<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

global $product;

if ( is_single( 'product' ) ): ?>
	<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" rel="nofollow" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-product-type="<?php echo esc_attr( $product_type ); ?>" class="button-o button-md button-green hover-bounce-to-right <?php echo rella_helper()->sanitize_html_classes( $link_classes ); ?>" >
		<?php echo wp_kses_post( $label ) ?>
	</a>
	
<?php else: ?>
	<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" rel="nofollow" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e( 'Add to wishlist', 'boo' ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-product-type="<?php echo esc_attr( $product_type ); ?>" class="add-to-wishlist" >
		<?php echo wp_kses_post( $label ); ?>
	</a>
<?php endif;?>