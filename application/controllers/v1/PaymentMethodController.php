<?php


namespace Demoshop\controllers\v1;


use Demoshop\service\ApiOutput;

class PaymentMethodController extends BaseController {

    const SHIPPING_METHODS = [
        1 => 'Direct Debit',
        2 => 'Invoice',
        3 => 'Credit Card'
    ];


    /**
     * PaymentMethodController constructor.
     * @param ApiOutput $oApiOutputService
     * @param AuthController $oAuthController
     */
    public function __construct(
        ApiOutput $oApiOutputService,
        AuthController $oAuthController
    ) {
        parent::__construct( $oApiOutputService, $oAuthController );
    }

    /**
     * Call restFul APIs based on method type
     */
    public function index () {
        $this->callRestApi( $this );

    }
    /**
     * function is to get all the payment methods
     */
    public function processGet() {
        //to enhance this feature we can store all the payment methods in DB.
        $result = $this->oApiOutputService->buildJsonOutput( self::SHIPPING_METHODS );
        $this->oApiOutputService->sendJsonOutput( $result );
    }

}