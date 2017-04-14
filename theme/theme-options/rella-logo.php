<?php
/*
 * General Section
*/

$this->sections[] = array(
	'title'  => esc_html__('Logo', 'boo'),
	'icon'   => 'el-icon-plus-sign'
);

// Body
$this->sections[] = array(
	'title'  => esc_html__('Logo', 'boo'),
	'subsection' => true,
	'fields' => array(

		array(
			'id'=>'header-logo',
			'type' => 'media',
			'url' => true,
			'title' => esc_html__('Default Logo', 'boo'),
			'subtitle' => esc_html__('Select an image file for your logo.', 'boo'),
		),

		array(
			'id'=>'header-logo-retina',
			'type' => 'media',
			'url'=> true,
			'title' => esc_html__('Retina Default Logo', 'boo'),
			'subtitle'=> esc_html__('Select an image file for the retina version of the logo. It should be exactly 2x the size of the main logo.', 'boo'),
		),

		array(
			'id'=>'menu-logo',
			'type' => 'media',
			'url' => true,
			'title' => esc_html__('Menu Logo', 'boo'),
			'subtitle' => esc_html__('Upload the logo that will be displayed in the menu bar for small devices.', 'boo'),
		)
	)
);

// Headers
$this->sections[] = array(
	'title'  => esc_html__('Favicon', 'boo'),
	'subsection' => true,
	'fields'      => array(

		array(
			'id'          => 'favicon',
			'type'        => 'media',
			'title'       => esc_html__( 'Favicon', 'boo' ),
			'subtitle' => esc_html__( 'Favicon for your website at 16px x 16px.', 'boo' )
		),

		array(
			'id'          => 'iphone_icon',
			'type'        => 'media',
			'title'       => esc_html__( 'Apple iPhone Icon Upload', 'boo' ),
			'subtitle' => esc_html__( 'Favicon for Apple iPhone at 57px x 57px.', 'boo' )
		),

		array(
			'id'          => 'iphone_icon_retina',
			'type'        => 'media',
			'title'       => esc_html__( 'Apple iPhone Retina Icon Upload', 'boo' ),
			'subtitle' => esc_html__( 'Favicon for Apple iPhone Retina Version at 114px x 114px.', 'boo' ),
			'required'    => array(
				array( 'iphone_icon', '!=', '' ),
				array( 'iphone_icon', '!=', array( 'url'  => '' ) )
			)
		),

		array(
			'id'          => 'ipad_icon',
			'type'        => 'media',
			'title'       => esc_html__( 'Apple iPad Icon Upload', 'boo' ),
			'subtitle' => esc_html__( 'Favicon for Apple iPad at 72px x 72px.', 'boo' )
		),

		array(
			'id'          => 'ipad_icon_retina',
			'type'        => 'media',
			'title'       => esc_html__( 'Apple iPad Retina Icon Upload', 'boo' ),
			'subtitle' => esc_html__( 'Favicon for Apple iPad Retina Version at 144px x 144px.', 'boo' ),
			'required'    => array(
				array( 'ipad_icon', '!=', '' ),
				array( 'ipad_icon', '!=', array( 'url'  => '' ) )
			)
		)
	)
);
