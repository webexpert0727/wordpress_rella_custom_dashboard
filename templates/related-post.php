<div class="post-related">

	<div class="row">

		<div class="col-md-12">
			<h4><?php echo $heading ?></h4>
		</div>

		<?php while( $related_posts->have_posts() ): $related_posts->the_post(); ?>
		<div class="col-md-6">

			<article class="blog-post hentry entry">

				<figure class="post-image hmedia">
					
					<?php 
						$retina_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'rella-related-post@2x' );
						the_post_thumbnail( 'rella-related-post', array( 'data-rjs' => $retina_image[0] ) );
					
					?>
				</figure><!-- /.main-image -->

				<div class="post-contents">

					<header>

						<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ) ?>

						<div class="post-info">

							<span><time <?php rella_helper()->attr( 'entry-published' ); ?>><?php echo get_the_date( 'M j' ); ?></time></span>
							<?php rella_author_link( 'before=' ) ?>

						</div><!-- /.post-info -->

					</header>

				</div><!-- /.contents -->

			</article><!-- /.blog-post -->

		</div><!-- /.col-md-6 -->
		<?php endwhile; ?>

	</div><!-- /.row -->

</div><!-- /.post-related -->

<?php wp_reset_postdata();
