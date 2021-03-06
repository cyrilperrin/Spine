<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * Tests about calling action in action view
 */
class CallActionInActionViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test calling "HelloWorld" controller
     */
    public function testCallHelloWorldController()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('CallActionInActionView', 'callHelloWorldController');
        $response = $application->run($request);
        $this->assertEquals('Hello world!', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * Test calling inexistant controller
     */
    public function testCallInexistantController()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('CallActionInActionView', 'callInexistantController');
        $response = $application->run($request);
        $this->assertEquals('Not Found', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }
}