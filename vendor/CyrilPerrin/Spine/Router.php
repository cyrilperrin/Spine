<?php

namespace CyrilPerrin\Spine;

use CyrilPerrin\Spine\Route\Regex;

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
            $urlBase = '';
            for ($i=0,$j=1;isset($_SERVER['REQUEST_URI'][$j]);$i++,$j++) {
                if ($_SERVER['REQUEST_URI'][$j] ==
                    $_SERVER['SCRIPT_NAME'][$j]) {
                    $urlBase .= $_SERVER['REQUEST_URI'][$i];
                } else {
                    break;
                }
            }
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
     * @return string URL base
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
        if ($this->_urlBase !== '' && strpos($url, $this->_urlBase) === 0) {
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