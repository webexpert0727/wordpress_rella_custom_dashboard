<?php

$this->sections[] = array(
	'title' => esc_html__( 'Woocommerce', 'boo' ),
	'icon'  => 'el-icon-shopping-cart'
);

$this->sections[] = array(
	'title'      => esc_html__( 'Shop Settings', 'boo' ),
	'subsection' => true,
	'fields'     => array(
		
		array(
			'id'    => 'ra_woo_style',
			'type'  => 'select',	
			'title' => esc_html__( 'Shop Catalog Style', 'boo' ),
			'desc'  => esc_html__( 'Select a style for products to display on shop catalog', 'boo' ),
			'options' => array(
				'elegant' => esc_html( 'Elegant', 'boo' )
			),
			'default' => 'elegant'

		),
		
		array(
			'id'      => 'ra_woo_products_per_page',
			'type'    => 'text',	
			'title'   => esc_html__( 'Products per page', 'boo' ),
			'desc'    => esc_html__( 'How many products per page to display?', 'boo' ),
			'default' => '12'
		),

		array(
			'id'    => 'ra_woo_columns',
			'type'  => 'select',	
			'title' => esc_html__( 'Shop Columns', 'boo' ),
			'desc'  => esc_html__( 'Select how many columns per row to display', 'boo' ),
			'options' => array(
				'1' => esc_html( '1', 'boo' ),
				'2' => esc_html( '2', 'boo' ),
				'3' => esc_html( '3', 'boo' ),
				'4' => esc_html( '4', 'boo' ),
				'5' => esc_html( '5', 'boo' ),
				'6' => esc_html( '6', 'boo' ),
			),
			'default' => '3'

		),

	) 
);

$this->sections[] = array(
	'title' => esc_html__( 'Single Product', 'boo' ),
	'subsection' => true,
	'fields' => array(
			
		array(
			'id'    => 'ra_woo_related_columns',
			'type'  => 'select',	
			'title' => esc_html__( 'Related/Up-Sell/Cross-Sell Products Number of Columns', 'boo' ),
			'desc'  => esc_html__( 'Select how many columns per row to display', 'boo' ),
			'options' => array(
				'1' => esc_html( '1', 'boo' ),
				'2' => esc_html( '2', 'boo' ),
				'3' => esc_html( '3', 'boo' ),
				'4' => esc_html( '4', 'boo' ),
				'5' => esc_html( '5', 'boo' ),
				'6' => esc_html( '6', 'boo' ),
			),
			'default' => '4'

		),
		
	)
);
	
?>