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

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>
<li <?php post_class(); ?>>

	<div class="product-image-container">
		<?php 
			the_post_thumbnail( 'rella-woo-elegant' );
		?>
		<?php woocommerce_show_product_loop_sale_flash(); ?>
	</div>

	<?php do_action( 'rella_woocommerce_loop_add_to_cart_elegant' );  ?>
	<a class="woocommerce-LoopProduct-link" href="<?php the_permalink(); ?>">
		<h3><?php the_title(); ?></h3>
		<?php woocommerce_template_loop_price(); ?>
		<?php woocommerce_template_loop_rating(); ?>
	</a>
	
	<?php //Check if the plugin is active and add icon add-to-wishlist
		if ( class_exists( 'YITH_WCWL' ) ): 
			echo do_shortcode('[yith_wcwl_add_to_wishlist label="<i class=\'fa fa-heart-o\'></i>"]');
		endif; 
	?>
	<a href="<?php the_permalink(); ?>" class="product-zoom"><i class="fa fa-search"></i></a>



</li>