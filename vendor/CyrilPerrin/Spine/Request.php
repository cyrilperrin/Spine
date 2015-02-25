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
    
    /** @var $_type string type */
    private $_type;
    
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
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    $request->setParameter($key, $value);
                }
            }
            
            // Set POST parameters
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    $request->setParameter($key, $value);
                }
            }
            
            // Set type
            if (!empty($_SERVER['REQUEST_METHOD'])) {
                $request->setType($_SERVER['REQUEST_METHOD']);
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
     */
    public function __construct($controllerName,$actionName,$parameters=array(),
        $type='GET')
    {
        $this->_controllerName = $controllerName;
        $this->_actionName = $actionName;
        $this->_parameters = $parameters;
        $this->_type = $type;
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
     * Get type
     * @return string type
     */
    public function getType()
    {
        return $this->_type;
    }
    
    /**
     * Set type
     * @param $type string type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }
    
    /**
     * Check type
     * @param $type string type
     * @return string true if type match
     */
    public function is($type)
    {
        return $this->_type == $type;
    }
}