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

    					<div class="col-md-4">

    						<?php rella_portfolio_the_content() ?>

    					</div><!-- /.col-md- -->

    					<div class="col-md-4">

    						<div class="row">

								<?php rella_portfolio_date() ?>
								<?php rella_portfolio_atts() ?>

    						</div><!-- /.row -->

    					</div><!-- /.col-md-4 -->

    					<div class="col-md-4">

    						<div class="portfolio-single-share style-alt clearfix">

    							<?php rella_portfolio_share( get_post_type() ) ?>

    							<?php rella_portfolio_likes() ?>

    						</div><!-- /.col-md-6 col-md-offset-3 -->

    						</div><!-- /.portfolio-single-share -->

    					</div><!-- /.col-md-4 -->

    				</div><!-- /.row -->

    			</div><!-- /.portfolio-info -->

    		</div><!-- /.col-md-12 -->

    	</div><!-- /.row -->

    </div><!-- /.container -->

   <?php rella_render_related_posts( get_post_type() ) ?>

	<?php rella_render_post_nav( get_post_type() ) ?>

</div><!-- /.portfolio-details -->
