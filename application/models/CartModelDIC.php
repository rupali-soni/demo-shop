<?php


namespace Demoshop\models;


trait CartModelDIC {
    /**
     * @var CartModel
     */
    private $oCartModel;

    /**
     * @return CartModel
     */
    public function getCartModel() {
        if( null === $this->oCartModel ) {
            $this->oCartModel = new CartModel();
        }
        return $this->oCartModel;
    }

}