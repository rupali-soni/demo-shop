<?php
namespace Demoshop\controllers;
use Demoshop\Component\View as ViewComponent;
use Demoshop\config\Config;
use Demoshop\Component\Session\SessionFactory;
/**
 * This class is core class for all the controller classes
 */
class BaseController{
    /**
     * BaseController constructor.
     * setting config and session objects here
     */
    public function __construct(){
        //Define config object
        $this->config = Config::getConfig();
        $this->session = SessionFactory::getSession();
        $this->userName = '';
        if(null !== $this->session->get_userdata('user')) {
            $user = $this->session->get_userdata('user');
            $this->userName = $user->firstName . ' ' . $user->lastName;
        }

    }

    /**
     * This function created object of view loader and they can be used to render view files.
     */
    public function loadViews() {
        //Define View object
        $this->view = new ViewComponent\View(
            new ViewComponent\Viewloader(APP_PATH.'/views/')
        );
    }
}