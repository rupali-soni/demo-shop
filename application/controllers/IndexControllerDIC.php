<?php


namespace Demoshop\controllers;


trait IndexControllerDIC {

    /**
     * @var IndexController
     */
    private $oIndexController;

    /**
     * @return IndexController
     */
    public function getIndexController () {
        if ( null === $this->oIndexController ) {
            $this->oIndexController = new IndexController();
        }
        return $this->oIndexController;
    }

}