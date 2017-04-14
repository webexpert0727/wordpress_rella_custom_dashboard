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
    <?php $this->entry_thumbnail() ?>
	<?php $this->entry_tags() ?>
</figure>
<?php
}

if( 'link' !== $format ) {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s <span>%3$s</span></time>';
	printf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date( 'd' ),
		get_the_date( 'M' )
	);
}
?>
<div class="post-contents">

    <header>

		<?php $this->entry_title() ?>

        <div class="post-info">
		<?php

			if( 'link' === $format ) {
				$time_string = '<span><time class="published updated" datetime="%1$s">%3$s %2$s</time></span>';
				printf( $time_string,
					esc_attr( get_the_date( 'c' ) ),
					get_the_date( 'd' ),
					get_the_date( 'M' )
				);
			}

			$this->entry_author();
			$this->entry_comments();
		?>
        </div>

    </header>

	<?php $this->entry_content() ?>

    <footer>
        <a href="<?php the_permalink() ?>" class="entry-more btn btn-lg semi-round"><span>Continue Reading <i class="fa fa-angle-right"></i></span></a>
    </footer>

</div>
