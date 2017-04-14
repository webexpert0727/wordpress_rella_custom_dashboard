<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

//set columns
global $woocommerce_loop;

if ( ! isset( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
}
$woo_columns = 'columns-'. $woocommerce_loop['columns'];

$woo_style = rella_helper()->get_option( 'ra_woo_style', 'elegant' );

//print_r($woocommerce_loop);

?>
<div class="product-<?php echo sanitize_html_class( $woo_style ); ?> woocommerce <?php echo rella_helper()->sanitize_html_classes( $woo_columns ) ; ?>">
<ul class="products">
