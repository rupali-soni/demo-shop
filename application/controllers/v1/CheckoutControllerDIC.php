<?php


namespace Demoshop\controllers\v1;


trait CheckoutControllerDIC {
    /**
     * @var CheckoutController
     */
    private $oCheckoutController;

    /**
     * @return CheckoutController
     */
    public function getV1CheckoutController () {
        if ( null === $this->oCheckoutController ) {
            $this->oCheckoutController = new CheckoutController(
                $this->getApiOutputService(),
                $this->getV1AuthController(),
                $this->getCartService(),
                $this->getOrdersService()
            );
        }
        return $this->oCheckoutController;
    }

}