<?php
/**
 * Themerella Theme Framework
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

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
 * [rella_attributes_comment description]
 * @method rella_attributes_comment
 * @param  [type]                   $attributes [description]
 * @return [type]                               [description]
 */
add_filter( 'rella_attr_comment', 'rella_attributes_comment', 5 );
function rella_attributes_comment( $attributes ) {

	$attributes['id']    = 'comment-' . get_comment_ID();
	$attributes['class'] = join( ' ', get_comment_class() );

	if ( in_array( get_comment_type(), array( '', 'comment' ) ) ) {

		$attributes['itemprop']  = 'comment';
		$attributes['itemscope'] = 'itemscope';
		$attributes['itemtype']  = 'http://schema.org/Comment';
	}

	return $attributes;
}

/**
 * [rella_attributes_comment_author description]
 * @method rella_attributes_comment_author
 * @param  [type]                          $attributes [description]
 * @return [type]                                      [description]
 */
add_filter( 'rella_attr_comment-author', 'rella_attributes_comment_author', 5 );
function rella_attributes_comment_author( $attributes ) {

	$attributes['class']     = 'comment-author';
	$attributes['itemprop']  = 'author';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/Person';

	return $attributes;
}

/**
 * [rella_attributes_comment_published description]
 * @method rella_attributes_comment_published
 * @param  [type]                             $attributes [description]
 * @return [type]                                         [description]
 */
add_filter( 'rella_attr_comment-published', 'rella_attributes_comment_published', 5 );
function rella_attributes_comment_published( $attributes ) {

	$attributes['class']    = 'comment-published';
	$attributes['datetime'] = get_comment_time( 'Y-m-d\TH:i:sP' );

	// Translators: Comment date/time "title" attribute.
	$attributes['title']    = get_comment_time( _x( 'l, F j, Y, g:i a', 'comment time format', 'boo' ) );
	$attributes['itemprop'] = 'datePublished';

	return $attributes;
}

/**
 * [rella_attributes_comment_permalink description]
 * @method rella_attributes_comment_permalink
 * @param  [type]                             $attributes [description]
 * @return [type]                                         [description]
 */
add_filter( 'rella_attr_comment-permalink', 'rella_attributes_comment_permalink', 5 );
function rella_attributes_comment_permalink( $attributes ) {

	$attributes['class']    = 'comment-permalink';
	$attributes['href']     = get_comment_link();
	$attributes['itemprop'] = 'url';

	return $attributes;
}

/**
 * [rella_attributes_comment_content description]
 * @method rella_attributes_comment_content
 * @param  [type]                           $attributes [description]
 * @return [type]                                       [description]
 */
add_filter( 'rella_attr_comment-content', 'rella_attributes_comment_content', 5 );
function rella_attributes_comment_content( $attributes ) {

	$attributes['class']    = 'comment-content';
	$attributes['itemprop'] = 'text';

	return $attributes;
}

// 2. Functions ------------------------------------------------------
//

/**
 * [rella_comments_callback description]
 * @method rella_comments_callback
 * @param  [type]                  $comment [description]
 * @return [type]                           [description]
 */
function rella_comments_callback( $comment ) {

	// Get the comment type of the current comment.
	$comment_type = get_comment_type( $comment->comment_ID );

	// Create an empty array if the comment template array is not set.
	if ( ! isset( rella()->comment_template ) || ! is_array( rella()->comment_template ) ) {
		rella()->comment_template = array();
	}

	// Check if a template has been provided for the specific comment type.  If not, get the template.
	if ( ! isset( rella()->comment_template[ $comment_type ] ) ) {

		// Create an array of template files to look for.
		$templates = array( "templates/comment/{$comment_type}.php" );

		// If the comment type is a 'pingback' or 'trackback', allow the use of 'comment-ping.php'.
		if ( 'pingback' == $comment_type || 'trackback' == $comment_type ) {
			$templates[] = 'templates/comment/ping.php';
		}

		// Add the fallback 'comment.php' template.
		$templates[] = 'templates/comment/comment.php';

		// Allow devs to filter the template hierarchy.
		$templates = apply_filters( 'rella_comment_template_hierarchy', $templates, $comment_type );

		// Locate the comment template.
		$template = locate_template( $templates );

		// Set the template in the comment template array.
		rella()->comment_template[ $comment_type ] = $template;
	}

	// If a template was found, load the template.
	if ( ! empty( rella()->comment_template[ $comment_type ] ) ) {
		require( rella()->comment_template[ $comment_type ] );
	}
}

// 3. Template Tags --------------------------------------------------
//

/**
 * [rella_comment_reply_link description]
 * @method rella_comment_reply_link
 * @param  array                    $args [description]
 * @return [type]                         [description]
 */
function rella_comment_reply_link( $args = array() ) {
	echo rella_get_comment_reply_link( $args );
}

/**
 * [rella_get_comment_reply_link description]
 * @method rella_get_comment_reply_link
 * @param  array                        $args [description]
 * @return [type]                             [description]
 */
function rella_get_comment_reply_link( $args = array() ) {

	if ( ! get_option( 'thread_comments' ) || in_array( get_comment_type(), array( 'pingback', 'trackback' ) ) ) {
		return '';
	}

	$args = wp_parse_args(
		$args,
		array(
			'depth'     => intval( $GLOBALS['comment_depth'] ),
			'max_depth' => get_option( 'thread_comments_depth' ),
		)
	);

	return get_comment_reply_link( $args );
}
