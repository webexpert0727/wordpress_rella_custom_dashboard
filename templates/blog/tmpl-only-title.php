<div class="post-contents">

    <header>
	<?php
		$format = get_post_format();
		$url = 'link' == $format ? rella_helper()->get_option( 'post-link-url' ) : get_permalink();

		the_title( sprintf( '<h2 class="entry-title" data-fitText="true" data-max-fontSize="75px"><a href="%s" rel="bookmark">', esc_url( $url ) ), '</a></h2>' );
	?>
    </header>

</div>
