<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $source
 * @var $image
 * @var $custom_src
 * @var $onclick
 * @var $img_size
 * @var $external_img_size
 * @var $caption
 * @var $img_link_large
 * @var $link
 * @var $img_link_target
 * @var $alignment
 * @var $el_class
 * @var $css_animation
 * @var $style
 * @var $external_style
 * @var $border_color
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Single_image
 */
$title = $source = $image = $custom_src = $onclick = $img_size = $external_img_size =
$caption = $img_link_large = $link = $img_link_target = $alignment = $el_class = $css_animation = $style = $external_style = $border_color = $css = $image_type = $d_effect = $stacking_factor = $enable_panr_effect = $sensitivity = $scale = $scaleonhover = $scaleduration = $scaleto = $panx = $pany = $panduration = $invisible = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$default_src = vc_asset_url( 'vc/no_image.png' );

// backward compatibility. since 4.6
if ( empty( $onclick ) && isset( $img_link_large ) && 'yes' === $img_link_large ) {
	$onclick = 'img_link_large';
} elseif ( empty( $atts['onclick'] ) && ( ! isset( $atts['img_link_large'] ) || 'yes' !== $atts['img_link_large'] ) ) {
	$onclick = 'custom_link';
}

if ( 'external_link' === $source ) {
	$style = $external_style;
	$border_color = $external_border_color;
}

$border_color = ( '' !== $border_color ) ? ' vc_box_border_' . $border_color : '';

$img = false;

switch ( $source ) {
	case 'media_library':
	case 'featured_image':

		if ( 'featured_image' === $source ) {
			$post_id = get_the_ID();
			if ( $post_id && has_post_thumbnail( $post_id ) ) {
				$img_id = get_post_thumbnail_id( $post_id );
			} else {
				$img_id = 0;
			}
		} else {
			$img_id = preg_replace( '/[^\d]/', '', $image );
		}

		// set rectangular
		if ( preg_match( '/_circle_2$/', $style ) ) {
			$style = preg_replace( '/_circle_2$/', '_circle', $style );
			$img_size = $this->getImageSquareSize( $img_id, $img_size );
		}

		if ( ! $img_size ) {
			$img_size = 'medium';
		}

		if( 'svg' === $image_type ) {
			$svg = rella_include_svg( $img_id );
			$img['thumbnail'] = file_get_contents( $svg );  
		} else {
			$img = wpb_getImageBySize( array(
				'attach_id' => $img_id,
				'thumb_size' => $img_size,
				'class' => 'vc_single_image-img'
			) );			
		}

		// don't show placeholder in public version if post doesn't have featured image
		if ( 'featured_image' === $source ) {
			if ( ! $img && 'page' === vc_manager()->mode() ) {
				return;
			}
		}

		break;

	case 'external_link':
		$dimensions = vcExtractDimensions( $external_img_size );
		$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';

		$custom_src = $custom_src ? esc_attr( $custom_src ) : $default_src;
		
		if( 'svg' === $image_type ) {
			$img = array(
				'thumbnail' => '<object data="' . $custom_src . '" type="image/svg+xml"><img class="vc_single_image-img" ' . $hwstring . ' src="' . $custom_src . '" /></object>',
			);
		} else {
			$img = array(
				'thumbnail' => '<img class="vc_single_image-img" ' . $hwstring . ' src="' . $custom_src . '" ' . $data_stacking . ' />',
			);			
		}

		break;

	default:
		$img = false;
}

if ( ! $img ) {
	$img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" ' . $data_stacking . ' src="' . $default_src . '" />';
}

$el_class = $this->getExtraClass( $el_class );

// backward compatibility
if ( vc_has_class( 'prettyphoto', $el_class ) ) {
	$onclick = 'link_image';
}

// backward compatibility. will be removed in 4.7+
if ( ! empty( $atts['img_link'] ) ) {
	$link = $atts['img_link'];
	if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link ) ) {
		$link = 'http://' . $link;
	}
}

// backward compatibility
if ( in_array( $link, array( 'none', 'link_no' ) ) ) {
	$link = '';
}

$a_attrs = array();

switch ( $onclick ) {
	case 'img_link_large':

		if ( 'external_link' === $source ) {
			$link = $custom_src;
		}
		else {
			$link = wp_get_attachment_image_src( $img_id, 'large' );
			$link = $link[0];
			if ( 'lightbox' ===  $img_link_target ) {
				$a_attrs['data-type'] = 'image';
			}
		}

		break;

	case 'link_image':
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );

		$a_attrs['class'] = 'prettyphoto';
		$a_attrs['data-rel'] = 'prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']';

		// backward compatibility
		if ( vc_has_class( 'prettyphoto', $el_class ) ) {
			// $link is already defined
		} elseif ( 'external_link' === $source ) {
			$link = $custom_src;
		} else {
			$link = wp_get_attachment_image_src( $img_id, 'large' );
			$link = $link[0];
		}

		break;

	case 'custom_link':
		// $link is already defined
		break;

	case 'zoom':
		wp_enqueue_script( 'vc_image_zoom' );

		if ( 'external_link' === $source ) {
			$large_img_src = $custom_src;
		} else {
			$large_img_src = wp_get_attachment_image_src( $img_id, 'large' );
			if ( $large_img_src ) {
				$large_img_src = $large_img_src[0];
			}
		}

		$img['thumbnail'] = str_replace( '<img ', '<img data-vc-zoom="' . $large_img_src . '" ', $img['thumbnail'] );

		break;
}

$d_effect_data = $data_stacking = '';
if( 'yes' === $d_effect ) {
	$d_effect_data = 'data-hover3d="true"';
	$data_stacking = ! empty( $stacking_factor ) ? 'data-stacking-factor="' . esc_attr( $stacking_factor ) .'"' : 'data-stacking-factor="0.1"';
	$img['thumbnail'] = str_replace( '<img ', '<img ' . $data_stacking . ' ', $img['thumbnail'] );
}

// add rjs to image
$retina_image = wp_get_attachment_image_src( $img_id, $img_size . '@2x' );
$img['thumbnail'] = str_replace( '<img ', '<img data-rjs="' . $retina_image[0] . '" ', $img['thumbnail'] );

if( 'yes' === $enable_panr_effect ) {

	wp_enqueue_script( 'jquery-panr' );
	
	$panr_options = array();

	$panr_options['sensitivity'] = esc_attr( $sensitivity );
	$panr_options['scaleDuration'] = esc_attr( $scaleduration );
	$panr_options['scaleTo'] = esc_attr( $scaleto );
	$panr_options['panDuration'] = esc_attr( $panduration );
	
	$panr_options['scale'] = ! empty( $scale ) ? true : false;
	$panr_options['scaleOnHover'] = ! empty( $scaleonhover ) ? true : false;
	
	$panr_options['panX'] = ! empty( $panx ) ? true : false;
	$panr_options['panY'] = ! empty( $pany ) ? true : false;
	
	$img['thumbnail'] = str_replace( '<img ', '<img data-panr="true" data-plugin-options=' . json_encode( $panr_options ) . ' ', $img['thumbnail'] );	
}


// backward compatibility
if ( vc_has_class( 'prettyphoto', $el_class ) ) {
	$el_class = vc_remove_class( 'prettyphoto', $el_class );
}

$wrapperClass = 'vc_single_image-wrapper ' . $style . ' ' . $border_color;

if ( $link && 'lightbox' != $img_link_target ) {

	$a_attrs['href'] = $link;
	$a_attrs['target'] = $img_link_target;
	if ( ! empty( $a_attrs['class'] ) ) {
		$wrapperClass .= ' ' . $a_attrs['class'];
		unset( $a_attrs['class'] );
	}

	$html = '<a ' . vc_stringify_attributes( $a_attrs ) . ' class="' . $wrapperClass . '">' . $img['thumbnail'] . '</a>';

} 
elseif ( $link && 'lightbox' === $img_link_target ) {

	if ( empty( $a_attrs['data-type'] ) ) {
		$a_attrs['data-type'] = 'video';		
	}
	$a_attrs['href'] = $link;
	$a_attrs['class'] = 'lightbox-link';
	if ( ! empty( $a_attrs['class'] ) ) {
		$wrapperClass .= ' ' . $a_attrs['class'];
		unset( $a_attrs['class'] );
	}

	$html = $img['thumbnail'];	
	$html .= '<a ' . vc_stringify_attributes( $a_attrs ) . ' class="' . $wrapperClass . '"><i class="fa fa-expand"></i></a>';
	
}
else {
	$html = '<div class="' . $wrapperClass . '">' . $img['thumbnail'] . '</div>';
}

$lightbox_class = '';
if( 'lightbox' === $img_link_target ) {
	$lightbox_class = ' lightbox-image ';
}

$class_to_filter = 'wpb_single_image wpb_content_element vc_align_' . $alignment . ' ' . $this->getCSSAnimation( $css_animation );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class . $lightbox_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

if( $invisible ) {
	$css_class .= ' invisible ';
}

if ( in_array( $source, array( 'media_library', 'featured_image' ) ) && 'yes' === $add_caption ) {
	$post = get_post( $img_id );
	$caption = $post->post_excerpt;
} else {
	if ( 'external_link' === $source ) {
		$add_caption = 'yes';
	}
}

if ( 'yes' === $add_caption && '' !== $caption ) {
	$html .= '<figcaption class="vc_figure-caption">' . esc_html( $caption ) . '</figcaption>';
}

$output = '
	<div class="' . esc_attr( trim( $css_class ) ) . '" ' . $d_effect_data . '>
		' . wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) ) . '
		<figure class="wpb_wrapper vc_figure">
			' . $html . '
		</figure>
	</div>
';

echo $output;
