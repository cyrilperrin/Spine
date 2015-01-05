<?php

namespace CyrilPerrin\Spine;

use CyrilPerrin\Spine\Configuration\Loader;

/**
 * Configuration
 */
class Configuration
{
    /**
     * Get default instance
     * @return \CyrilPerrin\Spine\Configuration default instance
     */
    public static function getDefaultInstance()
    {
        return new Configuration();
    }
    
    /** @var $_data array data */
    private $_data;
    
    /**
     * Constructor
     * @param $data array data
     */
    public function __construct($data=array())
    {
        // Default configuration
        $this->_data = array(
            'spine.layout' => null,
            'spine.services' => array(),
            'spine.filters' => array()
        );
        
        // User configuration
        foreach ($data as $key => $value) {
            $this->_data[$key] = $value;
        }
    }
    
    /**
     * Get data
     * @param $key string key
     * @return string|array value
     */
    public function get($key)
    {
        return $this->_data[$key];
    }
    
    /**
     * Set data
     * @param $key string key
     * @param $value string|array valye
     */
    public function set($key,$value)
    {
        $this->_data[$key] = $value;
    }
    
    /**
     * Load data
     * @param $loader \CyrilPerrin\Spine\Configuration\Loader loader
     * @param $environment string environment
     */
    public function load(Loader $loader,$environment)
    {
        $data = $loader->getData($environment);
        foreach ($data as $key => $value) {
            $this->_data[$key] = $data;
        }
    }
    
}