<?php

/**
 * Template for Reset Password Page
 */

get_header();

$key   = sanitize_text_field($_GET['key'] ?? '');
$login = sanitize_text_field($_GET['login'] ?? '');

$error  = '';
$notice = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'], $_POST['confirm_password'], $_POST['login'], $_POST['key'])) {
    $login = sanitize_text_field($_POST['login']);
    $key   = sanitize_text_field($_POST['key']);

    $user = check_password_reset_key($key, $login);

    if (is_wp_error($user)) {
        $error = $user->get_error_message();
    } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
        $error = 'Passwords do not match.';
    } else {
        reset_password($user, $_POST['new_password']);
        $notice = 'Your password has been reset successfully. <a href="' . wp_login_url() . '">Login</a>';
    }
}

if (! $notice) {
?>
    <div class="clp-reset-password-page" style="max-width:500px;margin:50px auto;">
        <h2>Reset Your Password</h2>
        <?php if ($error): ?>
            <div class="clp-error"><?php echo esc_html($error); ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="login" value="<?php echo esc_attr($login); ?>">
            <input type="hidden" name="key" value="<?php echo esc_attr($key); ?>">
            <p>
                <label>New Password</label>
                <input type="password" name="new_password" required>
            </p>
            <p>
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </p>
            <p>
                <button type="submit">Reset Password</button>
            </p>
        </form>
    </div>
<?php
} else {
    echo '<div class="clp-notice" style="max-width:500px;margin:50px auto;">' . $notice . '</div>';
}

get_footer();
