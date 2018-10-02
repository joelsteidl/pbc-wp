/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

	var BeClients = __webpack_require__(1),
	    BeImageSlider = __webpack_require__(5),
	    BeTestimonils = __webpack_require__(7),
	    BeContentSlider = __webpack_require__(9),
	    BeIconCard = __webpack_require__(11),
	    BeProcess = __webpack_require__(12),
	    BeServices = __webpack_require__(14),
	    BeSkills = __webpack_require__(16),
	    BeSkill = __webpack_require__(17),
	    BeSpecialHeading1 = __webpack_require__(18),
	    BeSpecialHeading2 = __webpack_require__(19),
	    BeSpecialHeading3 = __webpack_require__(20),
	    BeSpecialHeading4 = __webpack_require__(21),
	    BeSpecialHeading5 = __webpack_require__(22),
	    BeSpecialHeading6 = __webpack_require__(23),
	    BeSpecialSubTitle = __webpack_require__(24),
	    BeMenuCard = __webpack_require__(25),
	    BeTabs = __webpack_require__(26),
	    BeAccordion = __webpack_require__(30),
	    BeAnimateIconsStyle1 = __webpack_require__(32),
	    BeAnimateIconsStyle2 = __webpack_require__(34),
	    BeTeam = __webpack_require__(36),
	    BeSVGIcon = __webpack_require__(37),
	    BeAnimatedLink = __webpack_require__(48);
	tatsuConfig.clients = BeClients;
	tatsuConfig.flex_slider = BeImageSlider;
	tatsuConfig.testimonials = BeTestimonils;
	tatsuConfig.content_slides = BeContentSlider;
	tatsuConfig.icon_card = BeIconCard;
	tatsuConfig.process_style1 = BeProcess;
	tatsuConfig.services = BeServices;
	tatsuConfig.skills = BeSkills;
	tatsuConfig.special_heading = BeSpecialHeading1;
	tatsuConfig.special_heading2 = BeSpecialHeading2;
	tatsuConfig.special_heading3 = BeSpecialHeading3;
	tatsuConfig.special_heading4 = BeSpecialHeading4;
	tatsuConfig.special_heading5 = BeSpecialHeading5;
	tatsuConfig.be_special_heading6 = BeSpecialHeading6;
	tatsuConfig.special_sub_title = BeSpecialSubTitle;
	tatsuConfig.skill = BeSkill;
	tatsuConfig.menu_card = BeMenuCard;
	tatsuConfig.tabs = BeTabs;
	tatsuConfig.accordion = BeAccordion;
	tatsuConfig.animate_icons_style1 = BeAnimateIconsStyle1;
	tatsuConfig.animate_icons_style2 = BeAnimateIconsStyle2;
	tatsuConfig.team = BeTeam;
	tatsuConfig.oshine_svg_icon = BeSVGIcon;
	tatsuConfig.oshine_animated_link = BeAnimatedLink;

/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    findDOMNode = ReactDOM.findDOMNode,
	    parseValue = __webpack_require__(3),
	    Client = __webpack_require__(4);
	var Clients = React.createClass({
		displayName: 'Clients',


		getInitialState: function () {

			return {
				trigger: false
			};
		},

		componentWillReceiveProps: function (nextProps) {

			if (!Immutable.is(this.props.module, nextProps.module)) {
				var height = jQuery(findDOMNode(this)).outerHeight();
				jQuery(findDOMNode(this)).css({ 'opacity': '0', 'height': height, 'overflow': 'hidden' });
				setTimeout(function () {
					var data = {
						type: 'jstrigger',
						moduleName: 'clients',
						shouldUpdate: true
					},
					    jsonData = JSON.stringify(data);
					document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
					setTimeout(function () {
						this.setState({
							trigger: true
						});
					}.bind(this), 0);
				}.bind(this), 0);
			}
		},

		componentDidMount: function (nextProps, nextState) {

			var data = {
				type: 'jstrigger',
				moduleName: 'clients',
				shouldUpdate: false
			},
			    jsonData = JSON.stringify(data);
			document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
			this.setState({
				trigger: false
			});
		},

		shouldComponentUpdate: function (nextProps, nextState) {

			if (nextState.trigger) {
				return true;
			} else {
				return false;
			}
		},

		componentDidUpdate: function () {

			var data = {
				type: 'jstrigger',
				moduleName: 'clients',
				shouldUpdate: false
			},
			    jsonData = JSON.stringify(data);
			document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
			this.setState({
				trigger: false
			});
		},

		render: function () {

			var clients = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = clients.get('atts'),
			    children = clients.get('inner'),
			    slideShow,
			    slideShowSpeed;
			if (!isEmpty(atts)) {
				slideShow = atts.get('slide_show');
				slideShowSpeed = parseValue(clients.get('name'), 'slide_show_speed', atts.get('slide_show_speed'), moduleOptions);
				if (!isEmpty(slideShow)) {
					slideShow = '1';
				} else {
					slideShow = '0';
				}
				if ('string' === typeof slideShowSpeed && !isNaN(slideShowSpeed.replace(/\D+/, '')) && '' != slideShowSpeed.replace(/\D+/, '')) {
					slideShowSpeed = slideShowSpeed.replace(/\D+/, '');
				} else {
					slideShowSpeed = '2000';
				}
			}
			return React.createElement(
				'div',
				{ className: 'carousel-wrap clearfix' },
				React.createElement(
					'ul',
					{ className: 'be-owl-carousel client-carousel-module', 'data-slide-show': slideShow, 'data-slide-show-speed': slideShowSpeed },
					children.map(function (client) {
						return React.createElement(Client, { key: client.get('id'), moduleOptions: moduleOptions, module: client });
					})
				)
			);
		}

	});
	module.exports = Clients;

/***/ }),
/* 2 */
/***/ (function(module, exports) {

	module.exports = function isEmpty(mixed_var) {

		if (_.isUndefined(mixed_var) || '0' === mixed_var || '' === mixed_var || 0 === mixed_var || _.isEmpty(mixed_var) || 'none' === mixed_var || false === mixed_var) {
			return true;
		}

		return false;
	};

/***/ }),
/* 3 */
/***/ (function(module, exports) {

	module.exports = function (moduleName, attName, value, moduleOptions) {

	    var attsFromModuleOptions = moduleOptions.getIn([moduleName, 'atts']),
	        attributeMap = Immutable.Map(),
	        options,
	        unit;
	    if ('string' === typeof value) {
	        if (Immutable.List.isList(attsFromModuleOptions)) {
	            attsFromModuleOptions.every(function (att) {
	                if (attName === att.get('att_name')) {
	                    attributeMap = att;
	                    return false;
	                } else {
	                    return true;
	                }
	            });
	            options = attributeMap.get('options');
	            if ('undefined' != typeof options && Immutable.Map.isMap(options)) {
	                unit = options.get('unit');
	                if ('string' === typeof unit && '' != unit) {
	                    if (-1 == value.indexOf(unit)) {
	                        value = value + unit;
	                    }
	                }
	            } else {
	                console.log('options is undefined!');
	            }
	        } else {
	            console.log('module options not found for', moduleName);
	        }
	    } else {
	        console.log('value is not a string, check module options of', moduleName);
	        value = '';
	    }

	    return value;
	};

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);
	var Client = React.createClass({
		displayName: 'Client',


		getImageGreyScale: function (defaultImageStyle, hoverImageStyle) {

			var imageGradient = '';
			if (!isEmpty(defaultImageStyle) && !isEmpty(hoverImageStyle)) {
				if ('black_white' === defaultImageStyle) {
					if ('black_white' === hoverImageStyle) {
						imageGradient = 'bw_to_bw';
					} else {
						imageGradient = 'bw_to_c';
					}
				} else {
					if ('black_white' === hoverImageStyle) {
						imageGradient = 'c_to_bw';
					} else {
						imageGradient = 'c_to_c';
					}
				}
			}
			return imageGradient;
		},

		render: function () {

			var client = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = client.get('atts'),
			    image,
			    link,
			    newTab,
			    imageGradient;
			if (!isEmpty(atts)) {
				image = atts.get('image');
				link = atts.get('link');
				newTab = atts.get('new_tab');
				defaultImageStyle = atts.get('default_image_style');
				hoverImageStyle = atts.get('hover_image_style');
				if (isEmpty(image)) {
					image = '';
				}
				if (isEmpty(newTab)) {
					newTab = '0';
				}
				if ('undefined' === typeof link || '' === link) {
					link = '#';
				}
				imageGradient = this.getImageGreyScale(defaultImageStyle, hoverImageStyle);
			}
			if ('' != image) {
				return React.createElement(
					'li',
					{ className: "carousel-item client-carousel-item " + imageGradient },
					React.createElement(
						'a',
						{ target: '0' != newTab ? '_blank' : null, href: link },
						React.createElement('img', { src: image, alt: '' })
					)
				);
			} else {
				return null;
			}
		}

	});
	module.exports = Client;

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    ImageSlide = __webpack_require__(6),
	    findDOMNode = ReactDOM.findDOMNode,
	    parseValue = __webpack_require__(3);
	var ImageSlider = React.createClass({
		displayName: 'ImageSlider',


		getInitialState: function () {

			return {
				trigger: false
			};
		},

		componentWillReceiveProps: function (nextProps) {

			if (!Immutable.is(this.props.module, nextProps.module)) {
				var height = jQuery(findDOMNode(this)).outerHeight();
				jQuery(findDOMNode(this)).css({ 'opacity': '0', 'height': height, 'overflow': 'hidden' });
				setTimeout(function () {
					var data = {
						type: 'jstrigger',
						moduleName: 'flex_slider',
						shouldUpdate: true
					},
					    jsonData = JSON.stringify(data);
					document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
					setTimeout(function () {
						this.setState({
							trigger: true
						});
					}.bind(this), 0);
				}.bind(this), 0);
			}
		},

		shouldComponentUpdate: function (nextProps, nextState) {

			if (nextState.trigger) {
				return true;
			} else {
				return false;
			}
		},

		componentDidUpdate: function () {

			var data = {
				type: 'jstrigger',
				moduleName: 'flex_slider',
				shouldUpdate: false
			},
			    jsonData = JSON.stringify(data);
			document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
			this.setState({
				trigger: false
			});
		},

		componentDidMount: function () {

			var data = {
				type: 'jstrigger',
				moduleName: 'flex_slider',
				shouldUpdate: false
			},
			    jsonData = JSON.stringify(data);
			document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
			this.setState({
				trigger: false
			});
		},

		render: function () {

			var imageSlider = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    children = imageSlider.get('inner'),
			    atts = imageSlider.get('atts'),
			    slideShow,
			    slideShowSpeed;

			if (!isEmpty(atts)) {
				slideShowSpeed = parseValue(imageSlider.get('name'), 'slide_show_speed', atts.get('slide_show_speed'), moduleOptions);
				slideShow = atts.get('slide_show');
				if ('yes' === slideShow || '1' === slideShow) {
					slideShow = '1';
				} else {
					slideShow = '0';
				}
				if ('string' === typeof slideShowSpeed && !isNaN(slideShowSpeed.replace(/\D+/, '')) && '' != slideShowSpeed.replace(/\D+/, '')) {
					slideShowSpeed = slideShowSpeed.replace(/\D+/, '');
				} else {
					slideShowSpeed = '2000';
				}
			}
			return React.createElement(
				'div',
				{ className: 'be_image_slider style1-arrow' },
				React.createElement(
					'div',
					{ className: 'image_slider_module slides', 'data-animation': 'fade', 'data-slide-show': slideShow, 'data-slide-show-speed': slideShowSpeed },
					children.map(function (image) {
						return React.createElement(ImageSlide, { key: image.get('id'), module: image, moduleOptions: moduleOptions });
					})
				)
			);
		}

	});
	module.exports = ImageSlider;

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);
	var ImageSlide = React.createClass({
		displayName: 'ImageSlide',


		parseUrl: function (url) {

			var anchor = document.createElement('a'),
			    hostName;
			anchor.href = url;
			hostName = anchor.host;
			if (-1 < hostName.indexOf('youtube') || -1 < hostName.indexOf('youtu.be')) {
				return 'youtube';
			} else if (-1 < hostName.indexOf('vimeo')) {
				return 'vimeo';
			} else {
				return '';
			}
		},

		render: function () {

			var imageSlide = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = imageSlide.get('atts'),
			    image,
			    pattern,
			    output,
			    video = '';
			if (!isEmpty(atts)) {
				image = atts.get('image');
				video = atts.get('video');
				if ('undefined' != typeof video && '' != video) {
					if ('youtube' === this.parseUrl(video)) {
						pattern = /(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i;
						videoId = video.match(pattern)[1];
						output = React.createElement('iframe', { width: '940', height: '450', src: "https://www.youtube.com/embed/" + videoId, allowFullScreen: true });
					} else if ('vimeo' === this.parseUrl(video)) {
						pattern = /https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/;
						videoId = video.match(pattern)[3];
						output = React.createElement('iframe', { src: "https://player.vimeo.com/video/" + videoId, width: '500', height: '281', allowFullScreen: true });
					} else {
						video = '';
					}
				}
				if (!isEmpty(image) && ('' === video || 'undefined' === typeof video)) {
					output = React.createElement('img', { src: image, alt: '' });
				}
			}
			return React.createElement(
				'div',
				{ className: 'be_image_slide' },
				output
			);
		}

	});
	module.exports = ImageSlide;

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    findDOMNode = ReactDOM.findDOMNode,
	    Testimonial = __webpack_require__(8),
	    parseValue = __webpack_require__(3);
	var Testimonials = React.createClass({
		displayName: 'Testimonials',


		getInitialState: function () {

			return {
				trigger: false
			};
		},

		componentWillReceiveProps: function (nextProps) {

			var currentNode = jQuery(findDOMNode(this));
			if (!Immutable.is(this.props.module, nextProps.module)) {
				var height = jQuery(findDOMNode(this)).outerHeight();
				currentNode.css({ 'opacity': '0', 'height': height, 'overflow': 'hidden' });
				setTimeout(function () {
					var data = {
						type: 'jstrigger',
						moduleName: 'testimonials',
						shouldUpdate: true
					},
					    jsonData = JSON.stringify(data);
					document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
					setTimeout(function () {
						this.setState({
							trigger: true
						});
					}.bind(this), 0);
				}.bind(this), 0);
			}
		},

		shouldComponentUpdate: function (nextProps, nextState) {

			if (nextState.trigger) {
				return true;
			} else {
				return false;
			}
		},

		componentDidUpdate: function () {

			var data = {
				type: 'jstrigger',
				moduleName: 'testimonials',
				shouldUpdate: false
			},
			    jsonData = JSON.stringify(data);
			document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
			this.setState({
				trigger: false
			});
		},

		componentDidMount: function () {

			var data = {
				type: 'jstrigger',
				moduleName: 'testimonials',
				shouldUpdate: false
			},
			    jsonData = JSON.stringify(data);
			document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
		},

		render: function () {
			var testimonials = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = testimonials.get('atts'),
			    children = testimonials.get('inner') || Immutable.List(),
			    authorRoleFont = '',
			    testimonialFontSize = '',
			    slideAnimationType = '',
			    alignment = '',
			    slideShowSpeed = '',
			    slideShow = '',
			    pagination = '',
			    animate = '',
			    animationType = '',
			    cssObject = this.props.cssObject;

			if (!isEmpty(atts)) {
				testimonialFontSize = parseValue(testimonials.get('name'), 'testimonial_font_size', atts.get('testimonial_font_size'), moduleOptions);
				authorRoleFont = atts.get('author_role_font');
				slideAnimationType = atts.get('slide_animation_type');
				slideShowSpeed = atts.get('slide_show_speed');
				slideShow = atts.get('slide_show');
				pagination = atts.get('pagination');
				alignment = atts.get('alignment'), animate = atts.get('animate');
				if (!isEmpty(animate)) {
					animationType = atts.get('animation_type');
				}
				if ('string' === typeof testimonialFontSize && '' != testimonialFontSize.replace(/\D+/, '') && !isNaN(testimonialFontSize.replace(/\D+/, ''))) {
					testimonialFontSize = testimonialFontSize;
				} else {
					testimonialFontSize = null;
				}
			}
			return React.createElement(
				'div',
				{ className: "testimonials_wrap " + (!isEmpty(animate) ? 'be-animate' : ''), 'data-animation': !isEmpty(animate) ? animationType : null },
				React.createElement(
					'div',
					{ className: 'testimonials-slides' },
					React.createElement(
						'div',
						{ className: "clearfix testimonial_module slides " + alignment + "-content", 'data-slide-show': !isEmpty(slideShow) ? '1' : '0', 'data-slide-show-speed': !isEmpty(slideShowSpeed) ? slideShowSpeed : null, 'data-slide-animation-type': !isEmpty(slideAnimationType) ? slideAnimationType : null, 'data-pagination': !isEmpty(pagination) ? '1' : '0' },
						children.map(function (testimonial) {
							return React.createElement(Testimonial, { key: testimonial.get('id'), fontSize: testimonialFontSize, roleFont: authorRoleFont, module: testimonial, moduleOptions: moduleOptions, cssObject: cssObject });
						})
					)
				)
			);
		}

	});
	module.exports = Testimonials;

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);
	var Testimonial = React.createClass({
		displayName: "Testimonial",


		getAuthorImage: function (authorImage) {

			if (!isEmpty(authorImage)) {
				return React.createElement(
					"div",
					{ className: "testimonial-author-img" },
					React.createElement("img", { src: authorImage, alt: "" })
				);
			} else {
				return null;
			}
		},

		getAuthor: function (atts, authorGradientClass, authorStyle) {

			var author = atts.get('author'),
			    authorColor = atts.get('author_color');
			if ('undefined' != typeof author) {
				return React.createElement(
					"h6",
					{ className: "testimonial-author " + authorGradientClass, style: authorStyle },
					author
				);
			} else {
				return null;
			}
		},

		getAuthorRole: function (atts, authorRoleGradientClass, authorRoleStyle) {

			var authorRole = atts.get('author_role'),
			    authorRoleFont = this.props.roleFont,
			    authorRoleClass = 'testimonial-author-role ',
			    authorRoleColor = atts.get('author_role_color');
			if ('undefined' != typeof authorRole) {
				if (!isEmpty(authorRoleFont)) {
					if ('h6' === authorRoleFont) {
						authorRoleClass = authorRoleClass + 'h6-font';
					} else if ('special' === authorRoleFont) {
						authorRoleClass = authorRoleClass + 'special-subtitle ';
					} else {
						authorRoleClass = authorRoleClass + '';
					}
				}
				return React.createElement(
					"div",
					{ className: authorRoleClass + ' ' + authorRoleGradientClass, style: authorRoleStyle },
					authorRole
				);
			} else {
				return null;
			}
		},

		render: function () {
			var testimonial = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = testimonial.get('atts'),
			    content = '',
			    authorImage = '',
			    quoteColor = '';
			var gradientClass = this.props.cssObject.class,
			    cssObject = this.props.cssObject.style,
			    key = testimonial.get('id'),
			    keyClass = ' ' + key,
			    authorGradientClass = gradientClass['.' + key + ' .testimonial-author'],
			    authorRoleGradientClass = gradientClass['.' + key + ' .testimonial-author-role'],
			    iconGradientClass = gradientClass['.' + key + ' .icon-quote'],
			    authorStyle = cssObject['.' + key + ' .testimonial-author'],
			    authorRoleStyle = cssObject['.' + key + ' .testimonial-author-role'],
			    iconStyle = cssObject['.' + key + ' .icon-quote'],
			    fontSize = cssObject['.testimonial-content'];
			if (!isEmpty(atts)) {
				content = atts.get('content');
				authorImage = atts.get('author_image');
			}
			return React.createElement(
				"div",
				{ className: "testimonial_slide slide clearfix be-testimonial-" + testimonial.get('id') },
				React.createElement(
					"div",
					{ className: "testimonial_slide_inner" },
					React.createElement("i", { className: "font-icon icon-quote " + iconGradientClass, style: iconStyle }),
					React.createElement("p", { className: "testimonial-content", dangerouslySetInnerHTML: { __html: content }, style: fontSize }),
					React.createElement(
						"div",
						{ className: "testimonial-author-info-wrap clearfix " },
						this.getAuthorImage(authorImage),
						React.createElement(
							"div",
							{ className: "testimonial-author-info" },
							[this.getAuthor(atts, authorGradientClass, authorStyle), this.getAuthorRole(atts, authorRoleGradientClass, authorRoleStyle)]
						)
					)
				)
			);
		}

	});
	module.exports = Testimonial;

/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    findDOMNode = ReactDOM.findDOMNode,
	    ContentSlide = __webpack_require__(10),
	    parseValue = __webpack_require__(3);
	var ContentSlider = React.createClass({
		displayName: 'ContentSlider',


		getInitialState: function () {

			return {
				trigger: false
			};
		},

		componentWillReceiveProps: function (nextProps) {

			if (!Immutable.is(this.props.module, nextProps.module)) {
				var height = jQuery(findDOMNode(this)).outerHeight();
				jQuery(findDOMNode(this)).css({ 'opacity': '0', 'height': height, 'overflow': 'hidden' });
				setTimeout(function () {
					var data = {
						type: 'jstrigger',
						moduleName: 'content_slides',
						shouldUpdate: true
					},
					    jsonData = JSON.stringify(data);
					document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
					setTimeout(function () {
						this.setState({
							trigger: true
						});
					}.bind(this), 0);
				}.bind(this), 0);
			}
		},

		shouldComponentUpdate: function (nextProps, nextState) {

			if (nextState.trigger) {
				return true;
			} else {
				return false;
			}
		},

		componentDidMount: function () {

			var data = {
				type: 'jstrigger',
				moduleName: 'content_slides',
				shouldUpdate: false
			},
			    jsonData = JSON.stringify(data);
			document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
		},

		componentDidUpdate: function () {

			var data = {
				type: 'jstrigger',
				moduleName: 'content_slides',
				shouldUpdate: false
			},
			    jsonData = JSON.stringify(data);
			document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
			this.setState({
				trigger: false
			});
		},

		render: function () {

			var contentSlider = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    children = contentSlider.get('inner'),
			    atts = contentSlider.get('atts'),
			    slideAnimationType = 'slide',
			    slideShow,
			    slideShowSpeed,
			    animate,
			    animationType,
			    contentMaxWidth,
			    moduleName = contentSlider.get('name'),
			    bulletsColor;
			if (!isEmpty(atts)) {
				slideShow = atts.get('slide_show');
				slideShowSpeed = parseValue(moduleName, 'slide_show_speed', atts.get('slide_show_speed'), moduleOptions);
				animate = atts.get('animate');
				bulletsColor = atts.get('bullets_color');
				contentMaxWidth = parseValue(moduleName, 'content_max_width', atts.get('content_max_width'), moduleOptions);
				if (!isEmpty(slideShow)) {
					slideShow = '1';
				} else {
					slideShow = '0';
				}
				if ('string' === typeof slideShowSpeed && '' != slideShowSpeed.replace(/\D+/, '') && !isNaN(slideShowSpeed.replace(/\D+/, ''))) {
					slideShowSpeed = slideShowSpeed.replace(/\D+/, '');
				} else {
					slideShowSpeed = '1000';
				}
				if (!isEmpty(animate)) {
					animationType = atts.get('animation_type');
				}
				if (isEmpty(bulletsColor)) {
					bulletsColor = '#20cbd4';
				}
				if ('string' === typeof contentMaxWidth && '' != contentMaxWidth.replace(/\D+/, '') && !isNaN(contentMaxWidth.replace(/\D+/, ''))) {
					contentMaxWidth = contentMaxWidth;
				} else {
					contentMaxWidth = '100%';
				}
			}
			return React.createElement(
				'div',
				{ className: "oshine-module content-slide-wrap " + (!isEmpty(animate) ? 'be-animate' : ''), 'data-animation': !isEmpty(animate) ? animationType : null },
				React.createElement(
					'div',
					{ className: 'content-slider clearfix' },
					React.createElement(
						'ul',
						{ className: 'clearfix slides content_slider_module clearfix', 'data-slide-show': slideShow, 'data-slide-show-speed': slideShowSpeed, 'data-slide-animation-type': 'slide' },
						children.map(function (slide) {
							return React.createElement(ContentSlide, { key: slide.get('id'), maxWidth: contentMaxWidth, module: slide, moduleOptions: moduleOptions });
						})
					)
				)
			);
		}

	});
	module.exports = ContentSlider;

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);
	var ContentSlide = React.createClass({
		displayName: 'ContentSlide',


		render: function () {

			var contentSlide = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = contentSlide.get('atts'),
			    maxWidth = this.props.maxWidth || '100',
			    content;
			if (!isEmpty(atts)) {
				content = atts.get('content');
				if ('undefined' != typeof content) {
					content = content;
				} else {
					content = '';
				}
			}
			return React.createElement(
				'li',
				{ className: 'content_slide slide clearfix' },
				React.createElement(
					'div',
					{ className: 'content_slide_inner', style: { width: maxWidth } },
					React.createElement('div', { className: 'content-slide-content', dangerouslySetInnerHTML: { __html: content } })
				)
			);
		}

	});
	module.exports = ContentSlide;

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);
	var IconCard = React.createClass({
		displayName: 'IconCard',


		getCaptionTag: function (atts) {

			var captionTag = 'div',
			    captionFont = atts.get('caption_font');
			if (!isEmpty(captionFont) && 'body' != captionFont && 'special' != captionFont) {
				captionTag = captionFont;
			}
			return captionTag;
		},

		getCaptionClass: function (atts) {

			var captionClass = '',
			    captionFont = atts.get('caption_font');
			if (!isEmpty(captionFont)) {
				if ('body' === captionFont) {
					captionClass = captionClass + 'body-font';
				} else if ('special' === captionFont) {
					captionClass = captionClass + 'special-subtitle';
				}
			}
			return captionClass;
		},

		getWrapperClass: function (atts) {

			var wrapperClass = 'oshine-module be_icon_card_wrap ',
			    size = atts.get('size'),
			    animate = atts.get('animate'),
			    style = atts.get('style');
			if (!isEmpty(size)) {
				wrapperClass = wrapperClass + size + ' ';
			}
			if (!isEmpty(style)) {
				wrapperClass = wrapperClass + style + ' ';
			}
			if (!isEmpty(animate)) {
				wrapperClass = wrapperClass + 'be-animate ';
			}
			return wrapperClass;
		},

		render: function () {

			var iconCard = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = this.props.atts,
			    iconStyle = {},
			    wrapperClass = '',
			    title = '',
			    TitleTag = 'h4',
			    titleColor = '',
			    icon = '',
			    CaptionTag = 'div',
			    captionClass = '',
			    animate = '',
			    caption = '',
			    animationType = '',
			    captionColor = '',
			    cssObject = this.props.cssObject.style,
			    gradientClass = this.props.cssObject.class;
			if (!isEmpty(atts)) {
				animate = atts.get('animate');
				if (!isEmpty(animate)) {
					animationType = atts.get('animation_type');
				}
				title = atts.get('title');
				TitleTag = atts.get('title_font');
				caption = atts.get('caption');
				CaptionTag = this.getCaptionTag(atts);
				captionClass = this.getCaptionClass(atts);
				wrapperClass = this.getWrapperClass(atts);
				icon = atts.get('icon');
			}

			return React.createElement(
				'div',
				{ className: wrapperClass, 'data-animation': !isEmpty(animate) ? animationType : null },
				React.createElement('i', { className: "font-icon " + icon, style: cssObject['.font-icon'] }),
				React.createElement(
					'div',
					{ className: 'title-with-icon-card' },
					['undefined' != typeof title ? React.createElement(
						TitleTag,
						{ style: cssObject['.title'] },
						' ',
						title,
						' '
					) : null, 'undefined' != typeof caption ? React.createElement(
						CaptionTag,
						{ className: captionClass, style: cssObject['.caption'] },
						' ',
						caption,
						' '
					) : null]
				)
			);
		}

	});
	module.exports = IconCard;

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    parseValue = __webpack_require__(3);
	ProcessColumn = __webpack_require__(13);
	var Process = React.createClass({
		displayName: 'Process',


		getDividerHeight: function (iconSize, name, moduleOptions) {

			var dividerHeight = 0,
			    iconSize = parseValue(name, 'icon_size', iconSize, moduleOptions),
			    unit = '';
			if ('string' === typeof iconSize && '' != iconSize.replace(/\D+/, '') && !isNaN(iconSize.replace(/\D+/, ''))) {
				unit = iconSize.replace(/\d+/, '');
				dividerHeight = Number(iconSize.replace(/\D+/, '')) / 2;
			}
			return dividerHeight.toString() + unit;
		},

		render: function () {

			var process = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = process.get('atts'),
			    children = process.get('inner'),
			    outputArray = [],
			    borderColor = '',
			    cssObject = this.props.cssObject.style,
			    gradientClass = this.props.cssObject.class;
			if (!isEmpty(atts)) {
				borderColor = atts.get('border_color');
			}
			children.forEach(function (processCol) {

				var dividerHeight = this.getDividerHeight(processCol.getIn(['atts', 'icon_size']), processCol.get('name'), moduleOptions);
				outputArray.push(React.createElement(ProcessColumn, { parentId: process.get('id'), dividerHeight: dividerHeight, key: processCol.get('id'), module: processCol, moduleOptions: moduleOptions, cssObject: cssObject, gradientClass: gradientClass }));
			}.bind(this));
			return React.createElement(
				'div',
				{ className: 'oshine-module process-style1', 'data-col': '1' },
				outputArray
			);
		}

	});
	module.exports = Process;

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    parseValue = __webpack_require__(3);
	var ProcessColumn = React.createClass({
		displayName: 'ProcessColumn',


		// getIconStyle : function( atts, processColumn, moduleOptions ) {

		// 	var iconStyle = {},
		// 		iconSize = parseValue( processColumn.get( 'name' ), 'icon_size', atts.get( 'icon_size' ), moduleOptions ),
		// 		iconColor = atts.get( 'icon_color' );
		// 	if( 'string' === typeof iconSize && '' != iconSize.replace( /\D+/, '' ) && !isNaN( iconSize.replace( /\D+/, '' ) ) ) {
		// 		iconStyle.fontSize = iconSize;
		// 	}
		// 	if( !isEmpty( iconColor ) ) {
		// 		iconStyle.color = iconColor;
		// 	}
		// 	return iconStyle;

		// },

		render: function () {

			var processColumn = this.props.module,
			    id = "." + processColumn.get('id'),
			    moduleOptions = this.props.moduleOptions,
			    atts = processColumn.get('atts'),
			    animate = '',
			    top = this.props.dividerHeight,

			//	borderColor = this.props.borderColor,
			icon = '',
			    content = '',
			    animationType = '',

			//	iconStyle = {},
			cssObject = this.props.cssObject,
			    gradientClass = this.props.gradientClass,
			    sep_style = jQuery.extend({}, cssObject['.process-sep'], { top: top });

			if (!isEmpty(atts)) {
				animate = atts.get('animate');
				if (!isEmpty(animate)) {
					animationType = atts.get('animation_type');
				}
				icon = atts.get('icon'),
				//	iconStyle = this.getIconStyle( atts, processColumn, moduleOptions );
				content = atts.get('content');
			}
			console.log(cssObject);
			return React.createElement(
				'div',
				{ className: "process-col align-center " + (!isEmpty(animate) ? 'be-animate' : ''), 'data-animation': !isEmpty(animate) ? animationType : null },
				React.createElement('i', { className: "font-icon " + icon + " " + gradientClass[id + '.process-col .font-icon'], style: cssObject[id + '.process-col .font-icon'] }),
				React.createElement('div', { dangerouslySetInnerHTML: { __html: content }, className: 'process-info' }),
				React.createElement('div', { className: 'process-sep', style: sep_style })
			);
		}

	});
	module.exports = ProcessColumn;

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

	var Service = __webpack_require__(15),
	    isEmpty = __webpack_require__(2);
	var Services = React.createClass({
		displayName: 'Services',


		render: function () {

			var services = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = services.get('atts'),
			    children = services.get('inner') || Immutable.List(),
			    lineColor = '',
			    cssObject = this.props.cssObject;
			if (!isEmpty(atts)) {
				lineColor = atts.get('line_color');
			}
			return React.createElement(
				'div',
				{ className: 'oshine-module services-outer-wrap' },
				React.createElement(
					'ul',
					{ className: 'be-services' },
					children.map(function (service) {

						return React.createElement(Service, { key: service.get('id'), module: service, moduleOptions: moduleOptions, cssObject: cssObject });
					})
				),
				React.createElement('span', { className: 'timeline', style: cssObject.style['.timeline'] })
			);
		}

	});
	module.exports = Services;

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);
	var Service = React.createClass({
		displayName: 'Service',


		getInitialState: function () {
			return {
				hovered: false
			};
		},

		hoverHandler: function () {
			this.setState({
				hovered: !this.state.hovered
			});
		},

		getIconStyle: function (atts) {

			var iconStyle = {},
			    bgColor = atts.get('icon_bg_color'),
			    color = atts.get('icon_color');
			if (!isEmpty(bgColor)) {
				iconStyle.backgroundColor = bgColor;
			}
			if (!isEmpty(color)) {
				iconStyle.color = color;
			}
			return iconStyle;
		},

		render: function () {

			var service = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = service.get('atts'),
			    id = "." + service.get('id'),
			    content = '',
			    iconStyle = {},
			    icon = '',
			    size = '';

			var cssObject = this.props.cssObject.style,
			    iconStyle = cssObject[id + ' .service-icon'],
			    iconHoverStyle = cssObject[id + ' .service-wrap:hover .service-icon'],
			    contentStyle = cssObject[id + ' .service-content'];

			iconHoverStyle = jQuery.extend({}, iconStyle, iconHoverStyle);

			if (!isEmpty(atts)) {
				icon = atts.get('icon');
				size = atts.get('icon_size');
				content = atts.get('content');
				iconClass = 'font-icon ';
				if (!isEmpty(size)) {
					iconClass = iconClass + 'icon-size-' + size + ' ';
				}
				if (!isEmpty(icon)) {
					iconClass = iconClass + icon;
				}
			}
			return React.createElement(
				'li',
				{ className: 'oshine-module be-service' },
				React.createElement(
					'div',
					{ className: 'service-wrap', onMouseEnter: this.hoverHandler, onMouseLeave: this.hoverHandler },
					React.createElement('i', { className: iconClass, style: this.state.hovered ? iconHoverStyle : iconStyle }),
					React.createElement('div', { className: 'service-content', style: contentStyle, dangerouslySetInnerHTML: { __html: content } })
				)
			);
		}

	});
	module.exports = Service;

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    Skill = __webpack_require__(17),
	    parseValue = __webpack_require__(3);
	var Skills = React.createClass({
	    displayName: 'Skills',


	    render: function () {

	        var skills = this.props.module,
	            moduleOptions = this.props.moduleOptions,
	            atts = skills.get('atts'),
	            cssObject = this.props.cssObject,
	            children = skills.get('inner') || Immutable.List(),
	            direction = 'horizontal',
	            skillsStyle = {},
	            height = '',
	            cssObject = this.props.cssObject.style,
	            gradientClass = this.props.cssObject.class;

	        if (!isEmpty(atts)) {
	            direction = atts.get('direction');
	            height = parseValue(skills.get('name'), 'height', atts.get('height'), moduleOptions);
	            if (isEmpty(direction)) {
	                direction = 'horizontal';
	            }
	            if ('string' === typeof height && '' != height.replace(/\D+/, '') && !isNaN(height.replace(/\D+/, ''))) {
	                height = height;
	            } else {
	                height = '400px';
	            }
	            if ('vertical' === direction) {
	                skillsStyle.height = height;
	            }
	        }
	        return React.createElement(
	            'div',
	            { className: "oshine-module skill_container be-shortcode skill-" + direction, style: skillsStyle },
	            React.createElement(
	                'div',
	                { className: 'skill clearfix' },
	                children.map(function (skill) {

	                    return React.createElement(Skill, { key: skill.get('id'), height: height, module: skill, moduleOptions: moduleOptions, direction: direction, cssObject: cssObject, gradientClass: gradientClass });
	                })
	            )
	        );
	    }

	});
	module.exports = Skills;

/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    parseValue = __webpack_require__(3);
	var Skill = React.createClass({
	    displayName: 'Skill',


	    render: function () {

	        var skill = this.props.module,
	            id = '.' + skill.get('id'),
	            moduleOptions = this.props.moduleOptions,
	            atts = skill.get('atts'),
	            cssObject = this.props.cssObject.style,
	            key = skill.get('id'),
	            direction = this.props.direction,
	            height = this.props.height,
	            title = '',
	            value = '',
	            barStyle = {},
	            cssObject = this.props.cssObject,
	            gradientClass = this.props.gradientClass;
	        if (!isEmpty(atts)) {
	            title = atts.get('title');
	            value = parseValue(skill.get('name'), 'value', atts.get('value'), moduleOptions);
	            if ('string' === typeof value && '' != value.replace(/\D+/, '') && !isNaN(value.replace(/\D+/, ''))) {
	                value = value;
	            } else {
	                value = '100%';
	            }
	            if ('undefined' != typeof direction && 'vertical' === direction) {
	                barStyle.height = height;
	            }
	        }
	        return 'horizontal' === direction ? React.createElement(
	            'div',
	            { className: "oshine-module skill-wrap " },
	            React.createElement(
	                'span',
	                { className: "skill_name " + gradientClass[id + ' .skill_name'], style: cssObject[id + ' .skill_name'] },
	                title
	            ),
	            React.createElement(
	                'div',
	                { className: 'skill-bar', style: cssObject[id + ' .skill-bar'] },
	                React.createElement('span', { className: 'be-skill expand alt-bg alt-bg-text-color', 'data-skill-value': value, style: cssObject[id + ' .be-skill'] })
	            )
	        ) : React.createElement(
	            'div',
	            { className: 'oshine-module skill-wrap' },
	            React.createElement(
	                'div',
	                { className: 'skill-bar', style: jQuery.extend({}, cssObject[id + ' .skill-bar'], barStyle) },
	                React.createElement('span', { className: 'be-skill expand alt-bg alt-bg-text-color', 'data-skill-value': value, style: cssObject[id + ' .be-skill'] })
	            ),
	            React.createElement(
	                'span',
	                { className: "skill_name " + gradientClass[id + ' .skill_name'], style: cssObject[id + ' .skill_name'] },
	                title
	            )
	        );
	    }

	});
	module.exports = Skill;

/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    parseValue = __webpack_require__(3);
	var SpecialHeadingStyle1 = React.createClass({
		displayName: 'SpecialHeadingStyle1',


		getSeparatorStyle: function (atts, specialHeading, moduleOptions) {

			var separatorStyle = {},
			    separatorColor = atts.get('separator_color'),
			    separatorWidth = parseValue(specialHeading.get('name'), 'separator_width', atts.get('separator_width'), moduleOptions),
			    separatorThickness = parseValue(specialHeading.get('name'), 'separator_thickness', atts.get('separator_thickness'), moduleOptions);
			if (!isEmpty(separatorColor)) {
				separatorStyle.background = separatorColor;
				separatorStyle.color = separatorColor;
				separatorStyle.borderColor = separatorColor;
			}
			if ('string' === typeof separatorWidth && '' != separatorWidth.replace(/\D+/, '') && !isNaN(separatorWidth.replace(/\D+/, ''))) {
				separatorStyle.width = separatorWidth;
			} else {
				separatorStyle.width = '0px';
			}
			if ('string' === typeof separatorThickness && '' != separatorThickness.replace(/\D+/, '') && !isNaN(separatorThickness.replace(/\D+/, ''))) {
				separatorStyle.height = separatorThickness;
			} else {
				separatorStyle.height = '0px';
			}
			return separatorStyle;
		},

		getWrapperClass: function (atts) {

			var wrapperClass = 'oshine-module special-heading-wrap style1 ',
			    animate = atts.get('animate'),
			    scrollToAnimate = atts.get('scroll_to_animate');
			if (!isEmpty(animate)) {
				wrapperClass = wrapperClass + 'be-animate ';
			}
			if (!isEmpty(scrollToAnimate)) {
				wrapperClass = wrapperClass + 'scrollToFade ';
			}
			return wrapperClass;
		},

		getSeparatorWithIcon: function (atts, specialHeading, moduleOptions, cssObject) {

			var separatorStyle = this.getSeparatorStyle(atts, specialHeading, moduleOptions),
			    icon,
			    iconStyle = {},
			    iconColor,
			    separatorIconStyle = atts.get('separator_style'),
			    disableSeparator = atts.get('disable_separator');

			var sepIconColor = isEmpty(cssObject['.sep-icon']) ? cssObject['.sep-icon.oshine_diamond'] : cssObject['.sep-icon'],
			    newSeperatorStyle = cssObject['.sep-with-icon'];
			if (isEmpty(disableSeparator)) {
				if (!isEmpty(separatorIconStyle)) {
					icon = atts.get('icon_name');
					iconColor = atts.get('icon_color');
					if ('oshine_diamond' === icon && !isEmpty(iconColor)) {
						iconStyle.background = iconColor;
					} else if (!isEmpty(iconColor)) {
						iconStyle.color = iconColor;
					}
					separatorStyle.width = separatorStyle.width.replace(/\D+/, '') / 2 + separatorStyle.width.replace(/\d+/, '');
					return React.createElement(
						'div',
						{ className: 'sep-with-icon-wrap margin-bottom' },
						React.createElement('span', { className: 'sep-with-icon', style: newSeperatorStyle }),
						React.createElement('i', { className: "sep-icon font-icon " + icon, style: sepIconColor }),
						React.createElement('span', { className: 'sep-with-icon', style: newSeperatorStyle })
					);
				} else {
					return React.createElement(
						'div',
						{ className: 'sep-with-icon-wrap margin-bottom' },
						React.createElement('hr', { className: 'separator margin-bottom', style: newSeperatorStyle })
					);
				}
			}
		},

		render: function () {

			var specialHeading = this.props.module,
			    atts = this.props.atts,
			    moduleOptions = this.props.moduleOptions,
			    animate = '',
			    animationType = '',
			    alignment = '',
			    titleContent = '',
			    addSubTitleSpecialFont = '',
			    subTitleContent = '',
			    TitleTag = 'h3',
			    separatorPosition = '',
			    outputArray = [],
			    subTitleClass = '',
			    wrapperClass = '';
			if (!isEmpty(atts)) {
				wrapperClass = this.getWrapperClass(atts);
				titleColor = atts.get('title_color');
				titleContent = atts.get('title_content');
				alignment = atts.get('title_align') || '';
				subTitleContent = atts.get('content');
				TitleTag = atts.get('h_tag');
				addSubTitleSpecialFont = atts.get('subtitle_spl_font');
				separatorPosition = atts.get('separator_pos');
				if (!isEmpty(addSubTitleSpecialFont)) {
					subTitleClass = 'special-subtitle ';
				}
				animate = atts.get('animate');
				if (!isEmpty(animate)) {
					animationType = atts.get('animation_type');
				}
				if ('' === TitleTag || 'undefined' === typeof TitleTag) {
					TitleTag = 'h3';
				}
			}

			var cssObject = this.props.cssObject.style,
			    newTitleColor = cssObject['.special-h-tag'];

			if ('undefined' != typeof titleContent) {
				outputArray.push(React.createElement(
					TitleTag,
					{ className: 'special-h-tag', style: newTitleColor },
					' ',
					titleContent,
					' '
				));
			}
			if (isEmpty(separatorPosition)) {
				if ('undefined' != typeof subTitleContent) {
					outputArray.push(React.createElement('div', { className: "sub-title margin-bottom " + subTitleClass, dangerouslySetInnerHTML: { __html: subTitleContent } }));
				}
				outputArray.push(this.getSeparatorWithIcon(atts, specialHeading, moduleOptions, cssObject));
			} else {
				outputArray.push(this.getSeparatorWithIcon(atts, specialHeading, moduleOptions, cssObject));
				if ('undefined' != typeof subTitleContent) {
					outputArray.push(React.createElement('div', { className: "sub-title margin-bottom " + subTitleClass, dangerouslySetInnerHTML: { __html: subTitleContent } }));
				}
			}
			//console.log(this.props.cssObject);


			return React.createElement(
				'div',
				{ className: wrapperClass, 'data-animation': !isEmpty(animate) ? animationType : null },
				React.createElement(
					'div',
					{ className: "special-heading align-" + alignment },
					outputArray
				)
			);
		}

	});
	module.exports = SpecialHeadingStyle1;

/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

	var parseValue = __webpack_require__(3),
	    isEmpty = __webpack_require__(2);

	var SpecialHeadingStyle2 = React.createClass({
		displayName: 'SpecialHeadingStyle2',


		getWrapperClass: function (atts) {

			var wrapperClass = 'oshine-module special-heading-wrap style2 ',
			    animate = atts.get('animate'),
			    alignment = atts.get('title_alignment'),
			    scrollToAnimate = atts.get('scroll_to_animate');
			if (!isEmpty(animate)) {
				wrapperClass = wrapperClass + 'be-animate ';
			}
			if (!isEmpty(scrollToAnimate)) {
				wrapperClass = wrapperClass + 'scrollToFade ';
			}
			if (!isEmpty(alignment)) {
				wrapperClass = wrapperClass + 'align-' + alignment + ' ';
			}
			return wrapperClass;
		},

		render: function () {

			var specialHeading = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = this.props.atts,
			    wrapperClass = '',
			    TitleTag = 'h3',
			    animate = '',
			    animationType = '',
			    titleContent = '',
			    titleColor = '';
			if (!isEmpty(atts)) {
				animate = atts.get('animate');
				if (!isEmpty(animate)) {
					animationType = atts.get('animation_type');
				}
				wrapperClass = this.getWrapperClass(atts);
				titleContent = atts.get('title_content');
				titleColor = atts.get('title_color');
				TitleTag = atts.get('h_tag');
				if ('undefined' === TitleTag || '' === TitleTag) {
					TitleTag = 'h3';
				}
			}
			var cssObject = this.props.ccsObject;
			var newHeadingStyle = this.props.cssObject.style['.special-heading'];
			var newTitleColor = this.props.cssObject.style['.special-h-tag'];

			return React.createElement(
				'div',
				{ className: wrapperClass, 'data-animation': !isEmpty(animate) ? animationType : null },
				React.createElement(
					'div',
					{ className: "special-heading " + this.props.cssObject.class['.special-heading'], style: newHeadingStyle },
					React.createElement(
						TitleTag,
						{ className: "special-h-tag " + this.props.cssObject.class['.special-h-tag'], style: newTitleColor },
						titleContent
					)
				)
			);
		}
	});

	module.exports = SpecialHeadingStyle2;

/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    parseValue = __webpack_require__(3);
	var SpecialHeadingStyle3 = React.createClass({
		displayName: 'SpecialHeadingStyle3',


		getTopCaptionClass: function (atts) {

			var topCaptionClass = 'caption ',
			    topCaptionFont = atts.get('top_caption_font');
			if (!isEmpty(topCaptionFont)) {
				if ('body' === topCaptionFont) {
					topCaptionClass = topCaptionClass + 'body-font';
				} else if ('special' === topCaptionFont) {
					topCaptionClass = topCaptionClass + 'special-subtitle';
				}
			}
			return topCaptionClass;
		},

		getBottomCaptionClass: function (atts) {

			var bottomCaptionClass = 'caption ',
			    bottomCaptionFont = atts.get('bottom_caption_font');
			if (!isEmpty(bottomCaptionFont)) {
				if ('body' === bottomCaptionFont) {
					bottomCaptionClass = bottomCaptionClass + 'body-font';
				} else if ('special' === bottomCaptionFont) {
					bottomCaptionClass = bottomCaptionClass + 'special-subtitle';
				}
			}
			return bottomCaptionClass;
		},

		getWrapperClass: function (atts) {

			var wrapperClass = 'oshine-module special-heading-wrap style3 ',
			    animate = atts.get('animate'),
			    scrollToAnimate = atts.get('scroll_to_animate');
			if (!isEmpty(animate)) {
				wrapperClass = wrapperClass + 'be-animate ';
			}
			if (!isEmpty(scrollToAnimate)) {
				wrapperClass = wrapperClass + 'scrollToFade ';
			}
			return wrapperClass;
		},

		render: function () {

			var specialHeading = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = this.props.atts,
			    topCaptionClass = '',
			    bottomCaptionClass = '',
			    topCaption = '',
			    bottomCaption = '',
			    titleColor = '',
			    titleContent = '',
			    wrapperClass = '',
			    animate = '',
			    CustomTag = 'h3',
			    animationType;
			if (!isEmpty(atts)) {
				topCaptionClass = this.getTopCaptionClass(atts);
				bottomCaptionClass = this.getBottomCaptionClass(atts);
				wrapperClass = this.getWrapperClass(atts);
				animate = atts.get('animate');
				if (!isEmpty(animate)) {
					animationType = atts.get('animation_type');
				}
				topCaption = atts.get('sub_title1');
				bottomCaption = atts.get('sub_title2');
				CustomTag = atts.get('h_tag');
				titleColor = atts.get('title_color');
				titleContent = atts.get('title_content');
				if ('undefined' === typeof CustomTag || '' === CustomTag) {
					CustomTag = 'h3';
				}
			}
			var cssObject = this.props.cssObject.style;
			var newTopCaptionStyle = cssObject['.top-caption h6'];
			var newTopCaptionSeparatorColor = cssObject['.special-heading-wrap.style3 .top-caption .caption .caption-inner'];
			var newTitleColor = cssObject['.special-h-tag'];
			var newBottomCaptionSeparatorColor = cssObject['.special-heading-wrap.style3 .bottom-caption .caption .caption-inner'];
			var newBottomCaptionStyle = cssObject['.bottom-caption h6'];

			return React.createElement(
				'div',
				{ className: wrapperClass, 'data-animation': animate ? animationType : null },
				'string' == typeof topCaption && '' != topCaption ? React.createElement(
					'div',
					{ className: 'caption-wrap' },
					React.createElement(
						'h6',
						{ style: newTopCaptionStyle, className: topCaptionClass },
						topCaption,
						React.createElement('span', { className: 'caption-inner', style: newTopCaptionSeparatorColor })
					)
				) : null,
				React.createElement(
					'div',
					{ className: 'special-heading align-center' },
					React.createElement(
						CustomTag,
						{ className: 'special-h-tag', style: newTitleColor },
						titleContent
					)
				),
				'string' == typeof bottomCaption && '' != bottomCaption ? React.createElement(
					'div',
					{ className: 'caption-wrap' },
					React.createElement(
						'h6',
						{ style: newBottomCaptionStyle, className: bottomCaptionClass },
						bottomCaption,
						React.createElement('span', { className: 'caption-inner', style: newBottomCaptionSeparatorColor })
					)
				) : null
			);
		}

	});
	module.exports = SpecialHeadingStyle3;

/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);
	var SpecialHeadingStyle4 = React.createClass({
		displayName: 'SpecialHeadingStyle4',


		getWrapperClass: function (atts) {

			var wrapperClass = 'oshine-module special-heading-wrap style4 ',
			    animate = atts.get('animate'),
			    scrollToAnimate = atts.get('scroll_to_animate');
			if (!isEmpty(animate)) {
				wrapperClass = wrapperClass + 'be-animate ';
			}
			if (!isEmpty(scrollToAnimate)) {
				wrapperClass = wrapperClass + 'scrollToFade ';
			}
			return wrapperClass;
		},

		getCaptionTag: function (atts) {

			var captionTag = 'div',
			    captionFont = atts.get('caption_font');
			if (!isEmpty(captionFont) && 'body' != captionFont && 'special' != captionFont) {
				captionTag = captionFont;
			}
			return captionTag;
		},

		getCaptionClass: function (atts) {

			var captionClass = 'caption ',
			    captionFont = atts.get('caption_font');
			if (!isEmpty(captionFont)) {
				if ('body' === captionFont) {
					captionClass = captionClass + 'body-font';
				} else if ('special' === captionFont) {
					captionClass = captionClass + 'special-subtitle';
				}
			}
			return captionClass;
		},

		render: function () {

			var specialHeading = this.props.module,
			    atts = this.props.atts,
			    moduleOptions = this.props.moduleOptions,
			    wrapperClass = '',
			    CaptionTag = 'div',
			    TitleTag = 'h3',
			    captionClass = '',
			    dividerStyle = 'both',
			    animate = '',
			    animationType = '',
			    captionColor = '',
			    dividerColor = '',
			    captionContent = '',
			    titleContent = '',
			    titleColor = '';
			if (!isEmpty(atts)) {
				wrapperClass = this.getWrapperClass(atts);
				CaptionTag = this.getCaptionTag(atts);
				captionClass = this.getCaptionClass(atts);
				titleContent = atts.get('title_content');
				captionContent = atts.get('caption_content');
				dividerStyle = atts.get('divider_style');
				TitleTag = atts.get('h_tag');
				animate = atts.get('animate');
				if (!isEmpty(animate)) {
					animationType = atts.get('animation_type');
				}
				if ('undefined' === typeof CaptionTag || '' === CaptionTag) {
					CaptionTag = 'h3';
				}
				if ('undefined' === typeof TitleTag || '' === TitleTag) {
					TitleTag = 'h3';
				}
			}
			var cssObject = this.props.cssObject.style;
			var newDividerColor = cssObject['.special-heading-wrap .vertical-divider'];
			var newTitleColor = cssObject['.special-h-tag'];
			var newCaptionColor = cssObject['.caption'];

			return React.createElement(
				'div',
				{ className: wrapperClass, 'data-animation': !isEmpty(animate) ? animationType : null },
				['bottom' === dividerStyle ? null : React.createElement('div', { className: 'vertical-divider top', style: newDividerColor }), 'undefined' != typeof captionContent && '' != captionContent ? React.createElement(
					CaptionTag,
					{ className: captionClass, style: newCaptionColor },
					' ',
					captionContent,
					' '
				) : null, React.createElement(
					'div',
					{ className: 'special-heading ' },
					React.createElement(
						TitleTag,
						{ className: 'special-h-tag', style: newTitleColor },
						' ',
						titleContent,
						' '
					)
				), 'top' === dividerStyle ? null : React.createElement('div', { className: 'vertical-divider bottom', style: newDividerColor })]
			);
		}

	});
	module.exports = SpecialHeadingStyle4;

/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);
	var SpecialHeadingStyle5 = React.createClass({
		displayName: 'SpecialHeadingStyle5',


		getWrapperClass: function (atts) {

			var wrapperClass = 'oshine-module special-heading-wrap style5 ',
			    animate = atts.get('animate'),
			    titleAlignment = atts.get('title_alignment'),
			    scrollToAnimate = atts.get('scroll_to_animate');
			if (!isEmpty(animate)) {
				wrapperClass = wrapperClass + 'be-animate ';
			}
			if (!isEmpty(scrollToAnimate)) {
				wrapperClass = wrapperClass + 'scrollToFade ';
			}
			if (!isEmpty(titleAlignment)) {
				wrapperClass = wrapperClass + 'align-' + titleAlignment + ' ';
			}
			return wrapperClass;
		},

		getCaptionTag: function (atts) {

			var captionTag = 'div',
			    captionFont = atts.get('caption_font');
			if (!isEmpty(captionFont) && 'body' != captionFont && 'special' != captionFont) {
				captionTag = captionFont;
			}
			return captionTag;
		},

		getCaptionClass: function (atts) {

			var captionClass = 'caption ',
			    captionFont = atts.get('caption_font');
			if (!isEmpty(captionFont)) {
				if ('body' === captionFont) {
					captionClass = captionClass + 'body-font';
				} else if ('special' === captionFont) {
					captionClass = captionClass + 'special-subtitle';
				}
			}
			return captionClass;
		},

		render: function () {

			var specialHeading = this.props.module,
			    moduleOptions = this.props.moduleOptions,

			//atts = specialHeading.get( 'atts' ),
			atts = this.props.atts,
			    CaptionTag = 'div',
			    captionClass = '',
			    TitleTag = 'h3',
			    wrapperClass = '',
			    animate = '',
			    animationType = '',
			    titleContent = '',
			    captionContent = '',
			    cssObject = this.props.cssObject.style;
			if (!isEmpty(atts)) {
				animate = atts.get('animate');
				if (!isEmpty(animate)) {
					animationType = atts.get('animation_type');
				}
				wrapperClass = this.getWrapperClass(atts);
				CaptionTag = this.getCaptionTag(atts);
				captionClass = this.getCaptionClass(atts);
				TitleTag = atts.get('h_tag');
				titleContent = atts.get('title_content');
				captionContent = atts.get('caption_content');
				if ('undefined' === typeof CaptionTag || '' === CaptionTag) {
					CaptionTag = 'h3';
				}
				if ('undefined' === typeof TitleTag || '' === TitleTag) {
					TitleTag = 'h3';
				}
			}
			return React.createElement(
				'div',
				{ className: wrapperClass, 'data-animation': !isEmpty(animate) ? animationType : null },
				React.createElement(
					'div',
					{ className: 'special-heading' },
					React.createElement(
						TitleTag,
						{ className: 'special-h-tag', style: cssObject['.special-h-tag'] },
						titleContent
					)
				),
				React.createElement(
					'div',
					{ className: 'caption-wrap' },
					React.createElement(
						CaptionTag,
						{ className: captionClass, style: cssObject['.caption'] },
						captionContent
					)
				)
			);
		}
	});
	module.exports = SpecialHeadingStyle5;

/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);
	var SpecialHeading6 = React.createClass({
	    displayName: 'SpecialHeading6',


	    getInitialState: function () {
	        return {
	            hovered: false
	        };
	    },

	    hoverHandler: function () {
	        this.setState({
	            hovered: !this.state.hovered
	        });
	    },

	    render: function () {

	        var specialHeading6 = this.props.module,
	            moduleOptions = this.props.moduleOptions,
	            atts = this.props.atts,
	            animate = '',
	            animationType = '',
	            title = '',
	            expandOnHover = false,
	            alignment = 'left',
	            borderStyle = 'style1',
	            titleStyle,
	            titleHoverStyle,
	            cssObject = this.props.cssObject.style;
	        if (!isEmpty(atts)) {
	            animate = atts.get('animate');
	            if (!isEmpty(animate)) {
	                animationType = atts.get('animation_type');
	            }
	            title = atts.get('title_content') || '';
	            alignment = atts.get('alignment');
	            borderStyle = atts.get('border_style');
	            expandOnHover = atts.get('expand_border');
	            letterSpacing = atts.get('letter_spacing');
	        }

	        titleStyle = cssObject['.special-heading-wrap.style6 .be-title'];
	        titleHoverStyle = jQuery.extend({}, titleStyle, cssObject['.style6 .special-heading-inner-wrap:hover .be-title']);

	        //    console.log( titleStyle, titleHoverStyle, this.state.hovered );

	        return React.createElement(
	            'div',
	            { className: "oshine-module special-heading-wrap style6 " + (!isEmpty(animate) ? "be-animate " : ""), style: cssObject['.special-heading-wrap.style6'], 'data-animation': !isEmpty(animate) ? animationType : null },
	            React.createElement(
	                'div',
	                { className: "special-heading-inner-wrap" + (!isEmpty(borderStyle) ? " be-border-" + borderStyle : "") + (!isEmpty(expandOnHover) ? " be-expand" : ""), onMouseEnter: this.hoverHandler, onMouseLeave: this.hoverHandler },
	                React.createElement('div', { className: 'be-border', style: cssObject['.special-heading-wrap.style6 .be-border'] }),
	                React.createElement(
	                    'h6',
	                    { className: 'be-title', style: this.state.hovered ? titleHoverStyle : titleStyle },
	                    "string" === typeof title ? title : ""
	                )
	            )
	        );
	    }

	});
	module.exports = SpecialHeading6;

/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    parseValue = __webpack_require__(3);
	var SpecialSubTitle = React.createClass({
		displayName: 'SpecialSubTitle',


		getWrapperClass: function (atts) {

			var wrapperClass = 'oshine-module special-subtitle-wrap ',
			    animate = atts.get('animate'),
			    scrollToAnimate = atts.get('scroll_to_animate');
			if (!isEmpty(animate)) {
				wrapperClass = wrapperClass + 'be-animate ';
			}
			if (!isEmpty(scrollToAnimate)) {
				wrapperClass = wrapperClass + 'scrollToFade ';
			}
			return wrapperClass;
		},

		getTitleStyle: function (atts, specialSubTitle, moduleOptions) {

			var titleStyle = {},
			    moduleName = specialSubTitle.get('name'),
			    fontSize = parseValue(moduleName, 'font_size', atts.get('font_size'), moduleOptions),
			    titleColor = atts.get('title_color'),
			    maxWidth = parseValue(moduleName, 'max_width', atts.get('max_width'), moduleOptions);
			if ('string' === typeof fontSize && '' != fontSize.replace(/\D+/, '') && !isNaN(fontSize.replace(/\D+/, ''))) {
				titleStyle.fontSize = fontSize;
			}
			if (!isEmpty(titleColor)) {
				titleStyle.color = titleColor;
			}
			if ('string' === typeof maxWidth && '' != maxWidth.replace(/\D+/, '') && !isNaN(maxWidth.replace(/\D+/, ''))) {
				titleStyle.maxWidth = maxWidth;
			}
			return titleStyle;
		},

		render: function () {

			var specialSubTitle = this.props.module,
			    moduleOptions = this.props.moduleOptions,
			    atts = specialSubTitle.get('atts'),
			    wrapperClass = '',
			    animate = '',
			    animationType = '',
			    titleContent = '',

			//	titleStyle = {},
			//	bottomMargin = '0',
			alignment = '',
			    cssObject = this.props.cssObject.style,
			    gradientClass = this.props.cssObject.class;
			if (!isEmpty(atts)) {
				wrapperClass = this.getWrapperClass(atts);
				//	titleStyle = this.getTitleStyle( atts, specialSubTitle, moduleOptions );
				bottomMargin = parseValue(specialSubTitle.get('name'), 'margin_bottom', atts.get('margin_bottom'), moduleOptions);
				alignment = atts.get('title_alignment');
				animate = atts.get('animate');
				titleContent = atts.get('title_content');
				if (!isEmpty(animate)) {
					animationType = atts.get('animation_type');
				}
				// if( 'string' === typeof bottomMargin && '' != bottomMargin.replace( /\D+/, '' ) && !isNaN( bottomMargin.replace( /\D+/, '' ) ) ) {
				// 	bottomMargin = bottomMargin;
				// }else{
				// 	bottomMargin = null;
				// }
			}
			return React.createElement(
				'div',
				{ className: wrapperClass, style: cssObject['.special-subtitle-wrap'], 'data-animation': !isEmpty(animate) ? animationType : null },
				React.createElement(
					'div',
					{ className: "align-" + alignment },
					'undefined' != typeof titleContent ? React.createElement(
						'span',
						{ className: "special-subtitle " + gradientClass['.special-subtitle'], style: cssObject['.special-subtitle'] },
						' ',
						titleContent,
						' '
					) : null
				)
			);
		}

	});
	module.exports = SpecialSubTitle;

/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);

	var MenuCard = React.createClass({
	    displayName: 'MenuCard',


	    render: function () {
	        var menuCard = this.props.module,
	            atts = this.props.atts,
	            title,
	            ingredients,
	            price,
	            titleColor,
	            ingredientsColor,
	            priceColor,
	            highlight,
	            highlightColor,
	            star,
	            starColor,
	            borderColor,
	            animate,
	            animationType,
	            cssObject = this.props.cssObject.style;
	        if (!isEmpty(atts)) {
	            title = atts.get('title');
	            if (isEmpty(title)) {
	                title = null;
	            }
	            ingredients = atts.get('ingredients');
	            if (isEmpty(ingredients)) {
	                ingredients = null;
	            }
	            price = atts.get('price');
	            if (isEmpty(price)) {
	                price = null;
	            }

	            highlight = atts.get('highlight');
	            if (!isEmpty(highlight)) {
	                highlight = 'highlight-menu-item';
	            } else {
	                highlight = '';
	            }

	            star = atts.get('star');
	            if (isEmpty(star)) {
	                star = null;
	            }
	            animate = atts.get('animate');
	            if (!isEmpty(animate)) {
	                animate = 'be-animate';
	                animationType = atts.get('animation_type');
	                if (isEmpty(animationType)) {
	                    animationType = 'fadeIn';
	                }
	            } else {
	                animate = '';
	            }
	        }
	        return React.createElement(
	            'div',
	            { className: 'menu-card-item oshine-module ' + animate + ' clearfix ' + highlight, 'data-animation': animationType, style: cssObject['.menu-card-item'] },
	            React.createElement(
	                'div',
	                { className: 'menu-card-item-info' },
	                React.createElement(
	                    'span',
	                    { className: 'h6-font menu-card-title', style: cssObject['.menu-card-title'] },
	                    ' ',
	                    title,
	                    ' '
	                ),
	                React.createElement(
	                    'span',
	                    { className: 'menu-card-ingredients special-subtitle', style: cssObject['.menu-card-ingredients'] },
	                    ' ',
	                    ingredients,
	                    ' '
	                ),
	                React.createElement(
	                    'span',
	                    { className: 'menu-card-item-price', style: cssObject['.menu-card-item-price'] },
	                    ' ',
	                    price,
	                    ' '
	                ),
	                star ? React.createElement('i', { className: 'icon-icon_star menu-card-item-stared alt-color', style: cssObject['.menu-card-item-stared'] }) : null
	            )
	        );
	    }
	});

	module.exports = MenuCard;

/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    jsTrigger = __webpack_require__(27),
	    TabHeader = __webpack_require__(28),
	    TabPane = __webpack_require__(29);

	var Tabs = React.createClass({
	    displayName: 'Tabs',


	    render: function () {
	        var tabsCount = 0,
	            tabs = this.props.module,
	            moduleOptions = this.props.moduleOptions,
	            cssObject = this.props.cssObject,
	            atts = tabs.get('atts'),
	            children = tabs.get('inner') || Immutable.List(),
	            tabsCount = children.size;
	        return React.createElement(
	            'div',
	            { className: 'tabs oshine-module' },
	            React.createElement(
	                'ul',
	                { className: 'clearfix be-tab-header' },
	                children.map(function (tab) {

	                    return React.createElement(TabHeader, { key: tab.get('id'), tabsCount: tabsCount, module: tab, moduleOptions: moduleOptions, cssObject: cssObject });
	                })
	            ),
	            children.map(function (tab) {
	                return React.createElement(TabPane, { key: tab.get('id'), tabsCount: tabsCount, module: tab, moduleOptions: moduleOptions });
	            })
	        );
	    }
	});

	module.exports = Tabs;

/***/ }),
/* 27 */
/***/ (function(module, exports) {

	module.exports = function jsTrigger(moduleName, moduleId) {

	        var data = {
	                type: 'jstrigger',
	                moduleName: moduleName,
	                shouldUpdate: true,
	                moduleId: moduleId ? moduleId : ''
	        },
	            jsonData = JSON.stringify(data);
	        document.getElementById('tatsu-preview').contentWindow.postMessage(jsonData, '*');
	};

/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);

	var TabHeader = React.createClass({
	    displayName: 'TabHeader',

	    render: function () {
	        var tabHeader = this.props.module,
	            moduleOptions = this.props.moduleOptions,
	            tabsCount = this.props.tabsCount,
	            cssObject = this.props.cssObject.style,
	            key = tabHeader.get('id'),
	            rand = tabHeader.get('id'),
	            atts = tabHeader.get('atts'),
	            icon,
	            title,
	            titleColor;

	        titleColor = cssObject['#' + key];

	        if (!isEmpty(atts)) {
	            icon = atts.get('icon');
	            if (!isEmpty(icon)) {
	                icon = 'tab-icon ' + icon;
	            } else {
	                icon = '';
	            }
	            title = atts.get('title');
	            if (isEmpty(title)) {
	                title = '';
	            }
	        }
	        return React.createElement(
	            'li',
	            null,
	            React.createElement(
	                'a',
	                { className: icon, href: '#fragment-' + tabsCount + '-' + rand, style: titleColor },
	                title
	            )
	        );
	    }
	});

	module.exports = TabHeader;

/***/ }),
/* 29 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);

	var TabPane = React.createClass({
	    displayName: 'TabPane',


	    render: function () {
	        var tabPane = this.props.module,
	            tabsCount = this.props.tabsCount,
	            atts = tabPane.get('atts'),
	            id,
	            content;
	        id = tabPane.get('id');
	        if (isEmpty(id)) {
	            id = '';
	        }
	        content = atts.get('content');
	        if (isEmpty(content)) {
	            content = '';
	        }
	        return React.createElement('div', { id: 'fragment-' + tabsCount + '-' + id, dangerouslySetInnerHTML: { __html: content }, className: 'clearfix be-tab-content' });
	    }
	});

	module.exports = TabPane;

/***/ }),
/* 30 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    jsTrigger = __webpack_require__(27),
	    Toggle = __webpack_require__(31);

	var Accordion = React.createClass({
	    displayName: 'Accordion',


	    render: function () {

	        var accordion = this.props.module,
	            moduleOptions = this.props.moduleOptions,
	            atts = accordion.get('atts'),
	            cssObject = this.props.cssObject,
	            children = accordion.get('inner') || Immutable.List(),
	            toggle = Immutable.List(),
	            collapsed;
	        if (!isEmpty(atts)) {
	            collapsed = atts.get('collapsed');
	            if (isEmpty(collapsed)) {
	                collapsed = 0;
	            }
	        }

	        children.forEach(function (toggleItem) {
	            var atts = toggleItem.get('atts'),
	                content;
	            content = atts.get('content');
	            if (isEmpty(content)) {
	                content = '';
	            }
	            toggle = toggle.push(React.createElement(Toggle, { module: toggleItem, moduleOptions: moduleOptions, cssObject: cssObject }));
	            toggle = toggle.push(React.createElement('div', { dangerouslySetInnerHTML: { __html: content } }));
	        });

	        return React.createElement(
	            'div',
	            { className: 'accordion oshine-module', 'data-collapsed': collapsed },
	            toggle
	        );
	    }
	});

	module.exports = Accordion;

/***/ }),
/* 31 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);

	var Toggle = React.createClass({
	    displayName: 'Toggle',


	    getToggleStyle: function (atts) {

	        var toggleStyle = {},
	            titleColor,
	            titleBgColor;
	        titleColor = atts.get('title_color');
	        if (!isEmpty(titleColor)) {
	            toggleStyle.color = titleColor;
	        }
	        titleBgColor = atts.get('title_bg_color');
	        if (!isEmpty(titleBgColor)) {
	            toggleStyle.backgroundColor = titleBgColor;
	            toggleStyle.padding = '12px';
	        }
	        return toggleStyle;
	    },

	    render: function () {

	        var toggle = this.props.module,
	            atts = toggle.get('atts'),
	            cssObject = this.props.cssObject.style,
	            key = toggle.get('id'),
	            style = 'no-bg',
	            title,
	            titleBgColor,
	            toggleStyle;

	        newToggleStyle = cssObject['.' + key + '.accordion-head'];
	        if (!isEmpty(atts)) {
	            toggleStyle = this.getToggleStyle(atts);
	            title = atts.get('title');
	            if (isEmpty(title)) {
	                title = '';
	            }
	            titleBgColor = atts.get('title_bg_color');
	            if (!isEmpty(titleBgColor)) {
	                style = 'with-bg';
	            }
	        }

	        return React.createElement(
	            'h3',
	            { className: 'accordion-head ' + style, style: jQuery.extend({}, toggleStyle, newToggleStyle) },
	            title
	        );
	    }
	});

	module.exports = Toggle;

/***/ }),
/* 32 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    jsTrigger = __webpack_require__(27),
	    AnimateIconStyle1 = __webpack_require__(33);

	var AnimateIconsStyle1 = React.createClass({
	    displayName: 'AnimateIconsStyle1',


	    render: function () {

	        var animateIconsStyle1 = this.props.module,
	            moduleOptions = this.props.moduleOptions,
	            atts = animateIconsStyle1.get('atts'),
	            cssObject = this.props.cssObject,
	            children = animateIconsStyle1.get('inner') || Immutable.List(),
	            height,
	            gutter;

	        height = atts.get('height');
	        if (isEmpty(height)) {
	            height = 300;
	        }
	        gutter = atts.get('gutter');
	        if (isEmpty(gutter)) {
	            gutter = 0;
	        }

	        return React.createElement(
	            'div',
	            { className: 'oshine-module display-block' },
	            React.createElement(
	                'div',
	                { className: 'animate-icon-module-style1-wrap-container' },
	                React.createElement(
	                    'div',
	                    { className: 'animate-icon-module-style1-wrap clearfix', style: cssObject.style['.animate-icon-module-style1-wrap'], 'data-gutter-width': gutter },
	                    children.map(function (animateIcon) {
	                        return React.createElement(AnimateIconStyle1, { gutter: gutter, module: animateIcon, cssObject: cssObject, moduleOptions: moduleOptions });
	                    })
	                )
	            )
	        );
	    }

	});

	module.exports = AnimateIconsStyle1;

/***/ }),
/* 33 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);

	var AnimateIconStyle1 = React.createClass({
	    displayName: 'AnimateIconStyle1',


	    getInitialState: function () {
	        return {
	            isMouseIn: false
	        };
	    },

	    hoverHandler: function () {
	        this.setState({
	            isMouseIn: !this.state.isMouseIn
	        });
	    },

	    render: function () {
	        var animateIconStyle1 = this.props.module,
	            moduleOptions = this.props.moduleOptions,
	            beAnimateIconStyle1Gutter = this.props.gutter,
	            atts = animateIconStyle1.get('atts'),
	            cssObject = this.props.cssObject.style,
	            key = animateIconStyle1.get('id'),
	            icon,
	            title,
	            TitleFont,
	            size,
	            linkToUrl,
	            height,
	            bgImage,
	            bgColor,
	            hoverBgColor,
	            bgOverlay,
	            overlayColor,
	            hoverOverlayOpacity,
	            animateDirection,
	            bgOverlayClass,
	            content,
	            style = {};

	        if (!isEmpty(atts)) {
	            icon = atts.get('icon');
	            if (isEmpty(icon)) {
	                icon = '';
	            }
	            title = atts.get('title');
	            if (isEmpty(title)) {
	                title = null;
	            }
	            TitleFont = atts.get('title_font');
	            if (isEmpty(TitleFont)) {
	                TitleFont = 'h6';
	            }
	            size = atts.get('size');
	            if (isEmpty(size)) {
	                size = 30;
	            }

	            linkToUrl = atts.get('link_to_url');
	            if (isEmpty(linkToUrl)) {
	                linkToUrl = '#';
	            }
	            height = atts.get('height');
	            if (isEmpty(height)) {
	                height = '';
	            }
	            bgImage = atts.get('bg_image');
	            if (isEmpty(bgImage)) {
	                bgImage = '';
	            }
	            bgOverlay = atts.get('bg_overlay');
	            if (isEmpty(bgOverlay)) {
	                bgOverlay = 0;
	            }

	            animateDirection = atts.get('animate_direction');
	            if (isEmpty(animateDirection)) {
	                animateDirection = 'top';
	            }
	            if (!isEmpty(bgOverlay)) {
	                bgOverlayClass = 'ai-has-overlay';
	            } else {
	                bgOverlayClass = '';
	            }
	            content = atts.get('content');
	            if (isEmpty(content)) {
	                content = '';
	            }
	            style.marginBottom = beAnimateIconStyle1Gutter + 'px';
	            if (!isEmpty(bgImage)) {
	                style.background = 'url(' + bgImage + ')';
	            }
	            style.backgroundColor = bgColor;

	            var newIconStyle = cssObject['.' + key + ' .font-icon'];
	            if (isEmpty(bgImage)) {
	                if (this.state.isMouseIn) {
	                    style = jQuery.extend({}, style, cssObject['.' + key + ':hover']);
	                } else {
	                    style = jQuery.extend({}, style, cssObject['.' + key]);
	                }
	            }
	            if (this.state.isMouseIn) {
	                overlayColor = cssObject['.' + key + ':hover .ai-overlay'];
	            } else {
	                overlayColor = cssObject['.' + key + ' .ai-overlay'];
	            }

	            return React.createElement(
	                'a',
	                { onMouseEnter: this.hoverHandler.bind(this), onMouseLeave: this.hoverHandler.bind(this), href: linkToUrl, className: 'animate-icon-module-style1 be-bg-cover animate-icon-module ' + bgOverlayClass + ' ' + animateDirection + '-animate', style: style },
	                React.createElement(
	                    'div',
	                    { className: 'animate-icon-module-normal-content' },
	                    React.createElement(
	                        'div',
	                        { className: 'display-table' },
	                        React.createElement(
	                            'div',
	                            { className: 'display-table-cell vertical-align-middle' },
	                            React.createElement('i', { className: 'font-icon ' + icon, style: newIconStyle }),
	                            title ? React.createElement(
	                                TitleFont,
	                                { className: 'title_content', style: { color: newIconStyle.color } },
	                                ' ',
	                                title
	                            ) : null
	                        )
	                    )
	                ),
	                React.createElement(
	                    'div',
	                    { className: 'animate-icon-module-hover-content' },
	                    React.createElement(
	                        'div',
	                        { className: 'display-table' },
	                        React.createElement('div', { className: 'display-table-cell vertical-align-middle', dangerouslySetInnerHTML: { __html: content } })
	                    )
	                ),
	                !isEmpty(bgOverlay) && !isEmpty(bgImage) ? React.createElement('div', { className: 'ai-overlay', style: overlayColor }) : null
	            );
	        }
	    }

	});

	module.exports = AnimateIconStyle1;

/***/ }),
/* 34 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    jsTrigger = __webpack_require__(27),
	    AnimateIconStyle2 = __webpack_require__(35);

	var AnimateIconsStyle2 = React.createClass({
	    displayName: 'AnimateIconsStyle2',


	    render: function () {

	        var animateIconsStyle2 = this.props.module,
	            moduleOptions = this.props.moduleOptions,
	            atts = animateIconsStyle2.get('atts'),
	            cssObject = this.props.cssObject,
	            children = animateIconsStyle2.get('inner') || Immutable.List();

	        return React.createElement(
	            'div',
	            { className: 'oshine-module animate-icon-module-style2-wrap clearfix' },
	            children.map(function (animateIcon) {
	                return React.createElement(AnimateIconStyle2, { module: animateIcon, moduleOptions: moduleOptions, cssObject: cssObject });
	            })
	        );
	    }

	});

	module.exports = AnimateIconsStyle2;

/***/ }),
/* 35 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);

	var AnimateIconStyle2 = React.createClass({
	    displayName: 'AnimateIconStyle2',


	    getInitialState: function () {
	        return {
	            isMouseIn: false
	        };
	    },

	    hoverHandler: function () {
	        this.setState({
	            isMouseIn: !this.state.isMouseIn
	        });
	    },

	    render: function () {
	        var animateIconStyle2 = this.props.module,
	            moduleOptions = this.props.moduleOptions,
	            atts = animateIconStyle2.get('atts'),
	            cssObject = this.props.cssObject.style,
	            key = animateIconStyle2.get('id'),
	            icon,
	            size,
	            title,
	            Htag,
	            titleColor,
	            bgColor,
	            hoverBgColor,
	            content;

	        if (!isEmpty(atts)) {
	            icon = atts.get('icon');
	            if (isEmpty(icon)) {
	                icon = '';
	            }
	            size = atts.get('size');
	            if (isEmpty(size)) {
	                size = 30;
	            }
	            Htag = atts.get('h_tag');
	            if (isEmpty(Htag)) {
	                Htag = 'h6';
	            }
	            title = atts.get('title');
	            if (isEmpty(title)) {
	                title = '';
	            }

	            content = atts.get('content');
	            if (isEmpty(content)) {
	                content = '';
	            }

	            var newIconStyle, iconClass;
	            if (this.state.isMouseIn) {
	                bgColor = cssObject['.' + key + '.animate-icon-module-style2:hover'];
	                newIconStyle = cssObject['.' + key + '.animate-icon-module-style2:hover .animate-icon-icon'];
	                newIconStyle.fontSize = cssObject['.' + key + ' .animate-icon-icon'].fontSize;
	                iconClass = this.props.cssObject.class['.' + key + '.animate-icon-module-style2:hover .animate-icon-icon'];
	                titleColor = cssObject['.' + key + '.animate-icon-module-style2:hover .animate-icon-title'];
	            } else {
	                bgColor = cssObject['.' + key + '.animate-icon-module-style2'];
	                newIconStyle = cssObject['.' + key + ' .animate-icon-icon'];
	                iconClass = this.props.cssObject.class['.' + key + ' .animate-icon-icon'];
	                titleColor = cssObject['.' + key + ' .animate-icon-title'];
	            }

	            return React.createElement(
	                'div',
	                { onMouseEnter: this.hoverHandler.bind(this), onMouseLeave: this.hoverHandler.bind(this), className: 'animate-icon-module-style2', style: bgColor },
	                React.createElement(
	                    'div',
	                    { className: 'animate-icon-module-style2-inner-wrap' },
	                    React.createElement(
	                        'div',
	                        { className: 'animate-icon-module-style2-normal-content clearfix' },
	                        React.createElement('i', { className: iconClass + ' animate-icon-icon font-icon ' + icon, style: newIconStyle }),
	                        title ? React.createElement(
	                            Htag,
	                            { className: 'animate-icon-title', style: titleColor },
	                            title
	                        ) : null
	                    ),
	                    React.createElement('div', { className: 'animate-icon-module-style2-hover-content clearfix', dangerouslySetInnerHTML: { __html: content } })
	                )
	            );
	        }
	    }

	});

	module.exports = AnimateIconStyle2;

/***/ }),
/* 36 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2);

	var Team = React.createClass({
	    displayName: 'Team',


	    getInitialState: function () {
	        return {
	            iconHovered: 'empty'
	        };
	    },

	    hoverHandler: function (iconHovered) {
	        this.setState({
	            iconHovered: iconHovered
	        });
	    },

	    getIcon: function (atts, cssObject, gradientClass) {
	        'use strict';

	        var facebook,
	            twitter,
	            dribbble,
	            googlePlus,
	            linkedin,
	            youtube,
	            vimeo,
	            email,
	            iconLi = Immutable.List(),
	            iconBgColor,
	            iconColor,
	            iconHoverColor,
	            iconHoverBgColor,
	            smediaIconPosition,
	            overlayColor,
	            titleStyle,
	            thumbOverlayColor,
	            style = {};
	        var iconStyle = cssObject['i'],
	            iconHoverStyle = cssObject['i:hover'],
	            iconBgStyle = cssObject['.team_icons'],
	            iconBgHoverStyle = cssObject['.team_icons:hover'],
	            teamSocialStyle = cssObject['.team-social'],
	            iconGradientClass = gradientClass['i'],
	            iconBgGradientClass = gradientClass['.team_icons'],
	            teamSocialGradientclass = gradientClass['.team-social'];

	        iconBgColor = atts.get('icon_bg_color');
	        if (isEmpty(iconBgColor)) {
	            iconBgColor = 'transparent';
	        } else {
	            style.backgroundColor = iconBgColor;
	        }
	        iconColor = atts.get('icon_color');
	        if (isEmpty(iconColor)) {
	            iconColor = 'inherit';
	        } else {
	            style.color = iconColor;
	        }
	        iconHoverColor = atts.get('icon_hover_color');
	        if (isEmpty(iconHoverColor)) {
	            iconHoverColor = '';
	        }
	        iconHoverBgColor = atts.get('icon_hover_bg_color');
	        if (isEmpty(iconHoverBgColor)) {
	            iconHoverBgColor = '';
	        }
	        titleStyle = atts.get('title_style');
	        if (isEmpty(titleStyle)) {
	            titleStyle = 'style3';
	        }
	        smediaIconPosition = atts.get('smedia_icon_position');
	        if (isEmpty(smediaIconPosition)) {
	            smediaIconPosition = 'over';
	        }
	        if ('style3' == titleStyle) {
	            smediaIconPosition = 'over';
	        }
	        overlayColor = atts.get('overlay_color');
	        if (isEmpty(overlayColor)) {
	            overlayColor = '';
	            thumbOverlayColor = '';
	        } else {
	            thumbOverlayColor = overlayColor;
	        }
	        facebook = atts.get('facebook');
	        twitter = atts.get('twitter');
	        dribbble = atts.get('dribbble');
	        googlePlus = atts.get('google_plus');
	        linkedin = atts.get('linkedin');
	        youtube = atts.get('youtube');
	        vimeo = atts.get('vimeo');
	        email = atts.get('email');

	        // before removing data atts

	        if (!isEmpty(facebook) || !isEmpty(twitter) || !isEmpty(dribbble) || !isEmpty(googlePlus) || !isEmpty(linkedin) || !isEmpty(youtube) || !isEmpty(vimeo) || !isEmpty(email)) {
	            if (!isEmpty(facebook)) {
	                iconLi = iconLi.push(React.createElement(
	                    'li',
	                    { className: 'icon-shortcode' },
	                    React.createElement(
	                        'a',
	                        { href: facebook, className: 'font-icon tatsu-icon team_icons ' + iconBgGradientClass, target: '_blank', onMouseEnter: this.hoverHandler.bind(this, 'facebook'), onMouseLeave: this.hoverHandler.bind(this, 'empty'), style: this.state.iconHovered == 'facebook' ? iconBgHoverStyle : iconBgStyle },
	                        React.createElement('i', { className: 'icon-facebook ' + iconGradientClass, style: this.state.iconHovered == 'facebook' ? iconHoverStyle : iconStyle })
	                    )
	                ));
	            }
	            if (!isEmpty(twitter)) {
	                iconLi = iconLi.push(React.createElement(
	                    'li',
	                    { className: 'icon-shortcode' },
	                    React.createElement(
	                        'a',
	                        { href: twitter, className: 'font-icon tatsu-icon team_icons ' + iconBgGradientClass, target: '_blank', onMouseEnter: this.hoverHandler.bind(this, 'twitter'), onMouseLeave: this.hoverHandler.bind(this, 'empty'), style: this.state.iconHovered == 'twitter' ? iconBgHoverStyle : iconBgStyle },
	                        React.createElement('i', { className: 'icon-twitter ' + iconGradientClass, style: this.state.iconHovered == 'twitter' ? iconHoverStyle : iconStyle })
	                    )
	                ));
	            }
	            if (!isEmpty(googlePlus)) {
	                iconLi = iconLi.push(React.createElement(
	                    'li',
	                    { className: 'icon-shortcode' },
	                    React.createElement(
	                        'a',
	                        { href: googlePlus, className: 'font-icon tatsu-icon team_icons ' + iconBgGradientClass, target: '_blank', onMouseEnter: this.hoverHandler.bind(this, 'gplus'), onMouseLeave: this.hoverHandler.bind(this, 'empty'), style: this.state.iconHovered == 'gplus' ? iconBgHoverStyle : iconBgStyle },
	                        React.createElement('i', { className: 'icon-gplus ' + iconGradientClass, style: this.state.iconHovered == 'gplus' ? iconHoverStyle : iconStyle })
	                    )
	                ));
	            }
	            if (!isEmpty(linkedin)) {
	                iconLi = iconLi.push(React.createElement(
	                    'li',
	                    { className: 'icon-shortcode' },
	                    React.createElement(
	                        'a',
	                        { href: linkedin, className: 'font-icon tatsu-icon team_icons ' + iconBgGradientClass, target: '_blank', onMouseEnter: this.hoverHandler.bind(this, 'linkedin'), onMouseLeave: this.hoverHandler.bind(this, 'empty'), style: this.state.iconHovered == 'linkedin' ? iconBgHoverStyle : iconBgStyle },
	                        React.createElement('i', { className: 'icon-linkedin ' + iconGradientClass, style: this.state.iconHovered == 'linkedin' ? iconHoverStyle : iconStyle })
	                    )
	                ));
	            }
	            if (!isEmpty(youtube)) {
	                iconLi = iconLi.push(React.createElement(
	                    'li',
	                    { className: 'icon-shortcode' },
	                    React.createElement(
	                        'a',
	                        { href: youtube, className: 'font-icon tatsu-icon team_icons ' + iconBgGradientClass, target: '_blank', onMouseEnter: this.hoverHandler.bind(this, 'youtube'), onMouseLeave: this.hoverHandler.bind(this, 'empty'), style: this.state.iconHovered == 'youtube' ? iconBgHoverStyle : iconBgStyle },
	                        React.createElement('i', { className: 'icon-youtube ' + iconGradientClass, style: this.state.iconHovered == 'youtube' ? iconHoverStyle : iconStyle })
	                    )
	                ));
	            }
	            if (!isEmpty(dribbble)) {
	                iconLi = iconLi.push(React.createElement(
	                    'li',
	                    { className: 'icon-shortcode' },
	                    React.createElement(
	                        'a',
	                        { href: dribbble, className: 'font-icon tatsu-icon team_icons ' + iconBgGradientClass, target: '_blank', onMouseEnter: this.hoverHandler.bind(this, 'dribble'), onMouseLeave: this.hoverHandler.bind(this, 'empty'), style: this.state.iconHovered == 'dribble' ? iconBgHoverStyle : iconBgStyle },
	                        React.createElement('i', { className: 'icon-dribbble ' + iconGradientClass, style: this.state.iconHovered == 'dribble' ? iconHoverStyle : iconStyle })
	                    )
	                ));
	            }
	            if (!isEmpty(vimeo)) {
	                iconLi = iconLi.push(React.createElement(
	                    'li',
	                    { className: 'icon-shortcode' },
	                    React.createElement(
	                        'a',
	                        { href: vimeo, className: 'font-icon tatsu-icon team_icons ' + iconBgGradientClass, target: '_blank', onMouseEnter: this.hoverHandler.bind(this, 'vimeo'), onMouseLeave: this.hoverHandler.bind(this, 'empty'), style: this.state.iconHovered == 'vimeo' ? iconBgHoverStyle : iconBgStyle },
	                        React.createElement('i', { className: 'icon-vimeo ' + iconGradientClass, style: this.state.iconHovered == 'vimeo' ? iconHoverStyle : iconStyle })
	                    )
	                ));
	            }
	            if (!isEmpty(email)) {
	                iconLi = iconLi.push(React.createElement(
	                    'li',
	                    { className: 'icon-shortcode' },
	                    React.createElement(
	                        'a',
	                        { href: email, className: 'font-icon tatsu-icon team_icons ' + iconBgGradientClass, target: '_blank', onMouseEnter: this.hoverHandler.bind(this, 'mail'), onMouseLeave: this.hoverHandler.bind(this, 'empty'), style: this.state.iconHovered == 'mail' ? iconBgHoverStyle : iconBgStyle },
	                        React.createElement('i', { className: 'icon-email ' + iconGradientClass, style: this.state.iconHovered == 'mail' ? iconHoverStyle : iconStyle })
	                    )
	                ));
	            }
	        }
	        return React.createElement(
	            'ul',
	            { className: 'team-social clearfix ' + smediaIconPosition + ' ' + teamSocialGradientclass, style: teamSocialStyle },
	            iconLi
	        );
	    },

	    render: function () {

	        var team = this.props.module,
	            moduleOptions = this.props.moduleOptions,
	            atts = team.get('atts'),
	            title,
	            HTag,
	            description,
	            designation,
	            image,
	            titleColor,
	            descriptionColor,
	            designationColor,
	            hoverStyle,
	            titleStyle,
	            smediaIconPosition,
	            titleAlignmentStatic,
	            defaultImageStyle,
	            hoverImageStyle,
	            imageEffect,
	            overlayColor,
	            animate,
	            animationType,
	            iconDefaultColor,
	            imgGrayscale,
	            icon,
	            thumbOverlayColor;

	        var cssObject = this.props.cssObject.style,
	            gradientClass = this.props.cssObject.class,
	            overlayStyle = cssObject['.thumb-bg'],
	            titleNameStyle = cssObject['.team-title'],
	            designationStyle = cssObject['.designation'],
	            descriptionStyle = cssObject['.team-description'],
	            teamWrapStyle = cssObject['.team-wrap'],
	            overlayGradientClass = gradientClass['.thumb-bg'],
	            titleGradientClass = gradientClass['.team-title'],
	            designationGradientClass = gradientClass['.designation'],
	            descriptionGradientClass = gradientClass['.team-description'];

	        if (!isEmpty(atts)) {
	            title = atts.get('title');
	            if (isEmpty(title)) {
	                title = '';
	            }
	            HTag = atts.get('h_tag');
	            if (isEmpty(HTag)) {
	                HTag = 'H6';
	            }
	            description = atts.get('description');
	            if (isEmpty(description)) {
	                description = '';
	            }
	            designation = atts.get('designation');
	            if (isEmpty(designation)) {
	                designation = '';
	            }
	            image = atts.get('image');
	            if (isEmpty(image)) {
	                image = '';
	            }
	            titleColor = atts.get('title_color');
	            if (isEmpty(titleColor)) {
	                titleColor = null;
	            }
	            descriptionColor = atts.get('description_color');
	            if (isEmpty(descriptionColor)) {
	                descriptionColor = '';
	            }
	            designationColor = atts.get('designation_color');
	            if (isEmpty(designationColor)) {
	                designationColor = '';
	            }
	            hoverStyle = atts.get('hover_style');
	            if (isEmpty(hoverStyle)) {
	                hoverStyle = 'style1-hover';
	            }
	            titleStyle = atts.get('title_style');
	            if (isEmpty(titleStyle)) {
	                titleStyle = 'style3';
	            }
	            smediaIconPosition = atts.get('smedia_icon_position');
	            if (isEmpty(smediaIconPosition)) {
	                smediaIconPosition = 'over';
	            }
	            if ('style3' == titleStyle) {
	                smediaIconPosition = 'over';
	            }
	            titleAlignmentStatic = atts.get('title_alignment_static');
	            if (isEmpty(titleAlignmentStatic) && 'style5' != titleStyle) {
	                titleAlignmentStatic = '';
	            }
	            defaultImageStyle = atts.get('default_image_style');
	            if (isEmpty(defaultImageStyle)) {
	                defaultImageStyle = 'color';
	            }
	            hoverImageStyle = atts.get('hover_image_style');
	            if (isEmpty(hoverImageStyle)) {
	                hoverImageStyle = 'color';
	            }
	            imageEffect = atts.get('image_effect');
	            if (isEmpty(imageEffect)) {
	                imageEffect = 'none';
	            }
	            overlayColor = atts.get('overlay_color');
	            if (isEmpty(overlayColor)) {
	                overlayColor = '';
	                thumbOverlayColor = '';
	            } else {
	                thumbOverlayColor = overlayColor;
	            }
	            animate = atts.get('animate');
	            if (!isEmpty(animate)) {
	                animate = ' be-animate';
	            } else {
	                animate = '';
	            }
	            animationType = atts.get('animation_type');
	            if (isEmpty(animationType)) {
	                animationType = 'fadeIn';
	            }
	            if ('black_white' == defaultImageStyle) {
	                if ('black_white' == hoverImageStyle) {
	                    imgGrayscale = 'bw_to_bw';
	                } else {
	                    imgGrayscale = 'bw_to_c';
	                }
	            } else {
	                if ('black_white' == hoverImageStyle) {
	                    imgGrayscale = 'c_to_bw';
	                } else {
	                    imgGrayscale = 'c_to_c';
	                }
	            }
	            icon = this.getIcon(atts, cssObject, gradientClass);
	            if ('style5' == titleStyle) {
	                hoverStyle = '';
	            }
	        }

	        return React.createElement(
	            'div',
	            { className: 'team-shortcode-wrap oshine-module ' + animate, 'data-animation': animationType },
	            React.createElement(
	                'div',
	                { className: 'element ' + hoverStyle + ' ' + imgGrayscale + ' ' + titleStyle + '-title' },
	                React.createElement(
	                    'div',
	                    { className: 'element-inner' },
	                    React.createElement(
	                        'div',
	                        { className: 'flip-wrap' },
	                        React.createElement(
	                            'div',
	                            { className: 'flip-img-wrap ' + imageEffect + '-effect' },
	                            React.createElement('img', { src: image, alt: title }),
	                            'over' == smediaIconPosition && 'style3' != titleStyle ? icon : null
	                        )
	                    ),
	                    React.createElement(
	                        'div',
	                        { className: 'thumb-overlay' },
	                        React.createElement(
	                            'div',
	                            { className: 'thumb-bg ' + overlayGradientClass, style: overlayStyle },
	                            React.createElement(
	                                'div',
	                                { className: 'display-table' },
	                                React.createElement(
	                                    'div',
	                                    { className: 'display-table-cell vertical-align-middle' },
	                                    React.createElement(
	                                        'div',
	                                        { className: 'team-wrap clearfix', style: teamWrapStyle },
	                                        React.createElement(
	                                            HTag,
	                                            { className: 'team-title ' + titleGradientClass, style: titleNameStyle },
	                                            title
	                                        ),
	                                        React.createElement(
	                                            'p',
	                                            { className: 'designation ' + designationGradientClass, style: designationStyle },
	                                            designation
	                                        ),
	                                        React.createElement(
	                                            'p',
	                                            { className: 'team-description ' + descriptionGradientClass, style: descriptionStyle },
	                                            description
	                                        ),
	                                        'below' == smediaIconPosition || 'style3' == titleStyle ? icon : null
	                                    )
	                                )
	                            )
	                        )
	                    )
	                )
	            )
	        );
	    }
	});

	module.exports = Team;

/***/ }),
/* 37 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    findDOMNode = ReactDOM.findDOMNode,
	    shortId = __webpack_require__(38),
	    jsTrigger = __webpack_require__(27);

	var SvgIcon = React.createClass({
	    displayName: 'SvgIcon',


	    triggerAnimation: false,

	    // componentWillReceiveProps : function( nextProps ) {

	    //     var currentAtts = this.props.module.get( 'atts' ),
	    //         newAtts = nextProps.module.get( 'atts' );
	    //     if( currentAtts.get( 'line_animate' ) != newAtts.get( 'line_animate' ) || currentAtts.get( 'path_animation_type' ) != newAtts.get( 'path_animation_type' ) || currentAtts.get( 'svg_animation_type' ) != newAtts.get( 'svg_animation_type' ) || currentAtts.get( 'animation_duration' ) != newAtts.get( 'animation_duration' ) || currentAtts.get( 'animation_delay' ) != newAtts.get( 'animation_delay' ) ) {
	    //         this.triggerAnimation = true;
	    //     }

	    // },

	    componentDidMount: function () {
	        var atts = this.props.module.get('atts'),
	            url = atts.get('content');
	        // var abc = 'svg-'+this.svgId;
	        // var vivus = new Vivus(abc,{file:url},null);
	        //http://localhost:8888/newOshine/wp-content/uploads/2018/05/react-custom-svg.svg
	    },

	    componentDidUpdate: function () {

	        var atts = this.props.module.get('atts'),
	            animation = atts.get('animate'),
	            moduleName = this.props.module.get('name'),
	            moduleId = this.props.module.get('id'),
	            animationType = atts.get('animation_type');
	        if (isEmpty(atts.get('alignment'))) {
	            findDOMNode(this).parentElement.style.display = 'inline-block';
	        } else {
	            findDOMNode(this).parentElement.style.display = 'block';
	        }
	    },
	    render: function () {

	        //console.log('mysvg',this.props.cssObject);
	        this.svgId = shortId.generate();

	        var svgIcon = this.props.module,
	            moduleOptions = this.props.moduleOptions,
	            atts = svgIcon.get('atts'),
	            content,
	            size,
	            width,
	            height,
	            color,
	            alignment,
	            lineAnimate,
	            pathAnimationType,
	            svgAnimationType,
	            animationDuration,
	            animationDelay;

	        content = atts.get('content');
	        if (isEmpty(content)) {
	            content = '';
	        }
	        size = atts.get('size');
	        if (isEmpty(size)) {
	            size = 'small';
	        }
	        if ('custom' == size) {
	            width = atts.get('width');
	            if (isEmpty(width)) {
	                width = null;
	            } else {
	                width += 'px';
	            }
	            height = atts.get('height');
	            if (isEmpty(height)) {
	                height = null;
	            } else {
	                height += 'px';
	            }
	        } else {
	            width = null;
	            height = null;
	        }
	        color = this.props.cssObject.style['.oshine-svg-icon svg'].color;

	        alignment = atts.get('alignment');
	        if (isEmpty(alignment)) {
	            alignment = '';
	        }
	        lineAnimate = atts.get('line_animate');
	        if (isEmpty(lineAnimate)) {
	            lineAnimate = '';
	        } else if (lineAnimate == 1) {
	            lineAnimate = 'svg-line-animate ';
	            pathAnimationType = atts.get('path_animation_type');
	            if (isEmpty(pathAnimationType)) {
	                pathAnimationType = null;
	            }
	            svgAnimationType = atts.get('svg_animation_type');
	            if (isEmpty(svgAnimationType)) {
	                svgAnimationType = null;
	            }
	            animationDuration = atts.get('animation_duration');
	            if (isEmpty(animationDuration)) {
	                animationDuration = 0;
	            }
	            animationDelay = atts.get('animation_delay');
	            if (isEmpty(animationDelay)) {
	                animationDelay = 0;
	            }
	        }
	        return React.createElement('div', { ref: 'svgelement', className: 'oshine-svg-icon oshine-module ' + lineAnimate + ' align-' + alignment + ' ' + size, 'data-path-animation': pathAnimationType, 'data-svg-animation': svgAnimationType, 'data-animation-delay': lineAnimate ? animationDelay : 1, 'data-animation-duration': lineAnimate ? animationDuration : 2, style: { color: color, width: width, height: height }, 'data-svg-url': content, 'data-target': 'svg-' + this.svgId, dangerouslySetInnerHTML: { __html: '<span  id=svg-' + this.svgId + ' ></span>' } });
	    }

	});

	module.exports = SvgIcon;

/***/ }),
/* 38 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	module.exports = __webpack_require__(39);


/***/ }),
/* 39 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var alphabet = __webpack_require__(40);
	var encode = __webpack_require__(42);
	var decode = __webpack_require__(44);
	var build = __webpack_require__(45);
	var isValid = __webpack_require__(46);

	// if you are using cluster or multiple servers use this to make each instance
	// has a unique value for worker
	// Note: I don't know if this is automatically set when using third
	// party cluster solutions such as pm2.
	var clusterWorkerId = __webpack_require__(47) || 0;

	/**
	 * Set the seed.
	 * Highly recommended if you don't want people to try to figure out your id schema.
	 * exposed as shortid.seed(int)
	 * @param seed Integer value to seed the random alphabet.  ALWAYS USE THE SAME SEED or you might get overlaps.
	 */
	function seed(seedValue) {
	    alphabet.seed(seedValue);
	    return module.exports;
	}

	/**
	 * Set the cluster worker or machine id
	 * exposed as shortid.worker(int)
	 * @param workerId worker must be positive integer.  Number less than 16 is recommended.
	 * returns shortid module so it can be chained.
	 */
	function worker(workerId) {
	    clusterWorkerId = workerId;
	    return module.exports;
	}

	/**
	 *
	 * sets new characters to use in the alphabet
	 * returns the shuffled alphabet
	 */
	function characters(newCharacters) {
	    if (newCharacters !== undefined) {
	        alphabet.characters(newCharacters);
	    }

	    return alphabet.shuffled();
	}

	/**
	 * Generate unique id
	 * Returns string id
	 */
	function generate() {
	  return build(clusterWorkerId);
	}

	// Export all other functions as properties of the generate function
	module.exports = generate;
	module.exports.generate = generate;
	module.exports.seed = seed;
	module.exports.worker = worker;
	module.exports.characters = characters;
	module.exports.decode = decode;
	module.exports.isValid = isValid;


/***/ }),
/* 40 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var randomFromSeed = __webpack_require__(41);

	var ORIGINAL = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
	var alphabet;
	var previousSeed;

	var shuffled;

	function reset() {
	    shuffled = false;
	}

	function setCharacters(_alphabet_) {
	    if (!_alphabet_) {
	        if (alphabet !== ORIGINAL) {
	            alphabet = ORIGINAL;
	            reset();
	        }
	        return;
	    }

	    if (_alphabet_ === alphabet) {
	        return;
	    }

	    if (_alphabet_.length !== ORIGINAL.length) {
	        throw new Error('Custom alphabet for shortid must be ' + ORIGINAL.length + ' unique characters. You submitted ' + _alphabet_.length + ' characters: ' + _alphabet_);
	    }

	    var unique = _alphabet_.split('').filter(function(item, ind, arr){
	       return ind !== arr.lastIndexOf(item);
	    });

	    if (unique.length) {
	        throw new Error('Custom alphabet for shortid must be ' + ORIGINAL.length + ' unique characters. These characters were not unique: ' + unique.join(', '));
	    }

	    alphabet = _alphabet_;
	    reset();
	}

	function characters(_alphabet_) {
	    setCharacters(_alphabet_);
	    return alphabet;
	}

	function setSeed(seed) {
	    randomFromSeed.seed(seed);
	    if (previousSeed !== seed) {
	        reset();
	        previousSeed = seed;
	    }
	}

	function shuffle() {
	    if (!alphabet) {
	        setCharacters(ORIGINAL);
	    }

	    var sourceArray = alphabet.split('');
	    var targetArray = [];
	    var r = randomFromSeed.nextValue();
	    var characterIndex;

	    while (sourceArray.length > 0) {
	        r = randomFromSeed.nextValue();
	        characterIndex = Math.floor(r * sourceArray.length);
	        targetArray.push(sourceArray.splice(characterIndex, 1)[0]);
	    }
	    return targetArray.join('');
	}

	function getShuffled() {
	    if (shuffled) {
	        return shuffled;
	    }
	    shuffled = shuffle();
	    return shuffled;
	}

	/**
	 * lookup shuffled letter
	 * @param index
	 * @returns {string}
	 */
	function lookup(index) {
	    var alphabetShuffled = getShuffled();
	    return alphabetShuffled[index];
	}

	module.exports = {
	    characters: characters,
	    seed: setSeed,
	    lookup: lookup,
	    shuffled: getShuffled
	};


/***/ }),
/* 41 */
/***/ (function(module, exports) {

	'use strict';

	// Found this seed-based random generator somewhere
	// Based on The Central Randomizer 1.3 (C) 1997 by Paul Houle (houle@msc.cornell.edu)

	var seed = 1;

	/**
	 * return a random number based on a seed
	 * @param seed
	 * @returns {number}
	 */
	function getNextValue() {
	    seed = (seed * 9301 + 49297) % 233280;
	    return seed/(233280.0);
	}

	function setSeed(_seed_) {
	    seed = _seed_;
	}

	module.exports = {
	    nextValue: getNextValue,
	    seed: setSeed
	};


/***/ }),
/* 42 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var randomByte = __webpack_require__(43);

	function encode(lookup, number) {
	    var loopCounter = 0;
	    var done;

	    var str = '';

	    while (!done) {
	        str = str + lookup( ( (number >> (4 * loopCounter)) & 0x0f ) | randomByte() );
	        done = number < (Math.pow(16, loopCounter + 1 ) );
	        loopCounter++;
	    }
	    return str;
	}

	module.exports = encode;


/***/ }),
/* 43 */
/***/ (function(module, exports) {

	'use strict';

	var crypto = typeof window === 'object' && (window.crypto || window.msCrypto); // IE 11 uses window.msCrypto

	function randomByte() {
	    if (!crypto || !crypto.getRandomValues) {
	        return Math.floor(Math.random() * 256) & 0x30;
	    }
	    var dest = new Uint8Array(1);
	    crypto.getRandomValues(dest);
	    return dest[0] & 0x30;
	}

	module.exports = randomByte;


/***/ }),
/* 44 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	var alphabet = __webpack_require__(40);

	/**
	 * Decode the id to get the version and worker
	 * Mainly for debugging and testing.
	 * @param id - the shortid-generated id.
	 */
	function decode(id) {
	    var characters = alphabet.shuffled();
	    return {
	        version: characters.indexOf(id.substr(0, 1)) & 0x0f,
	        worker: characters.indexOf(id.substr(1, 1)) & 0x0f
	    };
	}

	module.exports = decode;


/***/ }),
/* 45 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';

	var encode = __webpack_require__(42);
	var alphabet = __webpack_require__(40);

	// Ignore all milliseconds before a certain time to reduce the size of the date entropy without sacrificing uniqueness.
	// This number should be updated every year or so to keep the generated id short.
	// To regenerate `new Date() - 0` and bump the version. Always bump the version!
	var REDUCE_TIME = 1459707606518;

	// don't change unless we change the algos or REDUCE_TIME
	// must be an integer and less than 16
	var version = 6;

	// Counter is used when shortid is called multiple times in one second.
	var counter;

	// Remember the last time shortid was called in case counter is needed.
	var previousSeconds;

	/**
	 * Generate unique id
	 * Returns string id
	 */
	function build(clusterWorkerId) {

	    var str = '';

	    var seconds = Math.floor((Date.now() - REDUCE_TIME) * 0.001);

	    if (seconds === previousSeconds) {
	        counter++;
	    } else {
	        counter = 0;
	        previousSeconds = seconds;
	    }

	    str = str + encode(alphabet.lookup, version);
	    str = str + encode(alphabet.lookup, clusterWorkerId);
	    if (counter > 0) {
	        str = str + encode(alphabet.lookup, counter);
	    }
	    str = str + encode(alphabet.lookup, seconds);

	    return str;
	}

	module.exports = build;


/***/ }),
/* 46 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	var alphabet = __webpack_require__(40);

	function isShortId(id) {
	    if (!id || typeof id !== 'string' || id.length < 6 ) {
	        return false;
	    }

	    var characters = alphabet.characters();
	    var len = id.length;
	    for(var i = 0; i < len;i++) {
	        if (characters.indexOf(id[i]) === -1) {
	            return false;
	        }
	    }
	    return true;
	}

	module.exports = isShortId;


/***/ }),
/* 47 */
/***/ (function(module, exports) {

	'use strict';

	module.exports = 0;


/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {

	var isEmpty = __webpack_require__(2),
	    findDOMNode = ReactDOM.findDOMNode;

	var AnimatedLink = React.createClass({
	    displayName: 'AnimatedLink',


	    getInitialState: function () {
	        return {
	            isMouseIn: false
	        };
	    },

	    hoverHandler: function () {
	        this.setState({
	            isMouseIn: !this.state.isMouseIn
	        });
	    },

	    componentDidMount: function () {

	        var atts = this.props.module.get('atts');
	        if (isEmpty(atts.get('alignment'))) {
	            findDOMNode(this).parentElement.style.display = 'inline-block';
	        } else {
	            findDOMNode(this).parentElement.style.display = 'block';
	        }
	    },

	    componentDidUpdate: function () {

	        var atts = this.props.module.get('atts');
	        if (isEmpty(atts.get('alignment'))) {
	            findDOMNode(this).parentElement.style.display = 'inline-block';
	        } else {
	            findDOMNode(this).parentElement.style.display = 'block';
	        }
	    },

	    render: function () {
	        var animatedLink = this.props.module,
	            atts = animatedLink.get('atts'),
	            linkText,
	            url,
	            fontSize,
	            cssObject = this.props.cssObject.style,
	            linkStyle,
	            alignment,
	            color,
	            hoverColor,
	            lineColor,
	            lineHoverColor,
	            animate,
	            animationType,
	            animationDelay;

	        lineColor = cssObject['.animated-link:before'];
	        lineHoverColor = cssObject['.animated-link:hover:before'];
	        color = cssObject['.link-text'];
	        hoverColor = cssObject['.animated-link:hover .link-text'];
	        if (this.state.isMouseIn) {
	            lineColor = lineHoverColor;
	            color = hoverColor;
	        }

	        fontSize = cssObject['a'];

	        if (!isEmpty(atts)) {
	            linkText = atts.get('link_text');
	            if (isEmpty(linkText)) {
	                linkText = null;
	            }
	            url = atts.get('url');
	            if (isEmpty(url)) {
	                url = null;
	            }
	            linkStyle = atts.get('link_style');
	            if (isEmpty(linkStyle)) {
	                linkStyle = 'style1';
	            }
	            alignment = atts.get('alignment');
	            if (isEmpty(alignment)) {
	                alignment = 'none';
	            }

	            animate = atts.get('animate');
	            if (!isEmpty(animate)) {
	                animate = 'tatsu-animate';
	                animationType = atts.get('animation_type');
	                if (isEmpty(animationType)) {
	                    animationType = 'fadeIn';
	                }
	                animationDelay = atts.get('animation_delay');
	                if (isEmpty(animationDelay)) {
	                    animationDelay = 0;
	                }
	            } else {
	                animate = '';
	            }
	        }
	        return React.createElement(
	            'div',
	            { className: 'oshine-animated-link oshine-module align-' + alignment },
	            React.createElement(
	                'a',
	                { onMouseEnter: this.hoverHandler.bind(this), onMouseLeave: this.hoverHandler.bind(this), className: 'animated-link-' + linkStyle + ' ' + animate, href: url, style: jQuery.extend({}, lineColor, fontSize), 'data-animation': animationType, 'data-animation-delay': animationDelay },
	                React.createElement(
	                    'span',
	                    { className: 'link-text', style: color },
	                    linkText
	                ),
	                linkStyle == 'style4' || linkStyle == 'style5' ? React.createElement(
	                    'div',
	                    { className: 'next-arrow' },
	                    React.createElement('span', { className: 'arrow-line-one', style: { backgroundColor: lineColor.color } }),
	                    React.createElement('span', { className: 'arrow-line-two', style: { backgroundColor: lineColor.color } }),
	                    React.createElement('span', { className: 'arrow-line-three', style: { backgroundColor: lineColor.color } })
	                ) : null
	            )
	        );
	    }
	});

	module.exports = AnimatedLink;

/***/ })
/******/ ]);