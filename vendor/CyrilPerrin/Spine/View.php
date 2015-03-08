<?php

namespace CyrilPerrin\Spine;

use CyrilPerrin\Spine\View\Widget;
use CyrilPerrin\Spine\View\Layout;

/**
 * View
 */
abstract class View
{
    /** @var $_application \CyrilPerrin\Spine\Application application */
    protected $_application;
    
    /** @var $_request \CyrilPerrin\Spine\Request request */
    protected $_request;
    
    /**
     * Constructor
     * @param $application \CyrilPerrin\Spine\Application application
     * @param $request \CyrilPerrin\Spine\Request request
     */
    public function __construct(Application $application,Request $request)
    {
        $this->_application = $application;
        $this->_request = $request;
    }
    
    /**
     * Wrap view by a layout
     * @param $layoutName string layout name
     * @return \CyrilPerrin\Spine\View\Layout wrapped view
     */
    public function wrap($layoutName)
    {
        return new Layout(
            $this->_application, $this->_request, $this, $layoutName
        );
    }
    
    /**
     * Call action
     * @param $controllerName string controller name
     * @param $actionName string action name
     * @param $parameters array parameters
     * @throws \CyrilPerrin\Spine\Interruption
     */
    protected function call($controllerName, $actionName, $parameters=array())
    {
        // Create request
        $request = new Request($controllerName, $actionName, $parameters);
        
        // Get controller
        $controller = Controller::getInstance(
            $this->_application, $request, false
        );
        
        // Run action
        $response = $controller->run($actionName);
        
        // Echo response content
        echo $response->getContent();
    }
    
    /**
     * Render widget
     * @param $widgetName string widget name
     * @param $parameters array parameters
     */
    protected function widget($widgetName,$parameters=array())
    {
        // Create widget
        $widget = new Widget(
            $this->_application, $this->_request, $widgetName, $parameters
        );
        
        // Render widget
        $widget->render();
    }
    
    /**
     * Get URL base
     * @return string URL base
     */
    protected function getUrlBase()
    {
        return $this->_application->getRouter()->getUrlBase();
    }
    
    /**
     * Build URL
     * @param $controllerName string controller name
     * @param $actionName string action name
     * @param $parameters array parameters
     */
    public function buildUrl($controllerName,$actionName,$parameters=array())
    {
        return $this->_application->getRouter()->buildUrl(
            $controllerName,
            $actionName,
            $parameters
        );
    }
    
    /**
     * Magic getter
     * @param $name string name
     * @return mixed value
     */
    public abstract function __get($name);
    
    /**
     * Magic setter
     * @param $name string name
     * @param $value mixed value
     */
    public abstract function __set($name,$value);
    
    /**
     * Render
     */
    public abstract function render();
    
}