<?php
namespace Demoshop\Component\Session;
/**
 * Interface SessionInterface
 * @package Demoshop\Component\Session
 * Interface to define various session types (e.g. cookie session, database session)
 */
interface SessionInterface {
    /**
     * Instantiate session
     * @return mixed
     */
    public static function initSession();

    /**
     * destroy session
     */
    public static function destroySession();

    /**
     * get unique session Id
     * @return string
     */
    public static function getSessionId();
}
