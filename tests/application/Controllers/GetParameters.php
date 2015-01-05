<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich manipulate GET parameters
 */
class GetParameters extends Controller
{
    /**
     * Action wich manipulate GET parameters
     */
    public function getParametersAction()
    {
        $firstname = $this->_request->getGetParameter('firstname');
        $lastname = $this->_request->getGetParameter('lastname');
        echo 'My name is ',$lastname,', ',$firstname,' ',$lastname;
    }
    
    /**
     * Action wich manipulate GET parameters with default value
     */
    public function getParametersWithDefaultValueAction()
    {
        $parameter = $this->_request->getGetParameter(
            'parameter',
            'I am a default value'
        );
        echo $parameter;
    }
}