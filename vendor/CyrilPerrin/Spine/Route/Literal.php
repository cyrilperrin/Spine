<?php

namespace CyrilPerrin\Spine\Route;

use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Route;

/**
 * Literal route
 */
class Literal extends Route
{
    /** @var $_url string URL */
    private $_url;
    
    /** @var $_controllerName string controller name */
    private $_controllerName;
    
    /** @var $_actionName string action name */
    private $_actionName;
    
    /** @var $_parameters array parameters */
    private $_parameters;
    
    /**
     * Constructor
     * @param $url string URL
     * @param $controllerName string controller name
     * @param $actionName string action name
     * @param $parameters array parameters
     */
    public function __construct($url,$controllerName,$actionName,
        $parameters=array())
    {
        // Save URL
        $this->_url = $url;
        
        // Save parameters
        $this->_controllerName = $controllerName;
        $this->_actionName = $actionName;
        $this->_parameters = $parameters;
    }
    
    /**
     * @see \CyrilPerrin\Spine\Route::parseUrl()
     */
    public function parseUrl($url)
    {
        // Matching URL ?
        if ($url != $this->_url) {
            return null;
        }
        
        // Build/Return request
        return new Request(
            $this->_controllerName,
            $this->_actionName,
            $this->_parameters
        );
    }
    
    /**
     * @see \CyrilPerrin\Spine\Route::buildUrl()
     */
    public function buildUrl($controllerName,$actionName,$parameters=array())
    {
        // Same parameters, controller name and action name ?
        if ($controllerName != $this->_controllerName) {
            return null;
        }
        if ($actionName != $this->_actionName) {
            return null;
        }
        if ($parameters != $this->_parameters) {
            return null;
        }
        
        // Return URL
        return $this->_url;
    }
}