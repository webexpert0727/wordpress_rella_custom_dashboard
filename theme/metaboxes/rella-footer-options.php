<?php
/*
 * Footer Section
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
	'post_types' => array('rella-footer'),
	'title' => esc_html__('Design Options', 'boo'),
	'icon' => 'el-icon-cog',
	'fields' => array(

		array(
			'id'     => 'footer-fixed',
			'type'   => 'button_set',
			'title'  => esc_html__('Fixed Footer', 'boo'),
			'subtitle' => esc_html__('If on, this footer will be fixed', 'boo'),
			'options' => array(
				'on'  => esc_html__( 'On', 'boo' ),
				'off' => esc_html__( 'Off', 'boo' ),
			),
			'default' => 'off',
		),

		array(
			'id' => 'footer-text-color',
			'type'	 => 'color_rgba',
			'title' => esc_html__('Text Color', 'boo'),
		),

		array(
			'id' => 'footer-link-color',
			'type'	 => 'link_color',
			'title' => esc_html__('Link Color', 'boo'),
		),

		array(
			'id' => 'footer-bg',
			'type'	 => 'color',
			'title' => esc_html__('Background Color', 'boo'),
		),

		array(
			'id'=>'footer-bg-img',
			'type' => 'media',
			'url' => true,
			'title' => esc_html__('Background Image', 'boo')
		),

		array(
			'id' => 'footer-padding',
			'type'	 => 'spacing',
			'title' => esc_html__('Padding', 'boo'),
		)
	)
);
