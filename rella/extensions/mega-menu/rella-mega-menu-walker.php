<?php
/**
 * The Menu Walker
 * Menu Walker class extends from Nav Menu Walker
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rella_Mega_Menu_Walker extends Walker_Nav_Menu {

	/**
     * Starts the list before the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of wp_nav_menu() arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"nav-item-children\">\n";
    }

	/**
     * @see Walker::start_el()
     */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$item_html = '';

		if( '[divider]' === $item->title ) {
			$output .= '<li class="menu-item-divider"></li>';
			return;
		}

		if( !empty( $item->rella_megaprofile ) ) {
			$item->classes[] = 'megamenu megamenu-style-alt';
		}

		if( 'default' != $item->rella_submenu_color ) {
			$item->classes[] = 'submenu-dark';
		}

		if( !empty( $item->rella_icon ) ) {
			$args->old_link_before = $args->link_before;
			$args->link_before = '<span class="link-icon"><i class="'. esc_attr( $item->rella_icon ) .'"></i></span>' . $args->link_before;
		}

		if( !empty( $args->caret_visibility ) && ( $item->hasChildren || !empty( $item->rella_megaprofile ) ) ) {
			$args->old_link_after = $args->link_after;
			$args->link_after = $args->link_after . '<i class="fa fa-caret-down"></i>';
		}

		if( !empty( $item->rella_badge ) ) {
			$args->old_link_after = $args->link_after;
			$args->link_after = $args->link_after . '<mark class="'. esc_attr( $item->rella_badge_style ) .'">'. esc_html( $item->rella_badge ) . '</mark>';
		}

		if( isset( $args->nav_style ) && 'onepage' === $args->nav_style ) {
			$item->classes[] = 'local-scroll';
		}

        parent::start_el( $item_html, $item, $depth, $args, $id );

		if( !empty( $args->old_link_before ) ) {
			$args->link_before = $args->old_link_before;
			$args->old_link_before = '';
		}

		if( !empty( $args->old_link_after ) ) {
			$args->link_after = $args->old_link_after;
			$args->old_link_after = '';
		}

		if( !empty( $item->rella_megaprofile ) ) {
			$item_html .= $this->get_megamenu( $item->rella_megaprofile );
		}

		$output .= $item_html;
	}

	function get_megamenu( $id ) {
		$post = get_post( $id );
        $content = do_shortcode( $post->post_content );

		$css = rella_helper()->get_vc_custom_css( $id );

        return $css . '<ul class="nav-item-children"><li><div class="container">' . $content . '</div></li></ul>';
	}

	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		// check whether this item has children, and set $item->hasChildren accordingly
		$element->hasChildren = isset( $children_elements[$element->ID] ) && !empty( $children_elements[$element->ID] );

		return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
}
