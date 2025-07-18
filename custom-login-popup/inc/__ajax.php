<?php
class CLP_Ajax
{
    public function __construct()
    {
        add_action('wp_ajax_clp_ajax_logout', [$this, 'ajax_logout']);
        add_action('wp_ajax_nopriv_clp_ajax_logout', [$this, 'ajax_logout']);

        add_action('wp_ajax_clp_forgot_password', [$this, 'forgot_password']);
        add_action('wp_ajax_nopriv_clp_forgot_password', [$this, 'forgot_password']);
    }

    public function ajax_logout()
    {
        wp_logout();

        $current_url = (! empty($_SERVER['HTTP_REFERER']))
            ? esc_url_raw($_SERVER['HTTP_REFERER'])
            : home_url('/');

        wp_send_json_success(['redirect' => $current_url]);
    }

    public function forgot_password()
    {
        if (empty($_POST['email']) || ! is_email($_POST['email'])) {
            wp_send_json_error('Invalid email address.');
        }

        $email = sanitize_email($_POST['email']);
        $user = get_user_by('email', $email);

        if (! $user) {
            wp_send_json_error('No user found with that email.');
        }

        $user_login = $user->user_login;
        $user_email = $user->user_email;

        // Generate reset key
        $key = get_password_reset_key($user);

        if (is_wp_error($key)) {
            wp_send_json_error('Could not generate reset key.');
        }

        // Build your custom reset URL
        $reset_url = site_url('/reset-password/') . "?key={$key}&login=" . rawurlencode($user_login);

        // Send email manually
        $subject = 'Password Reset Request';
        $message = "Hi {$user_login},\n\n";
        $message .= "You requested a password reset.\n\n";
        $message .= "Click the link below to reset your password:\n";
        $message .= $reset_url . "\n\n";
        $message .= "If you did not request this, please ignore this email.\n";

        wp_mail($user_email, $subject, $message);

        wp_send_json_success([
            'message' => 'Reset email sent.',
            'debug_reset_url' => $reset_url
        ]);
    }
}
