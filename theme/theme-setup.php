<?php
/**
 * Themerella Theme Framework
 * The Rella_Theme initiate the theme engine
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_theme_support( 'theme-demo' );

// Custom Post Type Supports
//add_theme_support( 'rella-faq' );
add_theme_support( 'rella-portfolio' );
//add_theme_support( 'rella-team' );
add_theme_support( 'rella-footer' );
add_theme_support( 'rella-header' );
add_theme_support( 'rella-mega-menu' );

// Custom Extensions
add_theme_support( 'rella-extension', array(
	'mega-menu',
	'breadcrumb',
	'post-likes'
) );
add_post_type_support( 'post', 'rella-post-likes' );

// Set theme options
rella()->set_option_name( 'prefix_opt_name' );
add_theme_support( 'rella-theme-options', array(
	'general',
	'layout',
	'header',
	'logo',
	'footer',
	'sidebars',
	'typography',
	'blog',
	'portfolio',
	'woocommerce',
	'extras',
	'advanced',
	'custom-code',
	'export'
));


//Set available metaboxes
add_theme_support( 'rella-metaboxes', array(
	'portfolio-general',
	'portfolio-meta',
	//'sliders',
	'page',
	'header',
	'footer',
	'sidebars',
	'title-wrapper',
	'title-wrapper-portfolio',
	'post',
	'post-format',
	//'layout',
	//'content',

	// Rella Content
	'header-options',
	'footer-options'
));


//Enable support for Post Formats.
//See http://codex.wordpress.org/Post_Formats
add_theme_support( 'post-formats', array(
	'audio', 'gallery', 'link', 'quote', 'video'
) );


// Sets up theme navigation locations.
register_nav_menus( array(
   'primary' => esc_html__( 'Primary Menu', 'boo' )
));

//Add Custom regular image sizes
//Blog image sizes
add_image_size( 'rella-default-blog',       690, 999, false );
add_image_size( 'rella-agency-blog',        370, 270, true );
add_image_size( 'rella-cloud-blog',         370, 205, true );
add_image_size( 'rella-shop-blog',          370, 300, true );
add_image_size( 'rella-medium-blog',        740, 640, true );
add_image_size( 'rella-university-blog',    400, 280, true );
add_image_size( 'rella-classic-blog',       1463, 9999, false );
add_image_size( 'rella-widget',             180, 180, true );
add_image_size( 'rella-slider-nav',         180, 130, true );
add_image_size( 'rella-masonry-blog',       450, 9999, false );

add_image_size( 'rella-small',              30, 9999, false );
add_image_size( 'rella-small-pf-related',   30, 30, true );
add_image_size( 'rella-small-portrait',     15, 30, true );
add_image_size( 'rella-small-portrait-tall', 20, 30, true );
add_image_size( 'rella-small-wide',         30, 15, true );

//Post image sizes
add_image_size( 'rella-thumbnail-post',     765, 400, true );
add_image_size( 'rella-related-post',       370, 190, true );

//Portfolio sizes
add_image_size( 'rella-portfolio',          480, 480, true );
add_image_size( 'rella-portfolio-sq',       285, 285, true );
add_image_size( 'rella-portfolio-big-sq',   570, 570, true );
add_image_size( 'rella-portfolio-portrait', 285, 570, true );
add_image_size( 'rella-portfolio-portrait-tall', 570, 867, true );
add_image_size( 'rella-portfolio-wide',     570, 285, true );
add_image_size( 'rella-portfolio-related',  285, 285, true );

add_image_size( 'rella-portfolio-grid-hover-elegant', 720, 560, true );
add_image_size( 'rella-portfolio-full', 1463, 9999, false );

add_image_size( 'rella-portfolio-one-col', 1463, 9999, false );
add_image_size( 'rella-portfolio-two-col', 731, 9999, false );
add_image_size( 'rella-portfolio-three-col', 488, 9999, false );
add_image_size( 'rella-portfolio-four-col', 366, 9999, false );
add_image_size( 'rella-portfolio-six-col', 244, 9999, false );

//Woo sizes
add_image_size( 'rella-woo-elegant',  270, 350, true );

//Add Custom Retina image sizes
//Blog image sizes
add_image_size( 'rella-default-blog@2x',       1380, 999, false );
add_image_size( 'rella-agency-blog@2x',        740, 640, true );
add_image_size( 'rella-cloud-blog@2x',         740, 410, true );
add_image_size( 'rella-shop-blog@2x',          740, 600, true );
add_image_size( 'rella-medium-blog@2x',        740, 640, true );
add_image_size( 'rella-university-blog@2x',    800, 560, true );
add_image_size( 'rella-classic-blog@2x',       1463, 9999, false );
add_image_size( 'rella-widget@2x',             360, 360, true );
add_image_size( 'rella-slider-nav@2x',         360, 260, true );
add_image_size( 'rella-masonry-blog@2x',       900, 9999, false );

add_image_size( 'rella-small@2x',              60, 9999, false );
add_image_size( 'rella-small-pf-related@2x',   60, 30, true );

//Post image sizes
add_image_size( 'rella-thumbnail-post@2x',     1530, 800, true );
add_image_size( 'rella-related-post@2x',       740, 380, true );

//Portfolio sizes
add_image_size( 'rella-portfolio@2x',          960, 960, true );
add_image_size( 'rella-portfolio-sq@2x',       570, 570, true );
add_image_size( 'rella-portfolio-big-sq@2x',   1140, 1140, true );
add_image_size( 'rella-portfolio-portrait@2x', 570, 1140, true );
add_image_size( 'rella-portfolio-portrait-tall@2x', 570, 867, true );
add_image_size( 'rella-portfolio-wide@2x',     1140, 570, true );
add_image_size( 'rella-portfolio-related@2x',  570, 570, true );

add_image_size( 'rella-portfolio-grid-hover-elegant@2x', 1440, 1120, true );
add_image_size( 'rella-portfolio-full@2x', 1463, 9999, false );

add_image_size( 'rella-portfolio-one-col@2x', 1463, 9999, false );
add_image_size( 'rella-portfolio-two-col@2x', 1462, 9999, false );
add_image_size( 'rella-portfolio-three-col@2x', 976, 9999, false );
add_image_size( 'rella-portfolio-four-col@2x', 732, 9999, false );
add_image_size( 'rella-portfolio-six-col@2x', 488, 9999, false );

//Woo sizes
add_image_size( 'rella-woo-elegant@2x',  540, 700, true );



// Register Widgets Area.
add_action( 'widgets_init', 'rella_main_sidebar' );
function rella_main_sidebar() {
	register_sidebar( array(
		'name'          => esc_html__( 'Main Sidebar', 'boo' ),
		'id'            => 'main',
		'description'   => esc_html__( 'Main widget area to display in sidebar', 'boo' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
}
