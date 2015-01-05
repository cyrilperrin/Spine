<?php

namespace CyrilPerrin\Spine;

/**
 * Interruption
 */
abstract class Interruption extends \Exception
{
    /**
     * Get response
     * @return \CyrilPerrin\Spine\Response response
     */
    public abstract function getResponse();
}