<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich use layout view
 */
class LayoutView extends Controller
{
    /**
     * Action wich manipulate layout view
     */
    public function layoutViewAction()
    {
        $this->useLayout('LayoutView/layoutView');
        $this->_view->render();
    }
    
    /**
     * Action wich manipulate layout view with parameters
     */
    public function layoutViewWithParametersAction()
    {
        $this->useLayout('LayoutView/layoutViewWithParameters');
        $this->_view->firstname = 'James';
        $this->_view->lastname = 'Bond';
        $this->_view->render();
    }
    
}