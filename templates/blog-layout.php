<?php

// Fallback
if( !class_exists( 'RA_Blog' ) ) {
	// Start the Loop.
	while ( have_posts() ) : the_post();

		/*
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		rella_get_content_template();

	// End the loop.
	endwhile;
	return;
}

get_template_part( 'theme/theme-blog' );
