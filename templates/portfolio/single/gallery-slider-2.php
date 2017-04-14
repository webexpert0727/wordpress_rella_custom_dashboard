<!-- <div class="portfolio-details" data-appear-animation="true" data-appear-element="> .container > .row > [class*=col] > *,> .container-fluid > .row > [class*=col] > *" data-appear-from='{ "y": 70 }' data-appear-to='{ "y": 0, "opacity": 1, "visibility": "visible", "ease": "Power4.easeOut" }' data-stagger="true" data-appear-time="1" data-appear-delay="0.15"> -->
<div class="portfolio-details">
	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<?php rella_portfolio_media() ?>

			</div><!-- /.col-md-12 -->

			<div class="col-md-12">

				<div class="portfolio-info">

					<div class="row">

						<div class="col-md-8">

							<?php rella_portfolio_the_content() ?>

							<?php if( $url = get_post_meta( get_the_ID(), 'portfolio-website', true ) ) : ?>
                            <p>
                                <a href="<?php echo esc_url( $url ) ?>" class="btn btn-xlg semi-round text-uppercase"><span><?php esc_html_e( 'Launch', 'boo' ) ?> <i class="fa fa-angle-right"></i></span></a>
                            </p>
							<?php endif; ?>

						</div><!-- /.col-md-8 -->

						<div class="col-md-4">

							<div class="row">

								<?php rella_portfolio_date() ?>
								<?php rella_portfolio_atts() ?>

								<div class="col-md-12">

									<div class="portfolio-single-share clearfix">

										<?php rella_portfolio_likes() ?>

		                                <?php rella_portfolio_share( get_post_type() ) ?>

									</div><!-- /.portfolio-single-share -->

								</div><!-- /.col-md-12 -->

							</div><!-- /.row -->

						</div><!-- /.col-md-4 -->

					</div><!-- /.row -->

				</div><!-- /.portfolio-info -->

			</div><!-- /.col-md-12 -->

		</div><!-- /.row -->

	</div><!-- /.container -->

	<div class="container">
		<?php rella_portfolio_the_vc() ?>
	</div>

	<?php rella_render_related_posts( get_post_type() ) ?>

</div>
