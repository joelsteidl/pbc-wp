    /***  post message listener ***/
    ;(function($) { 
        var curAddToolsPosition = '',
            currentPath = '',
            isSafari = ( ( -1 <  navigator.userAgent.toLowerCase().indexOf( 'safari' ) ) && ( -1 == navigator.userAgent.toLowerCase().indexOf( 'chrome' ) ) ) ,
            debounce = function debounce(func, wait, immediate) {
                var timeout;
                return function() {
                    var context = this, args = arguments;
                    var later = function() {
                        timeout = null;
                        if (!immediate) func.apply(context, args);
                    };
                    var callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) func.apply(context, args);
                };
            },
            mouseMoveHandler = function( event ) {
                
                var x = jQuery( '.tatsu-add-tools-helper' );
                if( !jQuery( this ).hasClass( 'disable-add-tools' ) &&  -1 == parent.document.body.className.indexOf( "preview" ) ) {
                        var moduleCollection = jQuery( '.tatsu-module-preview:not(.be-prevent-add-tools)' ),
                            res = isNear( moduleCollection, 30, event ),
                            resPathArrayLength,
                            eleHeightRatio,
                            clientY,
                            resSiblingsCount,
                            resPath;
                        if( res ) {
                            resPath = res.attr( 'data-path' );
                            resPathArrayLength = resPath.split( '-' ).length;
                            eleHeightRatio = res.outerHeight(true)/2;
                            clientY = event.pageY - res.offset().top;
                            if( 6 == resPathArrayLength ) {
                                resSiblingsCount = res.parent().children().length - 1;
                                if( 0 == res.index() && ( 0 == resSiblingsCount || clientY < eleHeightRatio ) ) {
                                    x.addClass( 'tatsu-pill' );
                                }else if( res.index() == resSiblingsCount ) {
                                    x.addClass( 'tatsu-pill' );
                                }else if( x.hasClass( 'tatsu-pill' ) ) {
                                    x.removeClass( 'tatsu-pill' );
                                }
                            }else if( x.hasClass( 'tatsu-pill' ) ) {
                                x.removeClass( 'tatsu-pill' );
                            }
                            if( resPath != currentPath ) {
                                curAddToolsPosition = '';
                            }
                            if( 0 == res.index() ) {
                                if( clientY < eleHeightRatio && 'top' != curAddToolsPosition ) {
                                    x.css({
                                        top : ( res.offset().top ),
                                        display: 'flex',
                                        left  : ( res.offset().left + res.width()/2 )
                                    });
                                    curAddToolsPosition = 'top';
                                    currentPath = res.attr( 'data-path' );
                                }else if(  clientY > eleHeightRatio && 'bottom' != curAddToolsPosition ) {
                                    x.css( {
                                        top : ( res.offset().top + res.outerHeight(true) ),
                                        display: 'flex',
                                        left  : ( res.offset().left + res.width()/2 )                        
                                    } );
                                    curAddToolsPosition = 'bottom';
                                    currentPath = res.attr( 'data-path' );
                                }
                            }else{
                                if( 'bottom' != curAddToolsPosition ) {
                                    x.css( {
                                        top : ( res.offset().top + res.outerHeight(true) ),
                                        display: 'flex',
                                        left  : ( res.offset().left + res.width()/2 )                    
                                    } );
                                    curAddToolsPosition = 'bottom';
                                    currentPath = res.attr( 'data-path' );                        
                                }
                            }
                        }else {
                            if( x.hasClass( 'tatsu-pill' ) ) {
                                x.removeClass( 'tatsu-pill' );
                            }                            
                            if( 'none' != x.css( 'display' ) ) {
                                x.css( 'display', 'none' );
                                curAddToolsPosition = '';
                                currentPath = '';
                            }
                        };                
                }else{
                    if( 'none' != x.css( 'display' ) ) {
                        x.css( 'display', 'none' );
                        curAddToolsPosition = '';
                        currentPath = '';                
                    }
                }
    
            };
        jQuery( 'body' ).mousemove( debounce( mouseMoveHandler, 100 ) );           


        function isNear( element, distance, event ) {

            var result = null;
            element.each( function( index ) {

                var ele = jQuery( this ),
                    left = ele.offset().left - distance,
                    top = ele.offset().top - distance,
                    right = left + ele.width() + 2*distance,
                    bottom = top + ele.height() + 2*distance,
                    x = event.pageX,
                    nextSibling = ele.next(),
                    prevSibling = ele.prev(),
                    y = event.pageY;
                if( nextSibling.hasClass( 'be-prevent-add-tools' ) ) {
                    if( 0 == ele.index() ) {
                        bottom = bottom - ( ele.height()/2 ) - distance;
                    }else {
                        bottom = -1;
                    }
                }else if( prevSibling.hasClass( 'be-prevent-add-tools' ) ) {
                    top = top + ( ele.height()/2 ) + distance;
                }
                if( x > left && x < right && y > top && y < bottom ) {
                    result =  ele;
                    return false;
                }
            
            });     
            return result;
         
        };
        jQuery( document ).ready( function() {

            document.getElementsByClassName( 'tatsu-add-tools-icon-wrapper' )[0].addEventListener('click', function( event ) {

                event.stopPropagation();
                event.preventDefault();
                var message = 'addModule ' + currentPath + ' ' + curAddToolsPosition;
                parent.postMessage( message, '*' );

            } );
             document.getElementsByClassName( 'tatsu-add-tools-icon-wrapper' )[1].addEventListener('click', function( event ) {

                event.stopPropagation();
                event.preventDefault();
                var message = 'addModule ' + currentPath.slice(0,7) + ' ' + curAddToolsPosition;
                parent.postMessage( message, '*' );
                
            } );
            document.getElementsByClassName( 'tatsu-add-tools-icon-wrapper' )[1].addEventListener( 'mouseenter', function( event ) {

                var message = 'setDrag ' + currentPath.slice(0,7) + ' ' + curAddToolsPosition;
                parent.postMessage( message, '*' );

            } );
            document.getElementsByClassName( 'tatsu-add-tools-icon-wrapper' )[1].addEventListener( 'mouseleave', function( event ) {

                parent.postMessage( 'resetDrag', '*' );

            } );

        } )
    window.addEventListener("message",tatsu_scripts_trigger,false);
    function tatsu_scripts_trigger(event) {
     
          var jsonTest = function isJson( str ) {
                                try {
                                    JSON.parse(str);
                                } catch (e) {
                                    return false;
                                }
                                return true;
                           },
                data = event.data;
            
            if( jsonTest( data ) ) {

                    var parsedData = JSON.parse( data );
                    jQuery( 'p:empty' ).remove();
                    jQuery( window ).trigger( 'tatsu_update', parsedData );
            }else if( 'show_add_tools' == data.split( ',' )[0] ) {  
                var addToolsHelper = jQuery( '#tatsu-add-tools-helper' ),
                    dataArray = data.split( ',' ),
                    element = jQuery( '.be-pb-observer-' + dataArray[1] );
                if( 'top' == dataArray[ 2 ] ) {
                    addToolsHelper.css( { display : 'block', top : element.offset().top, width : element.innerWidth(), left : element.offset().left } );
                }else{
                    addToolsHelper.css( { display : 'block', top : ( element.offset().top + element.innerHeight() ), width : element.innerWidth(), left : element.offset().left } );
                }
            }else if( 'hide_add_tools' == data.split( ',' )[0] ) {
                jQuery( '#tatsu-add-tools-helper' ).css( 'display', 'none' );
            }else if( 'trigger_inline_editor' == data.split( ',' )[0] ) {
                     tinymce.init({
                         selector :  data.split( ',' )[1],
                         inline : true,
                         toolbar : false,
                         statusbar : false,
                         content_style : ( 'undefined' != typeof mceInlineContentStyles && 'string' == typeof mceInlineContentStyles.mce_inline_content_styles ) ? ( mceInlineContentStyles.mce_inline_content_styles ) : '',
                         menubar : false,
                         init_instance_callback : function( editor ) {

                            editor.on( 'click', function( event ) {
                                    setTimeout( function() {
                                      if( isSafari ) {  
                                           var actualTop = event.pageY,
                                                actualLeft,
                                                actualLeft = editor.selection.getRng().getBoundingClientRect().left;
                                                parent.postMessage( 'showToolbar' + ' ' + editor.id + ' ' + event.pageX + ' ' + actualTop, '*' );
                                      }else{
                                        var actualTop,
                                            actualLeft,
                                            distance = 0,
                                            startNode = editor.selection.getStart(),
                                            currentParent = startNode;
                                            while( currentParent.offsetParent ) {
                                                distance = distance + currentParent.offsetTop;
                                                currentParent = currentParent.offsetParent;
                                            }
                                            distance = distance + ( editor.selection.getRng().getBoundingClientRect().top - startNode.getBoundingClientRect().top );
                                            actualTop = distance;
                                            actualLeft = editor.selection.getRng().getBoundingClientRect().left;
                                            parent.postMessage( 'showToolbar' + ' ' + editor.id + ' ' + actualLeft + ' ' + actualTop, '*' );
                                      }
                                }, 0 );

                             } );
                         },
                         setup : function( editor ) {
                             editor.on( 'keyup', function( event ) {

                                parent.postMessage( 'pushToState' + ' ' + editor.id, '*' );

                             } );
                             editor.on( 'init', function( event ) {
                                 editor.formatter.register('letterspacing',{
                                     inline : 'span',
                                     styles : {
                                         letterSpacing : '%value'
                                     }
                                 });
                                 editor.formatter.register('lineheight',{
                                     inline : 'span',
                                     styles : {
                                         lineHeight : '%value'
                                     }
                                 });  
                                 editor.formatter.register('classname',{
                                     inline: 'span',
                                    classes: '%value'
                                });
                                 editor.formatter.register( 'alignleft', {
                                      selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li,blockquote',
                                      styles: {
                                        textAlign: 'left'
                                      }
                                 });  
                                 editor.formatter.register( 'alignright', {
                                      selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li,blockquote',
                                      styles: {
                                        textAlign: 'right'
                                      }
                                 });                               
                                 editor.formatter.register( 'aligncenter', {
                                      selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li,blockquote',
                                      styles: {
                                        textAlign: 'center'
                                      }
                                 });                               
                                 editor.formatter.register( 'alignjustify', {
                                      selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li,blockquote',
                                      styles: {
                                        textAlign: 'justify'
                                      }
                                 });  
                             } );
                             editor.on( 'blur', function( event ) {
                                parent.postMessage( 'hideToolbar' + ' ' + editor.id, '*' );
                             } );

                         }
                     });
            }else if( data.split( ',' )[0] === 'addSelection' ) {
                var idString = '.be-pb-observer-'+data.split( ',' )[1] + ' >div',
                    element = jQuery( idString );
                jQuery( '.tatsu-module-select' ).css({'display' : 'inline-block','top' : element.offset().top, 'left' : element.offset().left, 'height' : element.innerHeight(), 'width' : element.outerWidth() });
            }else if( data.split( ',' )[0] === 'removeSelection' ) {
                jQuery( '.tatsu-module-select' ).css('display','none');
            }     
            else if( event.data.split(',')[0] === 'hover_set') {
                 var id = event.data.split(',')[1],
                     selector = '.be-pb-observer-'+id,
                     element  = jQuery( selector );
                 if( !element.hasClass( 'active' ) ) {
                     jQuery('#tatsu-observer').css({'display' : 'inline-block','top' : element.offset().top, 'left' : element.offset().left, 'height' : element.innerHeight(), 'width' : element.outerWidth() });
                     jQuery('#tatsu-observer-tooltip').text( event.data.split(',')[2] );     
                     if( 'undefined' != typeof event.data.split(',')[2] && 'Section' != event.data.split( ',' )[2] ){
                        jQuery( '#tatsu-observer-tooltip' ).addClass('out');
                     }else{
                        jQuery( '#tatsu-observer-tooltip' ).removeClass('out')
                     }
                 }else{
                    jQuery('#tatsu-observer').css('display','none');
                    if( jQuery('#tatsu-observer-tooltip').hasClass('out') ){
                        jQuery('#tatsu-observer-tooltip').removeClass('out');
                    } 
                 }
            }else if( 'add_selection' === data.split( ',' )[0] ) {
                var dataArray = data.split( ',' ),
                    selector = '.be-pb-observer-' + dataArray[1],
                    element = jQuery( selector );
                jQuery( selector ).css( 'outline', '1px solid #20cbd4' );

            }else if( data.split( ',' )[0] === 'drag_set' ) {
                var dataArray = data.split( ',' ),
                    id = dataArray[1],
                    height = 0,
                    position = dataArray[2],
                    isInnerRow = 'string' == typeof dataArray[3] && 'innerRow' == dataArray[3],
                    selector = '.be-pb-observer-'+id,
                    element = jQuery( selector );
                if( 'top' === position ) {
                    jQuery( '.tatsu-drag-observer' ).css({ display : 'inline-block', 'top' : ( element.offset().top ), 'left' : element.offset().left, 'width' : element.innerWidth(), backgroundColor : isInnerRow ? 'red' : ''  });
                }else{
                    height = element.innerHeight();
                    jQuery( '.tatsu-drag-observer' ).css({ display : 'inline-block', 'top' : ( element.offset().top + height ), 'left' : element.offset().left, 'width' : element.innerWidth(), backgroundColor : isInnerRow ? 'red' : '' });
                }
            }else if( data.split( ',' )[0] === 'reset_drag' ) {
                jQuery( '.tatsu-drag-observer' ).css( 'display' , 'none' );
            }
            else {
                jQuery('#tatsu-observer').css('display','none');
                if( jQuery('#tatsu-observer-tooltip').hasClass('out') ){
                    jQuery('#tatsu-observer-tooltip').removeClass('out');
                } 
            }
             
    }

    jQuery(document).ready( function() {
        jQuery(document).on( 'click', '.tatsu-frame a',  function(e) {
            e.preventDefault();
        });
        jQuery('form').on( 'submit', function(e) {
            e.preventDefault();
        });        
    });
})(jQuery); 