<?php
namespace Demoshop\Component\View;

/**
 * This class is for loading the view files.
 */
class View {
    /**
     * To store view file path
     *
     * @var ViewLoader
     */
    public $viewLoader;

    /**
     * set ViewLoader object in a variable
     *
     * @param ViewLoader $viewLoader
     */
    public function __construct($viewLoader){
        $this->viewLoader = $viewLoader;
    }

    /**
     * Load file contents and return result
     *
     * @param String $viewName
     * @param Array $variables
     */
    public function render($viewName, $variables = array(), $commonFiles = 1){
        $this->viewLoader->load($viewName, $variables);
    }
}