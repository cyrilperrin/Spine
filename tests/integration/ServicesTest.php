<?php

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Request;
use CyrilPerrin\Spine\Router;

/**
 * Tests about using services
 */
class ServicesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test database service
     */
    public function testDatabaseService()
    {
        $application = new Application(null, null, __DIR__.'/../application');
        
        $databaseA = $application->getService('Database');
        $this->assertNotNull($databaseA);
        $this->assertFalse($databaseA->isStarted());
        
        $databaseB = $application->startService('Database');
        $this->assertTrue($databaseA === $databaseB);
        $this->assertTrue($databaseB->isStarted());
        
        $databaseC = $application->stopService('Database');
        $this->assertTrue($databaseB === $databaseC);
        $this->assertFalse($databaseB->isStarted());
    }
}