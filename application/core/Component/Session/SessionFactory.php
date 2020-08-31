<?php

namespace Demoshop\Component\Session;
/**
 * Class SessionFactory
 * @package Demoshop\Component\Session
 * Class will not be extendable anymore
 * class will return session object
 * Following singleton design pattern
 */
final class SessionFactory {
    /**
     * Method to get session object
     * Singleton design pattern
     * @return Session|null
     */
    public static function getSession() {
        static $sessionObj = null;
        if ($sessionObj === null) {
            $sessionObj = new Session();
        }
        return $sessionObj;
    }
}
