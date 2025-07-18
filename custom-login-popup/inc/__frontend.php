<?php
class CLP_Frontend
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_footer', [$this, 'render_popup']);
        add_filter('wp_nav_menu_items', [$this, 'add_login_logout_links'], 10, 2);
        add_filter('nav_menu_css_class', [$this, 'add_login_logout_class'], 10, 2);
        add_filter('nav_menu_link_attributes', [$this, 'adjust_logout_link'], 10, 3);
    }

    public function enqueue_assets()
    {
        wp_enqueue_style('clp-style', CLP_URL . 'assets/style.css');

        // Add inline custom colors
        $primary   = get_option('clp_primary_color', '#000000');
        $secondary = get_option('clp_secondary_color', '#ffffff');

        $custom_css = "
            .clp-popup .content {
                background-color: {$secondary};
                color: {$primary};
            }
            .clp-popup .content label,
            .clp-popup .content a {
                color: {$primary};
            }
            .clp-popup .content button,.clp-popup input[type='submit'] {
                background-color: {$primary};
                color: {$secondary};
            }
            
            .clp-popup input[type='submit']{
                border : none !important;
            }
            
            .clp-popup .content button:hover {
                opacity: 0.9;
            }
            .clp-popup-title {
                background-color: {$primary};
                color: {$secondary};
            }
        ";

        wp_add_inline_style('clp-style', $custom_css);

        wp_enqueue_script('clp-script', CLP_URL . 'assets/script.js', ['jquery'], null, true);
        wp_localize_script('clp-script', 'clp_ajax', [
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
    }

    public function render_popup()
    {
        echo '<div class="clp-popup">';
        include CLP_PATH . 'templates/popup.php';
        echo '</div>';
    }

    public function add_login_logout_links($items, $args)
    {
        if (is_user_logged_in() && ! isset($_GET['loggedout'])) {
            $items .= '<li class="clp-login-logout"><a href="#" class="clp-ajax-logout">Logout</a></li>';
        } else {
            $items .= '<li><a href="#" class="clp-open-popup">Login</a></li>';
        }

        return $items;
    }

    /**
     * Add CSS class to logout menu item
     */
    public function add_login_logout_class($classes, $item)
    {
        if ($item->title === 'Logout') {
            $classes[] = 'clp-login-logout';
        }
        return $classes;
    }

    /**
     * Adjust logout menu link to redirect back to current page
     */
    public function adjust_logout_link($atts, $item, $args)
    {
        if ($item->title === 'Logout' && is_user_logged_in()) {
            $current_url = (! empty($_SERVER['REQUEST_URI']))
                ? home_url($_SERVER['REQUEST_URI'])
                : home_url('/');
            $atts['href'] = wp_logout_url($current_url);
        }
        return $atts;
    }
}
