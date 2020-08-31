<?php


namespace Demoshop\controllers\v1;


use Demoshop\service\ApiOutput;

class BaseController {

    /**
     * @var ApiOutput
     */
    protected $oApiOutputService;

    protected $iCustomerId;

    /**
     * BaseController constructor.
     * @param ApiOutput $oApiOutputService
     * @param AuthController $oAuthController
     */
    public function __construct(
        ApiOutput $oApiOutputService,
        AuthController $oAuthController
    ) {
        $this->oApiOutputService = $oApiOutputService;
        $credentials = $oAuthController->validateToken();
        if ( $credentials instanceof \stdClass ) {
            $this->iCustomerId = $credentials->cid;
        }
    }

    /**
     * @param $controllerObject
     */
    public function callRestApi( $controllerObject ) {
        $requestType = $_SERVER['REQUEST_METHOD'];
        switch ($requestType) {
            case 'POST':
                $controllerObject->processPost();
                break;
            case 'GET':
                $controllerObject->processGet();
                break;
            case 'PUT':
                $controllerObject->processPut();
                break;
            default:
                //request type that isn't being handled.
                break;
        }
    }

}