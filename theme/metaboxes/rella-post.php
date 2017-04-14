<?php
/**
 * Post
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
	'post_types' => array('post'),
	'title'      => esc_html__( 'Post Options', 'boo' ),
	'icon'       => 'el-icon-screen',
	'fields'     => array(

		array(
			'id'      => 'post-style',
			'type'    => 'select',
			'title'   => esc_html__( 'Style', 'boo' ),
			'options' => array(
				'default' => esc_html__( 'Default', 'boo' ),
				'cover'   => esc_html__( 'Cover', 'boo' ),
				'minimal' => esc_html__( 'Minimal', 'boo' )
			),
		),

		array(
			'id'       => 'post-likes-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Like Button', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display the like button on single posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				''     => esc_html__( 'Default', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default'  => ''
		),

		array(
			'id'       => 'post-social-box-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Social Sharing Box', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display the social sharing box on single posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				''     => esc_html__( 'Default', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default'  => ''
		),


		array(
			'id'       => 'post-author-box-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Author Info Box', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display the author info box below posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				''     => esc_html__( 'Default', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default'  => ''
		),

		array(
			'id'       => 'post-navigation-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Previous/Next Pagination', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display the previous/next post pagination for single posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				''     => esc_html__( 'Default', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default'  => ''
		),

		array(
			'id'       => 'post-related-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Related Projects', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to display related projects on single posts.', 'boo' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'boo' ),
				''     => esc_html__( 'Default', 'boo' ),
				'off'  => esc_html__( 'Off', 'boo' )
			),
			'default'  => ''
		),

		array(
			'type'     => 'text',
			'id'       => 'post-related-title',
			'title'    => esc_html__( 'Related Project Title', 'boo' ),
			'default'  => 'You may also like',
			'required' => array(
				'post-related-enable',
				'!=',
				'off'
			)
		),

		array(
			'type'     => 'slider',
			'id'       => 'post-related-number',
			'title'    => esc_html__( 'Number of Related Projects', 'boo' ),
			'subtitle' => esc_html__( 'Controls the number of posts that display under related posts section.', 'boo' ),
			'default'  => 2,
			'max'      => 100,
			'required' => array(
				'post-related-enable',
				'!=',
				'off'
			)
		),

		array(
			'id'       => 'post-rating',
			'type'     => 'select',
			'title'    => esc_html__( 'Rating', 'boo' ),
			'subtitle' => esc_html__( 'Select a rating', 'boo' ),
			'options' => array(
				''    => 'None',
				'0'   => '0',
				'0.5' => '0.5',
				'1.0' => '1.0',
				'1.5' => '1.5',
				'2.0' => '2.0',
				'2.5' => '2.5',
				'3.0' => '3.0',
				'3.5' => '3.5',
				'4.0' => '4.0',
				'4.5' => '4.5',
				'5.0' => '5.0',
				'5.5' => '5.5',
				'6.0' => '6.0',
				'6.5' => '6.5',
				'7.0' => '7.0',
				'7.5' => '7.5',
				'8.0' => '8.0',
				'8.5' => '8.5',
				'9.0' => '9.0',
				'9.5' => '9.5',
				'10'  => '10',
			),
			'default'  => ''
		),

		array(
			'id'       => 'post-bg',
			'type'     => 'color',
			'title'    => esc_html__( 'Post background color', 'boo' ),
			'subtitle' => esc_html__( 'Used for some latest posts templates', 'boo' ),
			'validate' => 'color',
		),
		
		array(
			'id'       => 'post-gradient-bg',
			'type'     => 'color_gradient',
			'title'    => esc_html__( 'Post gradient background color', 'boo' ),
			'subtitle' => esc_html__( 'Used in 3d style in latest posts shortcode', 'boo' ),
			'validate' => 'color',
		),
		
	)
);
