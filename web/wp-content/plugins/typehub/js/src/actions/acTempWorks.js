import helpers from '../helper/helpers';
import {notification} from 'antd';

export default {
    loadingStateChange: function (newData) {
        return { type: 'BUTTON_LOADING_STATE', newData }
    },
    saveStore: function (newData) {
        return { type: 'SAVED_STORE', newData }
    }, sendLocalFontsNametoStore: function (fonts) {
        return { type: 'LOCAL_FONTS', newData: fonts }
    },
    getLocalGoogleFonts: function () {
        var that = this;
        return function (dispatch, getState) {
            jQuery.ajax({
                url: window.ajaxurl,
                data: {
                    action: "local_font_details",
                    security: window.typehubAjax.nonce
                },
                type: 'POST'
            })
                .done((data) => {
                    var localFonts = JSON.parse(data);
                    dispatch(that.sendLocalFontsNametoStore(localFonts));
                    dispatch(that.progressOnGoing(false));
                })
                .fail((err) => {
                    console.log(err);
                });
        }
    },
    downloadFont: function (fonts) {
        var that = this;
        return function (dispatch, getState) {
            dispatch(that.progressRemainingFonts(fonts));
            if (fonts.length) {
                dispatch(that.progressOnGoing(true));
                jQuery.ajax({
                    url: window.ajaxurl,
                    data: {
                        action: 'download_font',
                        security: window.typehubAjax.nonce,
                        fontName: fonts.shift(),
                    },
                    type: 'POST'
                })
                    .done((data) => {
                        if (data === 'success') {
                            dispatch(that.downloadFont(fonts));
                            
                        } else if( data === 'permission denied' ) {
                            notification.error({
                                message: 'Permission Denied',
                                description: "Please check your file access settings",
                                placement: 'bottomRight'
                            })
                        }else{
                            console.log(data);
                        }
                    })
                    .fail((data) => {
                        console.log(data,'download failed');
                    });
            } else {
                dispatch(that.deleteUnusedFonts());
                dispatch(that.getLocalGoogleFonts());
            }
        }.bind(this);
    },
    progressRemainingFonts: function (remainingFonts) {
        return { type: 'REMAINING_FONTS', fonts: remainingFonts };
    },
    deleteUnusedFonts: function () {
        return function (dispatch, getState) {
            jQuery.ajax({
                url: window.ajaxurl,
                data: {
                    action: 'refresh_changes',
                    security: window.typehubAjax.nonce
                },
                type: 'POST',
            }).done((data) => {
            }).fail((data) => {
                console.log(data);
            });
        }
    },
    tempStatus : function( data ){
        return { type:'TEMP_STATUS', data }
    },
    progressOnGoing:function(onGoing){
        return {type:'ON_GOING',onGoing:onGoing};
    }
}