<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich manipulate POST parameters
 */
class PostParameters extends Controller
{
    /**
     * Action wich manipulate POST parameters
     */
    public function postParametersAction()
    {
        $firstname = $this->_request->getPostParameter('firstname');
        $lastname = $this->_request->getPostParameter('lastname');
        echo 'My name is ',$lastname,', ',$firstname,' ',$lastname;
    }
    
    /**
     * Action wich manipulate POST parameters with default value
     */
    public function postParametersWithDefaultValueAction()
    {
        $parameter = $this->_request->getPostParameter(
            'parameter',
            'I am a default value'
        );
        echo $parameter;
    }
}