<?php
//Main entry point of the application
require_once __DIR__ . '/vendor/autoload.php';

define('BASEPATH', __DIR__);
define('APP_PATH', BASEPATH . '/application');
if(!$_ENV) {
    ini_set('error_reporting', 0);
    ini_set('display_errors', false);
}
//including bootstrap file
require(APP_PATH . '/bootstrap.php');
try {
    //calling router to dispatch request
    $router->dispatch();
} catch (Exception $e) {
    echo "404 page not found";
}


