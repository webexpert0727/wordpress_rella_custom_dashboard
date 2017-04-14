<?php

add_action( 'rella_option_sidebars', 'rella_woocommerce_option_sidebars' );

function rella_woocommerce_option_sidebars( $obj ) {

	// Product Sidebar
	$obj->sections[] = array(
		'title'  => esc_html__('Products', 'boo'),
		'subsection' => true,
		'fields' => array(

			array(
				'id' => 'wc-enable-global',
				'type'	 => 'button_set',
				'title' => esc_html__('Activate Global Sidebar For Products', 'boo'),
				'subtitle' => esc_html__('Turn on if you want to use the same sidebars on all product posts. This option overrides the product options.', 'boo'),
				'options' => array(
					'on' => 'On',
					'off' => 'Off'
				),
				'default' => 'off'
			),

			array(
	 			'id'=>'wc-sidebar-one',
	 			'type' => 'select',
	 			'title' => esc_html__('Global Products Sidebar 1', 'boo'),
	 			'subtitle'=> esc_html__('Select sidebar 1 that will display on all product posts.', 'boo'),
				'data' => 'sidebars'
			),

			array(
	 			'id'=>'wc-sidebar-two',
	 			'type' => 'select',
	 			'title' => esc_html__('Global Products Sidebar 2', 'boo'),
	 			'subtitle'=> esc_html__('Select sidebar 2 that will display on all product posts. Sidebar 2 can only be used if sidebar 1 is selected.', 'boo'),
				'data' => 'sidebars'
			),

			array(
	 			'id'=>'wc-sidebar-position',
	 			'type' => 'button_set',
	 			'title' => esc_html__('Global Product Sidebar Position', 'boo'),
	 			'subtitle'=> esc_html__('Controls the position of sidebar 1 for all product posts. If sidebar 2 is selected, it will display on the opposite side.', 'boo'),
				'options' => array(
					'left' => esc_html__( 'Left', 'boo' ),
					'right' => esc_html__( 'Right', 'boo' )
				),
				'default' => 'right'
			)
		)
	);

	// Product Archive Sidebar
	$obj->sections[] = array(
		'title'  => esc_html__('Product Archive', 'boo'),
		'subsection' => true,
		'fields' => array(

			array(
	 			'id'=>'wc-archive-sidebar-one',
	 			'type' => 'select',
	 			'title' => esc_html__('Product Archive Sidebar 1', 'boo'),
	 			'subtitle'=> esc_html__('Select sidebar 1 that will display on the product archive pages.', 'boo'),
				'data' => 'sidebars'
			),

			array(
	 			'id'=>'wc-archive-sidebar-two',
	 			'type' => 'select',
	 			'title' => esc_html__('Product Archive Sidebar 2', 'boo'),
	 			'subtitle'=> esc_html__('Select sidebar 2 that will display on the product archive pages. Sidebar 2 can only be used if sidebar 1 is selected.', 'boo'),
				'data' => 'sidebars'
			),

			array(
	 			'id'=>'wc-archive-sidebar-position',
	 			'type' => 'button_set',
				'title' => esc_html__('Global Product Archive Sidebar Position', 'boo'),
	 			'subtitle'=> esc_html__('Controls the position of sidebar 1 for product archive pages. If sidebar 2 is selected, it will display on the opposite side.', 'boo'),
				'options' => array(
					'left' => esc_html__( 'Left', 'boo' ),
					'right' => esc_html__( 'Right', 'boo' )
				),
				'default' => 'right'
			)
		)
	);

}
