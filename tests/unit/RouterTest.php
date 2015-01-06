<?php

use CyrilPerrin\Spine\Router;
use CyrilPerrin\Spine\Route\Scan;
use CyrilPerrin\Spine\Route\Literal;

/**
 * Router test
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * ParseUrl() test
     */
    public function testParseUrl()
    {
        // Build router
        $router = new Router('/app');
        $router->addRoute(new Literal('/user/login', 'User', 'login'));
        $router->addRoute(new Literal('/user/changeSettings', 'User', 'changeSettings'));
        $router->addRoute(new Literal('/user/changePassword', 'User', 'changePassword'));
        $router->addRoute(new Literal('/user/logout', 'User', 'logout'));
        $router->addRoute(new Literal('/user-management', 'User/Management', 'index'));
        $router->addRoute(new Literal('/user-management/add', 'User/Management', 'add'));
        $router->addRoute(
            new Scan('/user-management/view/:id', 'User/Management', 'view', array(), array('id' => '%u'))
        );
        $router->addRoute(
            new Scan('/user-management/edit/:id', 'User/Management', 'edit', array(), array('id' => '%u'))
        );
        $router->addRoute(
            new Scan('/user-management/delete/:id', 'User/Management', 'delete', array(), array('id' => '%u'))
        );
        
        // Parse unvalid URLs
        $this->assertNull($router->parseUrl(''));
        $this->assertNull($router->parseUrl('something'));
        $this->assertNull($router->parseUrl('/app'));
        $this->assertNull($router->parseUrl('/app/something'));
        $this->assertNull($router->parseUrl('/app/user/something'));
        $this->assertNull($router->parseUrl('/app/user-management/something'));
        $this->assertNull($router->parseUrl('/app/user-management/view/something'));
        $this->assertNull($router->parseUrl('/app/user-management/edit/something'));
        $this->assertNull($router->parseUrl('/app/user-management/delete/something'));
        
        // Parse valid URLs
        $request = $router->parseUrl('/app/user/login');
        $this->assertEquals('User', $request->getControllerName());
        $this->assertEquals('login', $request->getActionName());
        $this->assertEmpty($request->getParameters());

        $request = $router->parseUrl('/app/user/changeSettings');
        $this->assertEquals('User', $request->getControllerName());
        $this->assertEquals('changeSettings', $request->getActionName());
        $this->assertEmpty($request->getParameters());

        $request = $router->parseUrl('/app/user/changePassword');
        $this->assertEquals('User', $request->getControllerName());
        $this->assertEquals('changePassword', $request->getActionName());
        $this->assertEmpty($request->getParameters());

        $request = $router->parseUrl('/app/user/logout');
        $this->assertEquals('User', $request->getControllerName());
        $this->assertEquals('logout', $request->getActionName());
        $this->assertEmpty($request->getParameters());

        $request = $router->parseUrl('/app/user-management');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('index', $request->getActionName());
        $this->assertEmpty($request->getParameters());

        $request = $router->parseUrl('/app/user-management/add');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('add', $request->getActionName());
        $this->assertEmpty($request->getParameters());

        $request = $router->parseUrl('/app/user-management/delete/5');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('delete', $request->getActionName());
        $this->assertEquals(array('id' => '5'), $request->getParameters());

        $request = $router->parseUrl('/app/user-management/view/10');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('view', $request->getActionName());
        $this->assertEquals(array('id' => '10'), $request->getParameters());

        $request = $router->parseUrl('/app/user-management/edit/20');
        $this->assertEquals('User/Management', $request->getControllerName());
        $this->assertEquals('edit', $request->getActionName());
        $this->assertEquals(array('id' => '20'), $request->getParameters());
    }
    
    /**
     * BuildUrl() test
     */
    public function testBuildUrl()
    {
        // Build router
        $router = new Router('/app');
        $router->addRoute(new Literal('/user/login', 'User', 'login'));
        $router->addRoute(new Literal('/user/changeSettings', 'User', 'changeSettings'));
        $router->addRoute(new Literal('/user/changePassword', 'User', 'changePassword'));
        $router->addRoute(new Literal('/user/logout', 'User', 'logout'));
        $router->addRoute(new Literal('/user-management', 'User/Management', 'index'));
        $router->addRoute(new Literal('/user-management/add', 'User/Management', 'add'));
        $router->addRoute(
            new Scan('/user-management/view/:id', 'User/Management', 'view', array(), array('id' => '%u'))
        );
        $router->addRoute(
            new Scan('/user-management/edit/:id', 'User/Management', 'edit', array(), array('id' => '%u'))
        );
        $router->addRoute(
            new Scan('/user-management/delete/:id', 'User/Management', 'delete', array(), array('id' => '%u'))
        );
        
        // Build URLs with unvalid parameters
        $this->assertNull($router->buildUrl('Something', 'something'));
        $this->assertNull($router->buildUrl('Something', 'index'));
        $this->assertNull($router->buildUrl('User', 'something'));
        $this->assertNull($router->buildUrl('User/Management', 'something'));
        $this->assertNull($router->buildUrl('User/Management', 'view'));
        $this->assertNull($router->buildUrl('User/Management', 'edit'));
        $this->assertNull($router->buildUrl('User/Management', 'delete'));
        
        // Build URLs with valid parameters
        $this->assertEquals('/app/user/login', $router->buildUrl('User', 'login'));
        $this->assertEquals('/app/user/changeSettings', $router->buildUrl('User', 'changeSettings'));
        $this->assertEquals('/app/user/changePassword', $router->buildUrl('User', 'changePassword'));
        $this->assertEquals('/app/user/logout', $router->buildUrl('User', 'logout'));
        $this->assertEquals('/app/user-management', $router->buildUrl('User/Management', 'index'));
        $this->assertEquals('/app/user-management/add', $router->buildUrl('User/Management', 'add'));
        
        $url = $router->buildUrl('User/Management', 'view', array('id' => '5'));
        $this->assertEquals('/app/user-management/view/5', $url);
        
        $url = $router->buildUrl('User/Management', 'edit', array('id' => '10'));
        $this->assertEquals('/app/user-management/edit/10', $url);
        
        $url = $router->buildUrl('User/Management', 'delete', array('id' => '20'));
        $this->assertEquals('/app/user-management/delete/20', $url);
    }
}

