<?php
/**
 * Single Product Availability
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/availability.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<span class="availability_status">
<?php
	// Availability
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : esc_html__( 'Availability: ' , 'boo' ) . '<span class="availability">' . esc_html( $availability['availability'] )  . '</span>';
	//echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
?>
</span>