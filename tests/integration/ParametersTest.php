<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * Tests about parameters
 */
class ParametersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test parameters
     */
    public function testParameters()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request(
            'Parameters', 'parameters', array(
                'firstname' => 'James',
                'lastname' => 'Bond'
            )
        );
        $response = $application->run($request);
        $this->assertEquals('My name is Bond, James Bond', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * Test parameters with default value
     */
    public function testParametersWithDefaultValue()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        
        $request = new Request('Parameters', 'parametersWithDefaultValue');
        $response = $application->run($request);
        $this->assertEquals('I am a default value', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());

        $request = new Request(
            'Parameters', 'parametersWithDefaultValue',
            array('parameter' => 'I am not a default value')
        );
        $response = $application->run($request);
        $this->assertEquals('I am not a default value', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}