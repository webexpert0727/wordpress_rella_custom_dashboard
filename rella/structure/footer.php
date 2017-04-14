<?php
/**
 * Themerella Theme Framework
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Table of content
 *
 * 1. Hooks
 * 2. Functions
 * 3. Template Tags
 */

// 1. Hooks ------------------------------------------------------
//

/**
 * [rella_output_space_body description]
 * @method rella_output_space_body
 * @return [type]                  [description]
 */
add_action( 'wp_footer', 'rella_output_space_body', 999 );
function rella_output_space_body() {

	echo rella_helper()->get_theme_option( 'space_body' );
}

/**
 * [rella_attributes_footer description]
 * @method rella_attributes_footer
 * @param  [type]                  $attributes [description]
 * @return [type]                              [description]
 */
add_filter( 'rella_attr_footer', 'rella_attributes_footer' );
function rella_attributes_footer( $attributes ) {

	$attributes['id'] = 'footer';
	$attributes['class'] = !empty( $attributes['class'] ) ? 'main-footer site-footer ' . $attributes['class'] : 'main-footer site-footer';
	$attributes['role'] = 'contentinfo';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WPFooter';
	
	global $post;
	
	// which one
	$id = rella_get_custom_footer_id();
	if( 'on' === rella_helper()->get_post_meta( 'footer-fixed', $id ) ) {
		$attributes['data-fixed']  = true;	
	}

	return $attributes;

}

/**
 * [rella_footer_backtotop description]
 * @method rella_footer_backtotop
 * @return [type]                 [description]
 */
add_action( 'rella_after_footer', 'rella_footer_backtotop' );
function rella_footer_backtotop() {
	
	$enable = rella_helper()->get_theme_option( 'enable-go-top' );
	if( ! $enable ) {
		return;
	}
		
	$atts = array(
		'after'    => '</div>',
		'before'   => '<div class="local-scroll site-backtotop">',
		'href'     => '#wrap',
		'nofollow' => true,
		'text'     => __( 'Return to top of page', 'boo' ),
	);
	$atts = apply_filters( 'rella_footer_backtotop_defaults', $atts );

	$nofollow = $atts['nofollow'] ? 'rel="nofollow"' : '';

	printf( '%s<a href="%s" %s>%s</a>%s', $atts['before'], esc_url( $atts['href'] ), $nofollow, $atts['text'], $atts['after'] );
}

// 2. Functions ------------------------------------------------------
//

/**
 * [rella_get_custom_footer_id description]
 * @method rella_get_custom_footer_id
 * @return [type]                     [description]
 */
function rella_get_custom_footer_id() {

	// which one
	$id = rella_helper()->get_option( 'footer-template' );
	if( current_theme_supports( 'theme-demo' ) && !empty( $_GET['f'] ) ) {
		$id = $_GET['f'];
	}

	return $id;
}

/**
 * [rella_print_custom_footer_css description]
 * @method rella_print_custom_footer_css
 * @return [type]                        [description]
 */
add_action( 'wp_head', 'rella_print_custom_footer_css', 1001 );
function rella_print_custom_footer_css() {

	echo rella_helper()->get_vc_custom_css( rella_get_custom_footer_id() );
}

// 3. Template Tags --------------------------------------------------
//
