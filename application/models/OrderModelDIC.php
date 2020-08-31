<?php


namespace Demoshop\models;


trait OrderModelDIC {
    /**
     * @var OrderModel
     */
    private $oOrderModel;

    /**
     * @return OrderModel
     */
    public function getOrderModel() {
        if( null === $this->oOrderModel ) {
            $this->oOrderModel = new OrderModel();
        }
        return $this->oOrderModel;
    }

}