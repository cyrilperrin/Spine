<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Crontoller wich do forwards
 */
class Forward extends Controller
{
    /**
     * Action wich do forward to HelloWorld controller
     */
    public function forwardToHelloWorldAction()
    {
        $this->forward('HelloWorld', 'helloWorld');
    }
    
    /**
     * Action wich do forward to InternalServerError controller
     */
    public function forwardToInternalServerErrorAction()
    {
        $this->forward('InternalServerError', 'testWarningError');
    }
    
    /**
     * Action wich do forward to non-existent controller
     */
    public function forwardToNonExistentControllerAction()
    {
        $this->forward('NonExistentController', 'nonExistentAction');
    }
    
    /**
     * Action wich do forward to non-existent action
     */
    public function forwardToNonExistentActionAction()
    {
        $this->forward('HelloWorld', 'nonExistentAction');
    }
}