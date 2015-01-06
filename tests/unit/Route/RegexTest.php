<?php

use CyrilPerrin\Spine\Route\Regex;

/**
 * Regex route test
 */
class RegexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * ParseUrl() test
     */
    public function testParseUrl()
    {
        // Build route
        $route = new Regex(
            array(
                '/:controller/:action:parameters',
                array(
                    'parameters' => array(
                        '/:name/:value'
                    )
                )
            ),
            array(
                '(/:controller(/:action(:parameters)?)?)?/?',
                array(
                    'controller' => '[a-zA-Z][a-zA-Z0-9\._-]*',
                    'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    'parameters' => array(
                        '/:name/:value', array(
                            'name' => '[a-zA-Z][a-zA-Z0-9]*',
                            'value' => '[^\/]*'
                        )
                    )
                )
            ),
            'Index', 'index'
        );

        // Parse unvalid URLs
        $this->assertNull($route->parseUrl('something'));
        $this->assertNull($route->parseUrl('/1users/1get'));
        $this->assertNull($route->parseUrl('/users/get/1id/5'));
        
        // Parse valid URLs
        $request = $route->parseUrl('');
        $this->assertEquals('Index', $request->getControllerName());
        $this->assertEquals('index', $request->getActionName());
        $this->assertEmpty($request->getParameters());
        
        $request = $route->parseUrl('/user/login');
        $this->assertEquals('User', $request->getControllerName());
        $this->assertEquals('login', $request->getActionName());
        $this->assertEmpty($request->getParameters());
        
        $request = $route->parseUrl('/user/changeSettings');
        $this->assertEquals('User', $request->getControllerName());
        $this->assertEquals('changeSettings', $request->getActionName());
        $this->assertEmpty($request->getParameters());
        
        $request = $route->parseUrl('/user/changePassword');
        $this->assertEquals('User', $request->getControllerName());
        $this->assertEquals('changePassword', $request->getActionName());
        $this->assertEmpty($request->getParameters());
        
        $request = $route->parseUrl('/user/logout');
        $this->assertEquals('User', $request->getControllerName());
        $this->assertEquals('logout', $request->getActionName());
        $this->assertEmpty($request->getParameters());
        
        $request = $route->parseUrl('/user-management');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('index', $request->getActionName());
        $this->assertEmpty($request->getParameters());
        
        $request = $route->parseUrl('/user-management/add');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('add', $request->getActionName());
        $this->assertEmpty($request->getParameters());
        
        $request = $route->parseUrl('/user-management/view/id/198');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('view', $request->getActionName());
        $this->assertEquals(array('id' => '198'), $request->getParameters());
        
        $request = $route->parseUrl('/user-management/view/id/205');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('view', $request->getActionName());
        $this->assertEquals(array('id' => '205'), $request->getParameters());
        
        $request = $route->parseUrl('/user-management/view/id/548');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('view', $request->getActionName());
        $this->assertEquals(array('id' => '548'), $request->getParameters());
        
        $request = $route->parseUrl('/userManagement');
        $this->assertEquals('UserManagement', $request->getControllerName());
        $this->assertEquals('index', $request->getActionName());
        $this->assertEmpty($request->getParameters());
        
        $request = $route->parseUrl('/userManagement/add');
        $this->assertEquals('UserManagement', $request->getControllerName());
        $this->assertEquals('add', $request->getActionName());
        $this->assertEmpty($request->getParameters());
        
        $request = $route->parseUrl('/userManagement/view/id/198');
        $this->assertEquals('UserManagement', $request->getControllerName());
        $this->assertEquals('view', $request->getActionName());
        $this->assertEquals(array('id' => '198'), $request->getParameters());
        
        $request = $route->parseUrl('/userManagement/view/id/205');
        $this->assertEquals('UserManagement', $request->getControllerName());
        $this->assertEquals('view', $request->getActionName());
        $this->assertEquals(array('id' => '205'), $request->getParameters());
        
        $request = $route->parseUrl('/userManagement/view/id/548');
        $this->assertEquals('UserManagement', $request->getControllerName());
        $this->assertEquals('view', $request->getActionName());
        $this->assertEquals(array('id' => '548'), $request->getParameters());
    }


    /**
     * BuildUrl() test
     */
    public function testBuildUrl()
    {
        // Build route
        $route = new Regex(
            array(
                '/:controller/:action:parameters',
                array(
                    'parameters' => array(
                        '/:name/:value'
                    )
                )
            ),
            array(
                '(/:controller(/:action(:parameters)?)?)?/?',
                array(
                    'controller' => '[a-zA-Z][a-zA-Z0-9\._-]*',
                    'action' => '[a-zA-Z][a-zA-Z0-9]*',
                    'parameters' => array(
                        '/?:name(/:value)?', array(
                            'name' => '[a-zA-Z][a-zA-Z0-9]*',
                            'value' => '[^\/]*'
                        )
                    )
                )
            )
        );
        
        // Build URLs with valid parameters
        $url = $route->buildUrl('User', 'login');
        $this->assertEquals('/user/login', $url);

        $url = $route->buildUrl('User', 'changeSettings');
        $this->assertEquals('/user/changeSettings', $url);

        $url = $route->buildUrl('User', 'changePassword');
        $this->assertEquals('/user/changePassword', $url);

        $url = $route->buildUrl('User', 'logout');
        $this->assertEquals('/user/logout', $url);

        $url = $route->buildUrl('User/Management', 'index');
        $this->assertEquals('/user-management/index', $url);

        $url = $route->buildUrl('User/Management', 'add');
        $this->assertEquals('/user-management/add', $url);

        $url = $route->buildUrl('User/Management', 'view', array('id' => '5'));
        $this->assertEquals('/user-management/view/id/5', $url);

        $url = $route->buildUrl('User/Management', 'edit', array('id' => '10'));
        $this->assertEquals('/user-management/edit/id/10', $url);

        $url = $route->buildUrl('User/Management', 'delete', array('id' => '20'));
        $this->assertEquals('/user-management/delete/id/20', $url);

        $url = $route->buildUrl('UserManagement', 'index');
        $this->assertEquals('/userManagement/index', $url);

        $url = $route->buildUrl('UserManagement', 'add');
        $this->assertEquals('/userManagement/add', $url);

        $url = $route->buildUrl('UserManagement', 'view', array('id' => '5'));
        $this->assertEquals('/userManagement/view/id/5', $url);

        $url = $route->buildUrl('UserManagement', 'edit', array('id' => '10'));
        $this->assertEquals('/userManagement/edit/id/10', $url);

        $url = $route->buildUrl('UserManagement', 'delete', array('id' => '20'));
        $this->assertEquals('/userManagement/delete/id/20', $url);
    }

}