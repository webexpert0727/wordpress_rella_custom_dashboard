<?php
/*
 * General Section
*/

$this->sections[] = array(
	'title'  => esc_html__('General', 'boo'),
	'icon'   => 'el-icon-adjust-alt',
);

// General Setting
$this->sections[] = array(
	'title'  => esc_html__('General Settings', 'boo'),
	'subsection' => true,
	'fields' => array(

		array(
			'id'       => 'custom-sidebars',
			'type'     => 'multi_text',
			'title'    => esc_html__( 'Custom Sidebars', 'boo' ),
			'subtitle' => esc_html__( 'Custom sidebars can be assigned to any page or post.', 'boo' ),
			'desc'     => esc_html__( 'You can add as many custom sidebars as you need.', 'boo' )
		),

		array(
			'id'       => 'google-api-key',
			'type'     => 'text',
			'title'    => esc_html__( 'Google map API key', 'boo' ),
			'subtitle' => '',
			'desc'     => esc_html__( 'Add your Google map API key here. You can get Google API key from https://developers.google.com/maps/documentation/javascript/get-api-key', 'boo' )
		),
		
		array(
			'id'      => 'primary_ac_color',
			'type'    => 'color',
			'title'   => esc_html__( 'Primary Accent color' , 'boo' ),
			'subtile' => '',
			'desc'    => esc_html__( 'Use this colorpicker to override main accent color of the theme', 'boo' ),
		),
		
		array(
			'id'      => 'secondary_ac_color',
			'type'    => 'color',
			'title'   => esc_html__( 'Secondary Accent color' , 'boo' ),
			'subtile' => '',
			'desc'    => esc_html__( 'Use this colorpicker to override secondary accent color of the theme', 'boo' ),
		),

		array(
			'id'      => 'tertiary_ac_color',
			'type'    => 'color',
			'title'   => esc_html__( 'Tertiary Accent color' , 'boo' ),
			'subtile' => '',
			'desc'    => esc_html__( 'Use this colorpicker to override tertiary accent color of the theme', 'boo' ),
		),
		
		array(
			'id'      => 'primary_gradient_color',
			'type'    => 'color_gradient',
			'title'   => esc_html__( 'Primary Gradient colors' , 'boo' ),
			'subtile' => '',
			'desc'    => esc_html__( 'Use this colorpicker to override main gradient colors of the theme', 'boo' ),
			'validate' => 'color',
			'default' => array(
				'from' => '',
				'to' => '',
				
			)
		),
		
		array(
			'id'      => 'secondary_gradient_color',
			'type'    => 'color_gradient',
			'title'   => esc_html__( 'Secondary Gradient colors' , 'boo' ),
			'subtile' => '',
			'desc'    => esc_html__( 'Use this colorpicker to override secondary gradient colors of the theme', 'boo' ),
			'validate' => 'color',
			'default' => array(
				'from' => '',
				'to' => '',
				
			)	
		),
		
		array(
			'id'      => 'tertiary_gradient_color',
			'type'    => 'color_gradient',
			'title'   => esc_html__( 'Tertiary Gradient colors' , 'boo' ),
			'subtile' => '',
			'desc'    => esc_html__( 'Use this colorpicker to override tertiary gradient colors of the theme', 'boo' ),
			'validate' => 'color',
			'default' => array(
				'from' => '',
				'to' => '',
				
			)	
		),		
		
		
		
	)
);

// Theme Features
$this->sections[] = array(
	'title'  => esc_html__( 'Theme Features', 'boo' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id'       => 'enable-lazy-load',
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable Progressively Load', 'boo' ),
			'subtitle' => esc_html__( 'If enabled it will progressively load the images and fasten the page loading.', 'boo' ),
			'default'  => 1
		),

		array(
			'id'       => 'enable-preloader',
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable Loader Effect', 'boo' ),
			'subtitle' => esc_html__( 'If on, a loader will appear before loading the page.', 'boo' ),
			'default'  => 0
		),
		
		array(
			'id'       => 'smooth-scroll',
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable Smooth Scroll', 'boo' ),
			'subtitle' => esc_html__( 'If on, will enable smooth scroll', 'boo' ),
			'default'  => 0
		),

		array(
			'id'       => 'enable-go-top',
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable Go To Top Buttons', 'boo' ),
			'subtitle' => esc_html__( 'If on, a button will appear in the right bottom corner the page.', 'boo' ),
			'default'  => 0
		),

		array(
			'id' => 'sh_theme_features',
			'type'     => 'raw',
			'class' => 'redux-sub-heading',
			'desc' => '<h2>' . esc_html__( 'Icons', 'boo' ) . '</h2>'
		),

		array(
			'id' => 'font-icons',
			'type' => 'select',
			'multi' => true,
			'title' => esc_html__( 'Additional Icon Fonts sets', 'boo' ),
			'subtitle' => esc_html__( 'Select icon fonts sets you want to enable', 'boo' ),
			'options' => array(
				'rella-icons' => esc_html__( 'Rella Icons', 'boo' )
			)
		)
	)
);