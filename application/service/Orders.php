<?php
namespace Demoshop\service;
use Demoshop\entity\Address;
use Demoshop\entity\Checkout;
use Demoshop\entity\PaymentInformation;
use Demoshop\models\OrderModel;
use Demoshop\entity\Order;
use Demoshop\Component\Session\SessionFactory;
use Demoshop\service\Cart;

/**
 * This class for implementing all the operations related to Orders
 */
class Orders {
    /**
     * @var OrderModel
     */
    private $orderModel;

    /**
     * Orders constructor.
     */
    public function __construct(
        OrderModel $oOrderModel
    ) {
        $this->orderModel = $oOrderModel;
    }

    /**
     * @param $postData
     * @param \Demoshop\entity\Cart $oCartEntity
     * @return Checkout
     */
    public function getCheckoutObject ( $postData, \Demoshop\entity\Cart $oCartEntity ) {
        $checkoutEntity = new Checkout();
        $checkoutEntity->cart = $oCartEntity;
        $shippingAddressEntity = new Address();
        $shippingAddressEntity->companyName = $postData['shippingAddress']['companyName'];
        $checkoutEntity->shippingAddress = $shippingAddressEntity;
        $checkoutEntity->isSameAddress = intval( $postData['isSameBillingAddress'] );
        if ( 1 === $checkoutEntity->isSameAddress ) {
            $checkoutEntity->billingAddress = $shippingAddressEntity;
        } else {
           $billingAddressEntity = new Address();
           $billingAddressEntity->companyName = $postData['billingAddress']['companyName'];

           $checkoutEntity->billingAddress = $billingAddressEntity;
        }
        $checkoutEntity->paymentType = $postData['paymentType'];
        $paymentInformation = new PaymentInformation();

        $checkoutEntity->paymentInformation = $paymentInformation;
        $checkoutEntity->customerId = $postData['customerId'];
        $checkoutEntity->customerEmailAddress = $postData['customerEmailAddress'];
        return $checkoutEntity;
    }

    /**
     * @param Checkout $oCheckout
     * @return bool
     */
    public function validateCheckoutObject ( Checkout $oCheckout ) {
        return true;
    }

    /**
     * Make transaction for placing the order
     * @param $data
     * @return bool|string
     */
    private function makeTransaction( $totalAmount ) {
        //we can integrate payment gateway here
        //On success from payment gateway, return transaction id
        $transactionId = md5('DemoShop-Payment' . $totalAmount . time());
        return $transactionId;
    }

    /**
     * Place order
     * Maintain transactions
     * @param $postData
     * @return bool
     */
    public function placeOrder( Checkout $checkoutEntity ) {
        try {
            $this->orderModel->startTransaction();
            if ( $checkoutEntity->paymentType != 'Invoice' ) {
                //make payment transaction
                $transactionId = $this->makeTransaction( $checkoutEntity->cart->totalSum );
            } else {
                //send bill to customer on his billing address
                $transactionId = 'Invoice';
            }

            //if true then
            //make entry in order table and into transaction table
            if( null != $transactionId ) {
                $bData = array(
                    ":userId" => $checkoutEntity->customerId
                );
                $data['tableName'] = 't_order';
                $data['fields'] = 'customer_id';
                $data['values'] = ':userId';
                $data['bindParam'] = $bData;
                $orderId = $this->orderModel->insert($data);

                //insert entry into transaction table
                $bData = array(
                    ":customer_id"          => $checkoutEntity->customerId,
                    ":order_id"             => $orderId,
                    ":transaction_token"    => $transactionId,
                    ":payment_type"         => $checkoutEntity->paymentType,
                    ":amount"               => $checkoutEntity->cart->totalSum
                );
                $data['tableName'] = 't_transaction';
                $data['fields'] = 'customer_id, order_id, transaction_token, payment_type, amount';
                $data['values'] = ':customer_id, :order_id, :transaction_token, :payment_type, :amount';
                $data['bindParam'] = $bData;
                $this->orderModel->insert($data);

                //insert each product into order_products table
                foreach ($checkoutEntity->cart->products as $product) {
                    $bData = array(
                        ":customer_id"          => $checkoutEntity->customerId,
                        ":order_id"             => $orderId,
                        ":product_id"           => $product->productId,
                        ":quantity"             => $product->amount,
                        ":price"                => $product->price
                    );
                    $data['tableName'] = 't_order_product';
                    $data['fields'] = 'order_id, customer_id, product_id, quantity, price';
                    $data['values'] = ':order_id, :customer_id, :product_id, :quantity, :price';
                    $data['bindParam'] = $bData;
                    $id = $this->_orderModel->insert($data);
                    //@todo: remove product from checkout table
                }
                $this->orderModel->commitTransaction();
                $oOrderEntity = new Order();
                $oOrderEntity->orderId = $orderId;
                $oOrderEntity->orderNumber = md5( $orderId );
                $oOrderEntity->customerEmail = $checkoutEntity->customerEmailAddress;
                $oOrderEntity->customerName = 'Tim Test';
                $oOrderEntity->newsletterAbo = ( 1 === $checkoutEntity->newsletterAbo ) ? 'true' : 'false';
                $deliveryAddress = $checkoutEntity->shippingAddress->streetName . ' ' . $checkoutEntity->shippingAddress->houseNumber . ', ' . $checkoutEntity->shippingAddress->zipCode . ', ' . $checkoutEntity->shippingAddress->city;
                $oOrderEntity->deliveryAddress = $deliveryAddress;
                return $oOrderEntity;
            } else {
                return [
                    'error' => 'transactino failed'
                ];
            }


        } catch(\Exception $e) {
            $this->orderModel->rollbackTransaction();
            return false;
        }
    }
}