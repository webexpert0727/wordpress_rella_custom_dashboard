<?php
/**
 * Default header template
 *
 * @package base-html
 */

$header = rella_get_header_layout();
?>
<header <?php rella_helper()->attr( 'header', $header['attributes'] ); ?>>

	<?php echo apply_filters( 'the_content', get_post_field( 'post_content', $header['id'] ) ) ?>

</header>
