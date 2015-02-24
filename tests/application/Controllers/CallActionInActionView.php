<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich call action in action view
 */
class CallActionInActionView extends Controller
{
    /**
     * Action view wich call "HelloWorld" controller
     */
    public function callHelloWorldControllerAction()
    {
        $this->_view->render();
    }
    
    /**
     * Action view wich call an inexistant controller
     */
    public function callInexistantControllerAction()
    {
        $this->_view->render();
    }
}