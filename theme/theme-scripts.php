<?php
/**
 * The Asset Manager
 * Enqueue scripts and styles for the frontend
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rella_Theme_Assets extends Rella_Base {

    /**
     * Hold data for wa_theme for frontend
     * @var array
     */
    private static $theme_json = array();

	/**
	 * [__construct description]
	 * @method __construct
	 */
    public function __construct() {

        // Frontend
        $this->add_action( 'wp_enqueue_scripts', 'dequeue', 2 );
        $this->add_action( 'wp_enqueue_scripts', 'register' );
        $this->add_action( 'wp_enqueue_scripts', 'woo_register' );
        $this->add_action( 'wp_enqueue_scripts', 'enqueue' );
		$this->add_action( 'wp_enqueue_scripts', 'woocommerce' );
        $this->add_action( 'wp_footer', 'script_data' );

        self::add_config( 'uris', array(
            'ajax'    => admin_url('admin-ajax.php', 'relative')
        ));
    }

    /**
     * Unregister Scripts and Styles
     * @method dequeue
     * @return [type]  [description]
     */
    public function dequeue() {

		wp_dequeue_script( 'wp-mediaelement' );

    }

    /**
     * Register Scripts and Styles
     * @method register
     * @return [type]   [description]
     */
    public function register() {

        // Styles --------------------------------------------------------------------------------
		$header = rella_get_header_layout();
		$font = isset( $header['typography']['font-family'] ) ? $header['typography']['font-family'] . ':100,200,300,400,500,600,700,800,900' : '';

		//print_r($header['typography']);
        $this->style('google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|' . $font);

		// Icons
		$this->style('rella-icons', $this->get_vendor_uri('rella-font-icon/css/rella-font-icon.css'));
		$this->style('font-awesome', $this->get_vendor_uri('font-awesome/css/font-awesome.min.css'));

		// Vendors
		$this->style('bootstrap', $this->get_vendor_uri('bootstrap/css/bootstrap.min.css'));
		$this->style('bootstrap-1275', $this->get_vendor_uri('bootstrap/css/bootstrap-1275.min.css'));

		$this->style('flickity', $this->get_vendor_uri('flickity/flickity.min.css'));

		$this->style('progressively', $this->get_vendor_uri('progressively/progressively.min.css'));

		$this->style('magnific-popup', $this->get_vendor_uri('magnific-popup/magnific-popup.css'));

		$this->style('jquery-ui', $this->get_vendor_uri('jquery-ui/jquery-ui.min.css'));
		$this->style('jquery-ui-timepicker', $this->get_vendor_uri('jquery-ui/jquery-ui.timepicker.css'));

        $this->style('base', get_template_directory_uri() . '/style.css');
        $this->style('theme', $this->get_css_uri('theme.min'));
		$this->style('theme-blog', $this->get_css_uri('theme-blog.min'));
        $this->style('theme-animate', $this->get_css_uri('theme-animate'));
		$this->style('theme-portfolio', $this->get_css_uri('theme-portfolio.min'));
        $this->style('theme-elements', $this->get_css_uri('theme-elements.min'));
        $this->style('custom', $this->get_css_uri('custom'));


		// Register ----------------------------------------------------------

		// Essentials
		$this->script( 'modernizr', $this->get_vendor_uri( 'modernizr.min.js' ), array( 'jquery' ), false );
		$this->script( 'img-aspect-ratio', $this->get_vendor_uri( 'img-aspect-ratio.min.js' ), array( 'jquery' ), false );
		$this->script( 'bootstrap', $this->get_vendor_uri( 'bootstrap/js/bootstrap.min.js' ) );
		$this->script( 'imagesloaded', $this->get_vendor_uri( 'imagesloaded.pkgd.min.js' ), array( 'jquery' ) );

		$deps = array(
			'modernizr',
			'bootstrap',
			'imagesloaded',
		);

		// Progressivelly load
		if( rella_helper()->get_option( 'enable-lazy-load' ) ) {
			$this->script( 'progressively', $this->get_vendor_uri( 'progressively/progressively.min.js' ), array( 'img-aspect-ratio' ) );
			array_push( $deps,
				'progressively'
			);
		}

		// Plugins
		$this->script( 'jquery-appear', $this->get_vendor_uri( 'jquery.appear.js' ), array( 'jquery' ) );

		$this->script( 'magnific-popup', $this->get_vendor_uri( 'magnific-popup/jquery.magnific-popup.min.js' ), array( 'jquery' ) );
		$this->script( 'google-maps-api', '//maps.googleapis.com/maps/api/js?key=' . rella_helper()->get_theme_option( 'google-api-key' ) );
		$this->script( 'in-view', $this->get_vendor_uri( 'jquery.inview.min.js' ) );
		$this->script( 'vivus', $this->get_vendor_uri( 'vivus.min.js' ) );
		$this->script( 'typed', $this->get_vendor_uri( 'typed.min.js' ) );

		$this->script( 'countdown-plugin',$this->get_vendor_uri( 'countdown/jquery.plugin.min.js' ) );
		$this->script( 'jquery-countdown',$this->get_vendor_uri( 'countdown/jquery.countdown.min.js' ), array( 'countdown-plugin' ) );
		$this->script( 'TweenMax', $this->get_vendor_uri( 'greensock/TweenMax.min.js' ), array( 'jquery' ) );
		$this->script( 'flickity', $this->get_vendor_uri( 'flickity/flickity.pkgd.min.js' ), array( 'jquery', 'TweenMax' ) );
		$this->script( 'jquery-countTo', $this->get_vendor_uri( 'jquery.countTo.js' ) );
		$this->script( 'jquery-panr', $this->get_vendor_uri( 'jquery.panr.js' ) );
		$this->script( 'circle-progress', $this->get_vendor_uri('circle-progress.min.js'));
		$this->script( 'mCustom-scrollbar', $this->get_vendor_uri('mCustom-scrollbar/jquery.mCustomScrollbar.concat.min.js'));

		$this->script( 'hammer', $this->get_vendor_uri( 'hammer.min.js' ) );
		$this->script( 'jquery-hammer', $this->get_vendor_uri( 'jquery.hammer.js' ), array( 'hammer' ) );

		$this->script( 'retina', $this->get_vendor_uri( 'retina.min.js' ) );

		if( is_singular( 'rella-portfolio' ) ) {
			array_push( $deps,
				'jquery-appear',
				'flickity',
				'image-comparison',
				'adaptive-backgrounds',
				'jquery-scrollmagic',
				'animation-gsap',
				'packery-mode',
				'jquery-matchHeight'
			);
		}

		// Fullscreen Nav
		$this->script( 'jquery-dlmenu', $this->get_vendor_uri( 'jquery.dlmenu.js' ) );

		// jQuery UI
		$this->script( 'jquery-ui', $this->get_vendor_uri( 'jquery-ui/jquery-ui.min.js'), array( 'jquery' ) );
		$this->script( 'jquery-ui-timepicker', $this->get_vendor_uri( 'jquery-ui/jquery-ui.timepicker.min.js' ), array( 'jquery-ui' ) );

		// ScrollMagic
		$this->script( 'scrollmagic', $this->get_vendor_uri( 'scrollmagic/minified/ScrollMagic.min.js' ) );
		$this->script( 'jquery-scrollmagic', $this->get_vendor_uri( 'scrollmagic/minified/plugins/jquery.ScrollMagic.min.js' ), array( 'scrollmagic' ) );
		$this->script( 'animation-gsap', $this->get_vendor_uri( 'scrollmagic/minified/plugins/animation.gsap.min.js' ), array( 'scrollmagic' ) );
		$this->script( 'ScrollToPlugin', $this->get_vendor_uri( 'greensock/plugins/ScrollToPlugin.min.js' ) );

		array_push( $deps,
			'jquery-ui',
			'ScrollToPlugin',
			'retina'
		);

		// Portfolio & Blog
		$this->script( 'rella-isotope', $this->get_vendor_uri( 'isotope.min.js' ) );
		$this->script( 'packery-mode', $this->get_vendor_uri( 'packery-mode.pkgd.min.js' ), array( 'rella-isotope') );
		$this->script( 'SplitText', $this->get_vendor_uri( 'greensock/utils/SplitText.min.js' ), array( 'jquery' ) );
		$this->script( 'ofi-polyfill', $this->get_vendor_uri( 'object-fit-polyfill/ofi.min.js' ) );
		$this->script( 'jquery-matchHeight', $this->get_vendor_uri( 'jquery.matchHeight-min.js' ), array( 'rella-isotope' ) );
		$this->script( 'jquery-lettering', $this->get_vendor_uri( 'jquery.lettering.js' ) );
		$this->script( 'image-comparison', $this->get_vendor_uri( 'cd-image-comparison.js' ) );
		$this->script( 'StackBlur', $this->get_vendor_uri( 'StackBlur.js' ) );
		$this->script( 'adaptive-backgrounds', $this->get_vendor_uri( 'jquery.adaptive-backgrounds.js' ) );
		$this->script( 'headroom', $this->get_vendor_uri( 'headroom/headroom.min.js' ) );
		$this->script( 'jquery-headroom', $this->get_vendor_uri( 'headroom/jquery.headroom.js' ), array( 'headroom' ) );

		array_push( $deps,
			'TweenMax',
			'jquery-headroom',
			 'mediaelement'
		);

		// At the End
		$this->script('theme-init', $this->get_js_uri('theme.init'));
		$this->script('theme-plugins', $this->get_js_uri('theme.plugins'), $deps );
		$this->script('custom', $this->get_js_uri('custom'), array( 'theme-plugins', 'theme-init' ) );
    }

    /**
     * Enqueue Scripts and Styles
     * @method enqueue
     * @return [type]  [description]
     */
    public function enqueue() {

		$layout_width = rella_helper()->get_theme_option( 'page-layout-width' );

        // Styles-----------------------------------------------------
		$font_icons = rella_helper()->get_theme_option( 'font-icons' );
		if( !empty( $font_icons ) ) {
			foreach( $font_icons as $handle ) {
				wp_enqueue_style($handle);
			}
		}

		wp_enqueue_style( 'google-fonts' );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'bootstrap' );
		if( 'wide' === $layout_width ) {
			wp_enqueue_style( 'bootstrap-1275' );
		}
		wp_enqueue_style( 'flickity' );
		wp_enqueue_style('progressively');
		wp_enqueue_style('magnific-popup');
		wp_enqueue_style('jquery-ui');
		wp_enqueue_style('jquery-ui-timepicker');
		wp_enqueue_style('jquery-ui-easy');
		wp_enqueue_style('jquery-ui-draggable');
		wp_enqueue_style('base');
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_style('theme');
		wp_enqueue_style('theme-blog');
		wp_enqueue_style('theme-animate');
		wp_enqueue_style('theme-portfolio');
		wp_enqueue_style('theme-elements');
		wp_enqueue_style('theme-shop');
        wp_enqueue_style('custom');

        // Scripts -----------------------------------------------------
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			$scripts[] = 'comment-reply';
		}

		wp_enqueue_script('custom');
	}

    //Register the woocommerce  shop styles
    public function woo_register() {

	    //check if woocommerce is activated and styles are loaded
		$deps = class_exists( 'WooCommerce' ) ? array( 'woocommerce-layout', 'woocommerce-smallscreen', 'woocommerce-general' ) : array();
		$this->style( 'theme-shop', $this->get_css_uri('theme-shop'), $deps );
		wp_enqueue_style( 'theme-shop' );

    }

	/**
	 * Optimize WooCommerce Scripts
	 * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
	 *
	 * @return [type]      [description]
	 */
	public function woocommerce() {

		if ( class_exists('WooCommerce') && ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {

			## Dequeue styles.
			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
			wp_dequeue_style( 'woocommerce-general' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );

			## Dequeue scripts.
			wp_dequeue_script( 'wc-add-payment-method' );
			wp_dequeue_script( 'wc_price_slider' );
			wp_dequeue_script( 'wc-add-to-cart-variation' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );

			wp_dequeue_script( 'wc-cart-fragments' );
			wp_dequeue_script( 'woocommerce' );
			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'wc-checkout' );
			wp_dequeue_script( 'wc-cart' );
			wp_dequeue_script( 'wc-single-product' );
		}
	}

    /**
     * Localize Data Object
     * @method script_data
     * @return [type]      [description]
     */
    public function script_data() {

        wp_localize_script( 'theme-plugins', 'rellaTheme', self::$theme_json );
    }

    // Register Helpers ----------------------------------------------------------
    public function script( $handle, $src, $deps = null, $in_footer = true, $ver = null ) {
        wp_register_script( $handle, $src, $deps, $ver, $in_footer);
    }

    public function style( $handle, $src, $deps = null, $ver = null, $media = 'all' ) {
        wp_register_style( $handle, $src, $deps, $ver, $media );
    }

    /**
     * Add items to JSON object
     * @method add_config
     * @param  [type]     $id    [description]
     * @param  string     $value [description]
     */
    public static function add_config( $id, $value = '' ) {

        if(!$id) {
            return;
        }

        if(isset(self::$theme_json[$id])) {
            if(is_array(self::$theme_json[$id])) {
                self::$theme_json[$id] = array_merge(self::$theme_json[$id],$value);
            }
            elseif(is_string(self::$theme_json[$id])) {
                self::$theme_json[$id] = self::$theme_json[$id].$value;
            }
        }
        else {
            self::$theme_json[$id] = $value;
        }
    }

    // Uri Helpers ---------------------------------------------------------------

    public function get_theme_uri($file = '') {
        return get_template_directory_uri() . '/' . $file;
    }

    public function get_child_uri($file = '') {
        return get_stylesheet_directory_uri() . '/' . $file;
    }

    public function get_css_uri($file = '') {
        return $this->get_theme_uri('assets/css/'.$file.'.css');
    }

    public function get_js_uri($file = '') {
        return $this->get_theme_uri('assets/js/'.$file.'.js');
    }

    public function get_vendor_uri($file = '') {
        return $this->get_theme_uri('assets/vendors/'.$file);
    }
}
new Rella_Theme_Assets;
