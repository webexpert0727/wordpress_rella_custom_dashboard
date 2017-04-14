( function ($) {

	var rellaImporter = function( id, options ) {
		console.log(id);
		console.log(options);
                var $this = this;
                
                // Id import
		$this.id = id; 
                // list type import
		$this.options = options; 
                

		this.init = function() {

                    var self = this,
					start = $('.rella-popup-getting-started'),
					actions = this.options.slice();

                    start.hide();
                    start.after( _.template( $('#tmpl-demo-import-modules').html() )( { modules: this.options } ) );

					$.ajax({
						url : ajaxurl,
						type : 'post',
						data : {
							action : 'redux_wbc_importer',
							demo_import_id: self.id,
							selections: options,
						},
						success : function( response ) {
							alert("Import completed!");
							var popup = $('#rella-popup');
							popup.remove();
						}
					});



		};
		
		this.init();

	};

	var rellaAdmin = {

		init: function() {
			this.initTabs();
			this.initDemo();
		},

		initDemo: function() {

			$('.rella-card-demo').on( 'click', '.rella-import-popup', function() {
				var id = $(this).data('demo-id'),
					demo = rella_demos[id];

				$(document.body).append( _.template( $('#tmpl-demo-popup').html() )(demo) );

				// Popup
				var popup = $('#rella-popup');

				// CLose
				popup.on('click','.rella-popup-close', function(){
					popup.remove();
				});

				popup.on('click','.agree', function(){

					var $this = $(this),
						parent = $this.parent();

					$this.is(':checked') ? parent.addClass('checked') : parent.removeClass('checked')

				})

				// Import Now
				popup.on('click','.rella-import-demo', function(){
					var btn = $(this);

					if( ! btn.prev().children('input').is(':checked') ) {
						var agreeBox = btn.prev();

						agreeBox.removeClass('rella-shake error');

						setTimeout(function() {
							agreeBox.addClass('rella-shake error');
						}, 50)

						return;
					}

					var options = [];

					btn.parent().find('.import-option-group .import-option :checked').each(function(){
						options.push( $(this).val() );
					});

					var importer = new rellaImporter( id, options );
				});

				return false;
			});
		},

		initTabs: function() {

			var navItem = $('.rella-nav-tabs').children('li'),
				tabPane = $('.rella-tab-pane').hide(),
				currentHashURL = document.location.hash;

			$('.rella-tab-pane.rella-tab-is-active').show();

			navItem.on('click', 'a[href^="#"]:not([href="#"])', function(e) {

				var $this = $(this),
					targetPane = $this.attr('href');

				if ( ! $(targetPane).length ) {
					return;
				}

				e.preventDefault();

				$(targetPane).show()
					.siblings().hide();

				$this.parent().addClass('is-active')
					.siblings().removeClass('is-active');
			});

			if ( currentHashURL === "" || ! navItem.children('a').filter("[href*='" + currentHashURL + "']").length ) return;

			$(currentHashURL).show().siblings().hide();

			navItem.children('a').filter("[href*='" + currentHashURL + "']").trigger("click");

			$('body, html').stop().animate({
				scrollTop: navItem.parents('.rella-nav-tabs').offset().top
			});

		}
	};

	jQuery(document).ready(function() {
		rellaAdmin.init();
	});

}) (jQuery);
