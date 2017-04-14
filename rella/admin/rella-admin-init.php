<?php
/**
* Themerella Theme Framework
* The Rella_Admin initiate the theme admin
*/

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rella_Admin extends Rella_Base {

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {

		// Envato Market
		rella()->load_library( 'wp-envato-market/envato-market' );
		get_template_part( 'rella/libs/importer/rella', 'importer' );

		$this->add_action( 'init', 'init', 7 );
		$this->add_action( 'admin_init', 'save_plugins' );
		$this->add_action( 'admin_enqueue_scripts', 'enqueue', 99 );
		$this->add_action( 'admin_menu', 'fix_parent_menu', 999 );

		$this->add_action( 'vc_backend_editor_enqueue_js_css', 'vc_iconpicker_editor_jscss' );
		$this->add_action( 'vc_frontend_editor_enqueue_js_css', 'vc_iconpicker_editor_jscss' );
	}

	/**
	 * [init description]
	 * @method init
	 * @return [type] [description]
	 */
	public function init() {

		rella()->load_theme_part( 'theme-register-plugins' );

		include_once 'rella-admin-page.php';
		include_once 'rella-admin-dashboard.php';
		include_once 'rella-admin-plugins.php';
		include_once 'rella-admin-import.php';
	}

	/**
	 * [enqueue description]
	 * @method enqueue
	 * @return [type] [description]
	 */
    public function enqueue() {

		wp_enqueue_style( 'rella-admin', rella()->load_assets( 'css/rella-admin.css' ) );
		wp_enqueue_style( 'rella-redux', rella()->load_assets( 'css/rella-redux.css' ) );
		wp_enqueue_style( 'font-awesome', rella()->load_assets( 'css/font-awesome.min.css' ) );

		wp_enqueue_script( 'rella-modernizr', rella()->load_assets( 'js/modernizr-custom.js' ), array( 'jquery' ), false, false );
		wp_enqueue_script( 'rella-admin', rella()->load_assets( 'js/rella-admin.js' ), array( 'jquery', 'underscore' ), false, true );

		// Icons
		$uri = get_template_directory_uri() . '/assets/vendors/' ;
		wp_register_style('rella-icons', $uri . 'rella-font-icon/css/rella-font-icon.css' );

    }

	public function vc_iconpicker_editor_jscss() {
		$font_icons = rella_helper()->get_theme_option( 'font-icons' );
		if( !empty( $font_icons ) ) {
			foreach( $font_icons as $handle ) {
				wp_enqueue_style($handle);
			}
		}
	}

	/**
	 * [fix_parent_menu description]
	 * @method fix_parent_menu
	 * @return [type]          [description]
	 */
	public function fix_parent_menu() {
		global $submenu;

		$submenu['rella'][0][0] = esc_html__( 'Dashboard', 'boo' );

		remove_submenu_page( 'themes.php', 'tgmpa-install-plugins' );
	}

	/**
	 * [save_plugins description]
	 * @method save_plugins
	 * @return [type]       [description]
	 */
	public function save_plugins() {

        if ( !current_user_can( 'edit_theme_options' ) ) {
            return;
        }

		// Deactivate Plugin
        if ( isset( $_GET['rella-deactivate'] ) && 'deactivate-plugin' == $_GET['rella-deactivate'] ) {

			check_admin_referer( 'rella-deactivate', 'rella-deactivate-nonce' );

			$plugins = TGM_Plugin_Activation::$instance->plugins;

			foreach( $plugins as $plugin ) {
				if ( $plugin['slug'] == $_GET['plugin'] ) {

					deactivate_plugins( $plugin['file_path'] );

                    wp_redirect( admin_url( 'admin.php?page=' . $_GET['page'] ) );
					exit;
				}
			}
		}

		// Activate plugin
		if ( isset( $_GET['rella-activate'] ) && 'activate-plugin' == $_GET['rella-activate'] ) {

			check_admin_referer( 'rella-activate', 'rella-activate-nonce' );

			$plugins = TGM_Plugin_Activation::$instance->plugins;

			foreach( $plugins as $plugin ) {
				if ( $plugin['slug'] == $_GET['plugin'] ) {

					activate_plugin( $plugin['file_path'] );

					wp_redirect( admin_url( 'admin.php?page=' . $_GET['page'] ) );
					exit;
				}
			}
		}
    }
}
new Rella_Admin;
