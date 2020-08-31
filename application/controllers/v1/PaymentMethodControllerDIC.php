<?php


namespace Demoshop\controllers\v1;


trait PaymentMethodControllerDIC {
    /**
     * @var PaymentMethodController
     */
    private $oPaymentController;

    /**
     * @return PaymentMethodController
     */
    public function getV1PaymentMethodController () {
        if ( null === $this->oPaymentController ) {
            $this->oPaymentController = new PaymentMethodController(
                $this->getApiOutputService(),
                $this->getV1AuthController()
            );
        }
        return $this->oPaymentController;
    }

}