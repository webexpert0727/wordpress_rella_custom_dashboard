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
	'post_types' => array( 'post', 'page', 'product', 'rella-portfolio' ),
	'title' => esc_html__('Footer', 'boo'),
	'icon' => 'el-icon-cog',
	'fields' => array(

		array(
			'id' => 'footer-enable-switch',
			'type'	 => 'button_set',
			'title' => esc_html__('Enable Footer', 'boo'),
			'subtitle' => esc_html__('If on, this layout part will be displayed.', 'boo'),
			'options' => array(
				'on' => 'On',
				'' => 'Default',
				'off' => 'Off',
			)
		),

		array(
 			'id'=>'footer-template',
 			'type' => 'select',
 			'title' => esc_html__('Footer Template', 'boo'),
			'subtitle'=> esc_html__('Select which footer displays on this page, this footer override the default footer.', 'boo'),
 			'data' => 'post',
			'args' => array(
				'post_type' => 'rella-footer',
				'posts_per_page' => -1
			),
			'required'  => array('footer-enable-switch', '!=', 'off'),
		)

	), // #fields
);
