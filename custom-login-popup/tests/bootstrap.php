<?php

/**
 * PHPUnit bootstrap file for Hello Theme Child tests
 */

// Define path to WP root
define('PHPUNIT_RUNNING', true);
define('WP_TESTS_ROOT', realpath(__DIR__ . '/../../../..'));

if (! file_exists(WP_TESTS_ROOT . '/wp-load.php')) {
    exit("Could not find wp-load.php. Please check WP_TESTS_ROOT path.\n");
}

// Load WordPress
require_once WP_TESTS_ROOT . '/wp-load.php';

// Load plugin file explicitly
require_once WP_PLUGIN_DIR . '/custom-login-popup/__custom-login-popup.php';

