<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'ReduxFramework_gradient' ) ) {
    class ReduxFramework_gradient {

        /**
         * Field Constructor.
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since ReduxFramework 1.0.0
         */
        function __construct( $field = array(), $value = '', $parent ) {
            $this->parent = $parent;
            $this->field  = $field;
            $this->value  = $value;
        }

        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since ReduxFramework 1.0.0
         */
        function render() {

            if ( empty( $this->value ) && ! empty( $this->field['data'] ) && ! empty( $this->field['options'] ) ) {
                $this->value = $this->field['options'];
            }

            $qtip_title = isset( $this->field['text_hint']['title'] ) ? 'qtip-title="' . $this->field['text_hint']['title'] . '" ' : '';
            $qtip_text  = isset( $this->field['text_hint']['content'] ) ? 'qtip-content="' . $this->field['text_hint']['content'] . '" ' : '';

			$placeholder = ( isset( $this->field['placeholder'] ) && ! is_array( $this->field['placeholder'] ) ) ? ' placeholder="' . esc_attr( $this->field['placeholder'] ) . '" ' : '';
			echo '<input ' . $qtip_title . $qtip_text . 'type="text" id="' . $this->field['id'] . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '" ' . $placeholder . 'value="' . esc_attr( $this->value ) . '" class="hidden regular-text ' . $this->field['class'] . '" />';
			printf( '<input type="text" class="rella-gradient-css">', $this->field['id'] );
			printf( '<input type="text" class="hidden rella-gradient-bg">', $this->field['id'] );
			printf( '<div id="%1$s-gradient" class="rella-gradient"></div>', $this->field['id'] );
        }

		/**
         * Enqueue Function.
         * If this field requires any scripts, or css define this funct	ion and register/enqueue the scripts/css
         *
         * @since ReduxFramework 1.0.0
         */
        function enqueue() {

            if (!wp_script_is ( 'redux-field-gradient-js' )) {

				$url = trailingslashit( get_template_directory_uri() ) . 'rella/extensions/redux-gradient';

				wp_enqueue_style( 'ics-gradient', $url . '/ics-gradient-editor.min.css' );
				wp_enqueue_script( 'ics-gradient', $url . '/ics-gradient-editor.min.js' ,  array('jquery'), '1.0.0', true );

                wp_enqueue_script(
                    'redux-field-gradient-js',
                    $url . '/field_gradient.js',
                    array( 'jquery', 'redux-js' ),
                    time(),
                    true
                );
            }
		}
    }
}
