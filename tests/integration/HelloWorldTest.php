<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * "Hello world" test
 */
class HelloWorldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * "Hello world" test
     */
    public function testHelloWorld()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('HelloWorld', 'helloWorld');
        $response = $application->run($request);
        $this->assertEquals('Hello world!', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}