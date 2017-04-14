<?php
$style = rella_helper()->get_option( 'post-style', 'default' );
$format = get_post_format();
if( current_theme_supports( 'theme-demo' ) && !empty( $_GET['ps'] ) ) {
	$style = $_GET['ps'];
}
if( 'video' === $format ){
	$style = 'cover';
}
elseif( 'audio' === $format ){
	$style = 'minimal';
}

if( 'default' === $style && 'gallery' === $format ) :

?>
<?php 

	$gallery = rella_helper()->get_option( 'post-gallery' );
	if ( is_array( $gallery ) ) {
		wp_enqueue_script( 'flickity' );
		$retina_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

?>
	<figure class="post-image hmedia">
		<div class="carousel-container carousel-parallax carousel-nav-style4">
			<div class="carousel-items">
				
			<?php
				foreach ( $gallery as $item ) {
					if ( isset ( $item['attachment_id'] ) ) {
			?>
				<div class="carousel-item">
					<?php echo wp_get_attachment_image( $item['attachment_id'], 'full', false, array( 'alt' => esc_attr( $item['title'] ), 'data-rjs' => $retina_image[0] ) ); ?>
				</div><!-- /.carousel-item -->
			<?php
					}
				}
			?>

			</div><!-- /.carousel-items -->
			<div class="carousel-nav">
				<button class="flickity-prev-next-button previous"><i class="fa fa-angle-left"></i></button>
				<button class="flickity-prev-next-button next"><i class="fa fa-angle-right"></i></button>
			</div><!-- /.carousel-nav -->

		</div><!-- /.carousel-container -->

		<?php the_tags( '<div class="tags">', _x( ', ', 'Used between list items, there is a space after the comma.', 'boo' ), '</div>' ); ?>

	</figure><!-- /.main-image -->
<?php } ?>
<?php

	elseif( 'default' === $style ) :
	
?>
	<figure class="post-image hmedia">
	<?php
		$retina_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'rella-thumbnail-post@2x' );
		the_post_thumbnail( 'rella-thumbnail-post', array( 'data-rjs' => $retina_image[0] ) );
		the_tags( '<div class="tags">', _x( ', ', 'Used between list items, there is a space after the comma.', 'boo' ), '</div>' );
	?>
	</figure>

<?php else : ?>

	<?php 

	switch( $format ) {
		case 'video':
	
	?>
	<div class="post-video">
	<?php 
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
					'align'        => true,
					'width'        => true,
					'height'       => true,
					'frameborder'  => true,
					'name'         => true,
					'src'          => true,
					'id'           => true,
					'class'        => true,
					'style'        => true,
					'scrolling'    => true,
					'marginwidth'  => true,
					'marginheight' => true,
				);

				echo wp_kses( $video, $my_allowed );
			}
			
		?>
	</div>
	<?php
		
		break;
		default;
		case 'image':	 

		wp_enqueue_script( 'jquery-scrollmagic' );
		wp_enqueue_script( 'animation-gsap' );
		
		if( rella_helper()->get_option( 'enable-lazy-load' ) ) {
			$url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'rella-small' );
		} else {
			$url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		}

	?>
		<figure class="post-image hmedia" style="background-image: url(<?php echo $url[0] ?>);" data-parallax-bg="true" data-parallax-options='{ "y": "-20%", "opacity": 1 }'>
			<?php 
				$retina_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				the_post_thumbnail( 'full', array( 'data-rjs' => $retina_image[0] ) ); 
			?>
		</figure><!-- /.main-image -->	
	<?php 
		
		break;
	} 
	
	?>
	
<?php endif; ?>