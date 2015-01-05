<?php

namespace CyrilPerrin\Spine\View;

use CyrilPerrin\Spine\View;
use CyrilPerrin\Spine\Interruption\Error;
use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;

/**
 * Widget view
 */
class Widget extends View
{
    /** @var $_widgetName string widget name */
    private $_widgetName;
    
    /** @var $_parameters array parameters */
    private $_parameters;
    
    /**
     * Constructor
     * @param $application \CyrilPerrin\Spine\Application application
     * @param $request \CyrilPerrin\Spine\Request request
     * @param $widgetName string widget name
     * @param $parameters array parameters
     */
    public function __construct(Application $application,Request $request,
        $widgetName,$parameters=array())
    {
        parent::__construct($application, $request);
        $this->_widgetName = $widgetName;
        $this->_parameters = $parameters;
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
        // Get widget path
        $widgetPath = $this->_application->getDirectory().'/Views/Widgets/'.
                    $this->_widgetName.'.phtml';
        
        // Check if widget exists
        if (!file_exists($widgetPath)) {
            throw new Error($this->_application, null, 500);
        }
        
        // Include widget
        include($widgetPath);
    }
}