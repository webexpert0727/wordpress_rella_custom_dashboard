<?php

$item_count = count( $wishlist_items );

$browse_wishlist_text = get_option( 'yith_wcwl_browse_wishlist_text' );
$browse_wishlist_text = $browse_wishlist_text ? $browse_wishlist_text : esc_html__( 'View All', 'boo' );

global $rella_header_wishlist_trigger_size;
?>
<div class="header-module module-wishlist">
	<span class="module-trigger <?php echo $rella_header_wishlist_trigger_size ?>">
		<i class="fa fa-heart-o"></i>
		<?php echo $item_count ?>
	</span>
	<div class="module-container">
		<div class="header-wishlist-container">
			<h4>
				<?php echo $item_count ?> <?php esc_html_e( 'items in your wishlist', 'boo' ); ?>
			</h4>
			<div class="products">
			<?php
			foreach( $wishlist_items as $item ) :
                global $product;

				if( function_exists( 'wc_get_product' ) ) {
		            $product = wc_get_product( $item['prod_id'] );
	            }
	            else{
		            $product = get_product( $item['prod_id'] );
	            }

				if( $product !== false && $product->exists() ) :
			?>
				<div class="product">
					<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item['prod_id'] ) ) ) ?>">
                        <?php echo $product->get_image() ?>
						<h5><?php echo apply_filters( 'woocommerce_in_cartproduct_obj_title', $product->get_title(), $product ) ?></h5>
                    </a>
					<p><?php echo apply_filters( 'woocommerce_short_description', $product->post_excerpt ) ?></p>
					<span class="woocommerce-Price-amount amount">
						<?php
                        if( is_a( $product, 'WC_Product_Bundle' ) ){
                            if( $product->min_price != $product->max_price ){
                                echo sprintf( '%s - %s', wc_price( $product->min_price ), wc_price( $product->max_price ) );
                            }
                            else{
                                echo wc_price( $product->min_price );
                            }
                        }
                        elseif( $product->price != '0' ) {
                            echo $product->get_price_html();
                        }
                        else {
                            echo apply_filters( 'yith_free_text', esc_html__( 'Free!', 'boo' ) );
                        }
                        ?>
					</span>
					<a href="<?php echo esc_url( add_query_arg( 'remove_from_wishlist', $item['prod_id'] ) ) ?>" class="remove-product"><i class="fa fa-times"></i></a>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
			<a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ) ?>" class="btn btn-xsm btn-solid btn-block view-all weight-bold text-uppercase"><span><?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text )?><i class="fa fa-angle-right"></i></span></a>
		</div>
	</div>
</div>
