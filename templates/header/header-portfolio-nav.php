<?php

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

?>
<div class="row">
	<div class="col-md-10">
		
		<?php echo $heading; ?>
		<?php if( $breadcrumb ) rella_breadcrumb( $breadcrumb_args ); ?>
	
	</div><!-- /.col-md-10 -->
	<div class="col-md-2 align-right">
	
		<div class="portfolio-nav">
	
			<?php
				$prev_post = get_adjacent_post( true, '', true, 'rella-portfolio-category' );
				$next_post = get_adjacent_post( true, '', false, 'rella-portfolio-category' );
			?>
	
			<?php if( $prev_post ): ?>
			<a href="<?php echo get_permalink( $prev_post ) ?>" class="prev btn btn-xxsm semi-round text-uppercase">
				<span><i class="fa fa-angle-left"></i></span>
			</a>
			<?php endif; ?>
	
			<a href="<?php echo get_post_type_archive_link( 'rella-portfolio' ) ?>" class="portfolio-view-all"><span></span></a>
	
			<?php if( $next_post ): ?>
			<a href="<?php echo get_permalink( $next_post ) ?>" class="next btn btn-xxsm semi-round text-uppercase">
				<span><i class="fa fa-angle-right"></i></span>
			</a>
			<?php endif; ?>
	
		</div><!-- /.portfolio-nav -->
	
	</div><!-- /.col-md-2 -->
</div>