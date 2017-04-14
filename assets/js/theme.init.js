/*!
* Themerella
*
* (c) Copyright themerella.com
*
* @version 1.0.0
* @author  Themerella
*/


(function($) {
    var Themerella = {
        init: function() {
            this.objectFitPolyfill();
        },
        objectFitPolyfill: function() {
            if (typeof objectFitImages !== typeof undefined) {
                objectFitImages();
            }
        }
    };
    $(document).ready(function() {
        Themerella.init();
        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function() {
            var flickel = $('.flickity-enabled');
            if (flickel.length) {
                flickel.flickity('resize');
            }
        });
        +function($) {
            'use strict';
            function transitionEnd() {
                var el = document.createElement('bootstrap');
                var transEndEventNames = {
                    WebkitTransition: 'webkitTransitionEnd',
                    MozTransition: 'transitionend',
                    OTransition: 'oTransitionEnd otransitionend',
                    transition: 'transitionend'
                };
                for (var name in transEndEventNames) {
                    if (el.style[name] !== undefined) {
                        return {
                            end: transEndEventNames[name]
                        };
                    }
                }
                return false;
            }
            $.fn.emulateTransitionEnd = function(duration) {
                var called = false;
                var $el = this;
                $(this).one('bsTransitionEnd', function() {
                    called = true;
                });
                var callback = function() {
                    if (!called) $($el).trigger($.support.transition.end);
                };
                setTimeout(callback, duration);
                return this;
            };
            $(function() {
                $.support.transition = transitionEnd();
                if (!$.support.transition) return;
                $.event.special.bsTransitionEnd = {
                    bindType: $.support.transition.end,
                    delegateType: $.support.transition.end,
                    handle: function(e) {
                        if ($(e.target).is(this)) return e.handleObj.handler.apply(this, arguments);
                    }
                };
            });
        }(jQuery);
    });
    var wooButtonUpdate = function() {
        var button = $('.woocommerce-cart .woocommerce input.update_cart');
        if (!button.length) {
            return;
        }
        if (button.attr('disabled') == 'disabled') {
            button.prop('disabled', false);
            var but = button.parent().find('button.input-generated-button');
            if (but.length) {
                but.prop('disabled', false);
            }
        }
    };
    $(document).on('spinnerAction', wooButtonUpdate);
    $(document).on('change input', 'div.woocommerce > form .cart_item :input', wooButtonUpdate);
    $(document).ajaxComplete(function() {
        if (typeof progressively !== typeof undefined && $('.progressive__img').length) {
            var enableProgressiveLoad = new RellaProgressiveAspectRatio();
            enableProgressiveLoad.init();
            progressively.render();
        }
    });
    $(window).on('load', function() {
        if ('vc_js' in window) {
            window.setTimeout(vc_waypoints, 500);
        }
    });
    $(window).on('resize', function() {
        $(document).RellaHeader().megamenuPositioning;
        $(document).RellaHeightToWidth();
        $(document).RellaMobileNav();
    });
})(jQuery);

(function($) {
    var instanceName = '__smoothMouseWheel';
    var SmoothMouseWheel = function(el, options) {
        return this.init(el, options);
    };
    SmoothMouseWheel.defaults = {};
    SmoothMouseWheel.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, SmoothMouseWheel.defaults, options);
            return this;
        },
        build: function() {
            var self = this, container, running = false, currentY = 0, targetY = 0, oldY = 0, maxScrollTop = 0, minScrollTop, direction, onRenderCallback = null, fricton = .9, vy = 0, stepAmt = 1, minMovement = .1, ts = .1;
            var updateScrollTarget = function(amt) {
                targetY += amt;
                vy += (targetY - oldY) * stepAmt;
                oldY = targetY;
            };
            var render = function() {
                if (vy < -minMovement || vy > minMovement) {
                    currentY = currentY + vy;
                    if (currentY > maxScrollTop) {
                        currentY = vy = 0;
                    } else if (currentY < minScrollTop) {
                        vy = 0;
                        currentY = minScrollTop;
                    }
                    container.scrollTop(-currentY);
                    vy *= fricton;
                    if (onRenderCallback) {
                        onRenderCallback();
                    }
                }
            };
            var animateLoop = function() {
                if (!running) return;
                requestAnimFrame(animateLoop);
                render();
            };
            var onWheel = function(e) {
                e.preventDefault();
                var evt = e.originalEvent;
                var delta = evt.detail ? evt.detail * -1 : evt.wheelDelta / 40;
                var dir = delta < 0 ? -1 : 1;
                if (dir != direction) {
                    vy = 0;
                    direction = dir;
                }
                currentY = -container.scrollTop();
                updateScrollTarget(delta);
            };
            window.requestAnimFrame = function() {
                return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function(callback) {
                    window.setTimeout(callback, 1e3 / 60);
                };
            }();
            var normalizeWheelDelta = function() {
                var distribution = [], done = null, scale = 30;
                return function(n) {
                    if (n == 0) return n;
                    if (done != null) return n * done;
                    var abs = Math.abs(n);
                    outer: do {
                        for (var i = 0; i < distribution.length; ++i) {
                            if (abs <= distribution[i]) {
                                distribution.splice(i, 0, abs);
                                break outer;
                            }
                        }
                        distribution.push(abs);
                    } while (false);
                    var factor = scale / distribution[Math.floor(distribution.length / 3)];
                    if (distribution.length == 500) done = factor;
                    return n * factor;
                };
            }();
            $.fn.smoothWheel = function() {
                var options = jQuery.extend({}, arguments[0]);
                return this.each(function(index, elm) {
                    if (!('ontouchstart' in window)) {
                        container = $(this);
                        container.bind("mousewheel", onWheel);
                        container.bind("DOMMouseScroll", onWheel);
                        targetY = oldY = container.scrollTop();
                        currentY = -targetY;
                        minScrollTop = container.get(0).clientHeight - container.get(0).scrollHeight;
                        if (options.onRender) {
                            onRenderCallback = options.onRender;
                        }
                        if (options.remove) {
                            log("122", "smoothWheel", "remove", "");
                            running = false;
                            container.unbind("mousewheel", onWheel);
                            container.unbind("DOMMouseScroll", onWheel);
                        } else if (!running) {
                            running = true;
                            animateLoop();
                        }
                    }
                });
            };
            $(document, '.modules-fullscreen .main-nav').smoothWheel();
            return this;
        }
    };
    $.fn.rellaSmoothMouseWheel = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new SmoothMouseWheel(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $("body.smooth-wheel-enabled").rellaSmoothMouseWheel();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__FooterFixed';
    var FooterFixed = function(el, options) {
        return this.init(el, options);
    };
    FooterFixed.defaults = {};
    FooterFixed.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, FooterFixed.defaults, options);
            return this;
        },
        build: function() {
            var element = this.el, mainContents = $('main#content'), footerHeight = element.outerHeight();
            element.addClass('is-fixed');
            mainContents.css({
                marginBottom: footerHeight
            });
        }
    };
    $.fn.RellaFooterFixed = function(settings) {
        return this.map(function() {
            var el = $(this);
            el.imagesLoaded(function() {
                if (el.data(instanceName)) {
                    return el.data(instanceName);
                } else {
                    var pluginOptions = el.data('plugin-options'), opts;
                    if (pluginOptions) {
                        opts = $.extend(true, {}, settings, pluginOptions);
                    }
                    return new FooterFixed(el, opts);
                }
            });
        });
    };
    $(document).ready(function() {
        $('footer[data-fixed]').RellaFooterFixed();
    });
    $(window).on('resize', function() {
        $('footer[data-fixed]').RellaFooterFixed();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__Hover3d';
    var Hover3d = function(el, options) {
        return this.init(el, options);
    };
    Hover3d.defaults = {};
    Hover3d.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, Hover3d.defaults, options);
            return this;
        },
        build: function() {
            'use strict';
            window.ATicon = {};
            window.ATicon.getInstance = function(jQueryDOMElement) {
                jQueryDOMElement.imagesLoaded(function() {
                    if (jQueryDOMElement === null) throw new Error("Passed in element doesn't exist in DOM");
                    return new ATicon(jQueryDOMElement);
                });
            };
            function ATicon(jQueryDomElement) {
                this.$icon = jQueryDomElement;
                if (!this.$icon.length) {
                    return;
                }
                this.perspectiveAmount = 1200;
                this.offset = this.$icon.offset();
                this.width = this.$icon.width();
                this.height = this.$icon.height();
                this.maxRotation = 8;
                this.maxTranslation = 4;
                var that = this;
                this.$icon.on('mousemove', function(e) {
                    that.events.hover.call(that, e);
                }).on('mouseleave', function(e) {
                    that.events.leave.call(that, e);
                });
            }
            ATicon.prototype = {
                appleTvAnimate: function(element, config) {
                    var rotate = "rotateX(" + config.xRotationPercentage * config.maxRotationX + "deg)" + " rotateY(" + config.yRotationPercentage * config.maxRotationY + "deg)";
                    var translate = " translate3d(" + config.xTranslationPercentage * config.maxTranslationX + "px," + config.yTranslationPercentage * config.maxTranslationY + "px, 0px)";
                    TweenMax.to(element, .3, {
                        rotationX: -config.xRotationPercentage * config.maxRotationX,
                        rotationY: -config.yRotationPercentage * config.maxRotationY,
                        x: -config.xTranslationPercentage * config.maxTranslationX,
                        y: -config.yTranslationPercentage * config.maxTranslationY,
                        ease: Linear.easeNone,
                        perspective: this.perspectiveAmount
                    });
                },
                calculateRotationPercentage: function(offset, dimension) {
                    return -2 / dimension * offset + 1;
                },
                calculateTranslationPercentage: function(offset, dimension) {
                    return -2 / dimension * offset + 1;
                }
            };
            ATicon.prototype.events = {
                hover: function(e) {
                    var that = this;
                    var mouseOffsetInside = {
                        x: e.pageX - this.offset.left,
                        y: e.pageY - this.offset.top
                    };
                    var xRotationPercentage = this.calculateRotationPercentage(mouseOffsetInside.y, this.height);
                    var yRotationPercentage = this.calculateRotationPercentage(mouseOffsetInside.x, this.width) * -1;
                    var xTranslationPercentage = this.calculateTranslationPercentage(mouseOffsetInside.x, this.width);
                    var yTranslationPercentage = this.calculateTranslationPercentage(mouseOffsetInside.y, this.height);
                    this.$icon.find('[data-stacking-factor]').each(function(index, element) {
                        var stackingFactor = $(element).attr('data-stacking-factor');
                        that.appleTvAnimate($(element), {
                            maxTranslationX: that.maxTranslation * stackingFactor,
                            maxTranslationY: that.maxTranslation * stackingFactor,
                            maxRotationX: that.maxRotation * stackingFactor,
                            maxRotationY: that.maxRotation * stackingFactor,
                            xRotationPercentage: xRotationPercentage,
                            yRotationPercentage: yRotationPercentage,
                            xTranslationPercentage: xTranslationPercentage,
                            yTranslationPercentage: yTranslationPercentage
                        });
                    });
                },
                leave: function(e) {
                    var that = this;
                    var mouseOffsetInside = {
                        x: e.pageX - this.offset.left,
                        y: e.pageY - this.offset.top
                    };
                    var xRotationPercentage = this.calculateRotationPercentage(mouseOffsetInside.y, this.height);
                    var yRotationPercentage = this.calculateRotationPercentage(mouseOffsetInside.x, this.width) * -1;
                    var xTranslationPercentage = this.calculateTranslationPercentage(mouseOffsetInside.x, this.width);
                    var yTranslationPercentage = this.calculateTranslationPercentage(mouseOffsetInside.y, this.height);
                    this.$icon.find('[data-stacking-factor]').each(function(index, element) {
                        that.appleTvAnimate($(element), {
                            maxTranslationX: 0,
                            maxTranslationY: 0,
                            maxRotationX: 0,
                            maxRotationY: 0,
                            xRotationPercentage: 0,
                            yRotationPercentage: 0,
                            xTranslationPercentage: 0,
                            yTranslationPercentage: 0
                        });
                    });
                }
            };
        }
    };
    $.fn.RellaHover3d = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-hover3d-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Hover3d(el, opts);
            }
        });
    };
    $(window).on('load resize', function() {
        setTimeout(function() {
            $(document).RellaHover3d();
            $('[data-hover3d]').each(function() {
                ATicon.getInstance($(this));
            });
        }, 500);
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__ProgressiveLoad';
    var ProgressiveLoad = function(el, options) {
        return this.init(el, options);
    };
    ProgressiveLoad.defaults = {};
    ProgressiveLoad.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, ProgressiveLoad.defaults, options);
            return this;
        },
        build: function() {
            var progressiveImage = this.el;
            if (typeof progressively === typeof undefined) {
                return;
            }
            setAspectRatio();
            vcCares();
            function setAspectRatio(el) {
                progressiveImage.each(function() {
                    var $this = $(this), elementRowParent = $this.closest('.row');
                    $this.imagesLoaded(function() {
                        if ($this.closest('[data-mh]').length) {
                            $.fn.matchHeight._update();
                        }
                    });
                    if (typeof elementRowParent !== typeof undefined || elementRowParent !== null) {
                        elementRowParent.imagesLoaded(function() {
                            if (elementRowParent.data('isotope')) {
                                elementRowParent.isotope('layout');
                            }
                            if ($('[data-mh]').length) {
                                $.fn.matchHeight._afterUpdate = function(event, groups) {
                                    if (elementRowParent.data('isotope')) {
                                        elementRowParent.isotope('layout');
                                    }
                                };
                            }
                        });
                    }
                });
            }
            function vcCares() {
                $(progressiveImage).each(function() {
                    var $this = $(this), vcParent = $this.closest('.wpb_single_image').addClass('wpb_single_image_progressive');
                    if (vcParent.length) {
                        if (vcParent.is(':only-child') || vcParent.width() === vcParent.parent().width()) {
                            vcParent.find('.vc_figure').css('display', 'block');
                            vcParent.find('.vc_single_image-wrapper').css('display', 'block');
                            $(this).addClass('width-auto');
                            setAspectRatio();
                        }
                    }
                });
            }
            var progressive = progressively.init({
                throttle: 50,
                delay: 30,
                onLoad: function(el) {
                    $('.portfolio-item.hover-blur').RellaEnableStackBlur();
                    $(el).parent().addClass('progressive-image--is-loaded');
                    if ($(el).closest('.portfolio-main-image').length) {
                        $(el).closest('.portfolio-main-image').addClass('progressive-image--is-loaded');
                    }
                    if ($(el).closest('.carousel-items').length && $(el).closest('.carousel-items').data('flickity')) {
                        $(el).closest('.carousel-items').flickity('resize');
                    }
                }
            });
            $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function() {
                if (typeof progressively !== typeof undefined) {
                    progressively.render();
                }
            });
        }
    };
    $.fn.RellaProgressiveLoad = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new ProgressiveLoad(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('.progressive__img').RellaProgressiveLoad();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__FullWidth';
    var FullWidth = function(el, options) {
        return this.init(el, options);
    };
    FullWidth.defaults = {};
    FullWidth.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, FullWidth.defaults, options);
            return this;
        },
        build: function() {
            var element = this.el;
            element.each(function() {
                var $this = $(this);
                $this.css({
                    width: '',
                    'margin-left': ''
                });
                $this.css({
                    width: $(window).width(),
                    'margin-left': -$this.offset().left + 'px'
                });
            });
        }
    };
    $.fn.RellaFullWidth = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new FullWidth(el, opts);
            }
        });
    };
    $(document).ready(function() {});
    $(window).on('resize', function() {});
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__MobileNav';
    var MobileNav = function(el, options) {
        return this.init(el, options);
    };
    MobileNav.defaults = {};
    MobileNav.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, MobileNav.defaults, options);
            return this;
        },
        build: function() {
            var mainHeader = $('.main-header'), mainNav = mainHeader.find('.main-nav'), submenu = mainNav.find('.nav-item-children');
            if ($(window).width() <= 991) {
                mainHeader.addClass('mobile').removeClass('desktop');
                submenu.parent().off('mouseenter mouseleave');
                submenu.css({
                    overflow: '',
                    visibility: '',
                    opacity: '',
                    height: '',
                    transform: ''
                });
            } else {
                mainHeader.removeClass('mobile').addClass('desktop');
            }
        }
    };
    $.fn.RellaMobileNav = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new MobileNav(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaMobileNav();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__Progressbar';
    var Progressbar = function(el, options) {
        return this.init(el, options);
    };
    Progressbar.defaults = {};
    Progressbar.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, Progressbar.defaults, options);
            return this;
        },
        build: function() {
            this.progressbarCircle();
        },
        progressbarCircle: function() {
            var el = $('.progressbar-circle');
            if (!el.length) {
                return;
            }
            el.each(function() {
                var $this = $(this), inner = $this.find('.progressbar-inner'), percentage = $this.attr('data-percentage') + '%';
                var progress = inner.circleProgress({
                    value: 0,
                    size: $this.parent().width() - 20,
                    thickness: $this.data('thickness'),
                    startAngle: Math.PI * 3.501411705537642,
                    emptyFill: $this.data('empty-fill'),
                    animation: {
                        duration: 1100
                    },
                    reverse: $this.data('reverse') === true ? true : false,
                    fill: {
                        gradient: [ $this.data('start-color'), $this.data('end-color') ],
                        gradientAngle: Math.PI * 3.501411705537642
                    }
                });
                progress.on('circle-animation-progress', function() {});
                if ($.isFunction($.fn.appear)) {
                    $this.appear(function() {
                        inner.circleProgress({
                            value: parseInt(percentage, 10) / 100
                        });
                    });
                } else {
                    inner.circleProgress({
                        value: parseInt(percentage, 10) / 100
                    });
                    console.warn('jQuery appear is needed');
                }
            });
            $(window).on('resize', function() {
                el.find('.progressbar-inner').circleProgress('redraw');
            });
        }
    };
    $.fn.RellaProgressbar = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Progressbar(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaProgressbar();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__Header';
    var Header = function(el, options) {
        return this.init(el, options);
    };
    Header.defaults = {};
    Header.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, Header.defaults, options);
            return this;
        },
        build: function() {
            this.resizeWindow();
            this.headerModules();
            this.megamenuPositioning();
            this.desktopHeaderSubmenu();
            this.mobileHeaderSubmenu();
            this.headerSticky();
        },
        headerModules: function() {
            var mainHeader = $('.main-header'), mainBar = mainHeader.find('.main-bar'), secondaryBar = mainHeader.find('.secondary-bar'), module = mainHeader.find('.header-module'), itemsTimeline = new TimelineMax({
                callbackScope: module
            }), timelineTotalDuration = 0, navToggle = mainHeader.find('.navbar-toggle').not('.module-toggle'), navTopBar = $('<div class="nav-top-bar"></div>');
            if (navToggle.length) {
                navToggle.each(function() {
                    var $this = $(this).wrap('<div class="header-module module-nav-trigger hidden-lg hidden-md"></div>'), toggleParent = $this.parents('.main-bar') || $this.parents('.secondary-bar');
                    if (!toggleParent.children('.header-module.module-nav-trigger.hidden-lg.hidden-md').length) {
                        $this.parent().appendTo(toggleParent);
                    }
                    if (!toggleParent.find('.navbar-collapse').children('.header-module.module-nav-trigger.hidden-lg.hidden-md').length) {
                        var navToggleClone = $this.clone('true');
                        navTopBar.append(navToggleClone).prependTo(toggleParent.find('.navbar-collapse'));
                    }
                });
            }
            mainBar.each(function() {
                var $this = $(this), headerModule = $this.find('.header-module');
                $this.find('.navbar-header').prependTo($this);
            });
            module.each(function() {
                var $this = $(this), moduleContainer = $this.find('.module-container'), moduleTrigger = $this.find('.module-trigger'), dataTarget = moduleTrigger.data('target');
                if ($('.masonry-filters').length && $this.find('.masonry-filters-clone').length) {
                    $('.masonry-filters').clone('true').appendTo($this.find('.masonry-filters-clone'));
                }
                if (typeof dataTarget === typeof undefined || dataTarget === null) {
                    $this.on('mouseenter', '.module-trigger', function() {
                        moduleContainer.stop().slideDown(300);
                        $this.addClass('module-container-is-showing');
                        if ($this.find('input[type="search"]').length) {
                            setTimeout(function() {
                                $this.find('input[type="search"]').focus();
                            }, 250);
                        }
                        if (typeof progressively !== typeof undefined && $(this).find('.progressive__img').length) {
                            var enableProgressiveLoad = new RellaProgressiveAspectRatio();
                            enableProgressiveLoad.init();
                            progressively.render();
                        }
                    }).on('mouseleave', function() {
                        moduleContainer.stop().slideUp(300);
                        $this.removeClass('module-container-is-showing');
                        if ($this.find('input[type="search"]').length) {
                            setTimeout(function() {
                                $this.find('input[type="search"]').blur();
                            }, 150);
                        }
                    });
                } else {
                    moduleTrigger.off('click');
                    moduleTrigger.on('click', function(event) {
                        var dataTarget = $(this).data('target');
                        event.preventDefault();
                        if ($this.closest('.module-search-form').length) {
                            var moduleClassList = $this.closest('.module-search-form').attr('class').split(' '), classesToBody = [ 'search-module-is-showing' ];
                            for (var i = 0; i < moduleClassList.length; i++) {
                                if (moduleClassList[i].match('style-')) classesToBody.push('search-module-' + moduleClassList[i]);
                            }
                            $('body').addClass(classesToBody.join(' '));
                            $this.find('input[type="search"]').on('keyup', function() {
                                if ($this.find('input[type="search"]').val() != '') {
                                    $this.addClass('input-filled');
                                } else {
                                    $this.removeClass('input-filled');
                                }
                            });
                        }
                        if (!$this.closest('.style-ghost').length) {
                            $(dataTarget).toggleClass('is-active');
                            $('[data-target="' + dataTarget + '"]').parent('.header-module').toggleClass('module-container-is-showing');
                            if ($('.modules-fullscreen').has(this).length) {
                                $('body').toggleClass('overflow-hidden');
                            }
                            if ($this.find('input[type="search"]').length && $this.closest('.module-container-is-showing').length) {
                                setTimeout(function() {
                                    $this.find('input[type="search"]').focus();
                                }, 250);
                            }
                        } else {
                            var siblingModules = $this.siblings('.header-module'), searchSiblings = [], selectors = [];
                            if ($this.siblings('.navbar-collapse').find('.main-nav').children('li').length) {
                                searchSiblings.push($this.siblings('.navbar-collapse').find('.main-nav').children());
                            }
                            if ($this.siblings('.navbar-brand').length) {
                                $this.find('.search-form').css({
                                    marginLeft: $this.siblings('.navbar-brand').outerWidth()
                                });
                            }
                            siblingModules.each(function() {
                                var $this = $(this);
                                if ($this.find('li').length) {
                                    searchSiblings.push($this.find('li'));
                                } else {
                                    searchSiblings.push($this);
                                }
                            });
                            $.each(searchSiblings, function(i, sibling) {
                                $.each(sibling, function(i, selector) {
                                    selectors.push(selector);
                                });
                            });
                            itemsTimeline.staggerTo($(selectors).get().reverse(), .3, {
                                scale: .5,
                                opacity: 0,
                                ease: Power3.easeIn
                            }, .04);
                            timelineTotalDuration = timelineTotalDuration == 0 ? itemsTimeline.duration() : timelineTotalDuration;
                            itemsTimeline.pause();
                            if (itemsTimeline.progress() < 1) {
                                itemsTimeline.play();
                                setTimeout(function() {
                                    $this.addClass('module-container-is-showing');
                                }, timelineTotalDuration * 700);
                                setTimeout(function() {
                                    $this.find('input[type="search"]').focus();
                                }, timelineTotalDuration * 1e3);
                            }
                            $this.find('.module-container').find('.module-trigger').on('click', function() {
                                if (itemsTimeline.progress() > 0 && itemsTimeline.reversed() === false) {
                                    itemsTimeline.seek(timelineTotalDuration).reverse();
                                }
                            });
                        }
                    });
                    if (!$(dataTarget).children('.module-nav-trigger').length && $this.is('.module-nav-trigger')) {
                        $this.clone('true').appendTo(dataTarget);
                    }
                    if ($this.siblings('.header-container').length) {
                        $this.siblings('.header-container').appendTo(dataTarget);
                    }
                    $this.find('.module-container').find('.module-trigger').off('click');
                    $this.find('.module-container').find('.module-trigger').on('click', function() {
                        $this.removeClass('module-container-is-showing');
                        $this.find('input[type="search"]').blur();
                        $('body').removeClass('search-module-is-showing');
                    });
                }
            });
            function closeAllModules(event) {
                module.find('.module-container').stop().slideUp(300);
                module.removeClass('module-container-is-showing');
                if (module.find('input[type="search"]').length) {
                    setTimeout(function() {
                        module.find('input[type="search"]').blur();
                    }, 150);
                }
                module.find('.is-active').removeClass('is-active');
                $('body').removeClass('search-module-is-showing');
                module.not('.style-ghost').removeClass('module-container-is-showing is-active');
                module.find('.module-container-is-showing').removeClass('module-container-is-showing');
                module.find('input[type="search"]').blur();
                $('.navbar-collapse').removeClass('is-active');
                $('.module-nav-trigger').removeClass('dl-active');
                if (itemsTimeline.progress() > 0 && itemsTimeline.reversed() === false) {
                    $('.header-module.style-ghost').removeClass('module-container-is-showing');
                    itemsTimeline.seek(timelineTotalDuration).reverse();
                }
            }
            function closeMobileNav(event) {
                $('.navbar-collapse').attr('aria-expanded', 'false').addClass('collapsing').removeClass('in');
                navToggle.attr('aria-expanded', 'false').addClass('collapsed');
            }
            $(document).on('click', function(e) {
                var target = $(e.target);
                if (!module.is(target) && !module.has(target).length && !target.has('.modules-fullscreen').length || target.parents().is('.module-trigger-inner')) {
                    closeAllModules(e);
                }
                if (!navToggle.is(target) && !navToggle.parent().is(target) && !$('.navbar-collapse').is(target) && !$('.navbar-collapse').has(target).length && $('.navbar-collapse').hasClass('in')) {
                    $('.navbar-toggle', '.module-nav-trigger').trigger('click');
                }
            });
            $(document).on('keyup', function(e) {
                if (e.keyCode == 27) {
                    closeAllModules(e);
                }
            });
        },
        megamenuPositioning: function() {
            var el = $('.megamenu');
            el.each(function() {
                var liParent = $(this);
                if (liParent.parents('.container').length) {
                    return;
                }
                var megamenu = liParent.children('.nav-item-children'), parentPos = liParent.offset().left, megamenuPos = parentPos - megamenu.outerWidth() / 2;
                if (megamenuPos < 0) {
                    megamenuPos = 0;
                }
                megamenu.css({
                    left: '',
                    right: ''
                });
                megamenu.css('left', megamenuPos);
                if (megamenuPos + megamenu.outerWidth() >= $(window).width()) {
                    megamenu.css({
                        left: 'auto',
                        right: 15
                    });
                } else if (parentPos <= 0) {
                    megamenu.css({
                        left: 15,
                        right: 'auto'
                    });
                }
                if (megamenu.offset().left <= 0) {
                    megamenu.css({
                        left: 15
                    });
                }
                megamenu.hide();
            });
        },
        desktopHeaderSubmenu: function() {
            var mainHeader = $('.main-header'), mainBarContainer = mainHeader.find('.main-bar-container'), mainNav = mainHeader.find('.main-nav'), submenu = mainNav.find('.nav-item-children'), megamenuParent = mainNav.find('.megamenu');
            mainBarContainer.each(function() {
                var $this = $(this);
                if ($this.hasClass('modules-fullscreen')) {
                    $('.modules-fullscreen').find('.main-nav').dlmenu({
                        animationClasses: {
                            classin: 'dl-animate-in-2',
                            classout: 'dl-animate-out-2'
                        }
                    });
                    if (!$('.modules-fullscreen').find('.main-nav').parent('.main-nav-container').length) {
                        $('.modules-fullscreen').find('.main-nav').wrap('<div class="main-nav-container"></div>');
                    }
                }
                if ($this.hasClass('modules-fullscreen-alt')) {
                    $this.find('.navbar-collapse').children().wrapAll('<div class="container"></div>');
                }
            });
            if (mainHeader.hasClass('mobile') || mainBarContainer.hasClass('modules-fullscreen')) {
                return;
            }
            submenu.each(function() {
                var $this = $(this), subParent = $this.parent();
                $this.hide();
                subParent.on('mouseenter', function() {
                    var mainHeader = $('.main-header');
                    if (mainHeader.hasClass("desktop")) {
                        var $liParent = $(this), navChild = $liParent.children('.nav-item-children');
                        if (navChild.length) {
                            navChild.css({
                                visibility: 'visible',
                                opacity: 1
                            });
                            $liParent.addClass('submenu-is-showing');
                            navChild.stop().fadeIn(200);
                        }
                    }
                    if (typeof progressively !== typeof undefined && $(this).find('.progressive__img').length) {
                        var enableProgressiveLoad = new RellaProgressiveAspectRatio();
                        enableProgressiveLoad.init();
                        progressively.render();
                    }
                }).on('mouseleave', function() {
                    var mainHeader = $('.main-header');
                    if (mainHeader.hasClass("desktop")) {
                        var $liParent = $(this), navChild = $liParent.children('.nav-item-children');
                        if (navChild.length) {
                            $liParent.removeClass('submenu-is-showing');
                            navChild.stop().fadeOut(100);
                        }
                    }
                });
            });
        },
        responsiveMenu: function(status) {
            var self = this;
            mainHeader = $(".main-header"), mainNav = mainHeader.find('.main-nav'), submenu = mainNav.find('.nav-item-children');
            if (status) {
                submenu.each(function() {
                    $(this).removeAttr("style");
                });
            } else {
                submenu.each(function() {});
            }
        },
        resizeWindow: function(status) {
            var mainHeader = $('.main-header'), windowWidth = $(window).width(), self = this;
            if (windowWidth > 991) {
                mainHeader.addClass("desktop");
                mainHeader.removeClass("mobile");
                self.responsiveMenu(false);
            } else {
                mainHeader.removeClass("desktop");
                mainHeader.addClass("mobile");
                self.responsiveMenu(true);
            }
            $(window).resize(function() {
                windowWidth = $(window).width();
                if (windowWidth > 991) {
                    mainHeader.addClass("desktop");
                    mainHeader.removeClass("mobile");
                    self.responsiveMenu(false);
                } else {
                    mainHeader.removeClass("desktop");
                    mainHeader.addClass("mobile");
                    self.responsiveMenu(true);
                }
                $('.megamenu .nav-item-children', mainHeader).css({
                    display: 'block',
                    visibility: 'hidden',
                    opacity: 0
                });
                self.megamenuPositioning();
            });
        },
        mobileHeaderSubmenu: function() {
            var mainNav = $('.main-header.mobile').find('.main-nav'), submenu = mainNav.find('.nav-item-children');
            $('body').on('click', '.main-header.mobile .main-nav li > a', function(e) {
                if (!$(this).siblings('.nav-item-children').length) {
                    return;
                }
                e.preventDefault();
                var submenu = $(this).siblings('.nav-item-children');
                submenu.stop().slideToggle();
            });
        },
        headerSticky: function() {
            var el = $('[data-sticky]');
            if (!el.length || typeof $.fn.headroom !== 'function') {
                return;
            }
            el.each(function() {
                var $this = $(this), offsetEl = $($this.data('sticky-offset')), offsetElOffsetTop = 0, offsetElHeight = 0, elementHeight = 0, elementOffsetTop = 0, newClassNames, prevClassNames;
                var getClassames = function(element) {
                    return element.attr('class');
                };
                var switchClasses = function(searchIn, searchFor, targetClassname) {
                    if (searchIn.search(searchFor) >= 0) {
                        $this.addClass(targetClassname);
                    } else {
                        $this.removeClass(targetClassname);
                    }
                };
                if (offsetEl.length && offsetEl.is(':visible')) {
                    offsetEl.each(function() {
                        var $this = $(this);
                        $this.imagesLoaded(function() {
                            offsetElHeight += $this.outerHeight();
                            offsetElOffsetTop += $this.offset().top;
                        });
                    });
                } else {
                    offsetElHeight = 0;
                }
                $this.imagesLoaded(function() {
                    elementHeight = parseInt($this.outerHeight(), 10);
                    elementOffsetTop = $this.is('[data-only-visible-onsticky]') ? $this.parent().outerHeight() : $this.position().top;
                    $this.parent().css('margin-bottom', elementHeight);
                    $this.css({
                        top: elementOffsetTop
                    });
                    $this.headroom({
                        tolerance: 10,
                        offset: $this.is('[data-only-visible-onsticky]') ? elementOffsetTop : elementOffsetTop + elementHeight,
                        onPin: function() {
                            $this.css({
                                top: ''
                            });
                            prevClassNames = newClassNames;
                            newClassNames = getClassames($this);
                            switchClasses(prevClassNames, 'headroom--top', 'pinned-from-top');
                        },
                        onUnpin: function() {
                            $this.css({
                                top: ''
                            });
                            prevClassNames = newClassNames;
                            newClassNames = getClassames($this);
                            switchClasses(prevClassNames, 'headroom--top', 'pinned-from-top');
                            $this.find('.is-active').removeClass('is-active');
                            $this.find('.module-container-is-showing').not('.style-ghost, .style-fullscreen').removeClass('module-container-is-showing');
                            $('body').not('.search-module-style-ghost, .search-module-style-fullscreen').removeClass('search-module-is-showing');
                        },
                        onNotTop: function() {
                            $this.css({
                                top: ''
                            });
                        },
                        onTop: function() {
                            $this.css({
                                top: elementOffsetTop
                            });
                            prevClassNames = newClassNames;
                            newClassNames = getClassames($this);
                        }
                    });
                    newClassNames = getClassames($this);
                });
            });
        }
    };
    $.fn.RellaHeader = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Header(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaHeader();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__FullHeight';
    var FullHeight = function(el, options) {
        return this.init(el, options);
    };
    FullHeight.defaults = {};
    FullHeight.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, FullHeight.defaults, options);
            return this;
        },
        build: function() {
            var fullheighElement = this.el;
            if (!fullheighElement.length) {
                return;
            }
            var windowHeight = $(window).height(), hstr = '';
            fullheighElement.each(function() {
                var $this = $(this), pt = parseInt($this.css('padding-top'), 10), pb = parseInt($this.css('padding-bottom'), 10);
                $this.height('');
                hstr = windowHeight - pt - pb + 'px !important';
                $this.attr('style', function(i, s) {
                    if (typeof s !== typeof undefined) {
                        return s + ';' + 'height: ' + hstr;
                    } else {
                        return 'height: ' + hstr;
                    }
                });
                if ($('body').hasClass('framed')) {
                    var frameHeight = parseInt($('body').css('margin-top'), 10) * 2;
                    $this.height('');
                    hstr = windowHeight - frameHeight - pt - pb + 'px !important';
                    $this.attr('style', function(i, s) {
                        if (typeof s !== typeof undefined) {
                            return s + ';' + 'height: ' + hstr;
                        } else {
                            return 'height: ' + hstr;
                        }
                    });
                }
            });
            if ($('.modules-fullscreen').length) {
                $('.modules-fullscreen').find('.main-nav').mCustomScrollbar('update');
                $('.modules-fullscreen').find('.main-nav').mCustomScrollbar('scrollTo', 'top');
            }
        }
    };
    $.fn.RellaFullHeight = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new FullHeight(el, opts);
            }
        });
    };
    $(document).ready(function() {});
    $(window).resize(function() {});
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__EnableJqueryUI';
    var EnableJqueryUI = function(el, options) {
        return this.init(el, options);
    };
    EnableJqueryUI.defaults = {};
    EnableJqueryUI.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build().enableRangeSlider();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, EnableJqueryUI.defaults, options);
            return this;
        },
        build: function() {
            if ($('.select-dropdown').length) {
                $('.select-dropdown').selectmenu();
            }
            if ($('.timepicker').length) {
                $('.timepicker').timepicker();
            }
            if ($('.datepicker').length) {
                $('.datepicker').datepicker();
            }
            if ($('.spinner').length) {
                $('.spinner').spinner({
                    spin: function() {
                        $(document).trigger('spinnerAction');
                    }
                });
            }
            return this;
        },
        enableRangeSlider: function() {
            var element = $('.rangeslider');
            if (!element.length || !$.isFunction(slider)) {
                return;
            }
            element.each(function() {
                var $this = $(this), min = $this.attr("data-min") ? $this.attr("data-min") : 0, max = $this.attr("data-max") ? $this.attr("data-max") : 100, style;
                var setMinMaxVal = function(min, max) {
                    if ($(".min-val-tooltip")) {
                        style = $($this.find(".ui-slider-handle")[0]).attr("style");
                        $(".min-val-tooltip").html(min).attr("style", style);
                    }
                    if ($(".max-val-tooltip")) {
                        style = $($this.find(".ui-slider-handle")[1]).attr("style");
                        $(".max-val-tooltip").html(max).attr("style", style);
                    }
                    if ($this.attr("data-min-val-return-to")) {
                        $($this.attr("data-min-val-return-to")).val(min);
                    }
                    if ($this.attr("data-max-val-return-to")) {
                        $($this.attr("data-max-val-return-to")).val(max);
                    }
                };
                $this.slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [ min, max ],
                    change: function(event, ui) {
                        setMinMaxVal(ui.values[0], ui.values[1]);
                    },
                    slide: function(event, ui) {
                        setMinMaxVal(ui.values[0], ui.values[1]);
                    }
                });
                setMinMaxVal(min, max);
            });
            return this;
        }
    };
    $.fn.RellaEnableJqueryUI = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new EnableJqueryUI(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaEnableJqueryUI();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__EnableMediaElementJs';
    var EnableMediaElementJs = function(el, options) {
        return this.init(el, options);
    };
    EnableMediaElementJs.defaults = {};
    EnableMediaElementJs.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, EnableMediaElementJs.defaults, options);
            return this;
        },
        build: function() {
            var element = this.el, settings = {};
            if (!element.length) {
                return;
            }
            if (typeof _wpmejsSettings !== 'undefined') {
                settings = $.extend(true, {}, _wpmejsSettings);
            }
            settings.success = settings.success || function(mejs) {
                var autoplay, loop;
                if ('flash' === mejs.pluginType) {
                    autoplay = mejs.attributes.autoplay && 'false' !== mejs.attributes.autoplay;
                    loop = mejs.attributes.loop && 'false' !== mejs.attributes.loop;
                    autoplay && mejs.addEventListener('canplay', function() {
                        mejs.play();
                    }, false);
                    loop && mejs.addEventListener('ended', function() {
                        mejs.play();
                    }, false);
                }
            };
            var rellamejsDefaults = {
                audioHeight: 60,
                audioVolume: 'vertical',
                features: [ 'playpause', 'current', 'progress', 'duration', 'tracks', 'volume' ]
            };
            rellamejsDefaults.success = function(media) {
                media.addEventListener('play', function(e) {
                    var $this = $(e.target), parent;
                    parent = $this.closest('.blog-post').length ? $this.closest('.blog-post') : $this.closest('.mejs-container');
                    parent.addClass('is-playing');
                });
                media.addEventListener('pause', function(e) {
                    var $this = $(e.target), parent;
                    parent = $this.closest('.blog-post').length ? $this.closest('.blog-post') : $this.closest('.mejs-container');
                    parent.removeClass('is-playing');
                });
            };
            if ("undefined" !== typeof _wpmejsSettings) {
                $.extend(_wpmejsSettings, rellamejsDefaults);
            }
            element.not('.mejs-container').filter(function() {
                return !$(this).parent().hasClass('.mejs-mediaelement');
            }).mediaelementplayer(rellamejsDefaults);
        }
    };
    $.fn.RellaEnableMediaElementJs = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new EnableMediaElementJs(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('video, audio').RellaEnableMediaElementJs();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__EnableMatchHeight';
    var EnableMatchHeight = function(el, options) {
        return this.init(el, options);
    };
    EnableMatchHeight.defaults = {};
    EnableMatchHeight.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, EnableMatchHeight.defaults, options);
            return this;
        },
        build: function() {}
    };
    $.fn.RellaEnableMatchHeight = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new EnableMatchHeight(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaEnableMatchHeight();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__EnableFitText';
    var EnableFitText = function(el, options) {
        return this.init(el, options);
    };
    EnableFitText.defaults = {};
    EnableFitText.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, EnableFitText.defaults, options);
            return this;
        },
        build: function() {
            var el = $('[data-fitText]');
            if (!el.length) {
                return;
            }
            $.fn.fitText = function(kompressor, options) {
                var compressor = kompressor || 1, settings = $.extend({
                    minFontSize: Number.NEGATIVE_INFINITY,
                    maxFontSize: Number.POSITIVE_INFINITY
                }, options);
                return this.each(function() {
                    var $this = $(this);
                    var resizer = function() {
                        $this.css('font-size', Math.max(Math.min($this.width() / (compressor * 10), parseFloat(settings.maxFontSize)), parseFloat(settings.minFontSize)));
                    };
                    resizer();
                    $(window).on('resize.fittext orientationchange.fittext', resizer);
                });
            };
            el.each(function() {
                var $this = $(this), dataMaxFontSize = $this.attr('data-max-fontSize');
                $this.fitText(1, {
                    maxFontSize: dataMaxFontSize
                });
            });
        }
    };
    $.fn.RellaEnableFitText = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new EnableFitText(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaEnableFitText();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__AppearAnimations';
    var AppearAnimations = function(el, options) {
        return this.init(el, options);
    };
    AppearAnimations.defaults = {};
    AppearAnimations.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, AppearAnimations.defaults, options);
            return this;
        },
        build: function() {
            var animationDefaults = {
                from: {
                    y: 70
                },
                to: {
                    y: 0,
                    opacity: 1,
                    visibility: 'visible'
                }
            };
            var el = $('[data-appear-animation]'), appearElement = el.attr('data-appear-element'), appearDelay = el.data('appear-delay'), appearTime = el.data('appear-time'), appearOptionsFrom = el.data('appear-from') || animationDefaults.from, appearOptionsTo = el.data('appear-to') || el.data('appear-options') || animationDefaults.to;
            if (!el.length || appearElement === null || typeof appearElement === typeof undefined) {
                return;
            }
            TweenMax.set(el, {
                opacity: 1,
                visibility: 'visible'
            });
            TweenMax.set(el.find(appearElement), {
                opacity: 0,
                visibility: 'hidden'
            });
            var controller = new ScrollMagic.Controller();
            var scene = new ScrollMagic.Scene({
                triggerElement: el
            });
            if (el.data('stagger') === true) {
                scene.setTween(TweenMax.staggerFromTo(el.find(appearElement), appearTime || .8, appearOptionsFrom, appearOptionsTo, appearDelay));
            } else {
                scene.setTween(TweenMax.fromTo(el.find(appearElement), appearTime || .8, appearOptionsFrom, appearOptionsTo));
            }
            scene.addTo(controller).reverse(false).on('start', function(event) {
                el.addClass('appear-animation-started');
            });
        }
    };
    $.fn.RellaAppearAnimations = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new AppearAnimations(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaAppearAnimations();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__RellaAjaxLoadMore';
    var AjaxLoadMore = function(el, options) {
        return this.init(el, options);
    };
    AjaxLoadMore.defaults = {};
    AjaxLoadMore.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, AjaxLoadMore.defaults, options);
            return this;
        },
        build: function() {
            var doc = this.el;
            doc.off('click', '[data-plugin-ajaxify]');
            doc.on('click', '[data-plugin-ajaxify]', function(event) {
                event.preventDefault();
                var button = $(this), target = button.attr('href'), opts = $.extend(true, {}, button.data('plugin-options'));
                button.addClass('loading');
                $.ajax({
                    type: 'GET',
                    url: target,
                    complete: function() {
                        button.removeClass('loading');
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    },
                    success: function(data) {
                        var wrapper = $(data).find(opts.wrapper), items = wrapper.find(opts.items), nextPageUrl = $(data).find('[data-plugin-ajaxify="true"]').attr('href'), lastDate = $(".timeline-date").last().text().trim(), timelineRows = $(opts.wrapper).find('.timeline-row'), lastTimelineRow = timelineRows.last(), parentOfNewItems;
                        items.imagesLoaded(function() {
                            if (nextPageUrl) button.attr('href', nextPageUrl); else button.parent().slideUp(300);
                            if (items.is('.row:not(.timeline-row)')) {
                                items = items.children('[class*=col-]');
                            }
                            if (items.is('.timeline-row')) {
                                $(items).insertBefore(button.parents('.page-nav'));
                            } else {
                                $(opts.wrapper).append(items.parent('[class*=col-]'));
                            }
                            if ($(opts.wrapper).hasClass('timeline')) {
                                var newFirstRow = items.first(), newFirstRowItems = newFirstRow.find('.masonry-item').not('.mid-bar'), timelineRows = $(opts.wrapper).find('.timeline-row'), newDate = $(".timeline-date", items.first()).text().trim();
                                if (newDate === lastDate) {
                                    newFirstRowItems.appendTo(lastTimelineRow).addClass('item-just-added');
                                    parentOfNewItems = newFirstRowItems.parent();
                                    timelineRows.each(function() {
                                        var $this = $(this);
                                        if (!$this.find('.masonry-item').not('.mid-bar').length) {
                                            $this.remove();
                                        }
                                    });
                                    parentOfNewItems.isotope('appended', newFirstRowItems);
                                    if (typeof progressively !== typeof undefined && $('.progressive__img').length) {
                                        var enableProgressiveLoad = new RellaProgressiveAspectRatio();
                                        enableProgressiveLoad.init();
                                        $('.progressive__img').RellaProgressiveLoad();
                                        progressively.render();
                                    }
                                    setTimeout(function() {
                                        parentOfNewItems.isotope('layout');
                                    }, 300);
                                    parentOfNewItems.on('layoutComplete', function() {
                                        setTimeout(function() {
                                            parentOfNewItems.find('.masonry-item').removeClass('item-just-added');
                                        }, 300);
                                    });
                                }
                            }
                            if (typeof progressively !== typeof undefined && $('.progressive__img').length) {
                                var enableProgressiveLoad = new RellaProgressiveAspectRatio();
                                enableProgressiveLoad.init();
                                $('.progressive__img').RellaProgressiveLoad();
                                progressively.render();
                            }
                            $('[data-plugin-masonry]').rellaMasonryLayout();
                            $('video, audio').RellaEnableMediaElementJs();
                            $(document).RellaCarousel();
                            $(document).RellaOffsetTop();
                            $('[data-parallax="true"]').RellaParallax();
                            $('[data-parallax-bg="true"]').RellaParallaxBG();
                            $('.portfolio-item.hover-blur').RellaEnableStackBlur();
                            $('[data-panr]').rellaPanr();
                            $('.lightbox-link').rellaLightbox();
                            if ($('[data-mh]').length && !button.parents('.masonry-creative').length) {
                                $('[data-mh]').matchHeight({
                                    remove: true
                                });
                                $('[data-mh]').matchHeight();
                            }
                            if ($(opts.wrapper).data('isotope')) {
                                $(opts.wrapper).removeClass('items-loaded');
                                if (!items.is('.timeline-row')) {
                                    $(opts.wrapper).isotope('appended', items.parent('[class*="col-"]'));
                                }
                                $(opts.wrapper).on('layoutComplete', function() {
                                    $(opts.wrapper).addClass('items-loaded');
                                });
                                $.fn.matchHeight._afterUpdate = function(event, groups) {
                                    $(opts.wrapper).isotope('layout');
                                    $(opts.wrapper).addClass('items-loaded');
                                    setTimeout(function() {
                                        $(opts.wrapper).isotope('layout');
                                    }, 600);
                                };
                            }
                            if ('vc_js' in window) {
                                window.setTimeout(vc_waypoints, 500);
                                if ($(opts.wrapper).data('isotope')) {
                                    window.setTimeout(function() {
                                        $(opts.wrapper).isotope('layout');
                                    }, 600);
                                }
                            }
                        });
                        $(window).trigger('resize');
                    }
                });
            });
        }
    };
    $.fn.RellaAjaxLoadMore = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new AjaxLoadMore(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaAjaxLoadMore();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__OffsetTop';
    var OffsetTop = function(el, options) {
        return this.init(el, options);
    };
    OffsetTop.defaults = {};
    OffsetTop.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, OffsetTop.defaults, options);
            return this;
        },
        build: function() {
            this.offset();
            this.reSetOffset();
            return this;
        },
        offset: function() {
            var el = $(".carousel-vertical-random-offset");
            if (!el.length) {
                return;
            }
            el.each(function() {
                var maxHeight = 0;
                var self = $(this);
                $($(".flickity-slider", self).children()).each(function() {
                    var itemHeight = $(this).height();
                    if (itemHeight > maxHeight) {
                        maxHeight = itemHeight;
                    }
                });
                $($(".flickity-slider", self).children()).each(function() {
                    var itemHeight = $(this).height(), maxOffset = maxHeight - itemHeight;
                    var offset = (Math.random() * maxOffset).toFixed();
                    $(this).css("top", offset + "px");
                });
            });
        },
        getHeights: function() {
            var self = this, heights = [];
            $($(".flickity-slider", self.el).children()).each(function() {
                var itemHeight = $(this).height();
                heights.push(itemHeight);
            });
            return heights;
        },
        getTopOffsets: function() {
            var self = this, topOffsets = [];
            $($(".flickity-slider", self.el).children()).each(function() {
                var itemTopOffset = parseInt($(this).css("top"));
                topOffsets.push(itemTopOffset);
            });
            return topOffsets;
        },
        reSetOffset: function() {
            $($(".flickity-slider", self.el).children()).each(function(index) {});
        }
    };
    $.fn.RellaOffsetTop = function(settings) {
        return this.map(function() {
            var el = $(this);
            el.imagesLoaded(function() {
                if (el.data(instanceName)) {
                    return el.data(instanceName);
                } else {
                    var pluginOptions = el.data('plugin-options'), opts;
                    if (pluginOptions) {
                        opts = $.extend(true, {}, settings, pluginOptions);
                    }
                    return new OffsetTop(el, opts);
                }
            });
        });
    };
    $(document).ready(function() {
        $(document).RellaOffsetTop();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__Accordion';
    var Accordion = function(el, options) {
        return this.init(el, options);
    };
    Accordion.defaults = {};
    Accordion.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, Accordion.defaults, options);
            return this;
        },
        build: function() {
            $('.accordion-collapse').on('show.bs.collapse', function() {
                $(this).closest('.accordion-item').addClass('active');
            });
            $('.accordion-collapse').on('hide.bs.collapse', function() {
                $(this).closest('.accordion-item').removeClass('active');
            });
        }
    };
    $.fn.RellaAccordion = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Accordion(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaAccordion();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__LocalScroll';
    var LocalScroll = function(el, options) {
        return this.init(el, options);
    };
    LocalScroll.defaults = {};
    LocalScroll.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, LocalScroll.defaults, options);
            return this;
        },
        build: function() {
            var el = $('.local-scroll');
            if (!el.length) {
                return;
            }
            el.on('click', 'a', function(event) {
                var target = $(this).attr('href');
                if ($(target).length) {
                    event.preventDefault();
                    TweenMax.to($(window), .8, {
                        scrollTo: target,
                        ease: Power3.easeOut
                    });
                }
            });
        }
    };
    $.fn.RellaLocalScroll = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new LocalScroll(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaLocalScroll();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__SortingOption';
    var SortingOption = function(el, options) {
        return this.init(el, options);
    };
    SortingOption.defaults = {};
    SortingOption.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, SortingOption.defaults, options);
            return this;
        },
        build: function() {
            var el = $('.sorting-option');
            if (!el.length) {
                return;
            }
            el.each(function() {
                var $this = $(this), checkbox = $this.find('input[type=checkbox]');
                checkbox.on('change', function() {
                    if (checkbox.prop('checked')) {
                        $this.addClass('checked');
                    } else {
                        $this.removeClass('checked');
                    }
                });
            });
        }
    };
    $.fn.RellaSortingOption = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new SortingOption(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('.sorting-option').RellaSortingOption();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__HeightToWidth';
    var HeightToWidth = function(el, options) {
        return this.init(el, options);
    };
    HeightToWidth.defaults = {};
    HeightToWidth.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, HeightToWidth.defaults, options);
            return this;
        },
        build: function() {
            var el = $('[data-heighttowidth]');
            if (!el.length) {
                return;
            }
            el.each(function() {
                var $this = $(this), target = $this.attr('data-heighttowidth-target');
                $this.find(target).width('');
                $this.imagesLoaded(function() {
                    $this.find(target).width($this.outerHeight());
                    $this.addClass('width-applied');
                });
            });
        }
    };
    $.fn.RellaHeightToWidth = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new HeightToWidth(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaHeightToWidth();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__VideoBG';
    var VideoBG = function(el, options) {
        return this.init(el, options);
    };
    VideoBG.defaults = {};
    VideoBG.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, VideoBG.defaults, options);
            return this;
        },
        build: function() {
            var el = $('.video-bg-player');
            if (!el.length) {
                return;
            }
            el.YTPlayer();
            el.on('YTPReady', function(e) {
                $(e.currentTarget).addClass('video-is-ready');
            });
        }
    };
    $.fn.RellaVideoBG = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new VideoBG(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('.video-bg-player').RellaVideoBG();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__InputIcon';
    var InputIcon = function(el, options) {
        return this.init(el, options);
    };
    InputIcon.defaults = {};
    InputIcon.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, InputIcon.defaults, options);
            return this;
        },
        build: function() {
            var el = $('[data-input-icon]');
            if (!el.length) {
                return;
            }
            $('button.input-generated-button').remove();
            el.each(function(index) {
                var $this = $(this), val = $this.val(), classes = $this.attr('class'), icon = $this.data('input-icon');
                $this.after('<button class=" ' + classes + ' input-generated-button"><span>' + val + '<i class=" ' + icon + ' "></i></span></button>');
                $this.hide();
                if ($this.attr('disabled') == 'disabled') {
                    $this.parent().find('button.input-generated-button').attr('disabled', 'disabled');
                }
                $this.parent().find('button').click(function(e) {
                    e.preventDefault();
                    $this.click();
                });
            });
        }
    };
    $.fn.RellaInputIcon = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new InputIcon(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaInputIcon();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__BackToTop';
    var BackToTop = function(el, options) {
        return this.init(el, options);
    };
    BackToTop.defaults = {};
    BackToTop.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, BackToTop.defaults, options);
            return this;
        },
        build: function() {
            var el = $('.site-backtotop'), $window = $(window);
            if (!el.length) {
                return;
            }
            $window.on('scroll', function() {
                if ($window.scrollTop() >= $window.outerHeight() / 2) {
                    el.addClass('is-visible');
                } else {
                    el.removeClass('is-visible');
                }
            });
        }
    };
    $.fn.RellaBackToTop = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new BackToTop(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $(document).RellaBackToTop();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__scroll_animation';
    var ScrollAnimation = function(el, options) {
        return this.init(el, options);
    };
    ScrollAnimation.defaults = {
        seperator: ".row",
        animation: "fadeInDown",
        bound: 35
    };
    ScrollAnimation.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, ScrollAnimation.defaults, options);
            return this;
        },
        build: function() {
            this.setId();
            this.scrollClick();
            this.paginateHeight();
            this.paginationDrag();
            this.onResize();
        },
        paginationSlide: function(id) {
            var self = this;
            var totalItem = $(self.options.seperator, self.el).length, totalHeight = self.el.height(), paginationHeight = $(".pagination", self.el).outerHeight(), netHeight = totalHeight - paginationHeight, pageHeight = parseInt(netHeight / totalItem), paginationTop = (id - 1) * pageHeight;
            $(".pagination", self.el).css("top", paginationTop + "px");
            $(".bar.before", self.el).css("height", paginationTop + bound);
            $(".bar.after", self.el).css("height", netHeight - paginationTop - bound);
        },
        paginateHeight: function() {
            var self = this;
            var totalHeight = parseInt($(self.options.seperator, self.el).css("height")), paginationHeight = $(".pagination", self.el).outerHeight(), netHeight = totalHeight - paginationHeight + 25;
            $(".bar.before", self.el).css("height", self.options.bound);
            $(".bar.after", self.el).height(netHeight - self.options.bound - 27);
        },
        onResize: function() {
            var self = this;
            $(window).on("resize", function() {
                self.paginateHeight();
                var id = $(self.options.seperator + ".active", self.el).attr("data-id");
                self.paginationSlide(id);
            });
            $(window).triggerHandler('resize');
        },
        setId: function() {
            var self = this;
            var id = 0;
            self.el.attr("data-id", 1);
            $(self.options.seperator + "[data-id=1]", self.el).addClass("active");
            TweenMax.fromTo($(self.options.seperator + "[data-id=1]", self.el), .2, {
                y: 10,
                opacity: 0
            }, {
                y: 0,
                opacity: 1
            });
            $(self.options.seperator, self.el).each(function() {
                id++;
                $(this).attr("data-id", id);
                if (id != 1) {
                    $(this).addClass("non");
                }
            });
            $(".all", self.el).text(id);
        },
        changeRow: function(id) {
            var self = this;
            var selectorId = $(self.options.seperator + "[data-id=" + id + "]", self.el);
            var notSelectorId = $(self.options.seperator + ".active", self.el);
            var resolveSelector = $(self.options.seperator + '[data-id=' + id + '] .section-title-resolve', self.el);
            var notSelectorCols = $("[class*=col-]", $(self.options.seperator + ".active", self.el));
            var selectorCols = $(" [class*=col-]", selectorId);
            var transitionTime = parseFloat($(self.options.seperator, self.el).css("transition-duration"));
            notSelectorId.removeClass("in");
            self.el.find('.page-buttons').addClass('scrolling animations-disabled');
            function completeFunc() {
                notSelectorId.removeClass("active").addClass("non");
                selectorId.addClass("active").removeClass("non");
                selectorId.addClass("in");
                TweenMax.staggerFromTo(selectorCols, .6, {
                    y: '30px',
                    opacity: 0
                }, {
                    y: '0',
                    opacity: 1,
                    ease: Expo.easeOut
                }, .15);
                resolveSelector.rellaResolve().checkResolve;
                $(".slider-3d", selectorId).RellaCarousel3d();
                self.el.find('.page-buttons').removeClass('scrolling');
                self.onResize();
            }
            TweenMax.staggerFromTo(notSelectorCols, .6, {
                y: '0',
                opacity: 1,
                onStart: function() {
                    console.log('asd');
                }
            }, {
                y: '30px',
                opacity: 0,
                ease: Expo.easeInOut
            }, .15, completeFunc);
        },
        scrollClick: function() {
            var self = this, totalItem = parseInt($(self.options.seperator, self.el).length);
            $(".pagination a", self.el).click(function(e) {
                e.preventDefault();
                var direction = $(this).attr("class");
                var id = parseInt(self.el.attr("data-id"));
                if (direction == "next") {
                    if (id == totalItem) {
                        self.changeRow(1);
                        self.el.attr("data-id", 1);
                        $(".pagination .active", self.el).text(1);
                        self.paginationSlide(1);
                    } else {
                        self.changeRow(id + 1);
                        self.el.attr("data-id", id + 1);
                        $(".pagination .active", self.el).text(id + 1);
                        self.paginationSlide(id + 1);
                    }
                } else {
                    if (id == 1) {
                        self.changeRow(totalItem);
                        self.el.attr("data-id", totalItem);
                        $(".pagination .active", self.el).text(totalItem);
                        self.paginationSlide(totalItem);
                    } else {
                        self.changeRow(id - 1);
                        self.el.attr("data-id", id - 1);
                        $(".pagination .active", self.el).text(id - 1);
                        self.paginationSlide(id - 1);
                    }
                }
            });
        },
        paginationDrag: function() {
            var self = this;
            var totalItem = $(self.options.seperator, self.el).length, totalHeight = parseInt($(".page-buttons", self.el).css("height")), paginationHeight = $(".pagination", self.el).height(), netHeight = totalHeight - paginationHeight, pageHeight = parseInt(netHeight / totalItem);
            bound = self.options.bound;
            var transform = Modernizr.prefixedCSS('transform');
            $(".pagination", self.el).draggable({
                axis: "y",
                containment: "parent",
                start: function(event, ui) {
                    start = ui.position.top;
                    lastDragTop = start;
                    selectedItem = $(self.options.seperator + ".active", self.el).attr("data-id");
                },
                drag: function(event, ui) {
                    var stop = ui.position.top, dragTop = ui.position.top, chosen = selectedItem, totalHeight = parseInt($(".page-buttons", self.el).css("height")), netHeight = totalHeight - paginationHeight;
                    $(".bar.before", self.el).css("height", dragTop + bound);
                    $(".bar.after", self.el).css("height", netHeight - dragTop - bound);
                    lastDragTop = dragTop;
                },
                stop: function(event, ui) {
                    var stop = ui.position.top;
                    if (start > stop) {
                        $(".pagination a.prev", self.el).trigger("click");
                    } else {
                        $(".pagination a.next", self.el).trigger("click");
                    }
                }
            });
        }
    };
    $.fn.rellaScrollAnimation = function(settings) {
        return this.map(function() {
            var el = $(this);
            el.imagesLoaded(function() {
                if (el.data(instanceName)) {
                    return el.data(instanceName);
                } else {
                    var pluginOptions = el.data('plugin-options'), opts;
                    if (pluginOptions) {
                        opts = $.extend(true, {}, settings, pluginOptions);
                    }
                    return new ScrollAnimation(el, opts);
                }
            });
        });
    };
    $(document).ready(function() {
        $('[data-plugin-scroll-animation]').rellaScrollAnimation();
    });
}).apply(this, [ jQuery ]);