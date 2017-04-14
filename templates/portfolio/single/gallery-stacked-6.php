<!-- <div class="portfolio-details" data-appear-animation="true" data-appear-element="> .container > .row > [class*=col] > *,> .container-fluid > .row > [class*=col] > *" data-appear-from='{ "y": 70 }' data-appear-to='{ "y": 0, "opacity": 1, "visibility": "visible", "ease": "Power4.easeOut" }' data-stagger="true" data-appear-time="1" data-appear-delay="0.15"> -->
<div class="portfolio-details">
	<div class="container">

		<div class="row">

			<div class="col-md-9">

				<?php rella_portfolio_media() ?>

			</div><!-- /.col-md-9 -->

			<div class="col-md-3">

				<div class="portfolio-info">

					<div class="row">

						<div class="col-md-12 mb-20">

							<?php the_title( '<h2 '. rella_helper()->get_attr( 'entry-title', array( 'class' => 'portfolio-title' ) ) .'>', '</h2>' ); ?>

							<?php rella_portfolio_the_content() ?>

						</div><!-- /.col-md-12 -->

						<div class="col-md-12">

							<div class="wpb_wrapper align-center" style="padding-bottom: 20px; border: 1px solid #ededed;">

								<h3>Details</h3>

								<div class="row">
								<?php rella_portfolio_date(12) ?>
								<?php rella_portfolio_atts(12) ?>
								</div>

								<?php rella_portfolio_likes( 'portfolio-likes' ) ?>

							</div><!-- /.wpb_wrapper -->

						</div><!-- /.col-md-12 -->

						<div class="col-md-12 align-center">

							<?php if( $url = get_post_meta( get_the_ID(), 'portfolio-website', true ) ) : ?>
							<a href="<?php echo esc_url( $url ) ?>" class="btn btn-xxsm semi-round"><span><?php esc_html_e( 'See Details', 'boo' ); ?> <i class="fa fa-long-arrow-right"></i></span></a>
							<?php endif; ?>

							<?php rella_portfolio_share( get_post_type(), array(
								'class' => 'social-icon',
								'before' => '<div class="portfolio-share"><span class="btn btn-xsm semi-round"><span><i class="fa fa-share"></i></span></span><div class="portfolio-share-popup">',
								'after' => '</div></div>'
							) ) ?>

						</div><!-- /.col-md-12 -->

					</div><!-- /.row -->

				</div><!-- /.portfolio-info -->

				<?php rella_portfolio_the_vc() ?>

			</div><!-- /.col-md-3 -->

		</div><!-- /.row -->

	</div><!-- /.container -->

	<?php rella_render_post_nav( get_post_type() ) ?>

</div>
