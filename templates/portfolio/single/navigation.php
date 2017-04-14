<?php
$prev_post = get_adjacent_post( true, '', true, 'rella-portfolio-category' );
$next_post = get_adjacent_post( true, '', false, 'rella-portfolio-category' );

$style = get_post_meta( get_the_ID(), 'portfolio-style', true );
$style = $style ? $style : 'gallery-stacked';

$attributes = array(
	'class' => 'portfolio-nav'
);

if( in_array( $style, array( 'gallery-stacked-4' ) ) ) {
	$attributes['class'] = 'portfolio-nav bordered mb-50';
}

if( in_array( $style, array( 'gallery-slider', 'gallery-stacked-4', 'gallery-stacked-5', 'gallery-stacked-6', 'featured-image' ) ) ) {
	$attributes['style'] = 'background-color: #fff;';
}
?>
<div<?php echo rella_helper()->html_attributes( $attributes )  ?>>

	<div class="container">

		<div class="row">

			<div class="col-sm-3">
			<?php if( $prev_post ): ?>
				<a href="<?php echo get_permalink( $prev_post ) ?>" class="prev btn btn-xxsm semi-round text-uppercase">
					<?php if( has_post_thumbnail( $prev_post ) ) : ?>
					<span class="image-container">
						<?php echo get_the_post_thumbnail( $prev_post, array( 100, 100 ) ) ?>
					</span>
					<?php endif; ?>
					<span><i class="fa fa-angle-left"></i> <?php esc_html_e( 'Prev', 'boo' ) ?></span>
				</a>
			<?php endif; ?>
			</div><!-- //.com-md-3 -->

			<div class="col-sm-6">
				<a href="<?php echo get_post_type_archive_link( 'rella-portfolio' ) ?>" class="portfolio-view-all"><span></span></a>
			</div><!-- //.com-md-6 -->

			<div class="col-sm-3">
			<?php if( $next_post ): ?>
				<a href="<?php echo get_permalink( $next_post ) ?>" class="next btn btn-xxsm semi-round text-uppercase">
					<?php if( has_post_thumbnail( $next_post ) ) : ?>
					<span class="image-container">
						<?php echo get_the_post_thumbnail( $next_post, array( 100, 100 ) ) ?>
					</span>
					<?php endif; ?>
					<span><?php esc_html_e( 'Next', 'boo' ) ?> <i class="fa fa-angle-right"></i></span>
				</a>
			<?php endif; ?>
			</div><!-- //.com-md-3 -->

		</div>

	</div>

</div>
