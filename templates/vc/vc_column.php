<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$el_class = $width = $css = $offset = $css_animation = $parallax = $parallax_preset = $parallax_from = $parallax_to = $parallax_time = $parallax_duration = $delay = $align = $gradient_bg = $gradient_bg_color = $bg_position = $bg_pos_h = $bg_pos_v = '';
$output = $bg_styles = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$css_classes = array(
	$this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation ),
	'wpb_column',
	'vc_column_container',
	$width,
	$align
);

if ( vc_shortcode_custom_css_has_property( $css, array(
	'border',
	'background',
) ) ) {
	$css_classes[] = 'vc_col-has-fill';
}

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
if( ! empty( $delay ) ) {
	$wrapper_attributes[] = 'data-animation-delay="' . esc_attr( $delay ) . '"';	
}

$col_styles = array();

if( 'yes' === $gradient_bg && ! empty( $gradient_bg_color ) ) {
	$bg = rella_parse_gradient( $gradient_bg_color );
	$bg_styles = 'background:' . esc_attr( $bg['background-image'] ) . '';
}
if( 'custom' != $bg_position && ! empty( $bg_position ) ) {
	$bg_styles = 'background-position:' . esc_attr( $bg_position ) . ' !important; ';
} 
elseif( 'custom' === $bg_position ) {
	$bg_styles = 'background-position:' . esc_attr( $bg_pos_h ) . ' ' . esc_attr( $bg_pos_v ) . ' !important; ';
}
$col_styles[] = 'style="' . esc_attr( trim( $bg_styles ) ) . '"';

if( 'yes' === $parallax ) {
	
	wp_enqueue_script( 'jquery-scrollmagic' );
	wp_enqueue_script( 'animation-gsap' );

	$parallax_data = $parallax_opts = array();	
	
	$wrapper_attributes[] = 'data-parallax="true"';
	$wrapper_attributes[] = 'data-smooth-transition="true"';
	
	if( 'custom' !== $parallax_preset ) {
			$parallax_data = rella_get_parallax_preset( $parallax_preset );
	} else {
		if ( ! empty( $parallax_from ) ) {
			$parallax_data['from'] = $parallax_from;
		} else {
			$parallax_data['from'] = '';
		}
		if( ! empty( $parallax_to ) ) {
			$parallax_data['to'] = $parallax_to;
		} else {
			$parallax_data['to'] = '';
		}
	}
	
	if( is_array( $parallax_data['from'] ) && ! empty( $parallax_data['from'] ) ) {
		$wrapper_attributes[] = 'data-parallax-from=' . json_encode( $parallax_data['from'] );
	} elseif( ! empty( $parallax_from ) ) {
		$wrapper_attributes[] = 'data-parallax-from=\'{' . $parallax_from . '}\'';
	}
	if( is_array( $parallax_data['to'] && ! empty( $parallax_data['to'] ) ) ) {
		$wrapper_attributes[] = 'data-parallax-to=' . json_encode( $parallax_data['to'] );
	}elseif( ! empty( $parallax_to ) ) {
		$wrapper_attributes[] = 'data-parallax-to=\'{' . $parallax_to . '}\'';
	}
	
	if( ! empty( $parallax_time ) ) {
		$parallax_opts['time'] = esc_attr( $parallax_time );
	}
	if( ! empty( $parallax_duration ) ) {
		$parallax_opts['duration'] = esc_attr( $parallax_duration );
	}
	if( ! empty( $parallax_opts ) ) {
		$wrapper_attributes[] = 'data-parallax-options=' . json_encode( $parallax_opts );
	}
	
}

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= '<div class="vc_column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) . '" ' . implode( ' ', $col_styles ) . '>';
$output .= '<div class="wpb_wrapper">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;