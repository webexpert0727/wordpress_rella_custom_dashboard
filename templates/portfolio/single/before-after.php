<!-- <div class="portfolio-details" data-appear-animation="true" data-appear-element="> .container > .row > [class*=col] > *,> .container-fluid > .row > [class*=col] > *" data-appear-from='{ "y": 70 }' data-appear-to='{ "y": 0, "opacity": 1, "visibility": "visible", "ease": "Power4.easeOut" }' data-stagger="true" data-appear-time="1" data-appear-delay="0.15"> -->
<div class="portfolio-details">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<div class="portfolio-info">

					<div class="row">

						<div class="col-md-8">

							<?php the_title( '<h2 '. rella_helper()->get_attr( 'entry-title', array( 'class' => 'portfolio-title' ) ) .'>', '</h2>' ); ?>

							<?php rella_portfolio_the_content() ?>

						</div><!-- /.col-md-8 -->

						<div class="col-md-4">

							<div class="row">

								<?php rella_portfolio_date() ?>
								<?php rella_portfolio_atts() ?>

								<?php if( $url = get_post_meta( get_the_ID(), 'portfolio-website', true ) ) : ?>
									<div class="col-md-12">

										<a href="<?php echo esc_url( $url ) ?>" class="btn btn-xlg semi-round text-uppercase"><span><?php esc_html_e( 'Launch', 'boo' ) ?> <i class="fa fa-angle-right"></i></span></a>

									</div><!-- /.col-md-12 -->
								<?php endif; ?>

							</div><!-- /.row -->

						</div><!-- /.col-md-4 -->

					</div><!-- /.row -->

				</div><!-- /.portfolio-info -->

			</div><!-- /.col-md-12 -->

		</div><!-- /.row -->

	</div><!-- /.container -->

	<div class="container">

		<div class="row">

			<?php
			$before_image = get_post_meta( get_the_ID(), 'portfolio-before-image', true );
			$after_image = get_post_meta( get_the_ID(), 'portfolio-after-image', true );

			if( $before_image && $after_image ) :
				?>
				<div class="col-md-12">

					<figure class="cd-image-container">

						<img src="<?php echo $before_image['url'] ?>" alt="Original Image">
						<span class="cd-image-label" data-type="original"><?php esc_html_e( 'Original', 'boo' ); ?></span>

						<div class="cd-resize-img"> <!-- the resizable image on top -->
							<img src="<?php echo $after_image['url'] ?>" alt="Modified Image">
							<span class="cd-image-label" data-type="modified"><?php esc_html_e( 'Modified', 'boo' ) ?></span>
						</div>

						<span class="cd-handle"></span>
					</figure> <!-- cd-image-container -->

				</div><!-- /.col-md-12 -->
			<?php endif; ?>

		</div><!-- /.row -->

		<?php rella_portfolio_the_vc() ?>

	</div><!-- /.container -->

	<div class="portfolio-single-share style-alt clearfix">

		<div class="container">

			<div class="row">

				<div class="col-md-6 col-md-offset-3">

					<?php rella_portfolio_share( get_post_type(), array(
						'class' => 'social-icon scheme-gray text',
						'before' => '<h6>' . esc_html__( 'Share', 'boo' ) . '</h6>',
						'style' => 'label'
					) ) ?>

					<?php rella_portfolio_likes() ?>

				</div><!-- /.col-md-6 col-md-offset-3 -->

			</div><!-- /.row -->

		</div><!-- /.container -->

	</div><!-- /.portfolio-single-share -->

	<?php rella_render_related_posts( get_post_type() ) ?>

	<?php rella_render_post_nav( get_post_type() ) ?>

</div>
