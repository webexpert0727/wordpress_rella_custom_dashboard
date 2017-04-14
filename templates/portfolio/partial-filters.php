<?php
extract( $atts );

$filter_cats = explode( ', ', $filter_cats );
$terms = get_terms( array(
	'taxonomy' => 'rella-portfolio-category',
	'hide_empty' => false,
	'include' => $filter_cats
) );

if( empty( $terms ) ) {
	return;
}

if( in_array( $style, array( 'grid', 'masonry', 'metro', 'packery' ) ) ) :
?>
	<div class="row">

	<div class="col-md-12">

		<div class="masonry-filters default <?php echo $filter_color; ?>" data-target="#<?php echo $this->grid_id; ?>">
			<span class="filters-toggle-link">
				<?php echo $filter_title ?>
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
					<g>
						<line x1="0" y1="32" x2="63" y2="32"/>
					</g>
					<polyline  points="50.7,44.6 63.3,32 50.7,19.4 "/>
					<circle cx="32" cy="32" r="31"/>
				</svg>
			</span>
			<ul class="list-unstyled list-inline">
				<li data-filter="*" class="active"><span><span><?php echo $filter_lbl_all ?></span></span></li>
				<?php foreach( $terms as $term ) {
					printf( '<li data-filter=".%s"><span><span>%s</span></span></li>', $term->slug, $term->name );
				} ?>
			</ul>
		</div>

	</div>

	</div>
<?php
else:
?>
    <div class="row">

        <div class="col-md-7">

            <div class="masonry-filters default <?php echo $filter_color; ?>" data-target="#<?php echo $this->grid_id; ?>">
				<span class="filters-toggle-link">
					<?php echo $filter_title ?>
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
						<g>
							<line x1="0" y1="32" x2="63" y2="32"/>
						</g>
						<polyline  points="50.7,44.6 63.3,32 50.7,19.4 "/>
						<circle cx="32" cy="32" r="31"/>
					</svg>
				</span>
                <ul class="list-unstyled list-inline">
                    <li data-filter="*" class="active"><span><span><?php echo $filter_lbl_all ?></span></span></li>
					<?php foreach( $terms as $term ) {
						printf( '<li data-filter=".%s"><span><span>%s</span></span></li>', $term->slug, $term->name );
					} ?>
                </ul>
            </div>

        </div>

		<?php if( $show_order || $show_orderby ): ?>
        <div class="col-md-5">

			<?php if( $show_order ): ?>
            <div class="sorting-option<?php echo isset( $_GET['orderby'] ) ? ' checked' : '' ?>">
				<span>
					<label for="post-orderby"><?php esc_html_e( 'Date', 'boo' ); ?></label>
					<input type="checkbox" name="post-orderby" id="post-orderby" data-metric="orderby" value="title" <?php checked( isset( $_GET['orderby'] ) ) ?>>
					<span class="input-dummy"></span>
					<label for="post-orderby"><?php esc_html_e( 'Name', 'boo' ); ?></label>
				</span>
            </div>
			<?php endif; ?>

			<?php if( $show_orderby ): ?>
            <div class="sorting-option<?php echo isset( $_GET['order'] ) ? ' checked' : '' ?>">
                <span>
					<label for="post-order"><?php esc_html_e( 'Desc', 'boo' ); ?></label>
					<input type="checkbox" name="post-order" id="post-order" data-metric="order" value="Asc" <?php checked( isset( $_GET['order'] ) ) ?>>
					<span class="input-dummy"></span>
					<label for="post-order"><?php esc_html_e( 'Asc', 'boo' ); ?></label>
				</span>
            </div>
			<?php endif; ?>

        </div>
		<?php endif; ?>

    </div>
<?php endif;
