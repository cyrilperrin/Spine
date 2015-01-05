<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich is protected by ACL
 */
class Acl extends Controller
{
    /**
     * Add action
     */
    public function addAction()
    {
        echo 'User "',$this->_request->getParameter('user'),'" can add';
    }
    
    /**
     * Read action
     */
    public function readAction()
    {
        echo 'User "',$this->_request->getParameter('user'),'" can read';
    }
    
    /**
     * Edit action
     */
    public function editAction()
    {
        echo 'User "',$this->_request->getParameter('user'),'" can edit';
    }
    
    /**
     * Delete action
     */
    public function deleteAction()
    {
        echo 'User "',$this->_request->getParameter('user'),'" can delete';
    }
}