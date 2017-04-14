<?php $theme = rella_helper()->get_current_theme(); ?>
<header class="rella-dashboard-header">

	<div class="rella-dashboard-title  clearfix">

		<div class="rella-left">

			<h1>
				<?php printf( esc_html__( 'Welcome to %s!', 'boo' ), $theme->name ) ?>
				<div class="rella-label">
					<span><?php printf( esc_html__( 'Theme Version: %s', 'boo' ), $theme->version ) ?></span>
				</div>
			</h1>

			<p><?php esc_html_e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum dui malesuada eros.', 'boo' ) ?></p>

		</div>

		<figure class="rella-right">
			<img src="<?php echo rella()->load_assets( 'img/rella-logo.png' ); ?>" alt="Rella Logo">
		</figure>

	</div>

	<div class="clearfix"></div>

	<ul class="rella-inline-nav rella-clearlist clearfix rella-nav-tabs">
		<li class="rella-left is-active"><a href="<?php echo rella_helper()->dashboard_page_url() ?>#rella-general"><?php esc_html_e( 'General', 'boo' ) ?></a></li>
		<li class="rella-left"><a href="<?php echo rella_helper()->import_demos_page_url() ?>"><?php esc_html_e( 'Import Demos', 'boo' ) ?></a></li>
		<li class="rella-left"><a href="<?php echo rella_helper()->plugin_page_url() ?>"><?php esc_html_e( 'Plugins', 'boo' ) ?></a></li>
		<li class="rella-right"><a href="#"><i class="fa fa-youtube-play"></i> <?php esc_html_e( 'Visual Help', 'boo' ) ?> <i class="fa fa-angle-right"></i></a></li>
	</ul>

</header>