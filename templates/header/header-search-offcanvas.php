<?php

$icon_opts = rella_get_icon( $atts );
$icon = !empty( $icon_opts['type'] ) && !empty( $icon_opts['icon'] ) ? $icon_opts['icon'] : 'fa fa-search';

$img = $logo ? rella_get_image( $logo ) : rella_helper()->get_option( 'header-logo' );

if( is_array( $img ) && !empty( $img['url'] ) ) {
	$img = esc_url( $img['url'] );
}

$retina_img = $data_retina = '';
$retina_img = $retina_logo ? rella_get_image( $retina_logo ) : rella_helper()->get_option( 'header-logo-retina' );

if( is_array( $retina_img ) && !empty( $retina_img['url'] ) ) {
	$retina_img = esc_url( $retina_img['url'] );
}

if( $retina_img ) {
	$data_retina = 'data-rjs=' . $retina_img;
}

?>	

<div class="header-module module-search-form style-offcanvas">

	<span class="module-trigger <?php echo $atts['trigger_size'] ?>" data-target="#search-module-fullscreen">
		<i class="<?php echo $icon ?>"></i>
	</span>

	<div class="module-container" id="search-module-fullscreen">

		<span class="module-trigger" data-target="#search-module-fullscreen">
			<i class="icon-linear-cross3"></i>
		</span>

		<a class="navbar-brand hidden-sm hidden-xs" href="<?php echo esc_url( home_url( '/' ) ) ?>">
			<img src="<?php echo $img ?>" alt="Logo" <?php echo $data_retina; ?>>
		</a>

		<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
            <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'boo' ) ?></span>
            <input type="search" placeholder="<?php echo esc_attr_x( 'type and hit enter', 'placeholder', 'boo' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
			<button type="submit"><i class="icon-search"></i></button>
		</form>

	</div><!-- /module-container -->

</div><!-- /module -->