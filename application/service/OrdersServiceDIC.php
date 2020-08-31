<?php


namespace Demoshop\service;


trait OrdersServiceDIC {
    /**
     * @var Orders
     */
    private $oOrdersService;

    /**
     * @return Orders
     */
    public function getOrdersService () {
        if ( null === $this->oOrdersService ) {
            $this->oOrdersService = new Orders (
                $this->getOrderModel()
            );
        }
        return $this->oOrdersService;
    }

}