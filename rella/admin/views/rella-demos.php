<div class="wrap rella-wrap">
	<div class="rella-dashboard">

		<h2 class="h1 rella-align-center">Boo Demos</h2>

		<div class="rella-info rella-align-center bg-seashell">
			<h4><i class="fa fa-check text-gradient"></i> We provide with many usefull demos and much more to come!</h4>
		</div>
		<?php

		$located = locate_template( 'theme/theme-demo-config.php' );
		include_once $located;
	
		if( ! empty( $demos ) ) :
	
		wp_localize_script( 'rella-admin', 'rella_demos', $demos );

		?>
		<ul class="rella-cards-container clearfix">
		<?php foreach( $demos as $id => $demo ): ?>
			<li class="rella-card rella-card-demo rella-card-is-active">
				<div class="rella-card-inner">
					<div class="rella-icon-container">
						<img src="<?php echo $demo['screenshot'] ?>" alt="<?php echo $demo['title'] ?>" />
					</div>
					<h3><?php echo $demo['title'] ?></h3>
					<p><?php echo $demo['description'] ?></p>
					<div class="rella-card-footer clearfix">
						<a target="_blank" class="rella-button" href="<?php echo $demo['preview'] ?>"><span><?php esc_html_e( 'Preview', 'boo' ) ?></span> <i class="fa fa-angle-right"></i></a>
						<a class="rella-button rella-import-popup" href="#" data-demo-id="<?php echo $id ?>"><span><?php esc_html_e( 'Import Demo', 'boo' ) ?></span> <i class="fa fa-angle-right"></i></a>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
		</ul>

		<script type="text/template" id="tmpl-demo-import-modules">
	
			<div class="rella-popup-right rella-popup-import-modules">
				<h4>Importing &hellip;</h4>
				<p>Import in progress, don't close the window.</p>

	
			</div>
		</script>

		<script type="text/template" id="tmpl-demo-popup">
			<div class="rella-popup" id="rella-popup">
				<div class="rella-popup-body">
					<span class="rella-popup-close">&times;</span>
					<div class="rella-popup-content">

						<div class="rella-huge-text">
							<h3>Boo</h3>
						</div>
	
						<div class="rella-popup-content-inner">

							<div class="rella-popup-left">
								<a class="live-demo" target="_blank" href="<%= preview %>"><span>View Demo</span></a>
								<img class="demo-image-blur" src="<%= screenshot %>" alt="Demo Image"></img>
								<img class="demo-image" src="<%= screenshot %>" alt="Demo Image"></img>
							</div>
						
							<div class="rella-popup-right rella-popup-getting-started">

								<h3>What You Get In This Package</h3>
								<p>This package will import the content you choose using bottoms below. Please note that choosing media, will increase the import time dramatically. Also you need to install required plugins like contact form 7 before importing the demos.</p>

								<div class="import-option-group">
		
									<span class="import-option">
										<input id="rella-import-content" type="checkbox" value="content" checked="">
										<label for="rella-import-content">
											<i class="option-icon fa fa-check"></i>CONTENT
										</label>
									</span>
		
									<% if( has_yellow ) { %>
									<span class="import-option">
										<input id="rella-import-yellow" type="checkbox" value="yellow" checked="">
										<label for="rella-import-yellow">
											<i class="option-icon fa fa-check"></i>YELLOW
										</label>
									</span>
									<% } %>

									<% if( has_widgets ) { %>
									<span class="import-option">
										<input id="rella-import-widget" type="checkbox" value="widgets" checked="">
										<label for="rella-import-widget">
											<i class="option-icon fa fa-check"></i>WIDGETS
										</label>
									</span>
									<% } %>

									<% if( has_sliders ) { %>
									<span class="import-option">
										<input id="rella-import-sliders" type="checkbox" value="sliders" checked="">
										<label for="rella-import-sliders">
											<i class="option-icon fa fa-check"></i>SLIDERS
										</label>
									</span>
									<% } %>
	
									<span class="import-option">
										<input id="rella-import-setting" type="checkbox" value="settings" checked="">
										<label for="rella-import-setting">
											<i class="option-icon fa fa-check"></i>SETTING
										</label>
									</span>
	
									<span class="import-option">
										<input id="rella-import-media" type="checkbox" value="media" checked="">
										<label for="rella-import-media">
											<i class="option-icon fa fa-check"></i>MEDIA
										</label>
									</span>
	
								</div><!-- /.import-option-group -->

								<hr>
								<p>New builder settings will overwrite your current settings, are you sure about this?</p>
								<div class="rella-agree-box"></div><!-- /.rella-agree-box -->
						
								<div class="import-option">
									<input class="agree" id="agree" name="agree" type="checkbox" value="no">
									<label for="agree"><i class="option-icon fa fa-check"></i>Yes, Im sure about this</label>
								</div>
						
								<a class="rella-import-demo purchase-code-false" data-revslider="true" data-id="0"><span>import demo</span></a>

							</div>
						</div><!-- /.rella-popup-content-inner -->

					</div><!-- /.rella-popup-content -->
				</div><!-- /.rella-popup-body -->
			</div><!-- /.rella-popup -->
		</script>
		<?php endif; ?>

	</div>
</div>
