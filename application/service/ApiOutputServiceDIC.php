<?php


namespace Demoshop\service;


trait ApiOutputServiceDIC {

    /**
     * @var ApiOutput
     */
    private $oApiOutputService;

    /**
     * @return ApiOutput
     */
    public function getApiOutputService () {
        if ( null === $this->oApiOutputService ) {
            $this->oApiOutputService = new ApiOutput();
        }
        return $this->oApiOutputService;
    }
}