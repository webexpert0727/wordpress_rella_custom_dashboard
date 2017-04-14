<?php
	
$format =  get_post_format();

?>
<div class="contents-container blog-single blog-single-minimal">
	<div class="contents">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">		

				<article <?php rella_helper()->attr( 'post', array( 'class' => 'blog-post' ) ) ?>>
		
					<div class="post-contents">
		
						<header>
							<?php if( 'audio' === $format && $audio = rella_helper()->get_option( 'post-audio' ) ) : ?>
								<div class="post-audio">
									<?php echo do_shortcode( '[audio src="' . esc_url( $audio ) . '"]' ) ?>
								</div><!-- /.post-audio -->
							<?php endif; ?>
							
							<?php the_title( '<h2 '. rella_helper()->get_attr( 'entry-title' ) .'>', '</h2>' ); ?>
		
							<div class="post-info">
								<span><time <?php rella_helper()->attr( 'entry-published' ); ?>><i class="fa fa-clock-o"></i> <?php echo get_the_date(); ?></time></span>
								<?php rella_author_link() ?>
								<span class="comments">
									<?php comments_popup_link( '<i class="fa fa-comment"></i> 0 Opinions', '<i class="fa fa-comment"></i> 1 Opinion', '<i class="fa fa-comment"></i> % Opinions', 'comments-link', '' ); ?>
								</span>
							</div><!-- /.post-info -->
		
						</header>		

						<div <?php rella_helper()->attr( 'entry-content' ) ?>>
							<?php
								the_content( sprintf(
									esc_html__( 'Continue reading %s', 'boo' ),
									the_title( '<span class="screen-reader-text">', '</span>', false )
									) );

								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'boo' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
									'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'boo' ) . ' </span>%',
									'separator'   => '<span class="screen-reader-text">, </span>',
								) );
							?>
						</div>

						<div class="row">
							<div class="col-md-10 col-md-offset-1">
		
								<?php rella_portfolio_share( get_post_type(), array(
									'class' => 'social-icon semi-round rectangle bordered branded-text',
									'before' => '<div class="post-share">',
									'after' => '</div>'
								) ) ?>
		
								<?php rella_render_post_nav() ?>
		
								<?php get_template_part( 'templates/blog/single/part', 'author' ) ?>
		
								<?php rella_render_related_posts( get_post_type() ) ?>
		
								<?php
								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif; ?>
		
							</div><!-- /.col-md-10 col-md-offset-1 -->
						</div><!-- /.row -->
					</div><!-- /.post-contents -->
					
				</article><!-- #post-## -->

			</div><!-- /.col-md-10 -->
		</div><!-- /.row -->
	</div>
</div>