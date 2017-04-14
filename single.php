<?php
/**
 * The template for displaying all single posts.
 *
 * @package base-theme
 */

get_header();

	while ( have_posts() ) : the_post();
		
		//get value from options
		$style = rella_helper()->get_option( 'post-style', 'default' );
		
		//if empty style get default
		if( !$style ) {
			$style = 'default';
		}

		$format = get_post_format();
		if( 'video' === $format ){
			$style = 'cover';
		}
		elseif( 'audio' === $format ){
			$style = 'minimal';
		}
		if( current_theme_supports( 'theme-demo' ) && !empty( $_GET['ps'] ) ) {
			$style = $_GET['ps'];
		}
		get_template_part( 'templates/blog/single/' . $style );

	endwhile;

get_footer();