
// Custom Side with Fade Animation
function tatsuToggle(speed, easing, callback) {
    return this.animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'}, speed, easing, callback);
}

(function( $ ) {
    'use strict';

    var vendorScriptsUrl = tatsuFrontendConfig.vendorScriptsUrl,
        dependencies = tatsuFrontendConfig.dependencies || {};

    if( 'undefined' != typeof dependencies ) {
		for( var dependency in dependencies ) {
			if( dependencies.hasOwnProperty( dependency ) ) {
				asyncloader.register( dependencies[ dependency ], dependency );
			}
		}
    }    

    var adjustTopSectionPadding = function() {
        if( jQuery('#tatsu-header-wrap').hasClass('transparent') ){
            var currentPadding = jQuery('#be-content .tatsu-section:first-child .tatsu-section-pad').css('padding') || 0,
            adjustedPadding = parseInt( currentPadding ) + jQuery('#tatsu-header-wrap').height() ;
            jQuery('#be-content .tatsu-section:first-child .tatsu-section-pad').css('padding-top', adjustedPadding);
            $(document.body).addClass( 'tatsu-transparent-header-pad' );
            $(document).trigger( 'tatsu_transparent_header_padding_calc' );
        }

    },

    addHoverClass = function() {

        if( jQuery('#tatsu-header-wrap').hasClass('transparent') ){
            jQuery(document).on('mouseenter', '.tatsu-menu li', function() {
                jQuery(this).addClass('tatsu-hovered');
                jQuery(this).closest('li.current-menu-parent').addClass('tatsu-hovered');
            });
            jQuery(document).on('mouseleave', '.tatsu-menu li' , function() {
                jQuery(this).removeClass('tatsu-hovered');
                jQuery(this).closest('li.current-menu-parent').removeClass('tatsu-hovered');
            });  
        } 

    };

    var tatsuHeader = (function() {
        var body = $('body'),
            html = $('html'),
            $htmlBody = $( 'html,body' ),
            $win = $(window),
            headerContainer = $('#tatsu-header-container'),
            headerWrap = $('#tatsu-header-wrap'),
            header = $('.tatsu-header'),
            triggerStickyPostion = headerWrap.height(),
            placeholder = $( '#tatsu-header-placeholder' ),
            pluginUrl = tatsuFrontendConfig.pluginUrl,
            smartSticky = headerWrap.hasClass('smart'),
            sticky = headerWrap.hasClass('sticky'),
            scrollPos = 0,
            headerWrapHeight = headerWrap.height(),
            smartOffset = headerWrap.height() + 200,
            hamburger = $('.tatsu-hamburger'),
            slideMenu = $('.tatsu-slide-menu'),
            overlay = $( '#tatsu-fixed-overlay' ),
            raf,
            tatsuCallbacks = {},  

        stickyHeader = function() {
            
            if( $win.scrollTop() > headerWrap.height() && $win.scrollTop() < smartOffset ) {
                headerWrap.addClass('pre-stuck');
            } else if( $win.scrollTop() >= smartOffset ){
                if( smartSticky ) {
                    if( body[0].getBoundingClientRect().top <= scrollPos ) {
                        headerWrap.addClass('hide');//
                    } else {
                        headerWrap.removeClass('hide').addClass('stuck');
                    }
                }else{
                    headerWrap.addClass('stuck');
                }
            } else if($win.scrollTop() <= headerWrap.height() ){
                if( body[0].getBoundingClientRect().top > scrollPos ){
                    headerWrap.removeClass('stuck').removeClass('pre-stuck');
                }
            }
            scrollPos = body[0].getBoundingClientRect().top;
        },

        headerHeight = function() {
            var height = 0;
            header.each( function() {
                if( $(this).hasClass('default') && $(this).is(':visible') ) {
                    height = height + parseInt( $(this).height() );
                }
            });
            
            return height;
        },

        getSmartOffset = function(){
            return smartOffset;
        },

        stickyHeaderHeight = function() {
            var height = 0;
            if( $htmlBody.scrollTop() < smartOffset ) {
                var clonedHeader = headerWrap.clone();
                clonedHeader.addClass( 'pre-stuck stuck' ).css({
                    position : 'absolute',
                    left : '-999999px',
                    display : 'block',
                    visibility : 'hidden',
                });
                body.append( clonedHeader );
                height = clonedHeader.height();
                clonedHeader.remove();
                clonedHeader = null;
            }else {
                header.each( function() {
                    var curEle = $(this);
                    if( curEle.hasClass( 'sticky' ) && curEle.is( ':visible' ) ) {
                            height+= curEle.height();
                    }
                } );
            }
            return height;
        },

        setPlaceholderHeight = function() {
            if( headerWrap.hasClass( 'solid' ) && sticky && placeholder.length > 0 ) {
                placeholder.css( 'height', headerWrapHeight );
            }
        },

        slide = function() {
            hamburger.on( 'click', function(){
                var id = $(this).attr('data-slide-menu');
                var menuToSlide = slideMenu.filter( function(){
                    return $(this).attr('id') == id;
                });
                $(this).find('.line-wrapper').addClass('open');
                menuToSlide.toggleClass('open');
                overlay.toggleClass('open');
            });
        },

        closeSlideCallback = function() {
            var menuToClose = slideMenu.filter( function(){
                return $(this).hasClass('open');
            });
            hamburger.find('.line-wrapper').removeClass('open');
            overlay.removeClass('open');
            menuToClose.removeClass('open');
        },

        closeSlide = function() {
            overlay.on( 'click', closeSlideCallback );
        },

        removeMegaMenuClass = function() {
            jQuery('.tatsu-slide-menu li.mega-menu').removeClass('mega-menu');
        },

        setSidebarMenuWidth = function() {

            var sideBarMenu = jQuery('.tatsu-sidebar-menu');

            sideBarMenu.each(function (){
                sideBarMenu.css('width', jQuery(this).closest('.tatsu-slide-menu-col').width());
            });
            
        },

        superfish = function() {
            asyncloader.require( [ 'superfish', 'hoverintent' ], function(){
                
                var $menu = jQuery('.tatsu-header-col .tatsu-header-navigation .tatsu-menu').children('ul');
                $menu.superfish('destroy');
                
                // Remove Instances on Menu within Slide Bar 
                // $menu = $menu.map( function( index, menuInstance ){
                //     if( jQuery(menuInstance).closest('.tatsu-slide-menu').length <= 0 ){
                //         return menuInstance;
                //     }else{
                //         return null;
                //     }
                // });

                $menu.superfish({
                    animation: {top: "50px", opacity: "show"},
                    animationOut: {top: "45px", opacity: "hide"},
                    pathLevels:3,  
                    speed : "fast",
                    delay: 100,
                    disableHI: true,
                    onBeforeShow : function() {
                        
                        if( this.parent('li').hasClass('mega-menu') ){
                            this.css('visibility','hidden');
                            this.fadeIn();
                            
                            var subMenu = this,
                                subMenuWidth = subMenu.width() ,
                                subMenuPosition = subMenu.offset().left ,
                                parentPosition = this.parent('li').offset().left;
                                if( ( jQuery(window).width() - subMenuPosition ) < subMenuWidth ){
                                    var correctedPosition = subMenuWidth - ( jQuery(window).width() - 30 - subMenuPosition )
                                    subMenu.css( 'left', - correctedPosition );
                                    subMenu.find('.tatsu-header-pointer').css( 'left', correctedPosition + 20 );
                                }
                            this.css('visibility','visible');
                            this.fadeOut();
                        }
                        else{
                            var subMenuDepth = this.parents('ul').length ,
                            currentMenuItem = this.closest('li.menu-item-has-children'),
                            subMenuWidth = this.innerWidth(),
                            subMenuPositionCheck = subMenuDepth * subMenuWidth,
                            positionOffset = ( jQuery(this).innerWidth() - jQuery(this).width() ) / 2 , 
                            subMenuPosition = subMenuWidth -  positionOffset + 5;

                            if ( subMenuDepth > 1 ){                                
                                if( ( jQuery(window).width() - this.closest('li.menu-item-has-children').offset().left ) < subMenuPositionCheck ){
                                    currentMenuItem.find('ul.tatsu-sub-menu').css( 'right', subMenuPosition ).css('top', 0);
                                }else{
                                    currentMenuItem.find('ul.tatsu-sub-menu').css( 'left', subMenuPosition ).css('top', 0);
                                }
                            }
                        }
                        this.siblings('.sub-menu-indicator').addClass('menu-open');
                    },
                    onBeforeHide : function() {
                        this.siblings('.sub-menu-indicator').removeClass('menu-open');
                    }
                });
            });		    	
        },

        tatsuSideBarMenu = function() {
            removeMegaMenuClass();
            setSidebarMenuWidth();
        },

        closeMobileMenu = function() {
            jQuery('.tatsu-mobile-menu-icon').find('.line-wrapper').removeClass('open');
            jQuery('.tatsu-mobile-menu').animate({opacity: 'hide', height: 'hide', padding: 'hide', margin: 'hide'}, 200, 'linear', '');
        },

        tatsu_mobile_menu = function() {
            jQuery(document).on('click', '.tatsu-mobile-navigation .tatsu-mobile-menu-icon', function () {
                jQuery(this).find('.line-wrapper').toggleClass('open');
                jQuery(this).siblings('.tatsu-mobile-menu').animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'}, 200, 'linear', '');
            });
            jQuery(document).on('click','.tatsu-mobile-menu .sub-menu-indicator , .tatsu-slide-menu-col .sub-menu-indicator' , function() {
                jQuery(this).toggleClass('menu-open');
                jQuery(this).siblings('.tatsu-sub-menu').animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'}, 200, 'linear', '');
            });
            jQuery(document).on('click','.tatsu-mobile-menu li.menu-item-has-children a , .tatsu-slide-menu-col li.menu-item-has-children a' , function() {
                if(jQuery(this).attr('href') == '#'){
                    jQuery(this).toggleClass('menu-open');
                    jQuery(this).siblings('.tatsu-sub-menu').animate({opacity: 'toggle', height: 'toggle', padding: 'toggle', margin: 'toggle'}, 200, 'linear', '');
                }
            });
        },

        tatsu_search = function() {
            jQuery(document).on( 'click', '.tatsu-search svg', function() {
                var iconPostion = jQuery(this).offset().left,
                    windowMedian = jQuery(window).width() / 2;
                if( iconPostion <  windowMedian ){
                    jQuery(this).siblings( '.search-bar' ).css( 'left' , -20 );
                    jQuery(this).siblings( '.search-bar' ).find( '.tatsu-header-pointer' ).css( 'left' , 20 );
                }else{
                    jQuery(this).siblings( '.search-bar' ).css( 'right' , -20 );
                    jQuery(this).siblings( '.search-bar' ).find( '.tatsu-header-pointer' ).css( 'right' , 20 );
                }
                jQuery(this).siblings( '.search-bar' ).toggleClass('search-open');
                
            });
        },

        tatsu_close_popups = function() {
            jQuery(document).on('mouseup', function () {
                // Close Search
                // if( jQuery('.search-bar').hasClass('search-open') ){
                //     jQuery('.search-bar').removeClass('search-open')
                // };
            })
        },

        tatsu_language_switcher = function() {
            jQuery(document).on( 'click', '.tatsu-wpml-lang-switcher', function() {
                jQuery(this).toggleClass('language-switcher-open');
            });
        },    

        registerCallbacks = function() {
            tatsuCallbacks[ 'tatsu_sidebar_navigation_menu' ] = tatsuSideBarMenu;
            tatsuCallbacks[ 'tatsu_navigation_menu' ] = superfish;
            tatsuCallbacks[ 'tatsu_wpml_language_switcher' ] = tatsu_language_switcher;
        },

        ready = function(){

            adjustTopSectionPadding();
            addHoverClass();
            headerWrapHeight =  headerHeight(); //headerWrap.height(),
            //setPlaceholderHeight();
            slide();
            closeSlide();    
            superfish();   
            tatsuSideBarMenu();
            tatsu_mobile_menu();
            tatsu_search();
            tatsu_language_switcher();
            tatsu_close_popups();
            registerCallbacks();

            jQuery(window).on( 'tatsu_update.tatsu', function( e, data )  {
                if( data.moduleName in tatsuCallbacks ) {
                    tatsuCallbacks[data.moduleName]( data.shouldUpdate, data.moduleId );                                         
                } 
            });

            if( sticky ) {
                $(window).on( 'scroll.tatsuStickyHeader', function() {
                    cancelAnimationFrame(raf);
                    raf = requestAnimationFrame( stickyHeader );
                });
            }
        }        
        
        return {
            ready: ready,
            getStickyHeaderHeight : stickyHeaderHeight,
            getHeaderHeight : headerHeight,
            getSmartOffset : getSmartOffset,
            closeSlide : closeSlideCallback,
            closeMobileMenu : closeMobileMenu
        }

    })(); 

    window.tatsuHeader = tatsuHeader;
    $( tatsuHeader.ready );

})( jQuery );