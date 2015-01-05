<?php

namespace CyrilPerrin\Spine\Router\Loader;

use CyrilPerrin\Spine\Router\Loader;

/**
 * INI Router loader
 */
class Ini extends Loader
{
    /** @var $_filename string filename */
    private $_filename;
    
    /**
     * Constructor
     * @param $filename string filename
     */
    public function __construct($filename)
    {
        $this->_filename = $filename;
    }
    
    /**
     * @see \CyrilPerrin\Spine\Router\Loader::getRoutes()
     */
    public function getRoutes()
    {
        // TODO
    }
}