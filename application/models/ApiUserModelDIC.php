<?php


namespace Demoshop\models;


trait ApiUserModelDIC {
    /**
     * @var ApiUsersModel
     */
    private $oApiUserModel;

    /**
     * @return ApiUsersModel
     */
    public function getApiUserModel() {
        if( null === $this->oApiUserModel ) {
            $this->oApiUserModel = new ApiUsersModel();
        }
        return $this->oApiUserModel;
    }

}