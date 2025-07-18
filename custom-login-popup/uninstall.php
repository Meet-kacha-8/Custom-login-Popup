<?php
// If uninstall not called from WordPress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Delete Reset Password page
$page = get_page_by_path( 'reset-password' );
if ( $page ) {
    wp_delete_post( $page->ID, true );
}

// Delete plugin option
delete_option( 'clp_default_role' );
