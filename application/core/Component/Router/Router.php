<?php
namespace Demoshop\Component\Router;
use Demoshop\config\Config;
use Demoshop\controllers\DependencyInjectionContainer;

/**
 * This class defines all the features related to URL routing.
 */
class Router{

    const API_VERSIONS = [ 'v1' ];

    /**
     * To store all the routes in an array
     *
     * @var $routes Array
     */
    private $routes = [];

    /**
     *
     * @var $notFound
     */
    private $notFound;

    /**
     *
     * Display 404 not found message
     */
    public function __construct(){
        $this->notFound = function($url){
            echo "404 - $url not found!";
        };
    }

    /**
     * Add new route in an array
     *
     * @param $add
     * @param $action
     */
    public function add($url, $action){
        $this->routes[$url] = $action;
    }

    /**
     * Set not found action
     *
     * @param $action
     */
    public function setNotFound($action){
        $this->notFound = $action;
    }

    /**
     *
     * Call respective controller and action as per the route
     * @return function
     */
    public function dispatch() {
        $oDIC = DependencyInjectionContainer::getInstance();
        $requestURL = $_SERVER['REQUEST_URI'];
        $config = Config::getConfig();
        if(isset($config['baseUrl']))
            $baseUrl = $config['baseUrl'];
        else
            $baseUrl = '/';
        $requestURL = str_replace($baseUrl, '', $requestURL);

        foreach ($this->routes as $url => $action) {
            if( $url == $requestURL ){
                if(is_callable($action))
                    return $action();

                $actionArr = explode('#', $action);
                $controller = $oDIC->{'get'.ucfirst($actionArr[0]).'Controller'}();
                $method = $actionArr[1];

                return (new $controller)->$method();
            }
        }

        $requestURL = trim($requestURL, '/');
        if(!$requestURL) {
            $action = 'index';
            $controller = $oDIC->getIndexController();
        } else {
            $urlArr = explode('/', $requestURL);
            $countUrlArr = sizeof( $urlArr );
            $APIPrefix = '';
            if ( true === in_array( strtolower( $urlArr[0] ), self::API_VERSIONS ) ) {
                $APIPrefix = strtoupper( $urlArr[0] );
                array_shift( $urlArr );
                $countUrlArr = sizeof( $urlArr );
            }
            if( $countUrlArr == 1 ) {
                $action = 'index';
                $controller = $oDIC->{'get'.$APIPrefix.ucfirst($urlArr[0]).'Controller'}();
            } else {
                if(strpos($urlArr[1], '?') != false) {
                    $actionArr = explode("?", $urlArr[1]);
                    $urlArr[1] = $actionArr[0];
                }
                $action = $urlArr[1];

                $controller = $oDIC->{'get'.$APIPrefix.ucfirst($urlArr[0]).'Controller'}();
            }

        }
        try {
            return ($controller)->$action();
        } catch (\Exception $e) {
           // echo $e;
            //die("500 Error");
            call_user_func_array($this->notFound,[$_SERVER['REQUEST_URI']]);
        }
    }
}