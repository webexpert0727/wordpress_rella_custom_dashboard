<?php

// Background
$bg = '';
$bg_type = rella_helper()->get_option( 'title-background-type' );
if( 'solid' === $bg_type && $color = rella_helper()->get_option( 'title-bar-solid' ) ) {
	$bg = ' style="background-color: ' . $color . '"';
}
elseif( 'gradient' === $bg_type && $gradient = rella_helper()->get_option( 'title-bar-gradient' ) ) {
	$gradient = explode( '|', $gradient );
	$gradient[0] = 'background-image:' . $gradient[0];
	$bg = ' style="' . join( ';', $gradient ) . '"';
}
elseif( 'image' === $bg_type && $bg = rella_helper()->get_option( 'title-bar-bg' ) ) {
	$bg = ' style="background-image: url('.$bg['url'].')"';
}

// Classes
$classes = array( 'titlebar' );
if( $size = rella_helper()->get_option( 'title-bar-size' ) ) {
	$classes[] = 'titlebar-title-' . $size;
}
if( $height = rella_helper()->get_option( 'title-bar-height' ) ) {
	if( 'full' !== $height ) {
		$classes[] = 'titlebar-height-' . $height;
		$height = '';
	}
	else {
		$height = ' data-enable-fullheight="true"';
	}
}
if( $scheme = rella_helper()->get_option( 'title-bar-scheme' ) ) {
	$classes[] = $scheme;
}
if( $align = rella_helper()->get_option( 'title-bar-align' ) ) {
	$classes[] = $align;
}
if( $extra = rella_helper()->get_option( 'title-bar-classes' ) ) {
	$classes[] = $extra;
}
$style = rella_helper()->get_option( 'title-bar-content-style' );

// Content
$content = $heading = $subheading = '';
if( !rella_helper()->get_current_page_id() && is_home() ) {
	$heading = rella_helper()->get_option( 'blog-title-bar-heading', 'html' );
	$subheading = rella_helper()->get_option( 'blog-title-bar-subheading', 'html' );
}
else {
	$heading = rella_helper()->get_option( 'title-bar-heading', 'html' );
	$subheading = rella_helper()->get_option( 'title-bar-subheading', 'html' );
}
$heading_class = rella_helper()->get_option( 'title-bar-weight' ); 
$heading = $heading ? '<h1 class="portfolio-title ' . $heading_class . '">'. $heading .'</h1>' : get_the_title( '<h1 '. rella_helper()->get_attr( 'entry-title', array( 'class' => 'portfolio-title' ) ) .'>', '</h1>' );
$subheading = $subheading ? '<h6>'. $subheading .'</h6>' : '';
$content = wpautop( rella_helper()->get_option( 'title-bar-content', 'post' ) );

// Breadcrumb
$breadcrumb = ('on' === rella_helper()->get_option( 'title-bar-breadcrumb' ));
$breadcrumb_args = array(
	'classes' => rella_helper()->get_option( 'title-bar-breadcrumb-style' )
);

// Local Scroll
$scroll = ('on' === rella_helper()->get_option( 'title-bar-scroll' ));
$scroll_id = rella_helper()->get_option( 'title-bar-scroll-id' );

$header_position = rella_helper()->get_option( 'header-position' );
if( 'bottom' === $header_position ) {
	$classes[] = 'titlebar-header-bottom';
}

// Portfolio navigation
$portfolio_nav = ( 'on' === rella_helper()->get_option( 'title-bar-nav' ) );

?>
<section class="<?php echo join( ' ', $classes ) ?>"<?php echo $bg . $height ?>>
	
	<?php if( 'bottom' != $header_position ) : ?>
		<?php rella_action( 'header_titlebar' ); ?>
	<?php endif; ?>

    <div class="titlebar-inner">

        <div class="container">

		<?php if( 'split' === $style ) : ?>

			<?php if( $portfolio_nav ) : ?>
			
				<?php get_template_part( 'templates/header/header-portfolio', 'nav' ); ?>	
			
			<?php else : ?>

			<div class="row">				
				<div class="col-md-6">
					<?php echo $subheading ?>
					<?php echo $heading ?>
					<?php echo $content ?>
				</div>

				<div class="col-md-6 align-right">
					<?php if( $breadcrumb ) rella_breadcrumb( $breadcrumb_args ); ?>
				</div>
			</div><!-- /.row -->
			
			<?php endif; ?>

		<?php elseif( 'bottom' === $style ) : ?>
			
			<?php if( $portfolio_nav ) { ?>
				<?php get_template_part( 'templates/header/header-portfolio', 'nav' ); ?>	
			<?php  } else {  ?>

			<?php echo $subheading ?>
			<?php echo $heading ?>
			<?php echo $content ?>
			
			<?php } ?>
			

		<?php elseif( 'bottom-bar' === $style ) : ?>
		<?php else: ?>
			
			<?php if( $portfolio_nav ) { ?>
				<?php get_template_part( 'templates/header/header-portfolio', 'nav' ); ?>	
			<?php  } else {  ?>
			
			<?php echo $subheading ?>
			<?php echo $heading ?>
			<?php echo $content ?>

			<?php if( $breadcrumb ) rella_breadcrumb( $breadcrumb_args ); ?>
			
			<?php } ?>	

		<?php endif; ?>
        </div>

    </div>

	<?php if( 'bottom' === $style && $breadcrumb ) : ?>
	<div class="titlebar-bottom-bar">

		<div class="container">

			<?php rella_breadcrumb( $breadcrumb_args ); ?>

		</div><!-- /.container -->

	</div>
	<?php endif; ?>

	<?php if( 'bottom-bar' === $style ) : ?>

		<div class="titlebar-bottom-bar">

			<div class="container">

				<?php if( $portfolio_nav ) : ?>
						
					<?php get_template_part( 'templates/header/header-portfolio', 'nav' ); ?>	

				<?php else : ?>
				
				<div class="row">
					<div class="col-md-6">
						<?php echo $subheading ?>
						<?php echo $heading ?>
						<?php echo $content ?>
					</div>

					<div class="col-md-6 align-right">
						<?php if( $breadcrumb ) rella_breadcrumb( $breadcrumb_args ); ?>
					</div>
				</div><!-- /.row -->

				<?php endif; ?>

			</div><!-- /.container -->

		</div>
	<?php endif; ?>
	
	<?php if( $scroll ) : ?>
		<div class="local-scroll move-bottom">
			<a href="#<?php echo esc_attr( $scroll_id ); ?>"><span><i class="fa fa-angle-down"></i></span></a>
		</div>	
	<?php endif; ?>
	
	<?php if( 'bottom' === $header_position ) : ?>
		<?php rella_action( 'header_titlebar' ); ?>
	<?php endif; ?>

</section>