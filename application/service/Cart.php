<?php
namespace Demoshop\service;
use Demoshop\config\Config;
use Demoshop\entity\Product;
use Demoshop\models\CartModel;
/**
 * This class for implementing all the operations related to shopping cart
 */
class Cart
{
    /**
     * @var CartModel
     */
    private $cartModel;

    /**
     * Cart constructor.
     * @param CartModel $cartModel
     */
    public function __construct(
        CartModel $cartModel
    ) {
        $this->cartModel = $cartModel;
    }

    /**
     * get all the products available in cart
     * @param int $getImg
     * @return mixed
     */
    public function getCartProducts($customerId = 0) {
        $cartEntity = false;
        if($customerId) {
            $cartData = $this->cartModel->getAllProducts( [':customerId' => $customerId ] );
            if ( $cartData instanceof \stdClass ) {
                $cartObject = json_decode( $cartData->cart_data );
                if ( $cartObject instanceof \stdClass ) {
                    $cartEntity = new \Demoshop\entity\Cart();
                    $cartEntity->type = $cartObject->type;
                    $cartEntity->shoppingCartId = $cartObject->shoppingcartid;
                    foreach ( $cartObject->products as $product ) {
                        $productEntity = new Product();
                        $productEntity->productId = $product->productid;
                        $productEntity->title = $product->title;
                        $productEntity->price = $product->price;
                        $productEntity->amount = $product->amount;
                        $productEntity->image = $product->image;

                        $cartEntity->products[] = $productEntity;
                    }
                    $cartEntity->sum = $cartObject->sum;
                    $cartEntity->vatPercent = $cartObject->vatPercent;
                    $cartEntity->vatSum = $cartObject->vatSum;
                    $cartEntity->deliveryCosts = $cartObject->deliveryCosts;
                    $cartEntity->totalSum = $cartObject->totalSum;
                    $cartEntity->currency = $cartObject->currency;
                }
            }
        }
        return $cartEntity;
    }

    /**
     * get total amount for all the cart products.
     * @param int $formatted
     * @return int|string
     */
    public function getCartTotal($formatted = 0) {
        $data[":sessionId"] = $this->sessionId;
        $result = $this->cartModel->getProductTotal($data);
        $total = $result ? number_format($result->total, 2) : 0;
        if($formatted) {
            $config = Config::getConfig();
            return $total ? $config['currencySymbol']. $total: 0;
        }
            return $total;
    }
}