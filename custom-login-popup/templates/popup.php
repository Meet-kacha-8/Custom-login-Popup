<div class="clp-popup">
    <div class="content">
        <span class="close">×</span>

        <div class="clp-login">
            <?php echo do_shortcode('[clp_login_form]'); ?>
        </div>

        <div class="clp-register" style="display:none">
            <?php echo do_shortcode('[clp_register_form]'); ?>
        </div>

        <div class="clp-forgot" style="display:none">
            <h3 class="clp-popup-title">Reset your password</h3>
            <form id="clp-forgot-form">
                <p>
                    <label for="clp_forgot_email">Email Address</label>
                    <input type="email" name="clp_forgot_email" id="clp_forgot_email" required>
                </p>
                <p>
                    <button type="submit">Send Reset Link</button>
                </p>
            </form>
            <p><a href="#" class="clp-show-login">Back to login</a></p>
        </div>
    </div>
</div>