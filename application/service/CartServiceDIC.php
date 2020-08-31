<?php


namespace Demoshop\service;


trait CartServiceDIC {
    /**
     * @var Cart
     */
    private $oCartService;

    /**
     * @return Cart
     */
    public function getCartService () {
        if ( null === $this->oCartService ) {
            $this->oCartService = new Cart (
                $this->getCartModel()
            );
        }
        return $this->oCartService;
    }
}