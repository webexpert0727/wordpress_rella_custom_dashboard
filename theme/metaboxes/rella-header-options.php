<?php
/*
 * Header Section
 *
 * Available options on $section array:
 * separate_box (boolean) - separate metabox is created if true
 * box_title - title for separate metabox
 * title - section title
 * desc - section description
 * icon - section icon
 * fields - fields, @see https://docs.reduxframework.com/ for details
*/

$url = get_template_directory_uri() . '/theme/assets/headers';
$sections[] = array(
	'post_types' => array( 'rella-header' ),
	'title' => esc_html__( 'Design Options', 'boo' ),
	'icon' => 'el-icon-cog',
	'fields' => array(

		array(
			'id' => 'header-layout',
			'type'	 => 'select',
			'title' => esc_html__('Style', 'boo'),
			'options' => array(
				'default' => esc_html__('Default', 'boo'),
				'overlay' => esc_html__('Overlay', 'boo')
			),
			'default' => 'default'
		)
	)
);

$sections[] = array(
	'post_types' => array('rella-header'),
	'title' => esc_html__('Menu Design Options', 'boo'),
	'icon' => 'el-icon-cog',
	'fields' => array(

		array(
			'id'          => 'nav_typography',
			'title'       => esc_html__( 'Menus Typography', 'boo' ),
			'description' => esc_html__( 'These settings control the typography for all menus.', 'boo' ),
			'type'        => 'typography',
			'text-align' => false,
			'text-transform' => true,
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
