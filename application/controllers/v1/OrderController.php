<?php


namespace Demoshop\controllers\v1;


use Demoshop\entity\Checkout;
use Demoshop\service\ApiOutput;
use Demoshop\service\Cart;
use Demoshop\service\Orders;

class OrderController extends BaseController {

    /**
     * @var Cart
     */
    private $oCartService;

    /**
     * @var Orders
     */
    private $oOrdersService;

    /**
     * OrderController constructor.
     * @param ApiOutput $oApiOutputService
     * @param AuthController $oAuthController
     * @param Cart $oCartService
     * @param Orders $oOrdersService
     */
    public function __construct(
        ApiOutput $oApiOutputService,
        AuthController $oAuthController,
        Cart    $oCartService,
        Orders $oOrdersService
    ) {
        parent::__construct( $oApiOutputService, $oAuthController );
        $this->oCartService = $oCartService;
        $this->oOrdersService = $oOrdersService;
    }

    /**
     * Call restFul APIs based on method type
     */
    public function index () {
        $this->callRestApi( $this );

    }

    /**
     * update checkout details here
     */
    public function processPost() {
        $cartEntity = $this->oCartService->getCartProducts( $this->iCustomerId );
        if ($cartEntity instanceof  \Demoshop\entity\Cart ) {
            $postData = $_POST;
            $postData['customerId'] = $this->iCustomerId;
            $checkoutEntity = $this->oOrdersService->getCheckoutObject( $postData, $cartEntity );
            if ( $checkoutEntity instanceof Checkout ) {
                $result = $this->oOrdersService->validateCheckoutObject( $checkoutEntity ) ;
                if( true === $result ) {
                    $orderResult = $this->oOrdersService->placeOrder( $checkoutEntity );
                    $result = $this->oApiOutputService->buildJsonOutput( $orderResult );
                    $this->oApiOutputService->sendJsonOutput( $result );
                } else {
                    $result = $this->oApiOutputService->buildJsonOutput( ['error' => $result ] );
                    $this->oApiOutputService->sendJsonOutput( $result );
                }
            }
        } else {
            $result = $this->oApiOutputService->buildJsonOutput( ['error' => 'no products found in shopping cart!'] );
            $this->oApiOutputService->sendJsonOutput( $result );
        }
        //to enhance this feature we can store all the payment methods in DB.

    }
}