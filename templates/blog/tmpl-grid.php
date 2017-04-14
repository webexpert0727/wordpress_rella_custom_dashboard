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
    <?php $this->entry_thumbnail( 'rella-default-blog' ) ?>
	<?php $this->entry_tags() ?>
</figure>
<?php
}
?>
<div class="post-contents">

    <header>

		<?php $this->entry_title() ?>

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

    </header>

	<?php $this->entry_content() ?>

</div>