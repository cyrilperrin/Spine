<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * Tests about GET parameters
 */
class GetParametersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test GET parameters
     */
    public function testGetParameters()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request(
            'GetParameters', 'getParameters', array(), array(
                'firstname' => 'James',
                'lastname' => 'Bond'
            )
        );
        $response = $application->run($request);
        $this->assertEquals('My name is Bond, James Bond', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * Test GET parameters with default value
     */
    public function testGetParametersWithDefaultValue()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        
        $request = new Request('GetParameters', 'getParametersWithDefaultValue');
        $response = $application->run($request);
        $this->assertEquals('I am a default value', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
        
        $request = new Request(
            'GetParameters', 'getParametersWithDefaultValue',
            array(), array('parameter' => 'I am not a default value')
        );
        $response = $application->run($request);
        $this->assertEquals('I am not a default value', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}