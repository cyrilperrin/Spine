<?php

namespace CyrilPerrin\Spine\Route;

use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Route;

/**
 * Scan route
 */
class Scan extends Route
{
    /** @var $_pattern string pattern */
    private $_pattern;
    
    /** @var $_controllerName string controller name */
    private $_controllerName;
    
    /** @var $_imposedControllerName imposed controller name ? */
    private $_imposedControllerName;

    /** @var $_actionName string action name */
    private $_actionName;
    
    /** @var $_imposedActionName imposed action name ? */
    private $_imposedActionName;
    
    /** @var $_parameters array parameters */
    private $_parameters;
    
    /** @var $_order array parameters order */
    private $_order;
    
    /**
     * Constructor
     * @param $pattern string pattern
     * @param $controllerName string controller name
     * @param $actionName string action name
     * @param $parameters array parameters
     * @param $constraints array constraints on parameters
     */
    public function __construct($pattern,$controllerName=null,$actionName=null,
        $parameters=array(),$constraints=array())
    {
        // Save pattern and parameters
        $this->_pattern = $pattern;
        $this->_controllerName = $controllerName;
        $this->_actionName = $actionName;
        $this->_parameters = $parameters;
        
        // Imposed controller and action name ?
        if (strpos($pattern, ':controller') === false) {
            $this->_imposedControllerName = true;
        } else {
            $this->_imposedControllerName = false;
        }
        if (strpos($pattern, ':action') === false) {
            $this->_imposedActionName = true;
        } else {
            $this->_imposedActionName = false;
        }
        
        // Build pattern
        $this->_order = array();
        preg_match_all('/:([a-zA-Z][a-zA-Z0-9]*)/', $this->_pattern, $matches);
        foreach ($matches[1] as $parameterOrder => $parameterName) {
            // Save parameter order
            $this->_order[$parameterOrder] = $parameterName;
        
            // Get parameter constraint
            $constraint = $constraints[$parameterName];
        
            // Replace parameter name by its constraint
            $this->_pattern = str_replace(
                $matches[0][$parameterOrder], $constraint, $this->_pattern
            );
        }
    }
    
    /**
     * @see \CyrilPerrin\Spine\Route::parseUrl()
     */
    public function parseUrl($url)
    {
        // Scan URL
        $parametersValues = sscanf($url, $this->_pattern);
        
        // Matching URL ?
        if ($parametersValues[0] === null) {
            return null;
        }
        
        // Get parameters, controller name and action name
        $controllerName = $this->_controllerName;
        $actionName = $this->_actionName;
        $parameters = $this->_parameters;
        foreach ($parametersValues as $parameterOrder => $parameterValue) {
            // Get parameter name
            $parameterName = $this->_order[$parameterOrder];
            
            // Check if parameter value is null
            if ($parameterValue === null) {
                return null;
            }
            
            // Save parameter value, controller name or action name
            switch ($parameterName) {
                case 'controller':
                    $controllerName = implode(
                        '/', array_map('ucfirst', explode('-', $parameterValue))
                    );
                    break;
                case 'action':
                    $actionName = $parameterValue;
                    break;
                default:
                    $parameters[$parameterName] = $parameterValue;
            }
        }
        
        // Build/Return request
        return new Request($controllerName, $actionName, $parameters);
    }
    
    /**
     * @see \CyrilPerrin\Spine\Route::buildUrl()
     */
    public function buildUrl($controllerName,$actionName,$parameters=array())
    {
        // Same controller name ?
        if ($this->_imposedControllerName && isset($this->_controllerName)) {
            if ($this->_controllerName != $controllerName) {
                return null;
            }
        }
        
        // Change controller's name case and replace "/" character
        $controllerName = implode(
            '-', array_map('lcfirst', explode('/', $controllerName))
        );
        
        // Same action name ?
        if ($this->_imposedActionName && isset($this->_actionName)) {
            if ($this->_actionName != $actionName) {
                return null;
            }
        }
        
        // Merge route parameters and given parameters
        $parameters = array_merge($this->_parameters, $parameters);
        
        // Build/Return URL
        $arguments = array($this->_pattern);
        foreach ($this->_order as $parameterOrder => $parameterName) {
            switch ($parameterName) {
                case 'controller':
                    $arguments[] = $controllerName;
                    break;
                case 'action':
                    $arguments[] = $actionName;
                    break;
                default:
                    if (!array_key_exists($parameterName, $parameters)) {
                        return null;
                    }
                    $arguments[] = $parameters[$parameterName];
            }
        }
        return call_user_func_array('sprintf', $arguments);
    }
}