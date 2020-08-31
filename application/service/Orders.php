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
        //@todo: we can also apply filters for post data here
        $checkoutEntity = new Checkout();
        $checkoutEntity->cart = $oCartEntity;
        $shippingAddressEntity = new Address();
        $shippingAddressEntity->companyName = trim( $postData['shippingCompanyName'] );
        $shippingAddressEntity->streetName = trim( $postData['shippingStreetName']);
        $shippingAddressEntity->houseNumber = intval( $postData['shippingHouseNumber'] );
        $shippingAddressEntity->zipCode = intval( $postData['shippingZipCode'] );
        $shippingAddressEntity->city = trim( $postData['shippingCity']);
        $shippingAddressEntity->state = trim( $postData['shippingState']);
        $shippingAddressEntity->country = trim( $postData['shippingCountry']);
        $shippingAddressEntity->mobileNumber = intval($postData['shippingMobile']);
        $checkoutEntity->shippingAddress = $shippingAddressEntity;
        $checkoutEntity->isSameAddress = intval( $postData['isSameBillingAddress'] );
        if ( 1 === $checkoutEntity->isSameAddress ) {
            $checkoutEntity->billingAddress = $shippingAddressEntity;
        } else {
            $billingAddressEntity = new Address();
            $billingAddressEntity->companyName = trim( $postData['billingCompanyName'] );
            $billingAddressEntity->streetName = trim( $postData['billingStreetName'] );
            $billingAddressEntity->houseNumber = intval( $postData['billingHouseNumber'] );
            $billingAddressEntity->zipCode = intval( $postData['billingZipCode']);
            $billingAddressEntity->city = trim( $postData['billingCity'] );
            $billingAddressEntity->state = trim( $postData['billingState'] );
            $billingAddressEntity->country = trim( $postData['billingCountry'] );
            $billingAddressEntity->mobileNumber = intval( $postData['billingMobile'] );

           $checkoutEntity->billingAddress = $billingAddressEntity;
        }
        $checkoutEntity->paymentType = trim( $postData['paymentType'] );
        $paymentInformation = new PaymentInformation();
        switch ( $checkoutEntity->paymentType ) {
            case 'Direct Debit':
                $paymentInformation->iBan = $postData['iBan'];
                $paymentInformation->BIC = $postData['BIC'];
                $paymentInformation->bankName = trim( $postData['bankName'] );
                break;
            case 'Credit Card':
                $paymentInformation->cardNumber = $postData['cardNumber'];
                $paymentInformation->cvc = $postData['cvc'];
                $paymentInformation->expiryDate = $postData['expiryDate'];
                break;
        }
        $checkoutEntity->paymentInformation = $paymentInformation;
        $checkoutEntity->customerId = $postData['customerId'];
        $checkoutEntity->customerEmailAddress = $postData['customerEmailAddress'];
        return $checkoutEntity;
    }

    /**
     * @param Checkout $oCheckout
     * @return array|bool
     */
    public function validateCheckoutObject ( Checkout $oCheckout ) {
        //@todo: implement more efficient validations.
        $errors = [];
        if ( true === empty( $oCheckout->shippingAddress->streetName ) ) {
            $errors[] = 'Street name for shipping address is mandatory.';
        }
        if ( true === empty( $oCheckout->shippingAddress->houseNumber ) ) {
            $errors[] = 'House number for shipping address is mandatory.';
        }
        if ( 0 === $oCheckout->shippingAddress->zipCode  ) {
            $errors[] = 'Zipcode for shipping address is mandatory.';
        }
        if ( true === empty( $oCheckout->shippingAddress->city ) ) {
            $errors[] = 'City name for shipping address is mandatory.';
        }
        if ( true === empty( $oCheckout->shippingAddress->state ) ) {
            $errors[] = 'State name for shipping address is mandatory.';
        }
        if ( true === empty( $oCheckout->shippingAddress->country ) ) {
            $errors[] = 'Country name for shipping address is mandatory.';
        }

        if ( 0 === $oCheckout->isSameAddress ) {
            if ( true === empty( $oCheckout->billingAddress->streetName ) ) {
                $errors[] = 'Street name for billing address is mandatory.';
            }
            if ( true === empty( $oCheckout->billingAddress->houseNumber ) ) {
                $errors[] = 'House number for billing address is mandatory.';
            }
            if ( 0 === $oCheckout->billingAddress->zipCode  ) {
                $errors[] = 'Zipcode for billing address is mandatory.';
            }
            if ( true === empty( $oCheckout->billingAddress->city ) ) {
                $errors[] = 'City name for billing address is mandatory.';
            }
            if ( true === empty( $oCheckout->billingAddress->state ) ) {
                $errors[] = 'State name for billing address is mandatory.';
            }
            if ( true === empty( $oCheckout->billingAddress->country ) ) {
                $errors[] = 'Country name for billing address is mandatory.';
            }
        }

        switch ( $oCheckout->paymentType ) {
            case 'Direct Debit':
                if ( true === empty( $oCheckout->paymentInformation->iBan ) ) {
                    $errors[] = 'IBAN is mandatory.';
                }
                if ( true === empty( $oCheckout->paymentInformation->BIC ) ) {
                    $errors[] = 'BIC is mandatory.';
                }
                if ( true === empty( $oCheckout->paymentInformation->bankName ) ) {
                    $errors[] = 'bankName is mandatory.';
                }
                break;
            case 'Credit Card':
                if ( true === empty( $oCheckout->paymentInformation->cardNumber ) ) {
                    $errors[] = 'Card number is mandatory.';
                }
                if ( true === empty( $oCheckout->paymentInformation->cvc ) ) {
                    $errors[] = 'CVC is mandatory.';
                }
                if ( true === empty( $oCheckout->paymentInformation->expiryDate ) ) {
                    $errors[] = 'Expiry Date is mandatory.';
                }
                break;
        }
        if ( true === empty( $oCheckout->customerEmailAddress ) ) {
            $errors[] = 'Customer email address is mandatory.';
        }

        If ( 0 < count ( $errors ) ) {
            return $errors;
        } else {
            return true;
        }
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
                    $id = $this->orderModel->insert($data);
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