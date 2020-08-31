<?php


namespace Demoshop\controllers\v1;


trait ShippingMethodControllerDIC {

    /**
     * @var ShippingMethodController
     */
    private $oShippingController;

    /**
     * @return ShippingMethodController
     */
    public function getV1ShippingMethodController () {
        if ( null === $this->oShippingController ) {
            $this->oShippingController = new ShippingMethodController(
                $this->getApiOutputService(),
                $this->getV1AuthController()
            );
        }
        return $this->oShippingController;
    }

}