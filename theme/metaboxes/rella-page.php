<?php
/*
 * General Section
 *
 * Available options on $section array:
 * separate_box (boolean) - separate metabox is created if true
 * box_title - title for separate metabox
 * title - section title
 * desc - section description
 * icon - section icon
 * fields - fields, @see https://docs.reduxframework.com/ for details
*/

$sections[] = array(
	'post_types' => array( 'post', 'page', 'product', 'rella-portfolio' ),
	'title' => esc_html__('Page', 'boo'),
	'icon' => 'el-icon-adjust-alt',
	'fields' => array(

		/*
		array(
			'id'=> 'page-layout',
			'type' => 'button_set',
			'title' => esc_html__('Layout', 'boo'),
			'subtitle'  => esc_html__('Select boxed or wide layout.', 'boo'),
			'options' => array(
				'default' => 'Default',
				'wide' => 'Wide',
				'boxed' => 'Boxed',
			),
			'default' => 'default'
		),
		*/

		array(
			'id'       => 'page-background-type',
			'type'     => 'select',
			'title'    => esc_html__( 'Background Type', 'boo' ),
			'options' => array(
				'solid' => 'Solid',
				'gradient' => 'Gradient'
			),
		),

		array(
			'id'=>'page-bar-bg',
			'type' => 'media',
			'url' => true,
			'title' => esc_html__('Background Image', 'boo'),
			'subtitle'  => esc_html__('Select boxed or wide layout.', 'boo'),
			'required' => array(
				'page-layout',
				'equals',
				'boxed'
			),
		),

		array(
			'id'=>'page-bar-solid',
			'type' => 'color',
			'url' => true,
			'title' => esc_html__('Background Color', 'boo'),
			'subtitle'  => esc_html__('Select boxed or wide layout.', 'boo'),
			'required' => array(
				'page-background-type',
				'equals',
				'solid'
			),
		),

		array(
			'id'=>'page-bar-gradient',
			'type' => 'gradient',
			'url' => true,
			'title' => esc_html__('Background Gradient', 'boo'),
			'required' => array(
				'page-background-type',
				'equals',
				'gradient'
			),
		),

		array(
			'id' => 'content-padding',
			'type'	 => 'spacing',
			'title' => esc_html__('Content Padding', 'boo'),
			'left' => false, 'right' => false,
			'units' => array(
				'px',
				'%',
				'em',
				'rem'
			)
		)
	)
);
