<?php

namespace CyrilPerrin\Spine\View;

use CyrilPerrin\Spine\View;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Interruption\Error;

/**
 * Action view
 */
class Action extends View
{
    /** @var $_controllerName string controller name */
    private $_controllerName;
    
    /** @var $_actionName string action name */
    private $_actionName;
    
    /** @var $_parameters array parameters */
    private $_parameters = array();
    
    /**
     * Constructor
     * @param $application \CyrilPerrin\Spine\Application application
     * @param $request \CyrilPerrin\Spine\Request request
     * @param $controllerName string controller name
     */
    public function __construct(Application $application,Request $request,
        $controllerName)
    {
        parent::__construct($application, $request);
        $this->_controllerName = $controllerName;
    }
    
    /**
     * Set action name
     * @param $actionName string action name
     */
    public function setActionName($actionName)
    {
        $this->_actionName = $actionName;
    }
    
    /**
     * @see \CyrilPerrin\Spine\View::__get()
     */
    public function __get($name)
    {
        if (!isset($this->_parameters[$name])) {
            return null;
        }
        return $this->_parameters[$name];
    }
    
    /**
     * @see \CyrilPerrin\Spine\View::__set()
     */
    public function __set($name,$value)
    {
        $this->_parameters[$name] = $value;
    }

    /**
     * @see \CyrilPerrin\Spine\View::render()
     */
    public function render()
    {
        // Get view path
        $viewPath = $this->_application->getDirectory().'/Views/Actions/'.
                    $this->_controllerName.'/'.$this->_actionName.'.phtml';
        
        // Check if view exists
        if (!file_exists($viewPath)) {
            throw new Error($this->_application, null, 500);
        }
        
        // Include view
        include($viewPath);
    }
}