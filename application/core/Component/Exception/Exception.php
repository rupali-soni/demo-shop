<?php
namespace Demoshop\Component\Exception;

/**
 * This class defines Exception handling
 */
class Exception extends Throwable {

    /**
     * Exception constructor.
     * @param $message
     */
    public function __construct($message){
        echo $message;
    }
}