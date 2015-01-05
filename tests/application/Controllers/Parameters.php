<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich manipulate parameters
 */
class Parameters extends Controller
{
    /**
     * Action wich manipulate parameters
     */
    public function parametersAction()
    {
        $firstname = $this->_request->getParameter('firstname');
        $lastname = $this->_request->getParameter('lastname');
        echo 'My name is ',$lastname,', ',$firstname,' ',$lastname;
    }
    
    /**
     * Action wich manipulate parameters with default value
     */
    public function parametersWithDefaultValueAction()
    {
        $parameter = $this->_request->getParameter(
            'parameter',
            'I am a default value'
        );
        echo $parameter;
    }
}