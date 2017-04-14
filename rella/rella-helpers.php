<?php
/**
 * The Helper
 * Contains all the helping functions
 *
 *
 * Table of Content
 *
 * 1. WordPress Helpers
 * 2. Markup Helpers
 * 3. Theme Options/Meta Helpers
 * 4. Array opperations
 */

/**
 * Main helper functions.
 *
 * @class Rella_Helper
*/
class Rella_Helper {

	/**
	 * Hold an instance of Rella_Helper class.
	 * @var Rella_Helper
	 */
	protected static $instance = null;

	/**
	 * Main Rella_Helper instance.
	 *
	 * @return Rella_Helper - Main instance.
	 */
	public static function instance() {

		if(null == self::$instance) {
			self::$instance = new Rella_Helper();
		}

		return self::$instance;
	}




	// 1. WordPress Helpers -----------------------------------------------

	/**
	 * [ajax_url description]
	 * @method ajax_url
	 * @return [type]   [description]
	 */
	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}

	/**
	 * [get_sidebars description]
	 * @method get_sidebars
	 * @param  array        $data [description]
	 * @return [type]             [description]
	 */
	public function get_sidebars( $data = array() ) {
		global $wp_registered_sidebars;

        foreach ( $wp_registered_sidebars as $key => $value ) {
            $data[ $key ] = $value['name'];
        }

		return $data;
	}


	/**
	 * Perform a HTTP HEAD or GET request.
	 *
	 * If $file_path is a writable filename, this will do a GET request and write
	 * the file to that path.
	 *
	 * This is a re-implementation of the deprecated wp_get_http() function from WP Core,
	 * but this time using the recommended WP_Http() class and the WordPress filesystem.
	 *
	 * @param string      $url       URL to fetch.
	 * @param string|bool $file_path Optional. File path to write request to. Default false.
	 * @param array       $args      Optional. Arguments to be passed-on to the request.
	 * @return bool|string False on failure and string of headers if HEAD request.
	 */
	function wp_get_http( $url = false, $file_path = false, $args = array() ) {

		// No need to proceed if we don't have a $url or a $file_path.
		if ( ! $url || ! $file_path ) {
			return false;
		}

		$try_file_get_contents = false;

		// Make sure we normalize $file_path.
		$file_path = wp_normalize_path( $file_path );

		// Include the WP_Http class if it doesn't already exist.
		if ( ! class_exists( 'WP_Http' ) ) {
			include_once( wp_normalize_path( ABSPATH . WPINC . '/class-http.php' ) );
		}
		// Inlude the wp_remote_get function if it doesn't already exist.
		if ( ! function_exists( 'wp_remote_get' ) ) {
			include_once( wp_normalize_path( ABSPATH . WPINC . '/http.php' ) );
		}

		$args = wp_parse_args( $args, array(
			'timeout'    => 30,
			'user-agent' => 'rella-user-agent',
		) );
		$response = wp_remote_get( esc_url_raw( $url ), $args );
		$body     = wp_remote_retrieve_body( $response );

		// Try file_get_contents if body is empty.
		if ( empty( $body ) ) {
			if ( function_exists( 'ini_get' ) && ini_get( 'allow_url_fopen' ) ) {
				$body = @file_get_contents( $url );
			}
		}

		// Initialize the Wordpress filesystem.
		$wp_filesystem = $this->init_filesystem();

		if ( ! defined( 'FS_CHMOD_DIR' ) ) {
			define( 'FS_CHMOD_DIR', ( 0755 & ~ umask() ) );
		}
		if ( ! defined( 'FS_CHMOD_FILE' ) ) {
			define( 'FS_CHMOD_FILE', ( 0644 & ~ umask() ) );
		}

		// Attempt to write the file.
		if ( ! $wp_filesystem->put_contents( $file_path, $body, FS_CHMOD_FILE ) ) {
			// If the attempt to write to the file failed, then fallback to fwrite.
			@unlink( $file_path );
			$fp = fopen( $file_path, 'w' );
			$written = fwrite( $fp, $body );
			fclose( $fp );
			if ( false === $written ) {
				return false;
			}
		}

		// If all went well, then return the headers of the request.
		if ( isset( $response['headers'] ) ) {
			$response['headers']['response'] = $response['response']['code'];
			return $response['headers'];
		}

		// If all else fails, then return false.
		return false;
	}

	/**
	 * Instantiates the WordPress filesystem for use with Boo.
	 *
	 * @static
	 * @access public
	 * @return object
	 */
	public function init_filesystem() {

		if ( ! defined( 'FS_METHOD' ) ) {
			define( 'FS_METHOD', 'direct' );
		}

		// The Wordpress filesystem.
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		return $wp_filesystem;
	}

	/**
	 * [get_template_part description]
	 * @method get_template_part
	 * @param  [type]            $template [description]
	 * @param  [type]            $args     [description]
	 * @return [type]                      [description]
	 */
	public function get_template_part( $template, $args = null ) {

		if ( $args && is_array( $args ) ) {
			extract( $args );
		}

		$located = locate_template( $template . '.php' );

		if ( ! file_exists( $located ) ) {
			_doing_it_wrong( __FUNCTION__, sprintf( __( '<code>%s</code> does not exist.', 'boo' ), $located ), null );
			return;
		}

		include $located;
	}

	/**
	 * [get_theme_name description]
	 * @method get_theme_name
	 * @return [type]         [description]
	 */
	public function get_current_theme() {
		$current_theme = wp_get_theme();
		if( $current_theme->parent_theme ) {
			$template_dir  = basename( get_template_directory() );
			$current_theme = wp_get_theme( $template_dir );
		}

		return $current_theme;
	}

	/**
	 * Generate plugin action link
	 * @return html
	 */
	public function tgmpa_plugin_action( $plugin, $status ) {

		$btn_class = $btn_text = $nonce_url = '';
		$page = admin_url( 'admin.php?page=' . $_GET['page'] );

		switch( $status ) {
			case 'not-installed':
				$btn_class = 'white';
				$btn_text = esc_html_x( 'Install', 'Rella plugin installation page.', 'boo' );

				$nonce_url = wp_nonce_url(
					add_query_arg(
						array(
							'plugin' => urlencode( $plugin['slug'] ),
							'tgmpa-install' => 'install-plugin',
							'return_url' => $_GET['page']
						),
						TGM_Plugin_Activation::$instance->get_tgmpa_url()
					),
					'tgmpa-install',
					'tgmpa-nonce'
				);
				break;

			case 'installed':
				$btn_class = 'success';
				$btn_text = esc_html_x( 'Activate', 'Rella plugin installation page.', 'boo' );

				$nonce_url = wp_nonce_url(
					add_query_arg(
						array(
							'plugin' => urlencode( $plugin['slug'] ),
							'rella-activate' => 'activate-plugin'
						),
						$page
					),
					'rella-activate',
					'rella-activate-nonce'
				);
				break;

			case 'active':
				$btn_class = 'danger';
				$btn_text = esc_html_x( 'Deactivate', 'Rella plugin installation page.', 'boo' );

				$nonce_url = wp_nonce_url(
					add_query_arg(
						array(
							'plugin' => urlencode( $plugin['slug'] ),
							'rella-deactivate' => 'deactivate-plugin'
						),
						$page
					),
					'rella-deactivate',
					'rella-deactivate-nonce'
				);
				break;
		}

		printf(
			'<a class="rella-button" href="%4$s" title="%2$s %1$s"><span>%2$s</span> <i class="fa fa-angle-right"></i></a>',
			$plugin['name'], $btn_text, $btn_class, esc_url( $nonce_url )
		);
	}

	/**
	 * [sanitize_html_classes description]
	 * @method sanitize_html_classes
	 * @return (mixed: string / $fallback ) [description]
	 */
	public function sanitize_html_classes( $class, $fallback = null ) {

		// Explode it, if it's a string
		if ( is_string( $class ) ) {
			$class = explode( ' ', $class );
		}

		if ( is_array( $class ) && !empty( $class ) ) {
			$class = array_map( 'sanitize_html_class', $class );
			return join( ' ', $class );
		}
		else {
			return sanitize_html_class( $class, $fallback );
		}

	}

	/**
	 * Adds all variables from $_GET array to given URL and returns this URL
	 * @param type $url url
	 * @param type $skip array of variables to skip
	 * @return type
	 */
	public function add_to_url_from_get( $url, $skip = array() ) {

		if ( isset( $_GET ) && is_array( $_GET ) ) {
			foreach ( $_GET as $key => $val ) {
				if ( in_array( $key, $skip ) ) {
					continue;
				}
				$url = add_query_arg( $key . '=' . $val, '', $url );
			}
		}
		return $url;
	}

	/**
	 * [has_seo_plugins description]
	 * @method has_seo_plugins
	 * @return boolean         [description]
	 */
	public function has_seo_plugins() {

		$plugins = array(
			'yoast' => defined( 'WPSEO_VERSION' ),
			'ainseop' => defined( 'AIOSEOP_VERSION' )
		);

		foreach( $plugins as $item ) {
			if( $item ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * [get_menu_location_name description]
	 * @method get_menu_location_name
	 * @param  [type]                 $location [description]
	 * @return [type]                           [description]
	 */
	public function get_menu_location_name( $location ) {

		$locations = get_registered_nav_menus();

		return isset( $locations[ $location ] ) ? $locations[ $location ] : '';
	}

	/**
	 * [get_attachment_types description]
	 * @method get_attachment_types
	 * @param  integer              $post_id [description]
	 * @return [type]                        [description]
	 */
	public function get_attachment_types( $post_id = 0 ) {

		$post_id   = empty( $post_id ) ? get_the_ID() : $post_id;
		$mime_type = get_post_mime_type( $post_id );

		list( $type, $subtype ) = false !== strpos( $mime_type, '/' ) ? explode( '/', $mime_type ) : array( $mime_type, '' );

		return (object) array( 'type' => $type, 'subtype' => $subtype );
	}

	/**
	 * [get_attachment_type description]
	 * @method get_attachment_type
	 * @param  integer             $post_id [description]
	 * @return [type]                       [description]
	 */
	public function get_attachment_type( $post_id = 0 ) {
		return $this->get_attachment_types( $post_id )->type;
	}

	/**
	 * [get_attachment_subtype description]
	 * @method get_attachment_subtype
	 * @param  integer                $post_id [description]
	 * @return [type]                          [description]
	 */
	public function get_attachment_subtype( $post_id = 0 ) {
		return $this->get_attachment_types( $post_id )->subtype;
	}

	/**
	 * [is_attachment_audio description]
	 * @method is_attachment_audio
	 * @param  integer             $post_id [description]
	 * @return boolean                      [description]
	 */
	public function is_attachment_audio( $post_id = 0 ) {
		return 'audio' === $this->get_attachment_type( $post_id );
	}

	/**
	 * [is_attachment_video description]
	 * @method is_attachment_video
	 * @param  integer             $post_id [description]
	 * @return boolean                      [description]
	 */
	public function is_attachment_video( $post_id = 0 ) {
		return 'video' === $this->get_attachment_type( $post_id );
	}

	/**
	 * Function for figuring out if we're viewing a "plural" page.  In WP, these pages after_header
	 * archives, search results, and the home/blog posts index.
	 * @method is_plural
	 * @return boolean          [description]
	 */
	public function is_plural() {
		return ( is_home() || is_archive() || is_search() );
	}

	public function get_vc_custom_css( $id ) {

		$out = '';

		if ( ! $id ) {
			return;
		}

		$post_custom_css = get_post_meta( $id, '_wpb_post_custom_css', true );
		if ( ! empty( $post_custom_css ) ) {
			$post_custom_css = strip_tags( $post_custom_css );
			$out .= '<style type="text/css" data-type="vc_custom-css">';
			$out .= $post_custom_css;
			$out .= '</style>';
		}

		$shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $shortcodes_custom_css ) ) {
			$shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
			$out .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
			$out .= $shortcodes_custom_css;
			$out .= '</style>';
		}

		return $out;
	}





	// 2. Markup Helpers -----------------------------------------------


	public function output_css( $styles = array() ) {

		// If empty return false
		if ( empty( $styles ) ) {
			return false;
		}

		$out = '';
		foreach ( $styles as $key => $value ) {

			if( ! $value ) {
				continue;
			}

			if( is_array( $value ) ) {

				switch( $key ) {

					case 'padding':
					case 'margin':
						$new_value = '';
						foreach( $value as $k => $v ) {

							if( '' != $v ) {
								$out .= sprintf( '%s: %s;', esc_html( $k ), $this->sanitize_unit($v) );
							}
						}
						break;

					default:
						$value = join( ';', $value );
				}
			}
			else {
				$out .= sprintf( '%s: %s;', esc_html( $key ), $value );
			}
		}

		return rtrim( $out, ';' );
	}

	public function sanitize_unit( $value ) {

		if( $this->str_contains( 'em', $value ) || $this->str_contains( 'rem', $value ) || $this->str_contains( '%', $value ) || $this->str_contains( 'px', $value ) ) {
			return $value;
		}

		return $value.'px';
	}

	/**
	 * Check if the string contains the given value.
	 *
	 * @param  string	$needle   The sub-string to search for
	 * @param  string	$haystack The string to search
	 *
	 * @return bool
	 */
    public function str_contains( $needle, $haystack ) {
        return strpos( $haystack, $needle ) !== false;
    }

	/**
	 * [str_starts_with description]
	 * @method str_starts_with
	 * @param  [type]          $needle   [description]
	 * @param  [type]          $haystack [description]
	 * @return [type]                    [description]
	 */
	public function str_starts_with( $needle, $haystack ) {
		return substr( $haystack, 0, strlen( $needle ) ) === $needle;
	}

	/**
	 * [html_attributes description]
	 *
	 * @method html_attributes
	 * @param  array           $attributes [description]
	 *
	 * @return [type]                [description]
	 */
	public function html_attributes( $attributes = array(), $prefix = '' ) {

		// If empty return false
		if ( empty( $attributes ) ) {
			return false;
		}

		$options = false;
		if( isset( $attributes['data-options'] ) ) {
			$options = $attributes['data-options'];
			unset( $attributes['data-options'] );
		}

		$out = '';
		foreach ( $attributes as $key => $value ) {

			if( ! $value ) {
				continue;
			}

			$key = $prefix . $key;
			if( true === $value ) {
				$value = 'true';
			}

			if( false === $value ) {
				$value = 'false';
			}

			if( is_array( $value ) ) {
				$out .= sprintf( ' %s=\'%s\'', esc_html( $key ), json_encode( $value ) );
			}
			else {
				$out .= sprintf( ' %s="%s"', esc_html( $key ), esc_attr( $value ) );
			}
		}

		if( $options ) {
			$out .= sprintf( ' data-options=\'%s\'', $options );
		}

		return $out;
	}

	public function attr( $context, $attributes = array() ) {
		echo $this->get_attr( $context, $attributes );
	}

	/**
	 * [get_attr description]
	 * @method get_attr
	 * @param  [type] $context    [description]
	 * @param  array  $attributes [description]
	 * @return [type]             [description]
	 */
	public function get_attr( $context, $attributes = array() ) {

		$defaults = array(
			'class' => sanitize_html_class( $context )
		);

		$attributes = wp_parse_args( $attributes, $defaults );
		$attributes = apply_filters( "rella_attr_{$context}", $attributes, $context );

		$output = $this->html_attributes( $attributes );
	    $output = apply_filters( "rella_attr_{$context}_output", $output, $attributes, $context );

	    return trim( $output );
	}





	// 3. Option Helpers -----------------------------------------------

	/**
	 * [get_option description]
	 * @method get_option
	 * @param  [type]     $id      [description]
	 * @param  boolean    $default [description]
	 * @param  string     $context [description]
	 * @param  string     $esc     [description]
	 */
    public function get_option_e( $id, $esc = 'raw', $default = false, $context = 'all' ) {
        echo $this->get_option( $id, $esc, $default, $context );
    }

	/**
	 * [get_option description]
	 * @method get_option
	 * @param  [type]     $id      [description]
	 * @param  boolean    $default [description]
	 * @param  string     $context [description]
	 * @param  string     $esc     [description]
	 * @return [type]              [description]
	 */
	public function get_option( $id, $esc = 'raw', $default = '', $context = 'all' ) {

		$value = false;
		$keys = explode( '.', $id );
		$id = array_shift( $keys );

		// Get first value from context
		switch( $context ) {

			case 'options':
				$value = $this->get_theme_option( $id );
				break;

			case 'post':
				$value = $this->get_post_meta( $id );
				break;

			default:
				$value = $this->get_post_meta( $id );
				$value = '' != $value ? $value : $this->get_theme_option( $id );
				break;
		}

		// parsing dot notation
		if( ! empty( $keys ) ) {
			foreach( $keys as $inner_key ) {

				if( isset( $value[$inner_key] ) ) {
					$value = $value[$inner_key];
				}
				else {
					break;
				}
			}
		}

		// Set default value if no value
		$value = ! empty( $value ) ? $value : $default;

		// Escape the value
		switch( $esc ) {

			case 'attr':
				$value = esc_attr( $value );
				break;

			case 'url':
				$value = esc_url( $value );
				break;

			case 'html':
				$value = esc_html( $value );
				break;

			case 'post':
				$value = wp_kses_post( $value );
				break;
		}

		// Return default
		return $value;
	}

	/**
	 * [get_post_meta description]
	 * @method get_post_meta
	 * @param  [type]        $id [description]
	 * @return [type]            [description]
	 */
	public function get_post_meta( $id, $post_id = null ) {

		if ( is_null( $post_id ) ) {
			$post_id = $this->get_current_page_id();
		}

		if ( ! $post_id ) {
			return;
		}

		$value = get_post_meta( $post_id, $id, true );
		if( is_array( $value ) ) {
			$value = array_filter($value);

			if( empty( $value ) ) {
				return '';
			}
		}
		return $value ? $value : '';
	}

	public function get_current_page_id() {

		global $post;
		$page_id = false;
		$object_id = is_null($post) ? get_queried_object_id() : $post->ID;

		// If we're on search page, set to false
		if( is_search() ) {
			$page_id = false;
		}
		// If we're not on a singular post, set to false
		if( ! is_singular() ) {
			$page_id = false;
		}
		// Use the $object_id if available
		if( ! is_home() && ! is_front_page() && ! is_archive() && isset( $object_id ) ) {
			$page_id = $object_id;
		}
		// if we're on front-page
		if( ! is_home() && is_front_page() && isset( $object_id ) ) {
			$page_id = $object_id;
		}
		// if we're on posts-page
		if( is_home() && ! is_front_page() ) {
			$page_id = get_option( 'page_for_posts' );
		}
		// The woocommerce shop page
		if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
			if( $shop_page = wc_get_page_id( 'shop' ) ) {
				$page_id = $shop_page;
			}
		}
		// if in the loop
		if( in_the_loop() ) {
			$page_id = get_the_ID();
		}

		return $page_id;
	}

	/**
	 * Check if woocommerce class exists
	 * @return boolean
	 */

	public function is_woocommerce_active() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}

	/**
	 * [get_theme_option description]
	 * @method get_theme_option
	 * @param  [type]           $id [description]
	 * @return [type]               [description]
	 */
	public function get_theme_option( $id ) {

		$options = $GLOBALS[rella()->get_option_name()];

		if( empty( $options ) || ! isset( $options[$id] ) ) {
			return '';
		}

		return $options[$id];
	}

	/**
	 * [dashboard_page_url description]
	 * @method dashboard_page_url
	 * @return [type]             [description]
	 */
	public function dashboard_page_url() {

		if( isset( $_GET['page'] ) && 'rella' === $_GET['page'] ) {
			return '';
		}
		return admin_url( 'admin.php?page=rella' );
	}

	/**
	 * [plugin_page_url description]
	 * @method plugin_page_url
	 * @return [type]          [description]
	 */
	public function plugin_page_url() {
		return admin_url( 'admin.php?page=rella-plugins' );
	}

	/**
	 * [import_demo_url description]
	 * @method import_demos_page_url
	 * @return [type]          [description]
	 */
	public function import_demos_page_url() {
		return admin_url( 'admin.php?page=rella-import-demos' );
	}
}

/**
 * Main instance of Rella_Helper.
 *
 * Returns the main instance of Rella_Helper to prevent the need to use globals.
 *
 * @return Rella_Helper
 */
function rella_helper() {
	return Rella_Helper::instance();
}
