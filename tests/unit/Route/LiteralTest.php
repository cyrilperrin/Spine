<?php

use CyrilPerrin\Spine\Route\Literal;

/**
 * Literal route test
 */
class LiteralTest extends \PHPUnit_Framework_TestCase
{
    /**
     * ParseUrl() test
     */
    public function testParseUrl()
    {
        // Build route
        $route = new Literal('/user', 'User', 'index', array('test' => 'test'));

        // Parse unvalid URLs
        $this->assertNull($route->parseUrl(''));
        $this->assertNull($route->parseUrl('something'));
        $this->assertNull($route->parseUrl('/something'));
        
        // Parse valid URLs
        $request = $route->parseUrl('/user');
        $this->assertEquals('User', $request->getControllerName());
        $this->assertEquals('index', $request->getActionName());
        $this->assertEquals(array('test' => 'test'), $request->getParameters());
    }

    /**
     * BuildUrl() test
     */
    public function testBuildUrl()
    {
        // Build route
        $route = new Literal('/user', 'User', 'index', array('test' => 'test'));
        
        // Build URL with invalid parameters
        $url = $route->buildUrl('Something', 'something');
        $this->assertNull($url);
        
        $url = $route->buildUrl('User', 'something');
        $this->assertNull($url);
        
        $url = $route->buildUrl('Something', 'index');
        $this->assertNull($url);
        
        $url = $route->buildUrl('User', 'index');
        $this->assertNull($url);
        
        $url = $route->buildUrl('User', 'index', array('something' => 'something'));
        $this->assertNull($url);
        
        $url = $route->buildUrl('User', 'index', array('something' => 'something','test' => 'test'));
        $this->assertNull($url);
        
        // Build URLs with valid parameters
        $url = $route->buildUrl('User', 'index', array('test' => 'test'));
        $this->assertEquals('/user', $url);
    }

}