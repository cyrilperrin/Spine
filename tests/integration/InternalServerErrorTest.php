<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * Tests about internal error
 */
class InternetServerErrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test non-existent action view
     */
    public function testNonExistentActionView()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('InternalServerError', 'nonExistentActionView');
        $response = $application->run($request);
        $this->assertEquals('Internal Server Error', $response->getContent());
        $this->assertEquals(500, $response->getStatusCode());
    }
    
    /**
     * Test non-existent layout view
     */
    public function testNonExistentLayoutView()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('InternalServerError', 'nonExistentLayoutView');
        $response = $application->run($request);
        $this->assertEquals('Internal Server Error', $response->getContent());
        $this->assertEquals(500, $response->getStatusCode());
    }
    
    /**
     * Test non-existent widget view
     */
    public function testNonExistentWidgetView()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('InternalServerError', 'nonExistentWidgetView');
        $response = $application->run($request);
        $this->assertEquals('Internal Server Error', $response->getContent());
        $this->assertEquals(500, $response->getStatusCode());
    }
    
    /**
     * Test warning error
     */
    public function testWarningError()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('InternalServerError', 'warningError');
        $response = $application->run($request);
        $this->assertEquals('Internal Server Error', $response->getContent());
        $this->assertEquals(500, $response->getStatusCode());
    }
}