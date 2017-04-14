<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 *
 * @var $section_type
 * @var $main_full_width
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = $css_animation = '';
$disable_element = $section_type = $main_full_width = $mainbar_style = $mainbar_color_type = $mainbar_color = $stickybar_color = $mainbar_gradient = $mainbar_container_style = '';
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$mainbar_container_style = str_replace( ',', ' ', $mainbar_container_style );

$css_classes = array(
	'vc_section',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
	$mainbar_container_style
);

if( 'default' !== $section_type ) {
	$css_classes[] = $section_type;
}

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

if ( vc_shortcode_custom_css_has_property( $css, array(
		'border',
		'background',
	) ) || $video_bg || $parallax
) {
	$css_classes[] = 'vc_section-has-fill';
}


$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	}
	$after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = 'vc_row-o-full-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_section-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_section-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$parallax_speed = $parallax_speed_bg;
if ( $has_video_bg ) {
	$parallax = $video_bg_parallax;
	$parallax_speed = $parallax_speed_video;
	$parallax_image = $video_bg_url;
	$css_classes[] = 'vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"'; // parallax speed
	$css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( false !== strpos( $parallax, 'fade' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( false !== strpos( $parallax, 'fixed' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
}

if ( ! empty( $parallax_image ) ) {
	if ( $has_video_bg ) {
		$parallax_image_src = $parallax_image;
	} else {
		$parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
		$parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
		if ( ! empty( $parallax_image_src[0] ) ) {
			$parallax_image_src = $parallax_image_src[0];
		}
	}
	$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

if( 'main-bar-container' === $section_type ) {
	if( rella_helper()->str_contains( 'sticky2', $mainbar_container_style ) ) $wrapper_attributes[] = 'data-sticky="true"';
	elseif( rella_helper()->str_contains( 'sticky', $mainbar_container_style ) ) $wrapper_attributes[] = 'data-sticky="true" data-only-visible-onsticky="true"';

	if( rella_helper()->str_contains( 'sticky', $mainbar_container_style ) && $stickybar_color ) {
		printf( '<style>.main-bar-container.headroom--not-top {background-color: %s}</style>', $stickybar_color );
	}
}
$output .= '<section ' . implode( ' ', $wrapper_attributes ) . '>';

if( 'scrollable' === $section_type ) {
	$output .= '<div data-plugin-scroll-animation="true" data-plugin-options = \'{ "seperator":".vc_row:not(.vc_inner)" }\' >';
}

if( 'secondary-bar' === $section_type ) {
	$output .= ( 'stretch_row' === $main_full_width ) ? '<div class="container-fluid">' : '<div class="container">';
}
elseif( 'main-bar-container' === $section_type ) {

	$mainbar_style = str_replace( ',', ' ', $mainbar_style );
	if( 'gradient' === $mainbar_color_type ) {
		$mainbar_gradient = rella_parse_gradient( $mainbar_gradient, 'css' );
		$mainbar_color = !$mainbar_gradient ? '' : sprintf( ' style="%s;"', $mainbar_gradient );
	}
	else {
		$mainbar_color = !$mainbar_color ? '' : sprintf( ' style="background-color: %s;"', $mainbar_color );
	}
	$output .= ( 'stretch_row' === $main_full_width ) ? '<div class="container-fluid">' : '<div class="container">';
		$output .= '<div class="row"><div class="col-md-12"><div class="main-bar '. $mainbar_style .'"'. $mainbar_color .'>';
}

$output .= wpb_js_remove_wpautop( $content );

if( 'secondary-bar' === $section_type ) {
	$output .= '</div>';
}
elseif( 'main-bar-container' === $section_type ) {
		$output .= '</div></div></div>';
	$output .= '</div>';
}


if( 'scrollable' === $section_type ) {
	$output .= '<div class="page-buttons">

					<div class="bar before">
						<div class="bar-inner"></div><!-- /.bar-inner -->
					</div><!-- /.bar before -->
	
					<div class="pagination">
						<a href="#" class="prev"><i class="fa fa-caret-up"></i></a>
						<span class="pages"><span class="active">1</span><span class="all">0</span></span>
						<a href="#" class="next"><i class="fa fa-caret-down"></i></a>
					</div>
	
					<div class="bar after">
						<div class="bar-inner"></div><!-- /.bar-inner -->
					</div><!-- /.bar after -->
	
				</div> </div>';
}

$output .= '</section>';
$output .= $after_output;

echo $output;
