<?php
/*
 * Footer Section
*/

$this->sections[] = array(
	'title'  => esc_html__('Footer', 'boo'),
	'icon'   => 'el-icon-photo'
);

$this->sections[] = array(
	'title'  => esc_html__('Layout', 'boo'),
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'footer-enable-switch',
			'type'	 => 'button_set',
			'title' => esc_html__('Enable Footer', 'boo'),
			'subtitle' => esc_html__('If on, this layout part will be displayed.', 'boo'),
			'options' => array(
				'on' => 'On',
				'off' => 'Off'
			)
		),

		array(
 			'id'=>'footer-template',
 			'type' => 'select',
 			'title' => esc_html__('Template', 'boo'),
 			'subtitle'=> esc_html__('Choose template for footer.', 'boo'),
 			'data' => 'post',
			'args' => array( 'post_type' => 'rella-footer', 'posts_per_page' => -1 )
 		)
	)
);
