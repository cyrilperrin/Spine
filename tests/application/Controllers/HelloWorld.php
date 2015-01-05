<?php

namespace Controllers;

use CyrilPerrin\Spine\Controller;

/**
 * Controller wich display "Hello world!"
 */
class HelloWorld extends Controller
{
    /**
     * Action wich display "Hello world!"
     */
    public function helloWorldAction()
    {
        echo 'Hello world!';
    }
}