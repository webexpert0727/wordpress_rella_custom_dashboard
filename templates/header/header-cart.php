<?php

// check
if( ! rella_helper()->is_woocommerce_active() ) {
	return;
}

$order_count = WC()->cart->get_cart_contents_count();
$is_empty = WC()->cart->is_empty();
$sub_total = WC()->cart->get_cart_subtotal();

$icon_opts = rella_get_icon( $atts );
$icon = !empty( $icon_opts['type'] ) && !empty( $icon_opts['icon'] ) ? $icon_opts['icon'] : 'icon-flaticon-shopping-bag2';
$style = !empty( $icon_opts['color'] ) ? sprintf( ' style="color:%s;"', $icon_opts['color'] ) : '';
?>
<div class="header-module module-cart <?php echo $atts['badge_style'] ?>">
    <span class="module-trigger <?php echo $atts['trigger_size'] ?>">
		<i class="<?php echo $icon ?>"<?php echo $style ?>><?php if( $order_count && 'hide' !== $atts['count_visibility'] ) {
			printf( '<span class="badge">%d</span>', $order_count );
		}?></i>
		<?php if ( ! $is_empty && 'hide' !== $atts['amount_visibility'] ) {
			printf( ' <span%s>%s</span>', $style, $sub_total );
		} ?>
	</span>
    <div class="module-container">
        <table class="header-cart-container">
			<thead class="header">
				<tr>
					<th class="product">
						<p>
							<?php esc_html_e( 'Your Cart', 'boo' ); ?>
							<span class="items-counter"><?php echo $order_count ?></span>
						</p>
					</th>
					<th>
						<div class="module-trigger module-trigger-inner">
							<button type="button" class="navbar-toggle module-toggle" aria-expanded="false">
								<span class="sr-only">
									<?php esc_html_e( 'Toggle navigation', 'boo' ); ?>
								</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
					</th>
				</tr>
			</thead>

            <tbody class="items-container">

				<?php if ( ! $is_empty ) : ?>

					<?php

						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
								$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
								$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								?>
								<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'item mini_cart_item', $cart_item, $cart_item_key ) ); ?>">


									<?php echo WC()->cart->get_item_data( $cart_item ); ?>
									<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>

									<td class="product">
										<?php
										echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
											'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
											esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
											__( 'Remove this item', 'boo' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() )
										), $cart_item_key );
										?>
										<?php if ( ! $_product->is_visible() ) : ?>
											<figure><?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) ?></figure>
											<h5><?php echo $product_name ?></h5>
										<?php else : ?>
											<a href="<?php echo esc_url( $product_permalink ); ?>">
												<figure><?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) ?></figure>
												<h5><?php echo $product_name ?></h5>
											</a>
										<?php endif; ?>
				                    </td>
				                    <td class=counter>
				                        <span class="amount"><?php echo $product_price ?></span>
				                        <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="qty quantity">x ' . $cart_item['quantity'] . '</span>', $cart_item, $cart_item_key ); ?>
				                    </td>
								</tr>
								<?php
							}
						}
					?>

				<?php else : ?>

					<tr class="empty"><td><?php esc_html_e( 'No products in the cart.', 'boo' ); ?></td></tr>

				<?php endif; ?>

			</tbody>
			<?php if ( ! $is_empty ) : ?>

				<tfoot>
	                <tr>
	                    <td>
	                        <h5><?php esc_html_e( 'Subtotal', 'boo' ); ?></h5>
	                    </td>
	                    <td class="counter">
	                        <span class="amount"><?php echo $sub_total; ?></span>
	                    </td>
	                </tr>
	                <tr>
	                    <td>
	                        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button checkout"><span><?php esc_html_e( 'Checkout', 'boo' ); ?></span><i class="fa fa-angle-right"></i></a>
	                    </td>
	                </tr>
	            </tfoot>

			<?php endif; ?>

        </table>
    </div>
</div>

<?php

/*
	wp_enqueue_script( 'wc-cart-fragments' );
	wp_enqueue_script( 'wc-cart' );
*/

?>
