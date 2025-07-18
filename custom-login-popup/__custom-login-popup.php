<?php
/*
Plugin Name: Custom Login Popup
Description: Login/Registration popup with reset password and menu integration. (OOP)
Version: 1.0
Author: Your Name
*/

if (! defined('ABSPATH')) exit;

define('CLP_PATH', plugin_dir_path(__FILE__));
define('CLP_URL', plugin_dir_url(__FILE__));

// Autoloader
spl_autoload_register(function ($class) {
    $map = [
        'CLP_Admin'       => 'inc/__admin.php',
        'CLP_Frontend'    => 'inc/__frontend.php',
        'CLP_Shortcodes'  => 'inc/__shortcodes.php',
        'CLP_Ajax'        => 'inc/__ajax.php',
        'CLP_Main'        => 'inc/__main.php',
        'CLP_Template_Loader' => 'inc/__template-loader.php',
    ];
    if (isset($map[$class])) {
        require_once CLP_PATH . $map[$class];
    }
});

// Helpers
require_once CLP_PATH . 'inc/__helpers.php';

// Init
register_activation_hook(__FILE__, ['CLP_Main', 'on_activation']);

add_action('plugins_loaded', function () {
    (new CLP_Main())->init();
});
