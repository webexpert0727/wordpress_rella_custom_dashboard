<?php
/**
 * Default footer template
 *
 * @package Boo
 */

?>

<footer class="main-footer no-padding">
	<div class="bottom-footer no-margin bottom-footer-sm2" style="background:#85858c;color:#cecece;">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
	
					<div class="widget widget_nav_menu widget_inline_nav">
						<ul class="widget_nav_menu text-uppercase weight-bold">
							<?php the_widget( 'WP_Widget_Meta', 'title= ' ); ?>
						</ul>
					</div><!-- /.widget -->
	
				</div><!-- /.col-md-12 -->

				<div class="col-md-12">
					<div class="widget widget_text">
						<div class="textwidget">
							<div class="copyright center-block text-center"><?php esc_html_e( '&copy; 2017 Boo Theme. All rights reserved.', 'boo' ); ?></div>
						</div><!-- /textwidget -->
					</div><!-- /.widget -->
				</div><!-- /.col-md-12 -->

			</div><!-- /.row -->
		</div><!-- /.container -->
	</div><!-- /.bottom-footer -->
</footer>