<li <?php rella_helper()->attr( 'comment' ); ?>>

	<article class="comment-body">

		<figure class="avatar">

			<?php echo get_avatar( $comment, 85 ); ?>

			<div class="reply">
				<?php rella_comment_reply_link(); ?>
			</div>
		</figure>

		<div <?php rella_helper()->attr( 'comment-content' ); ?>>

			<footer class="comment-meta">

				<b <?php rella_helper()->attr( 'comment-author' ); ?>><?php comment_author_link(); ?></b>

				<time <?php rella_helper()->attr( 'comment-published' ); ?>><?php printf( esc_html__( '%s ago', 'boo' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time>

			</footer>

			<?php comment_text(); ?>

			<a <?php rella_helper()->attr( 'comment-permalink' ); ?>><?php esc_html_e( 'Permalink', 'boo' ); ?></a><?php edit_comment_link(); ?>

		</div>

	</article>
