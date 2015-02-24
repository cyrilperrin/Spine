<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich call action in controller
 */
class CallActionInController extends Controller
{
    /**
     * Action wich call "HelloWorld" controller
     */
    public function callHelloWorldControllerAction()
    {
        echo $this->call('HelloWorld', 'helloWorld');
    }
    
    /**
     * Action wich call inexistant controller
     */
    public function callInexistantControllerAction()
    {
        echo $this->call('InexistantController', 'inexistantAction');
    }
}