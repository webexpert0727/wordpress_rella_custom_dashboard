<?php
/**
 * Themerella Theme Framework
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'body_class', 'rella_add_body_classes' );
/**
 * [rella_add_body_classes description]
 * @method rella_add_body_classes
 * @param  [type]                 $classes [description]
 */
function rella_add_body_classes( $classes ) {

	// Header sticky class
	$id = rella_get_custom_header_id(); // which one
	if( $scroll = rella_helper()->get_post_meta( 'header-scroll-type', $id ) ) {
		$classes[] = 'header-' . $scroll;
	}

	//Progressively load classnames
	if( rella_helper()->get_option( 'enable-lazy-load' ) && !is_admin() ) {
		$classes[] = 'progressive-load-activated';
	}
	
	//Smooth scroll classnames
	if( rella_helper()->get_option( 'smooth-scroll' ) ) {
		$classes[] = 'smooth-wheel-enabled';
	}
	
	//Footer fixed
	$footer_id = rella_get_custom_footer_id();
	if( 'on' === rella_helper()->get_post_meta( 'footer-fixed', $footer_id ) ) {
		$classes[] = 'footer-fixed';	
	}

	return $classes;
}

/**
 * [rella_get_header_view description]
 * @method rella_get_header_view
 * @return [type]             [description]
 */
add_action( 'rella_header', 'rella_get_header_view' );
function rella_get_header_view() {

	//Check if is not frontend vc editor
	if( function_exists( 'vc_mode' ) && 'page_editable' === vc_mode() ) {
		return;
	}
	
	$enable = rella_helper()->get_option( 'header-enable-switch', 'raw', '' );
	// Check if header is enabled
	if( 'off' === $enable ) {
		return;
	}

	// Overlay Header
	$header_id = rella_get_custom_header_id();
	$layout    = rella_helper()->get_post_meta( 'header-layout', $header_id );
	$enable_titlebar    = rella_helper()->get_option( 'title-bar-enable', 'raw', '' );
	
	if( 'overlay' === $layout && 'on' === $enable_titlebar ){
		return;
	}

	if( $id = rella_helper()->get_option( 'header-template', 'raw', false ) ) {
		get_template_part( 'templates/header/custom' );
		return;
	}

	get_template_part( 'templates/header/default' );
}

/**
 * [rella_get_header_view description]
 * @method rella_get_header_view
 * @return [type]             [description]
 */
add_action( 'rella_header_titlebar', 'rella_get_header_titlebar_view' );
function rella_get_header_titlebar_view() {

	//Check if is not frontend vc editor
	if( function_exists( 'vc_mode' ) && 'page_editable' === vc_mode() ) {
		return;
	}

	$enable = rella_helper()->get_option( 'header-enable-switch', 'raw', '' );
	// Check if title bar is enabled
	if( 'off' === $enable ) {
		return;
	}
	
	// Overlay Header
	$header_id = rella_get_custom_header_id();
	$layout    = rella_helper()->get_post_meta( 'header-layout', $header_id );
	$layout    = $layout ? $layout : 'default';
	
	if( 'default' === $layout ){
		return;
	}

	if( $id = rella_helper()->get_option( 'header-template', 'raw', false ) ) {
		get_template_part( 'templates/header/custom' );
		return;
	}

	get_template_part( 'templates/header/default' );
}

add_action( 'rella_after_header', 'rella_get_titlebar_view' );
/**
 * [rella_get_titlebar_view description]
 * @method rella_get_titlebar_view
 * @return [type]                  [description]
 */
function rella_get_titlebar_view() {

	$enable = rella_helper()->get_option( 'title-bar-enable', 'raw', '' );
	if( is_404() || 'off' === $enable ) {
		return;
	}
	if( is_singular( 'rella-portfolio' )) {
		get_template_part( 'templates/header/header-title-bar', 'portfolio' );
		return;	
	}

	get_template_part( 'templates/header/header-title', 'bar' );
}

/**
 * [rella_get_footer_view description]
 * @method rella_get_footer_view
 * @return [type]             [description]
 */
add_action( 'rella_footer', 'rella_get_footer_view' );
function rella_get_footer_view() {
	$enable = rella_helper()->get_option( 'footer-enable-switch', 'raw', '' );
	if( 'off' === $enable ) {
		return;
	}

	if( $id = rella_helper()->get_option( 'footer-template', 'raw', false ) ) {
		get_template_part( 'templates/footer/custom' );
		return;
	}

	get_template_part( 'templates/footer/default' );
}

/**
 * [rella_custom_sidebars description]
 * @method rella_custom_sidebars
 * @return [type]                [description]
 */
add_action( 'after_setup_theme', 'rella_custom_sidebars', 9 );
function rella_custom_sidebars() {

	//adding custom sidebars defined in theme options
	$custom_sidebars = rella_helper()->get_theme_option( 'custom-sidebars' );
	$custom_sidebars = array_filter( (array)$custom_sidebars );

	if ( !empty( $custom_sidebars ) ) {

		foreach ( $custom_sidebars as $sidebar ) {

			register_sidebar ( array (
				'name' => $sidebar,
				'id' => sanitize_title( $sidebar ),
				'before_widget' => '<div id="%1$s" class="mb25 clearfix sidebar_widget widget %2$s">',
				'after_widget' => '</div>',
				'before_title'  => '<h5 class="mt25">',
				'after_title'   => '</h5>',
			) );
		}
	}
}

/**
 * Remove ver variable from enqueued scripts and css files
 * E.g. http://yourdomain/style.css?ver=1.3
 *
 * @method rella_clear_files_query_string
 * @param  [type]                         $src [description]
 * @return [type]                              [description]
 */

add_action( 'init', function(){
	if ( rella_helper()->get_theme_option( 'clear-static-files' ) ) {
		add_filter( 'script_loader_src', 'rella_clear_files_query_string', 9999 );
		add_filter( 'style_loader_src', 'rella_clear_files_query_string', 9999 );
	}
});
function rella_clear_files_query_string( $src ) {

	$src = remove_query_arg( 'ver', $src );

	return $src;
}

/**
 * Remove type and id attribute from stylesheet
 * @method rella_html5_stylesheet
 * @param  [type]                 $html   [description]
 * @param  [type]                 $handle [description]
 * @return [type]                         [description]
 */

if( current_theme_supports( 'html5', 'rella-assets' ) ) {
	add_filter( 'style_loader_tag', 'rella_html5_stylesheet', 10, 2 );
	add_filter( 'script_loader_tag', 'rella_html5_stylesheet', 10, 2 );
}
function rella_html5_stylesheet( $html, $handle ) {

	$html = str_replace(" type='text/css'", '', $html );
	$html = str_replace(" type='text/javascript'", '', $html );
    return str_replace( " id='$handle-css' ", '', $html );
}

/**
 * [rella_wpcf7_submit_button description]
 * @method rella_wpcf7_submit_button
 * @return [type]                    [description]
 */
add_action( 'wpcf7_init', 'rella_wpcf7_submit_button', 25 );
function rella_wpcf7_submit_button() {
	if( function_exists( 'wpcf7_remove_form_tag' ) ) {
		wpcf7_remove_form_tag('submit');
		wpcf7_add_form_tag( 'submit', 'rella_wpcf7_submit_shortcode_handler' );
	}
}

function rella_wpcf7_submit_shortcode_handler( $tag ) {

	$tag = new WPCF7_Shortcode( $tag );

	$class = wpcf7_form_controls_class( $tag->type );

	$atts = array();

	$atts['class'] = $tag->get_class_option( $class );
	$atts['id'] = $tag->get_id_option();
	$atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

	$value = isset( $tag->values[0] ) ? $tag->values[0] : '';

	if ( empty( $value ) )
		$value = __( 'Send', 'boo' );

	$atts['type'] = 'submit';
	//$atts['value'] = $value;

	$atts = wpcf7_format_atts( $atts );

	$html = sprintf( '<button %1$s>%2$s</button>', $atts, $value );

	return $html;
}

/**
 * [rella_nav_menu_args description]
 * @method rella_nav_menu_args
 * @param  [type]              $args [description]
 * @return [type]                    [description]
 */
add_filter( 'wp_nav_menu_args', 'rella_nav_menu_args' );
function rella_nav_menu_args( $args ) {

	$menu = rella_helper()->get_option( 'header-primary-menu' );
	if( current_theme_supports( 'theme-demo' ) && !empty( $_GET['mid'] ) ) {
		$menu = $_GET['mid'];
	}

	if( empty( $menu ) ) {
		return $args;
	}

	$args['menu'] = $menu;

	return $args;
}

/**
 * [rella_page_ajaxify description]
 * @method rella_page_ajaxify
 * @param  [type]             $template [description]
 * @return [type]                       [description]
 */
add_action( 'template_include', 'rella_page_ajaxify', 1 );
function rella_page_ajaxify( $template ) {

	if( isset( $_GET['ajaxify'] ) && $_GET['ajaxify'] ) {

		$located = locate_template( 'ajaxify.php' );

		if( '' != $located ) {
			return $located;
		}
	}

	return $template;
}

/**
 * [rella_maintenance_mode description]
 * @method rella_maintenance_mode
 * @param  [type]             $template [description]
 * @return [type]                       [description]
 */
add_action( 'template_include', 'rella_maintenance_mode', 1 );
function rella_maintenance_mode( $template ) {

	$enable = rella_helper()->get_option( 'page-maintenance-enable', 'raw', '', 'options' );
	$enable = isset( $_GET['emm'] ) ? 'on' : $enable;

	if ( is_user_logged_in() || 'off' === $enable ) {
		return $template;
	}

	$maintenance_mode = true;

	//show maintenance mode only to specific time
	if ( 'on' === rella_helper()->get_option( 'page-maintenance-mode-till', 'raw', '', 'options' ) ) {

		$date    = rella_helper()->get_option( 'page-maintenance-mode-till-date', 'raw', '', 'options' );
		$hour    = rella_helper()->get_option( 'page-maintenance-mode-till-hour', 'raw', '', 'options' );
		$minutes = rella_helper()->get_option( 'page-maintenance-mode-till-minutes', 'raw', '', 'options' );

		if ( !empty( $date ) && !empty( $hour ) && !empty( $minutes ) ) {
			$till_time = DateTime::createFromFormat('m/d/Y H:i', $date.' '.$hour.':'.$minutes);
			//don't show maintenance mode if time is in the past
			if ( current_time( 'timestamp' ) > $till_time->getTimestamp() ) {
				$maintenance_mode = false;
			}
		}
	}

	if( !$maintenance_mode ) {
		return $template;
	}

	$new_template = locate_template( array( 'tmpl-maintenance-mode.php' ) );
	if ( '' != $new_template ) {
		return $new_template;
	}

	return $template;
}

/**
 * [rella_tag_cloud_widget description]
 * @method rella_tag_cloud_widget
 * @param  [array] $args [description]
 * @return [array] [description]
 */
add_filter( 'widget_tag_cloud_args', 'rella_tag_cloud_widget' );
function rella_tag_cloud_widget( $args ) {

    $args['largest'] = 13; //largest tag
    $args['smallest'] = 13; //smallest tag
    $args['unit'] = 'px';  //tag font unit

    return $args;
}

/**
 * [rella_modify_contact_methods description]
 * @method rella_modify_contact_methods
 * @param  [type]                       $profile_fields [description]
 * @return [type]                                       [description]
 */
add_filter( 'user_contactmethods', 'rella_modify_contact_methods' );
function rella_modify_contact_methods( $profile_fields ) {

	// Add new fields
	$profile_fields['author_facebook'] = 'Facebook ';
	$profile_fields['author_twitter']  = 'Twitter';
	$profile_fields['author_linkedin'] = 'LinkedIn';
	$profile_fields['author_dribble']  = 'Dribble';
	$profile_fields['author_gplus']    = 'Google+';

	return $profile_fields;
}

add_filter( 'avatar_defaults', 'rella_gravatar' );

function rella_gravatar ( $avatar_defaults ) {

	$rella_avatar = get_template_directory_uri() . '/assets/img/rella-avatar.jpg';
	$avatar_defaults[$rella_avatar] = "Rella Gravatar";

	return $avatar_defaults;
}

/**
 * [rella_audio_shortcode_class description]
 * @method rella_audio_shortcode_class
 * @param  [type] $class [description]
 * @return [type] $class [description]
 */
add_filter( 'wp_audio_shortcode_class', 'rella_audio_shortcode_class', 1, 1 );
function rella_audio_shortcode_class( $class ) {

	$class = '';

	return $class;
}


/**
 * [rella_video_shortcode_class description]
 * @method rella_video_shortcode_class
 * @param  [type] $class [description]
 * @return [type] $class [description]
 */
add_filter( 'wp_video_shortcode_class', 'rella_video_shortcode_class', 1, 1 );
function rella_video_shortcode_class( $class ) {

	$class = '';

	return $class;
}

/**
 * [rella_add_image_placeholders description]
 * @method rella_add_image_placeholders
 * @param  [type]                       $content [description]
 */

add_action( 'init', function(){

	if( rella_helper()->get_option( 'enable-lazy-load' ) && !is_admin() ) {
		add_filter( 'wp_get_attachment_image_attributes', 'rella_filter_gallery_img_atts', 10, 2 );
	}
});
function rella_add_image_placeholders( $content ) {

	// Don't lazyload for feeds, previews, mobile
	if( is_feed() || is_preview() ) {
		return $content;
	}

	// Don't lazy-load if the content has already been run through previously
	if ( false !== strpos( $content, 'data-lazy-src' ) ) {
		return $content;
	}

	// This is a pretty simple regex, but it works
	$content = preg_replace_callback( '#<(img)([^>]+?)(>(.*?)</\\1>|[\/]?>)#si', 'rella_process_image_placeholders', $content );

	return $content;
}

/**
 * [rella_process_image_placeholders description]
 * @method rella_process_image_placeholders
 * @param  [type]                           $matches [description]
 * @return [type]                                    [description]
 */
function rella_process_image_placeholders( $matches ) {

	// In case you want to change the placeholder image
	$placeholder_image = apply_filters( 'lazyload_images_placeholder_image', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' );

	$old_attributes_str = $matches[2];
	$old_attributes = wp_kses_hair( $old_attributes_str, wp_allowed_protocols() );

	if ( empty( $old_attributes['src'] ) ) {
		return $matches[0];
	}

	// Remove src and lazy-src since we manually add them
	$new_attributes = $old_attributes;
	unset( $new_attributes['src'], $new_attributes['srcset'], $new_attributes['data-lazy-src'], $new_attributes['data-lazy-srcset'] );
	$new_attributes = wp_list_pluck( $new_attributes, 'value', 'name' );

	// LazyLoad
	$new_attributes['data-lazy-src'] = $old_attributes['src']['value'];
	if( isset( $old_attributes['srcset']['value'] ) ) {
		$new_attributes['data-lazy-srcset'] = $old_attributes['srcset']['value'];
	}

	return sprintf( '<img src="%1$s"%2$s>', $placeholder_image, rella_helper()->html_attributes( $new_attributes ) );
}

/**
 * [rella_filter_gallery_img_atts description]
 * @method rella_process_image_placeholders
 * @param  [type]             $atts [description]
 * @param  [type]             $attachment [description]
 * @return [type]            [description]
 */
function rella_filter_gallery_img_atts( $atts, $attachment ) {

		$img_data = $atts['src'];

		@list( $width, $height ) = getimagesize( $atts['src'] );

		//Check the size of the image
		if( $width < '230' ) { 
			return $atts; 
		}
		
		$atts['srcset']= '';
		if ( $small_size = wp_get_attachment_image_src( $attachment->ID, 'rella-small' ) ) {
	        if ( ! empty( $small_size[0] ) ) {
				$atts['src'] = $small_size[0];
	        }
	    }
	    
		$atts['class'] .= ' progressive__img progressive--not-loaded';
		$atts['data-progressive'] = $img_data;

    return $atts;
}

/**
 * [rella_filter_related_portfolio_img_atts description]
 * @method rella_process_image_placeholders
 * @param  [type]             $atts [description]
 * @param  [type]             $attachment [description]
 * @return [type]            [description]
 */
function rella_filter_related_portfolio_img_atts( $atts, $attachment ) {

		$img_data = $atts['src'];

		@list( $width, $height ) = getimagesize( $atts['src'] );

		//Check the size of the image
		if( $width < '230' ) { 
			return $atts; 
		}

		$atts['srcset']= '';
		if ( $small_size = wp_get_attachment_image_src( $attachment->ID, 'rella-small-pf-related' ) ) {
	        if ( ! empty( $small_size[0] ) ) {
				$atts['src'] = $small_size[0];
	        }
	    }
	    
		$atts['class'] .= ' progressive__img progressive--not-loaded';
		$atts['data-progressive'] = $img_data;

    return $atts;
}


/**
 * [rella_filter_portrait_portfolio_img_atts description]
 * @method rella_process_image_placeholders
 * @param  [type]             $atts [description]
 * @param  [type]             $attachment [description]
 * @return [type]            [description]
 */
function rella_filter_portrait_portfolio_img_atts( $atts, $attachment ) {

		$img_data = $atts['src'];

		@list( $width, $height ) = getimagesize( $atts['src'] );

		//Check the size of the image
		if( $width < '230' ) { 
			return $atts; 
		}

		$atts['srcset']= '';
		if ( $small_size = wp_get_attachment_image_src( $attachment->ID, 'rella-small-portrait' ) ) {
	        if ( ! empty( $small_size[0] ) ) {
				$atts['src'] = $small_size[0];
	        }
	    }
	    
		$atts['class'] .= ' progressive__img progressive--not-loaded';
		$atts['data-progressive'] = $img_data;

    return $atts;
}

/**
 * [rella_filter_portrait_portfolio_img_atts description]
 * @method rella_process_image_placeholders
 * @param  [type]             $atts [description]
 * @param  [type]             $attachment [description]
 * @return [type]            [description]
 */
function rella_filter_portrait_tall_portfolio_img_atts( $atts, $attachment ) {

		$img_data = $atts['src'];

		@list( $width, $height ) = getimagesize( $atts['src'] );

		//Check the size of the image
		if( $width < '230' ) { 
			return $atts; 
		}

		$atts['srcset']= '';
		if ( $small_size = wp_get_attachment_image_src( $attachment->ID, 'rella-small-portrait-tall' ) ) {
	        if ( ! empty( $small_size[0] ) ) {
				$atts['src'] = $small_size[0];
	        }
	    }
	    
		$atts['class'] .= ' progressive__img progressive--not-loaded';
		$atts['data-progressive'] = $img_data;

    return $atts;
}

/**
 * [rella_filter_portrait_portfolio_img_atts description]
 * @method rella_process_image_placeholders
 * @param  [type]             $atts [description]
 * @param  [type]             $attachment [description]
 * @return [type]            [description]
 */
function rella_filter_wide_portfolio_img_atts( $atts, $attachment ) {

		$img_data = $atts['src'];

		@list( $width, $height ) = getimagesize( $atts['src'] );

		//Check the size of the image
		if( $width < '230' ) { 
			return $atts; 
		}

		$atts['srcset']= '';
		if ( $small_size = wp_get_attachment_image_src( $attachment->ID, 'rella-small-wide' ) ) {
	        if ( ! empty( $small_size[0] ) ) {
				$atts['src'] = $small_size[0];
	        }
	    }
	    
		$atts['class'] .= ' progressive__img progressive--not-loaded';
		$atts['data-progressive'] = $img_data;

    return $atts;
}

/**
 * Allows for excerpt generation outside the loop.
 * 
 * @param string $text  The text to be trimmed
 * @return string       The trimmed text
 */
function rella_trim_excerpt( $text = '' ) {
    $text = strip_shortcodes( $text );
    $text = apply_filters( 'the_content', $text );
    $text = str_replace(']]>', ']]&gt;', $text );
    $excerpt_length = apply_filters( 'excerpt_length', 55 );
    $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );
    return wp_trim_words( $text, $excerpt_length, $excerpt_more );
}
add_filter( 'wp_trim_excerpt', 'rella_trim_excerpt' );
