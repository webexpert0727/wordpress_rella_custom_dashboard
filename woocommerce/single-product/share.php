<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/share.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_share' ); // Sharing plugins can hook into here ?>
<?php
	$crunchifyURL       = urlencode( get_permalink() );
	$crunchifyTitle     = str_replace( ' ', '%20', get_the_title());
	$crunchifyThumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' );

	// Construct sharing URL without using any script
	$facebookURL  = 'https://www.facebook.com/sharer/sharer.php?u=' . $crunchifyURL . '&amp;t=' . $crunchifyTitle;
	$pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . $crunchifyURL . '&amp;media=' . $crunchifyThumbnail . '&amp;description=' . $crunchifyTitle;
	$googleURL    = 'https://plus.google.com/share?url=' . $crunchifyURL;
	$linkedInURL  = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $crunchifyURL . '&amp;title=' . $crunchifyTitle;
	$twitterURL   = 'https://twitter.com/intent/tweet?text=' . $crunchifyTitle . '&amp;url=' . $crunchifyURL;
?>
<ul class="social-icon scheme-gray">
	<li><a href="<?php echo esc_url( $twitterURL ); ?>"><i class="fa fa-twitter"></i></a></li>
	<li><a href="<?php echo esc_url( $facebookURL ); ?>"><i class="fa fa-facebook"></i></a></li>
	<li><a href="<?php echo esc_url( $googleURL );  ?>" onclick="<?php echo esc_js( "javascript:window.open( this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" ); ?>"><i class="fa fa-google"></i></a></li>
	<li><a href="<?php echo esc_url( $linkedInURL ); ?>"><i class="fa fa-linkedin"></i></a></li>
</ul><!-- /.social-icon -->