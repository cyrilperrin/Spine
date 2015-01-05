<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * Tests about forward
 */
class ForwardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test forward to HelloWorld controller
     */
    public function testForwardToHelloWorldController()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('Forward', 'forwardToHelloWorld');
        $response = $application->run($request);
        $this->assertEquals('Hello world!', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * Test forward to InternalServerError controller
     */
    public function testtForwardToInternalServerErrorController()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('Forward', 'forwardToInternalServerError');
        $response = $application->run($request);
        $this->assertEquals('Internal Server Error', $response->getContent());
        $this->assertEquals(500, $response->getStatusCode());
    }
    
    /**
     * Test forward to InternalServerError controller
     */
    public function testtForwardToNonExistentController()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('Forward', 'forwardToNonExistentController');
        $response = $application->run($request);
        $this->assertEquals('Internal Server Error', $response->getContent());
        $this->assertEquals(500, $response->getStatusCode());
    }
    
    /**
     * Test forward to InternalServerError controller
     */
    public function testtForwardToNonExistentAction()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('Forward', 'forwardToNonExistentAction');
        $response = $application->run($request);
        $this->assertEquals('Internal Server Error', $response->getContent());
        $this->assertEquals(500, $response->getStatusCode());
    }
}