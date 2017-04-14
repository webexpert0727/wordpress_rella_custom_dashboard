<?php
/**
 * The Admin Menu Walker
 * Menu Walker class to add fields into menu management screen
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Add new Fields
 * Based on Walker_Nav_Menu_Edit class.
 */
class Rella_Mega_Menu_Edit_Walker extends Walker_Nav_Menu_Edit {

	function __construct() {

		$this->megamenus = get_posts(array(
			'post_type' => 'rella-mega-menu'
		));

		$this->walker_args = array(
			'depth' => 0,
			'child_of' => 0,
			'selected' => 0,
			'value_field' => 'ID'
		);
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$item_output = '';
		parent::start_el($item_output, $item, $depth, $args, $id);

		// Adding new Fields
        $item_output = str_replace( '<fieldset class="field-move', $this->get_fields( $item, $depth, $args, $id ) . '<fieldset class="field-move', $item_output );

        $output .= $item_output;
	}

	function get_fields( $item, $depth = 0, $args = array(), $id = 0 ) {
        ob_start();

        $item_id = esc_attr( $item->ID );
	?>

		<?php if( 0 === $depth ) : ?>
		<p class="description description-wide">
            <label for="edit-menu-item-rella-megaprofile-<?php echo $item_id; ?>">
                <?php esc_html_e( 'Select Mega Menu', 'boo' ); ?><br />
				<select id="edit-menu-item-rella-megaprofile-<?php echo $item_id; ?>" class="widefat" name="menu-item-rella-megaprofile[<?php echo $item_id; ?>]">
					<option value="0"><?php esc_html_e( 'None', 'boo' ) ?></option>
					<?php
						$r = $this->walker_args;
						$r['selected'] = $item->rella_megaprofile;
						echo walk_page_dropdown_tree( $this->megamenus, $r['depth'], $r );
					?>
				</select>
            </label>
        </p>
        
        <p class="description description-wide">
            <label for="edit-menu-item-rella-submenu-color-<?php echo $item_id; ?>">
				<?php esc_html_e( 'Submenu color', 'boo' ); ?><br />
				<select id="edit-menu-item-rella-submenu-color-<?php echo $item_id; ?>" class="widefat" name="menu-item-rella-submenu-color[<?php echo $item_id; ?>]">
					<option value="default" <?php selected( 'default', $item->rella_submenu_color ) ?>><?php esc_html_e( 'Default', 'boo' ); ?></option>
					<option value="submenu-dark" <?php selected( 'submenu-dark', $item->rella_submenu_color ) ?>><?php esc_html_e( 'Dark', 'boo' ); ?></option>
				</select>
            </label>
	    </p>

		<p class="description description-wide">
            <label for="edit-menu-item-rella-badge-<?php echo $item_id; ?>">
                <?php esc_html_e( 'Badge', 'boo' ); ?><br />
                <input type="text" id="edit-menu-item-rella-badge-<?php echo $item_id; ?>" class="widefat" name="menu-item-rella-badge[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->rella_badge ); ?>" />
            </label>
        </p>

		<p class="description description-wide">
            <label for="edit-menu-item-rella-badge-style-<?php echo $item_id; ?>">
                <?php esc_html_e( 'Badge Style', 'boo' ); ?><br />
                <select id="edit-menu-item-rella-badge-style-<?php echo $item_id; ?>" class="widefat" name="menu-item-rella-badge-style[<?php echo $item_id; ?>]">
					<option value="style1" <?php selected( 'style1', $item->rella_badge_style ) ?>><?php esc_html_e( 'Style1', 'boo' ); ?></option>
					<option value="style2" <?php selected( 'style2', $item->rella_badge_style ) ?>><?php esc_html_e( 'Style2', 'boo' ); ?></option>
				</select>
            </label>
        </p>
		<?php endif; ?>

		<p class="description description-wide">
            <label for="edit-menu-item-rella-icon-<?php echo $item_id; ?>">
                <?php esc_html_e( 'Icon', 'boo' ); ?><br />
                <input type="text" id="edit-menu-item-rella-icon-<?php echo $item_id; ?>" class="widefat" name="menu-item-rella-icon[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->rella_icon ); ?>" />
            </label>
        </p>

	<?php
        return ob_get_clean();
    }
}
