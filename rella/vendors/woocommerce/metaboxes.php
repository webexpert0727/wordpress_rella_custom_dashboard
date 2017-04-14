<?php
/**
 * Custom metabox fields
 *
 * @package rella-framework
 */


/**
 * Add new fields in general section for woo products
 * @return void
 */
function rella_add_custom_general_fields() {

  global $woocommerce, $post;

  echo '<div class="options_group">';

	// Custom button label
	woocommerce_wp_textarea_input(
		array(
			'id'          => '_custom_label',
			'label'       => esc_html__( 'Custom label', 'boo' ),
			'desc_tip'    => 'true',
			'description' => esc_html__( 'Input a custom label for the product', 'boo' )
		)
	);
	echo '</div>';

}

/**
 * Save values for custom field in woo product
 * @return void
 */
function rella_add_custom_general_fields_save( $post_id ){

	// Custom button label
	$woo_custom_label = wp_kses_post( $_POST['_custom_label'] );
	if( !empty( $woo_custom_label ) ) {
		update_post_meta( $post_id, '_custom_label', $woo_custom_label );
	}
}

/**
 * Edit Meta background color to categories
 */
function rella_edit_background_meta_field( $term ) {
	$term_id = $term->term_id;
	$term_meta = get_option( "taxonomy_$term_id" );
	$value = $term_meta['background'];
?>
	<tr class="form-field">
		<th scope="row">
			<label for="term-background-color"><?php echo esc_html_e( 'Background Color', 'boo' ); ?></label>
			<td>
				<input type="text" name="term_meta[background]" id="term-background-color" size="3" value="<?php echo $term_meta['background'] ? $term_meta['background'] : ''; ?>" class="my-color-field" />
				<p class="description"><?php esc_html_e( 'Select a background for product category label', 'boo' ); ?></p>
			</td>
		</th>
	</tr>
<?php
}

// Save the field
function rella_save_tax_meta( $term_id ){

	if ( isset( $_POST['term_meta'] ) ) {
		$term_meta = array();

			// Be careful with the intval here. If it's text you could use sanitize_text_field()
			$term_meta['background'] = isset ( $_POST['term_meta']['background'] ) ? sanitize_text_field( $_POST['term_meta']['background'] ) : '';
			
			// Save the option array.
			update_option( "taxonomy_$term_id", $term_meta );
		}
	}

/**
 * Add Meta background color to categories
 */
function rella_create_background_meta_field() {
	// this will add the custom meta field to the add new term page
	?>
	<div class="form-field term-background-wrap">
		<label for="term-background-color"><?php esc_html_e( 'Background Color', 'boo' ); ?></label>
		<input type="text" name="term_meta[background]" id="term-background-color" size="3" value="" class="my-color-field" />
		<p><?php esc_html_e( 'Select a background for product category label', 'boo' ); ?></p>
	</div>
<?php }