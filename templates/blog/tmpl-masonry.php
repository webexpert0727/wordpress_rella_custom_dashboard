<?php
$format = get_post_format();

if( 'audio' === $format ) {
	$this->entry_thumbnail();
}
elseif( 'video' === $format ) {
?>
<div class="post-video">
	<?php $this->entry_thumbnail() ?>
	<?php $this->entry_tags() ?>
</div>
<?php
}
elseif( 'link' !== $format ) {
?>
<figure class="post-image hmedia">
    <?php $this->entry_thumbnail( 'rella-masonry-blog' ) ?>
	<?php $this->entry_tags() ?>
</figure>
<?php
}
?>
<div class="post-contents">

    <header>

        <div class="post-info">
		<?php

			$time_string = '<span><time class="published updated" datetime="%1$s">%3$s %2$s</time></span>';
			printf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date( 'd' ),
				get_the_date( 'M' )
			);

			$this->entry_author();
		?>
        </div>

		<?php $this->entry_title() ?>

    </header>

	<?php $this->entry_content() ?>

    <footer>
        <a href="<?php the_permalink() ?>" class="entry-more btn btn-naked"><span><?php esc_html_e( 'Continue Reading', 'boo' ); ?> <i class="fa fa-angle-right"></i></span></a>
    </footer>

</div>
