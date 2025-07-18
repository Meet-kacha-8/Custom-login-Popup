<?php
class CLP_Shortcodes
{
    public function __construct()
    {
        add_shortcode('clp_login_form', [$this, 'login_form']);
        add_shortcode('clp_register_form', [$this, 'register_form']);
    }


    public function login_form()
    {
        ob_start();
?>
        <h3 class="clp-popup-title">Login</h3>
        <?php
        wp_login_form([
            'redirect' => home_url()
        ]);
        ?>
        <p style="text-align: center; margin-top: 10px;">
            <a href="#" class="clp-show-register">Register</a> |
            <a href="#" class="clp-show-forgot">Forgot Password?</a>
        </p>
    <?php
        return ob_get_clean();
    }


    public function register_form()
    {
        ob_start();

        if (is_user_logged_in()) {
            echo '<p>You are already registered and logged in.</p>';
            return ob_get_clean();
        }

        $errors = [];

        if (isset($_POST['clp_register_nonce']) && wp_verify_nonce($_POST['clp_register_nonce'], 'clp_register')) {
            $username = sanitize_user($_POST['clp_username']);
            $email    = sanitize_email($_POST['clp_email']);
            $password = $_POST['clp_password'];

            if (empty($username) || empty($email) || empty($password)) {
                $errors[] = 'All fields are required.';
            }

            if (username_exists($username)) {
                $errors[] = 'Username already exists.';
            }

            if (email_exists($email)) {
                $errors[] = 'Email already registered.';
            }

            if (empty($errors)) {
                $role = get_option('clp_default_role', 'subscriber');

                $user_id = wp_insert_user([
                    'user_login' => $username,
                    'user_pass'  => $password,
                    'user_email' => $email,
                    'role'       => $role,
                ]);

                if (is_wp_error($user_id)) {
                    $errors[] = $user_id->get_error_message();
                } else {
                    wp_set_current_user($user_id);
                    wp_set_auth_cookie($user_id);
                    echo '<p>✅ Registration successful. You are now logged in.</p>';
                    return ob_get_clean();
                }
            }

            if (! empty($errors)) {
                echo '<div class="clp-errors"><ul>';
                foreach ($errors as $error) {
                    echo '<li>' . esc_html($error) . '</li>';
                }
                echo '</ul></div>';
            }
        }
    ?>

        <form method="post" class="clp-register-form">
            <h3 class="clp-popup-title">Registeration Form</h3>
            <?php wp_nonce_field('clp_register', 'clp_register_nonce'); ?>
            <p>
                <label>Username</label>
                <input type="text" name="clp_username" required>
            </p>
            <p>
                <label>Email</label>
                <input type="email" name="clp_email" required>
            </p>
            <p>
                <label>Password</label>
                <input type="password" name="clp_password" required>
            </p>
            <p>
                <button type="submit">Register</button>
            </p>
            <p style="text-align: center; margin-top: 10px;">
                <a href="#" class="clp-show-login">Back to Login</a>
            </p>
        </form>

<?php

        return ob_get_clean();
    }
}
