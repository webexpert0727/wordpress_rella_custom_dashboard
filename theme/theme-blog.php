<?php
/**
 * Theme Blog class for blog posts page and blog archives
 */

class ThemeBlog extends RA_Blog {

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {
		$this->atts = array(
			'style' => rella_helper()->get_option( 'blog-style' ),
			'pagination' => rella_helper()->get_option( 'blog-pagination' ),
		);

		$this->render( $this->atts );
	}

	/**
	 * [render description]
	 * @method render
	 * @return [type] [description]
	 */
	public function render( $atts, $content = '' ) {

		extract($atts);

		// check
		$located = locate_template( "templates/blog/tmpl-$style.php" );
		if ( ! file_exists( $located ) ) {
			return;
		}

		$before = $after = '';

		echo '<div class="blog-posts ' . $style . '">';
			
			if( in_array( $style, array('default','classic-date-featured','classic-image-large','classic-image-medium','no-image','split','featured-title','only-title' ) ) ) {
				echo '<div class="row">';
				$before = '<div class="col-xs-12">';
				$after = '</div>';		
			}
			
			if( 'grid' === $style ) {
				echo '<div class="row">';
				$before = '<div class="col-md-6">';
				$after = '</div>';
			}

			if( 'puzzle' === $style ) {
				echo '<div class="row no-margin">';
				$before = '<div class="col-md-6 no-padding">';
				$after = '</div>';
			}

			if( 'timeline' === $style ) {
				$before = '<div class="col-md-5 masonry-item">';
				$after = '</div>';
				// Initialize the time stamps for timeline month/year check
				$post_count = 1;
				$prev_post_timestamp = null;
				$prev_post_month = null;
				$prev_post_year = null;
			}

			if( 'masonry' === $style || 'masonry-creative' === $style ) {
				echo '<div class="row" data-plugin-masonry="true">';
				$before = '<div class="col-md-4 col-sm-6 col-xs-12 masonry-item">';
				$after = '</div>';
			}

			while( have_posts() ): the_post();

				$post_classes = array( 'blog-post', $this->get_class( $style ) );
				$post_classes = join( ' ', get_post_class( $post_classes, get_the_ID() ) );

				$attributes = array(
					'id' => 'post-' . get_the_ID(),
					'class' => $post_classes
				);
				
				if( 'classic-image-large' === $style ) {
					$attributes['class'] = $attributes['class'] . ' post-image-large';
				}
				
				if( 'grid' === $style ) {
					$attributes['data-mh'] = 'blog-grid';
				}

				if( 'puzzle' === $style ) {
					$attributes['data-mh'] = 'post-puzzle';
				}

				if( 'timeline' === $style ) {
					$post_timestamp = get_the_time( 'U' );
					$post_month = date( 'n', $post_timestamp );
					$post_year = get_the_date( 'Y' );

					// Set the timeline month label
					if ( $prev_post_month != $post_month ||
						 $prev_post_year != $post_year
					) {

						if ( $post_count > 1 ) {
							echo '</div>';
						}
						printf( '<div class="row timeline-row" data-plugin-masonry="true"><time class="timeline-date" datatime="2016-10"><span>%s</span><div class="loader"><div class="loader-inner"></div></div></time>', get_the_date( 'M Y' ) );
					}
				}

				if( 'masonry-creative' === $style ) {
					$width = get_post_meta( get_the_ID(), 'post-width', true );
					$width = $width ? $width : 'col-md-3';
					$before = sprintf( '<div class="%s col-sm-6 col-xs-12 masonry-item no-padding">', $width );

					$height = get_post_meta( get_the_ID(), 'post-height', true );
					$height = $height ? $height : 'default';
					$attributes['data-mh'] = $height;

					if( 'tall' == $height ) {
						$attributes['class'] = $attributes['class'] . ' tall';
					}
				}

				echo $before;

				printf( '<article%s>', ra_helper()->html_attributes( $attributes ) );

					if( 'quote' === get_post_format() ) {
						$quote_located = locate_template( 'templates/blog/format-quote.php' );
						include $quote_located;
					}
					else {
						include $located;
					}

				echo '</article>';

				echo $after;

				// Adjust the timestamp settings for next loop
				if( 'timeline' === $style ) {
					$prev_post_timestamp = $post_timestamp;
					$prev_post_month = $post_month;
					$prev_post_year = $post_year;
					$post_count++;
				}

			endwhile;

			if( in_array( $style, array('default','classic-date-featured','classic-image-large','classic-image-medium','no-image','split','featured-title','only-title' ) ) ) { 
				echo '</div>';
			}

			if ( 'timeline' === $style && $post_count > 1 ) {
				echo '</div>';
			}

			if( 'grid' === $style || 'puzzle' === $style || 'masonry' === $style || 'masonry-creative' === $style ) {
				echo '</div>';
			}

			// Pagination
			if( 'pagination' === $atts['pagination'] ) {

				// Set up paginated links.
		        $links = paginate_links( array(
					'type' => 'array',
					'prev_next' => true,
					'prev_text' => '<span aria-hidden="true">' . __( '<i class="fa fa-angle-left"></i>', 'boo' ) . '</span>',
					'next_text' => '<span aria-hidden="true">' . __( '<i class="fa fa-angle-right"></i>', 'boo' ) . '</span>'
				));

				if( !empty( $links ) ) {

					printf( '<div class="blog-nav"><nav aria-label="Page navigation"><ul class="pagination"><li>%s</li></ul></nav></div>', join( "</li>\n\t<li>", $links ) );
				}

			}

			if( in_array( $atts['pagination'], array( 'ajax1', 'ajax2', 'ajax3', 'ajax4' ) ) && $url = get_next_posts_page_link( $GLOBALS['wp_query']->max_num_pages ) ) {
				$hash = array(
					'ajax1' => 'btn btn-md ajax-load-more blog-load-more',
					'ajax2' => 'btn btn-md wide border-thick circle ajax-load-more blog-load-more blog-load-more-alt text-uppercase',
					'ajax3' => 'btn btn-md ajax-load-more blog-load-more blog-load-more-block',
					'ajax4' => 'btn btn-naked ajax-load-more blog-load-more blog-load-more-huge'
				);

				$attributes = array(
					'href' => add_query_arg( 'ajaxify', '1', $url),
					'data-plugin-ajaxify' => true,
					'data-plugin-options' => json_encode( array(
						'wrapper' => '.blog-posts > .row',
						'items' => 'timeline' === $style ? '.timeline-row' : '.blog-post'
					))
				);

				echo '<div class="blog-nav blog-ajax"><nav aria-label="Page navigation">';
				switch( $atts['pagination'] ) {

					case 'ajax1':
						$attributes['class'] = 'btn btn-md ajax-load-more blog-load-more';
						printf( '<a%s><span>More Stories<i class="fa fa-angle-down"></i></span><i class="icon-arrows_clockwise loading-icon"></i></a>', ra_helper()->html_attributes( $attributes ), $url );
						break;

					case 'ajax2':
						$attributes['class'] = 'btn btn-md wide border-thick circle ajax-load-more blog-load-more blog-load-more-alt text-uppercase';
						printf( '<a%s><span>Load more</span><i class="icon-arrows_clockwise loading-icon"></i></a>', ra_helper()->html_attributes( $attributes ), $url );
						break;

					case 'ajax3':
						$attributes['class'] = 'btn btn-md ajax-load-more blog-load-more blog-load-more-block';
						printf( '<a%s><span>More Stories<i class="fa fa-angle-down"></i></span><i class="icon-arrows_clockwise loading-icon"></i></a>', ra_helper()->html_attributes( $attributes ), $url );
						break;

					case 'ajax4':
						$attributes['class'] = 'btn btn-naked ajax-load-more blog-load-more blog-load-more-huge';
						$attributes['data-fitText'] = true;
						$attributes['data-max-fontSize'] = '75px';
						printf( '<a%s><span>Read more stories<i class="fa fa-angle-down"></i></span><i class="icon-arrows_clockwise loading-icon"></i></a>', ra_helper()->html_attributes( $attributes ), $url );
						break;
				}

				echo '</nav></div>';
			}

		echo '</div>';

	}
}
new ThemeBlog;
