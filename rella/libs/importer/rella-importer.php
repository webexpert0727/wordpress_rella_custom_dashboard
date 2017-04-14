<?php

/**
 * Rella Importer
 */
class Rella_Impoter extends Rella_Base {

	/**
	 * The name of the demo we're trying to import
	 *
	 * @access protected
	 * @var string
	 */
	protected $_demo;

	/**
	 * The name of the demo we're trying to import
	 *
	 * @access protected
	 * @var string
	 */
	protected $_demoData;

	/**
	 * The path where we'll be writing our files.
	 *
	 * @access protected
	 * @var string
	 */
	protected $_basedir;
        
        /**
         * Url link to demo folder
         * 
	 * @access protected
         * @var string
         */
        protected $_mediaLink;

        public function __construct() {
		$this->add_action( 'wp_ajax_rella_importer', 'handle' );
	}
        
        /*
         * Set base directory for demo
         * 
         * @return void
         */
        public function setBasedir() {
            $upload_dir    = wp_upload_dir();
            $basedir = wp_normalize_path( $upload_dir['basedir'] . '/rella-demo-data' );
            $this->_basedir = wp_normalize_path( $basedir . '/' . $this->demo . '_demo/' );
        }
        
        /*
         * Get base directory for demo
         * 
         * @return string
         */
        public function getBasedir() {
            if( empty($this->_basedir) ) {
                $this->setBasedir();
            }
            return $this->_basedir;
        }
        
        /**
         * Set Url link to demo folder
         * 
         * @return void
         */
        public function setMediaLink() { 
            $upload_dir = wp_upload_dir();
            $this->_mediaLink = $upload_dir['baseurl'] . '/rella-demo-data/' . $this->demo . '_demo/';
        }
        
        /**
         * Get Url link to demo folder
         * 
         * @return string $_mediaLink
         */
        public function getMediaLink() {            
            if( empty($this->_mediaLink) ) {
                $this->setMediaLink();
            }
            return $this->_mediaLink;
            
        }

	public function handle() {

		$handler = isset( $_REQUEST['handle'] ) ? $_REQUEST['handle'] : false;

		// Has Access
		if( !current_user_can( 'manage_options' ) ) {
			wp_send_json(array(
				'success' => false,
				'error' => esc_html__( 'Current user has no permission.', 'boo' )
			));
		}

		// Is permitted handler
		if( !in_array( $handler, array( 'content', 'yellow', 'widgets', 'sliders', 'media', 'settings' ) ) ) { // 
			wp_send_json(array(
				'success' => false,
				'error' => esc_html__( 'Not permitted.', 'boo' )
			));
		}

		// Include demo config
		$located = locate_template( 'theme/theme-demo-config.php' );
		include_once $located;
                
		// Get Demo ID
		$demo = ( ! isset( $_POST['demo_id'] ) || '' == trim( $_POST['demo_id'] ) ) ? 'main' : $_POST['demo_id'];
                
		if( !isset( $demos[$demo] ) ) {
			wp_send_json(array(
				'success' => false,
				'error' => esc_html__( 'Unable to find the selected demo.', 'boo' )
			));
		}
		else {
			$this->demo = $demo;
			$this->demo_data = $demos[$demo];
		}

		// Set PHP Variables
/*
		if ( function_exists( 'ini_get' ) ) {
			if ( 300 < ini_get( 'max_execution_time' ) ) {
				@ini_set( 'max_execution_time', 300 );
			}
			if ( 512 < intval( ini_get( 'memory_limit' ) ) ) {
				@ini_set( 'memory_limit', '512M' );
			}
		}
*/
                
                /*
                 * 
                 * REVIEW CODE
                 * 
                 * 

                
		// Attempt to create the necessary folders if they don't exist.
		$this->mkdir();

		// Get remote files and save them locally.
		$this->get_remote_files();
                
                */
                
                
		// Execute Handler
		if( method_exists( $this, $handler ) ) {
                        
                    $fileImport = null;
			try {
                            switch ($handler) {
                                case "content":
                                    $fileImport = "data.xml";
                                break;
                                case "settings":
                                    $fileImport = "theme-options.json";
                                break;
                                case "widgets":
                                    $fileImport = "widget-data.json";
                                break;
                                case "media":
                                    $fileImport = "media-files.json";
                                break;
                            }

                            $this->$handler($fileImport);
			}
			catch( Exception $e ) {
                            
				wp_send_json(array(
					'success' => false,
					'error' => esc_html__( 'Unexpected Error: ', 'boo' ) . $e->getMessage()
				));
			}
		}
	}

        
        /**
         * Import content method
         * 
         * @param type $file
         * @return json
         */
	public function content($file) {
            
		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true ); // We are loading importers.
		}

		if ( ! class_exists( 'WP_Importer' ) ) { // If main importer class doesn't exist.
			$wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			include $wp_importer;
		}

		if ( ! class_exists( 'WP_Import' ) ) { // If WP importer doesn't exist.
			$wp_import = get_template_directory() . '/rella/libs/importer/wordpress-importer.php';
			include $wp_import;
		}

		if ( !class_exists( 'WP_Importer' ) || !class_exists( 'WP_Import' ) ) {                    
                    return wp_send_json(array(
                        'success' => false,
                        'error' => esc_html__( 'Unable to load importer classes.', 'boo' )
                    ));
		}
                
                /*
                 * File path import
                 */
                $xml = wp_normalize_path( $this->getBasedir() . '/' . $file );
                
                if( file_exists( $xml ) ) {
	    
                        try {
                            $importer = new WP_Import();

                            $importer->fetch_attachments = true;

                            ob_start(); 
                            $importer->import( $xml );
                            ob_end_clean();
                            
                            return wp_send_json(array(
                                'success' => true,
                                'handle' => 'content'
                            ));

                        } catch (Exception $ex) {
                            return wp_send_json(array(
                                'success' => false,
                                'error' => sprintf(esc_html__('File %s not found.','boo'),$xml)
                            ));
                        }
                    
                }
	}
        
	public function yellow($file) {
            return wp_send_json(array(
                'success' => true,
                'handle' => 'yellow'
            ));
//            wp_send_json(array(
//                    'success' => true,
//                    'message' => esc_html__( 'No item mention for action.', 'boo' )
//            ));
	}

        
        /**
         * Import widget method
         * 
         * @global type $wp_filesystem
         * @param type $file
         * @return json
         */
	public function widgets($file) { 
                
                // load file
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }            
                
                $json = wp_normalize_path( $this->getBasedir() . '/' . $file); 
                
                if( file_exists( $json ) ) {

                    $widget_data_json = $wp_filesystem->get_contents($json);

                    $import_array = json_decode($widget_data_json, true);
                    
                } else {
                    return wp_send_json(array(
                        'success' => false,
                        'error' => esc_html__('Widget resource data not found.','boo')
                    ));
                }
		
		if (!is_array($import_array)) {
                    return wp_send_json(array(
                        'success' => false,
                        'error' => esc_html__('Widget resource data is empty.','boo')
                    ));
		}
		
		$sidebars_data = $import_array[0];
                
		$widget_data = $import_array[1];
                
		$current_sidebars = get_option( 'sidebars_widgets' );
		
		if (is_array($GLOBALS['wp_registered_sidebars'])) {
			foreach ($GLOBALS['wp_registered_sidebars'] as $key => $sidebar) {
				
				if (!isset($current_sidebars[$key])) {
					$current_sidebars[$key] = array();
				}
			}
		}
		
		//fix nav_menu widget IDs
		if (isset($widget_data['nav_menu'])) {
			
			$menus = wp_get_nav_menus(array('orderby' => 'name'));
			
			foreach ($widget_data['nav_menu'] as $widget_key => $widget_menu) {
				
				if (is_array($menus) && !is_wp_error($menus)) {
					foreach ($menus as $menu_key => $menu) {
						if (isset($widget_menu['title'])) {
							if ($widget_menu['title'] == $menu -> name) {
								$widget_data['nav_menu'][$widget_key]['nav_menu'] = $menu -> term_id;
							}
						}
					}
				}
				
			}
		}
		
		$new_widgets = array();

		foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :
			
			foreach ( $import_widgets as $import_widget ) :
				//if the sidebar exists
				if ( isset( $current_sidebars[$import_sidebar] ) ) :
					
					$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
					$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
					$current_widget_data = get_option( 'widget_' . $title );
					
					$new_widget_name =  $this->get_new_widget_name( $title, $index );
					
					$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

					if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
						while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
							$new_index++;
						}
					}
					$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
					if ( array_key_exists( $title, $new_widgets ) ) {
						$new_widgets[$title][$new_index] = $widget_data[$title][$index];
						$multiwidget = $new_widgets[$title]['_multiwidget'];
						unset( $new_widgets[$title]['_multiwidget'] );
						$new_widgets[$title]['_multiwidget'] = $multiwidget;
					} else {
						$current_widget_data[$new_index] = $widget_data[$title][$index];
						$current_multiwidget = $current_widget_data['_multiwidget'];
						$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
						$multiwidget = ($current_multiwidget != $new_multiwidget) ? $new_multiwidget : 1;
						unset( $current_widget_data['_multiwidget'] );
						$current_widget_data['_multiwidget'] = $multiwidget;
						$new_widgets[$title] = $current_widget_data;
					}

				endif;
			endforeach;
		endforeach;
		
		if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
			update_option( 'sidebars_widgets', $current_sidebars );
			
			foreach ( $new_widgets as $title => $content ) {
				$content = apply_filters( 'widget_data_import', $content, $title );
				update_option( 'widget_' . $title, $content );
			}
			return wp_send_json(array(
                            'success' => true,
                            'handle' => 'widgets'
                        ));
		}                
		
                return wp_send_json(array(
                    'success' => false,
                    'error' => esc_html__('Widget import not completed.','boo')
                ));
	}

	public function sliders($file) {
            return wp_send_json(array(
                'success' => true,
                'handle' => 'sliders'
            ));
	}
        
        
        /**
         * Import media method
         * 
         * @global type $wp_filesystem
         * @param type $file
         * @return json
         */
	public function media($file) {
            
                // load file
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }            
                
                $json = wp_normalize_path( $this->getBasedir() . '/' . $file); 
                
                if( file_exists( $json ) ) {

                    $media_data_json = $wp_filesystem->get_contents($json);

                    $import_array = json_decode($media_data_json, true);
                    
                } else {
                    return wp_send_json(array(
                        'success' => false,
                        'error' => esc_html__('Media resource data not found.','boo')
                    ));
                }
		
		if (!is_array($import_array)) {
                    return wp_send_json(array(
                        'success' => false,
                        'error' => esc_html__('Media resource data is empty.','boo')
                    ));
		}
                
                foreach($import_array as $item) {
                    $this->import_image($this->getMediaLink() . '/media-files/' . $item);
                }
                
                return wp_send_json(array(
                    'success' => true,
                    'handle' => 'media'
                ));
	}

        
	/**
	 *
	 * @param string $widget_name
	 * @param string $file
	 * @return json
	 */
	public function settings($file) {
            
                if (!class_exists('ReduxFramework')) {

                        return wp_send_json(array(
                            'success' => false,
                            'error' => sprintf(esc_html__('Please install Redux Framework Plugin & enable it.','boo'),$xml)
                        ));
                }

                // load ReduxFramework
                $redux = new ReduxFramework();
                $redux->args['opt_name'] = "prefix_opt_name";

                // load file
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }            
                $json = wp_normalize_path( $this->getBasedir() . '/' . $file);            
                $import_json = $wp_filesystem->get_contents($json);


                // prepare data import
                $data = json_decode($import_json, true);            
                $import_data = get_option($redux->args['opt_name']);
                $import_data['import'] = 'Import';
                $import_data['import_code'] = $import_json;

                if (!is_array($import_data)) {
                    return wp_send_json(array(
                        'success' => false,
                        'error' => esc_html__('Settings resource data incompatible for import.','boo')
                    ));
                }            
                $data = $redux->_validate_options( $import_data );


                // import remote media
                if (is_array($data) && count($data)) {

                        $basedir = $this->getBasedir();

                        foreach ($data as $key => $item) {
                                if (is_array($item)) {

                                        //upload image from url field
                                        if (isset($item['url']) && !empty($item['url'])) {

                                                //skip images already downloaded (it should rather not happen)
                                                if (strstr($item['url'], $basedir)) {
                                                        continue;
                                                }

                                                $id = $this->import_image($item['url']);
                                                if ($id !== false) {

                                                        $image = wp_get_attachment_image_src( $id, 'full' );

                                                        if (is_array($image) && !is_wp_error($image)) {

                                                                $data[$key]['url'] = $image[0];
                                                                $data[$key]['id'] = $id;
                                                                $data[$key]['height'] = $image[2];
                                                                $data[$key]['width'] = $image[1];

                                                                $thumb = wp_get_attachment_image_src( $id, 'thumbnail' );
                                                                if (is_array($thumb) && !is_wp_error($thumb)) {
                                                                        $data[$key]['thumbnail'] = $thumb[0];
                                                                }
                                                        }
                                                }
                                        }

                                        //upload image from background-image field
                                        if (isset($item['background-image']) && !empty($item['background-image'])) {

                                                //skip images already downloaded (it should rather not happen)
                                                if (strstr($item['background-image'], $basedir)) {
                                                        continue;
                                                }

                                                $id = $this->import_image($item['background-image']);
                                                if ($id !== false) {

                                                        $image = wp_get_attachment_image_src( $id, 'full' );
                                                        if (is_array($image) && !is_wp_error($image)) {
                                                                $data[$key]['background-image'] = $image[0];

                                                                $data[$key]['media'] = array();
                                                                $data[$key]['media']['id'] = $id;
                                                                $data[$key]['media']['height'] = $image[2];
                                                                $data[$key]['media']['width'] = $image[1];

                                                                $thumb = wp_get_attachment_image_src( $id, 'thumbnail' );
                                                                if (is_array($thumb) && !is_wp_error($thumb)) {
                                                                        $data[$key]['media']['thumbnail'] = $thumb[0];
                                                                }
                                                        }
                                                }
                                        }
                                }
                        }
                }


                // init import
                if ( ! empty( $data ) ) {
                        $redux->set_options( $data );

                        return wp_send_json(array(
                            'success' => true,
                            'handle' => 'settings'
                        ));
                } else {
                    return wp_send_json(array(
                        'success' => false,
                        'error' => esc_html__('Theme settings empty file.','boo')
                    ));
                }
            
	}
        
	
	/**
	 *
	 * @param string $widget_name
	 * @param string $widget_index
	 * @return string
	 */
	public static function get_new_widget_name( $widget_name, $widget_index ) {
            
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
                
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
                
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
                
		$new_widget_name = $widget_name . '-' . $widget_index;
                
		return $new_widget_name;
	}
        
	
	/**
	 * Import image to media library
	 * @param string $url
	 * @return boolean
	 */
	protected function import_image($url) {
		
		$tmp = download_url( $url );
		$file_array = array(
			'name' => basename( $url ),
			'tmp_name' => $tmp
		);

		// Check for download errors
		if ( is_wp_error( $tmp ) ) {
			@unlink( $file_array[ 'tmp_name' ] );
			return false;
		}

		$id = media_handle_sideload( $file_array, 0 );
		
		// Check for handle sideload errors.
		if ( is_wp_error( $id ) ) {
			@unlink( $file_array['tmp_name'] );
			return false;
		}
		return $id;
	}

	/**
	 * Create the necessary local folders if they don't already exist
	 *
	 * @access protected
	 */
	protected function mkdir() {

		if ( ! file_exists( $this->_basedir ) ) {
			wp_mkdir_p( $this->_basedir );
		}
		$demo_data_path = wp_normalize_path( $this->_basedir . '/' . $this->demo . '_demo' );
		if ( ! file_exists( $demo_data_path ) ) {
			wp_mkdir_p( $demo_data_path );
		}
	}

	/**
	 * Ping the remote server
	 * Get the demo data
	 * Save the data locally
	 *
	 * @access protected
	 */
	protected function get_remote_files() {

		$folder_path = wp_normalize_path( $this->_basedir . '/' . $this->demo . '_demo/' );

		if ( ! file_exists( $folder_path . 'content.zip' ) || DAY_IN_SECONDS < time() - filemtime( $folder_path . 'content.zip' ) ) {
			$response = rella_helper()->wp_get_http( $this->demo_data['zip_file'], $folder_path . 'content.zip' );
		}
		
		// Initialize the Wordpress filesystem.
		global $wp_filesystem;
		if ( ! defined( 'FS_CHMOD_DIR' ) ) {
			define( 'FS_CHMOD_DIR', ( 0755 & ~ umask() ) );
		}
		if ( ! defined( 'FS_CHMOD_FILE' ) ) {
			define( 'FS_CHMOD_FILE', ( 0644 & ~ umask() ) );
		}
		rella_helper()->init_filesystem();

		$unzipfile = unzip_file( $folder_path . 'content.zip', $folder_path );

		if ( $unzipfile ) {
			return true;
		}

		// Attempt to manually extract the zip.
		if ( class_exists( 'ZipArchive' ) ) {
			$zip = new ZipArchive;
			if ( true === $zip->open( $folder_path . 'content.zip' ) ) {
				$zip->extractTo( $folder_path );
				$zip->close();
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Log message
	 * @param string $message
	 * @param boolean $append
	 */
	public function log( $message, $append = true ) {
		$upload_dir = wp_upload_dir();
		if ( isset($upload_dir['baseurl'] ) ) {
			
			$data = '';
			if (!empty($message)) {
				$data = date("Y-m-d H:i:s").' - '.$message."\n";
			}
			pasific_write_file($upload_dir['basedir'].'/', 'importer.log', $data, $append); 
		}
	}
	
	/**
	 * Get Log content
	 * @return string
	 */
	public function get_log() {
		$upload_dir = wp_upload_dir();
		if (isset($upload_dir['baseurl'])) {
			
			if (file_exists($upload_dir['basedir'].'/importer.log')) {
				return pasific_read_file( $upload_dir['basedir'] . '/', 'importer.log');
			}
		}
		return '';
	}
	
}
new Rella_Impoter;
