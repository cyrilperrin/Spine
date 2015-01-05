<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * "Not found" tests
 */
class NotFoundTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test non-existent controller
     */
    public function testNonExistentController()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('NonExistentController', 'nonexistentAction');
        $response = $application->run($request);
        $this->assertEquals('Not Found', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }
    
    /**
     * Test non-existent action
     */
    public function testNonExistentAction()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('HelloWorld', 'nonexistentAction');
        $response = $application->run($request);
        $this->assertEquals('Not Found', $response->getContent());
        $this->assertEquals(404, $response->getStatusCode());
    }
}