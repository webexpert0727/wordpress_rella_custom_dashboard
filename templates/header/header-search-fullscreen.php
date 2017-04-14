<?php

$icon_opts = rella_get_icon( $atts );
$icon = !empty( $icon_opts['type'] ) && !empty( $icon_opts['icon'] ) ? $icon_opts['icon'] : 'fa fa-search';

?>
<div class="header-module module-search-form style-fullscreen">

	<span class="module-trigger <?php echo $atts['trigger_size'] ?>" data-target="#search-module-fullscreen">
		<i class="<?php echo $icon ?>"></i>
	</span>

	<div class="module-container" id="search-module-fullscreen">

		<span class="module-trigger" data-target="#search-module-fullscreen">
			<svg width="52" height="52" xmlns="http://www.w3.org/2000/svg">
				<ellipse stroke="#fff" ry="25" rx="25" id="svg_1" cy="26" cx="26" stroke-width="2" fill="none"/>
			</svg>
			<span class="bars">
				<span class="bar"></span>
				<span class="bar"></span>
				<span class="bar"></span>
			</span>
		</span>

		<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
            <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'boo' ) ?></span>
            <input type="search" placeholder="<?php echo esc_attr_x( 'type and hit enter', 'placeholder', 'boo' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
			<span class="line"></span>
			<button type="submit"><i class="icon-search"></i></button>
		</form>

	</div><!-- /module-container -->

</div><!-- /module -->
