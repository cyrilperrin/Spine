<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich throw errors
 */
class Error extends Controller
{
    /**
     * Action wich display error
     */
    public function errorAction()
    {
        echo $this->_request->getParameter('message', 'Oups.');
    }
    
    /**
     * Action wich throw customized error
     */
    public function customizedErrorAction()
    {
        $this->error('I am a customized error');
    }
    
    /**
     * Action wich throw 403 error
     */
    public function error403Action()
    {
        $this->error(null, 403);
    }
    
    /**
     * Action wich throw 404 error
     */
    public function error404Action()
    {
        $this->error(null, 404);
    }
    
    /**
     * Action wich throw 500 error
     */
    public function error500Action()
    {
        $this->error(null, 500);
    }
}