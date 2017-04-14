<?php
/*
 * Page 404
*/
$this->sections[] = array (
	'title'  => esc_html__( '404 Page', 'boo' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id'       => 'error-404-title',
			'type'     => 'text',
			'title'    => esc_html__( 'Page Title', 'boo' ),
			'subtitle' => '',
			'default' => '404'
		),

		array(
			'id'       => 'error-404-subtitle',
			'type'     => 'text',
			'title'    => esc_html__( 'Page Teaser', 'boo' ),
			'subtitle' => '',
			'default' => 'Something’s not right.'
		),

		array(
			'id'       => 'error-404-content',
			'type'     => 'editor',
			'title'    => esc_html__( 'Page Content', 'boo' ),
			'subtitle' => '',
			'default' => '<p>We can’t find the page your are looking for. You can check out our <br> <a class="bar-fill-hover" href="#">Help Center</a> or head back to <a class="bar-fill-hover" href="#">Homepage</a>.</p>'
		),

		array(
			'id' => 'error-404-enable-search',
			'type'	 => 'button_set',
			'title' => esc_html__('Enable Search', 'boo'),
			'subtitle' => esc_html__('If on, the search module will be displayed.', 'boo'),
			'options' => array(
				'on' => 'On',
				'off' => 'Off'
			),
			'default' => 'on'
		),

		array(
			'id'       => 'error-404-search-title',
			'type'     => 'text',
			'title'    => esc_html__( 'Search Title', 'boo' ),
			'subtitle' => '',
			'default' => 'Search Boo:',
			'required' => array(
				'error-404-enable-search',
				'equals',
				'on'
			)
		),

		array(
			'id' => 'error-404-enable-btn',
			'type'	 => 'button_set',
			'title' => esc_html__('Enable Button', 'boo'),
			'subtitle' => esc_html__('If on, the return to home button will be displayed.', 'boo'),
			'options' => array(
				'on' => 'On',
				'off' => 'Off'
			),
			'default' => 'on'
		),

		array(
			'id'       => 'error-404-btn-title',
			'type'     => 'text',
			'title'    => esc_html__( 'Button Title', 'boo' ),
			'subtitle' => '',
			'default' => 'Return to home',
			'required' => array(
				'error-404-enable-btn',
				'equals',
				'on'
			)
		),

		array(
			'id'       => 'error-404-background-type',
			'type'     => 'select',
			'title'    => esc_html__( 'Background Type', 'boo' ),
			'options' => array(
				'solid' => 'Solid',
				'gradient' => 'Gradient',
				'image' => 'Image'
			),
			'default' => 'image'
		),

		array(
			'id'=>'error-404-bar-bg',
			'type' => 'media',
			'url' => true,
			'title' => esc_html__('Background', 'boo'),
			'required' => array(
				'error-404-background-type',
				'equals',
				'image'
			),
		),

		array(
			'id'=>'error-404-bar-solid',
			'type' => 'color',
			'url' => true,
			'title' => esc_html__('Background', 'boo'),
			'required' => array(
				'error-404-background-type',
				'equals',
				'solid'
			),
		),

		array(
			'id'=>'error-404-bar-gradient',
			'type' => 'gradient',
			'url' => true,
			'title' => esc_html__('Background', 'boo'),
			'required' => array(
				'error-404-background-type',
				'equals',
				'gradient'
			),
		),
	)
);
