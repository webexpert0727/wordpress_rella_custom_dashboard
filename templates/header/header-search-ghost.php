<?php

$icon_opts = rella_get_icon( $atts );
$icon = !empty( $icon_opts['type'] ) && !empty( $icon_opts['icon'] ) ? $icon_opts['icon'] : 'fa fa-search';

?>
<div class="header-module module-search-form style-ghost">

	<span class="module-trigger <?php echo $atts['trigger_size'] ?>" data-target="#search-module-fullscreen">
		<i class="<?php echo $icon ?>"></i>
	</span>

	<div class="module-container" id="search-module-fullscreen">

		<span class="module-trigger" data-target="#search-module-fullscreen">
			<i class="icon-linear-cross3"></i>
		</span>

		<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
            <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'boo' ) ?></span>
            <input type="search" placeholder="<?php echo esc_attr_x( 'type and hit enter', 'placeholder', 'boo' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
			<span class="placeholder"><i class="icon-search"></i></span>
			<button type="submit"><i class="icon-search"></i></button>
		</form>

	</div><!-- /module-container -->

</div><!-- /module -->
