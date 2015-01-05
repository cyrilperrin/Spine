<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;
use CyrilPerrin\Spine\Configuration;

/**
 * Tests about using filters
 */
class FiltersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test ACL filter
     */
    public function testAclService()
    {
        // Build application
        $configuration = new Configuration(array('spine.filters' => array('Acl')));
        $application = new Application($configuration, null, __DIR__.'/../application');
        
        // Add
        $request = new Request('Acl', 'add');
        $response = $application->run($request);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('Forbidden', $response->getContent());
        
        $request = new Request('Acl', 'add', array('user' => 'reader'));
        $response = $application->run($request);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('Forbidden', $response->getContent());
        
        $request = new Request('Acl', 'add', array('user' => 'editor'));
        $response = $application->run($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('User "editor" can add', $response->getContent());
        
        $request = new Request('Acl', 'add', array('user' => 'administrator'));
        $response = $application->run($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('User "administrator" can add', $response->getContent());
        
        // Read
        $request = new Request('Acl', 'read');
        $response = $application->run($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('User "reader" can read', $response->getContent());
        
        $request = new Request('Acl', 'read', array('user' => 'reader'));
        $response = $application->run($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('User "reader" can read', $response->getContent());
        
        $request = new Request('Acl', 'read', array('user' => 'editor'));
        $response = $application->run($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('User "editor" can read', $response->getContent());
        
        $request = new Request('Acl', 'read', array('user' => 'administrator'));
        $response = $application->run($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('User "administrator" can read', $response->getContent());
        
        // Edit
        $request = new Request('Acl', 'edit');
        $response = $application->run($request);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('Forbidden', $response->getContent());

        $request = new Request('Acl', 'edit', array('user' => 'reader'));
        $response = $application->run($request);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('Forbidden', $response->getContent());
        
        $request = new Request('Acl', 'edit', array('user' => 'editor'));
        $response = $application->run($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('User "editor" can edit', $response->getContent());
        
        $request = new Request('Acl', 'edit', array('user' => 'administrator'));
        $response = $application->run($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('User "administrator" can edit', $response->getContent());
        
        // Delete
        $request = new Request('Acl', 'delete');
        $response = $application->run($request);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('Forbidden', $response->getContent());

        $request = new Request('Acl', 'delete', array('user' => 'reader'));
        $response = $application->run($request);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('Forbidden', $response->getContent());
        
        $request = new Request('Acl', 'delete', array('user' => 'editor'));
        $response = $application->run($request);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('Forbidden', $response->getContent());
        
        $request = new Request('Acl', 'delete', array('user' => 'administrator'));
        $response = $application->run($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('User "administrator" can delete', $response->getContent());
    }
    
    /**
     * Test password protector
     */
    public function testPasswordProtectorService()
    {
        $configuration = new Configuration(array('spine.filters' => array('PasswordProtector')));
        $application = new Application($configuration, null, __DIR__.'/../application');
        $request = new Request('Password', 'password', array('user' => 'administrator'));
        $response = $application->run($request);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Password is : ******', $response->getContent());
    }
}