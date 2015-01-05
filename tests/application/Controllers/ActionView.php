<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich use action view
 */
class ActionView extends Controller
{
    /**
     * Action wich use an action view
     */
    public function actionViewAction()
    {
        $this->_view->render();
    }

    /**
     * Action wich use an action view with parameters
     */
    public function actionViewWithParametersAction()
    {
        $this->_view->message = 'I am an action view with parameters!';
        $this->_view->render();
    }
}