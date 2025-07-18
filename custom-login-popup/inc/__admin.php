<?php
class CLP_Admin
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_init', [$this, 'register_menu_metabox']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets()
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('clp-admin-js', CLP_URL . 'assets/admin.js', ['wp-color-picker'], null, true);
    }

    /**
     * Add plugin settings page
     */
    public function add_menu()
    {
        add_menu_page(
            'Login Popup Settings',
            'Login Popup',
            'manage_options',
            'clp-settings',
            [$this, 'render_settings']
        );
    }

    /**
     * Render plugin settings page
     */
    public function render_settings()
    {
?>
        <div class="wrap">
            <h1>Login Popup Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('clp_settings');
                do_settings_sections('clp_settings');
                $role           = get_option('clp_default_role', 'subscriber');
                $primary_color   = get_option('clp_primary_color', '#000000');
                $secondary_color = get_option('clp_secondary_color', '#ffffff');
                ?>
                <p>
                    <label for="clp_default_role">Default Role for New Users:</label>
                    <select name="clp_default_role">
                        <option value="subscriber" <?php selected($role, 'subscriber'); ?>>Subscriber</option>
                        <?php if (clp_is_woocommerce_active()) : ?>
                            <option value="customer" <?php selected($role, 'customer'); ?>>Customer</option>
                        <?php endif; ?>
                        <?php if (clp_is_membership_active()) : ?>
                            <option value="member" <?php selected($role, 'member'); ?>>Member</option>
                        <?php endif; ?>
                    </select>
                </p>

                <p>
                    <label for="clp_primary_color">Popup Primary Color:</label>
                    <input type="text" name="clp_primary_color" value="<?php echo esc_attr($primary_color); ?>" class="clp-color-field" />
                </p>

                <p>
                    <label for="clp_secondary_color">Popup Secondary Color:</label>
                    <input type="text" name="clp_secondary_color" value="<?php echo esc_attr($secondary_color); ?>" class="clp-color-field" />
                </p>

                <?php submit_button(); ?>
            </form>
        </div>
    <?php
    }

    /**
     * Register custom menu item metabox on Appearance → Menus
     */
    public function register_menu_metabox()
    {
        add_meta_box(
            'clp_login_logout_menu',
            __('Login/Logout Link', 'clp'),
            [$this, 'render_login_logout_menu_metabox'],
            'nav-menus',
            'side',
            'default'
        );
    }

    /**
     * Render the metabox content
     */
    public function render_login_logout_menu_metabox()
    {
    ?>
        <div id="posttype-clp-login-logout" class="posttypediv">
            <div id="tabs-panel-clp-login-logout" class="tabs-panel tabs-panel-active">
                <ul id="clp-login-logout-checklist" class="categorychecklist form-no-clear">
                    <li>
                        <label class="menu-item-title">
                            <input type="checkbox" name="menu-item[-1][menu-item-type]" value="custom" />
                            <input type="hidden" name="menu-item[-1][menu-item-title]" value="Login/Logout" />
                            <input type="hidden" name="menu-item[-1][menu-item-url]" value="<?php echo esc_url(home_url()); ?>" />
                            <?php _e('Login/Logout', 'clp'); ?>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
<?php
    }

    public function register_settings()
    {
        register_setting('clp_settings', 'clp_default_role');
        register_setting('clp_settings', 'clp_primary_color');
        register_setting('clp_settings', 'clp_secondary_color');
    }
}
