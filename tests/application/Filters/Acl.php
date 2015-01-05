<?php

namespace Filters;

use CyrilPerrin\Spine\Filter;
use CyrilPerrin\Spine\Response;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Interruption\Error;

/**
 * ACL filter
 */
class Acl extends Filter
{
    /**
     * @see \CyrilPerrin\Spine\Filter::filterRequest()
     */
    public function filterRequest(Request $request)
    {
        // Get controller and action name
        $controllerName = $request->getControllerName();
        $actionName = $request->getActionName();
        
        // Check if ACL must be applied
        if ($controllerName == 'Acl') {
            // ACL error ?
            $error = false;
            
            // Get user
            $user = $request->getParameter('user', 'reader');

            // Depending on user
            switch ($user) {
                case 'reader':
                    $error = $actionName == 'add' || $actionName == 'edit' ||
                             $actionName == 'delete';
                    break;
                case 'editor':
                    $error = $actionName == 'delete';
                    break;
                case 'administrator':
                    break;
                default:
                    $error = true;
            }
            
            // ACL error ?
            if ($error) {
                throw new Error($this->_application, null, 403); 
            }
            
            // Set user if not set
            $request->setParameter('user', $user);
        }
        
        // Return request
        return $request;
    }
    
    /**
     * @see \CyrilPerrin\Spine\Filter::filterResponse()
     */
    public function filterResponse(Response $response)
    {
        return $response;
    }
}