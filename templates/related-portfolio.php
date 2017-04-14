<div class="related-projects">
    <div class="container">

        <h2 class="portfolio-title"><?php echo $heading ?></h2>

        <div class="carousel-container carousel-nav-style6">

            <div class="carousel-items row">

				<?php while( $related_posts->have_posts() ): $related_posts->the_post(); ?>

                    <div class="col-md-3 col-xs-6">

                        <div class="portfolio-item related">

                            <div class="portfolio-main-image">

                                <figure>
									<?php

										if( rella_helper()->get_option( 'enable-lazy-load' ) ) {
											remove_filter( 'wp_get_attachment_image_attributes', 'rella_filter_gallery_img_atts', 10, 2 );
											add_filter( 'wp_get_attachment_image_attributes', 'rella_filter_related_portfolio_img_atts', 10, 2 );
										}

										$retina_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'rella-portfolio-related@2x' );
										the_post_thumbnail( 'rella-portfolio-related', array( 'data-rjs' => $retina_image[0] ) );

									?>
								</figure>

                            </div>

                            <div class="portfolio-content">

                                <div class="title-wrapper">

									<?php the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ) ?>

									<?php the_terms( get_the_ID(), $taxonomy, '<ul class="category"><li>', '</li> <li>', '</li></ul>' ); ?>

                                </div>

                            </div>

                        </div>

                    </div>

					<?php endwhile; ?>

            </div>

            <div class="carousel-nav">

                <button class="flickity-prev-next-button previous"><i class="fa fa-angle-left"></i></button>
                <button class="flickity-prev-next-button next"><i class="fa fa-angle-right"></i></button>

            </div>

        </div>

    </div>

</div>

<?php wp_reset_postdata();
