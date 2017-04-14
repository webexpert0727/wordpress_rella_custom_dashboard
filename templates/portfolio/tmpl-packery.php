<div class="col-md-<?php echo $this->get_column_class() ?> col-sm-6 col-xs-12 masonry-item <?php echo $this->entry_term_classes() ?>">
	<article<?php echo rella_helper()->html_attributes( $attributes ) ?> >
		<div class="inner-wrapper <?php echo $this->get_animation() ?>">
			<div class="portfolio-inner">

				<div class="portfolio-main-image" <?php $this->get_zoom_effect(); ?>>
					<?php $this->entry_thumbnail(); ?>
				</div>

				<div class="portfolio-content">

					<?php if( 'hover-bottom-left' === $sub_style ) : ?>
					<div class="portfolio-footer">
						<?php $this->entry_ext_link() ?>
						<?php $this->entry_footer_link() ?>
						<?php $this->entry_lightbox() ?>
						<?php $this->entry_share() ?>
					</div>
					<?php endif; ?>

					<?php if( ! in_array( $sub_style, array( 'hover-elegant', 'hover-bottom', 'hover-only-icons', 'hover-bottom-shadow' ) ) ) : ?>
					<div class="portfolio-meta">
						<?php $this->entry_like() ?>
						<?php $this->entry_client() ?>
						<?php $this->entry_date() ?>
					</div>
					<?php endif; ?>

					<?php if( ! in_array( $sub_style, array( 'hover-only-icons' ) ) ) : ?>
					<div class="title-wrapper">
						<?php $this->entry_title() ?>
						<?php $this->entry_cats() ?>
					</div>
					<?php endif; ?>

					<?php if( 'hover-elegant' === $sub_style ) : ?>
					<div class="portfolio-meta">
						<?php $this->entry_like() ?>
					</div>
					<?php endif; ?>

					<?php if( ! in_array( $sub_style, array( 'hover-elegant', 'hover-bottom', 'hover-only-icons', 'hover-bottom-shadow' ) ) ) {
						$this->entry_content();
					} ?>

					<?php if( !in_array( $sub_style, array( 'hover-bottom-left', 'caption-fixed' ) ) ) : ?>
						<?php if( ! empty( $atts['show_share'] ) || ! empty( $atts['show_ext_link'] ) || ! empty( $atts['show_link'] ) || ! empty( $atts['show_lightbox'] ) ) { ?>
						<div class="portfolio-footer">
							<?php $this->entry_ext_link() ?>
							<?php $this->entry_footer_link() ?>
							<?php $this->entry_lightbox() ?>
							<?php $this->entry_share() ?>
						</div>
						<?php } ?>
					<?php endif; ?>

				</div>

				<?php if( 'caption-fixed' === $sub_style ) : ?>
					<div class="overlay-link">
						<?php $this->entry_title() ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</article>
</div>
