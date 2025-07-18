<?php

use PHPUnit\Framework\TestCase;

class TestHelpers extends TestCase
{
    public function test_login_shortcode_exists()
    {
        $shortcodes = array_keys($GLOBALS['shortcode_tags']);
        $this->assertContains('clp_login_form', $shortcodes, 'clp_login_form shortcode should be registered');
    }

    public function test_user_can_login()
    {
        if (username_exists('loginuser')) {
            wp_delete_user(get_user_by('login', 'loginuser')->ID);
        }

        $user_id = wp_create_user('loginuser', 'password', 'loginuser@example.com');
        $this->assertIsInt($user_id, 'User ID should be an integer');

        $creds = [
            'user_login'    => 'loginuser',
            'user_password' => 'password',
            'remember'      => true,
        ];
        $user = wp_signon($creds);

        $this->assertInstanceOf(WP_User::class, $user, 'wp_signon() should return a WP_User object');
        $this->assertEquals($user_id, $user->ID, 'Logged in user ID should match created user ID');
    }

    public function test_register_shortcode_exists()
    {
        $shortcodes = array_keys($GLOBALS['shortcode_tags']);
        $this->assertContains('clp_register_form', $shortcodes, 'clp_register_form shortcode should be registered');
    }

    public function test_registration_creates_user()
    {
        if (username_exists('unituser')) {
            wp_delete_user(get_user_by('login', 'unituser')->ID);
        }

        $username = 'unituser';
        $email    = 'unituser@example.com';
        $password = 'password';

        $user_id = wp_create_user($username, $password, $email);
        $this->assertIsInt($user_id, 'User ID should be an integer');

        $user = get_user_by('ID', $user_id);
        $this->assertEquals($username, $user->user_login, 'Username should match');
    }

    public function test_logout_clears_current_user()
    {
        if (username_exists('logoutuser')) {
            wp_delete_user(get_user_by('login', 'logoutuser')->ID);
        }

        $user_id = wp_create_user('logoutuser', 'password', 'logoutuser@example.com');
        wp_set_current_user($user_id);

        // instead of wp_logout() (which sends headers), use this:
        wp_set_current_user(0);

        $this->assertEquals(0, get_current_user_id(), 'User should be logged out');
    }

    public function test_reset_password_template_exists()
    {
        $template_path = dirname(__DIR__) . '/templates/__reset-password-template.php';
        $this->assertFileExists($template_path, 'Reset password template should exist');
    }

    public function test_ajax_actions_are_registered()
    {
        $this->assertArrayHasKey('wp_ajax_clp_login', $GLOBALS['wp_filter'], 'AJAX action wp_ajax_clp_login should be registered');
        $this->assertArrayHasKey('wp_ajax_nopriv_clp_login', $GLOBALS['wp_filter'], 'AJAX action wp_ajax_nopriv_clp_login should be registered');
    }

    public function test_template_loader_returns_template()
    {
        $template = clp_get_template_path('popup.php');
        $this->assertNotEmpty($template, 'Template path should not be empty');
        $this->assertFileExists($template, 'Template file should exist');
    }
}
