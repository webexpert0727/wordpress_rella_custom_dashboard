<?php

$args = array(
    'prev_text'          => '%title',
    'next_text'          => '%title',
    'in_same_term'       => false,
    'excluded_terms'     => '',
    'taxonomy'           => 'category'
);

$previous = get_previous_post_link(
    '%link',
    $args['prev_text'],
    $args['in_same_term'],
    $args['excluded_terms'],
    $args['taxonomy']
);
if( $previous ) {
	$previous = str_replace( '<a', '<a class="prev"', $previous );
}

$next = get_next_post_link(
    '%link',
    $args['next_text'],
    $args['in_same_term'],
    $args['excluded_terms'],
    $args['taxonomy']
);
if( $next ) {
	$next = str_replace( '<a', '<a class="next"', $next );
}
?>
<div class="post-nav">

	<nav class="navigation post-navigation" role="navigation">
        <h2 class="screen-reader-text"><?php esc_html__( 'Post navigation', 'boo' ) ?></h2>
        <?php echo $previous . $next ?>
    </nav>

</div><!-- /.post-nav -->