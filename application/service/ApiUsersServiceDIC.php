<?php

namespace Demoshop\service;


trait ApiUsersServiceDIC {

    /**
     * @var ApiUsers
     */
    private $oApiUserService;

    /**
     * @return ApiUsers
     */
    public function getApiUserService () {
        if ( null === $this->oApiUserService ) {
            $this->oApiUserService = new ApiUsers (
                $this->getApiUserModel()
            );
        }
        return $this->oApiUserService;
    }
}