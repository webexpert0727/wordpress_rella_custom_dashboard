<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package base-theme
 */

get_header();

// Background
$bg = '';
$bg_type = rella_helper()->get_option( 'error-404-background-type', 'raw', '', 'options' );
if( 'solid' === $bg_type && $color = rella_helper()->get_option( 'error-404-bar-solid', 'raw', '', 'options' ) ) {
	$bg = 'background-color: ' . $color;
}
elseif( 'gradient' === $bg_type && $gradient = rella_helper()->get_option( 'error-404-bar-gradient', 'raw', '', 'options' ) ) {
	$gradient = explode( '|', $gradient );
	$gradient[0] = 'background-image:' . $gradient[0];
	$bg = join( ';', $gradient );
}
elseif( 'image' === $bg_type && $bg = rella_helper()->get_option( 'error-404-bar-bg', 'raw', '', 'options' ) ) {
	$bg = 'background-image: url('.$bg['url'].');background-size: cover;';
}
?>
	<style>
		body {
			<?php echo $bg ?>
		}
		a:hover {
			color: #e5432a;
		}

		.btn {
			border-color: #d5d5d5;
			font-family: 'karla';
			color: #000;
		}
		.btn:hover {
			border-color: #000;
			background-color: #000;
			color: #fff;
		}
	</style>
	<article id="post-404" <?php post_class( 'page-404 error-404 not-found entry' ); ?>>

		<div class="row">

			<div class="col-md-8 col-md-offset-2 text-center">

				<div class="text-404">

		            <svg xmlns="http://www.w3.org/2000/svg">
		                <defs>
		                    <linearGradient y2="1" x2="1" y1="0" x1="0" id="svg_3">
		                        <stop offset="0" stop-opacity="1" stop-color="#DD2450">
		                            <animate attributeName="stop-color" values="#DD2450;#651ABB;#E71CF4;#DD2450;#F4441C;#EA751A;#F4441C;#DD2450;#E71CF4;#651ABB;#DD2450" dur="18s" repeatCount="indefinite" />
		                        </stop>
		                        <stop offset="1" stop-opacity="1" stop-color="#FF512F">
		                            <animate attributeName="stop-color" values="#FF512F;#CA24DD;#E81F5E;#FF512F;#E8731F;#FFB021;#E8731F;#FF512F;#E81F5E;#CA24DD;#FF512F" dur="17s" repeatCount="indefinite" />
		                        </stop>
		                    </linearGradient>
		                </defs>
										<text x="50%" y="50%" stroke="#000" font-weight="bold" text-anchor="middle" alignment-baseline="central" stroke-width="0" fill="url(#svg_3)"><?php rella_helper()->get_option_e( 'error-404-title', 'html', '', 'options' ) ?></text>
		            </svg>

		        </div><!-- /.text-404 -->

				<header class="error-page-header">
					<h2 class="page-title entry-title mb-45"><?php rella_helper()->get_option_e( 'error-404-subtitle', 'html', '', 'options' ) ?></h2>
				</header><!-- .page-header -->

				<div class="page-content entry-content">

					<?php echo apply_filters( 'the_content', rella_helper()->get_option( 'error-404-content', 'post', '', 'options' ) ) ?>

					<div class="row">

			            <div class="col-md-10 col-md-offset-1">

							<?php if( 'on' === rella_helper()->get_option( 'error-404-enable-search', 'raw', '', 'options' ) ) : ?>
			                <form role="search" method="get" class="search-form search-form-404" action="http://boowp.staging.wpengine.com/">
			                    <label>
			                        <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'boo' ) ?></span>
			                        <input type="search" class="search-field" placeholder="<?php rella_helper()->get_option_e( 'error-404-search-title', 'attr', '', 'options' ) ?>" value="" name="s">
			                    </label>

			                    <input type="submit" class="search-submit" value="Search">
			                </form>
							<?php endif; ?>

							<?php if( 'on' === rella_helper()->get_option( 'error-404-enable-btn', 'raw', '', 'options' ) ) : ?>
			                <a href="<?php echo esc_url( home_url('/') ) ?>" class="btn btn-sm round back-home icon-left text-uppercase"><span><i class="fa fa-angle-left"></i><?php rella_helper()->get_option_e( 'error-404-btn-title', 'html', '', 'options' ) ?></span></a>
							<?php endif; ?>

			            </div><!-- /.col-md-10 col-md-offset-1 -->

			        </div><!-- /.row -->

				</div><!-- .page-content -->

			</div>

		</div>

	</article><!-- .error-404 -->

<?php get_footer();
