<div class="<?php echo $this->get_grid_class() ?> masonry-item <?php echo $this->entry_term_classes() ?>">
	<article<?php echo rella_helper()->html_attributes( $attributes ) ?>>
		<div class="inner-wrapper <?php echo $this->get_animation() ?>">
			<div class="portfolio-inner">

				<div class="portfolio-main-image" <?php $this->get_zoom_effect(); ?>>
					<?php $this->entry_thumbnail(); ?>
				</div>

				<div class="portfolio-content">

					<div class="title-wrapper">
						<?php $this->entry_title() ?>
					</div>

				</div>

			</div>
		</div>
	</article>
</div>
