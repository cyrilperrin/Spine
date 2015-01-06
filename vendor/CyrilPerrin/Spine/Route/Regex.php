<?php

namespace CyrilPerrin\Spine\Route;

use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Route;

/**
 * Regex route
 */
class Regex extends Route
{
    /** @var $_buildPattern string build pattern */
    private $_buildPattern;
    
    /** @var $_parsePattern string parse pattern */
    private $_parsePattern;
    
    /** @var $_controllerName string controller name */
    private $_controllerName;

    /** @var $_actionName string action name */
    private $_actionName;
    
    /** @var $_parameters array parameters */
    private $_parameters;
    
    /**
     * Constructor
     * @param $buildPattern array build pattern
     * @param $parsePattern array parse pattern
     * @param $controllerName string controller name
     * @param $actionName string action name
     * @param $parameter array parameters
     */
    public function __construct($buildPattern,$parsePattern,
        $controllerName=null,$actionName=null,$parameters=array())
    {
        // Save patterns and parameters
        $this->_buildPattern = $buildPattern;
        $this->_parsePattern = $parsePattern;
        $this->_controllerName = $controllerName;
        $this->_actionName = $actionName;
        $this->_parameters = $parameters;
    }
    
    /**
     * @see \CyrilPerrin\Spine\Route::parseUrl()
     */
    public function parseUrl($url)
    {
        // Initialize parameters
        $parameters = $this->_parameters;
        
        // Extract parameters from URL
        $match = $this->_extractParametersFromUrl(
            $url, $this->_parsePattern, $parameters
        );
        
        // Matching URL ?
        if (!$match) {
            return null;
        }
        if (empty($parameters['controller']) && empty($this->_controllerName)) {
            return null;
        }
        if (empty($parameters['action']) && empty($this->_actionName)) {
            return null;
        }

        // Merge given parameters and extracted parameters
        if (isset($parameters['controller'])) {
            $controllerName = implode(
                '/', array_map(
                    'ucfirst', explode(
                        '-', $parameters['controller']
                    )
                )
            );
            unset($parameters['controller']);
        } else {
            $controllerName = $this->_controllerName;
        }
        if (isset($parameters['action'])) {
            $actionName = $parameters['action'];
            unset($parameters['action']);
        } else {
            $actionName = $this->_actionName;
        }
        if (isset($parameters['parameters'])) {
            foreach ($parameters['parameters'] as $parameter) {
                $parameters[$parameter['name']] = $parameter['value']; 
            }
            unset($parameters['parameters']);
        }
        
        // Construct/Return request
        return new Request($controllerName, $actionName, $parameters);
    }
    
    /**
     * Extract parameters from an URL
     * @param $url string URL
     * @param $pattern string parse pattern
     * @return boolean matching URL ?
     */
    private function _extractParametersFromUrl($url,$pattern,&$parameters)
    {
        // Build regular expression
        $regexp = $this->_buildRegexp($pattern);
        
        // Parse URL
        if (!preg_match('|^'.$regexp.'$|', $url, $matches)) {
           return false;
        }
        
        // Extract parameters
        foreach ($pattern[1] as $name => $subPattern) {
            // Check if there is a match
            if (!empty($matches[$name])) {
                // Check if it is a complex sub-pattern
                if (is_array($subPattern)) {
                    // Add sub-parameters array
                    $parameters[$name] = array();
                    
                    // Extract sub-parameters
                    $this->_extractSubParametersFromUrl(
                        $matches[$name], $subPattern, $parameters[$name]
                    );
                } else {
                    // Get parameter value
                    $parameters[$name] = urldecode($matches[$name]);
                }
            }
        }
        
        // Return true
        return true;
    }
    
    /**
     * Extract sub-parameters from an URL
     * @param $url string URL
     * @param $pattern string parse pattern
     */
    private function _extractSubParametersFromUrl($url,$pattern,&$parameters)
    {

        // Build regular expression
        $regexp = $this->_buildRegexp($pattern);
        
        // Parse URL
        $nbMatches = preg_match_all('|'.$regexp.'|', $url, $matches);
        
        // Matching URL ?
        if ($nbMatches) {
            // Extract parameters
            foreach ($pattern[1] as $name => $subPattern) {
                // Check if there is a match
                if (!empty($matches[$name])) {
                    foreach ($matches[$name] as $i => $value) {
                        // Check if it is a complex sub-pattern
                        if (is_array($subPattern)) {
                            // Add sub-parameters array
                            $parameters[$name] = array();
                        
                            // Extract sub-parameters
                            $this->_extractSubParametersFromUrl(
                                $value, $subPattern, $parameters[$name]
                            );
                        } else {
                            // Get parameter value
                            $parameters[$i][$name] = urlencode($value);
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Build regular expression
     * @param $pattern array parse pattern
     * @param $capture bool capturing sub-patterns ?
     * @return string regular expression
     */
    private function _buildRegexp($pattern,$capture=true)
    {
        // Get regular expression
        $regexp = $pattern[0];
    
        // Put sub-patterns into regular expression
        foreach ($pattern[1] as $name => $subPattern) {
            // Check if it is a complex sub-pattern
            if (is_array($subPattern)) {
                $subRegex = $this->_buildRegexp($subPattern, false);
                $subPattern = '(?:'.$subRegex.')*';
            }
    
            // Capturing sub-pattern
            if ($capture) {
                $subPattern = '(?P<'.$name.'>'.$subPattern.')';
            }
    
            // Put sub-pattern into regular expression
            $regexp = str_replace(':'.$name, $subPattern, $regexp);
        }
    
        // Return regular expression
        return $regexp;
    }
    
    /**
     * @see \CyrilPerrin\Spine\Route::buildUrl()
     */
    public function buildUrl($controllerName,$actionName,$parameters=array())
    {        
        // Same controller name ?
        if (isset($this->_controllerName)) {
            if ($this->_controllerName != $controllerName) {
                return null;
            }
        }
        
        // Change controller's name case and replace "/" character
        $controllerName = implode(
            '-', array_map('lcfirst', explode('/', $controllerName))
        );
        
        // Same action name ?
        if (isset($this->_actionName)) {
            if ($this->_actionName != $actionName) {
                return null;
            }
        }
        
        // Merge route parameters and given parameters
        $parameters = array_merge($this->_parameters, $parameters);
        array_walk(
            $parameters,
            function(&$value, $name) {
                $value = array('name' => $name, 'value' => $value);
            }
        );
        
        // Build/Return URL
        return $this->_insertParametersToUrl(
            $this->_buildPattern, array(
                'controller' => $controllerName,
                'action' => $actionName,
                'parameters' => $parameters
            )
        );
    }
    
    /**
     * Insert parameters to build an URL
     * @param $pattern array build pattern
     * @param $parameters array parameters
     * @return string URL
     */
    private function _insertParametersToUrl($pattern,$parameters)
    {
        // Initialize URL
        $url = $pattern[0];
        
        // Insert parameters into URL
        if (preg_match_all('/:([a-z][a-z0-9]*)/i', $url, $matches)) {
            foreach ($matches[1] as $name) {
                // Check if parameter is set
                if (!isset($parameters[$name])) {
                    // Remove parameter name from URL
                    $url = str_replace(':'.$name, '', $url);
                } else {
                    // Check if it is a complex sub-pattern
                    if (is_array($parameters[$name])) {
                        // Build value
                        $value = '';
                        foreach ($parameters[$name] as $subParameters) {
                            $value .= $this->_insertParametersToUrl(
                                $pattern[1][$name],
                                $subParameters
                            );
                        }
                    } else {
                        // Get value
                        $value = urlencode($parameters[$name]);
                    }

                    // Insert value into URL
                    $url = str_replace(':'.$name, $value, $url);
                }
            }
        }
        
        // Return URL
        return $url;
    }
    
}