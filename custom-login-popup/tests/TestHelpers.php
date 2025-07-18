<?php

use PHPUnit\Framework\TestCase;

/**
 * @group custom-login-popup
 */
class TestHelpers extends TestCase
{
    /**
     * Make sure WordPress hooks are fired.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Fire WordPress hooks to ensure plugin registers shortcodes and AJAX.
        do_action('init');
        do_action('admin_init');
    }

    /**
     * Plugin main file exists.
     */
    public function test_plugin_file_exists()
    {
        $this->assertFileExists(
            dirname(__DIR__) . '/__custom-login-popup.php',
            'Plugin main file should exist'
        );
    }

    /**
     * Template files exist.
     */
    public function test_templates_exist()
    {
        $this->assertFileExists(
            dirname(__DIR__) . '/templates/__reset-password-template.php',
            'Reset password template should exist'
        );
        $this->assertFileExists(
            dirname(__DIR__) . '/templates/popup.php',
            'Popup template should exist'
        );
    }

    /**
     * Shortcodes are registered.
     */
    public function test_shortcodes_registered()
    {
        global $shortcode_tags;

        $this->assertArrayHasKey(
            'clp_login_form',
            $shortcode_tags,
            'Shortcode [clp_login_form] should be registered'
        );

        $this->assertArrayHasKey(
            'clp_register_form',
            $shortcode_tags,
            'Shortcode [clp_register_form] should be registered'
        );
    }

    /**
     * AJAX actions are registered.
     */
    public function test_ajax_actions_registered()
    {
        global $wp_filter;

        $this->assertArrayHasKey(
            'wp_ajax_clp_login',
            $wp_filter,
            'AJAX action wp_ajax_clp_login should be registered'
        );

        $this->assertArrayHasKey(
            'wp_ajax_nopriv_clp_login',
            $wp_filter,
            'AJAX action wp_ajax_nopriv_clp_login should be registered'
        );
    }
}
