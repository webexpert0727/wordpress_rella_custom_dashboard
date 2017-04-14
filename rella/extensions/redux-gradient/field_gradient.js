/*global redux_change, redux*/

/**
 * Typography
 * Dependencies:        google.com, jquery, select2
 * Feature added by:    Dovy Paukstys - http://simplerain.com/
 * Date:                06.14.2013
 *
 * Rewrite:             Kevin Provance (kprovance)
 * Date:                May 25, 2014
 */

(function( $ ) {
    "use strict";

    redux.field_objects = redux.field_objects || {};
    redux.field_objects.gradient = redux.field_objects.gradient || {};

	redux.field_objects.gradient.init = function( selector, skipCheck) {

		if ( !selector ) {
            selector = $( document ).find( ".redux-group-tab:visible" ).find( '.redux-container-gradient:visible' );
        }

		var $css = selector.find('.rella-gradient-css'),
			$bg = selector.find('.rella-gradient-bg'),
			$field = selector.find('.regular-text');

		var value = $field.val(),//= this.model.get('params')[param.param_name],
			startingGradient = '',
			startingBgProps = '',
			bg = '';

		if( 'undefined' !== typeof value && '' !== value ) {
			value = value.split('|');
			bg = '{"' + value[1].replace(/: /g, '":"').replace(/;/g,'","').slice(0,-2) + '}';

			startingGradient = value[0];
			startingBgProps = JSON.parse(bg);
		}

		var options = {
			interface: [ 'gradient', 'background' ],
			targetInputElement: $css,
			targetBgInputElement: $bg,
			startingGradient: startingGradient,
			startingBgProps: startingBgProps
		};

		selector.find('.rella-gradient').icsge(options);
		selector.find('.rella-gradient-css, .rella-gradient-bg').on( 'change', function(){

			var val = $css.val() + '|' + $bg.val();
			$field.val(val);
		});
	};

})( jQuery );
