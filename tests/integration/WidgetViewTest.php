<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * Tests about widget view
 */
class WidgetViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test widget view
     */
    public function testWidgetView()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('WidgetView', 'widgetView');
        $response = $application->run($request);
        $this->assertEquals('I am a widget', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * Test widget view with parameters test
     */
    public function testWidgetViewWithParameters()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('WidgetView', 'widgetViewWithParameters');
        $response = $application->run($request);
        $this->assertEquals('My name is Bond, James Bond', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}