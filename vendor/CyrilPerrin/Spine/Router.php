<?php

namespace CyrilPerrin\Spine;

use CyrilPerrin\Spine\Route\Regex;
use CyrilPerrin\Spine\Router\Loader;

/**
 * Router
 */
class Router
{
    /**
     * Get instance from globales
     * @return \CyrilPerrin\Spine\Router default instance
     */
    public static function getInstanceFromGlobals()
    {
        // Default URL base
        if (isset($_SERVER['REQUEST_URI'])) {
            $urlBase = substr(
                $_SERVER['SCRIPT_NAME'], 0,
                strrpos($_SERVER['REQUEST_URI'], '/')
            ).'/';
        } else {
            $urlBase = '';
        }
        
        // Build/Return default Router
        return new Router($urlBase);
    }
    
    /** @var $_urlBase string URL base */
    private $_urlBase = '';
    
    /** @var $_route array routes */
    private $_routes = array();
    
    /**
     * Constructor
     * @param $urlBase string URL base
     */
    public function __construct($urlBase='')
    {
        $this->_urlBase = $urlBase;
    }
    
    /**
     * Get routes
     * @return array routes
     */
    public function getRoutes()
    {
        return $this->_routes;
    }
    
    /**
     * Load routes
     * @param $loader \CyrilPerrin\Spine\Router\Loader loader
     */
    public function loadRoutes(Loader $loader)
    {
        foreach ($loader->getRoutes() as $route) {
            $this->_routes[] = $route;
        }
    }
    
    /**
     * Clear routes
     */
    public function clearRoutes()
    {
        $this->_routes = array();
    }
    
    /**
     * Add route
     * @param $route \CyrilPerrin\Spine\Route route
     */
    public function addRoute(Route $route)
    {
        $this->_routes[] = $route;
    }
    
    /**
     * Get URL base
     */
    public function getUrlBase()
    {
        return $this->_urlBase;
    }
    
    /**
     * Set URL base
     * @param $urlBase string URL base
     */
    public function setUrlBase($urlBase)
    {
        $this->_urlBase = $urlBase;
    }
    
    /**
     * Parse URL
     * @param $url string URL
     * @return \CyrilPerrin\Spine\Request request
     */
    public function parseUrl($url)
    {
        // Resize URL
        if (strpos($url, $this->_urlBase) === 0) {
            $url = substr($url, strlen($this->_urlBase));
        }
        
        // Parse URL
        foreach ($this->_routes as $route) {
            $request = $route->parseUrl($url);
            if ($request != null) {
                return $request;
            }
        }
        return null;
    }
    
    /**
     * Build URL
     * @param $controllerName string controller name
     * @param $actionName string action name
     * @param $parameters array parameters
     */
    public function buildUrl($controllerName,$actionName,$parameters=array())
    {
        foreach ($this->_routes as $route) {
            $url = $route->buildUrl($controllerName, $actionName, $parameters);
            if ($url !== null) {
                return $this->_urlBase.$url;
            }
        }
        return null;
    }
    
}