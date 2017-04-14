<!-- <div class="portfolio-details pulled-up" data-appear-animation="true" data-appear-element="> .container > .row > [class*=col], .portfolio-info > .row > [class*=col-]" data-appear-from='{ "y": 70 }' data-appear-to='{ "y": 0, "opacity": 1, "visibility": "visible", "ease": "Power4.easeOut" }' data-stagger="true" data-appear-time="1" data-appear-delay="0.15"> -->
<div class="portfolio-details pulled-up">
	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<div class="portfolio-info style-alt bg-dark">

					<div class="row">

						<div class="col-md-4">

							<?php the_title( '<h2 '. rella_helper()->get_attr( 'entry-title', array( 'class' => 'portfolio-title' ) ) .'>', '</h2>' ); ?>

						</div><!-- /.col-md-4 -->

						<div class="col-md-4">

							<?php rella_portfolio_the_content() ?>

						</div><!-- /.col-md-4 -->

						<div class="col-md-4">

							<div class="row">

								<?php rella_portfolio_date() ?>
								<?php rella_portfolio_atts() ?>

							</div><!-- /.row -->

						</div><!-- /.col-md-4 -->

					</div><!-- /.row -->

				</div><!-- /.portfolio-info -->

			</div><!-- /.col-md-12 -->

			<?php rella_portfolio_media( array(
				'before' => '<div class="col-md-6">',
				'after' => '</div><!-- /.col-md-6 -->'
			) ) ?>

		</div><!-- /.row -->

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

	<div class="conainer">
		<?php rella_portfolio_the_vc() ?>
	</div>

	<?php rella_render_post_nav( get_post_type() ) ?>

</div>
