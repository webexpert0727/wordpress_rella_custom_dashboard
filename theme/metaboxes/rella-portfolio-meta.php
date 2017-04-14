<?php
/*
 * Portfolio Meta Section
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
	'post_types' => array( 'rella-portfolio' ),
	'title'      => esc_html__( 'Portfolio Meta', 'boo' ),
	'icon'       => 'el-icon-cog',
	'fields'     => array(

		array(
			'id'       => 'portfolio-likes-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Like Button', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display the like button on single portfolio posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				''     => esc_html__( 'Default', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default' => ''
		),

		array(
			'id'       => 'portfolio-social-box-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Social Sharing Box', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display the social sharing box on single portfolio posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				''     => esc_html__( 'Default', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default'  => ''
		),

		array(
			'id'       => 'portfolio-navigation-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Previous/Next Pagination', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display the previous/next post pagination for single portfolio posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				''     => esc_html__( 'Default', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default'  => ''
		),

		array(
			'id'       => 'portfolio-related-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Related Projects', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display related projects on single portfolio posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				''     => esc_html__( 'Default', 'boo' ),	
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default' => ''
		),

		array(
			'type'    => 'text',
			'id'      => 'portfolio-related-title',
			'title'   => esc_html__( 'Related Project Title', 'boo' ),
			'default' => 'Related Projects',
			'required' => array(
				'portfolio-related-enable',
				'!=',
				'off'
			)
		),

		array(
			'type'     => 'slider',
			'id'       => 'portfolio-related-number',
			'title'    => esc_html__( 'Number of Related Projects', 'boo' ),
			'subtitle' => esc_html__( 'Controls the number of projects that display under related project section.', 'boo' ),
			'default'  => 6,
			'max'      => 100,
			'required' => array(
				'portfolio-related-enable',
				'!=',
				'off'
			)
		),
		
		array(
			'type' => 'info',
			'id'   => 'portfolio-atts-info',
			'title' => esc_html( 'Portfolio Attributes', 'boo' ),
			'desc' => esc_html__( 'The Attributes of the portfolio item', 'boo' )
		),
		
		array(
			'id'       => 'portfolio-enable-date',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Show Date', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display published or custom date of the portfolio item', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				''     => esc_html__( 'Default', 'boo' ),	
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default' => ''
		),

		array(
			'id'    => 'portfolio-date-label',
			'type'  => 'text',
			'title' => esc_html__( 'Date Label', 'boo' ),
			'required' => array(
				'portfolio-enable-date',
				'!=',
				'off'
			)			
		),

		array(
			'id'    => 'portfolio-date',
			'type'  => 'date',
			'title' => esc_html__( 'Project Date', 'boo' ),
			'desc'  => esc_html__( 'Will overrite the published date of the portfolio post', 'boo' ),
			'required' => array(
				'portfolio-enable-date',
				'!=',
				'off'
			)			
		),

		array(
			'id'       => 'portfolio-website',
			'type'     => 'text',
			'validate' => 'url',
			'title'    => esc_html__( 'External Url', 'boo' )
		),

		array(
			'id'      => 'portfolio-attributes',
			'type'    => 'multi_text',
			'title'   => esc_html__( 'Portfolio attributes', 'boo' ),
			'desc'    => esc_html__( 'Add custom portfolio attributes. Divide by | label with value ( Label | Value )', 'boo' ),
			'default' => array(
				'Client | Themerella',
			),
		),

	), // #fields
);