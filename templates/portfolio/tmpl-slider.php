<?php
	wp_enqueue_script( 'flickity' );
	wp_enqueue_script( 'mCustom-scrollbar' );
?>
<div class="col-xs-12 no-padding">
	<div class="portfolio-item portfolio-fullwidth text-light">

		<div class="portfolio-main-image">
			<?php $this->entry_thumbnail(); ?>
		</div><!-- /.portfolio-main-image -->

		<div class="portfolio-content">
			<div class="portfolio-meta">
				<?php $this->entry_like() ?>
				<?php $this->entry_client() ?>
				<?php $this->entry_date() ?>
			</div><!-- /.portfolio-meta -->

			<div class="title-wrapper">
				<?php $this->entry_title() ?>
				<?php $this->entry_cats() ?>
			</div><!-- /.title-wrapper -->

			<div class="portfolio-summary">
				<?php $this->entry_content(); ?>
			</div><!-- /.portfolio-summary -->

		</div><!-- /.portfolio-content -->
		
	</div><!-- /.portfolio-item -->
</div><!-- /.col-xs-12 -->