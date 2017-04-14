<?php
/**
 * General functions used to integrate this theme with WooCommerce.
 *
 * @package boo
 */

/**
 * Custom heading for loop product
 * @return string
 */
if ( ! function_exists( 'rella_woocommerce_template_loop_product_title' ) ) {
	function rella_woocommerce_template_loop_product_title() {
		echo '<h3>' . get_the_title() . '</h3>';
	}
}

/**
 * Add custom woocommerce template part for list loop
 * @return void
 */
if ( ! function_exists( 'rella_woocommerce_add_to_cart_list' ) ) {
	function rella_woocommerce_add_to_cart_list() {
		wc_get_template( 'loop/add-to-cart-list.php' );
	}
}

/**
 * Add custom woocommerce template part for carousel loop
 * @return void
 */
if ( ! function_exists( 'rella_woocommerce_add_to_cart_carousel' ) ) {
	function rella_woocommerce_add_to_cart_carousel() {
		wc_get_template( 'loop/add-to-cart-carousel.php' );
	}
}

/**
 * Add custom woocommerce template part for elegant loop
 * @return void
 */
if ( ! function_exists( 'rella_woocommerce_add_to_cart_elegant' ) ) {
	function rella_woocommerce_add_to_cart_elegant() {
		wc_get_template( 'loop/add-to-cart-elegant.php' );
	}
}

/**
 * Add custom woocommerce template part single product
 * @return void
 */
if ( ! function_exists( 'rella_woocommerce_template_single_cats' ) ) {
	function rella_woocommerce_template_single_cats() {
		wc_get_template( 'single-product/cats-and-tags.php' );
	}
}

/**
 * Add custom woocommerce template part single product
 * @return void
 */
if ( ! function_exists( 'rella_woocommerce_variations_quantity_input' ) ) {
	function rella_woocommerce_variations_quantity_input() {
		wc_get_template( 'single-product/add-to-cart/quantity-input.php' );
	}
}

/**
 * Add custom woocommerce template part single product
 * @return void
 */
if ( ! function_exists( 'rella_woocommerce_add_availability' ) ) {
	function rella_woocommerce_add_availability() {
		wc_get_template( 'single-product/availability.php' );
	}
}

/**
 * Add 'woocommerce' class to the body tag
 * @param  array $classes
 * @return array $classes modified to include 'woocommerce' class
 */
if ( ! function_exists( 'rella_woocommerce_body_class' ) ) {
	function rella_woocommerce_body_class( $classes ) {
		if ( get_post_meta( get_the_ID(), '_wp_page_template', true ) == 'page-templates/shop.php' ) {
	
			$classes[] = 'woocommerce';
		}
	
		return $classes;
	}
}

/**
 * Default loop columns on product archives
 * @return integer products per row
 * @since  1.0.0
 */
if ( ! function_exists( 'rella_loop_columns' ) ) {
	function rella_loop_columns() {
		$columns = rella_helper()->get_option( 'ra_woo_columns', '3' );	
		return $columns; // products per row
	}
}

/**
 * Default related loop columns on single product
 * @return integer columns per row
 * @since  1.0.0
 */
if ( ! function_exists( 'rella_related_loop_columns' ) ) {
	function rella_related_loop_columns() {
		$columns = rella_helper()->get_option( 'ra_woo_related_columns', '4' );	
		return $columns; // products per row
	}
}

/**
 * Default up-sell loop columns on single product
 * @return integer columns per row
 * @since  1.0.0
 */
if ( ! function_exists( 'rella_upsell_loop_columns' ) ) {
	function rella_upsell_loop_columns() {
		$columns = rella_helper()->get_option( 'ra_woo_related_columns', '4' );	
		return $columns; // products per row
	}
}

/**
 * Get default posts per page value
 * @return int
 */
function rella_wc_get_current_posts_per_page_value( $force_value = null ) {	
	$posts_per_page = get_query_var( 'postsperpage' );
	if ( empty( $posts_per_page ) ) {

		if ( $force_value != null && intval( $force_value ) ) {
			$posts_per_page = $force_value;
		} else {
			$posts_per_page = rella_helper()->get_option( 'ra_woo_products_per_page', '12' );
			if ( empty( $posts_per_page ) ) {
				$posts_per_page = get_option( 'posts_per_page' );
			}
		}
	}
	return intval( $posts_per_page );
}

/**
 * Limit post on products archive
 * @return type
 */
function rella_wc_limit_archive_posts_per_page() {
	return rella_wc_get_current_posts_per_page_value();
}

/**
 * Add postsperpage var to custom query
 * @param array $vars
 * @return string
 */
function rella_wc_add_custom_query_var( $vars ){
  $vars[] = "postsperpage";
  return $vars;
}

/**
 * Get values to post per pages dropdown list
 * @return type
 */
function rella_wc_get_posts_per_page_dropdown_values( $add_value = null ) {
  
	$current_value = rella_wc_get_current_posts_per_page_value( $add_value );

	$values = array( 10,20,30,40,50,60,70,80,90,100 );

	if ( ! in_array( $current_value, $values ) ) {
		$values[] = $current_value;
		sort( $values );
	}

	if ( ! in_array( $add_value, $values ) ) {
		$values[] = $add_value;
		sort( $values );
	}

	$defined_posts_per_page = intval( rella_helper()->get_option( 'ra_woo_products_per_page' ) );
	if ( ! empty( $defined_posts_per_page ) &&  ! in_array( $defined_posts_per_page, $values ) ) {
		$values[] = rella_helper()->get_option( 'ra_woo_products_per_page' );
		sort( $values );
	}

	return $values;
}

/**
 * Custom woocommerce order by array
 * @param array $sortby
 * @return array
 */

function rella_woocommerce_catalog_orderby( $sortby ) {
	
	$sortby = array(
		'menu_order' => esc_html__( 'Default Order', 'boo' ),
		'popularity' => esc_html__( 'Popularity', 'boo' ),
		'rating'     => esc_html__( 'Average rating', 'boo' ),
		'date'       => esc_html__( 'Newness', 'boo' ),
		'price'      => esc_html__( 'Lowest Price', 'boo' ),
		'price-desc' => esc_html__( 'Highest Price', 'boo' )
	);
	
	return $sortby;
}

/**
 * Define woocommerce image sizes
 */
function rella_woocommerce_setup() {
	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}

	$catalog = array(
		'width'  => '250', // px
		'height' => '358', // px
		'crop'   => 1      // true
	);

	$single = array(
		'width'  => '500', // px
		'height' => '760', // px
		'crop'   => 1      // true
	);

	$thumbnail = array(
		'width'  => '50', // px
		'height' => '72', // px
		'crop'   => 1     // true
	);

	// Image sizes
	update_option( 'shop_catalog_image_size',   $catalog );   // Product category thumbs
	update_option( 'shop_single_image_size',    $single );    // Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs
	update_option( 'yith_wcwl_button_position', 'shortcode' );
}

/**
 * Empty the cart
 * @global object $woocommerce
 */
function rella_woocommerce_clear_cart_url() {
  global $woocommerce;
	
	if ( is_object( $woocommerce ) && isset( $_GET['empty-cart'] ) ) {
		$woocommerce->cart->empty_cart();
		$url = $woocommerce->cart->get_cart_url();
		if ( empty( $url ) ) {
			$url = get_permalink( wc_get_page_id( 'shop' ) );
		}
		wp_redirect( esc_url($url) );
	}
}

/**
 * Get current products list view type
 * @return string
 */
function rella_woocommerce_get_products_list_view_type() {
	
	if ( isset( $_GET['view'] ) && in_array( $_GET['view'], array( 'list', 'grid' ) ) ) {
		return $_GET['view'];
	}
	return rella_helper()->get_option( 'shop-products-list-view' );
}

/**
* WP Core doens't let us change the sort direction for invidual orderby params - http://core.trac.wordpress.org/ticket/17065
*
* This lets us sort by meta value desc, and have a second orderby param.
*
* @param array $args
* @return array
*/
function rella_woocommerce_order_by_popularity_post_clauses( $args ) {

	global $wpdb;
	$args['orderby'] = "$wpdb->postmeta.meta_value+0 DESC, $wpdb->posts.post_date DESC";
	return $args;
}

/**
* order_by_rating_post_clauses function.
*
* @param array $args
* @return array
*/
function rella_woocommerce_order_by_rating_post_clauses( $args ) {

	global $wpdb;
	$args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";
	$args['where'] .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";
	$args['join'] .= "
	   LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
	   LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
	";
	$args['orderby'] = "average_rating DESC, $wpdb->posts.post_date DESC";
	$args['groupby'] = "$wpdb->posts.ID";

	return $args;
};
