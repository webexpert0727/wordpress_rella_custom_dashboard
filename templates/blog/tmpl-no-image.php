<div class="post-contents">

    <header>

		<?php
		if( 'link' !== get_post_format() ) {

			echo '<div class="post-info">';

			$time_string = '<span><time class="published updated" datetime="%1$s"><span>%2$s</span> %3$s</time></span>';
			printf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date( 'd' ),
				get_the_date( 'M' )
			);

			$this->entry_author( 106 );

			echo '</div>';
		}
		?>

		<?php $this->entry_title() ?>

    </header>

	<?php $this->entry_content() ?>

    <footer>
        <a href="<?php the_permalink() ?>" class="entry-more btn btn-md2"><span>Continue Reading <i class="fa fa-angle-right"></i></span></a>
    </footer>

</div>
