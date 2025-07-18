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
        $username = 'unituser';
        $email    = 'unituser@example.com';
        $password = 'password';

        $user_id = wp_create_user($username, $password, $email);
        $this->assertIsInt($user_id, 'User ID should be an integer');

        $user = get_user_by('ID', $user_id);
        $this->assertEquals($username, $user->user_login, 'Username should match');
    }
}
