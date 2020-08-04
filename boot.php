<?php   

    // Include all configurations
    $config = include __DIR__ . '/config.php';

    // Include all library modules
    include __DIR__ . '/library/fish.php';
    include __DIR__ . '/library/user.php';

    // Error Display
    if( $config['app']['mode'] == 'dev' ) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    // Set timezone
    date_default_timezone_set($config['timezone']);

    // Start a session
    session_start();