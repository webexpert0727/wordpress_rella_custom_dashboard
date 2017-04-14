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
 * [at_meta_mobile_app description]
 * @method at_meta_mobile_app
 * @return [type]             [description]
 */
add_action( 'wp_head', 'rella_meta_mobile_app', 0 );
function rella_meta_mobile_app() {

	echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
	echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
	printf( '<meta name="apple-mobile-web-app-title" content="%s - %s">' . "\n", esc_html( get_bloginfo('name') ), esc_html( get_bloginfo('description') ) );
}

/**
 * [rella_meta_name_url description]
 * @method rella_meta_name_url
 * @return [type]          [description]
 */
add_action( 'wp_head', 'rella_meta_name_url', 1 );
function rella_meta_name_url() {

	if ( ! is_front_page() ) {
		return;
	}

	printf( '<meta itemprop="name" content="%s" />' . "\n", get_bloginfo( 'name' ) );
	printf( '<meta itemprop="url" content="%s" />' . "\n", trailingslashit( home_url() ) );
}

/**
 * [rella_meta_pingback description]
 * @method rella_meta_pingback
 * @return [type]              [description]
 */
add_action( 'wp_head', 'rella_meta_pingback', 0 );
function rella_meta_pingback() {

	if ( 'open' === get_option( 'default_ping_status' ) ) {
		echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />' . "\n";
	}
}

/**
 * [rella_load_favicon description]
 * @method rella_load_favicon
 * @return [type]             [description]
 */
add_action( 'wp_head', 'rella_load_favicon' );
function rella_load_favicon() {
?>
	<link rel="shortcut icon" href="<?php rella_helper()->get_option_e( 'favicon.url', 'url', get_template_directory_uri() . '/favicon.ico') ?>" />
	<?php
	if ( $icon = rella_helper()->get_option( 'iphone_icon.url' ) ) : ?>
		<!-- For iPhone -->
		<link rel="apple-touch-icon-precomposed" href="<?php echo $icon ?>">
	<?php endif;

	if ( $icon = rella_helper()->get_option( 'iphone_icon_retina.url' ) ) : ?>
		<!-- For iPhone 4 Retina display -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $icon ?>">
	<?php endif;

	if ( $icon = rella_helper()->get_option( 'ipad_icon.url' ) ) : ?>
		<!-- For iPad -->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $icon ?>">
	<?php endif;

	if ( $icon = rella_helper()->get_option( 'ipad_icon_retina.url' ) ) : ?>
		<!-- For iPad Retina display -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $icon ?>">
	<?php endif;
}

/**
 * [rella_output_advance_code description]
 * @method rella_output_advance_code
 * @return [type]                  [description]
 */
add_action( 'wp_head', 'rella_output_advance_code', 999 );
function rella_output_advance_code() {

	echo rella_helper()->get_theme_option( 'google_analytics' );

	echo rella_helper()->get_theme_option( 'space_head' );
}

/**
 * Add skiplinks for screen readers and keyboard navigation
 */
add_action( 'rella_before', 'rella_skip_links', 1 );
function rella_skip_links() {

	// Determine which skip links are needed
	$links = array();

	if ( has_nav_menu( 'primary' ) ) {
		$links['primary'] =  __( 'Skip to primary navigation', 'boo' );
	}

	$links['content'] = __( 'Skip to content', 'boo' );

	// write HTML, skiplinks in a list with a heading
	$skiplinks  =  '<section>';
	$skiplinks .=  '<h2 class="screen-reader-text">'. __( 'Skip links', 'boo' ) .'</h2>';
	$skiplinks .=  '<ul class="rella-skip-link screen-reader-text">';

	// Add markup for each skiplink
	foreach ($links as $key => $value) {
		$skiplinks .=  '<li><a href="' . esc_url( '#' . $key ) . '" class="screen-reader-shortcut"> ' . $value . '</a></li>';
	}

	$skiplinks .=  '</ul>';
	$skiplinks .=  '</section>' . "\n";

	echo $skiplinks;
}

/**
 * [rella_attributes_header description]
 * @method rella_attributes_header
 * @param  [type]                  $attributes [description]
 * @return [type]                              [description]
 */
add_filter( 'rella_attr_header', 'rella_attributes_header' );
function rella_attributes_header( $attributes ) {

	if( !isset( $attributes['id'] ) || empty( $attributes['id'] ) ) {
		$attributes['id'] = 'header';
	}

	$attributes['class'] = !empty( $attributes['class'] ) ? 'header site-header ' . $attributes['class'] : 'header site-header';
	$attributes['role'] = 'banner';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WPHeader';

	return $attributes;

}


add_filter( 'rella_attr_archive-header', 'rella_attributes_archive_header' );
/**
 * [rella_attributes_archive_header description]
 * @method rella_attributes_archive_header
 * @param  [type]              $attributes [description]
 * @return [type]                          [description]
 */
function rella_attributes_archive_header( $attributes ) {

	$attributes['class'] = 'page-header archive-header';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WebPageElement';

	return $attributes;
}


add_filter( 'rella_attr_archive-title', 'rella_attributes_archive_title' );
/**
 * [rella_attributes_archive_title description]
 * @method rella_attributes_archive_title
 * @param  [type]              $attributes [description]
 * @return [type]                          [description]
 */
function rella_attributes_archive_title( $attributes ) {

	$attributes['class']     = 'archive-title';
	$attributes['itemprop']  = 'headline';

	return $attributes;
}


add_filter( 'rella_attr_archive-description', 'rella_attributes_archive_description' );
/**
 * [rella_attributes_archive_description description]
 * @method rella_attributes_archive_description
 * @param  [type]              $attributes [description]
 * @return [type]                          [description]
 */
function rella_attributes_archive_description( $attributes ) {

	$attributes['class']     = 'archive-description';
	$attributes['itemprop']  = 'text';

	return $attributes;
}

// 2. Functions ------------------------------------------------------
//

/**
 * [rella_get_custom_header_id description]
 * @method rella_get_custom_header_id
 * @return [type]                     [description]
 */
function rella_get_custom_header_id() {
	
	// which one
	$id = rella_helper()->get_option( 'header-template' );
	if( current_theme_supports( 'theme-demo' ) && !empty( $_GET['h'] ) ) {
		$id = $_GET['h'];
	}

	return $id;
}

/**
 * [rella_print_custom_header_css description]
 * @method rella_print_custom_header_css
 * @return [type]                        [description]
 */
add_action( 'wp_head', 'rella_print_custom_header_css', 1001 );
function rella_print_custom_header_css() {

	echo rella_helper()->get_vc_custom_css( rella_get_custom_header_id() );
}

// 3. Template Tags --------------------------------------------------
//

function rella_get_custom_header( $post_id = 0 ) {

	if( ! $post_id ) {
		return;
	}
}
