<?php

$icon_opts = rella_get_icon( $atts );
$icon = !empty( $icon_opts['type'] ) && !empty( $icon_opts['icon'] ) ? $icon_opts['icon'] : 'fa fa-search';

?>

<div class="header-module module-search-form style-simple">

	<span class="module-trigger <?php echo $atts['trigger_size'] ?>" data-target="#search-style-simple">
		<i class="<?php echo $icon ?>"></i>
	</span>

	<div class="module-container" id="search-style-simple">
		<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
            <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'boo' ) ?></span>
            <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'search your infinite universe', 'placeholder', 'boo' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
			<button type="submit"><i class="fa fa-long-arrow-right"></i></button>
		</form>
	</div><!-- /module-container -->

</div><!-- /module -->