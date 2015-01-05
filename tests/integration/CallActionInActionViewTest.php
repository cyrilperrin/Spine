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
     * Test calling action in action view
     */
    public function testCallActionInActionView()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request('CallActionInActionView', 'callActionInActionView');
        $response = $application->run($request);
        $this->assertEquals('Hello world!', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}