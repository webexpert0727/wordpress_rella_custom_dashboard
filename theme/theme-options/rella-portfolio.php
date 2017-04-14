<?php
/*
 * Portfolio
 */
$this->sections[] = array(
	'title'  => esc_html__( 'Portfolio', 'boo' ),
	'icon'   => 'el-icon-th'
);

$this->sections[] = array(
	'title'      => esc_html__( 'General', 'boo' ),
	'subsection' => true,
	'fields'     => array(

		array(
			'id'    => 'info_warning',
			'type'  => 'info',
			'title' => esc_html__( 'IMPORTANT NOTE:', 'boo' ),
			'style' => 'info',
			'desc'  => esc_html__( 'The options on this tab only control the portfolio page templates and portfolio archives, not the recent work shortcode. The only options on this tab that work with the recent work shortcode is the Load More Post Button Color.', 'boo' )
		),

		array(
			'type'  => 'text',
			'id'    => 'portfolio-single-slug',
			'title' => esc_html__( 'Portfolio Slug', 'boo' ),
			'subtitle' => esc_html__( 'The slug name cannot be the same name as your portfolio page or the layout will break. This option changes the permalink when you use the permalink type as %postname%. Visit the Settings - Permalinks screen after changing this setting', 'boo' ),
		),
		
		array(
			'id'       => 'portfolio-excerpt-length',
			'type'     => 'text',
			'title'    => esc_html__( 'Portflio excerpt length', 'boo' ),
			'validate' => 'numeric',
			'default'  => '45',
		),
		
	)
);

$this->sections[] = array(
	'title'      => esc_html__( 'Single Post', 'boo' ),
	'subsection' => true,
	'fields'     => array(

		array(
			'id'       => 'portfolio-likes-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Like Button', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display the like button on single portfolio posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default' => 'on'
		),

		array(
			'id'       => 'portfolio-social-box-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Social Sharing Box', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display the social sharing box on single portfolio posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default'  => 'on'
		),
		
		array(
			'id'      => 'title-bar-nav',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Enable Portfolio Navigation in Titlebar', 'boo' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'boo' ),
				'off' => esc_html__( 'Off', 'boo' ),
			),
			'default'  => 'on'
		),

		array(
			'id'       => 'portfolio-navigation-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Previous/Next Pagination below the content', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display the previous/next post pagination for single portfolio posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default'  => 'on'
		),

		array(
			'id'       => 'portfolio-related-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Related Projects', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display related projects on single portfolio posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default' => 'on'
		),

		array(
			'type'    => 'text',
			'id'      => 'portfolio-related-title',
			'title'   => esc_html__( 'Related Project Title', 'boo' ),
			'default' => 'Related Projects',
			'required' => array(
				'portfolio-related-enable',
				'equals',
				'on'
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
				'equals',
				'on'
			)
		)
	)
);
