<?php
/**
 * The template used for displaying page content
 */
?>

<article <?php rella_helper()->attr( 'post' ) ?>>

	<?php if( 1 == 2 ) : ?>
	<header class="entry-header">
		<h1 <?php rella_helper()->attr( 'entry-title' ); ?>><?php single_post_title(); ?></h1>
	</header><!-- .entry-header -->
	<?php endif; ?>
	
	<div <?php rella_helper()->attr( 'entry-content' ); ?>>

		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'boo' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'boo' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>

	</div><!-- .entry-content -->

	<?php // edit_post_link( __( 'Edit', 'boo' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article><!-- #post-## -->
