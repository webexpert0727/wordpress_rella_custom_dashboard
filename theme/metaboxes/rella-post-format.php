<?php
/*
 * Post
*/

// Masonry Creative
$sections[] = array(
	'separate_box' => true,
	'box_title'    => esc_html__( 'Masonry Creative', 'boo' ),
	'post_types' => array( 'post' ),
	'icon' => 'el-icon-screen',
	'position' => 'side',
	'priority' => 'low',
	'fields' => array(

		array(
			'id' => 'post-height',
			'type' => 'select',
			'title' => esc_html__( 'Height', 'boo' ),
			'options' => array(
				'default' => esc_html__( 'Default', 'boo' ),
				'tall' => esc_html__( 'Tall', 'boo' )
			),
			'default' => 'default'
		),

		array(
			'id' => 'post-width',
			'type' => 'select',
			'title' => esc_html__( 'Width', 'boo' ),
			'options' => array(
				'col-md-3' => esc_html__( 'Default', 'boo' ),
				'col-md-6' => esc_html__( 'Stretch', 'boo' )
			),
			'default' => 'col-md-3'
		)
	)
);

// Audio
$sections[] = array(
	'separate_box' => true,
	'box_title'    => esc_html__( 'Audio', 'boo' ),
	'post_types' => array( 'post', 'rella-portfolio' ),
	'post_format' => array( 'audio' ),
	'icon' => 'el-icon-screen',
	'fields' => array(

		array(
			'id' => 'post-audio',
			'type' => 'text',
			'title' => esc_html__( 'Audio URL', 'boo' ),
			'desc' => esc_html__( 'Audio file URL in format: mp3, ogg, wav.', 'boo' )
		)
	)
);

// Gallery
$sections[] = array(
	'separate_box' => true,
	'box_title'    => esc_html__( 'Gallery', 'boo' ),
	'post_types' => array( 'post', 'rella-portfolio' ),
	'post_format' => array( 'gallery' ),
	'icon' => 'el-icon-screen',
	'fields' => array(

		array(
			'id'        => 'post-gallery',
			'type'      => 'slides',
			'title'     => esc_html__( 'Gallery Slider', 'boo' ),
			'subtitle'  => esc_html__( 'Upload images or add from media library.', 'boo' ),
			'placeholder'   => array(
				'title'     => esc_html__( 'Title', 'boo' ),
			),
			'show' => array(
				'title' => true,
				'description' => false,
				'url' => false,
			)
		)
	)
);

// Link
$sections[] = array(
	'separate_box' => true,
	'box_title'    => esc_html__( 'Link', 'boo' ),
	'post_types' => array( 'post' ),
	'post_format' => array( 'link' ),
	'icon' => 'el-icon-screen',
	'fields' => array(

		array(
			'id'        => 'post-link-url',
			'type'      => 'text',
			'title'     => esc_html__( 'URL', 'boo' )
		)
	)
);

// Quote
$sections[] = array(
	'separate_box' => true,
	'box_title'    => esc_html__( 'Quote', 'boo' ),
	'post_types' => array( 'post' ),
	'post_format' => array( 'quote' ),
	'icon' => 'el-icon-screen',
	'fields' => array(
		array(
			'id'        => 'post-quote-url',
			'type'      => 'text',
			'title'     => esc_html__( 'Cite', 'boo' )
		)
	)
);

// Video
$sections[] = array(
	'separate_box' => true,
	'box_title'    => esc_html__( 'Video', 'boo' ),
	'post_types' => array( 'post', 'rella-portfolio' ),
	'post_format' => array( 'video' ),
	'icon' => 'el-icon-screen',
	'fields' => array(

		array(
			'id'        => 'post-video-url',
			'type'      => 'text',
			'title'     => esc_html__( 'Video URL', 'boo' ),
			'desc'  => esc_html__( 'YouTube or Vimeo video URL', 'boo' )
		),

		array(
			'id'        => 'post-video-file',
			'type'      => 'editor',
			'title'     => esc_html__( 'Video Upload', 'boo' ),
			'desc'  => esc_html__( 'Upload video file', 'boo' )
		),

		array(
			'id'        => 'post-video-html',
			'type'      => 'textarea',
			'title'     => esc_html__( 'Embadded video', 'boo' ),
			'desc'  => esc_html__( 'Use this option when the video does not come from YouTube or Vimeo', 'boo' )
		)
	)
);
