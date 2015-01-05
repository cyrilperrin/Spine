<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich call action in action view
 */
class CallActionInActionView extends Controller
{
    /**
     * Action wich call action in action view
     */
    public function callActionInActionViewAction()
    {
        $this->_view->render();
    }
}