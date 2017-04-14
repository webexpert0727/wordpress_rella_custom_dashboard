<?php
/**
 * The template for displaying the header
 *
 * @package base-theme
 */

while ( have_posts() ) : the_post();

	the_content();

endwhile;
