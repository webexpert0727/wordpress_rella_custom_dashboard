<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the main containers
 *
 * @package base-theme
 */
?>

			<?php rella_action( 'after_content' ); ?>
			<?php if( !is_singular( 'rella-portfolio' ) ) : ?></div><?php endif; ?>
		</main><!-- #content -->
		<?php
		rella_action( 'before_footer' );
		rella_action( 'footer' );
		rella_action( 'after_footer' );
		?>

	</div><!-- .site-container -->

	<?php wp_footer(); ?>

	<?php rella_action( 'after' ) ?>

</body>
</html>
