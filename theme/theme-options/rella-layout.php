<?php
/*
 * Layout Section
*/

$this->sections[] = array(

	'title'  => esc_html__( 'Layout Settings', 'boo' ),
	'icon'   => 'el-icon-website',
	'fields' => array(

		array(
			'id'        => 'page-layout-width',
			'type'      => 'button_set',
			'title'     => esc_html__( 'Layout width', 'boo' ),
			'subtitle'  => esc_html__( 'Controls the site layout width', 'boo' ),
			'options'   => array(
				'standart' => esc_html__( 'Default - 1170px', 'boo' ),
				'wide'     => esc_html__( 'Wide - 1270px', 'boo' ),
			),
			'default'   => 'standart'
		),

		array(
			'id'    => 'content-padding',
			'type'	=> 'spacing',
			'title' => esc_html__('Content Padding', 'boo'),
			'left'  => false, 'right' => false,
			'units' => array(
				'px',
				'%',
				'em',
				'rem'
			)
		)

	)
);
