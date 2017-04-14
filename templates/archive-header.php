<header <?php rella_helper()->attr( 'archive-header' ) ?>>

	<?php if ( ! is_front_page() && rella_helper()->is_plural() ) : ?>

		<h1 <?php rella_helper()->attr( 'archive-title' ) ?>><?php the_archive_title(); ?></h1>

		<?php if ( ! is_paged() && $desc = get_the_archive_description() ) : // Check if we're on page/1. ?>
			<div <?php rella_helper()->attr( 'archive-description' ); ?>>
				<?php echo $desc; ?>
			</div><!-- .archive-description -->
		<?php endif; // End paged check. ?>

	<?php elseif( is_search() ): ?>

		<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'boo' ), get_search_query() ); ?></h1>

	<?php endif; ?>

</header><!-- .page-header -->
