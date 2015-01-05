<?php

namespace CyrilPerrin\Spine\Configuration\Loader;

use CyrilPerrin\Spine\Configuration\Loader;

/**
 * INI configuration loader
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
     * @see \CyrilPerrin\Spine\Configuration\Loader::getData()
     */
    public function getData($environment)
    {
        $content = parse_ini_file($this->_filename, true);
        $data = array();
        foreach ($content as $key => $value) {
            $pos = strpos($key, ':');
            if ($pos !== false) {
                $data[substr($key, 0, $pos)] = array_merge(
                    $data[substr($key, $pos+1)], $value
                );
            } else {
                $data[$key] = $value;
            }
        }
        return $data[$environment];
    }
}