<?php
class CLP_Main
{
    public static function on_activation()
    {
        $page = get_page_by_path('reset-password');
        if (! $page) {
            wp_insert_post([
                'post_title'   => 'Reset Password',
                'post_name'    => 'reset-password',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ]);
        }
    }


    public function init()
    {
        new CLP_Admin();
        new CLP_Frontend();
        new CLP_Shortcodes();
        new CLP_Ajax();
        new CLP_Template_Loader();
        
    }
}
