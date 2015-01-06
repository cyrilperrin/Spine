<?php

use CyrilPerrin\Spine\Route\Scan;

/**
 * Scan route test
 */
class ScanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * ParseUrl() test
     */
    public function testParseUrl()
    {
        // Build route
        $route = new Scan('/user-management/view/:id', 'User/Management', 'view', array(), array('id' => '%u'));

        // Parse unvalid URLs
        $this->assertNull($route->parseUrl('something'));
        $this->assertNull($route->parseUrl('/'));
        $this->assertNull($route->parseUrl('/user-management'));
        $this->assertNull($route->parseUrl('/user-management/'));
        $this->assertNull($route->parseUrl('/user-management/view'));
        $this->assertNull($route->parseUrl('/user-management/view/'));
        $this->assertNull($route->parseUrl('/user-management/view/a'));
        
        // Parse valid URLs
        $request = $route->parseUrl('/user-management/view/5');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('view', $request->getActionName());
        $this->assertEquals(array('id' => '5'), $request->getParameters());
        
        $request = $route->parseUrl('/user-management/view/10');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('view', $request->getActionName());
        $this->assertEquals(array('id' => '10'), $request->getParameters());
    }


    /**
     * BuildUrl() test
     */
    public function testBuildUrl()
    {
        // Build route
        $route = new Scan('/user-management/view/:id', 'User/Management', 'view', array(), array('id' => '%u'));
        
        // Build URL with invalid parameters
        $url = $route->buildUrl('Something', 'view', array());
        $this->assertNull($url);
        
        $url = $route->buildUrl('User/Management', 'something', array());
        $this->assertNull($url);
        
        $url = $route->buildUrl('User/Management', 'view', array());
        $this->assertNull($url);
        
        $url = $route->buildUrl('User/Management', 'something', array('id' => 5));
        $this->assertNull($url);
        
        $url = $route->buildUrl('Something', 'view', array('id' => 10));
        $this->assertNull($url);
        
        $url = $route->buildUrl('Something', 'something', array('id' => 20));
        $this->assertNull($url);
        
        // Build URLs with valid parameters
        $url = $route->buildUrl('User/Management', 'view', array('id' => 5));
        $this->assertEquals('/user-management/view/5', $url);
        
        $url = $route->buildUrl('User/Management', 'view', array('id' => 10));
        $this->assertEquals('/user-management/view/10', $url);
    }

}