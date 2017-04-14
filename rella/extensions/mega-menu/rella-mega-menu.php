<?php
/**
* Themerella Theme Framework
* The Rella_Theme_Options initiate the theme option machine.
*/

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Load front-end menu walker
require_once 'rella-mega-menu-walker.php';

class Rella_Mega_Menu_Manager extends Rella_Base {

	function __construct() {

		// Custom Fields - Add
		$this->add_filter( 'wp_setup_nav_menu_item',  'setup_nav_menu_item' );

		// Custom Fields - Save
		$this->add_action( 'wp_update_nav_menu_item', 'update_nav_menu_item', 100, 3 );

		// Custom Walker - Edit
		$this->add_filter( 'wp_edit_nav_menu_walker', 'edit_nav_menu_walker', 100, 2 );
	}

	// Custom Fields - Add
    function setup_nav_menu_item( $menu_item ) {

		$menu_item->rella_megaprofile = get_post_meta( $menu_item->ID, '_menu_item_rella_megaprofile', true );
		$menu_item->rella_submenu_color = get_post_meta( $menu_item->ID, '_menu_item_rella_submenu_color', true );
		$menu_item->rella_icon = get_post_meta( $menu_item->ID, '_menu_item_rella_icon', true );
		$menu_item->rella_badge = get_post_meta( $menu_item->ID, '_menu_item_rella_badge', true );
		$menu_item->rella_badge_style = get_post_meta( $menu_item->ID, '_menu_item_rella_badge_style', true );

        return $menu_item;
    }

	// Custom Fields - Save
	function update_nav_menu_item( $menu_id, $menu_item_db_id, $menu_item_data ) {

		if ( isset( $_REQUEST['menu-item-rella-megaprofile'][$menu_item_db_id]) ) {
			update_post_meta($menu_item_db_id, '_menu_item_rella_megaprofile', $_REQUEST['menu-item-rella-megaprofile'][$menu_item_db_id]);
		}

		if ( isset( $_REQUEST['menu-item-rella-submenu-color'][$menu_item_db_id]) ) {
			update_post_meta($menu_item_db_id, '_menu_item_rella_submenu_color', $_REQUEST['menu-item-rella-submenu-color'][$menu_item_db_id]);
		}

		if ( isset( $_REQUEST['menu-item-rella-icon'][$menu_item_db_id]) ) {
			update_post_meta($menu_item_db_id, '_menu_item_rella_icon', $_REQUEST['menu-item-rella-icon'][$menu_item_db_id]);
		}

		if ( isset( $_REQUEST['menu-item-rella-badge'][$menu_item_db_id] ) ) {
			update_post_meta($menu_item_db_id, '_menu_item_rella_badge', $_REQUEST['menu-item-rella-badge'][$menu_item_db_id]);
			update_post_meta($menu_item_db_id, '_menu_item_rella_badge_style', $_REQUEST['menu-item-rella-badge-style'][$menu_item_db_id]);
		}
	}

	// Custom Backend Walker - Edit
	function edit_nav_menu_walker( $walker, $menu_id ) {

		if ( ! class_exists( 'Rella_Mega_Menu_Edit_Walker' ) ) {
			require_once 'rella-mega-menu-edit.php';
		}

		return 'Rella_Mega_Menu_Edit_Walker';
	}
}
new Rella_Mega_Menu_Manager;
