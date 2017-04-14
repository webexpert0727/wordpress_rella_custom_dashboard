<?php
/**
 * Themerella Theme Framework
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * [rella_site_title description]
 * @method rella_site_title
 * @return [type]           [description]
 */
function rella_site_title() {
	echo rella_get_site_title();
}

/**
 * [rella_get_site_title description]
 * @method rella_get_site_title
 * @return [type]               [description]
 */
function rella_get_site_title() {

	if ( $title = get_bloginfo( 'name' ) ) {
		$title = sprintf( '<h1 %s><a href="%s" rel="home">%s</a></h1>', rella_helper()->get_attr( 'site-title' ), esc_url( home_url() ), $title );
	}

	return apply_filters( 'rella_site_title', $title );
}

/**
 * [rella_site_description description]
 * @method rella_site_description
 * @return [type]                 [description]
 */
function rella_site_description() {
	echo rella_get_site_description();
}

/**
 * [rella_get_site_description description]
 * @method rella_get_site_description
 * @return [type]                     [description]
 */
function rella_get_site_description() {

	if ( $desc = get_bloginfo( 'description' ) ) {
		$desc = sprintf( '<h2 %s>%s</h2>', rella_helper()->get_attr( 'site-description' ), $desc );
	}

	return apply_filters( 'rella_site_description', $desc );
}

/**
 * [rella_get_content_template description]
 * @method rella_get_content_template
 * @return [type]                     [description]
 */
function rella_get_content_template() {

	// Set up an empty array and get the post type.
	$templates = array();
	$post_type = get_post_type();

	// Assume the theme developer is creating an attachment template.
	if ( 'attachment' === $post_type ) {

		remove_filter( 'the_content', 'prepend_attachment' );

		$type = rella_helper()->get_attachment_type();

		$templates[] = "templates/content/attachment-{$type}.php";
	}

	// If the post type supports 'post-formats', get the template based on the format.
	if ( post_type_supports( $post_type, 'post-formats' ) ) {

		// Get the post format.
		$post_format = get_post_format() ? get_post_format() : 'standard';

		// Template based off post type and post format.
		$templates[] = "templates/content/{$post_type}-{$post_format}.php";

		// Template based off the post format.
		$templates[] = "templates/content/{$post_format}.php";
	}

	// Template based off the post type.
	$templates[] = "templates/content/{$post_type}.php";

	// Fallback 'content.php' template.
	$templates[] = 'templates/content/content.php';

	// Apply filters to the templates array.
	$templates = apply_filters( 'rella_content_template_hierarchy', $templates );

	// Locate the template.
	$template = locate_template( $templates );

	// If template is found, include it.
	if ( apply_filters( 'rella_content_template', $template, $templates ) ) {
		include( $template );
	}
}
