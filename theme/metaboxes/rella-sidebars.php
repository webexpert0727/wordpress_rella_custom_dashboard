<?php
/*
 * Slider Section
*/

$sections[] = array(
	'post_types' => array( 'post', 'page', 'product' ),
	'title' => esc_html__('Sidebars', 'boo'),
	'icon' => 'el-icon-adjust-alt',
	'fields' => array(

		array(
 			'id'=>'rella-sidebar-one',
 			'type' => 'select',
 			'title' => esc_html__('Select Sidebar 1', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 1 that will display on this page. Choose "No Sidebar" for full width.', 'boo'),
			'options' => rella_helper()->get_sidebars( array( 'none' => esc_html__( 'No Sidebar', 'boo' ), 'main' => esc_html__( 'Main Sidebar', 'boo' ) ) ),
		),

		array(
 			'id'=>'rella-sidebar-two',
 			'type' => 'select',
 			'title' => esc_html__('Select Sidebar 2', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 2 that will display on this page. Sidebar 2 can only be used if sidebar 1 is selected.', 'boo'),
			'options' => rella_helper()->get_sidebars( array( 'none' => esc_html__( 'No Sidebar', 'boo' ), 'main' => esc_html__( 'Main Sidebar', 'boo' ) ) ),
			'required' => array(
				array( 'rella-sidebar-one', 'not', '' ),
				array( 'rella-sidebar-one', 'not', 'none' )
			)
		),

		array(
 			'id'=>'rella-sidebar-position',
 			'type' => 'button_set',
 			'title' => esc_html__('Sidebar 1 Position', 'boo'),
 			'subtitle'=> esc_html__('Select the sidebar 1 position. If sidebar 2 is selected, it will display on the opposite side. ', 'boo'),
			'options' => array(
				'default' => esc_html__( 'Default', 'boo' ),
				'left' => esc_html__( 'Left', 'boo' ),
				'right' => esc_html__( 'Right', 'boo' )
			),
			'required' => array(
				array( 'rella-sidebar-one', 'not', '' ),
				array( 'rella-sidebar-one', 'not', 'none' )
			),
			'default' => 'default'
		)
	)
);
