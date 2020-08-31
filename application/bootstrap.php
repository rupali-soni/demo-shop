<?php
use Demoshop\Component\Router\Router;
use Demoshop\Component\Session\SessionFactory;

$session = SessionFactory::getSession();
$session::initSession();
$router = new Router();
//Add all the routes here
//$router->add('products','ProductController#productlist');

//$router->add('/about-us',function() {
//    $view->display('about.php');
//});