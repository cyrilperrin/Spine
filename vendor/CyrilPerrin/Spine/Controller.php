<?php

namespace CyrilPerrin\Spine;

use CyrilPerrin\Spine\Interruption;
use CyrilPerrin\Spine\Interruption\Forward;
use CyrilPerrin\Spine\Interruption\Error;
use CyrilPerrin\Spine\View\Action;
use CyrilPerrin\Spine\View\Layout;

/**
 * Controller
 */
abstract class Controller
{
    
    /**
     * Get instance
     * @param $application \CyrilPerrin\Spine\Application application
     * @param $request \CyrilPerrin\Spine\Request request
     * @param $useLayout bool use layout ?
     * @return \CyrilPerrin\Spine\Controller controller
     * @throws \CyrilPerrin\Spine\Interruption 
     */
    public static function getInstance(Application $application,
        Request $request,$useLayout=true)
    {
        // Get application ID
        $applicationId = $application->getId();
        
        // Get configuration
        $configuration = $application->getConfiguration();
        
        // Get controller name
        $controllerName = $request->getControllerName();
        
        // Create view
        $view = new Action($application, $request, $controllerName);
        
        // Wrap view by the layout
        if ($useLayout) {
            $layoutName = $configuration->get('spine.layout');
            if ($layoutName != null) {
                $view = $view->wrap($layoutName);
            }
        }
        
        // Create response
        $response = new Response();
        
        // Check if controller exists
        if (!class_exists('\Controllers\\'.$controllerName)) {
            throw new Error($application, null, 404);
        }
        
        try {
            // Create controller
            $controller = eval(
                'return new \Controllers\\'.$controllerName.'();'
            );

            // Set controller's attributes
            $controller->_request = $request;
            $controller->_view = $view;
            $controller->_response = $response;
            $controller->_application = $application;
            
            // Initialize controller if necessary
            if (method_exists($controller, 'initialize')) {
                   $controller->initialize();
            }
        } catch (Interruption $exception) {
            // Throw exception
            throw $exception;
        } catch (\Exception $exception) {
            // Throw exception
            throw new Error($this->_application, null, 500, $exception);
        }
    
        // Return controller
        return $controller;
    }
    
    /** @var $_application \CyrilPerrin\Spine\Application application */
    protected $_application;
    
    /** @var $_request \CyrilPerrin\Spine\Request request */
    protected $_request;
    
    /** @var $_view \CyrilPerrin\Spine\View view */
    protected $_view;
    
    /** @var $response \CyrilPerrin\Spine\Response response */
    protected $_response;
    
    /**
     * Run action
     * @param $actionName string action name
     * @return \CyrilPerrin\Spine\Response response
     * @throws \CyrilPerrin\Spine\Interruption 
     */
    public final function run($actionName=null)
    {
        // Get action name if necessary
        if ($actionName === null) {
            $actionName = $this->_request->getActionName();
        }
        
        // Check if action exists
        if (!method_exists($this, $actionName.'Action')) {
            throw new Error($this->_application, null, 404);
        }
        
        // Set view's action name
        $this->_view->setActionName($actionName);
        
        // Run action
        try {
            // Turn on output buffering
            ob_start();
            
            // Call method
            call_user_func(array($this,$actionName.'Action'));
            
            // Get buffer content
            $content = ob_get_clean();
            
            // Set response's content if necessary
            if ($content != null) {
                $this->_response->setContent($content);
            }
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
        
        // Return response
        return $this->_response;
    }
    
    /**
     * Forward request
     * @param $controllerName string controller name
     * @param $actionName string action name
     * @param $parameters array parameters
     * @throws \CyrilPerrin\Spine\Interruption\Forward
     */
    protected function forward($controllerName,$actionName,$parameters=array())
    {
        throw new Forward(
            $this->_application, $controllerName, $actionName, $parameters
        );
    }
    
    /**
     * Throw an error
     * @param $message string message
     * @param $statusCode int HTTP status code
     * @param $cause \Exception cause
     * @throws \CyrilPerrin\Spine\Interruption\Error
     */
    protected function error($message=null,$statusCode=200,$cause=null)
    {
        throw new Error(
            $this->_application, $message, $statusCode, $cause
        );
    }
    
}