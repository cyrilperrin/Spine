<?php

namespace CyrilPerrin\Spine;

use CyrilPerrin\Spine\Application;
use CyrilPerrin\Spine\Interruption;
use CyrilPerrin\Spine\Interruption\Error;

/**
 * Filter
 */
abstract class Filter
{
    /** @var $_filters array filters */
    private static $_filters = array();
    
    /**
     * Get instance
     * @param $application \CyrilPerrin\Spine\Application application
     * @param $filterName string filter name
     * @return \CyrilPerrin\Spine\Filter filter
     * @throws \CyrilPerrin\Spine\Interruption
     */
    public static function getInstance(Application $application,$filterName)
    {
        // Get application ID
        $applicationId = $application->getId();
        
        // Check if filter is already created
        if (isset(self::$_filters[$applicationId][$filterName])) {
            // Return filter
            return self::$_filters[$applicationId][$filterName];
        } else {
            // Check if filter exists
            if (!class_exists('\Filters\\'.$filterName)) {
                throw new Error($application, 500);
            }
            
            try {
                // Create filter
                $filter = eval('return new \Filters\\'.$filterName.'();');
                
                // Set filter's attributes
                $filter->_application = $application;
                    
                // Initialize filter if necessary
                if (method_exists($filter, 'initialize')) {
                    $filter->initialize();
                }
            } catch (Interruption $exception) {
                // Throw exception
                throw $exception;
            } catch (\Exception $exception) {
                // Throw exception
                throw new Error($this->_application, null, 500, $exception);
            }
            
            // Save filter
            self::$_filters[$applicationId][$filterName] = $filter;
            
            // Return filter
            return $filter;
        }
    }
    
    /** @var $_application \CyrilPerrin\Spine\Application application */
    protected $_application;
    
    /**
     * Filter request
     * @param $request \CyrilPerrin\Spine\Request request
     * @return \CyrilPerrin\Spine\Request request
     * @throws \Exception
     */
    public abstract function filterRequest(Request $request);
    
    /**
     * Filter response
     * @param $response \CyrilPerrin\Spine\Response response
     * @return \CyrilPerrin\Spine\Response response
     * @throws \Exception
     */
    public abstract function filterResponse(Response $response);
}