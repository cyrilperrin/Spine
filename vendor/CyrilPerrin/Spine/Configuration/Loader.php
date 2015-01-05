<?php

namespace CyrilPerrin\Spine\Configuration;

/**
 * Configuration loader
 */
abstract class Loader
{
    /**
     * Get data
     * @param $environment string environment
     * @return array data 
     */
    abstract public function getData($environment);
}