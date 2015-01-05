<?php

namespace CyrilPerrin\Spine;

/**
 * Error handler
 */
class ErrorHandler
{
    /**
     * Register error handler
     */
    public static function register()
    {
        set_error_handler(
            '\CyrilPerrin\Spine\ErrorHandler::handleError',
            error_reporting()
        );
    }
    
    /**
     * Handle error
     * @param $errno int error level
     * @param $errstr int error description
     * @param $errfile int error file
     * @param $errline int error line number
     * @throws \CyrilPerrin\Spine\ErrorException
     */
    public static function handleError($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            return;
        }
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}