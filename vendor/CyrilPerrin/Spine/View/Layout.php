<?php

namespace CyrilPerrin\Spine\View;

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\View;
use CyrilPerrin\Spine\Interruption;
use CyrilPerrin\Spine\Interruption\Error;

/**
 * Layout view
 */
class Layout extends View
{
    /** @var $_view \CyrilPerrin\Spine\View view */
    private $_view;
    
    /** @var $_layoutName string layout name */
    private $_layoutName;
    
    /** @var $_content string view content */
    private $_content;
    
    /**
     * Constructor
     * @param $application \CyrilPerrin\Spine\Application application
     * @param $request \CyrilPerrin\Spine\Request request
     * @param $controllerName string controller name
     * @param $layoutName layout name
     * @param $view \CyrilPerrin\Spine\View view
     */
    public function __construct(Application $application,Request $request,
        View $view,$layoutName=null)
    {
        parent::__construct($application, $request);
        $this->_view = $view;
        $this->_layoutName = $layoutName;
    }
    
    /**
     * Unwrap view
     * @return \CyrilPerrin\Spine\View unwrapped view
     */
    public function unwrap()
    {
        return $this->_view;
    }
    
    /**
     * Magic caller
     * @param $name string method name
     * @param $arguments array arguments
     * @return mixed value
     */
    public function __call($name,$arguments)
    {
        return call_user_func_array(array($this->_view,$name), $arguments);
    }

    /**
     * @see \CyrilPerrin\Spine\View::__get()
     */
    public function __get($name)
    {
        return $this->_view->__get($name);
    }

    /**
     * @see \CyrilPerrin\Spine\View::__set()
     */
    public function __set($name,$value)
    {
        $this->_view->__set($name, $value);
    }

    /**
     * @see \CyrilPerrin\Spine\View::render()
     */
    public function render()
    {
        // Get layout path
        $layoutPath = $this->_application->getDirectory().'/Views/Layouts/'.
                      $this->_layoutName.'.phtml';
        
        // Check if layout exists
        if (!file_exists($layoutPath)) {
            throw new Error($this->_application, null, 500);
        }

        // Turn on output buffering
        ob_start();

        try {
            // Render view
            $this->_view->render();
        } catch (Interruption $exception) {
            // Clean buffer content
            ob_clean();
            
            // Throw exception
            throw $exception;
        } catch (\Exception $exception) {
            // Clean buffer content
            ob_clean();
            
            // Throw exception
            throw new Error($this->_application, null, 500, $exception);
        }

        // Get buffer content
        $this->_content = ob_get_clean();
        
        // Include layout
        include($layoutPath);
    }
}