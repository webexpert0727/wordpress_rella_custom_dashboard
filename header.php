<?php
/**
 * The template for displaying the header
 *
 * @package base-theme
 */

?><!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?>>
<head <?php rella_helper()->attr( 'head' ); ?>>

	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ) ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>

</head>

<body <?php rella_helper()->attr( 'body' ); ?>>

	<?php rella_action( 'before' ) ?>

	<div id="wrap">

		<?php
			rella_action( 'before_header' );
			rella_action( 'header' );
			rella_action( 'after_header' );
		?>

		<main <?php rella_helper()->attr( 'content' ); ?>>
			<?php if( !is_singular( 'rella-portfolio' ) ) : ?><div class="container"><?php endif; ?>
			<?php rella_action( 'before_content' ); ?>
