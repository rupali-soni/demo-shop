<?php


namespace Demoshop\controllers\v1;

use Demoshop\entity\ApiUser;
use Demoshop\service\ApiOutput;
use Demoshop\service\ApiUsers;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class AuthController {

    const JWT_SECRET   = '89yIAEhUWHYGNRBUh75xdN5Gza60hy0c'; //secret key for JWT validation
    const JWT_ALG      = 'HS256';
    const JWT_DURATION = 60 * 60;
    /**
     * @var ApiUsers
     */
    private $oApiUserService;

    /**
     * @var ApiOutput
     */
    private $oApiOutputService;

    /**
     * AuthController constructor.
     * @param ApiUsers $oApiUserService
     * @param ApiOutput $oApiOutputService
     */
    public function __construct(
        ApiUsers $oApiUserService,
        ApiOutput $oApiOutputService
    ) {
        $this->oApiUserService = $oApiUserService;
        $this->oApiOutputService = $oApiOutputService;
    }

    /**
     * Validate ApiUser and generate JWT token
     */
    public function gettoken () {
        if( isset( $_POST['username'] ) && $_POST['password'] ) {
            //filter inputs
            $username = strip_tags(trim($_POST['username']));
            $password = md5(strip_tags(trim($_POST['password'])));
            $user = $this->oApiUserService->authenticateUser( $username, $password );

            if( false !== $user && $user instanceof ApiUser ) {
                //generate JWT token
                $aPayLoad = [
                    'iss' => 'V1', //issuer
                    'alg' => self::JWT_ALG,
                    'sub' => $user->userId, //user identifier
                    'cid' => 1,
                    'iat' => time (), //created at
                    'exp' => time () + self::JWT_DURATION, //valid until
                ];

                $token = JWT::encode ( $aPayLoad, self::JWT_SECRET );
                $result = [
                    'token' => $token
                ];
                $result = $this->oApiOutputService->buildJsonOutput( $result );
                $this->oApiOutputService->sendJsonOutput( $result );
            } else {
                $result = [
                    'error' => 'Invalid Username or Password',
                    'token' => null
                ];
                $result = $this->oApiOutputService->buildJsonOutput( $result );
                $this->oApiOutputService->sendJsonOutput( $result, 403 );
            }

        } else {
            $result = $this->oApiOutputService->buildJsonOutput( ['error' =>'Invalid Request', 'token' => null ] );
            $this->oApiOutputService->sendJsonOutput( $result, 403 );
        }
    }

    /**
     * @return bool
     */
    public function validateToken () {
        if ( false === empty( $_SERVER['HTTP_AUTHORIZATION'] ) || NULL !== $_SERVER['HTTP_AUTHORIZATION'] ) {
            $sToken = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);

            try {
                $credentials = JWT::decode($sToken, self::JWT_SECRET, [self::JWT_ALG]);
                return $credentials;
            } catch (ExpiredException $oException) {
                $result = $this->oApiOutputService->buildJsonOutput(['error' => 'Token Expired']);
                $this->oApiOutputService->sendJsonOutput($result, 403);
            } catch (\Exception $oException) {
                $result = $this->oApiOutputService->buildJsonOutput(['error' => 'Invalid Token']);
                $this->oApiOutputService->sendJsonOutput($result, 403);
            }
        } else {
            $result = $this->oApiOutputService->buildJsonOutput(['error' => 'Invalid Request']);
            $this->oApiOutputService->sendJsonOutput($result, 403);
        }
    }

}