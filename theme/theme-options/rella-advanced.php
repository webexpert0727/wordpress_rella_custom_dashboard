<?php
/*
 * Advanced theme options like social sites API Keys etc.
*/

$this->sections[] = array(
	'title' => esc_html__( 'Advanced', 'boo' ),
	'icon'   => 'el-icon-puzzle'
);

// Code Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Code Fields (Tracking etc.)', 'boo' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'          => 'google_analytics',
			'type'        => 'ace_editor',
			'title'       => esc_html__( 'Tracking Code', 'boo' ),
			'subtitle' => esc_html__( 'Paste your tracking code here. This will be added into the header template of your theme. Place code inside &lt;script&gt; tags.', 'boo' ),
			'mode' => 'html',
			'theme' => 'chrome',
			'options' => array( 'minLines' => 20, 'maxLines' => 60 )
		),

		array(
			'id'          => 'space_head',
			'type'        => 'ace_editor',
			'title'       => esc_html__( 'Space before &lt;/head&gt;', 'boo' ),
			'subtitle' => esc_html__( 'Only accepts javascript code wrapped with &lt;script&gt; tags and HTML markup that is valid inside the &lt;/head&gt; tag.', 'boo' ),
			'mode' => 'html',
			'theme' => 'chrome',
			'options' => array( 'minLines' => 20, 'maxLines' => 60 )
		),

		array(
			'id'          => 'space_body',
			'type'        => 'ace_editor',
			'title'       => esc_html__( 'Space before &lt;/body&gt;', 'boo' ),
			'subtitle' => esc_html__( 'Only accepts javascript code, wrapped with &lt;script&gt; tags and valid HTML markup inside the &lt;/body&gt; tag.', 'boo' ),
			'mode' => 'html',
			'theme' => 'chrome',
			'options' => array( 'minLines' => 20, 'maxLines' => 60 )
		)
	)
);

// WordPress Core Functionality
$this->sections[] = array(
	'title'  => esc_html__( 'Core', 'boo' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id'       => 'clear-static-files',
			'type'     => 'switch',
			'title'    => esc_html__( 'Clear Static Files Query String', 'boo' ),
			'subtitle' => esc_html__( 'If enabled qeury string variable "ver" will be removed from query string for JS and CSS files.', 'boo' ),
			'default'  => 0,
		)
	)
);

// Dynamic CSS
$this->sections[] = array(
	'title'  => esc_html__( 'Dynamic CSS', 'boo' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id'          => 'dynamic_css_compiler',
			'type'        => 'switch',
			'title'       => esc_html__( 'CSS Compiler', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to compile the dynamic CSS into a file. A separate file will be created for each of your pages & posts inside of the uploads/rella-styles folder.', 'boo' ),
			'default'     => '1',
		),

		array(
			'id'          => 'dynamic_css_db_caching',
			'type'        => 'switch',
			'title'       => esc_html__( 'Database Caching for Dynamic CSS', 'boo' ),
			'subtitle' => esc_html__( 'Turn on to enable caching the dynamic CSS in your database.', 'boo' ),
			'default'     => '0',
		),

		array(
			'id'          => 'cache_server_ip',
			'type'        => 'text',
			'title'       => esc_html__( 'Cache Server IP', 'boo' ),
			'subtitle' => esc_html__( 'For unique cases where you are using cloud flare and a cache server, ex: varnish cache. Enter your cache server IP to clear the theme options dynamic CSS cache. Consult with your server admin for help.', 'boo' ),
		),
	)
);
