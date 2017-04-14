<?php
$current_theme = wp_get_theme();
if( $current_theme->parent_theme ) {
	$template_dir  = basename( get_template_directory() );
	$current_theme = wp_get_theme($template_dir);
}

$installed_plugins = get_plugins();
$plugins = TGM_Plugin_Activation::$instance->plugins;
?>
<div class="wrap rella-wrap">

	<div class="rella-dashboard">

		<h2 class="h1 rella-align-center">Themerella Plugins</h2>

       <div class="rella-info rella-align-center bg-seashell">
          <h4><i class="fa fa-check text-gradient"></i> Custom and third party plugins ( over $1000 in value ) you can use for free!</h4>
       </div>

	    <ul class="rella-cards-container clearfix">
	        <?php

			foreach( $plugins as $plugin ) :
				$btn = $btn_class = $class = $status = '';
				$file_path = $plugin['file_path'];

				// Install
				if( ! isset( $installed_plugins[$file_path] ) ) {
					$status = 'not-installed';
				}
				// Active
				elseif ( is_plugin_inactive( $file_path ) ) {
					$status = 'installed';
				}
				// Deactive
				elseif ( is_plugin_active( $file_path ) ) {
					$status = 'active';
				}
			?>
				<li class="rella-card rella-card-is-<?php echo $status ?>">

					<div class="rella-card-inner">

						<div class="rella-icon-container">

							<!-- <img src="<?php echo $plugin['rella_logo']  ?>" alt="Extension" class="icon"> -->
							<i class="text-gradient fa fa-plug"></i>

						</div>

						<h3><?php echo $plugin['name'] ?></h3>

						<div class="rella-status"><span><?php echo ucwords( $status ) ?></span></div>

						<p>
							<?php echo $plugin['rella_description'] ?>
						</p>

						<div class="rella-author">
							By <a href="#"><?php echo $plugin['rella_author'] ?></a>
						</div>

						<div class="rella-card-footer clearfix">
							<?php rella_helper()->tgmpa_plugin_action( $plugin, $status ); ?>
						</div>

					</div>

				</li>

	        <?php endforeach; ?>
	    </ul>

	</div>

</div>
