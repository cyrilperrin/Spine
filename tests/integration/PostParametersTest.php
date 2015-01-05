<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * Tests about POST parameters
 */
class PostParametersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test POST parameters
     */
    public function testPostParameters()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        $request = new Request(
            'PostParameters', 'postParameters', array(), array(), array(
                'firstname' => 'James',
                'lastname' => 'Bond'
            )
        );
        $response = $application->run($request);
        $this->assertEquals('My name is Bond, James Bond', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * Test POST parameters with default value
     */
    public function testPostParametersWithDefaultValue()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        
        $request = new Request('PostParameters', 'postParametersWithDefaultValue');
        $response = $application->run($request);
        $this->assertEquals('I am a default value', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
        
        $request = new Request(
            'PostParameters', 'postParametersWithDefaultValue',
            array(), array(), array('parameter' => 'I am not a default value')
        );
        $response = $application->run($request);
        $this->assertEquals('I am not a default value', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}