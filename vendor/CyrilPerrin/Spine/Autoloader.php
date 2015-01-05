<?php

namespace CyrilPerrin\Spine;

/**
 * Autoloader
 */
class Autoloader
{
    /**
     * Register autoloader
     */
    public static function register()
    {
        spl_autoload_register('\CyrilPerrin\Spine\Autoloader::autoload');
    }
    
    /**
     * Add directory to include path
     * @param $path string path
     */
    public static function addDirectoryToIncludePath($path)
    {
        set_include_path(get_include_path().PATH_SEPARATOR.realpath($path));
    }
    
    /**
     * Autoload
     * @param $className string class name
     * @return string filepath
     */
    public static function autoload($className)
    {
        // Remove first \
        $className = ltrim($className, '\\');
        
        // Initialize file path
        $filePath = '';
        
        // Consider namespace
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).
                        DIRECTORY_SEPARATOR;
        }
        
        // Consider class name
        $filePath .= str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';
        
        // Include class file
        if (stream_resolve_include_path($filePath) !== false) {
            include($filePath);
        }
    }
}