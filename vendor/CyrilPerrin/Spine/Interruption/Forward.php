<?php

namespace CyrilPerrin\Spine\Interruption;

use CyrilPerrin\Spine\Interruption;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Controller;
use CyrilPerrin\Spine\Response;

/**
 * Forward interruption
 */
class Forward extends Interruption
{
    /** @var $_application \CyrilPerrin\Spine\Application application */
    private $_application;
    
    /** @var $_controllerName string  controller name*/
    private $_controllerName;
    
    /** @var $_actionName string action name */
    private $_actionName;
    
    /** @var $_parameters array parameters */
    private $_parameters;
    
    /**
     * Constructor
     * @param $application \CyrilPerrin\Spine\Application application
     * @param $controllerName string controller name
     * @param $actionName string action name
     * @param $parameters array parameters
     */
    public function __construct(Application $application,$controllerName,
        $actionName,$parameters=array())
    {
        $this->_application = $application;
        $this->_controllerName = $controllerName;
        $this->_actionName = $actionName;
        $this->_parameters = $parameters;
    }
    
    /**
     * @see \CyrilPerrin\Spine\Interruption::getResponse()
     */
    public function getResponse()
    {
        try {
            // Create request
            $request = new Request(
                $this->_controllerName, $this->_actionName, $this->_parameters
            );
            
            // Get controller
            $controller = Controller::getInstance(
                $this->_application, $request
            );
            
            // Run controller
            $response = $controller->run();
        } catch (Interruption $exception) {
            // Build response
            $response = new Response(500, Response::getStatusByCode(500));
        }
        
        // Return response
        return $response;
    }
}
