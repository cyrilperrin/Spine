<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich use widget view
 */
class WidgetView extends Controller
{
    /**
     * Action wich use widget view
     */
    public function widgetViewAction()
    {
        $this->_view->render();
    }

    /**
     * Action wich use widget view with parameters
     */
    public function widgetViewWithParametersAction()
    {
        $this->_view->render();
    }
}