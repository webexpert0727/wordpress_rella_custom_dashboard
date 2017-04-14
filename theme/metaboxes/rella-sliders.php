<?php
/*
 * Slider Section
*/

$sections[] = array(
	'post_types' => array( 'post', 'page' ),
	'title' => esc_html__('Sliders', 'boo'),
	'icon' => 'el-icon-adjust-alt',
	'fields' => array(

		array(
 			'id'=>'slider-type',
 			'type' => 'select',
 			'title' => esc_html__('Slider Type', 'boo'),
 			'subtitle'=> esc_html__('Select the type of slider that displays.', 'boo'),
			'options' => array(
				'no' => esc_html__( 'No Slider', 'boo' ),
				'rella' => esc_html__( 'Rella Slider', 'boo' ),
				'rev' => esc_html__( 'Revolution Slider', 'boo' )
			),
			'default' => 'no'
		),

		array(
 			'id'=>'slider-rella',
 			'type' => 'select',
 			'title' => esc_html__('Select Rella Slider', 'boo'),
 			'subtitle'=> esc_html__('Select the unique name of the slider.', 'boo'),
			'options' => array(
				'no' => esc_html__( 'Select a slider', 'boo' )
			),
			'required' => array(
				'slider-type',
				'equals',
				'rella'
			),
			'default' => 'no'
		),

		array(
 			'id'=>'slider-rev',
 			'type' => 'select',
 			'title' => esc_html__('Select Revolution Slider', 'boo'),
 			'subtitle'=> esc_html__('Select the unique name of the slider.', 'boo'),
			'options' => array(
				'no' => esc_html__( 'Select a slider', 'boo' )
			),
			'required' => array(
				'slider-type',
				'equals',
				'rev'
			),
			'default' => 'no'
		),

		array(
 			'id'=>'slider-position',
 			'type' => 'button_set',
 			'title' => esc_html__('Slider Position', 'boo'),
 			'subtitle'=> esc_html__('Select if the slider shows below or above the header.', 'boo'),
			'options' => array(
				'default' => esc_html__( 'Default', 'boo' ),
				'below' => esc_html__( 'Below', 'boo' ),
				'above' => esc_html__( 'Above', 'boo' )
			),
			'required' => array(
				'slider-type',
				'not',
				'no'
			),
			'default' => 'default'
		)
	)
);
