<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * Tests about layout view
 */
class LayoutViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test layout view
     */
    public function testLayoutView()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('LayoutView', 'layoutView');
        $response = $application->run($request);
        $this->assertEquals('I am an action view inside a layout view', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * Test layout view with parameters
     */
    public function testLayoutViewWithParameters()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('LayoutView', 'layoutViewWithParameters');
        $response = $application->run($request);
        $this->assertEquals('My name is Bond, James Bond', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}