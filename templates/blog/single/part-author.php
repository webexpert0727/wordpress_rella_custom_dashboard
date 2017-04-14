<?php
/**
 * The template for displaying Author bios
 */

if( 'off' === rella_helper()->get_option( 'post-author-box-enable' ) ) {
	return;
}

// Initialize needed variables
global $authordata;
$author_id = is_object( $authordata ) ? $authordata->ID : -1;
?>
<div class="post-author">

	<h4 class="author-heading"><?php esc_html_e( 'About Author', 'boo' ); ?></h4>

	<div class="author-info">

		<figure class="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 85 ); ?>
		</figure>

		<div class="info-container author-description">

			<h6><?php rella_author_link(array(
				'before' => '',
			)) ?> , <?php echo rella_author_role() ?></h6>

			<ul class="social-icon">
				<?php if ( get_the_author_meta( 'author_facebook', $author_id ) ) : ?>
					<li>
						<a href="<?php echo esc_url( get_the_author_meta( 'author_facebook', $author_id ) ) ?>"><i class="fa fa-facebook"></i></a>
					</li>
				<?php endif; ?>
				<?php if ( get_the_author_meta( 'author_twitter', $author_id ) ) : ?>
					<li>
						<a href="<?php echo esc_url( get_the_author_meta( 'author_twitter', $author_id ) ) ?>"><i class="fa fa-twitter"></i></a>
					</li><?php endif; ?>
				<?php if ( get_the_author_meta( 'author_gplus', $author_id ) ) : ?>
					<li>
						<a href="<?php echo esc_url( get_the_author_meta( 'author_gplus', $author_id ) ) ?>"><i class="fa fa-google"></i></a>
					</li>
				<?php endif; ?>
				<?php if ( get_the_author_meta( 'author_linkedin', $author_id ) ) : ?>
					<li>
						<a href="<?php echo esc_url( get_the_author_meta( 'author_linkedin', $author_id ) ) ?>"><i class="fa fa-linkedin"></i></a>
					</li>
				<?php endif; ?>
				<?php if ( get_the_author_meta( 'author_dribble', $author_id ) ) : ?>
					<li>
						<a href="<?php echo esc_url( get_the_author_meta( 'author_dribble', $author_id ) ) ?>"><i class="fa fa-dribbble"></i></a>
					</li>
				<?php endif; ?>
			</ul>

			<?php if( get_the_author_meta( 'description', $author_id ) ) : ?>
				<p><?php the_author_meta( 'description' ); ?></p>
			<?php endif; ?>

		</div><!-- /.info-container -->

	</div><!-- author-info -->

</div><!-- /.post-author -->
