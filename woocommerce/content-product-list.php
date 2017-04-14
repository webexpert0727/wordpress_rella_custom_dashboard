<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $post;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>
<li <?php post_class(); ?>>
	<div class="col-md-4">
	<?php 
		the_post_thumbnail( 'boo-loop-list-product' );
	?>
	</div>
	<div class="col-md-6">
		<?php 
			if ( function_exists( 'wc_get_template' ) ) {
				wc_get_template( 'loop/sale-flash.php' ); 
			}
		?>
		<?php
		//Check if the plugin is active and add icon add-to-wishlist
			if ( class_exists( 'YITH_WCWL' ) ): 
				echo do_shortcode('[yith_wcwl_add_to_wishlist label="<i class=\'fa fa-heart-o\'></i>"]');
			endif;
		?>
		<h3><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
		<?php woocommerce_template_loop_rating(); ?>
		<p><?php echo boo_get_excerpt( 36 ); ?></p>
	</div>
	<div class="col-md-2">
		<?php woocommerce_template_loop_price(); ?>
		<?php do_action( 'woocommerce_shop_loop_add_cart_list' );  ?>
	</div>
</li>