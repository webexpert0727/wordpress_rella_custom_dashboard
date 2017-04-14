<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 */
?>

<article <?php rella_helper()->attr( 'post' ) ?>>

	<?php the_post_thumbnail(); ?>

	<?php if( is_singular() ) : ?>

		<header class="entry-header">

			<?php the_title( '<h1 '. rella_helper()->get_attr( 'entry-title' ) .'>', '</h1>' ); ?>

			<?php get_template_part( 'templates/entry', 'meta' ) ?>

		</header>

		<div <?php rella_helper()->attr( 'entry-content' ) ?>>
			<?php
				the_content( sprintf(
					__( 'Continue reading %s', 'boo' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
					) );

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'boo' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'boo' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				) );
			?>
		</div>

		<footer class="entry-footer">

			<?php rella_post_terms( array( 'taxonomy' => 'category', 'text' => esc_html__( 'Posted in %s', 'boo' ) ) ); ?>

			<?php rella_post_terms( array( 'taxonomy' => 'post_tag', 'text' => esc_html__( 'Tagged %s', 'boo' ), 'before' => '<br />' ) ); ?>

		</footer><!-- .entry-footer -->

	<?php else: ?>

		<header class="entry-header">

			<?php the_title( sprintf( '<h2 %s><a href="%s" rel="bookmark">', rella_helper()->get_attr( 'entry-title' ), esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php get_template_part( 'templates/entry', 'meta' ) ?>

		</header>

		<div <?php rella_helper()->attr( 'entry-summary' ) ?>>

			<?php the_excerpt() ?>

		</div><!-- .entry-content -->

	<?php endif; ?>

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'templates/author', 'bio' );
		endif;
	?>

</article><!-- #post-## -->
