<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package base-theme
 */

// If a post password is required or no comments are given and comments/pings are closed, return.
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<h4 class="comments-title"><?php esc_html_e( 'Opinions', 'boo' ); ?></h4>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style' => 'ol',
					'callback' => 'rella_comments_callback'
				) );
			?>
		</ol>

	<?php
		get_template_part( 'templates/comment/nav' );

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_typebooupports( get_post_type(), 'comments' ) ) : ?>

	<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'boo' ); ?></p>


	<?php

	endif;

	$req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html_req = ( $req ? " required='required'" : '' );
    $html5    = true;
	$fields   =  array(
		'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="'. esc_attr__( 'Name', 'boo' ) . ( $req ? '*' : '' ) .'" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="'. esc_attr__( 'Email', 'boo' ) . ( $req ? '*' : '' ) .'" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>',
		'url'    => '<p class="comment-form-url"><input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . esc_attr__( 'Website', 'boo' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',
	);

	comment_form( array(
		'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
		'title_reply' => 'Join the Discussion',
		'title_reply_after' => '</h4>',
		'fields' => $fields,
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" rows="6" placeholder="'. esc_attr__( 'Comment', 'boo' ) .'" aria-required="true" required="required"></textarea></p>',
		'comment_notes_before' => '',
		'label_submit' => esc_attr__( 'Send', 'boo' )
	) );
	?>

</div>
