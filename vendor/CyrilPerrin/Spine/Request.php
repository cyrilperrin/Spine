<?php

namespace CyrilPerrin\Spine;

use CyrilPerrin\Spine\Route;
use CyrilPerrin\Spine\Router;

/**
 * Request
 */
class Request
{
    /** @var $_controllerName string controller name */
    private $_controllerName;
    
    /** @var $_actionName string action name */
    private $_actionName;
    
    /** @var $_parameters array parameters */
    private $_parameters;
    
    /** @var $_getParameters array GET parameters */
    private $_getParameters;
    
    /** @var $_postParameters array POST parameters */
    private $_postParameters;
    
    /**
     * Get instance from globals
     * @param \CyrilPerrin\Spine\Router router
     * @return \CyrilPerrin\Spine\Request request
     */
    public static function getInstanceFromGlobals(Router $router)
    {
        // Get request
        $request = $router->parseUrl($_SERVER['REQUEST_URI']);
        
        // Check if request is not null
        if ($request != null) {
            // Set GET parameters
            if (is_array($_GET)) {
                $request->setGetParameters($_GET);
            }
            
            // Set POST parameters
            if (is_array($_POST)) {
                $request->setPostParameters($_POST);
            }
        }
        
        // Return request
        return $request;
    }
    
    /**
     * Constructor
     * @param $controllerName string controller name
     * @param $actionName string action name 
     * @param $parameters array parameters
     * @param $getParameters array GET parameters
     * @param $postParameters array POST parameters
     */
    public function __construct($controllerName,$actionName,$parameters=array(),
        $getParameters=array(),$postParameters=array())
    {
        $this->_controllerName = $controllerName;
        $this->_actionName = $actionName;
        $this->_parameters = $parameters;
        $this->_getParameters = $getParameters;
        $this->_postParameters = $postParameters;
    }
    
    /**
     * Get controller name
     * @return string controller name
     */
    public function getControllerName()
    {
        return $this->_controllerName;
    }
    
    /**
     * Set controller name
     * @param $controllerName string controller name
     */
    public function setControllerName($controllerName)
    {
        $this->_controllerName = $controllerName;
    }
    
    /**
     * Get action name
     * @return string action name
     */
    public function getActionName()
    {
        return $this->_actionName;
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
     * Get parameters
     * @return array parameters
     */
    public function getParameters()
    {
        return $this->_parameters;
    }
    
    /**
     * Set new parameters
     * @param $parameters array new parameters
     */
    public function setParameters($parameters)
    {
        $this->_parameters = $parameters;
    }
    
    /**
     * Get parameter value
     * @param $name string parameter name
     * @param $default string returned value if parameter is not set
     * @return string parameter value
     */
    public function getParameter($name,$default=null)
    {
        if (isset($this->_parameters[$name])) {
            return $this->_parameters[$name];
        } else {
            return $default;
        }
    }
    
    /**
     * Set parameter
     * @param $name string parameter name
     * @param $value string parameter value
     */
    public function setParameter($name,$value)
    {
        $this->_parameters[$name] = $value;
    }
    
    /**
     * Get GET parameters
     * @return array GET parameters
     */
    public function getGetParameters()
    {
        return $this->_getParameters;
    }
    
    /**
     * Set new GET parameters
     * @param array $parameters new GET parameters
     */
    public function setGetParameters($parameters)
    {
        $this->_getParameters = $parameters;
    }
    
    /**
     * Get GET parameter value
     * @param $name string GET parameter name
     * @param $default string returned value if GET parameter is not set
     * @return string GET parameter value
     */
    public function getGetParameter($name,$default=null)
    {
        if (isset($this->_getParameters[$name])) {
            return $this->_getParameters[$name];
        } else {
            return $default;
        }
    }
    
    /**
     * Set GET parameter
     * @param $name string GET parameter name
     * @param $value string GET parameter value
     */
    public function setGetParameter($name,$value)
    {
        $this->_getParameters[$name] = $value;
    }
    
    /**
     * get POST parameters
     * @return array POST parameters
     */
    public function getPostParameters()
    {
        return $this->_postParameters;
    }
    
    /**
     * Set new POST parameters
     * @param array $parameters new POST parameters
     */
    public function setPostParameters($parameters)
    {
        $this->_postParameters = $parameters;
    }
    
    /**
     * Get POST parameter value
     * @param $name string POST parameter name
     * @param $default string returned value if POST parameter is not set
     * @return string POST parameter value
     */
    public function getPostParameter($name,$default=null)
    {
        if (isset($this->_postParameters[$name])) {
            return $this->_postParameters[$name];
        } else {
            return $default;
        }
    }
    
    /**
     * Set POST parameter
     * @param $name string POST parameter name
     * @param $value string POST parameter value
     */
    public function setPostParameter($name,$value)
    {
        $this->_postParameters[$name] = $value;
    }
}