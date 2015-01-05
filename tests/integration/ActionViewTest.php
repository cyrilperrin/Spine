<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * Tests about action view usage
 */
class ActionViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test action view usage
     */
    public function testActionView()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('ActionView', 'actionView');
        $response = $application->run($request);
        $this->assertEquals('I am an action view!', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * Test action view usage with parameters
     */
    public function testActionViewWithParameters()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('ActionView', 'actionViewWithParameters');
        $response = $application->run($request);
        $this->assertEquals('I am an action view with parameters!', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}