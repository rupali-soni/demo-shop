<?php


namespace Demoshop\controllers;


use Demoshop\controllers\v1\AuthControllerDIC;
use Demoshop\controllers\v1\CheckoutControllerDIC;
use Demoshop\controllers\v1\PaymentMethodControllerDIC;
use Demoshop\controllers\v1\ShippingMethodControllerDIC;
use Demoshop\models\ApiUserModelDIC;
use Demoshop\models\CartModelDIC;
use Demoshop\models\OrderModelDIC;
use Demoshop\service\ApiOutputServiceDIC;
use Demoshop\service\ApiUsersServiceDIC;
use Demoshop\service\CartServiceDIC;
use Demoshop\service\OrdersServiceDIC;

class DependencyInjectionContainer {

    static private $oInstance = null;

    static public function getInstance () {
        if ( null === self::$oInstance ) {
            self::$oInstance = new self();
        }

        return self::$oInstance;
    }

    use AuthControllerDIC,
        IndexControllerDIC,
        ShippingMethodControllerDIC,
        PaymentMethodControllerDIC,
        CheckoutControllerDIC,
        CartModelDIC,
        OrderModelDIC,
        ApiUserModelDIC,
        ApiUsersServiceDIC,
        ApiOutputServiceDIC,
        CartServiceDIC,
        OrdersServiceDIC;

}