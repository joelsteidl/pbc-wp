;(function($) {
    /**
   * Resize Background Video
   */
    $.fn.tatsuResizeMedia = function() {
        if( this.length > 0 ) {
            this.each(function () {
                var $img = jQuery(this), 
                $section = $img.parent(), 
                windowWidth = $section.width(), 
                windowHeight = $section.outerHeight(), 
                r_w = windowHeight / windowWidth, 
                i_w = $img.width(), 
                i_h = $img.height(), 
                r_i = i_h / i_w, 
                new_w, 
                new_h;
                
                if (r_w > r_i) {
                    new_h = windowHeight;
                    new_w = windowHeight / r_i;
                } else {
                    new_h = windowWidth * r_i;
                    new_w = windowWidth;
                }
                $img.css({
                    width : new_w,
                    height : new_h,
                    left : (windowWidth - new_w) / 2,
                    top : (windowHeight - new_h) / 2,
                    display : 'block'
                });
            });
        }
  };
    
})(jQuery);

;(function($) {
    /**
   * Copyright 2012, Digital Fusion
   * Licensed under the MIT license.
   * http://teamdf.com/jquery-plugins/license/
   *
   * @author Sam Sehnert
   * @desc A small plugin that checks whether elements are within
   *     the user visible viewport of a web browser.
   *     only accounts for vertical position, not horizontal.
   */
    $.fn.visible = function(partial) {
    
      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;
    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };
    
})(jQuery);

;(function($) {
    /**
   * Copyright 2012, Digital Fusion
   * Licensed under the MIT license.
   * http://teamdf.com/jquery-plugins/license/
   *
   * @author Sam Sehnert
   * @desc A small plugin that checks whether elements are within
   *     the user visible viewport of a web browser.
   *     only accounts for vertical position, not horizontal.
   */
    $.fn.visible = function(partial) {
    
      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;
    
    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };
    
})(jQuery);
(function( $ ) {
    'use strict';

    var vendorScriptsUrl = tatsuFrontendConfig.vendorScriptsUrl,
        dependencies = tatsuFrontendConfig.dependencies || {},
        maps_api_key = tatsuFrontendConfig.mapsApiKey;


    if( 'undefined' != typeof dependencies ) {
		for( var dependency in dependencies ) {
			if( dependencies.hasOwnProperty( dependency ) ) {
				asyncloader.register( dependencies[ dependency ], dependency );
			}
		}
    }
    asyncloader.register( 'https://maps.googleapis.com/maps/api/js?key='+maps_api_key, 'google_maps_api' );
    

    var tatsu = (function() {

        var $window = jQuery(window),
            $body = jQuery('body'),
            $html = jQuery('html'),
            $pluginUrl = tatsuFrontendConfig.pluginUrl,
            tatsuCallbacks = {},
            didScroll = false,
            animate_wrapper = jQuery('.tatsu-animate, .be-animate'),
            scrollInterval,
            animateWrapperCount = animate_wrapper.length,
            alreadyVisibleIndex = 0,
            animatedNumberWrap = jQuery('.tatsu-an'),
            totalAnimCount = animate_wrapper.length + animatedNumberWrap.length,

        animatedAnchor = function() {

            jQuery(document).on( 'mouseenter.tatsu mouseleave.tatsu', '.be-animated-anchor', function(e) {
                
                var $this = jQuery( this ),
                    hoverColor,
                    borderColor,
                    color;
                if( 'mouseenter' === e.type ) {
                    hoverColor = $this.attr( 'data-hover-color' ) || '';
                    if( !$this.hasClass( 'be-style1' ) ) {
                        $this.css( 'color', hoverColor );
                        return;
                    }
                    borderColor = $this.attr( 'data-border-color' );
                    $this.css({
                        borderColor : '',
                        backgroundColor : borderColor,
                        color : hoverColor
                    });
                }else{
                    color = $this.attr( 'data-color' ) || '';
                    if( !$this.hasClass( 'be-style1' ) ) {
                        $this.css( 'color', color );
                        return;
                    }
                    borderColor = $this.attr( 'data-border-color' );
                    $this.css({
                        borderColor : borderColor,
                        backgroundColor : '',
                        color : color
                    });
                }

            });

        },

        closeNotification = function() {
            jQuery(document).on('click.tatsu', '.tatsu-notification .close', function (e) {
                e.preventDefault();
                jQuery(this).closest('.tatsu-notification').slideUp(500);
            });                     
        },

        animatedNumbers = function() {
            if(animatedNumberWrap.length > 0) {
               asyncloader.require( 'countTo', function() {
                    animatedNumberWrap.each(function (i, el) {
                        var el = jQuery(el);
                        if( el.hasClass('animate') ) {
                            if ( el.visible(true) ) {
                                el.removeClass('animate');
                                var $endval = Number( el.attr( 'data-number' ) );
                                el.countTo({
                                    from : 0,
                                    to : $endval,
                                    speed : 1500,
                                    refreshInterval : 30
                                });
                                alreadyVisibleIndex ++;
                                if( alreadyVisibleIndex >= totalAnimCount ) {
                                    clearTimeout(scrollInterval);
                                }
                            }
                        }
                    });
                });
            }           
        }, 

        cssAnimate = function( shouldUpdate, moduleId, context ) {
            var filteredElements = null;
            if( shouldUpdate ) {
                var el = jQuery('.be-pb-observer-'+moduleId );
                if( el.hasClass( 'tatsu-animate' ) || el.hasClass( 'be-animate' ) ) {
                   el.removeClass('animated flipInX flipInY fadeIn fadeInDown fadeInLeft fadeInRight fadeInUp slideInDown slideInLeft slideInRight rollIn rollOut bounce bounceIn bounceInUp bounceInDown bounceInLeft bounceInRight fadeInUpBig fadeInDownBig fadeInLeftBig fadeInRightBig flash flip lightSpeedIn pulse rotateIn rotateInUpLeft rotateInDownLeft rotateInUpRight rotateInDownRight shake swing tada wiggle wobble infiniteJump zoomIn none already-visible end-animation');
                }else{
                   el = el.find( '.tatsu-animate, .be-animate' ).removeClass('animated flipInX flipInY fadeIn fadeInDown fadeInLeft fadeInRight fadeInUp slideInDown slideInLeft slideInRight rollIn rollOut bounce bounceIn bounceInUp bounceInDown bounceInLeft bounceInRight fadeInUpBig fadeInDownBig fadeInLeftBig fadeInRightBig flash flip lightSpeedIn pulse rotateIn rotateInUpLeft rotateInDownLeft rotateInUpRight rotateInDownRight shake swing tada wiggle wobble infiniteJump zoomIn none already-visible end-animation');
                }
                if( el.length > 0 ) {
                    jQuery.each( el, function( index, element ) {
                        element = jQuery( element );
                        var animationDelay = element.attr('data-animation-delay');
                        element.css( 'animation-delay', animationDelay + 'ms' );
                        element.one('webkitAnimationStart oanimationstart msAnimationStart animationstart',  
                            function(e) {
                                element.addClass("end-animation");
                            });
                        if ( element.visible( true ) && ( $window.innerHeight() - element[0].getBoundingClientRect().top > 100 ) ) {
                            element.addClass("already-visible");
                            element.addClass(element.attr('data-animation'));
                            // element.addClass('animated');
                        }                    
                    } );
                }            
            } else {
                 if(animateWrapperCount > 0) {
                    if( null != context ) {
                        filteredElements = animate_wrapper.filter( function() {
                            return 0  < jQuery( this ).closest( context ).length;
                        } );
                    }else {
                        filteredElements = animate_wrapper;
                    }
                    filteredElements.each(function (i, el) {     
                        var el = jQuery(el);
                        if(!el.hasClass('already-visible')) {
                            var animationDelay = el.attr('data-animation-delay');
                            el.css( 'animation-delay', animationDelay + 'ms' );
                            el.one('webkitAnimationStart oanimationstart msAnimationStart animationstart',  
                                function(e) {
                                    el.addClass("end-animation");
                                });
                            // if( null != context ) {

                            // }else {
                                if( el.visible(true) && ( $window.innerHeight() - el[0].getBoundingClientRect().top > 40 ) ) {                            
                                    el.addClass("already-visible");
                                    el.addClass(el.attr('data-animation'));
                                    // el.addClass('animated');
                                    alreadyVisibleIndex ++;
                                    if( alreadyVisibleIndex >= totalAnimCount && !$body.hasClass('tatsu-frame') ) {
                                        clearInterval(scrollInterval);
                                    }                                
                                }
                           // }
                        }
                    });
                }                 
            }
                   
        },

        lightbox = function() {
            if (jQuery('.mfp-image').length > 0) {

                asyncloader.require( 'magnificpopup', function() {

                    var mfpImages = jQuery( '.mfp-image' ),
                        galleryEnabledMfpImages = mfpImages.filter( function() {
        
                            return 0 == jQuery( this ).closest( '.tatsu-single-image' ).length;
                        
                        } ),
                        galleryDisabledMfpImages = mfpImages.not( galleryEnabledMfpImages );
                    if( 0 < galleryEnabledMfpImages.length ) {
                        galleryEnabledMfpImages.magnificPopup({
                            mainClass: 'mfp-img-mobile my-mfp-zoom-in',
                            closeOnContentClick: true,
                            gallery: {
                                enabled: true
                            },
                            image: {
                                verticalFit: true,
                                titleSrc: 'title'
                            },
                            zoom: {
                                enabled: false,
                                duration: 300
                            },
                            preloader: true,
                            type: 'inline',
                            overflowY: 'auto',
                            removalDelay: 300,
                            callbacks: {
                                afterClose: function () {
                                },
                                open: function () {
                                    jQuery('body').addClass('mfp-active-state');
                                },
                                close: function () {
                                    jQuery('body').removeClass('mfp-active-state');
                                }
                            }
                        });
                    }
                    if( 0 < galleryDisabledMfpImages.length ) {
                        galleryDisabledMfpImages.magnificPopup({
                            mainClass: 'mfp-img-mobile my-mfp-zoom-in',
                            closeOnContentClick: true,
                            gallery: {
                                enabled: false
                            },
                            image: {
                                verticalFit: true,
                                titleSrc: 'title'
                            },
                            zoom: {
                                enabled: false,
                                duration: 300
                            },
                            preloader: true,
                            type: 'inline',
                            overflowY: 'auto',
                            removalDelay: 300,
                            callbacks: {
                                afterClose: function () {
                                },
                                open: function () {
                                    jQuery('body').addClass('mfp-active-state');
                                },
                                close: function () {
                                    jQuery('body').removeClass('mfp-active-state');
                                }
                            }
                        });
                    }
                    
                } );
                
            }
            if(jQuery('.mfp-iframe').length > 0) {
                 asyncloader.require( 'magnificpopup', function() {
                    jQuery('.mfp-iframe').magnificPopup({
                        iframe: {  
                            patterns: {
                                youtube: {
                                  index: 'youtube.com/',
                                  id: 'v=', 
                                  src: '//www.youtube.com/embed/%id%?autoplay=1&rel=0&showinfo=0'
                                },
                                vimeo: {
                                  index: 'vimeo.com/',
                                  id: '/',
                                  src: '//player.vimeo.com/video/%id%?autoplay=1'
                                },
                                gmaps: {
                                  index: '//maps.google.',
                                  src: '%id%&output=embed'
                                }                
                            }
                        }
                    });
                });
            }       
        },

        gmaps = function() {
            if(jQuery('.tatsu-gmap').length > 0) {
                 asyncloader.require( 'google_maps_api' , function() {
                    var styles = {
                        black : [{"featureType" : "water", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 17}]}, {"featureType" : "landscape", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 20}]}, {"featureType" : "road.highway", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}, {"lightness" : 17}]}, {"featureType" : "road.highway", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#000000"}, {"lightness" : 29}, {"weight" : 0.2}]}, {"featureType" : "road.arterial", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 18}]}, {"featureType" : "road.local", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 16}]}, {"featureType" : "poi", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 21}]}, {"elementType" : "labels.text.stroke", "stylers" : [{"visibility" : "on"}, {"color" : "#000000"}, {"lightness" : 16}]}, {"elementType" : "labels.text.fill", "stylers" : [{"saturation" : 36}, {"color" : "#000000"}, {"lightness" : 40}]}, {"elementType" : "labels.icon", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "transit", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}, {"lightness" : 19}]}, {"featureType" : "administrative", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}, {"lightness" : 20}]}, {"featureType" : "administrative", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#000000"}, {"lightness" : 17}, {"weight" : 1.2}]}],
                        greyscale: [{"featureType" : "landscape", "stylers" : [{"saturation" : -100}, {"lightness" : 65}, {"visibility" : "on"}]}, {"featureType" : "poi", "stylers" : [{"saturation" : -100}, {"lightness" : 51}, {"visibility" : "simplified"}]}, {"featureType" : "road.highway", "stylers" : [{"saturation" : -100}, {"visibility" : "simplified"}]}, {"featureType" : "road.arterial", "stylers" : [{"saturation" : -100}, {"lightness" : 30}, {"visibility" : "on"}]}, {"featureType" : "road.local", "stylers" : [{"saturation" : -100}, {"lightness" : 40}, {"visibility" : "on"}]}, {"featureType" : "transit", "stylers" : [{"saturation" : -100}, {"visibility" : "simplified"}]}, {"featureType" : "administrative.province", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "water", "elementType" : "labels", "stylers" : [{"visibility" : "on"}, {"lightness" : -25}, {"saturation" : -100}]}, {"featureType" : "water", "elementType" : "geometry", "stylers" : [{"hue" : "#ffff00"}, {"lightness" : -25}, {"saturation" : -97}]}],
                        midnight: [{"featureType" : "water", "stylers" : [{"color" : "#021019"}]}, {"featureType" : "landscape", "stylers" : [{"color" : "#08304b"}]}, {"featureType" : "poi", "elementType" : "geometry", "stylers" : [{"color" : "#0c4152"}, {"lightness" : 5}]}, {"featureType" : "road.highway", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}]}, {"featureType" : "road.highway", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#0b434f"}, {"lightness" : 25}]}, {"featureType" : "road.arterial", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}]}, {"featureType" : "road.arterial", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#0b3d51"}, {"lightness" : 16}]}, {"featureType" : "road.local", "elementType" : "geometry", "stylers" : [{"color" : "#000000"}]}, {"elementType" : "labels.text.fill", "stylers" : [{"color" : "#ffffff"}]}, {"elementType" : "labels.text.stroke", "stylers" : [{"color" : "#000000"}, {"lightness" : 13}]}, {"featureType" : "transit", "stylers" : [{"color" : "#146474"}]}, {"featureType" : "administrative", "elementType" : "geometry.fill", "stylers" : [{"color" : "#000000"}]}, {"featureType" : "administrative", "elementType" : "geometry.stroke", "stylers" : [{"color" : "#144b53"}, {"lightness" : 14}, {"weight" : 1.4}]}],
                        standard: [],
                        bluewater: [{"featureType" : "water", "stylers" : [{"color" : "#46bcec"}, {"visibility" : "on"}]}, {"featureType" : "landscape", "stylers" : [{"color" : "#f2f2f2"}]}, {"featureType" : "road", "stylers" : [{"saturation" : -100}, {"lightness" : 45}]}, {"featureType" : "road.highway", "stylers" : [{"visibility" : "simplified"}]}, {"featureType" : "road.arterial", "elementType" : "labels.icon", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "administrative", "elementType" : "labels.text.fill", "stylers" : [{"color" : "#444444"}]}, {"featureType" : "transit", "stylers" : [{"visibility" : "off"}]}, {"featureType" : "poi", "stylers" : [{"visibility" : "off"}]}]
                    };
                    jQuery('.tatsu-gmap').each(function () {
                        var $address = jQuery(this).attr('data-address'), 
                        $zoom = Number( jQuery(this).attr('data-zoom') ), 
                        $lat = jQuery(this).attr('data-latitude'), 
                        $lan = jQuery(this).attr('data-longitude'), 
                        $custom_marker = jQuery(this).attr('data-marker'), 
                        map_style = jQuery(this).attr('data-style'), 
                        mapOptions = {
                            zoom: $zoom,
                            scrollwheel: false,
                            navigationControl: false,
                            mapTypeControl: false,
                            scaleControl: false,
                            streetViewControl: false,
                            center: new google.maps.LatLng(parseFloat($lat), parseFloat($lan)),
                            styles: styles[map_style]
                        }, map = new google.maps.Map(jQuery(this)[0], mapOptions), marker = new google.maps.Marker({
                            position: new google.maps.LatLng(parseFloat($lat), parseFloat($lan)),
                            map: map,
                            title: $address,
                            icon: $custom_marker
                        });
                        marker.setMap(map);
                    });
                });
            }
        },

        backgroundVideo = function() {
          asyncloader.require( 'resizetoparent', function () {
            var bgVideoWrap = jQuery( '.tatsu-bg-video, .be-bg-video' );
            if ( bgVideoWrap.length > 0 ) {
              bgVideoWrap.each( function() {
                jQuery(this).load();
                jQuery(this).on("loadedmetadata", function () { 
                    jQuery(this).css({
                        width: this.videoWidth,
                        height: this.videoHeight
                    });
                    jQuery(this).tatsuResizeMedia();
                    jQuery(this).css('display', 'block');
                });
                //jQuery(this).tatsuResizeMedia();
              });
            }
          });            
        },

        video = function() {
            asyncloader.require( 'fitvids', function() {
                jQuery('body').fitVids({  
                });
            });
        },

        tatsuSection = function() {
           parallax();
        },

        registerCallbacks = function() {
            tatsuCallbacks['tatsu_video'] = video;
            tatsuCallbacks['tatsu_gmaps'] = gmaps;
            tatsuCallbacks['tatsu_animated_numbers'] = animatedNumbers;
            tatsuCallbacks[ 'tatsu_section' ] = tatsuSection;
            tatsuCallbacks[ 'tatsu_column' ] = tatsuColumn;
            tatsuCallbacks[ 'tatsu_image' ] = lightbox;
        },

        parallax = function() {
          var parallaxContainer = jQuery('.tatsu-parallax');
          if( parallaxContainer.length > 0 ) {
            asyncloader.require( 'tatsuParallax', function() {
              parallaxContainer.tatsuParallax({
                speed: 0.3
              });
            });
          }
        },

        columnParallax = function() {
            var columnParallaxContainer = jQuery( '.tatsu-column-parallax' );
            if( columnParallaxContainer.length > 0 ) {
                asyncloader.require( 'tatsuColumnParallax', function(){
                    columnParallaxContainer.tatsuColumnParallax({
                        speed : 7
                    });
                });
            }
        },
        columnTilt = function(shouldUpdate,moduleId){

            var columnTiltContainer = jQuery( '.tatsu-column-effect-tilt > div' );
            asyncloader.require( 'tilt',function(){
            
                if(shouldUpdate){
                        var temp1 = jQuery('.be-pb-observer-'+moduleId);
                    if( temp1.hasClass('tatsu-column-effect-tilt') ){
                        temp1.children().tilt();
                    }else{
                        var newTiltObj = temp1.children().eq(0).tilt();
                        newTiltObj.tilt.destroy.call(newTiltObj);
                    }
                } else {
                    columnTiltContainer.tilt({
                        scale: 1.1,
                        perspective: 1000,
                        speed: 4000,
                        //easing: 'ease',
                        maxTilt: 10,
                    });
                }
            });
        },

        stickyColumn = function(shouldUpdate,moduleId){
           
            var tatsuStickyColumn = jQuery('.tatsu-column-sticky');

            if(tatsuStickyColumn.length){
                asyncloader.require('stickykit',function(){
                    var stickyTopOffset = 0;
                    if(jQuery('#wpadminbar').length){
                        stickyTopOffset = 32;
                    }
                    jQuery.each(tatsuStickyColumn,function(key,element){
                        var jQueryObj = jQuery(element);
                        if(jQuery(window).width() > 767){
                        jQueryObj.stick_in_parent({offset_top : stickyTopOffset})
                        .on("sticky_kit:stick",function(e){
                            jQueryObj.css({left:jQueryObj.next().offset().left});
                        })
                        .on("sticky_kit:unstick", function(e) {
                            jQueryObj.css({left:0});
                           })
                        .on("sticky_kit:bottom", function(e) {
                            jQueryObj.css({left: jQueryObj.next().offset().left - jQueryObj.parent().offset().left});
                        })
                        .on("sticky_kit:unbottom", function(e) {
                            jQueryObj.css({left: jQueryObj.next().offset().left});
                            });
                        }else{
                            jQueryObj.trigger("sticky_kit:detach");
                            jQueryObj.css({left:0});
                        }
                        });
                });
            }
            var currentColumn = jQuery('.be-pb-observer-'+moduleId);
                if(!currentColumn.hasClass('tatsu-column-sticky')  ){
                    currentColumn.trigger("sticky_kit:detach");
                }

        },
       
        tatsuColumn = function(shouldUpdate,moduleId) {
            columnParallax();
            stickyColumn(shouldUpdate,moduleId);
            columnTilt(shouldUpdate,moduleId);
        },
        lazyLoadImages = function(){
            var tatsuLazyLoadImages = jQuery( '.tatsu-image-lazyload' );
            if( tatsuLazyLoadImages.length > 0 ){
                asyncloader.require( 'unveil', function(){
                    // Lazy load images 300px before they appear on the screen
                    tatsuLazyLoadImages.find( 'img' ).unveil(400, function(){
                        //Callback to be executed once image is loaded
                        var currentImage = jQuery( this );
                        currentImage.one( 'load', function() {
                            this.style.opacity = 1;
                            currentImage.closest( '.tatsu-single-image-inner' ).css( 'background-color', '' );
                        });
                        if( this.complete ) {
                           currentImage.load();
                        }
                    });
                });
            }
        },

        cssAnimateScrollCallback = function() {
            if( ( ( animate_wrapper.length > 0 || animatedNumberWrap.length > 0 ) && ( !$body.hasClass( 'be-sticky-sections' ) || 960 >= window.innerWidth ) ) || $body.hasClass('tatsu-frame') ) {
                scrollInterval = setInterval(function() {
                    if ( didScroll ) {
                        didScroll = false;
                        cssAnimate(false, '');      
                        animatedNumbers();
                    }
                }, 100); 
            }        
        },

        ready = function(){

            animatedAnchor();
            video();
            parallax();
            columnParallax();
            columnTilt();
            tatsuColumn();
            lazyLoadImages();
            closeNotification();
            animatedNumbers();
            if( !jQuery( 'body' ).hasClass( 'be-sticky-sections' ) ) {
                cssAnimate();
            }
            lightbox();
            gmaps();
            backgroundVideo();
            registerCallbacks();

            jQuery(window).on( 'tatsu_update.tatsu', function( e, data )  {
                animate_wrapper = jQuery('.tatsu-animate, .be-animate');
                animateWrapperCount = animate_wrapper.length,
                animatedNumberWrap = jQuery('.tatsu-an');
                totalAnimCount = animate_wrapper.length + animatedNumberWrap.length;
                if( 'trigger_ready' == data.moduleName ) {
                    animatedNumbers();
                    parallax();
                    gmaps();
                    video();
                    backgroundVideo();
                    lightbox();
                    tatsuColumn();
                    columnParallax();
                } else if( data.moduleName in tatsuCallbacks ) {
                    tatsuCallbacks[data.moduleName]( data.shouldUpdate,data.moduleId );                                         
                } 
                if ( 'csstrigger' === data.type ) {
                  cssAnimate( data.triggeredFromTatsu, data.id );
                }
            });

            jQuery(window).on('scroll', function(){
                didScroll = true;
            });

            cssAnimateScrollCallback();

           // jQuery(window).on( 'scroll.tatsu', cssAnimate.bind(null, false, '') );
           // jQuery(window).on( 'scroll.tatsu', animatedNumbers ); 
            jQuery(window).on( 'resize.tatsu', function() {
               jQuery( '.tatsu-bg-video, .be-bg-video' ).tatsuResizeMedia(); 
               if( $body.hasClass( 'be-sticky-sections' ) ) {
                   if( 960 >= window.innerWidth && null == scrollInterval ) {
                       cssAnimateScrollCallback();
                   }else if( 960 < window.innerWidth && null != scrollInterval ) {
                       clearTimeout( scrollInterval );
                   }
               }
               stickyColumn();
            });
        }
        
        return {
            ready: ready,
            lightbox: lightbox,
            cssAnimate: cssAnimate
        }

    })(); 

    window.tatsu = tatsu;
    jQuery( tatsu.ready );

})( jQuery );