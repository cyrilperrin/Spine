<?php

use CyrilPerrin\Spine\Configuration\Loader\Ini;

/**
 * Configuration INI loader test
 */
class IniTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Load() test
     */
    public function testLoad()
    {
        $loader = new Ini(__DIR__.'/IniTest.ini');
        
        $productionConfiguration = $loader->getData('production');
        $this->assertEquals(
            array(
                'varA' => 'A',
                'varB' => 'A',
                'varC' => 'A',
                'array' => array('A', 'B', 'C')
            ),
            $productionConfiguration
        );
        
        $productionConfiguration = $loader->getData('development');
        $this->assertEquals(
            array(
                'varA' => 'A',
                'varB' => 'B',
                'varC' => 'B',
                'array' => array('D', 'E', 'F')
            ),
            $productionConfiguration
        );
        
        $productionConfiguration = $loader->getData('integration');
        $this->assertEquals(
            array(
                'varA' => 'A',
                'varB' => 'A',
                'varC' => 'C',
                'varD' => 'C',
                'array' => array('A', 'B', 'C')
            ),
            $productionConfiguration
        );
    }
    
}