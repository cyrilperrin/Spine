<?php

// Used namespaces
use CyrilPerrin\Spine\Autoloader;
use CyrilPerrin\Spine\ErrorHandler;

// Register autoloader
require(__DIR__.'/../vendor/CyrilPerrin/Spine/Autoloader.php');
Autoloader::register();
Autoloader::addDirectoryToIncludePath(__DIR__.'/application');

// Add vendor directory to include path
Autoloader::addDirectoryToIncludePath(__DIR__.'/../vendor');

// Register error handler
ErrorHandler::register();
