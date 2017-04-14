<?php if( is_singular( 'post' ) ) : ?>

	<div class="loop-nav">
		<?php previous_post_link( '<div class="prev">' . esc_html__( 'Previous Post: %link', 'boo' ) . '</div>', '%title' ); ?>
		<?php next_post_link(     '<div class="next">' . esc_html__( 'Next Post: %link',     'boo' ) . '</div>', '%title' ); ?>
	</div><!-- .loop-nav -->

<?php elseif( at_helper()->is_plural() ) :

	// Previous/next page navigation.
	the_posts_pagination( array(
		'prev_text'          => esc_html_x( 'Previous page', 'posts navigation', 'boo' ),
		'next_text'          => esc_html_x( 'Next page', 'posts navigation', 'boo' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'boo' ) . ' </span>',
	) );

endif;
