/*!
* Themerella
*
* (c) Copyright themerella.com
*
* @version 1.0.0
* @author  Themerella
*/


(function($) {
    var instanceName = '__EnableStackBlur';
    var EnableStackBlur = function(el, options) {
        return this.init(el, options);
    };
    EnableStackBlur.defaults = {};
    EnableStackBlur.prototype = {
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
            this.options = $.extend(true, {}, EnableStackBlur.defaults, options);
            return this;
        },
        build: function() {
            var element = this.el;
            if (!element.length) {
                return;
            }
            var contents = element.find('.portfolio-content'), bg = element.find('.portfolio-main-image').find('img'), bgSrc, blurImageContainer = $('<figure class="blur-image-container" />'), blurImg = $('<img class="blur-image" src="" >'), blurCanvas = $('<canvas />'), imgID = 'img-' + Math.round(Math.random() * 1e3), canvasID = 'canvas-' + Math.round(Math.random() * 1e3), blurRadius = element.data('blur-radius'), dataProgressive = bg.attr('data-progressive');
            if (typeof dataProgressive == typeof undefined || dataProgressive == null) {
                bgSrc = bg.attr('src');
            } else {
                bgSrc = dataProgressive;
            }
            function checkURL(url) {
                return url.match(/\.(jpeg|jpg|gif|png|bmp)$/) != null;
            }
            if (typeof bgSrc === typeof undefined || bgSrc === null || checkURL(bgSrc) == false) {
                return;
            }
            if (element.hasClass('parallax-activated')) {
                blurCanvas.attr({
                    'data-parallax': true,
                    'data-parallax-from': '{ "y": "-25%" }',
                    'data-parallax-to': '{ "y": "0%" }',
                    'data-parallax-options': '{ "duration": "150%" }'
                });
            }
            if (!element.find('.blur-image-container').length) {
                blurImageContainer.appendTo(element.find('.portfolio-inner'));
                blurImg.appendTo(blurImageContainer).attr('id', imgID);
                blurCanvas.appendTo(blurImageContainer).attr('id', canvasID);
                blurImg.attr('src', bgSrc);
                contents.css('background-image', '');
                blurImg.imagesLoaded(function() {
                    stackBlurImage(imgID, canvasID, blurRadius || 40, false);
                });
            }
        }
    };
    $.fn.RellaEnableStackBlur = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new EnableStackBlur(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('.portfolio-item.hover-blur').RellaEnableStackBlur();
    });
}).apply(this, [ jQuery ]);

(function($) {
    if (typeof ScrollMagic === typeof undefined) {
        return;
    }
    var instanceName = '__Parallax';
    var Parallax = function(el, uniqueID, options, parallaxFrom, parallaxTo) {
        return this.init(el, uniqueID, options, parallaxFrom, parallaxTo);
    };
    Parallax.defaults = {
        time: 1,
        duration: '100%',
        triggerHook: 1,
        reverse: true,
        offset: 0,
        applyHeight: false
    };
    Parallax.from = {
        y: 35
    };
    Parallax.to = {
        y: 0,
        x: 0,
        z: 0,
        scaleX: 1,
        scaleY: 1,
        scaleZ: 1,
        rotationX: 0,
        rotationY: 0,
        rotationZ: 0,
        opacity: 1,
        ease: Linear.easeNone
    };
    var parallaxController = new ScrollMagic.Controller();
    Parallax.prototype = {
        init: function(el, uniqueID, options, parallaxFrom, parallaxTo) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.uniqueID = uniqueID;
            this.setOptions(uniqueID, options, parallaxFrom, parallaxTo).build();
            return this;
        },
        setOptions: function(uniqueID, options, parallaxFrom, parallaxTo) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, Parallax.defaults, options);
            this.uniqueID = Math.round(Math.random() * 1e7);
            this.optionsParallaxFrom = $.extend(true, {}, Parallax.from, parallaxFrom);
            this.optionsParallaxTo = $.extend(true, {}, Parallax.to, parallaxTo);
            return this;
        },
        build: function() {
            var el = this.el, self = this;
            this.createDummyElement().enableParallax();
            if (this.options.applyHeight) {
                el.imagesLoaded(function() {
                    el.parent().height(el.parent().height());
                });
            }
            $(window).on('load resize', function() {
                setTimeout(function() {
                    self.createDummyElement();
                    self.enableParallax();
                }, 1e3);
            });
            return this;
        },
        buildController: function() {
            return parallaxController;
        },
        createDummyElement: function() {
            var self = this, element = self.el, elementOffset = element.offset(), offsetTop = elementOffset.top, offsetLeft = elementOffset.left, dummyEl = $('<div class="dummy-parallax-element" />');
            if (!$('#prlx-dummy-' + self.uniqueID).length) {
                dummyEl.attr('id', 'prlx-dummy-' + self.uniqueID).appendTo('body');
            }
            dummyEl = $('#prlx-dummy-' + self.uniqueID);
            dummyEl.css({
                width: '',
                height: '',
                top: '',
                left: ''
            });
            dummyEl.css({
                width: element.width(),
                height: element.height(),
                position: 'absolute',
                top: element.offset().top,
                left: element.offset().left,
                zIndex: 99999,
                visibility: 'hidden'
            });
            return self;
        },
        enableParallax: function() {
            var element = this.el.addClass('prlx-obj-' + this.uniqueID), parallaxOptionsFrom = this.optionsParallaxFrom, parallaxOptionsTo = this.optionsParallaxTo, dataDuration = this.options.duration, dataTime = this.options.time, dataReverse = this.options.reverse, dataOffset = this.options.offset, dataTriggerHook = this.options.triggerHook;
            var scene = new ScrollMagic.Scene({
                triggerElement: $('#prlx-dummy-' + this.uniqueID),
                duration: dataDuration,
                offset: dataOffset,
                triggerHook: dataTriggerHook
            });
            scene.setTween(TweenMax.fromTo(element, dataTime, parallaxOptionsFrom, parallaxOptionsTo));
            scene.addTo(this.buildController()).reverse(dataReverse);
            return this;
        }
    };
    $.fn.RellaParallax = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('parallax-options'), dataParallaxFrom = el.data('parallax-from'), dataParallaxTo = el.data('parallax-to'), opts, uniqueID, parallaxFrom, parallaxTo;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                if (dataParallaxFrom) {
                    parallaxFrom = $.extend(true, {}, settings, dataParallaxFrom);
                }
                if (dataParallaxTo) {
                    parallaxTo = $.extend(true, {}, settings, dataParallaxTo);
                }
                return new Parallax(el, uniqueID, opts, parallaxFrom, parallaxTo);
            }
        });
    };
    $(window).on('load', function() {
        $('[data-parallax]').RellaParallax();
    });
    $(document).ready(function() {
        $('[data-parallax]').RellaParallax();
    });
}).apply(this, [ jQuery ]);

(function($) {
    if (typeof ScrollMagic === typeof undefined) {
        return;
    }
    var instanceName = '__ParallaxBG';
    var ParallaxBG = function(el, options) {
        return this.init(el, options);
    };
    ParallaxBG.defaults = {};
    var parallaxBgController = new ScrollMagic.Controller({
        globalSceneOptions: {
            triggerHook: 'onEnter'
        }
    });
    ParallaxBG.prototype = {
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
            this.options = $.extend(true, {}, ParallaxBG.defaults, options);
            return this;
        },
        build: function() {
            this.enableParallaxBG();
        },
        calculateFillHeight: function(srcWidth, srcHeight, maxWidth) {
            var ratio = srcHeight / srcWidth;
            return maxWidth * ratio;
        },
        buildController: function() {
            return parallaxBgController;
        },
        enableParallaxBG: function() {
            var element = this.el, self = this;
            if (!element.length) {
                return;
            }
            var bgImage = element.css('background-image'), parallaxOptions = element.data('parallax-options'), dataDuration = element.data('parallax-duration'), parallaxImg = element.children().addClass('section-parallax-img'), prlxImageContainer = $('<div class="parallax-img-container" />'), prlxBgParent = $('<figure class="parallax-img-parent">'), imageElement = parallaxImg, defaultDuration;
            if (parallaxImg.hasClass('aspect-ratio-container')) {
                parallaxImg.removeClass('section-parallax-img');
                parallaxImg = parallaxImg.find('img');
            }
            prlxImageContainer.appendTo(prlxBgParent);
            bgImage = bgImage.replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
            if (element.find('.parallax-img-parent').length) {
                return;
            }
            parallaxImg.imagesLoaded(function() {
                if (parallaxImg.hasClass('progressive__img')) {
                    parallaxImg.addClass('section-parallax-img').closest('.aspect-ratio-container').appendTo(prlxImageContainer);
                    prlxBgParent.prependTo(element);
                } else if (parallaxImg.is('img')) {
                    parallaxImg.addClass('section-parallax-img').attr('src', bgImage).prependTo(element);
                    parallaxImg.wrap(prlxBgParent);
                } else {
                    parallaxImg = $('<img class="section-parallax-img" >');
                    parallaxImg.attr('src', bgImage).prependTo(element);
                    parallaxImg.wrap(prlxBgParent);
                }
                parallaxImg.clone('true').removeClass('section-parallax-img progressive__img progressive--not-loaded').addClass('parallax-img-placeholder').appendTo(parallaxImg.parent());
                element.css({
                    'background-image': 'none',
                    opacity: 1,
                    visibility: 'visible'
                });
                if (parallaxOptions === null || typeof parallaxOptions === typeof undefined) {
                    parallaxOptions = {
                        y: "-25%"
                    };
                }
                if (dataDuration === null || typeof dataDuration === typeof undefined) {
                    dataDuration = defaultDuration;
                }
                $.extend(parallaxOptions, {
                    ease: Linear.easeNone
                });
                new ScrollMagic.Scene({
                    triggerElement: element,
                    duration: '185%'
                }).setTween(TweenMax.from(parallaxImg, 1, parallaxOptions)).addTo(self.buildController());
            });
        }
    };
    $.fn.RellaParallaxBG = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new ParallaxBG(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-parallax-bg]').RellaParallaxBG();
    });
}).apply(this, [ jQuery ]);

(function($) {
    if (typeof ScrollMagic === typeof undefined) {
        return;
    }
    var instanceName = '__StickyElement';
    var StickyElement = function(el, options) {
        return this.init(el, options);
    };
    StickyElement.defaults = {};
    var parallaxBgController = new ScrollMagic.Controller({
        globalSceneOptions: {
            triggerHook: 0
        }
    });
    StickyElement.prototype = {
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
            this.options = $.extend(true, {}, StickyElement.defaults, options);
            return this;
        },
        buildController: function() {
            return parallaxBgController;
        },
        build: function() {
            var self = this, element = this.el, elementHeight, mainFooter = $('.main-footer'), footerOffset = mainFooter.length ? mainFooter.offset().top : 0, elementOffset = element.offset(), elementBottom = elementOffset.top + element.outerHeight(), durationValueCache;
            function getDuration() {
                return durationValueCache;
            }
            function updateDuration(e) {
                durationValueCache = footerOffset - elementBottom - elementOffset.top;
                console.log(durationValueCache);
            }
            $(window).on("resize", updateDuration);
            $(window).triggerHandler("resize");
            var scene = new ScrollMagic.Scene({
                triggerElement: element
            }).setPin(element).duration(getDuration).addIndicators().addTo(self.buildController());
            return this;
        }
    };
    $.fn.RellaStickyElement = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-sticky-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new StickyElement(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-sticky-element]').RellaStickyElement();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__Carousel';
    var Carousel = function(el, options) {
        return this.init(el, options);
    };
    Carousel.defaults = {};
    Carousel.prototype = {
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
            this.options = $.extend(true, {}, Carousel.defaults, options);
            return this;
        },
        build: function() {
            this.flickitySlider();
        },
        flickitySlider: function() {
            var el = $('.carousel-container'), gallery = $('.gallery-style2'), Flickity = window.Flickity;
            if (typeof Flickity === typeof undefined) {
                return;
            }
            $.extend(Flickity.defaults, {
                contain: true,
                imagesLoaded: true,
                percentPosition: true,
                prevNextButtons: false,
                pageDots: false,
                adaptiveHeight: false,
                cellAlign: "left",
                groupCells: true
            });
            if (!el.length) {
                return;
            }
            el.each(function() {
                var self = $(this);
                var $this = $(this), itemsContainer = $this.find('.carousel-items'), carouselNav = $this.find('.carousel-nav'), navContainer = carouselNav.find('.row'), options = null;
                if (!$this.find('.carousel-nav .row').length) {
                    navContainer = $this.find('.carousel-nav');
                }
                if ($this.data('flickity-options')) {
                    options = $this.data('flickity-options');
                    if (options.prevNextButtons !== null) {
                        options.prevNextButtons = null;
                    }
                }
                if ($this.parents('.portfolio-item.caption-fixed').length || $this.parents('.portfolio-item[class*=hover]').length) {
                    $this.find('.carousel-nav').appendTo($this.parents('.portfolio-item'));
                    navContainer = $this.parents('.portfolio-item').find('.carousel-nav');
                }
                itemsContainer.imagesLoaded(function() {
                    itemsContainer.flickity(options);
                    var flkty = itemsContainer.data('flickity');
                    if ($this.find('.flickity-prev-next-button').length) {
                        $this.addClass('nav-buttons-exist');
                    }
                    carouselNav.find('.flickity-prev-next-button').off('click');
                    carouselNav.find('.flickity-prev-next-button.previous').on('click', function(event) {
                        event.preventDefault();
                        itemsContainer.flickity('previous');
                    });
                    carouselNav.find('.flickity-prev-next-button.next').on('click', function(event) {
                        event.preventDefault();
                        itemsContainer.flickity('next');
                    });
                    if (typeof flkty != typeof undefined || flkty != null) {
                        flkty.on('select', function() {
                            $this.addClass('is-moving');
                        }).on('dragMove', function() {
                            $this.addClass('is-moving');
                        }).on('settle', function() {
                            $this.removeClass('is-moving');
                        });
                    }
                    if ($this.hasClass('carousel-parallax') && (typeof flkty != typeof undefined || flkty != null)) {
                        var $imgs = itemsContainer.find('img').not('.section-parallax-img');
                        if (itemsContainer.find('[data-parallax-bg]').length) {
                            $imgs = itemsContainer.find('[data-parallax-bg]');
                        }
                        itemsContainer.on('scroll.flickity', function() {
                            flkty.slides.forEach(function(slide, i) {
                                var img = $imgs[i];
                                var tx = (slide.target + flkty.x) * -1 / 3;
                                img.style.transform = 'translate3d(' + tx + 'px, 0, 0)';
                            });
                        });
                    }
                    setTimeout(function() {
                        if ($('[data-mh]').length) {
                            $.fn.matchHeight._update();
                        }
                        $("body").RellaHover3d();
                        $('[data-hover3d]').each(function() {
                            ATicon.getInstance($(this));
                        });
                    }, 400);
                    if ($(flkty.element).closest('.row').length && $(flkty.element).closest('.row').data('isotope')) {
                        $(flkty.element).closest('.row').isotope('layout');
                        if ($('[data-mh]').length) {
                            $.fn.matchHeight._update();
                        }
                    }
                    flkty.on('settle', function(e) {
                        if ($('[data-mh]').length) {
                            $.fn.matchHeight._update();
                        }
                        if (typeof progressively !== typeof undefined && $(flkty.element).find('.progressive__img').length) {
                            progressively.render();
                        }
                    });
                });
            });
            if (!gallery.length) {
                return;
            }
            gallery.each(function() {
                var $this = $(this);
                var $carousel = $this.find('.carousel-items').flickity();
                var $thumbs = $this.find('.thumbs'), $carouselNavCells = $thumbs.find('figure'), tumbsToggle = $this.find('.toggle-thumbs');
                $thumbs.mCustomScrollbar({
                    axis: "y",
                    scrollInertia: 350,
                    contentTouchScroll: true,
                    autoHideScrollbar: true
                });
                if (!$this.hasClass('nav-vertical')) {
                    $thumbs = $this.find('.carousel-nav').flickity({
                        asNavFor: '.carousel-items'
                    });
                }
                $thumbs.on('click', 'figure', function(event) {
                    var index = $(event.currentTarget).index();
                    $carousel.flickity('select', index);
                });
                var flkty = $carousel.data('flickity'), navCellHeight = $carouselNavCells.height(), navHeight = $thumbs.height(), autoPlayTime = flkty.options.autoPlay / 1e3;
                $carousel.on('select.flickity', function() {
                    $thumbs.find('.is-nav-selected').removeClass('is-nav-selected');
                    var $selected = $carouselNavCells.eq(flkty.selectedIndex).addClass('is-nav-selected');
                    var scrollY = $selected.position().top - navCellHeight / 2;
                    $thumbs.mCustomScrollbar("scrollTo", scrollY);
                    if ($selected.position().top == 0) {
                        $thumbs.mCustomScrollbar("scrollTo", 0);
                    }
                    if ($this.find('.progress').length) {
                        TweenMax.set($this.find('.progress .progress-inner'), {
                            scaleX: 0
                        });
                        TweenMax.to($this.find('.progress .progress-inner'), autoPlayTime, {
                            scaleX: 1,
                            ease: Linear.easeNone
                        });
                    }
                });
                $carousel.appear(function() {
                    TweenMax.to($thumbs, .8, {
                        x: 0,
                        ease: Power4.easeOut
                    });
                    TweenMax.staggerTo($carouselNavCells, .8, {
                        scale: 1,
                        opacity: 1,
                        delay: .15,
                        ease: Power4.easeOut
                    }, .1);
                    TweenMax.staggerTo($this.find('.carousel-nav > button, .carousel-nav .toggle-thumbs'), .8, {
                        scale: 1,
                        opacity: 1,
                        visibility: 'visible',
                        delay: .3,
                        ease: Power4.easeOut
                    }, .15);
                });
                $('.toggle-thumbs-on').on('click', function() {
                    TweenMax.to($thumbs, .8, {
                        x: '100%',
                        delay: .2,
                        ease: Power4.easeOut
                    });
                    TweenMax.staggerTo($($carouselNavCells.get().reverse()), .8, {
                        scale: .5,
                        opacity: 0,
                        ease: Power4.easeOut
                    }, .1);
                    TweenMax.to($this.find('.carousel-nav'), .8, {
                        x: 0,
                        right: '2%',
                        delay: .3,
                        ease: Power4.easeOut
                    });
                    $(this).parent().addClass('off');
                });
                $('.toggle-thumbs-off').on('click', function() {
                    TweenMax.to($this.find('.carousel-nav'), .8, {
                        x: 0,
                        right: '12%',
                        ease: Power4.easeOut
                    });
                    TweenMax.to($thumbs, .8, {
                        x: '0%',
                        delay: .15,
                        ease: Power4.easeOut
                    });
                    TweenMax.staggerTo($carouselNavCells, .8, {
                        scale: 1,
                        opacity: 1,
                        visibility: 'visible',
                        delay: .3,
                        ease: Power4.easeOut
                    }, .1);
                    $(this).parent().removeClass('off');
                });
            });
        }
    };
    $.fn.RellaCarousel = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Carousel(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('.carousel-items').RellaCarousel();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__Carousel3d';
    var Carousel3d = function(el, options) {
        return this.init(el, options);
    };
    Carousel3d.defaults = {
        parentClass: ".carousel-3d",
        itemClass: ".item-3d"
    };
    Carousel3d.prototype = {
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
            this.options = $.extend(true, {}, Carousel3d.defaults, options);
            return this;
        },
        build: function() {
            this.setHeight();
            this.setId();
            this.carousel3d();
            this.dragItem();
            return self;
        },
        newBuild: function() {
            this.setHeight();
            this.setId();
            this.dragItem();
        },
        setId: function() {
            var self = this;
            var total = $(self.options.itemClass, self.el).length, id = total;
            $(self.options.itemClass, self.el).each(function() {
                $(this).attr("data-id", id);
                id--;
            });
            $("span.all", self.el).text(total);
        },
        setHeight: function() {
            var self = this, maxHeight = 0;
            $("a", self.options.itemClass, self.el).each(function() {
                if ($(this).height() > maxHeight) {
                    maxHeight = $(this).height();
                }
            });
            self.el.height(maxHeight);
            $(self.options.parentClass, self.el).height(maxHeight);
            $(self.options.itemClass, self.el).addClass("height-full");
        },
        carousel3d: function() {
            var self = this;
            $(self.options.itemClass, self.el).click(function(e) {
                e.preventDefault();
                if (!$(this).hasClass("noclick")) {
                    if ($(this).index() != $(self.options.itemClass, self.el).length - 1) {
                        e.preventDefault();
                        var id = self.showPrev();
                    }
                }
                $(this).removeClass("noclick");
            });
            return self;
        },
        dragItem: function() {
            var self = this;
            var containmentLeft = self.el.offset().left - 10, containmentRight = self.el.offset().left + 30;
            $(self.options.itemClass, self.el).draggable({
                axis: "x",
                containment: [ containmentLeft, 0, containmentRight, 0 ],
                start: function(event, ui) {
                    start = ui.position.left;
                    $(this).css("top", "");
                    $(self.options.itemClass, self.el).removeClass("noclick");
                    $(this).addClass("noclick");
                },
                stop: function(event, ui) {
                    stop = ui.position.left;
                    ui.position.left = containmentLeft;
                    if (start > stop) {
                        var id = self.showNext();
                    } else {
                        ui.position.left = containmentRight;
                        var id = self.showPrev();
                    }
                    $(this).attr('style', "");
                }
            });
        },
        showPrev: function() {
            var self = this;
            $(self.options.itemClass + ":last-child", self.el).addClass("out");
            $(self.options.itemClass, self.el).removeClass("last");
            $(self.options.itemClass + ":nth-last-child(2)", self.el).addClass("last");
            setTimeout(function() {
                $(self.options.itemClass + ":last-child", self.el).prependTo($(self.options.parentClass, self.el));
                $(self.options.itemClass + ":last-child", self.el).removeClass("last");
                $(self.options.itemClass + ":last-child", self.el).removeClass("out");
                setTimeout(function() {
                    $(self.options.itemClass + ":first-child", self.el).removeClass("out");
                }, 10);
                $(".active", self.el).text($(self.options.itemClass + ":last-child", self.el).attr("data-id"));
            }, 500);
            return $(self.options.itemClass + ":nth-last-child(2)", self.el).attr("data-id");
        },
        showNext: function() {
            var self = this;
            $(self.options.itemClass + ":first-child", self.el).addClass("out");
            $(self.options.itemClass, self.el).removeClass("last");
            $(self.options.itemClass + ":first-child", self.el).appendTo($(self.options.parentClass, self.el));
            setTimeout(function() {
                $(self.options.itemClass + ":last-child", self.el).removeClass("out");
                $(".active", self.el).text($(self.options.itemClass + ":last-child", self.el).attr("data-id"));
            }, 150);
            return $(self.options.itemClass + ":last-child", self.el).attr("data-id");
        }
    };
    $.fn.RellaCarousel3d = function(settings) {
        return this.map(function() {
            var el = $(this);
            el.imagesLoaded(function() {
                if (el.data(instanceName)) {
                    return el.data(instanceName).newBuild();
                } else {
                    var pluginOptions = el.data('plugin-options'), opts;
                    if (pluginOptions) {
                        opts = $.extend(true, {}, settings, pluginOptions);
                    }
                    return new Carousel3d(el, opts);
                }
            });
        });
    };
    $(document).ready(function() {
        $('.slider-3d').RellaCarousel3d();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__counter';
    var Counter = function(el, options) {
        return this.init(el, options);
    };
    Counter.defaults = {
        from: 0,
        speed: 1e3,
        refreshInterval: 50
    };
    Counter.prototype = {
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
            this.options = $.extend(true, {}, Counter.defaults, options);
            return this;
        },
        build: function() {
            var el = this.el, opts = this.options, span = el.find('.counter-element > span'), to = parseInt(span.text(), 10);
            if ($.isFunction($.fn.appear)) {
                span.appear(function() {
                    span.countTo($.extend({
                        to: to
                    }, opts));
                });
            } else {
                console.warn(' jQuery appear is needed ');
            }
            return this;
        }
    };
    $.fn.rellaCounter = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Counter(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-plugin-counter]').rellaCounter();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__animatedIcon';
    var AnimatedIcon = function(el, options) {
        return this.init(el, options);
    };
    AnimatedIcon.defaults = {
        color: rellaTheme.colorPrimary,
        hoverColor: null,
        type: 'delayed',
        duration: 100,
        delay: 0,
        resetOnHover: false
    };
    AnimatedIcon.prototype = {
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
            this.options = $.extend(true, {}, AnimatedIcon.defaults, options);
            return this;
        },
        build: function() {
            var self = this, el = this.el, obj = el.find('svg'), objVivus, delayTime = parseInt(self.options.delay, 10), parentIconbox = el.closest('.icon-box').attr('id', 'iconbox-' + Math.round(Math.random() * 1e6));
            if (!obj.length) {
                return;
            }
            objVivus = new Vivus(obj.get(0), {
                type: self.options.type,
                duration: self.options.duration,
                start: 'manual',
                onReady: function(event) {
                    var strokegradients = document.createElementNS('http://www.w3.org/2000/svg', 'defs'), strokeHoverGradients = document.createElementNS('http://www.w3.org/2000/svg', 'style'), gradientValues = typeof self.options.color !== typeof undefined && self.options.color !== null ? self.options.color.split(',') : '#000', hoverGradientValues = self.options.hoverColor, gid = Math.round(Math.random() * 1e6);
                    if (undefined === gradientValues[1]) {
                        gradientValues[1] = gradientValues[0];
                    }
                    strokegradients.innerHTML = '<linearGradient gradientUnits="userSpaceOnUse" id="grad' + gid + '" x1="0%" y1="0%" x2="0%" y2="100%">' + '<stop offset="0%" stop-color="' + gradientValues[0] + '" />' + '<stop offset="100%" stop-color="' + gradientValues[1] + '" />' + "</linearGradient>";
                    obj.prepend(strokegradients);
                    if (typeof undefined !== typeof hoverGradientValues && null !== hoverGradientValues) {
                        hoverGradientValues = hoverGradientValues.split(',');
                        if (undefined === hoverGradientValues[1]) {
                            hoverGradientValues[1] = hoverGradientValues[0];
                        }
                        strokeHoverGradients.innerHTML = '#' + parentIconbox.attr('id') + ':hover .icon-container defs stop:first-child{stop-color:' + hoverGradientValues[0] + ';}' + '#' + parentIconbox.attr('id') + ':hover .icon-container defs stop:last-child{stop-color:' + hoverGradientValues[1] + ';}';
                        obj.prepend(strokeHoverGradients);
                    }
                    obj.find('path').attr('stroke', 'url(#grad' + gid + ')');
                    $(event.el).closest('.icon-container').addClass('appear-animation-visible');
                }
            }).reset().stop();
            el.appear(function() {
                setTimeout(function() {
                    objVivus.stop().reset().play(self.options.duration / 100);
                }, delayTime);
            });
            if (self.options.resetOnHover) {
                parentIconbox.on('mouseenter', function() {
                    if (objVivus.getStatus() == 'end') {
                        objVivus.stop().reset().play(self.options.duration / 100);
                    }
                });
            }
            return this;
        }
    };
    $.fn.rellaAnimatedIcon = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new AnimatedIcon(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-plugin-animated-icon]').rellaAnimatedIcon();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__portfolio';
    var Portfolio = function(el, options) {
        return this.init(el, options);
    };
    Portfolio.defaults = {};
    Portfolio.prototype = {
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
            this.options = $.extend(true, {}, Portfolio.defaults, options);
            return this;
        },
        build: function() {
            var self = this, el = this.el, filters = $('.masonry-filters'), grid = filters.data('target') || el.children('[id*=grid-]'), counter = $('<span class="counter"><span></span></span>');
            grid = $(grid);
            grid.isotope({
                itemSelector: '.masonry-item',
                layoutMode: 'packery'
            });
            el.find('.sorting-option input[type=checkbox]').on('change', function() {
                var checkbox = $(this), value = checkbox.prop('checked') ? checkbox.val() : '';
                setTimeout(function() {
                    window.location = self.add_query_arg(checkbox.data('metric'), value);
                }, 300);
            });
            if (filters.length && !filters.find('li').find('.counter').length) {
                counter.appendTo(filters.find('li').not('[data-filter="*"]'));
            }
            self.update_filter_counts(grid, filters);
            var clones = $('.masonry-filters, .masonry-filters-clone .masonry-filters');
            filters.on('click', 'li', function() {
                var $this = $(this), filterValue = $this.attr('data-filter');
                clones.find('.active').removeClass('active');
                clones.find('[data-filter="' + filterValue + '"]').addClass('active');
                if (grid.attr('data-stagger') === null || typeof grid.attr('data-stagger') === typeof undefined) {
                    grid.isotope({
                        filter: filterValue
                    });
                    self.update_filter_counts(grid, filters);
                } else {
                    var items = grid.isotope('getItemElements');
                    TweenMax.staggerTo($(items).filter(':visible').find('.inner-wrapper'), .2, {
                        y: 30,
                        opacity: 0,
                        onStart: function() {
                            filters.addClass('grid-transition-started');
                        }
                    }, .05, function() {
                        grid.isotope({
                            filter: filterValue
                        });
                        grid.addClass('stagger-done');
                        self.update_filter_counts(grid, filters);
                    });
                    grid.on('layoutComplete', function() {
                        filters.removeClass('grid-transition-started');
                        TweenMax.staggerTo($(items).filter(':visible').find('.inner-wrapper'), .25, {
                            y: 0,
                            opacity: 1
                        }, .1);
                        if ($('[data-mh]').length) {
                            $('[data-mh]').matchHeight({
                                remove: true
                            });
                            $('[data-mh]').matchHeight();
                        }
                    });
                }
            });
            if ($('.carousel-items').length) {
                $('.carousel-items').imagesLoaded(function() {
                    self.update_layout(grid);
                });
            }
            if ($('[data-mh]').length) {}
            return this;
        },
        add_query_arg: function(key, val, url) {
            key = escape(key);
            val = escape(val);
            url = url || location.origin + location.pathname;
            var queries = {};
            if ('' !== document.location.search) {
                $.each(document.location.search.substr(1).split('&'), function(c, q) {
                    var i = q.split('=');
                    queries[i[0].toString()] = i[1].toString();
                });
            }
            if ('' != val) {
                queries[key] = val;
            } else {
                delete queries[key];
            }
            if (Object.keys(queries).length > 0) {
                url = url + '?' + $.param(queries);
            }
            return url;
        },
        update_filter_counts: function(grid, filters) {
            if (!filters.length) {
                return;
            }
            var itemElems = grid.isotope('getFilteredItemElements'), $itemElems = $(itemElems);
            filters.find('li').each(function(i, button) {
                var $button = $(button), filterValue = $button.attr('data-filter');
                if (!filterValue) {
                    return;
                }
                var count = $itemElems.filter(filterValue).length;
                $button.find('.counter span').text(count);
            });
            return this;
        },
        update_layout: function(grid) {
            setTimeout(function() {
                grid.isotope('layout');
            }, 400);
            return this;
        }
    };
    $.fn.rellaPortfolio = function(settings) {
        return this.map(function() {
            var el = $(this), filters = el.find('.masonry-filters'), grid = filters.data('target') || el.children('[id*=grid-]');
            el.imagesLoaded(function() {
                setTimeout(function() {
                    $(grid).addClass('items-loaded');
                }, 500);
                if (el.data(instanceName)) {
                    return el.data(instanceName);
                } else {
                    var pluginOptions = el.data('plugin-options'), opts;
                    if (pluginOptions) {
                        opts = $.extend(true, {}, settings, pluginOptions);
                    }
                    return new Portfolio(el, opts);
                }
            });
        });
    };
    $(document).ready(function() {
        if (typeof $.fn.isotope === 'function') {
            $('[data-plugin-portfolio]').rellaPortfolio();
        }
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__masonryLayout';
    var MasonryLayout = function(el, options) {
        return this.init(el, options);
    };
    MasonryLayout.prototype = {
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
            this.options = $.extend(true, {}, options);
            return this;
        },
        build: function() {
            var self = this, grid = this.el, filter = $(grid).siblings('.masonry-filters'), activeFilter = filter.find('.active'), activeValue = activeFilter.attr('data-filter');
            var $grid = grid.isotope({
                itemSelector: '.masonry-item',
                layoutMode: 'packery',
                filter: activeValue || '*'
            });
            filter.on('click', 'li', function() {
                var $this = $(this), filterVal = $this.attr('data-filter');
                filter.find('.active').removeClass('active');
                filter.find('[data-filter="' + filterVal + '"]').addClass('active');
                $grid.isotope({
                    filter: filterVal
                });
            });
            $grid.on('layoutComplete', self.layoutComplete);
            $grid.isotope('on', 'layoutComplete', self.layoutComplete);
            $grid.isotope('layout');
            $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
                $grid.isotope('layout');
            });
            return this;
        },
        layoutComplete: function(event, laidOutItems) {
            function itemTransitionEnd(endedTransition, callback) {
                var transEndEventNames = {
                    transition: 'transitionend',
                    OTransition: 'oTransitionEnd',
                    MozTransition: 'transitionend',
                    msTransition: 'MSTransitionEnd',
                    WebkitTransition: 'webkitTransitionEnd'
                };
                var transEndEventName = transEndEventNames[Modernizr.prefixedCSS('transition')];
                transEndEventName && endedTransition.on(transEndEventName, function(event) {
                    callback(event);
                });
            }
            function positioning(element) {
                element.removeClass('laid-to-left laid-to-right');
                if (element.position().left <= 0 || element.position().left + element.outerWidth() < element.parent().width() / 2) {
                    element.removeClass('laid-to-right').addClass('laid-to-left');
                } else if (element.position().left + element.outerWidth() >= element.parent().width()) {
                    element.removeClass('laid-to-left').addClass('laid-to-right');
                }
            }
            $.each(laidOutItems, function(index, val) {
                var el = $(val.element);
                setTimeout(function() {
                    positioning(el);
                }, 350);
            });
            var $element = $(this.element);
            setTimeout(function() {
                $element.addClass('items-loaded');
            }, 500);
        }
    };
    $.fn.rellaMasonryLayout = function(settings) {
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
                    return new MasonryLayout(el, opts);
                }
            });
        });
    };
    $(document).ready(function() {
        if (typeof $.fn.isotope === 'function') {
            $('[data-plugin-masonry]').rellaMasonryLayout();
        }
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__progressbar';
    var Progressbar = function(el, options) {
        return this.init(el, options);
    };
    Progressbar.defaults = {
        percent: 100
    };
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
            if (this.el.hasClass('progressbar')) {
                this.bar(false);
            } else if (this.el.hasClass('vertical-progressbar')) {
                this.bar(true);
            } else if (this.el.hasClass('progressbar-circle')) {
                this.circular();
            }
            return this;
        },
        bar: function(vertical) {
            var el = this.el, opts = this.options;
            if (opts.percent > 100) {
                opts.percent = 100;
            }
            var bar = $('<div class="progressbar-bar"><span></span></div>'), value = $('<span class="progressbar-value"><span>' + opts.percent + '</span>%</span>');
            el.append(bar).append(value);
            value.find('span').each(function() {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 1e3,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
            if (vertical) {
                el.find('.progressbar-bar > span, .progressbar-value').animate({
                    height: opts.percent + "%"
                }, {
                    duration: 1e3,
                    easing: 'swing'
                });
            } else {
                el.find('.progressbar-bar > span, .progressbar-value, .polygon-container').animate({
                    width: opts.percent + "%"
                }, {
                    duration: 1e3,
                    easing: 'swing'
                });
            }
        },
        circular: function() {}
    };
    $.fn.rellaProgressbar = function(settings) {
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
        $('[data-plugin-progressbar]').rellaProgressbar();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__subscribeform';
    var SubscribeForm = function(el, options) {
        return this.init(el, options);
    };
    SubscribeForm.defaults = {
        icon: false,
        align: 'left'
    };
    SubscribeForm.prototype = {
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
            this.options = $.extend(true, {}, SubscribeForm.defaults, options);
            return this;
        },
        build: function() {
            var self = this, el = this.el;
            var submit = el.find('.wysija-submit'), icon = self.options.icon ? '<span class="submit-icon"><i class="' + self.options.icon + '"></i></span>' : '', icon_left = '', icon_right = '';
            if ('left' === self.options.icon) {
                icon_left = icon;
            } else {
                icon_right = icon;
            }
            var button = '<button class="wysija-submit wysija-submit-field" type="submit">' + icon_left + '<span class="submit-text">' + submit.val() + '</span>' + icon_right + '</button>';
            submit.hide();
            submit.after(button);
            el.animate({
                opacity: 1
            });
            return this;
        }
    };
    $.fn.rellaSubscribeForm = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new SubscribeForm(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-plugin-subscribe-form]').rellaSubscribeForm();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__google_maps';
    function CustomMarker(latlng, map, className) {
        this.latlng_ = latlng;
        this.className = className;
        this.setMap(map);
    }
    if (typeof google !== typeof undefined) {
        CustomMarker.prototype = new google.maps.OverlayView();
        CustomMarker.prototype.draw = function() {
            var me = this;
            var div = this.div_;
            if (!div) {
                div = this.div_ = document.createElement('DIV');
                div.className = this.className;
                divChild = document.createElement("div");
                div.appendChild(divChild);
                divChild2 = document.createElement("div");
                divChild.appendChild(divChild2);
                google.maps.event.addDomListener(div, "click", function(event) {
                    google.maps.event.trigger(me, "click");
                });
                var panes = this.getPanes();
                panes.overlayImage.appendChild(div);
            }
            var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
            if (point) {
                div.style.left = point.x + 'px';
                div.style.top = point.y + 'px';
            }
        };
        CustomMarker.prototype.remove = function() {
            if (this.div_) {
                this.div_.parentNode.removeChild(this.div_);
                this.div_ = null;
            }
        };
        CustomMarker.prototype.getPosition = function() {
            return this.latlng_;
        };
    }
    var Maps = function(el, options) {
        return this.init(el, options);
    };
    Maps.defaults = {
        address: '',
        marker: '',
        primaryColor: '#2d313f',
        saturation: -20,
        brightness: 5,
        style: 'apple',
        markers: null,
        className: 'map_marker',
        marker_option: 'image'
    };
    Maps.styles = {
        aeropuerto: [ {
            featureType: "all",
            elementType: "geometry.fill",
            stylers: [ {
                weight: "2.00"
            } ]
        }, {
            featureType: "all",
            elementType: "geometry.stroke",
            stylers: [ {
                color: "#9c9c9c"
            } ]
        }, {
            featureType: "all",
            elementType: "labels.text",
            stylers: [ {
                visibility: "on"
            } ]
        }, {
            featureType: "landscape",
            elementType: "all",
            stylers: [ {
                color: "#f2f2f2"
            } ]
        }, {
            featureType: "landscape",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#ffffff"
            } ]
        }, {
            featureType: "landscape.man_made",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#ffffff"
            } ]
        }, {
            featureType: "poi",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "road",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 45
            } ]
        }, {
            featureType: "road",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#eeeeee"
            } ]
        }, {
            featureType: "road",
            elementType: "labels.text.fill",
            stylers: [ {
                color: "#7b7b7b"
            } ]
        }, {
            featureType: "road",
            elementType: "labels.text.stroke",
            stylers: [ {
                color: "#ffffff"
            } ]
        }, {
            featureType: "road.highway",
            elementType: "all",
            stylers: [ {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "labels.icon",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "transit",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "water",
            elementType: "all",
            stylers: [ {
                color: "#46bcec"
            }, {
                visibility: "on"
            } ]
        }, {
            featureType: "water",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#8cb6b6"
            } ]
        }, {
            featureType: "water",
            elementType: "labels.text.fill",
            stylers: [ {
                color: "#070707"
            } ]
        }, {
            featureType: "water",
            elementType: "labels.text.stroke",
            stylers: [ {
                color: "#ffffff"
            } ]
        } ],
        apple: [ {
            featureType: "landscape.man_made",
            elementType: "geometry",
            stylers: [ {
                color: "#f7f1df"
            } ]
        }, {
            featureType: "landscape.natural",
            elementType: "geometry",
            stylers: [ {
                color: "#d0e3b4"
            } ]
        }, {
            featureType: "landscape.natural.terrain",
            elementType: "geometry",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "poi",
            elementType: "labels",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "poi.business",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "poi.medical",
            elementType: "geometry",
            stylers: [ {
                color: "#fbd3da"
            } ]
        }, {
            featureType: "poi.park",
            elementType: "geometry",
            stylers: [ {
                color: "#bde6ab"
            } ]
        }, {
            featureType: "road",
            elementType: "geometry.stroke",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "road",
            elementType: "labels",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "road.highway",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#ffe15f"
            } ]
        }, {
            featureType: "road.highway",
            elementType: "geometry.stroke",
            stylers: [ {
                color: "#efd151"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#ffffff"
            } ]
        }, {
            featureType: "road.local",
            elementType: "geometry.fill",
            stylers: [ {
                color: "black"
            } ]
        }, {
            featureType: "transit.station.airport",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#cfb2db"
            } ]
        }, {
            featureType: "water",
            elementType: "geometry",
            stylers: [ {
                color: "#a2daf2"
            } ]
        } ],
        blueWater: [ {
            featureType: "administrative",
            elementType: "labels.text.fill",
            stylers: [ {
                color: "#444444"
            } ]
        }, {
            featureType: "landscape",
            elementType: "all",
            stylers: [ {
                color: "#f2f2f2"
            } ]
        }, {
            featureType: "poi",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "road",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 45
            } ]
        }, {
            featureType: "road.highway",
            elementType: "all",
            stylers: [ {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "labels.icon",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "transit",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "water",
            elementType: "all",
            stylers: [ {
                color: "#46bcec"
            }, {
                visibility: "on"
            } ]
        } ],
        classy: [ {
            featureType: "all",
            elementType: "labels",
            stylers: [ {
                visibility: "off"
            }, {
                hue: "#ff0000"
            } ]
        }, {
            featureType: "administrative.province",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "landscape",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 65
            }, {
                visibility: "on"
            } ]
        }, {
            featureType: "poi",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 51
            }, {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road.highway",
            elementType: "all",
            stylers: [ {
                saturation: "0"
            }, {
                visibility: "on"
            }, {
                lightness: "6"
            }, {
                hue: "#ff9800"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 30
            }, {
                visibility: "on"
            } ]
        }, {
            featureType: "road.local",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 40
            }, {
                visibility: "on"
            } ]
        }, {
            featureType: "transit",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                visibility: "simplified"
            } ]
        }, {
            featureType: "water",
            elementType: "geometry",
            stylers: [ {
                hue: "#ffff00"
            }, {
                lightness: -25
            }, {
                saturation: -97
            } ]
        }, {
            featureType: "water",
            elementType: "labels",
            stylers: [ {
                visibility: "on"
            }, {
                lightness: -25
            }, {
                saturation: -100
            } ]
        } ],
        desaturatedRoad: [ {
            stylers: [ {
                saturation: 0
            } ]
        }, {
            featureType: "road",
            elementType: "geometry",
            stylers: [ {
                lightness: 200
            }, {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road",
            elementType: "labels",
            stylers: [ {
                visibility: "simplified"
            } ]
        }, {
            featureType: "administrative",
            elementType: "labels",
            stylers: [ {
                visibility: "simplified"
            } ]
        }, {
            featureType: "poi",
            elementType: "labels",
            stylers: [ {
                visibility: "simplified"
            }, {
                saturation: 45
            } ]
        }, {
            featureType: "water",
            elementType: "labels",
            stylers: [ {
                visibility: "simplified"
            }, {
                saturation: -45
            } ]
        }, {
            featureType: "water",
            elementType: "geometry",
            stylers: [ {
                visibility: "simplified"
            }, {
                saturation: 45
            } ]
        }, {
            featureType: "landscape",
            elementType: "labels",
            stylers: [ {
                visibility: "simplified"
            }, {
                saturation: 45
            } ]
        }, {
            featureType: "transit",
            elementType: "labels",
            stylers: [ {
                visibility: "simplified"
            }, {
                saturation: 45
            } ]
        } ],
        flatPale: [ {
            featureType: "administrative",
            elementType: "labels.text.fill",
            stylers: [ {
                color: "#6195a0"
            } ]
        }, {
            featureType: "administrative.province",
            elementType: "geometry.stroke",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "landscape",
            elementType: "geometry",
            stylers: [ {
                lightness: "0"
            }, {
                saturation: "0"
            }, {
                color: "#f5f5f2"
            }, {
                gamma: "1"
            } ]
        }, {
            featureType: "landscape.man_made",
            elementType: "all",
            stylers: [ {
                lightness: "-3"
            }, {
                gamma: "1.00"
            } ]
        }, {
            featureType: "landscape.natural.terrain",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "poi",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "poi.park",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#bae5ce"
            }, {
                visibility: "on"
            } ]
        }, {
            featureType: "road",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 45
            }, {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road.highway",
            elementType: "all",
            stylers: [ {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road.highway",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#fac9a9"
            }, {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road.highway",
            elementType: "labels.text",
            stylers: [ {
                color: "#4e4e4e"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "labels.text.fill",
            stylers: [ {
                color: "#787878"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "labels.icon",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "transit",
            elementType: "all",
            stylers: [ {
                visibility: "simplified"
            } ]
        }, {
            featureType: "transit.station.airport",
            elementType: "labels.icon",
            stylers: [ {
                hue: "#0a00ff"
            }, {
                saturation: "-77"
            }, {
                gamma: "0.57"
            }, {
                lightness: "0"
            } ]
        }, {
            featureType: "transit.station.rail",
            elementType: "labels.text.fill",
            stylers: [ {
                color: "#43321e"
            } ]
        }, {
            featureType: "transit.station.rail",
            elementType: "labels.icon",
            stylers: [ {
                hue: "#ff6c00"
            }, {
                lightness: "4"
            }, {
                gamma: "0.75"
            }, {
                saturation: "-68"
            } ]
        }, {
            featureType: "water",
            elementType: "all",
            stylers: [ {
                color: "#eaf6f8"
            }, {
                visibility: "on"
            } ]
        }, {
            featureType: "water",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#c7eced"
            } ]
        }, {
            featureType: "water",
            elementType: "labels.text.fill",
            stylers: [ {
                lightness: "-49"
            }, {
                saturation: "-53"
            }, {
                gamma: "0.79"
            } ]
        } ],
        fuse: [ {
            featureType: "administrative.province",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "landscape",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 65
            }, {
                visibility: "on"
            } ]
        }, {
            featureType: "poi",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 51
            }, {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road.highway",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 30
            }, {
                visibility: "on"
            } ]
        }, {
            featureType: "road.local",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 40
            }, {
                visibility: "on"
            } ]
        }, {
            featureType: "transit",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                visibility: "simplified"
            } ]
        }, {
            featureType: "transit",
            elementType: "geometry.fill",
            stylers: [ {
                visibility: "on"
            } ]
        }, {
            featureType: "water",
            elementType: "geometry",
            stylers: [ {
                hue: "#ffff00"
            }, {
                lightness: -25
            }, {
                saturation: -97
            } ]
        }, {
            featureType: "water",
            elementType: "labels",
            stylers: [ {
                visibility: "on"
            }, {
                lightness: -25
            }, {
                saturation: -100
            } ]
        } ],
        lightAndDark: [ {
            featureType: "administrative",
            elementType: "labels.text.fill",
            stylers: [ {
                color: "#444444"
            } ]
        }, {
            featureType: "administrative.land_parcel",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "landscape",
            elementType: "all",
            stylers: [ {
                color: "#f2f2f2"
            } ]
        }, {
            featureType: "landscape.natural",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "poi",
            elementType: "all",
            stylers: [ {
                visibility: "on"
            }, {
                color: "#052366"
            }, {
                saturation: "-70"
            }, {
                lightness: "85"
            } ]
        }, {
            featureType: "poi",
            elementType: "labels",
            stylers: [ {
                visibility: "simplified"
            }, {
                lightness: "-53"
            }, {
                weight: "1.00"
            }, {
                gamma: "0.98"
            } ]
        }, {
            featureType: "poi",
            elementType: "labels.icon",
            stylers: [ {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 45
            }, {
                visibility: "on"
            } ]
        }, {
            featureType: "road",
            elementType: "geometry",
            stylers: [ {
                saturation: "-18"
            } ]
        }, {
            featureType: "road",
            elementType: "labels",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "road.highway",
            elementType: "all",
            stylers: [ {
                visibility: "on"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "all",
            stylers: [ {
                visibility: "on"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "labels.icon",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "road.local",
            elementType: "all",
            stylers: [ {
                visibility: "on"
            } ]
        }, {
            featureType: "transit",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "water",
            elementType: "all",
            stylers: [ {
                color: "#57677a"
            }, {
                visibility: "on"
            } ]
        } ],
        shadesOfGrey: [ {
            featureType: "all",
            elementType: "labels.text.fill",
            stylers: [ {
                saturation: 36
            }, {
                color: "#000000"
            }, {
                lightness: 40
            } ]
        }, {
            featureType: "all",
            elementType: "labels.text.stroke",
            stylers: [ {
                visibility: "on"
            }, {
                color: "#000000"
            }, {
                lightness: 16
            } ]
        }, {
            featureType: "all",
            elementType: "labels.icon",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "administrative",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#000000"
            }, {
                lightness: 20
            } ]
        }, {
            featureType: "administrative",
            elementType: "geometry.stroke",
            stylers: [ {
                color: "#000000"
            }, {
                lightness: 17
            }, {
                weight: 1.2
            } ]
        }, {
            featureType: "landscape",
            elementType: "geometry",
            stylers: [ {
                color: "#000000"
            }, {
                lightness: 20
            } ]
        }, {
            featureType: "poi",
            elementType: "geometry",
            stylers: [ {
                color: "#000000"
            }, {
                lightness: 21
            } ]
        }, {
            featureType: "road.highway",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#000000"
            }, {
                lightness: 17
            } ]
        }, {
            featureType: "road.highway",
            elementType: "geometry.stroke",
            stylers: [ {
                color: "#000000"
            }, {
                lightness: 29
            }, {
                weight: .2
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "geometry",
            stylers: [ {
                color: "#000000"
            }, {
                lightness: 18
            } ]
        }, {
            featureType: "road.local",
            elementType: "geometry",
            stylers: [ {
                color: "#000000"
            }, {
                lightness: 16
            } ]
        }, {
            featureType: "transit",
            elementType: "geometry",
            stylers: [ {
                color: "#000000"
            }, {
                lightness: 19
            } ]
        }, {
            featureType: "water",
            elementType: "geometry",
            stylers: [ {
                color: "#000000"
            }, {
                lightness: 17
            } ]
        } ],
        ultraLight: [ {
            featureType: "water",
            elementType: "geometry",
            stylers: [ {
                color: "#e9e9e9"
            }, {
                lightness: 17
            } ]
        }, {
            featureType: "landscape",
            elementType: "geometry",
            stylers: [ {
                color: "#f5f5f5"
            }, {
                lightness: 20
            } ]
        }, {
            featureType: "road.highway",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#ffffff"
            }, {
                lightness: 17
            } ]
        }, {
            featureType: "road.highway",
            elementType: "geometry.stroke",
            stylers: [ {
                color: "#ffffff"
            }, {
                lightness: 29
            }, {
                weight: .2
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "geometry",
            stylers: [ {
                color: "#ffffff"
            }, {
                lightness: 18
            } ]
        }, {
            featureType: "road.local",
            elementType: "geometry",
            stylers: [ {
                color: "#ffffff"
            }, {
                lightness: 16
            } ]
        }, {
            featureType: "poi",
            elementType: "geometry",
            stylers: [ {
                color: "#f5f5f5"
            }, {
                lightness: 21
            } ]
        }, {
            featureType: "poi.park",
            elementType: "geometry",
            stylers: [ {
                color: "#dedede"
            }, {
                lightness: 21
            } ]
        }, {
            elementType: "labels.text.stroke",
            stylers: [ {
                visibility: "on"
            }, {
                color: "#ffffff"
            }, {
                lightness: 16
            } ]
        }, {
            elementType: "labels.text.fill",
            stylers: [ {
                saturation: 36
            }, {
                color: "#333333"
            }, {
                lightness: 40
            } ]
        }, {
            elementType: "labels.icon",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "transit",
            elementType: "geometry",
            stylers: [ {
                color: "#f2f2f2"
            }, {
                lightness: 19
            } ]
        }, {
            featureType: "administrative",
            elementType: "geometry.fill",
            stylers: [ {
                color: "#fefefe"
            }, {
                lightness: 20
            } ]
        }, {
            featureType: "administrative",
            elementType: "geometry.stroke",
            stylers: [ {
                color: "#fefefe"
            }, {
                lightness: 17
            }, {
                weight: 1.2
            } ]
        } ],
        pastel: [ {
            featureType: "administrative",
            elementType: "labels.text.fill",
            stylers: [ {
                color: "#444444"
            } ]
        }, {
            featureType: "administrative.country",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "administrative.province",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            }, {
                saturation: "0"
            }, {
                lightness: "0"
            } ]
        }, {
            featureType: "administrative.locality",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "administrative.neighborhood",
            elementType: "all",
            stylers: [ {
                visibility: "simplified"
            } ]
        }, {
            featureType: "landscape",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            }, {
                color: "#ffffff"
            } ]
        }, {
            featureType: "landscape",
            elementType: "labels",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "landscape.man_made",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "landscape.natural",
            elementType: "geometry.fill",
            stylers: [ {
                saturation: "17"
            }, {
                visibility: "on"
            } ]
        }, {
            featureType: "landscape.natural",
            elementType: "labels",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "poi",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "poi.park",
            elementType: "all",
            stylers: [ {
                visibility: "on"
            }, {
                hue: "#91ff00"
            }, {
                lightness: "56"
            }, {
                saturation: "26"
            } ]
        }, {
            featureType: "road",
            elementType: "all",
            stylers: [ {
                saturation: -100
            }, {
                lightness: 45
            } ]
        }, {
            featureType: "road.highway",
            elementType: "all",
            stylers: [ {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road.highway",
            elementType: "geometry",
            stylers: [ {
                color: "#f5d2c4"
            } ]
        }, {
            featureType: "road.highway",
            elementType: "labels",
            stylers: [ {
                visibility: "on"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "all",
            stylers: [ {
                visibility: "on"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "geometry.fill",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "geometry.stroke",
            stylers: [ {
                visibility: "on"
            }, {
                color: "#f5d2c4"
            }, {
                lightness: "60"
            } ]
        }, {
            featureType: "road.arterial",
            elementType: "labels",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "road.local",
            elementType: "all",
            stylers: [ {
                visibility: "on"
            } ]
        }, {
            featureType: "road.local",
            elementType: "geometry",
            stylers: [ {
                color: "#f3f3f3"
            }, {
                visibility: "simplified"
            } ]
        }, {
            featureType: "road.local",
            elementType: "labels",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "transit",
            elementType: "all",
            stylers: [ {
                visibility: "off"
            } ]
        }, {
            featureType: "water",
            elementType: "all",
            stylers: [ {
                color: "#e9f6f8"
            }, {
                visibility: "on"
            } ]
        } ]
    };
    Maps.prototype = {
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
            this.options = $.extend(true, {}, Maps.defaults, {
                map: {
                    center: new google.maps.LatLng(-37.823323, 145.04612),
                    zoom: 14,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    panControl: false,
                    zoomControl: true,
                    mapTypeControl: false,
                    streetViewControl: false,
                    scrollwheel: false
                }
            }, options);
            return this;
        },
        build: function() {
            var opts = this.options, self = this, container = this.el, contentString = container.next('.marker-contents'), infowindow = null, mapOpts = opts.map;
            mapOpts.styles = Maps.styles[opts.style];
            var map = new google.maps.Map(container.get(0), mapOpts);
            map.zoom = this.options.zoom || 14;
            if (contentString.length) {
                infowindow = new google.maps.InfoWindow({
                    content: contentString.get(0),
                    maxWidth: 1170
                });
            }
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                address: opts.address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var result = results[0].geometry.location, latitude = results[0].geometry.location.lat(), longitude = results[0].geometry.location.lng(), contentWidth, contentHeight;
                    if (self.options.markers == null) {
                        if (self.options.marker_option == 'image') {
                            var marker = new google.maps.Marker({
                                position: result,
                                map: map,
                                visible: true,
                                icon: opts.marker,
                                zIndex: 9999999
                            });
                        } else {
                            overlay = new CustomMarker(result, map, self.options.className);
                        }
                    } else {
                        for (i = 0; i < self.options.markers.length; i++) {
                            if (self.options.marker_option == 'image') {
                                var marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(self.options.markers[i][0], self.options.markers[i][1]),
                                    map: map,
                                    visible: true,
                                    icon: opts.marker,
                                    zIndex: 9999999
                                });
                            } else {
                                overlay = new CustomMarker(new google.maps.LatLng(self.options.markers[i][0], self.options.markers[i][1]), map, self.options.className);
                            }
                        }
                    }
                    if (!contentString.length) {
                        map.setCenter(new google.maps.LatLng(latitude, longitude));
                    } else {
                        contentWidth = contentString.width(), contentHeight = contentString.height();
                        map.panBy(-(contentWidth / 2), contentHeight);
                    }
                    if (container.parent().hasClass('contents-style2') || container.parent().hasClass('contents-style3')) {
                        return;
                    }
                    if (contentString.length) {
                        infowindow.open(map, marker);
                    }
                }
            });
            return this;
        }
    };
    $.fn.rellaMaps = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Maps(el, opts);
            }
        });
    };
    $(window).on('load', function() {
        $('[data-plugin-map]').rellaMaps();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__lightbox';
    var Lightbox = function(el, options) {
        return this.init(el, options);
    };
    Lightbox.defaults = {
        closeBtnInside: false,
        removalDelay: 500,
        mainClass: 'mfp-fade'
    };
    Lightbox.prototype = {
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
            this.options = $.extend(true, {}, Lightbox.defaults, options);
            this.options.type = 'video' === this.el.data('type') ? 'iframe' : this.el.data('type');
            return this;
        },
        build: function() {
            this.el.magnificPopup(this.options);
            return this;
        }
    };
    $.fn.rellaLightbox = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Lightbox(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('.lightbox-link').rellaLightbox();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__lettering';
    var Lettering = function(el, options) {
        return this.init(el, options);
    };
    Lettering.defaults = {
        splitter: 'init',
        animateOnAppear: false,
        animateOnParentHover: false,
        animateDelay: 0,
        animationType: null,
        parent: null,
        element: null,
        staggerDelay: .05
    };
    Lettering.prototype = {
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
            this.options = $.extend(true, {}, Lettering.defaults, options);
            if (this.options.parent === null || typeof this.options.parent === typeof undefined) {
                this.options.parent = $(this.el).parent();
            }
            return this;
        },
        build: function() {
            var self = this, letteringSelector = self.el;
            if (self.options.element != null) {
                letteringSelector = $(self.options.element, self.el);
            }
            if ($.isFunction($.fn.lettering)) {
                letteringSelector.lettering(self.options.splitter).addClass('lettering-applied');
            } else {
                console.warn(' Lettering.js is needed ');
            }
            self.el.addClass('lettering-applied');
            $(self.el).find('span').find('span').each(function() {
                var $this = $(this), content = $this.text();
                if (content == '&nbsp;' || content == ' ') {
                    $this.parent().css('display', 'inline');
                    $this.css('display', 'inline');
                }
            });
            if (self.options.animateOnAppear) {
                var $this = $(this.el), animateDelay = self.options.animateDelay, animationType = self.options.animationType, staggerDelay = self.options.staggerDelay;
                if ($.isFunction($.fn.appear)) {
                    self.el.appear(function() {
                        if (animationType !== "typewriter") {
                            function completeFunc(tween) {
                                $this.addClass('tweening-done');
                                letteringSelector.addClass('tweening-done');
                            }
                            function onEachStart() {
                                $(this.target).parent().addClass('moving-started');
                            }
                            function onEachComplete() {
                                $(this.target).parent().addClass('moving-done');
                            }
                            if ($(this).parent().hasClass('left') || $(this).parent().hasClass('align-left') || $(this).parent().hasClass('text-left')) {
                                TweenMax.staggerTo($($(this).find('span').find('span')).get().reverse(), .2, {
                                    x: '0%',
                                    delay: animateDelay,
                                    ease: Power2.easeOut,
                                    onStart: onEachStart,
                                    onComplete: onEachComplete
                                }, staggerDelay, completeFunc);
                            } else {
                                TweenMax.staggerTo($(this).find('span').find('span'), .2, {
                                    x: '0%',
                                    delay: animateDelay,
                                    ease: Power2.easeOut,
                                    onStart: onEachStart,
                                    onComplete: onEachComplete
                                }, staggerDelay, completeFunc);
                            }
                        } else {
                            function completeFunc(tween) {
                                $this.addClass('tweening-done');
                                letteringSelector.addClass('tweening-done');
                            }
                            function onEachStart() {
                                $(this.target).parent().addClass('moving-started');
                            }
                            function onEachComplete() {
                                $(this.target).parent().addClass('moving-done');
                            }
                            if ($(this).parent().hasClass('left') || $(this).parent().hasClass('align-left') || $(this).parent().hasClass('text-left')) {
                                TweenMax.staggerFromTo($($(this).find('span').find('span')).get().reverse(), .2, {
                                    x: '0%',
                                    visibility: 'hidden'
                                }, {
                                    x: '0%',
                                    visibility: 'visible',
                                    delay: animateDelay,
                                    ease: Power2.easeOut,
                                    onStart: onEachStart,
                                    onComplete: onEachComplete
                                }, staggerDelay, completeFunc);
                            } else {
                                TweenMax.staggerFromTo($(this).find('span').find('span'), .2, {
                                    x: '0%',
                                    visibility: 'hidden'
                                }, {
                                    x: '0%',
                                    visibility: 'visible',
                                    delay: animateDelay,
                                    ease: Power2.easeOut,
                                    onStart: onEachStart,
                                    onComplete: onEachComplete
                                }, staggerDelay, completeFunc);
                            }
                        }
                    });
                } else {
                    console.warn(' jQuery appear is needed ');
                }
            }
            if (self.options.animateOnParentHover) {
                var animateDelay = self.options.animateDelay;
                self.el.parents(self.options.parent).on('mouseenter', function() {
                    TweenMax.set($(this).find('[data-lettering]').find('span').find('span'), {
                        x: '-110%'
                    });
                    TweenMax.staggerFromTo($(this).find('[data-lettering]').find('span').find('span'), .4, {
                        x: '-110%'
                    }, {
                        x: '0%',
                        delay: animateDelay,
                        ease: Power3.easeOut
                    }, staggerDelay);
                }).on('mouseleave', function() {
                    TweenMax.set($(this).find('[data-lettering]').find('span').find('span'), {
                        x: '-110%'
                    });
                });
            }
            return this;
        }
    };
    $.fn.rellaLettering = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Lettering(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-lettering]').rellaLettering();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__panr';
    var Panr = function(el, options) {
        return this.init(el, options);
    };
    Panr.defaults = {
        sensitivity: 15,
        scale: false,
        scaleOnHover: true,
        scaleTo: 1.08,
        scaleDuration: .25,
        panDuration: 1.25,
        panY: true,
        panX: true,
        resetPanOnMouseLeave: true,
        moveTarget: null
    };
    Panr.prototype = {
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
            this.options = $.extend(true, {}, Panr.defaults, options);
            return this;
        },
        build: function() {
            this.el.panr(this.options);
            return this;
        }
    };
    $.fn.rellaPanr = function(settings) {
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
                    return new Panr(el, opts);
                }
            });
        });
    };
    $(document).ready(function() {
        $('[data-panr]').rellaPanr();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__contact';
    var Contact = function(el, options) {
        return this.init(el, options);
    };
    Contact.defaults = {};
    Contact.prototype = {
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
            this.options = $.extend(true, {}, Contact.defaults, options);
            return this;
        },
        build: function() {
            $(this.el).each(function() {
                var $this = $(this);
                $this.find('input, textarea').on('focus', function() {
                    $this.addClass('input-focused');
                }).on('blur', function() {
                    var input = $(this);
                    $this.removeClass('input-focused');
                    if (input.val() !== '') {
                        $this.addClass('input-filled');
                    } else {
                        $this.removeClass('input-filled');
                    }
                });
            });
            return this;
        }
    };
    $.fn.rellaContact = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Contact(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('.wpcf7-form-control-wrap, .form-control-wrap').rellaContact();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__adaptiveBG';
    var AdaptiveBG = function(el, options) {
        return this.init(el, options);
    };
    AdaptiveBG.defaults = {};
    AdaptiveBG.prototype = {
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
            this.options = $.extend(true, {}, AdaptiveBG.defaults, options);
            return this;
        },
        build: function() {
            var self = this;
            if ($(self.el).hasClass('progressive__img')) {
                return;
            }
            $(self.el).appear(function(el) {
                $(el.target).parent().addClass('is-visible');
                $(el.target).imagesLoaded(function() {
                    jQuery.adaptiveBackground.run();
                    $(el.target).on('ab-color-found', function(element) {});
                });
            });
            return this;
        }
    };
    $.fn.rellaAdaptiveBG = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new AdaptiveBG(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-adaptive-background]').rellaAdaptiveBG();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__countdown';
    var Countdown = function(el, options) {
        return this.init(el, options);
    };
    Countdown.defaults = {};
    Countdown.prototype = {
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
            this.options = $.extend(true, {}, Countdown.defaults, options);
            return this;
        },
        build: function() {
            var el = this.el, options = this.options, targetTime = new Date(options.until);
            $(el).countdown({
                until: targetTime,
                padZeroes: true
            });
            return this;
        }
    };
    $.fn.rellaCountdown = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Countdown(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-plugin-countdown]').rellaCountdown();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__typed';
    var Typed = function(el, options) {
        return this.init(el, options);
    };
    Typed.defaults = {
        loop: true,
        backDelay: 1200,
        typeSpeed: 100
    };
    Typed.prototype = {
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
            this.options = $.extend(true, {}, Typed.defaults, options);
            this.options.stringsElement = this.el.find('.typed-strings');
            return this;
        },
        build: function() {
            this.el.addClass('typed-activated');
            this.el.find('.typed-element').typed(this.options);
            return this;
        }
    };
    $.fn.rellaTyped = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Typed(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-plugin-typed]').rellaTyped();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__testimonial_slider';
    var TestimonialSlider = function(el, options) {
        return this.init(el, options);
    };
    TestimonialSlider.defaults = {
        height: 530
    };
    TestimonialSlider.prototype = {
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
            this.options = $.extend(true, {}, TestimonialSlider.defaults, options);
            return this;
        },
        build: function() {
            this.relist();
            this.reverse();
            this.slide();
            this.drag();
        },
        drag: function() {
            var self = this;
            var transform = Modernizr.prefixedCSS('transform');
            $(".testimonial-slider-pagination", self.el).draggable({
                axis: "y",
                containment: 'parent',
                start: function(event, ui) {
                    start = ui.position.top;
                    $(this).addClass("noclick").removeClass('back-to-center');
                },
                drag: function(event, ui) {
                    var stop = ui.position.top, translateVal = stop - ui.originalPosition.top;
                    $(this).css(transform, 'translateY(' + translateVal + 'px)');
                },
                stop: function(event, ui) {
                    var stop = ui.position.top;
                    if (start > stop) {
                        self.slideItem("prev");
                    } else {
                        self.slideItem("next");
                    }
                    $(this).css('top', "");
                    $(this).one('bsTransitionEnd', function() {
                        $(this).addClass('back-to-center').attr('style', '');
                    }).emulateTransitionEnd(0);
                }
            });
        },
        relist: function() {
            var self = this;
            $(".testimonial-item", this.el).each(function() {
                var quote = $(".testimonial-quote", $(this)).html();
                var image = $(".testimonial-image", $(this)).html();
                var imageURL = $(".testimonial-image img", $(this)).attr("src");
                $(".testimonial-slider-opposite .item-left ul", self.el).append("<li><div class='testimonial-box'>" + quote + "</div></li>");
                $(".testimonial-slider-opposite .item-right ul", self.el).append("<li style='background-image: url(" + imageURL + ");'>" + image + "</li>");
            });
            this.el.attr("data-page", 0);
            self.activeItem();
            return this;
        },
        activeItem: function() {
            $(".testimonial-slider-opposite .item-left ul li:first-child", self.el).addClass("active");
            $(".testimonial-slider-opposite .item-right ul li:last-child", self.el).addClass("active");
        },
        reverse: function() {
            var self = this, transform = Modernizr.prefixedCSS('transform');
            var height = parseInt($(".testimonial-slider-opposite .item-right ul", self.el).css("height")) - parseInt($(".testimonial-slider-opposite .item-right").css("height"));
            $(".testimonial-slider-opposite .item-right ul", self.el).css(transform, 'translateY(' + -1 * height + 'px)');
            var total = $(".testimonial-slider-temporary .testimonial-item", self.el).length;
            $(".pages .all", self.el).text(total);
            for (var i = 0; i < total; i++) {
                $(".pages .actives ul", self.el).append("<li>" + (i + 1) + "</li>");
            }
            return this;
        },
        slideItem: function(direction) {
            var self = this, el = this.el, transform = Modernizr.prefixedCSS('transform');
            var height = parseInt($(".testimonial-slider-opposite .item-right", self.el).css("height"));
            var page = parseInt(el.attr("data-page"));
            var total = $(".testimonial-slider-temporary .testimonial-item", self.el).length;
            var maxHeight = height * (total - 1);
            var pageHeight = parseInt($(".testimonial-slider-pagination .actives", self.el).css("line-height"));
            if (direction === 'next') {
                var newLeftVal = height * -1 * (page + 1), newRightVal = -1 * maxHeight + height * (page + 1), newPageTop = pageHeight * -1 * (page + 1);
                if (total > page + 1) {
                    $(".testimonial-slider-opposite .item-left ul", self.el).css(transform, 'translateY(' + newLeftVal + 'px)');
                    $(".testimonial-slider-opposite .item-right ul", self.el).css(transform, 'translateY(' + newRightVal + 'px)');
                    el.attr("data-page", page + 1);
                    var rightItem = total - 1 - parseInt(self.el.attr("data-page"));
                    $(".testimonial-slider-opposite .item-left ul li", self.el).removeClass("active");
                    $(".testimonial-slider-opposite .item-left ul li:eq(" + self.el.attr("data-page") + ")", self.el).addClass("active");
                    $(".testimonial-slider-opposite .item-left ul li", self.el).removeClass("coming-from-top").removeClass("coming-from-bottom");
                    $(".testimonial-slider-opposite .item-left ul li:eq(" + self.el.attr("data-page") + ")", self.el).addClass("coming-from-bottom");
                    $(".testimonial-slider-opposite .item-right ul li", self.el).removeClass("active");
                    $(".testimonial-slider-opposite .item-right ul li:eq(" + rightItem + ")", self.el).addClass("active");
                    $(".testimonial-slider-opposite .item-right ul li", self.el).removeClass("coming-from-top").removeClass("coming-from-bottom");
                    $(".testimonial-slider-opposite .item-right ul li:eq(" + rightItem + ")", self.el).addClass("coming-from-top");
                    $(".testimonial-slider-pagination .pages ul", self.el).css(transform, 'translateY(' + newPageTop + 'px)');
                }
            } else {
                var newLeftVal = height * -1 * (page - 1), newRightVal = -1 * maxHeight + height * (page - 1), newPageTop = pageHeight * -1 * (page - 1);
                if (0 <= page - 1) {
                    $(".testimonial-slider-opposite .item-left ul", self.el).css(transform, 'translateY(' + newLeftVal + 'px)');
                    $(".testimonial-slider-opposite .item-right ul", self.el).css(transform, 'translateY(' + newRightVal + 'px)');
                    self.el.attr("data-page", page - 1);
                    var rightItem = total - 1 - parseInt(self.el.attr("data-page"));
                    $(".testimonial-slider-opposite .item-left ul li", self.el).removeClass("active");
                    $(".testimonial-slider-opposite .item-left ul li:eq(" + self.el.attr("data-page") + ")", self.el).addClass("active");
                    $(".testimonial-slider-opposite .item-left ul li", self.el).removeClass("coming-from-top").removeClass("coming-from-bottom");
                    $(".testimonial-slider-opposite .item-left ul li:eq(" + self.el.attr("data-page") + ")", self.el).addClass("coming-from-top");
                    $(".testimonial-slider-opposite .item-right ul li", self.el).removeClass("active");
                    $(".testimonial-slider-opposite .item-right ul li:eq(" + rightItem + ")", self.el).addClass("active");
                    $(".testimonial-slider-opposite .item-right ul li", self.el).removeClass("coming-from-top").removeClass("coming-from-bottom");
                    $(".testimonial-slider-opposite .item-right ul li:eq(" + rightItem + ")", self.el).addClass("coming-from-bottom");
                    $(".testimonial-slider-pagination .pages ul", self.el).css(transform, 'translateY(' + newPageTop + 'px)');
                }
            }
            $(".testimonial-slider-pagination .pages .active", self.el).text(parseInt(el.attr("data-page")) + 1);
        },
        slide: function() {
            var el = this.el, self = this;
            $(".testimonial-slider-pagination a", el).click(function(e) {
                e.preventDefault(0);
                var direction = $(this).attr("class");
                self.slideItem(direction);
            });
            self.el.hammer().on("swiperight", function(e) {
                var direction = "next";
                self.slideItem(direction);
            });
            self.el.hammer().on("swipeleft", function(e) {
                var direction = "prev";
                self.slideItem(direction);
            });
            return this;
        }
    };
    $.fn.rellaTestimonialSlider = function(settings) {
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
                    return new TestimonialSlider(el, opts);
                }
            });
        });
    };
    $(document).ready(function() {
        $('.testimonial-slider').rellaTestimonialSlider();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__resolve';
    var Resolve = function(el, options) {
        return this.init(el, options);
    };
    Resolve.defaults = {
        seperator: "words",
        start: .12,
        end: .52,
        fixed: 6,
        refreshInterval: 50,
        element: "h2",
        startDelay: 0
    };
    Resolve.prototype = {
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
            this.options = $.extend(true, {}, Resolve.defaults, options);
            return this;
        },
        build: function() {
            this.effect();
            this.checkResolve();
            return this;
        },
        effect: function() {
            var self = this, elem, splitText, selector = self.el.find(self.options.element), seperator = self.options.seperator, transitionDelay = Modernizr.prefixedCSS('transition-delay');
            $(selector, self.el).each(function() {
                if (!$(this).hasClass("subtitle")) {
                    elem = $(this);
                }
            });
            if (elem.children('.unit').length) {
                return;
            }
            splitText = new SplitText(elem, {
                type: seperator
            });
            elem.addClass('perspective').children('div').addClass('unit');
            elem.children('div').each(function() {
                var tDelay = (Math.random() * (self.options.end - self.options.start) + self.options.start).toFixed(self.options.fixed);
                $(this).css(transitionDelay, tDelay + "s");
            });
            return self;
        },
        checkResolve: function() {
            var self = this, timeout;
            this.el.on('inview', function(event, isInView) {
                if (isInView) {
                    timeout = setTimeout(function() {
                        self.el.addClass("is-visible");
                    }, self.options.startDelay);
                } else {
                    self.el.removeClass("is-visible");
                    clearTimeout(timeout);
                }
            });
            return this;
        }
    };
    $.fn.rellaResolve = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName).build();
            } else {
                var pluginOptions = el.data('plugin-resolve-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new Resolve(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-plugin-resolve]').rellaResolve();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__FillIn';
    var FillIn = function(el, options) {
        return this.init(el, options);
    };
    FillIn.defaults = {
        element: "p"
    };
    FillIn.prototype = {
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
            this.options = $.extend(true, {}, FillIn.defaults, options);
            return this;
        },
        build: function() {
            this.effect();
            return this;
        },
        effect: function() {
            var element = this.el.find(this.options.element).addClass('perspective');
            if (!element.length) {
                return;
            }
            var splitText = new SplitText(element, {
                type: "lines,chars"
            }), lines = $(splitText.lines).addClass('line'), startDelay = 0;
            element.addClass('element-original');
            element.wrapAll('<div class="fillin-wrap" />');
            this.el.addClass('splitting-applied');
            lines.each(function() {
                var $this = $(this), chars = $this.children('div'), timeline = new TimelineMax(), startDelay = $this.index() / 6;
                timeline = timeline.staggerTo(chars, .05, {
                    opacity: 1,
                    delay: startDelay,
                    ease: Expo.easeOut
                }, .01);
                timeline.restart().pause();
                element.on('inview', function(event, isInView) {
                    if (isInView) {
                        timeline.restart().play();
                    } else {
                        timeline.restart().pause();
                    }
                });
            });
            return this;
        }
    };
    $.fn.RellaFillIn = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName);
            } else {
                var pluginOptions = el.data('plugin-fillin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new FillIn(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-plugin-fillIn]').RellaFillIn();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__TextEffect';
    var TextEffect = function(el, options) {
        return this.init(el, options);
    };
    TextEffect.defaults = {
        seperator: "chars",
        element: "h2",
        autoplay: false,
        delay: 2e3
    };
    TextEffect.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.timeout;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, TextEffect.defaults, options);
            return this;
        },
        build: function() {
            this.hide();
            this.splitString();
            this.onHover();
            return this;
        },
        hide: function() {
            var self = this;
            $(".typed-strings span", $(self.options.element, self.el)).not(":first-child").hide();
        },
        splitString: function() {
            var self = this;
            if (self.options.seperator == "chars") {
                $(".typed-strings span", $(self.options.element, self.el)).each(function() {
                    var element = $(this), string = element.text(), splittedString = string.split("");
                    element.text("");
                    for (var i = 0; i < splittedString.length; i++) {
                        $('<div/>', {
                            text: splittedString[i],
                            css: {
                                display: 'inline',
                                position: 'relative'
                            }
                        }).appendTo(element);
                    }
                });
            }
        },
        effect: function(index) {
            var self = this;
            var selector = $(".typed-strings span", $(self.options.element, self.el)), totalItem = selector.length;
            if (index == totalItem) {
                index = 0;
            }
            $(".typed-strings span", $(self.options.element, self.el)).not(":eq(" + index + ")").hide();
            $(".typed-strings span:eq(" + index + ")", $(self.options.element, self.el)).show();
            var string = $(".typed-strings span:eq(" + index + ")", self.el);
            $(".typed-strings span:eq(" + index + ") div", self.el).each(function() {
                $(this).css({
                    left: "-5px",
                    opacity: 0
                });
                $(this).stop().animate({
                    left: 0,
                    opacity: 1
                }, 500);
            });
            self.timeout = setTimeout(function() {
                self.effect(index + 1);
            }, self.options.delay);
        },
        onHover: function() {
            var self = this;
            if (self.options.autoplay) {
                self.effect(0);
            } else {
                $(self.el).hover(function() {
                    clearTimeout(self.timeout);
                    self.effect(0);
                }, function() {
                    clearTimeout(self.timeout);
                });
            }
        }
    };
    $.fn.rellaTextEffect = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName).build();
            } else {
                var pluginOptions = el.data('plugin-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new TextEffect(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-plugin-texteffect]').rellaTextEffect();
    });
}).apply(this, [ jQuery ]);

(function($) {
    var instanceName = '__TextSlide';
    var TextSlide = function(el, options) {
        return this.init(el, options);
    };
    TextSlide.defaults = {
        element: "h2",
        autoplay: true,
        delay: 2e3
    };
    TextSlide.prototype = {
        init: function(el, options) {
            if (el.data(instanceName)) {
                return this;
            }
            this.el = el;
            this.timeoutTextSlide;
            this.setOptions(options).build();
            return this;
        },
        setOptions: function(options) {
            this.el.data(instanceName, this);
            this.options = $.extend(true, {}, TextSlide.defaults, options);
            return this;
        },
        build: function() {
            this.order();
            this.onHover();
            return this;
        },
        order: function() {
            var self = this;
            var height = $(self.options.element, self.el).height(), i = 0, transform = Modernizr.prefixedCSS('transform');
            $(".typed-keywords span", $(self.options.element, self.el)).each(function() {
                if (i == 0) {
                    $(this).css(transform, 'translateY(0px)');
                } else {
                    $(this).css(transform, 'translateY(' + height * 1 + 'px)');
                }
                i++;
            });
        },
        effect: function() {
            var self = this;
            var selector = $(".typed-keywords span", $(self.options.element, self.el)), totalItem = selector.length, height = $(self.options.element, self.el).height(), prevIndex = $(".typed-keywords span.active", self.el).index();
            var transform = Modernizr.prefixedCSS('transform');
            if (prevIndex == totalItem - 1) {
                index = 0;
            } else {
                index = prevIndex + 1;
            }
            $(".typed-keywords span", self.el).not(":eq(" + index + ")").not(":eq(" + prevIndex + ")").css("opacity", 0);
            $(".typed-keywords span", self.el).not(":eq(" + index + ")").not(":eq(" + prevIndex + ")").css(transform, 'translateY(' + height + 'px)');
            $(".typed-keywords span:eq(" + prevIndex + ")", self.el).css("opacity", 0);
            $(".typed-keywords span:eq(" + prevIndex + ")", self.el).css(transform, 'translateY(' + height * -1 + 'px)');
            $(".typed-keywords span:eq(" + index + ")", self.el).css("opacity", 1);
            $(".typed-keywords span:eq(" + index + ")", self.el).css(transform, 'translateY(0px)');
            $(".typed-keywords span", self.el).removeClass("active");
            $(".typed-keywords span:eq(" + index + ")", self.el).addClass("active");
            self.timeoutTextSlide = setTimeout(function() {
                self.effect(index + 1);
            }, self.options.delay);
        },
        onHover: function() {
            var self = this;
            if (self.options.autoplay) {
                self.effect();
            } else {
                $(self.el).hover(function() {
                    clearTimeout(self.timeoutTextSlide);
                    self.effect();
                }, function() {
                    clearTimeout(self.timeoutTextSlide);
                });
            }
        }
    };
    $.fn.rellaTextSlide = function(settings) {
        return this.map(function() {
            var el = $(this);
            if (el.data(instanceName)) {
                return el.data(instanceName).build();
            } else {
                var pluginOptions = el.data('plugin-textslide-options'), opts;
                if (pluginOptions) {
                    opts = $.extend(true, {}, settings, pluginOptions);
                }
                return new TextSlide(el, opts);
            }
        });
    };
    $(document).ready(function() {
        $('[data-plugin-textslide]').rellaTextSlide();
    });
}).apply(this, [ jQuery ]);