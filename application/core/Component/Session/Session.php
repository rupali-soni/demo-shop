<?php
namespace Demoshop\Component\Session;
/**
 * Class Session
 * @package Demoshop\Component\Session
 */
class Session implements SessionInterface {
    /**
     * @var session array
     */
    public $userdata;

    /**
     * Start session
     */
    public static function initSession(){
        session_start();
    }

    /**
     * Session constructor.
     * set session object in class variable
     */
    public function __construct() {
        $this->userdata = & $_SESSION;
    }

    /**
     * set value in session
     * @param $key
     * @param $value
     */
    public function set_userdata($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * get value from session
     * @param $key
     * @return null
     */
    public function get_userdata($key){
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];
        else
            return null;
    }

    /**
     * destroy session on logout
     */
    public static function destroySession(){
        session_destroy();
    }

    /**
     * get Unique session id
     * @return string
     */
    public static function getSessionId() {
        return session_id();
    }

    /**
     * unset variable in session
     * @param $key
     */
    public function unsetData($key) {
        if(isset($_SESSION[$key]))
            unset($_SESSION[$key]);
    }

}
