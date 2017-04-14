<?php
/**
 * Themerella Theme Framework
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * [rella_attributes_head description]
 * @method rella_attributes_head
 * @param  [type]                $attributes [description]
 * @return [type]                            [description]
 */
add_filter( 'rella_attr_head', 'rella_attributes_head' );
function rella_attributes_head( $attributes ) {

	unset( $attributes['class'] );
	if ( ! is_front_page() ) {
		return $attributes;
	}

	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WebSite';

	return $attributes;
}

/**
 * [rella_attributes_body description]
 * @method rella_attributes_body
 * @param  [type]                $attributes [description]
 * @return [type]                            [description]
 */
add_filter( 'rella_attr_body', 'rella_attributes_body' );
function rella_attributes_body( $attributes ) {

	$attributes['class']     = join( ' ', get_body_class() );
	$attributes['dir']       = is_rtl() ? 'rtl' : 'ltr';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WebPage';

	if ( is_singular( 'post' ) || is_home() || is_archive() ) {
		$attributes['itemtype'] = 'http://schema.org/Blog';
	}

	if ( is_search() ) {
		$attributes['itemtype'] = 'http://schema.org/SearchResultsPage';
	}

	return $attributes;
}

/**
 * [rella_attributes_menu description]
 * @method rella_attributes_menu
 * @return [type]                [description]
 */
add_filter( 'rella_attr_menu', 'rella_attributes_menu' );
function rella_attributes_menu( $attributes ) {

	$attributes['role']  = 'navigation';

	if ( $attributes['location'] ) {

		$menu_name = rella_helper()->get_menu_location_name( $attributes['location'] );

		if ( $menu_name ) {
			// Translators: The %s is the menu name. This is used for the 'aria-label' attribute.
			$attributes['aria-label'] = esc_attr( sprintf( _x( '%s', 'nav menu aria label', 'boo' ), $menu_name ) );
		}
	}
	unset( $attributes['location'] );

	$attributes['itemscope']  = 'itemscope';
	$attributes['itemtype']   = 'http://schema.org/SiteNavigationElement';

	return $attributes;
}


/**
 * [rella_attributes_content description]
 * @method rella_attributes_content
 * @param  [type]                   $attributes [description]
 * @return [type]                               [description]
 */
add_filter( 'rella_attr_content', 'rella_attributes_content' );
function rella_attributes_content( $attributes ) {

	$attributes['id'] = 'content';
	$attributes['role'] = 'main';

	if ( ! is_singular( 'post' ) && ! is_home() && ! is_archive() ) {
		$attributes['itemprop'] = 'mainContentOfPage';
	}

	return $attributes;

}
