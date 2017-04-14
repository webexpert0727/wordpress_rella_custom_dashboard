<?php

if ( !function_exists( 'wbc_change_demo_directory_path' ) ) {

	/**
	 * Change the path to the directory that contains demo data folders.
	 *
	 * @param [string] $demo_directory_path
	 *
	 * @return [string]
	 */

	function wbc_change_demo_directory_path( $demo_directory_path ) {

		//$demo_directory_path = get_template_directory().'/demo-data/';

		return $demo_directory_path;

	}

	// Uncomment the below
	// add_filter('wbc_importer_dir_path', 'wbc_change_demo_directory_path' );
}


if ( !function_exists( 'wbc_extended_example' ) ) {
	function wbc_extended_example( $demo_active_import , $demo_directory_path ) {

		reset( $demo_active_import );
		$current_key = key( $demo_active_import );

		/************************************************************************
		* Import slider(s) for the current demo being imported
		*************************************************************************/

		if ( class_exists( 'RevSlider' ) ) {

			//If it's demo3 or demo5
			$wbc_sliders_array = array(
				'demo3' => 'someslidername.zip', //Set slider zip name
				'demo5' => 'anotherslider.zip', //Set slider zip name
			);

			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
				$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];

				if ( file_exists( $demo_directory_path.$wbc_slider_import ) ) {
					$slider = new RevSlider();
					$slider->importSliderFromPost( true, true, $demo_directory_path.$wbc_slider_import );
				}
			}
		}

		/************************************************************************
		* Setting Menus
		*************************************************************************/

		// If it's demo1 - demo6
		$wbc_menu_array = array( 'demo1', 'demo2', 'demo3', 'demo4', 'demo5', 'demo6' );

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
			$top_menu = get_term_by( 'name', 'Temp Menu', 'nav_menu' );

			if ( isset( $top_menu->term_id ) ) {
				set_theme_mod( 'nav_menu_locations', array(
						'theme-primary' => $top_menu->term_id,
						'theme-footer'  => $top_menu->term_id
					)
				);
			}

		}

		/************************************************************************
		* Set HomePage
		*************************************************************************/

		// array of demos/homepages to check/select from
		$wbc_home_pages = array(
			'demo1' => 'Home Page v1',
			'demo2' => 'Home Page v2',
			'demo3' => 'Home Page v3',
			'demo4' => 'Home Page v4',
			'demo5' => 'Home Page v5',
			'demo6' => 'Home Page v6',
		);

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
			$page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $page->ID ) ) {
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
			}
		}

	}


	// Uncomment the below
	// add_action( 'wbc_importer_after_content_import', 'wbc_extended_example', 10, 2 );
}


	// redux extension loader script
	if(!function_exists('boo_redux_register_custom_extension_loader')) :
		function boo_redux_register_custom_extension_loader($ReduxFramework) {

			// path to redux extensions
			$redux_extensions_path = '';

			// loading wbc_importer extension
			$extension_class_wbc_importer = 'ReduxFramework_extension_wbc_importer';
			if( !class_exists( $extension_class_wbc_importer ) ) {
				
				// In case you wanted override your override, hah.
				$class_file = $redux_extensions_path . 'wbc_importer/extension_wbc_importer.php';
				$class_file = apply_filters( 'redux/extension/'.$ReduxFramework->args['opt_name'].'/wbc_importer', $class_file );
				if( $class_file ) {
					require_once( $class_file );
					$extension = new $extension_class_wbc_importer( $ReduxFramework );
				}
			}

		}
		
		add_action("redux/extensions/prefix_opt_name/before", 'boo_redux_register_custom_extension_loader', 0);
	endif;
?>
