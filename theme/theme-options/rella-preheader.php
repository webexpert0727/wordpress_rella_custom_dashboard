<?php
/*
 * Preheader Section
*/

$this->sections[] = array(
	'title' => esc_html__('Preheader', 'boo'),
	'desc' => esc_html__('Change the preheader section configuration.', 'boo'),
	'icon' => 'el-icon-cog',
	'fields' => array(

		array(
			'id' => 'preheader-enable-switch',
			'type' => 'switch', 
			'title' => esc_html__('Enable preheader', 'boo'),
			'subtitle' => esc_html__('If on, this layout part will be displayed.', 'boo'),
			'default' => 1,
		),
		
	), // #fields
);