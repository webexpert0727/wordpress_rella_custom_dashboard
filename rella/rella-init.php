<?php
/**
 * Themerella Theme Framework
 * The Rella_Theme initiate the theme engine
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Include base class
get_template_part( 'rella/rella-base' );

// For developers to hook.
rella_action( 'before_init' );

/**
 * Rella Theme
 */
class Rella_Theme extends Rella_Base {

	/**
	 * [$version description]
	 * @var string
	 */
	private $version = '1.0.0';

	/**
	 * Theme options values
	 * @var array
	 */
	protected $theme_options_values = array();

	/**
     * Hold an instance of Rella_Theme class.
     * @var Rella_Theme
     */
    protected static $instance = null;

	/**
	 * Main Rella_Theme instance.
	 *
	 * @return Rella_Theme - Main instance.
	 */
    public static function instance() {
        if(null == self::$instance) {
            self::$instance = new Rella_Theme();
        }

        return self::$instance;
    }

	/**
	 * [__construct description]
	 * @method __construct
	 */
	private function __construct() {

		$this->init_hooks();
	}

	/**
	 * [init_hooks description]
	 * @method init_hooks
	 * @return [type]     [description]
	 */
	private function init_hooks() {

		$this->add_action( 'after_setup_theme', 'includes', 2 );
		$this->add_action( 'after_setup_theme', 'setup_theme', 7 );
		$this->add_action( 'after_setup_theme', 'admin', 7 );
		$this->add_action( 'after_setup_theme', 'redux_init', 10 );
		$this->add_action( 'after_setup_theme', 'extensions', 25 );

		// For developers to hook.
		rella_action( 'loaded' );
	}

	/**
	 * [includes description]
	 * @method includes
	 * @return [type]   [description]
	 */
	public function includes() {

		// Load Core
		include_once 'rella-helpers.php';
		include_once 'rella-template-tags.php';
		include_once 'rella-theme-options-init.php';
		include_once 'rella-meta-boxes-init.php';
		include_once 'rella-dynamic-css.php';

		// Load Structure
		include_once 'structure/markup.php';
		include_once 'structure/header.php';
		include_once 'structure/footer.php';
		include_once 'structure/posts.php';
		include_once 'structure/comments.php';

		// Load Woocommerce stuff
		if( class_exists('WooCommerce') ) {
			include_once 'vendors/woocommerce/rella-woocommerce-init.php';
		}

		// Front-end
		if( ! is_admin() ) {
			$this->layout = include_once 'rella-theme-layout.php';
		}
	}

	/**
	 * [setup_theme description]
	 * @method setup_theme
	 * @return [type]      [description]
	 */
	public function setup_theme() {

		// Set Content Width
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 780;
		}

		// Localization
		load_theme_textdomain( 'boo', trailingslashit( WP_LANG_DIR ) . 'themes/' ); // From Wp-Content
        load_theme_textdomain( 'boo', get_stylesheet_directory()  . '/languages' ); // From Child Theme
        load_theme_textdomain( 'boo', get_template_directory()    . '/languages' ); // From Parent Theme

		// Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Let WordPress manage the document title.
        add_theme_support( 'title-tag' );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );

        // Enable support for WooCommerce
        add_theme_support( 'woocommerce' );

        // Switch default core markup for search form, comment form, and comments to output valid HTML5.
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'rella-assets'
        ));

		// Allow shortcodes in widgets.
		add_filter( 'widget_text', 'do_shortcode' );

		// Theme Specific Setup
		$this->load_theme_part( 'theme-setup' );

		// Get options for globals
		$GLOBALS[$this->get_option_name()] = get_option( $this->get_option_name(), array() );

		$this->load_theme_part( 'theme-scripts' );
		$this->load_theme_part( 'theme-hooks' );
		$this->load_theme_part( 'theme-template-tags' );
		$this->load_theme_part( 'theme-dynamic-css' );
		$this->load_theme_part( 'theme-walkers' );
	}

	/**
	 * [admin description]
	 * @method admin
	 * @return [type] [description]
	 */
	public function admin() {

		if( is_admin() ) {
			include_once 'admin/rella-admin-init.php';
		}

	}

	/**
	 * Init redux framework
	 * @method redux_init
	 */
	public function redux_init() {

		$this->add_action( 'redux/extensions/before', 'load_redux_extensions', 0 );
		$this->add_action( 'redux/'. $this->get_option_name() .'/field/class/typography', 'register_typography' );
		$this->add_action( 'redux/'. $this->get_option_name() .'/field/class/gradient', 'register_gradient' );
		$this->add_action( 'redux/'. $this->get_option_name() .'/field/class/color_rgba', 'register_color_rgba' );

		new Rella_Meta_Boxes;
		new Rella_Theme_Options;
		new Rella_Dynamic_CSS;
	}

	/**
	 * [load_redux_extensions description]
	 * @method load_redux_extensions
	 * @return [type]                [description]
	 */
	public function load_redux_extensions( $redux ) {

		$path = get_template_directory() . '/rella/extensions/';
		$exts = array( 'metaboxes', 'repeater' );

		foreach( $exts as $ext ) {

			$extension_class = 'ReduxFramework_extension_' . $ext;
			$class_file = $path . 'redux-' . $ext . '/extension_' . $ext . '.php';
			$class_file = apply_filters( 'redux/extension/' . $redux->args['opt_name'] . '/' . $ext, $class_file );

			if( !class_exists( $extension_class ) && $class_file ) {
				require_once( $class_file );
				$extension = new $extension_class( $redux );
			}
		}
	}

	/**
	 * [register_gradient description]
	 * @method register_gradient
	 * @return [type]              [description]
	 */
	public function register_gradient() {
		return get_template_directory() . '/rella/extensions/redux-gradient/field_gradient.php';
	}

	/**
	 * [register_typography description]
	 * @method register_typography
	 * @return [type]              [description]
	 */
	public function register_typography() {
		return get_template_directory() . '/rella/extensions/redux-typography/field_typography.php';
	}

	/**
	 * [register_color_rgba description]
	 * @method register_color_rgba
	 * @return [type]              [description]
	 */
	public function register_color_rgba() {
		return get_template_directory() . '/rella/extensions/redux-color-rgba/field_color_rgba.php';
	}

	/**
	 * [extensions description]
	 * @method extensions
	 * @return [type]     [description]
	 */
	public function extensions() {

		// check
		$extensions = get_theme_support( 'rella-extension' );
		if( empty( $extensions ) || empty( $extensions[0] ) ) {
			return;
		}

		// Load
		$extensions = $extensions[0];
		foreach( $extensions as $extension ) {
			$this->load_extension( $extension );
		}
	}

	/**
	 * [set_option_name description]
	 * @method set_option_name
	 * @param  string          $name [description]
	 */
	public function set_option_name( $name = '' ) {

		if( $name ) {
			$this->theme_options_name = $name;
		}
	}

	/**
	 * [get_option_name description]
	 * @method get_option_name
	 * @param  string          $name [description]
	 * @return [type]                [description]
	 */
	public function get_option_name( $name = '' ) {
		return $this->theme_options_name;
	}

	// Helper ----------------------------------------

	/**
	 * [get_version description]
	 * @method get_version
	 * @return [type]      [description]
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * [load_theme_part description]
	 * @method load_theme_part
	 * @param  [type]          $slug [description]
	 * @param  [type]          $args [description]
	 * @return [type]                [description]
	 */
	public function load_theme_part( $slug, $args = null ) {
		rella_helper()->get_template_part( 'theme/' . $slug, $args );
	}

	/**
	 * [load_library description]
	 * @method load_library
	 * @param  [type]       $slug [description]
	 * @param  [type]       $args [description]
	 * @return [type]             [description]
	 */
	public function load_library( $slug, $args = null ) {
		rella_helper()->get_template_part( 'rella/libs/' . $slug, $args );
	}

	public function load_assets( $slug ) {
		return get_template_directory_uri() . '/rella/assets/' . $slug;
	}
}

/**
 * Main instance of Rella_Theme.
 *
 * Returns the main instance of Rella_Theme to prevent the need to use globals.
 *
 * @return Rella_Theme
 */
function rella() {
	return Rella_Theme::instance();
}
rella(); // init it

// For developers to hook.
rella_action( 'init' );
