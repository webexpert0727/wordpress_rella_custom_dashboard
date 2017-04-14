<?php
/*
 * Title Wrapper Section
*/

// Title Bar
$this->sections[] = array(
	'title'  => esc_html__( 'Menu', 'boo' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id'          => 'nav_typography',
			'title'       => esc_html__( 'Menus Typography', 'boo' ),
			'description' => esc_html__( 'These settings control the typography for all menus.', 'boo' ),
			'type'        => 'typography',
			'text-align' => false,
			'line-height' => false,
			'color' => false,
			'letter-spacing' => true,
			'preview' => false,
			'subsets' => false
		),

		array(
			'id'          => 'nav_color',
			'title'       => esc_html__( 'Main Color', 'boo' ),
			'type'        => 'color_rgba',
		),

		array(
			'id'          => 'nav_secondary_color',
			'title'       => esc_html__( 'Secondary Color', 'boo' ),
			'type'        => 'color_rgba',
		),

		array(
			'id'          => 'nav_active_color',
			'title'       => esc_html__( 'Active Color', 'boo' ),
			'type'        => 'color_rgba',
		),

		array(
			'id' => 'nav_padding',
			'type'	 => 'spacing',
			'title' => esc_html__('Menu Item Padding', 'boo'),
			'top' => false, 'bottom' => false,
			'units' => array(
				'px',
				'%',
				'em',
				'rem'
			)
		),

		array(
			'id' => 'nav_logo_padding',
			'type'	 => 'spacing',
			'title' => esc_html__('Logo Padding', 'boo'),
			'units' => array(
				'px',
				'%',
				'em',
				'rem'
			)
		)
	)
);
