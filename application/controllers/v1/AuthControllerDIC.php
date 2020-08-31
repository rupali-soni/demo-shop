<?php


namespace Demoshop\controllers\v1;


trait AuthControllerDIC {

    /**
     * @var AuthController
     */
    private $oAuthController;

    /**
     * @return AuthController
     */
    public function getV1AuthController () {
        if ( null === $this->oAuthController ) {
            $this->oAuthController = new AuthController(
                $this->getApiUserService(),
                $this->getApiOutputService()
            );
        }
        return $this->oAuthController;
    }

}