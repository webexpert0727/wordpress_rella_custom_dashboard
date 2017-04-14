<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$fields = '';
if ( ! empty ( $_GET['postsperpage'] ) ) {
	$fields .= '<input type="hidden" name="postsperpage" value="' . esc_attr( $_GET['postsperpage'] ) . '" />';
}

?>
<form class="woocommerce-ordering" method="get">
	<label><?php esc_html_e( 'Sort By', 'boo' )?>:</label>
		<div class="select-container">
			<select name="orderby" class="orderby form-control">
				<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
					<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
			</select>
		</div> <!-- .select-contaienr -->
	<?php echo $fields; ?>
</form>
</div> <!-- .col-md-6 -->
<div class="col-md-6">
<form class="woocommerce-ordering" method="get">
	<?php
		// Keep query string vars intact
		foreach ( $_GET as $key => $val ) {
			if ( 'orderby' === $key || 'submit' === $key ) {
				continue;
			}
			if ( is_array( $val ) ) {
				foreach( $val as $innerVal ) {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
				}
			} else {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
			}
		}
	
	$values = rella_wc_get_posts_per_page_dropdown_values();
	$current_posts_per_page_value = rella_wc_get_current_posts_per_page_value();
	if ( is_array( $values ) ): ?>
		<label class="ml25"><?php echo esc_html_e( 'Show', 'boo' ); ?>:</label>
		<div class="select-container">
			<select name="postsperpage" class="form-control postsperpage" data-default="<?php echo esc_attr($current_posts_per_page_value); ?>" data-label="<?php esc_attr_e( 'Display', 'boo' ); ?>">
				<?php foreach ( $values as $val ):
						if ( ! empty ( $val ) ) {
					 ?>
					<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $val, $current_posts_per_page_value ); ?>><?php echo esc_html( $val ); ?></option>
				<?php
					}
					 endforeach; ?>
			</select>
		</div> <!-- .select-contaienr -->		
	<?php endif; ?>
	<label><?php echo esc_html_e( 'Items Per Page', 'boo' ); ?></label>
	<input type="hidden" name="orderby" value="<?php echo esc_attr( $orderby ); ?>"  />
</form>