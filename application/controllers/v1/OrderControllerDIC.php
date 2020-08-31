<?php


namespace Demoshop\controllers\v1;


trait OrderControllerDIC {
    /**
     * @var OrderController
     */
    private $oOrderController;

    /**
     * @return OrderController
     */
    public function getV1OrderController () {
        if ( null === $this->oOrderController ) {
            $this->oOrderController = new OrderController(
                $this->getApiOutputService(),
                $this->getV1AuthController(),
                $this->getCartService(),
                $this->getOrdersService()
            );
        }
        return $this->oOrderController;
    }

}