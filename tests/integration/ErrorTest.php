<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;

/**
 * Tests about error throws
 */
class ErrorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test customized error throw
     */
    public function testCustomizedError()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('Error', 'customizedError');
        $response = $application->run($request);
        $this->assertEquals('I am a customized error', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * Test 403 error throw
     */
    public function test403Error()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('Error', 'error403');
        $response = $application->run($request);
        $this->assertEquals('Forbidden', $response->getContent());
        $this->assertEquals(403, $response->getStatusCode());
    }
    
    /**
     * Test 404 error throw
     */
    public function test404Error()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('Error', 'error404');
        $response = $application->run($request);
        $this->assertEquals('Not Found', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }
    
    /**
     * Test 500 error throw
     */
    public function test500Error()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('Error', 'error500');
        $response = $application->run($request);
        $this->assertEquals('Internal Server Error', $response->getContent());
        $this->assertEquals(500, $response->getStatusCode());
    }
}