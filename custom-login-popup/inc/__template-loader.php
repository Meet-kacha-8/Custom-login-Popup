<?php
class CLP_Template_Loader {
    public function __construct() {
        add_filter( 'template_include', [ $this, 'load_reset_template' ] );
    }

    public function load_reset_template( $template ) {
        if ( is_page( 'reset-password' ) ) {
            return CLP_PATH . 'templates/__reset-password-template.php';
        }
        return $template;
    }
}

