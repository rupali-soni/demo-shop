<?php
namespace Demoshop\Component\View;
//use Demoshop\Component\Exception\Exception;
/**
 * This class is for loading the view files.
 */
class Viewloader{
    /**
     * To store view file path
     *
     * @var string
     */
    private $path;
    /**
     * To variables from controller
     *
     * @var Array
     */
    private $data;

    /**
     * set path of the file in a class variable
     *
     * @param $path
     */
    public function __construct($path){
        $this->path = $path;
    }

    /**
     * load file content else throw exception
     *
     * @param $viewName
     * @param $variables
     * @return null / Exception
     */
    public function load($viewName, $variables = array()){
        $this->data = $variables;
        $path = $this->path . $viewName . '.php';
        if( file_exists($path) ){
            include_once($path);
        } else
            throw new Exception("View does not exist: ".$path);
    }
}