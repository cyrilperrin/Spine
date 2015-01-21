<?php

namespace CyrilPerrin\Spine;

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Interruption;
use CyrilPerrin\Spine\Interruption\Error;

/**
 * Service
 */
abstract class Service
{
    /** @var $_services array services */
    private static $_services = array();
    
    /**
     * Get instance
     * @param $application \CyrilPerrin\Spine\Application application
     * @param $serviceName string service name
     * @return \CyrilPerrin\Spine\Service service
     * @throws \CyrilPerrin\Spine\Interruption
    */
    public static function getInstance(Application $application,$serviceName)
    {
        // Get application ID
        $applicationId = $application->getId();
    
        // Check if service is already created
        if (isset(self::$_services[$applicationId][$serviceName])) {
            // Return service
            return self::$_services[$applicationId][$serviceName];
        } else {
            // Check if service exists
            if (!class_exists('\Services\\'.$serviceName)) {
                throw new Error($application, null, 500);
            }

            try {
                // Create service
                $service = eval(
                    'return new \Services\\'.$serviceName.'();'
                );
        
                // Set service's attributes
                $service->_application = $application;
        
                // Initialize service if necessary
                if (method_exists($service, 'initialize')) {
                    $service->initialize();
                }
            } catch (Interruption $exception) {
                // Throw exception
                throw $exception;
            } catch (\Exception $exception) {
                // Throw exception
                throw new Error($application, null, 500, $exception);
            }
    
            // Save service
            self::$_services[$applicationId][$serviceName] = $service;
    
            // Return service
            return $service;
        }
    }
    
    /**
     * Start service
     * @param $application \CyrilPerrin\Spine\Application application
     * @param $serviceName string service name
     * @return \CyrilPerrin\Spine\Service started service
     * @throws \CyrilPerrin\Spine\Interruption
     */
    public static function startService(Application $application,$serviceName)
    {
        // Get service
        $service = self::getInstance($application, $serviceName);
        
        // Start service if necessary
        if (!$service->isStarted()) {
            try {
                $service->start();
            } catch (Interruption $exception) {
                // Throw exception
                throw $exception;
            } catch (\Exception $exception) {
                // Throw exception
                throw new Error($application, null, 500, $exception);
            }
        }
        
        // Return service
        return $service;
    }
    
    /**
     * Stop service
     * @param $application \CyrilPerrin\Spine\Application application
     * @param $serviceName string service name
     * @return \CyrilPerrin\Spine\Service stopped service
     * @throws \CyrilPerrin\Spine\Interruption
     */
    public static function stopService(Application $application,$serviceName)
    {
        // Get service
        $service = self::getInstance($application, $serviceName);
        
        // Stop service if necessary
        if ($service->isStarted()) {
            try {
                $service->stop();
            } catch (Interruption $exception) {
                // Throw exception
                throw $exception;
            } catch (\Exception $exception) {
                // Throw exception
                throw new Error($application, null, 500, $exception);
            }
        }
        
        // Return service
        return $service; 
    }
    
    /**
     * Stop application's services
     * @param $application \CyrilPerrin\Spine\Application application
     * @throws \CyrilPerrin\Spine\Interruption
     */
    public static function stopApplicationServices(Application $application)
    {
        // Check if application has services
        if (isset(self::$_services[$application->getId()])) {
            // Get application's services
            $services = self::$_services[$application->getId()];
            
            // Stop application's services
            foreach ($services as $service) {
                if ($service->isStarted()) {
                    try {
                        $service->stop();
                    } catch (Interruption $exception) {
                        // Throw exception
                        throw $exception;
                    } catch (\Exception $exception) {
                        // Throw exception
                        throw new Error($application, null, 500, $exception);
                    }
                }
            }
        }
    }
    
    /** @var $_application \CyrilPerrin\Spine\Application application */
    protected $_application;
    
    /** @var $_isStarted bool is started ? */
    protected $_isStarted = false;
    
    /**
     * Check if service is started
     * @return boolean service started ?
     */
    public abstract function isStarted();
    
    /**
     * Start
     */
    public abstract function start();
    
    /**
     * Stop
     */
    public abstract function stop();
}