<?php
/**
* Themerella WooCommerce init
*
*/

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Load WooCommerce compatibility files.
 */
require get_template_directory() . '/rella/vendors/woocommerce/hooks.php';
require get_template_directory() . '/rella/vendors/woocommerce/functions.php';
require get_template_directory() . '/rella/vendors/woocommerce/template-tags.php';
require get_template_directory() . '/rella/vendors/woocommerce/options.php';
require get_template_directory() . '/rella/vendors/woocommerce/metaboxes.php';
