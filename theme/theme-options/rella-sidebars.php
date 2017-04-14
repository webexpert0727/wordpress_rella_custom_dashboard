<?php
/*
 * Header Section
*/
$this->sections[] = array(
	'title'  => esc_html__('Sidebars', 'boo'),
	'icon'   => 'el-icon-photo'
);

// Page Sidebar
$this->sections[] = array(
	'title'  => esc_html__('Page', 'boo'),
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'page-enable-global',
			'type'	 => 'button_set',
			'title' => esc_html__('Activate Global Sidebar For Pages', 'boo'),
			'subtitle' => esc_html__('Turn on if you want to use the same sidebars on all pages. This option overrides the page options.', 'boo'),
			'options' => array(
				'on' => 'On',
				'off' => 'Off'
			),
			'default' => 'off'
		),

		array(
 			'id'=>'page-sidebar-one',
 			'type' => 'select',
 			'title' => esc_html__('Global Page Sidebar 1', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 1 that will display on all pages.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'page-sidebar-two',
 			'type' => 'select',
 			'title' => esc_html__('Global Page Sidebar 2', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 2 that will display on all pages. Sidebar 2 can only be used if sidebar 1 is selected.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'page-sidebar-position',
 			'type' => 'button_set',
 			'title' => esc_html__('Global Page Sidebar Position', 'boo'),
 			'subtitle'=> esc_html__('Controls the position of sidebar 1 for all pages. If sidebar 2 is selected, it will display on the opposite side.', 'boo'),
			'options' => array(
				'left' => esc_html__( 'Left', 'boo' ),
				'right' => esc_html__( 'Right', 'boo' )
			),
			'default' => 'right'
		)
	)
);

// Portfolio Sidebar
$this->sections[] = array(
	'title'  => esc_html__('Portfolio Posts', 'boo'),
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'portfolio-enable-global',
			'type'	 => 'button_set',
			'title' => esc_html__('Activate Global Sidebar For Portfolio Posts', 'boo'),
			'subtitle' => esc_html__('Turn on if you want to use the same sidebars on all portfolio posts. This option overrides the portfolio options.', 'boo'),
			'options' => array(
				'on' => 'On',
				'off' => 'Off'
			),
			'default' => 'off'
		),

		array(
 			'id'=>'portfolio-sidebar-one',
 			'type' => 'select',
 			'title' => esc_html__('Global Portfolio Posts Sidebar 1', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 1 that will display on all portfolio posts.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'portfolio-sidebar-two',
 			'type' => 'select',
 			'title' => esc_html__('Global Portfolio Posts Sidebar 2', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 2 that will display on all portfolio posts. Sidebar 2 can only be used if sidebar 1 is selected.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'portfolio-sidebar-position',
 			'type' => 'button_set',
 			'title' => esc_html__('Global Portfolio Sidebar Position', 'boo'),
 			'subtitle'=> esc_html__('Controls the position of sidebar 1 for all portfolio posts. If sidebar 2 is selected, it will display on the opposite side.', 'boo'),
			'options' => array(
				'left' => esc_html__( 'Left', 'boo' ),
				'right' => esc_html__( 'Right', 'boo' )
			),
			'default' => 'right'
		)
	)
);

// Portfolio Archive Sidebar
$this->sections[] = array(
	'title'  => esc_html__('Portfolio Archive', 'boo'),
	'subsection' => true,
	'fields' => array(

		array(
 			'id'=>'portfolio-archive-sidebar-one',
 			'type' => 'select',
 			'title' => esc_html__('Portfolio Archive Sidebar 1', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 1 that will display on the portfolio archive pages.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'portfolio-archive-sidebar-two',
 			'type' => 'select',
 			'title' => esc_html__('Portfolio Archive Sidebar 2', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 2 that will display on the portfolio archive pages. Sidebar 2 can only be used if sidebar 1 is selected.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'portfolio-archive-sidebar-position',
 			'type' => 'button_set',
			'title' => esc_html__('Global Portfolio Archive Sidebar Position', 'boo'),
 			'subtitle'=> esc_html__('Controls the position of sidebar 1 for portfolio archive pages. If sidebar 2 is selected, it will display on the opposite side.', 'boo'),
			'options' => array(
				'left' => esc_html__( 'Left', 'boo' ),
				'right' => esc_html__( 'Right', 'boo' )
			),
			'default' => 'right'
		)
	)
);

// Blog Posts Sidebar
$this->sections[] = array(
	'title'  => esc_html__('Blog Posts', 'boo'),
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'blog-enable-global',
			'type'	 => 'button_set',
			'title' => esc_html__('Activate Global Sidebar For Blog Posts', 'boo'),
			'subtitle' => esc_html__('Turn on if you want to use the same sidebars on all blog posts. This option overrides the blog options.', 'boo'),
			'options' => array(
				'on' => 'On',
				'off' => 'Off'
			),
			'default' => 'off'
		),

		array(
 			'id'=>'blog-sidebar-one',
 			'type' => 'select',
 			'title' => esc_html__('Global Blog Posts Sidebar 1', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 1 that will display on all blog posts.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'blog-sidebar-two',
 			'type' => 'select',
 			'title' => esc_html__('Global Blog Posts Sidebar 2', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 2 that will display on all blog posts. Sidebar 2 can only be used if sidebar 1 is selected.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'blog-sidebar-position',
 			'type' => 'button_set',
 			'title' => esc_html__('Global Blog Sidebar Position', 'boo'),
 			'subtitle'=> esc_html__('Controls the position of sidebar 1 for all blog posts. If sidebar 2 is selected, it will display on the opposite side.', 'boo'),
			'options' => array(
				'left' => esc_html__( 'Left', 'boo' ),
				'right' => esc_html__( 'Right', 'boo' )
			),
			'default' => 'right'
		)
	)
);

// Blog Archive Sidebar
$this->sections[] = array(
	'title'  => esc_html__('Blog Archive', 'boo'),
	'subsection' => true,
	'fields' => array(

		array(
 			'id'=>'blog-archive-sidebar-one',
 			'type' => 'select',
 			'title' => esc_html__('Blog Archive Sidebar 1', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 1 that will display on the blog archive pages.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'blog-archive-sidebar-two',
 			'type' => 'select',
 			'title' => esc_html__('Blog Archive Sidebar 2', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 2 that will display on the blog archive pages. Sidebar 2 can only be used if sidebar 1 is selected.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'blog-archive-sidebar-position',
 			'type' => 'button_set',
			'title' => esc_html__('Global Blog Archive Sidebar Position', 'boo'),
 			'subtitle'=> esc_html__('Controls the position of sidebar 1 for blog archive pages. If sidebar 2 is selected, it will display on the opposite side.', 'boo'),
			'options' => array(
				'left' => esc_html__( 'Left', 'boo' ),
				'right' => esc_html__( 'Right', 'boo' )
			),
			'default' => 'right'
		)
	)
);

// Search page Sidebar
$this->sections[] = array(
	'title'  => esc_html__('Search Page', 'boo'),
	'subsection' => true,
	'fields' => array(

		array(
 			'id'=>'search-sidebar-one',
 			'type' => 'select',
 			'title' => esc_html__('Search Page Sidebar 1', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 1 that will display on the search results page.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'search-sidebar-two',
 			'type' => 'select',
 			'title' => esc_html__('Search Page Sidebar 2', 'boo'),
 			'subtitle'=> esc_html__('Select sidebar 2 that will display on the search results page. Sidebar 2 can only be used if sidebar 1 is selected.', 'boo'),
			'data' => 'sidebars'
		),

		array(
 			'id'=>'search-sidebar-position',
 			'type' => 'button_set',
 			'title' => esc_html__('Search Sidebar Position', 'boo'),
 			'subtitle'=> esc_html__('Controls the position of sidebar 1 for the search results page. If sidebar 2 is selected, it will display on the opposite side.', 'boo'),
			'options' => array(
				'left' => esc_html__( 'Left', 'boo' ),
				'right' => esc_html__( 'Right', 'boo' )
			),
			'default' => 'right'
		)
	)
);

rella_action( 'option_sidebars', $this );
