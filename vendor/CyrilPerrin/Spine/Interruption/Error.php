<?php

namespace CyrilPerrin\Spine\Interruption;

use CyrilPerrin\Spine\Interruption;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Response;
use CyrilPerrin\Spine\Controller;

/**
 * Error interruption
 */
class Error extends Interruption
{
    /** @var $_application \CyrilPerrin\Spine\Application application */
    private $_application;
    
    /** @var $_statusCode int HTTP status code */
    private $_statusCode;
    
    /** @var $_message string message */
    private $_message;
    
    /** @var $_cause \Exception cause */
    private $_cause;
    
    /**
     * Constructor
     * @param $application \CyrilPerrin\Spine\Application application
     * @param $message string message
     * @param $statusCode int HTTP status code
     * @param $cause \Exception cause
     */
    public function __construct(Application $application, $message=null,
        $statusCode=200, $cause=null)
    {
        // Set message if necessary
        if ($message == null) {
            // Get HTTP status
            $message = Response::getStatusByCode($statusCode);
        }
        
        // Save attributes
        $this->_application = $application;
        $this->_statusCode = $statusCode;
        $this->_message = $message;
        $this->_cause = $cause;
    }
    
    /**
     * Get cause
     * @return \Exception cause
     */
    public function getCause()
    {
        return $this->_cause;
    }
    
    /**
     * @see \CyrilPerrin\Spine\Interruption::getResponse()
     */
    public function getResponse()
    {
        try {
            // Create request
            $request = new Request(
                'Error', 'error', array(
                    'message' => $this->_message,
                    'cause' => $this->_cause
                )
            );
        
            // Get controller
            $controller = Controller::getInstance(
                $this->_application, $request
            );
            
            // Run controller
            $response = $controller->run();
            
            // Set HTTP status code
            $response->setStatusCode($this->_statusCode);
            
            // Set exception
            $response->setException($this->_cause);
        } catch (Interruption $exception) {
            // Build response
            $response = new Response(
                500, Response::getStatusByCode(500), $exception
            );
        }
        
        // Return response
        return $response;
    }
}