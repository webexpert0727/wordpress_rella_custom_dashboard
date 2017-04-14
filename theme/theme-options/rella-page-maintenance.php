<?php
/*
 * Page Maintenance
*/

// Hours
$hours = array();
for ($i = 0; $i <= 24; $i++){

	$hour = $i;
	if ($i < 10) {
		$hour = '0'.$i;
	}
	$hours[(string)$hour] = (string)$hour;
}

// Minutes
$minutes = array();
for ($i = 0; $i < 60; $i++){

	$min = $i;
	if ($i < 10) {
		$min = '0'.$i;
	}
	$minutes[(string)$min] = (string)$min;
}

$this->sections[] = array (
	'title'  => esc_html__( 'Maintenance Page', 'boo' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'page-maintenance-enable',
			'type'	 => 'button_set',
			'title' => esc_html__('Enable Maintenance Mode', 'boo'),
			'subtitle' => esc_html__('If on, the frontend shows maintenance mode page only.', 'boo'),
			'desc' => esc_html__('Only administrator will be able to visit site. If you want to check if maintenance mode is enabled you have to logout.', 'boo'),
			'options' => array(
				'on' => 'On',
				'off' => 'Off'
			),
			'default' => 'on'
		),

		array(
			'id' => 'page-maintenance-mode-till',
			'type'	 => 'button_set',
			'title' => esc_html__('Enable Till', 'boo'),
			'subtitle' => esc_html__('If on, the frontend shows maintenance mode page only.', 'boo'),
			'desc' => esc_html__('Only administrator will be able to visit site. If you want to check if maintenance mode is enabled you have to logout.', 'boo'),
			'options' => array(
				'on' => 'On',
				'off' => 'Off'
			),
			'default' => 'on'
		),

		array(
			'id'        => 'page-maintenance-mode-till-date',
			'type'      => 'date',
			'title'     => esc_html__('Date (mm/dd/yyyy)', 'boo'),
			'default'   => date('m/d/Y'),
			'required' => array(
				'page-maintenance-mode-till',
				'equals',
				'on'
			)
		),

		array(
			'id'        => 'page-maintenance-mode-till-hour',
			'type'      => 'select',
			'title'     => esc_html__('Hour', 'boo'),
			'options' => $hours,
			'default'   => '00',
			'required' => array(
				'page-maintenance-mode-till',
				'equals',
				'on'
			)
		),

		array(
			'id'        => 'page-maintenance-mode-till-minutes',
			'type'      => 'select',
			'title'     => esc_html__('Minutes', 'boo'),
			'options' => $minutes,
			'default'   => '00',
			'required' => array(
				'page-maintenance-mode-till',
				'equals',
				'on'
			)
		),

		array(
			'id'       => 'page-maintenance-title',
			'type'     => 'text',
			'title'    => esc_html__( 'Page Title', 'boo' ),
			'subtitle' => '',
			//'desc'     => esc_html__( 'Add your Google map API key here. You can get Google API key from https://developers.google.com/maps/documentation/javascript/get-api-key', 'boo' )
			'default' => 'We’ll Be Right Back.'
		),

		array(
			'id'       => 'page-maintenance-content',
			'type'     => 'editor',
			'title'    => esc_html__( 'Page Content', 'boo' ),
			'subtitle' => '',
			//'desc'     => esc_html__( 'Add your Google map API key here. You can get Google API key from https://developers.google.com/maps/documentation/javascript/get-api-key', 'boo' )
			'default' => '<p>Our team is working hard to be able to back in a couple hours. <br> Thanks for your patience.</p>'
		),

		array(
			'id'       => 'page-maintenance-background-type',
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
			'id'=>'page-maintenance-bar-bg',
			'type' => 'media',
			'url' => true,
			'title' => esc_html__('Background', 'boo'),
			'required' => array(
				'page-maintenance-background-type',
				'equals',
				'image'
			),
		),

		array(
			'id'=>'page-maintenance-bar-solid',
			'type' => 'color',
			'url' => true,
			'title' => esc_html__('Background', 'boo'),
			'required' => array(
				'page-maintenance-background-type',
				'equals',
				'solid'
			),
		),

		array(
			'id'=>'page-maintenance-bar-gradient',
			'type' => 'gradient',
			'url' => true,
			'title' => esc_html__('Background', 'boo'),
			'required' => array(
				'page-maintenance-background-type',
				'equals',
				'gradient'
			),
		),

		array(
			'id' => 'page-maintenance-identities',
			'type' => 'repeater',
			'group_values' => true,
			'title' => esc_html__('Social identities', 'boo'),
			'fields' => array(

				array(
					'id'       => 'title',
					'type'     => 'text',
					'title'    => esc_html__( 'Title', 'boo' )
				),

				array(
					'id'       => 'url',
					'type'     => 'text',
					'title'    => esc_html__( 'Url', 'boo' )
				),
			)
		)
	)
);
