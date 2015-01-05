<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich throw internal errors 
 */
class InternalServerError extends Controller
{
    /**
     * Action with nonexistent action view
     */
    public function nonExistentActionViewAction()
    {
        $this->_view->render();
    }
    
    /**
     * Action with nonexistent layout view
     */
    public function nonExistentLayoutViewAction()
    {
        $this->_view->wrap('inexistantLayoutView')->render();
    }
    
    /**
     * Action with nonexistent widget view
     */
    public function nonExistentWidgetViewAction()
    {
        $this->_view->render();
    }
    
    /**
     * Action wich throw warning error
     */
    public function warningErrorAction()
    {
        strpos();
    }
}