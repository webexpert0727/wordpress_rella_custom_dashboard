<?php
/*
 * Portfoli General
 *
 * Available options on $section array:
 * separate_box (boolean) - separate metabox is created if true
 * box_title - title for separate metabox
 * title - section title
 * desc - section description
 * icon - section icon
 * fields - fields, @see https://docs.reduxframework.com/ for details
*/

$sections[] = array(
	'post_types'   => array('rella-portfolio'),
	'separate_box' => true,
	'box_title'    => esc_html__('Portfolio Description', 'boo'),
	'icon'         => 'el-icon-cog',
	'fields'       => array(

		array(
			'id'   => 'portfolio-description',
			'type' => 'editor'
		)
	)
);

$sections[] = array(
	'post_types' => array('rella-portfolio'),
	'title'      => esc_html__('Portfolio General', 'boo'),
	'icon'       => 'el-icon-cog',
	'fields'     => array(

		array(
			'id'       => 'portfolio-style',
			'type'     => 'select',
			'title'    => esc_html__( 'Portfolio Style', 'boo' ),
			'subtitle' => esc_html__( 'Choose template for portfolio.', 'boo' ),
			'options'  => array(
				'before-after'      => esc_html__( 'Before-After', 'boo' ), // 10
				'featured-image'    => esc_html__( 'Featured Image', 'boo' ), // 13
				'gallery-stacked'   => esc_html__( 'Stacked Gallery', 'boo' ),
				'gallery-stacked-2' => esc_html__( 'Stacked Gallery 2', 'boo' ),
				'gallery-stacked-3' => esc_html__( 'Stacked Gallery 3', 'boo' ),
				'gallery-stacked-4' => esc_html__( 'Stacked Gallery 4', 'boo' ), // 8
				'gallery-stacked-5' => esc_html__( 'Stacked Gallery 5', 'boo' ), // 9
				'gallery-stacked-6' => esc_html__( 'Stacked Gallery 6', 'boo' ), // 12
				'gallery-slider'    => esc_html__( 'Gallery Slider', 'boo' ),
				'gallery-slider-2'  => esc_html__( 'Gallery Slider 2', 'boo' ),
				'gallery-slider-3'  => esc_html__( 'Gallery Slider 3', 'boo' ), // 7
				'gallery-slider-4'  => esc_html__( 'Gallery Slider 4', 'boo' ), // 11
				'masonry'           => esc_html__( 'Masonry', 'boo' ),
				'custom'            => esc_html__( 'Custom', 'boo' )
			)
		),

		array(

			'id'       => 'portfolio-align',
			'type'     => 'select',
			'title'    => esc_html__( 'Portfolio Content Alignment', 'boo' ),
			'subtitle' => esc_html__( 'Content alignment on Classic portfolio listing page', 'boo' ),
			'options'  => array(
				'default'       => esc_html__( 'Default', 'boo' ),
				'left'          =>  esc_html__( 'Left', 'boo' ),
				'center'        => esc_html__( 'Center', 'boo' ),
				'right'         => esc_html__( 'Right', 'boo' ),
				'inside-left'   => esc_html__( 'Inside Left', 'boo' ),
				'inside-center' => esc_html__( 'Inside Center', 'boo' ),
				'inside-right'  => esc_html__( 'Inside Right', 'boo' ),
			),
		),

		array(
			'id'       => 'portfolio-width',
			'type'     => 'select',
			'title'    => esc_html( 'Width', 'boo' ),
			'subtitle' => esc_html__( 'Select desired width for the portfolio item on portfolio listing page', 'boo' ),
			'options'  => array(
				'auto' => esc_html__( 'Auto - width determined by thumbnail width', 'boo' ),
				'3'    => esc_html__( '3 columns - 1/4', 'boo' ),
				'4'    => esc_html__( '4 columns - 1/3', 'boo' ),
				'5'    => esc_html__( '5 columns - 5/12', 'boo' ),
				'6'    => esc_html__( '6 columns - 1/2', 'boo' ),
				'7'    => esc_html__( '7 columns - 7/12', 'boo' ),
				'8'    => esc_html__( '8 columns - 2/3', 'boo' ),
				'9'    => esc_html__( '9 columns - 3/4', 'boo' ),
				'10'   => esc_html__( '10 columns - 5/6', 'boo' ),
				'11'   => esc_html__( '11 columns - 11/12', 'boo' ),
				'12'   => esc_html__( '12 columns - 12/12', 'boo' ),
			)
		),

		array(
			'id'       => 'portfolio-before-image',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__('Before Image', 'boo'),
			'default'  => '',
			'required' => array(
				'portfolio-style',
				'equals',
				'before-after'
			)
		),

		array(
			'id'       => 'portfolio-after-image',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__('After Image', 'boo'),
			'default'  => '',
			'required' => array(
				'portfolio-style',
				'equals',
				'before-after'
			)
		),

		array(
			'id'       => '_portfolio_image_size',
			'type'     => 'select',
			'title'    => esc_html__( 'Thumbnail Sizes', 'boo' ),
			'subtitle' => esc_html__( 'Choose Portfolio Thumnbail size. Works only for VC element "Portfolio" on homepage', 'boo' ),
			'options'  => array(

				'rella-portfolio'          => esc_html__( 'Default - (480px x 480px)',    'boo' ),
				'rella-portfolio-sq'       => esc_html__( 'Square - (285px x 285px)',     'boo' ),
				'rella-portfolio-big-sq'   => esc_html__( 'Big Square - (570px x 570px)', 'boo' ),
				'rella-portfolio-portrait' => esc_html__( 'Portrait - (285px x 570px)',   'boo' ),
				'rella-portfolio-portrait-tall' => esc_html__( 'Packery Portrait - (570px x 867px)',   'boo' ),
				'rella-portfolio-wide'     => esc_html__( 'Wide - (570px x 285px)',       'boo' ),

				'rella-full-3'             => esc_html__( 'Full - 3 columns', 'boo' ),
				'rella-full-4'             => esc_html__( 'Full - 4 columns', 'boo' ),
				'rella-full-6'             => esc_html__( 'Full - 6 columns', 'boo' ),
				'rella-full-8'             => esc_html__( 'Full - 8 columns', 'boo' ),

			)
		),

		array(
			'id'       => '_caption_position',
			'type'     => 'select',
			'title'    => esc_html__( 'Caption Position', 'boo' ),
			'subtitle' => esc_html__( 'Select a position for caption (Used in Masonry style)', 'boo' ),
			'options'  => array(
				'caption-top-left'     => esc_html__( 'Top Left', 'boo' ),
				'caption-top-right'    => esc_html__( 'Top Right', 'boo' ),
				'caption-bottom-left'  => esc_html__( 'Bottom Left', 'boo' ),
				'caption-bottom-right' => esc_html__( 'Bottom Right', 'boo' ),
			)
		)

	), // #fields
);
