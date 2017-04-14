<?php

$uri = get_template_directory_uri() . '/rella/assets/img/demos/';

// Demos
$demos = array(

	'main' => array(
		'title'       => esc_html__( 'Boo Main', 'boo' ),
		'description' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adi nunc maximus egestas lectus eu condi. Duis non purus dignissim varius.', 'boo' ),
		'screenshot'  => $uri . 'main.jpg',
		'preview'     => 'http://boo.com',

		'min_version' => '1.0.0',
		'shop'        => true,
		'new'         => false,

		'has_widgets' => true,
		'has_sliders' => true,

		'zip_file'    => 'http://updates.theme-fusion.com/?avada_demo=classic',
		'sliders'     => array(
			'home-rs-1.zip',
			'home-rs-2.zip',
			'home-rs-3.zip'
		)
	),

	'agency' => array(
		'title'       => esc_html__( 'Agency', 'boo' ),
		'description' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adi nunc maximus egestas lectus eu condi. Duis non purus dignissim varius.', 'boo' ),
		'screenshot'  => $uri . 'agency.jpg',
		'preview'     => 'http://boo.com',

		'min_version' => '1.0.0',
		'shop'        => true,
		'new'         => false,

		'has_widgets' => false,
		'has_sliders' => false,

		'zip_file'    => 'http://updates.theme-fusion.com/?avada_demo=classic',
		'sliders'     => array(
			'home-rs-1.zip',
			'home-rs-2.zip',
			'home-rs-3.zip'
		)
	),

	'elegant' => array(
		'title'       => esc_html__( 'Elegant', 'boo' ),
		'description' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adi nunc maximus egestas lectus eu condi. Duis non purus dignissim varius.', 'boo' ),
		'screenshot'  => $uri . 'agency.jpg',
		'preview'     => 'http://boo.com',

		'min_version' => '1.0.0',
		'shop'        => true,
		'new'         => false,

                'has_yellow'  => false,
		'has_widgets' => true,
		'has_sliders' => false,

		'zip_file'    => 'http://updates.theme-fusion.com/?avada_demo=classic',
		'sliders'     => array(
			'home-rs-1.zip',
			'home-rs-2.zip',
			'home-rs-3.zip'
		)
	)	

);