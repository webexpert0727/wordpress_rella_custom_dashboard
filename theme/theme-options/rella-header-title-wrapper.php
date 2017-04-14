<?php
/*
 * Title Wrapper Section
*/

// Title Bar
$this->sections[] = array(
	'title'  => esc_html__( 'Title Wrapper', 'boo' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'title-bar-enable',
			'type'	 => 'button_set',
			'title' => esc_html__('Enable Title Wrapper', 'boo'),
			'subtitle' => esc_html__('If on, this layout part will be displayed.', 'boo'),
			'options' => array(
				'on' => 'On',
				'off' => 'Off'
			)
		),

		array(
			'id'=>'title-bar-heading',
			'type' => 'text',
			'title' => esc_html__('Heading', 'boo')
		),

		array(
			'id'=>'title-bar-subheading',
			'type' => 'text',
			'title' => esc_html__('Sub-Heading', 'boo')
		),

		array(
			'id'=>'title-bar-content',
			'type' => 'editor',
			'title' => esc_html__('Content', 'boo')
		),

		array(
			'id' => 'title-bar-breadcrumb',
			'type'	 => 'button_set',
			'title' => esc_html__('Enable Breadcrumbs', 'boo'),
			'options' => array(
				'on' => 'On',
				'off' => 'Off'
			)
		),

		array(
			'id' => 'title-bar-breadcrumb-style',
			'type'	 => 'select',
			'title' => esc_html__('Breadcrumb style', 'boo'),
			'options' => array(
				'' => 'Default',
				'parallelogram' => 'Parallelogram',
			),
			'required' => array(
				'title-bar-breadcrumb',
				'!=',
				'off'
			),
			'default' => 'off'
		),

		array(
			'id' => 'title-bar-content-style',
			'type'	 => 'select',
			'title' => esc_html__('Content style', 'boo'),
			'options' => array(
				'' => 'None',
				'split' => 'Split',
				'bottom' => 'Bottom',
				'bottom-bar' => 'Bottom Bar'
			),
			'required' => array(
				'title-bar-breadcrumb',
				'!=',
				'off'
			),
			'default' => 'off'
		),

		array(
			'id'       => 'title-bar-size',
			'type'     => 'select',
			'title'    => esc_html__( 'Title size', 'boo' ),
			'options' => array(
				'' => 'Default',
				'xxxsm' => 'xxxSmall',
				'xxsm' => 'xxSmall',
				'xsm' => 'xSmall',
				'sm' => 'Small',
				'md' => 'Medium',
				'lg' => 'Large',
				'xlg' => 'xLarge'
			),
			'default' => 'xlg'
		),

		array(
			'id'       => 'title-bar-height',
			'type'     => 'select',
			'title'    => esc_html__( 'Title bar height', 'boo' ),
			'options' => array(
				'' => 'Default',
				'full' => 'Fullheight',
				'xxxsm' => 'xxxSmall',
				'xxsm' => 'xxSmall',
				'xsm' => 'xSmall',
				'sm' => 'Small',
				'md' => 'Medium',
				'md2' => 'Medium2',
				'lg' => 'Large',
				'lg2' => 'Large2',
				'xlg' => 'xLarge',
				'xxlg' => 'xxLarge',
				'xxxlg' => 'xxxLarge'
			)
		),

		array(
			'id'       => 'title-bar-scheme',
			'type'     => 'select',
			'title'    => esc_html__( 'Color scheme', 'boo' ),
			'options' => array(
				'text-dark' => 'Dark',
				'text-white' => 'Light'
			),
			'default' => 'xlg'
		),

		array(
			'id'       => 'title-bar-align',
			'type'     => 'select',
			'title'    => esc_html__( 'Alignment', 'boo' ),
			'options' => array(
				'text-left' => 'Left',
				'text-center' => 'Center',
				'text-right' => 'Right'
			),
			'default' => 'xlg'
		),

		array(
			'id'       => 'title-background-type',
			'type'     => 'select',
			'title'    => esc_html__( 'Background Type', 'boo' ),
			'options' => array(
				'solid' => 'Solid',
				'gradient' => 'Gradient',
				'image' => 'Image'
			),
			'default' => 'image'
		),

		array(
			'id'=>'title-bar-bg',
			'type' => 'media',
			'url' => true,
			'title' => esc_html__('Background', 'boo'),
			'required' => array(
				'title-background-type',
				'equals',
				'image'
			)
		),

		array(
			'id'=>'title-bar-solid',
			'type' => 'color',
			'title' => esc_html__('Background', 'boo'),
			'required' => array(
				'title-background-type',
				'equals',
				'solid'
			)
		),

		array(
			'id'=>'title-bar-gradient',
			'type' => 'gradient',
			'title' => esc_html__('Background', 'boo'),
			'required' => array(
				'title-background-type',
				'equals',
				'gradient'
			)
		),

		array(
			'id'=>'title-bar-classes',
			'type' => 'text',
			'title' => esc_html__('Extra classes', 'boo')
		)
	)
);
