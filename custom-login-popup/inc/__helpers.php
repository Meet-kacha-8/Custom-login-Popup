<?php
function clp_is_woocommerce_active()
{
    return class_exists('WooCommerce');
}

function clp_is_membership_active()
{
    return class_exists('Some_Membership_Class');
}
