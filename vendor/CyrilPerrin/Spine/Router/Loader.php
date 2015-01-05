<?php

namespace CyrilPerrin\Spine\Router;

/**
 * Router loader
 */
abstract class Loader
{
    /**
     * Get routes
     * @return array routes
     */
    abstract public function getRoutes();
}