<?php
/**
 * The Template Tags
 */

/**
 * [rella_get_header_layout description]
 * @method rella_get_header_layout
 * @return [type]                  [description]
 */
function rella_get_header_layout() {
	global $post;

	// which one
	$id = rella_get_custom_header_id();
	$header = get_post( $id );
	$post = $header;

	// Hash
	$header_styles = array(
		'default'	=> 'main-header navbar navbar-default',
		'overlay'	=> 'main-header navbar navbar-default header-overlay'
	);

	// layout
	$layout = rella_helper()->get_post_meta( 'header-layout', $id );
	$layout = $layout ? $layout : 'default';

	// Classes
	$class = $header_styles[$layout];

	// Attributes
	$attributes = array(
		'class' => $class,
		'data-wait-for-images' => 'true'
	);

	// Styles
	$nav = rella_helper()->get_option( 'nav_typography' );
	if( (isset( $nav['google'] ) && 'false' === $nav['google']) || 1 === count($nav) ) {
		$nav = rella_helper()->get_theme_option( 'nav_typography' );
	}

	$out = array(
		'id' => $id,
		'attributes' => $attributes,
		'layout' => $layout,

		// Styles
		'typography' => $nav,
		'color' => rella_helper()->get_option( 'nav_color' ),
		'secondary_color' => rella_helper()->get_option( 'nav_secondary_color' ),
		'active_color' => rella_helper()->get_option( 'nav_active_color' ),
		'padding' => rella_helper()->get_option( 'nav_padding' ),
		'logo_padding' => get_post_meta( $id, 'nav_logo_padding', true )
	);

	// reset
	wp_reset_postdata();
	return $out;
}

/**
 * [rella_get_footer_layout description]
 * @method rella_get_footer_layout
 * @return [type]                  [description]
 */
function rella_get_footer_layout() {
	global $post;

	// which one
	$id = rella_get_custom_footer_id();
	$footer = get_post( $id );
	$post = $footer;


	// Styles
	$styles = array();
	if( $image = rella_helper()->get_post_meta( 'footer-bg-img', $id ) ) {
		$out['background-image'] = 'url('.$image['url'].')';
	}
	if( $bg = rella_helper()->get_post_meta( 'footer-bg', $id ) ) {
		$out['background-color'] = $bg;
	}
	if( $color = rella_helper()->get_option( 'footer-text-color', $id ) ) {
		if( $color['alpha'] < 1  ) {
			$out['color'] = $color['rgba'];
		} else {
			$out['color'] = $color['color'];
		}
	}
	if( $padding = rella_helper()->get_post_meta( 'footer-padding', $id ) ) {
		$out['padding'] = $padding;
	}
	if( $link = rella_helper()->get_post_meta( 'footer-link-color', $id ) ) {
		$out['link'] = $link;
	}

	$out = array_filter( $out );

	$out['id'] = $id;

	// reset
	wp_reset_postdata();

	return $out;
}

/**
 * [rella_portfolio_media description]
 * @method rella_portfolio_media
 * @return [type]                [description]
 */
function rella_portfolio_media( $args = array() ) {

	if ( post_password_required() || is_attachment() ) {
		return;
	}

	$defaults = array(
		'before' => '',
		'after' => '',
		'image_class' => 'portfolio-image'
	);
	extract( wp_parse_args( $args, $defaults ) );

	$format = get_post_format();
	$style = get_post_meta( get_the_ID(), 'portfolio-style', true );
	$style = $style ? $style : 'gallery-stacked';

	// Audio
	if( 'audio' === $format && $audio = rella_helper()->get_option( 'post-audio' ) ) {

		printf( '<div class="post-audio">%s</div>', do_shortcode( '[audio src="' . $audio . '"]' ) );
	}

	// Gallery
	elseif( 'gallery' === $format && $gallery = rella_helper()->get_option( 'post-gallery' ) ) {
		if ( is_array( $gallery ) ) {

			if( in_array( $style, array( 'gallery-stacked', 'gallery-stacked-2', 'gallery-stacked-3', 'gallery-stacked-6' ) ) ) {

				foreach ( $gallery as $item ) {

					if ( !isset ( $item['attachment_id'] ) ) {
						continue;
					}

					$attachment = get_post( $item['attachment_id'] );

					echo $before. '<figure class="'. $image_class .'">' ;
						echo '<div class="overlay"></div>';
						echo wp_get_attachment_image( $item['attachment_id'], 'large', false, array(
							'alt' => get_the_title(),
							'data-adaptive-background' => 'true',
							'data-ab-parent' => 'false',
							'data-ab-sibling' => '.overlay'
						));
						if( $attachment->post_excerpt ) {
							printf( '<figcaption><span>%s</span></figcaption>', $attachment->post_excerpt );
						}
					echo '</figure>' . $after;
				}
			}
			elseif( in_array( $style, array( 'gallery-stacked-5' ) ) ) {

				echo '<div class="row">';

				$before = '<div class="col-md-12">';
				$after ='</div>';
				$image_class = 'portfolio-image mb-30';

				foreach ( $gallery as $item ) {

					if ( !isset ( $item['attachment_id'] ) ) {
						continue;
					}

					$attachment = get_post( $item['attachment_id'] );

					echo $before. '<figure class="'. $image_class .'">' ;
						echo '<div class="overlay"></div>';
						echo wp_get_attachment_image( $item['attachment_id'], 'large', false, array(
							'alt' => get_the_title(),
							'data-adaptive-background' => 'true',
							'data-ab-parent' => 'false',
							'data-ab-sibling' => '.overlay'
						));
						if( $attachment->post_excerpt ) {
							printf( '<figcaption><span>%s</span></figcaption>', $attachment->post_excerpt );
						}
					echo '</figure>' . $after;

					// Not first
					$before = '<div class="col-md-6">';
					$image_class = 'portfolio-image';
				}

				echo '</div>';
			}
			elseif( in_array( $style, array( 'masonry' ) ) ) {

				echo '<div class="row" data-plugin-masonry="true">';

					foreach ( $gallery as $item ) {

						if ( !isset ( $item['attachment_id'] ) ) {
							continue;
						}

						$attachment = get_post( $item['attachment_id'] );

						echo $before. '<div class="col-md-4 masonry-item"><figure class="'. $image_class .'">' ;
							echo '<div class="overlay"></div>';
							echo wp_get_attachment_image( $item['attachment_id'], 'large', false, array(
								'alt' => get_the_title(),
								'data-adaptive-background' => 'true',
								'data-ab-parent' => 'false',
								'data-ab-sibling' => '.overlay'
							));
							if( $attachment->post_excerpt ) {
								printf( '<figcaption><span>%s</span></figcaption>', $attachment->post_excerpt );
							}
						echo '</figure></div>' . $after;
					}

				echo '</div>';
			}
			elseif( 'gallery-slider' === $style ) {

				echo '<div class="carousel-container carousel-nav-style6">';

					echo '<div class="row carousel-items js-flickity" data-flickity-options=\'{ "initialIndex": 2, "draggable": "false", "prevNextButtons": "false", "pageDots": true,"contain": true, "wrapAround": true, "cellAlign": "center"   }\'>';

						foreach ( $gallery as $item ) {
							if ( isset ( $item['attachment_id'] ) ) {
								printf( '<div class="col-md-8">%s</div>', wp_get_attachment_image( $item['attachment_id'], 'large', false, array( 'alt' => esc_attr( $item['title'] ) ) ) );
							}
						}

					echo '</div>';

					echo '<div class="carousel-nav"><div class="row"><div class="col-md-8 col-md-offset-2"><button class="flickity-prev-next-button previous"><i class="fa fa-angle-left"></i></button><button class="flickity-prev-next-button next"><i class="fa fa-angle-right"></i></button></div></div></div>';

				echo '</div>';
			}
			elseif( 'gallery-slider-4' === $style ) {

				echo '<div id="gallery-1" class="carousel-container carousel-parallax carousel-nav-style6 gallery gallery-style3 gallery-with-thumb">';

					echo '<div class="carousel-items slides js-flickity" data-flickity-options=\'{ "prevNextButtons": false, "pageDots": false, "contain": true, "selectedAttraction": 0.03, "friction": 0.3, "adaptiveHeight": true}\'>';

						foreach ( $gallery as $item ) {
							if ( isset ( $item['attachment_id'] ) ) {
								echo '<figure>';

									echo wp_get_attachment_image( $item['attachment_id'], 'large', false, array( 'alt' => esc_attr( $item['title'] ) ) );

									if( $attachment->post_excerpt ) {
										printf( '<div class="caption caption-style2"><h4>%s</h4></div>', $attachment->post_excerpt );
									}

								echo '</figure>';
							}
						}

					echo '</div>'; // images

					echo '<div class="thumbs row js-flickity" data-flickity-options=\'{ "asNavFor": "#gallery-1 .slides", "contain": true, "prevNextButtons": false, "pageDots": false }\'>';

						foreach ( $gallery as $item ) {
							if ( isset ( $item['attachment_id'] ) ) {
								echo '<div class="col-md-2 col-sm-3 col-xs-6"><figure>';

									echo wp_get_attachment_image( $item['attachment_id'], array( 170, 120 ), false, array( 'alt' => esc_attr( $item['title'] ) ) );

								echo '</figure></div>';
							}
						}

					echo '</div>'; // thumbs

					echo '<div class="carousel-nav"><button class="flickity-prev-next-button previous"><i class="fa fa-angle-left"></i></button><button class="flickity-prev-next-button next"><i class="fa fa-angle-right"></i></button></div>';

				echo '</div>';
			}
			elseif( 'gallery-slider-2' === $style || 'gallery-slider-3' === $style ) {

				echo 'gallery-slider-3' === $style ? '<div class="carousel-container carousel-parallax carousel-nav-style6">' : '<div class="carousel-container carousel-nav-style6">';

					echo '<div class="row carousel-items js-flickity" data-flickity-options=\'{ "prevNextButtons": "false", "pageDots": true, "contain": true, "adaptiveHeight": true  }\'>';

						foreach ( $gallery as $item ) {
							if ( isset ( $item['attachment_id'] ) ) {
								printf( '<div class="col-md-12">%s</div>', wp_get_attachment_image( $item['attachment_id'], 'large', false, array( 'alt' => esc_attr( $item['title'] ) ) ) );
							}
						}

					echo '</div>';

					echo '<div class="carousel-nav"><button class="flickity-prev-next-button previous"><i class="fa fa-angle-left"></i></button><button class="flickity-prev-next-button next"><i class="fa fa-angle-right"></i></button></div>';

				echo '</div>';
			}
		}
	}

	// Video
	elseif( 'video' === $format ) {
		$video = '';
		if( $url = rella_helper()->get_option( 'post-video-url', 'url' ) ) {
			global $wp_embed;
			echo $wp_embed->run_shortcode( '[embed]' . $url . '[/embed]' );
		}
		elseif( $file = rella_helper()->get_option( 'post-video-file' ) ) {
			if( rella_helper()->str_contains( '[embed', $file ) ) {
				global $wp_embed;
				echo $wp_embed->run_shortcode( $file );
			} else {
				echo do_shortcode( $file );
			}
		}
		else {
			$video = rella_helper()->get_option( 'post-video-html' );
		}

		if( '' != $video ) {
			$my_allowed = wp_kses_allowed_html( 'post' );

			// iframe
			$my_allowed['iframe'] = array(
				'align' => true,
				'width' => true,
				'height' => true,
				'frameborder' => true,
				'name' => true,
				'src' => true,
				'id' => true,
				'class' => true,
				'style' => true,
				'scrolling' => true,
				'marginwidth' => true,
				'marginheight' => true,
			);

			echo wp_kses( $video, $my_allowed );
		}

	}

	else {

		$attachment = get_post( get_post_thumbnail_id() );

		echo $before. '<figure class="'. $image_class .'">' ;
			echo '<div class="overlay"></div>';
			the_post_thumbnail( 'large', array(
				'alt' => get_the_title(),
				'data-adaptive-background' => 'true',
				'data-ab-parent' => 'false',
				'data-ab-sibling' => '.overlay'
			));
			if( $attachment->post_excerpt ) {
				printf( '<figcaption><span>%s</span></figcaption>', $attachment->post_excerpt );
			}
		echo '</figure>' . $after;
	}
}

/**
 * [rella_portfolio_meta description]
 * @method rella_portfolio_meta
 * @param  [type]               $key   [description]
 * @param  [type]               $label [description]
 * @return [type]                      [description]
 */
function rella_portfolio_meta( $key, $label, $col = 6 ) {

	$value = get_post_meta( get_the_ID(), 'portfolio-' . $key, true );
	if( !$value ) {
		return;
	}
	?>
	<div class="col-md-<?php echo $col ?>">

		<p>
			<strong class="info-title"><?php echo $label ?>:</strong> <?php echo $value ?>
		</p>

	</div>
	<?php
}

/**
 * [rella_portfolio_atts description]
 * @method rella_portfolio_date
 * @return [type]               [description]
 */
function rella_portfolio_atts( $col = 6 ) {

	$atts = get_post_meta( get_the_ID(), 'portfolio-attributes', true );
	if( ! is_array( $atts ) ) {
		return;
	}
	foreach ( $atts as $attr ) {

		if( ! empty( $attr ) ) {
			$attr = explode( "|", $attr );
			$label = isset( $attr[0] ) ? $attr[0] : '';
			$value = isset( $attr[1] ) ? $attr[1] : $label;
		?>
		<div class="col-md-<?php echo $col ?>">
			<p>
				<?php if( $label ) { ?><strong class="info-title"><?php echo esc_html( $label ) ?>:</strong><?php } ?> <?php echo esc_html( $value ); ?>
			</p>
		</div>
		<?php

		}
	}
}

/**
 * [rella_portfolio_date description]
 * @method rella_portfolio_date
 * @return [type]               [description]
 */
function rella_portfolio_date( $col = 6 ) {

	if( 'off' === rella_helper()->get_option( 'portfolio-enable-date' ) ) {
		return;
	}

	$label = rella_helper()->get_option( 'portfolio-date-label' ) ? rella_helper()->get_option( 'portfolio-date-label' ) : esc_html__( 'Date', 'boo' );
	$date = rella_helper()->get_option( 'portfolio-date' ) ? rella_helper()->get_option( 'portfolio-date' ) : get_the_date();
	?>
	<div class="col-md-<?php echo $col ?>">
		<p>
			<?php if( $label ) { ?><strong class="info-title"><?php echo esc_html( $label ) ?>:</strong><?php } ?> <?php echo $date ?>
		</p>
	</div>
	<?php
}

/**
 * [rella_portfolio_likes description]
 * @method rella_portfolio_likes
 * @return [type]                [description]
 */
function rella_portfolio_likes( $class = 'portfolio-likes style-alt', $post_type = 'portfolio' ) {

	$option_name = str_replace( 'rella-', '', $post_type ) . '-likes-';
	if( 'off' === rella_helper()->get_option( $option_name . 'enable' ) ) {
		return;
	}

	the_likes_button(array(
		'container' => 'div',
		'container_class' => $class,
		'format' => __( '<span><i class="fa fa-heart"></i> <span class="post-likes-count">%s</span></span>', 'boo' )
	));
}

/**
 * [rella_portfolio_share description]
 * @method rella_portfolio_share
 * @return [type]                [description]
 */
function rella_portfolio_share( $post_type = 'post', $args = array() ) {

	$option_name = str_replace( 'rella-', '', $post_type ) . '-social-box-';
	if( 'off' === rella_helper()->get_option( $option_name . 'enable' ) ) {
		return;
	}

	$defaults = array(
		'class' => 'social-icon circle scheme-gray bordered',
		'before' => '',
		'after' => '',
		'style' => 'icon'
	);
	extract( wp_parse_args( $args, $defaults ) );

	$hash = array(
		'fb' => array(
			'icon' => '<i class="fa fa-facebook"></i>',
			'label' => 'Facebook'
		),
		'tw' => array(
			'icon' => '<i class="fa fa-twitter"></i>',
			'label' => 'Twitter'
		),
		'pin' => array(
			'icon' => '<i class="fa fa-pinterest-p"></i>',
			'label' => 'Pinterest'
		),
		'go' => array(
			'icon' => '<i class="fa fa-google"></i>',
			'label' => 'Google'
		),
		'li' => array(
			'icon' => '<i class="fa fa-linkedin"></i>',
			'label' => 'Linkedin'
		)
	);

	$url = esc_url( get_the_permalink() );
	$pinterest_image = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );

	echo $before;
	?>
	<ul class="<?php echo $class ?>">
		<li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url ?>"><?php echo $hash['fb'][$style] ?></a></li>
		<li><a target="_blank" href="https://twitter.com/home?status=<?php echo $url ?>"><?php echo $hash['tw'][$style] ?></a></li>
		<?php if( ! empty( $pinterest_image ) ):?>
		<li><a target="_blank" href="https://pinterest.com/pin/create/button/?url=&amp;media=<?php echo esc_url( $pinterest_image ); ?>&amp;description=<?php echo urlencode( get_the_title() ); ?>"><?php echo $hash['pin'][$style] ?></a></li>
		<?php endif; ?>
		<li><a target="_blank" href="https://plus.google.com/share?url=<?php echo $url ?>"><?php echo $hash['go'][$style] ?></a></li>
		<li><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url ?>&amp;title=<?php echo get_the_title(); ?>&amp;source=<?php echo get_bloginfo( 'name' ); ?>"><?php echo $hash['li'][$style] ?></a></li>
	</ul>
	<?php

	echo $after;
}

/**
 * [rella_render_related_posts description]
 * @method rella_render_related_posts
 * @param  string                     $post_type [description]
 * @return [type]                                [description]
 */
function rella_render_related_posts( $post_type = 'post' ) {

	$folder = str_replace( 'rella-', '', $post_type );
	$option_name = $folder . '-related-';
	if( 'off' === rella_helper()->get_option( $option_name . 'enable' ) ) {
		return;
	}

	$heading = rella_helper()->get_option( $option_name . 'title', 'html' );
	$number_of_posts = rella_helper()->get_option( $option_name . 'number' );
	$number_of_posts = '0' == $number_of_posts ? '-1' : $number_of_posts;
	$taxonomy = 'post' === $post_type ? 'category' : $post_type . '-category';

	$related_posts = rella_get_post_type_related_posts( get_the_ID(), $number_of_posts, $post_type, $taxonomy );

	if( $related_posts && $related_posts->have_posts() ) {
		$located = locate_template( array(
			'templates/related-'. $folder .'.php',
			'templates/related-posts.php'
		) );

		if( $located ) require $located;
	}
}

/**
 * [rella_get_post_type_related_posts description]
 * @method rella_get_post_type_related_posts
 * @param  [type]                            $post_id      [description]
 * @param  integer                           $number_posts [description]
 * @param  string                            $post_type    [description]
 * @param  string                            $taxonomy     [description]
 * @return [type]                                          [description]
 */
function rella_get_post_type_related_posts( $post_id, $number_posts = 6, $post_type = 'post', $taxonomy = 'category' ) {

	if( 0 == $number_posts ) {
		return false;
	}

	$item_array = array();
	$item_cats = get_the_terms( $post_id, $taxonomy );
	if ( $item_cats ) {
		foreach( $item_cats as $item_cat ) {
			$item_array[] = $item_cat->term_id;
		}
	}

	if( empty( $item_array ) ) {
		return false;
	}

	$args = array(
		'post_type'				=> $post_type,
		'posts_per_page'		=> $number_posts,
		'post__not_in'			=> array( $post_id ),
		'meta_key'				=> '_thumbnail_id',
		'ignore_sticky_posts'	=> 0,
		'tax_query'				=> array(
			array(
				'field'		=> 'id',
				'taxonomy'	=> $taxonomy,
				'terms'		=> $item_array
			)
		)
	);

	return new WP_Query( $args );
}

/**
 * [rella_render_post_nav description]
 * @method rella_render_post_nav
 * @param  string                $post_type [description]
 * @return [type]                           [description]
 */
function rella_render_post_nav( $post_type = 'post' ) {

	$post_type = str_replace( 'rella-', '', $post_type );
	if( 'off' === rella_helper()->get_option( $post_type . '-navigation-enable' ) ) {
		return;
	}

	$post_type = 'post' === $post_type ? 'blog' : $post_type;
	get_template_part( 'templates/'. $post_type .'/single/navigation' );
}

/**
 * [rella_portfolio_the_content description]
 * @method rella_portfolio_the_content
 * @return [type]                      [description]
 */
function rella_portfolio_the_content() {

	$content = get_post_meta( get_the_ID(), 'portfolio-description', true );
	if( $content ) {
		echo apply_filters( 'the_content', $content );
		return;
	}

	$content = get_the_content();
	if( rella_helper()->str_contains( '[vc_row', $content ) ) {
		return;
	}

	the_content( sprintf(
		__( 'Continue reading %s', 'boo' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	) );
}

/**
 * [rella_portfolio_the_excerpt description]
 * @method rella_portfolio_the_content
 * @return [type]                      [description]
 */
function rella_portfolio_the_excerpt() {

	$excerpt = get_post_meta( get_the_ID(), 'portfolio-description', true );
	if( $excerpt ) {
		$excerpt = apply_filters( 'get_the_excerpt', $excerpt );
		$excerpt = apply_filters( 'the_excerpt', $excerpt );
		echo $excerpt;
		return;
	}

	$excerpt = get_the_excerpt();
	if( rella_helper()->str_contains( '[vc_row', $excerpt ) ) {
		return;
	}

	the_excerpt( sprintf(
		__( 'Continue reading %s', 'boo' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	) );
}


/**
 * [rella_portfolio_the_vc description]
 * @method rella_portfolio_the_vc
 * @return [type]                 [description]
 */
function rella_portfolio_the_vc() {

	$content = get_the_content();
	if( !rella_helper()->str_contains( '[vc_row', $content ) ) {
		return;
	}

	the_content( sprintf(
		__( 'Continue reading %s', 'boo' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	) );
}

/**
 * [rella_author_link description]
 * @method rella_author_link
 * @param  array             $args [description]
 * @return [type]                  [description]
 */
function rella_author_link( $args = array() ) {

	global $authordata;
    if ( ! is_object( $authordata ) ) {
        return;
    }

	$defaults = array(
		'before' => '<i class="fa fa-user"></i> ',
		'after' => ''
	);
	extract( wp_parse_args( $args, $defaults ) );

	$link = sprintf(
        '<a class="url fn" href="%1$s" title="%2$s" rel="author">%3$s</a>',
        esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
        esc_attr( sprintf( esc_html__( 'Posts by %s', 'boo' ), get_the_author() ) ),
        $before . get_the_author() . $after
    );
	?>
	<span <?php rella_helper()->attr( 'entry-author', array( 'class' => 'vcard author' ) ); ?>>
		<?php echo $link ?>
	</span>
	<?php
}

/**
 * [rella_author_role description]
 * @method rella_author_role
 * @return [type]            [description]
 */
function rella_author_role() {

	global $authordata;
    if ( ! is_object( $authordata ) ) {
        return;
    }

	$user = new WP_User( $authordata->ID );
    return array_shift( $user->roles );
}
