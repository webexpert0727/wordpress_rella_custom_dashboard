<?php
/*
 * General Section
*/

$this->sections[] = array(
	'title'  => esc_html__('Typography', 'boo'),
	'icon'   => 'el-icon-fontsize'
);

// Body
$this->sections[] = array(
	'title'  => esc_html__('Body Typography', 'boo'),
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'body_typography',
			'title'       => esc_html__( 'Body Typography', 'boo' ),
			'subtitle' => esc_html__( 'These settings control the typography for all body text.', 'boo' ),
			'type'        => 'typography',
			'letter-spacing' => true,
			'text-align' => false,
			'compiler' => true,
			'units' => '%',
			'default'     => array(
				'font-family'    => 'PT Sans',
				'font-size'      => '13px',
				'font-weight'    => '400',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#747474',
			)
		),

		array(
			'id'             => 'body_extra_typography',
			'title'          => esc_html__( 'Body Extra Typography', 'boo' ),
			'subtitle'       => esc_html__( 'This setting control the typography for some elements in text.', 'boo' ),
			'type'           => 'typography',
			'letter-spacing' => false,
			'text-align'     => false,
			'units'          => '%',
			'all_styles'     => true,
			'color'          => false,
			'font-size'      => false,
			'line-height'    => false,
			'font-style'     => false,
			'font-weight'    => false
		),
		
		array(
			'id'             => 'body_sec_extra_typography',
			'title'          => esc_html__( 'Body Extra Typography', 'boo' ),
			'subtitle'       => esc_html__( 'This setting control the typography for some elements in text.', 'boo' ),
			'type'           => 'typography',
			'letter-spacing' => false,
			'text-align'     => false,
			'units'          => '%',
			'all_styles'     => true,
			'color'          => false,
			'font-size'      => false,
			'line-height'    => false,
			'font-style'     => false,
			'font-weight'    => false
		),
		
		
	)
);


// Headers
$this->sections[] = array(
	'title'  => esc_html__('Headings Typography', 'boo'),
	'subsection' => true,
	'fields' => array(

		'h1_typography' => array(
			'id'          => 'h1_typography',
			'title'       => esc_html__( 'H1 Heading Typography', 'boo' ),
			'subtitle' => esc_html__( 'These settings control the typography for all H1 Heading.', 'boo' ),
			'type'        => 'typography',
			'letter-spacing' => true,
			'text-align' => false,
			'compiler' => true,
			'units' => '%',
			'default'     => array(
				'font-family'    => 'Antic Slab',
				'font-size'      => '34px',
				'font-weight'    => '400',
				'line-height'    => '1.4',
				'letter-spacing' => '0',
				'color'          => '#333333'
			)
		),

		'h2_typography' => array(
			'id'          => 'h2_typography',
			'title'       => esc_html__( 'H2 Heading Typography', 'boo' ),
			'subtitle' => esc_html__( 'These settings control the typography for all H2 Headings.', 'boo' ),
			'type'        => 'typography',
			'letter-spacing' => true,
			'text-align' => false,
			'compiler' => true,
			'units' => '%',
			'default'     => array(
				'font-family'    => 'Antic Slab',
				'font-size'      => '18px',
				'font-weight'    => '400',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#333333'
			)
		),

		'h3_typography' => array(
			'id'          => 'h3_typography',
			'title'       => esc_html__( 'H3 Heading Typography', 'boo' ),
			'subtitle' => esc_html__( 'These settings control the typography for all H3 Headings.', 'boo' ),
			'type'        => 'typography',
			'letter-spacing' => true,
			'text-align' => false,
			'compiler' => true,
			'units' => '%',
			'default'     => array(
				'font-family'    => 'Antic Slab',
				'font-size'      => '16px',
				'font-weight'    => '400',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#333333'
			)
		),

		'h4_typography' => array(
			'id'          => 'h4_typography',
			'title'       => esc_html__( 'H4 Heading Typography', 'boo' ),
			'subtitle' => esc_html__( 'These settings control the typography for all H4 Headings.', 'boo' ),
			'type'        => 'typography',
			'letter-spacing' => true,
			'text-align' => false,
			'compiler' => true,
			'units' => '%',
			'default'     => array(
				'font-family'    => 'Antic Slab',
				'font-size'      => '13px',
				'font-weight'    => '400',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#333333'
			)
		),

		'h5_typography' => array(
			'id'          => 'h5_typography',
			'title'       => esc_html__( 'H5 Heading Typography', 'boo' ),
			'subtitle' => esc_html__( 'These settings control the typography for all H5 Headings.', 'boo' ),
			'type'        => 'typography',
			'letter-spacing' => true,
			'text-align' => false,
			'compiler' => true,
			'units' => '%',
			'default'     => array(
				'font-family'    => 'Antic Slab',
				'font-size'      => '12px',
				'font-weight'    => '400',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#333333'
			)
		),

		'h6_typography' => array(
			'id'          => 'h6_typography',
			'title'       => esc_html__( 'H6 Heading Typography', 'boo' ),
			'subtitle' => esc_html__( 'These settings control the typography for all H6 Headings.', 'boo' ),
			'type'        => 'typography',
			'letter-spacing' => true,
			'text-align' => false,
			'compiler' => true,
			'units' => '%',
			'default'     => array(
				'font-family'    => 'Antic Slab',
				'font-size'      => '11px',
				'font-weight'    => '400',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'color'          => '#333333'
			)
		),
	)
);

//Additional Google fonts
$this->sections[] = array(
	'title'      => esc_html__( 'Additional Fonts', 'boo' ),
	'subsection' => true,
	'fields'     => array(

		array(
			'id'             => 'adds_google_font',
			'title'          => esc_html__( 'Google Font', 'boo' ),
			'subtitle'       => esc_html__( 'Select additional google font to load in theme', 'boo' ),
			'type'           => 'typography',
			'letter-spacing' => false,
			'text-align'     => false,
			'units'          => '%',
			'all_styles'     => true,
			'color'          => false,
			'font-size'      => false,
			'line-height'    => false,
			'font-style'     => false,
			'font-weight'    => false
		),

		array(
			'id'             => 'adds_google_font_2',
			'title'          => esc_html__( 'Google Font', 'boo' ),
			'subtitle'       => esc_html__( 'Select additional google font to load in theme', 'boo' ),
			'type'           => 'typography',
			'letter-spacing' => false,
			'text-align'     => false,
			'units'          => '%',
			'all_styles'     => true,
			'color'          => false,
			'font-size'      => false,
			'line-height'    => false,
			'font-style'     => false,
			'font-weight'    => false
		),
		
		array(
			'id'             => 'adds_google_font_3',
			'title'          => esc_html__( 'Google Font', 'boo' ),
			'subtitle'       => esc_html__( 'Select additional google font to load in theme', 'boo' ),
			'type'           => 'typography',
			'letter-spacing' => false,
			'text-align'     => false,
			'units'          => '%',
			'all_styles'     => true,
			'color'          => false,
			'font-size'      => false,
			'line-height'    => false,
			'font-style'     => false,
			'font-weight'    => false
		),
				
	)
);

//Shortcode Google fonts
$this->sections[] = array(
	'title'      => esc_html__( 'Shortcodes Fonts', 'boo' ),
	'subsection' => true,
	'fields'     => array(
		
		array(
			'id'             => 'btn_sc_fonts',
			'title'          => esc_html__( 'Button Shortcode Font', 'boo' ),
			'subtitle'       => esc_html__( 'Select google font for shortocode button', 'boo' ),
			'type'           => 'typography',
			'letter-spacing' => true,
			'text-transform' => true,
			'text-align'     => false,
			'units'          => '%',
			'all_styles'     => true,
			'color'          => false,
			'font-size'      => true,
			'line-height'    => true,
			'font-style'     => false,
			'font-weight'    => true
		),
	)
);