<?php

namespace Services;

use CyrilPerrin\Spine\Service;

/**
 * Database service
 */
class Database extends Service
{
    /**
     * @see \CyrilPerrin\Spine\Service::isStarted()
     */
    public function isStarted()
    {
        return $this->_isStarted;
    }
    
    /**
     * @see \CyrilPerrin\Spine\Service::start()
     */
    public function start()
    {
        // login to database
        
        $this->_isStarted = true;
    }
    
    /**
     * @see \CyrilPerrin\Spine\Service::stop()
     */
    public function stop()
    {
        // logout from database
        
        $this->_isStarted = false;
    }
}