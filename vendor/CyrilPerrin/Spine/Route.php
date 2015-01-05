<?php

namespace CyrilPerrin\Spine;

use CyrilPerrin\Spine\Route\Regex;

/**
 * Route
 */
abstract class Route
{
    /**
     * Get default instance
     * @return \CyrilPerrin\Spine\Route
     */
    public static function getDefaultInstance()
    {
        return new Regex(
            array(
                '/:controller/:action:parameters',
                array(
                    'parameters' => array(
                        '/:name/:value'
                    )
                )
            ),
            array(
                '(/:controller(/:action(:parameters)?)?)?/?',
                array(
                    'controller' => '[a-zA-Z][a-zA-Z0-9\._-]*',
                    'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    'parameters' => array(
                        '/:name/:value', array(
                            'name' => '[a-zA-Z][a-zA-Z0-9]*',
                            'value' => '[^\/]*'
                        )
                    )
                )
            ),
            'Index', 'index'
        );
    }
    
    /**
     * Parse URL
     * @param $url string URL
     * @return \CyrilPerrin\Spine\Request request
     */
    abstract public function parseUrl($url);
    
    /**
     * Build URL
     * @param $controllerName string controller name
     * @param $actionName string action name
     * @param $parameters array parameters
     * @return string URL
     */
    abstract public function buildUrl($controllerName,$actionName,
        $parameters=array());
}