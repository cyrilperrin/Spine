<?php

namespace CyrilPerrin\Spine;

use CyrilPerrin\Spine\Service;
use CyrilPerrin\Spine\Interruption;
use CyrilPerrin\Spine\Interruption\Error;

/**
 * Application
 */
class Application
{
    /** @var $_id string id */
    private $_id;
    
    /** @var $_configuration \CyrilPerrin\Spine\Configuration configuration */
    private $_configuration;
    
    /** @var $_router \CyrilPerrin\Spine\Router Router */
    private $_router;
    
    /** @var $_directory string directory */
    private $_directory;
    
    /**
     * Constructor
     * @param $configuration \CyrilPerrin\Spine\Configuration configuration
     * @param $router \CyrilPerrin\Spine\Router router
     * @param $directory string directory
     */
    public function __construct($configuration=null,$router=null,
        $directory='../application')
    {
        // Get default configuration if necessary
        if ($configuration == null) {
            $configuration = Configuration::getDefaultInstance();
        }
        
        // Get router from globals if necessary
        if ($router == null) {
            // Get router from globals
            $router = Router::getInstanceFromGlobals();
            
            // Add default route to router
            $router->addRoute(Route::getDefaultInstance());
        }
        
        // Save attributes
        $this->_id = uniqid();
        $this->_configuration = $configuration;
        $this->_router = $router;
        $this->_directory = realpath($directory);
    }
    
    /**
     * Destructor
     */
    public function __destruct()
    {
        // Stop all services
        Service::stopApplicationServices($this);
    }
    
    /**
     * Run
     * @param \CyrilPerrin\Spine\Request $request
     * @return \CyrilPerrin\Spine\Response response
     */
    public function run($request=null)
    {
        // Get request from globals if necessary
        if ($request == null) {
            // Get request from globals
            $request = Request::getInstanceFromGlobals($this->_router);
            
            // Check if request is null
            if ($request == null) {
                $exception = new Error($this, null, 404);
                return $exception->getResponse();
            }
        }
        
        // Initialize response
        $response = null;
        
        // Get filters
        $filters = array();
        foreach ($this->_configuration->get('spine.filters') as $filterName) {
            try {
                $filters[] = Filter::getInstance($this, $filterName);
            } catch (Interruption $exception) {
                $response = $exception->getResponse();
            }
        }
        
        // If response is not set
        if ($response == null) {
            // Filter request
            $usedFilters = array();
            foreach ($filters as $filter) {
                try {
                    $request = $filter->filterRequest($request);
                    $usedFilters[] = $filter;
                } catch (Interruption $exception) {
                    $response = $exception->getResponse();
                } catch (\Exception $exception) {
                    $exception = new Error($this, null, 500, $exception);
                    $response = $exception->getResponse();
                }
            }
            
            // Get/Run controller if response is not set
            if ($response == null) {
                try {
                    $response = Controller::getInstance($this, $request)->run();
                } catch (Interruption $exception) {
                    $response = $exception->getResponse();
                }
            }
            
            // Filter response
            foreach (array_reverse($usedFilters) as $filter) {
                try {
                    $response = $filter->filterResponse($response);
                } catch (Interruption $exception) {
                    $response = $exception->getResponse();
                } catch (\Exception $exception) {
                    $exception = new Error($this, null, 500, $exception);
                    $response = $exception->getResponse();
                }
            }
        }
        
        // Return response
        return $response;
    }
    
    /**
     * Get id
     * @return string id
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * Get configuration
     * @return \CyrilPerrin\Spine\Configuration configuration
     */
    public function getConfiguration()
    {
        return $this->_configuration;
    }
    
    /**
     * Get Router
     * @return \CyrilPerrin\Spine\Router Router
     */
    public function getRouter()
    {
        return $this->_router;
    }
    
    /**
     * Get directory
     * @return string directory
     */
    public function getDirectory()
    {
        return $this->_directory;
    }
    
    /**
     * Get a service
     * @param $serviceName string service name
     * @return \CyrilPerrin\Spine\Service service
     * @throws \CyrilPerrin\Spine\Interruption
     */
    public function getService($serviceName)
    {
        return Service::getInstance($this, $serviceName);
    }
    
    /**
     * Start a service
     * @param $serviceName string service name
     * @return \CyrilPerrin\Spine\Service started service
     * @throws \CyrilPerrin\Spine\Interruption
     */
    public function startService($serviceName)
    {
        return Service::startService($this, $serviceName);
    }
    
    /**
     * Stop a service
     * @param $serviceName string service name
     * @return \CyrilPerrin\Spine\Service stopped service
     * @throws \CyrilPerrin\Spine\Interruption
     */
    public function stopService($serviceName)
    {
        return Service::stopService($this, $serviceName);
    }
}