<?php if ( 'post' !== get_post_type() ) return; ?>

<div class="entry-byline">

	<span <?php rella_helper()->attr( 'entry-author' ); ?>><?php the_author_posts_link(); ?></span>

	<time <?php rella_helper()->attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>

	<?php comments_popup_link( number_format_i18n( 0 ), number_format_i18n( 1 ), '%', 'comments-link', '' ); ?>

	<?php edit_post_link(); ?>

</div><!-- .entry-byline -->
