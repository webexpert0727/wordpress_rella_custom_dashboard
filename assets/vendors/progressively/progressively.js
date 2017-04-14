/*!
* progressively 1.0.0
* https://github.com/thinker3197/progressively
* @license MIT licensed
*
* Copyright (C) 2016 Ashish
*/

;
(function(root, factory) {
	if (typeof define === 'function' && define.amd) {
		define(function() {
			return factory(root);
		});
	} else if (typeof exports === 'object') {
		module.exports = factory;
	} else {
		root.progressively = factory(root);
	}
})(this, function(root) {

	'use strict';

	var progressively = {};

	var defaults, poll, onLoad, inodes;

	onLoad = function() {};

	function extend(primaryObject, secondaryObject) {
		var o = {};
		for (var prop in primaryObject) {
			o[prop] = secondaryObject.hasOwnProperty(prop) ? secondaryObject[prop] : primaryObject[prop];
		}
		return o;
	};

	function isHidden(el) {
		return (el.offsetParent === null);
	};

	function inView(el, view) {
		if (isHidden(el)) {
			return false;
		}
		// get element and scroll positions with plain js
		var box = el.getBoundingClientRect();

		var pageTop 		= (document.body.scrollTop - defaults.offset),
			pageBottom 		= (document.body.scrollTop + window.innerHeight + defaults.offset),
			elementTop 		= box.top + document.body.scrollTop,
			elementBottom = box.bottom + document.body.scrollTop,
			elementLeft 	= (box.left + defaults.offset),
			elementRight	= (box.right - defaults.offset);

		var status = (
			( elementTop <= pageBottom ) &&
			( elementBottom >= pageTop ) &&
			elementLeft >= 0 &&
			elementRight <= ( window.innerWidth || box.width )
		);

		if(status) {
			return true;
		}else {
			return false;
		}

	};

	function is_high_resolution_screen() {
		return window.devicePixelRatio > 1;
	}

	function loadImage(el) {
		setTimeout(function() {
			var img = new Image();

			img.onload = function() {
				el.classList.remove('progressive--not-loaded');
				el.classList.add('progressive--is-loaded');
				el.src = this.src;

				onLoad(el);
			};

			if ( ( typeof el.getAttribute("data-rjs") !== typeof undefined || el.getAttribute("data-rjs") !== null ) && is_high_resolution_screen() ) {

				img.src = el.getAttribute("data-rjs");

			} else {

				img.src = el.getAttribute("data-progressive");

			}


		}, defaults.delay);
	};

	function listen() {
		if (!!poll)
		return;
		clearTimeout(poll);
		poll = setTimeout(function() {
			progressively.check();
			progressively.render();
			poll = null;
		}, defaults.throttle);
	}
	/*
	* default settings
	*/

	defaults = {
		throttle: 300, //appropriate value, don't change unless intended
		delay: 100,
		offset: 500,
		onLoadComplete: function() {},
		onLoad: function() {}
	};

	progressively.init = function(options) {
		options = options || {};

		defaults = extend(defaults, options);

		onLoad = defaults.onLoad || onLoad;

		inodes = [].slice.call(document.querySelectorAll('.progressive__img'));


		progressively.render();

		if (document.addEventListener) {
			root.addEventListener('scroll', listen, false);
			root.addEventListener('load', listen, false);
		} else {
			root.attachEvent('onscroll', listen);
			root.attachEvent('onload', listen);
		}
	};

	progressively.render = function() {
		var elem;

		for (var i = inodes.length - 1; i >= 0; --i) {
			elem = inodes[i];

			if (inView(elem) && elem.classList.contains('progressive--not-loaded')) {
				loadImage(elem);
				inodes.splice(i, 1);
			}
		}

		this.check();
	};

	progressively.check = function() {
		if (!inodes.length) {
			defaults.onLoadComplete();
			this.drop();
		}
	}

	progressively.drop = function() {
		if (document.removeEventListener) {
			root.removeEventListener('scroll', listen);
		} else {
			root.detachEvent('onscroll', listen);
		}
		clearTimeout(poll);
	};

	return progressively;
});
