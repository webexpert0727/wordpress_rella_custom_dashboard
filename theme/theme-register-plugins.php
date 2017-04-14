<?php
/**
 * Themerella Theme Framework
 * Include the TGM_Plugin_Activation class and register the required plugins.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 */

rella()->load_library( 'class-tgm-plugin-activation' );

/**
 * Register the required plugins for this theme.
 */
add_action( 'tgmpa_register', '_s_register_required_plugins' );
function _s_register_required_plugins() {

	$assets = get_template_directory() . '/theme/plugins/';
	$images = get_template_directory_uri() . '/theme/plugins/images';

	$plugins = array(

		array(
			'name' 		=> esc_html__( 'Boo Addons', 'boo' ),
			'slug' 		=> 'boo-addons',
			'required' 	=> true,
            'source'    => 'boo-addons.zip',

			'rella_logo' => $images . '/extension-placeholder.jpg',
			'rella_author' => 'Themerella',
			'rella_description' => 'Boo core theme plugin.'
		),
        
        array(
			'name'      => esc_html__( 'Contact Form 7', 'boo' ),
			'slug'      => 'contact-form-7',
			'required'  => false,

			'rella_logo' => $images . '/extension-placeholder.jpg',
			'rella_author' => 'Takayuki Miyoshi',
			'rella_description' => 'Contact Form 7 can manage multiple contact forms, plus you can customize the form and the mail contents flexibly with simple markup.'
		),

		array(
			'name' 		=> esc_html__( 'Redux Framework', 'boo' ),
			'slug' 		=> 'redux-framework',
			'required' 	=> true,

			'rella_logo' => $images . '/extension-placeholder.jpg',
			'rella_author' => 'Takayuki Miyoshi',
			'rella_description' => 'Contact Form 7 can manage multiple contact forms, plus you can customize the form and the mail contents flexibly with simple markup.'
		)
	);

	$config = array(
		'id'           => '_s',
		'default_path' => $assets
	);

	tgmpa( $plugins, $config );
}
