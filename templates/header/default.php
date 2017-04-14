<?php
/**
 * Default header
 *
 * @package Boo
 */
?>
<header <?php rella_helper()->attr( 'header' ); ?>>
	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<nav <?php rella_helper()->attr( 'menu', array(
			'id' => 'menu-primary',
			'class' => 'menu menu-primary',
			'location' => 'primary'
		) ); ?>>
			<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_class'     => 'primary-menu',
				 ) );
			?>
		</nav>
		<?php else: ?>
		<nav <?php rella_helper()->attr( 'menu', array(
			'id' => 'menu-primary',
			'class' => 'menu menu-primary',
			'location' => 'primary'
		) ); ?>>
			<?php
				wp_page_menu( array(
					'container'  => 'ul',
					'before'     => false,
					'after'      => false,
					'menu_id'    => 'primary-nav',
					'menu_class' => 'nav navbar-nav',
					'depth'      => 1
				));
			?>
		</nav>
	<?php endif; ?>
</header>