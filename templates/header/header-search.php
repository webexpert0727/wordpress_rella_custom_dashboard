<?php

$icon_opts = rella_get_icon( $atts );
$icon = !empty( $icon_opts['type'] ) && !empty( $icon_opts['icon'] ) ? $icon_opts['icon'] : 'fa fa-search';

?>
<div class="header-module module-search-form style-default">

	<span class="module-trigger <?php echo $atts['trigger_size'] ?>"><i class="<?php echo $icon ?>"></i></span>

	<div class="module-container">
		<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
            <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'boo' ) ?></span>
            <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'search your infinite universe', 'placeholder', 'boo' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
			<button type="submit" class="search-submit"><i class="icon-search"></i></button>
        </form>
		<div class="module-trigger module-trigger-inner">
			<button type="button" class="navbar-toggle module-toggle" aria-expanded="false">
				<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'boo' ) ?></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<?php if ( function_exists( 'get_bsearch_heatmap' ) ):
			global $bsearch_settings;

		    $args = array(
		        'before' => '<li>',              // Heatmap - Display before each search term
		        'after' => '</li>',     // Heatmap - Display after each search term
		    );
		?>
        <div class="popular-searches">
            <h4><?php echo esc_html( strip_tags( $bsearch_settings['title'] ) ) ?></h4>
            <ul>
                <?php echo get_bsearch_heatmap( $args ); ?>
            </ul>
        </div>
		<?php endif; ?>
    </div>

</div>
