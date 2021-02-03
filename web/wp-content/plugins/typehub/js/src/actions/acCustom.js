import initConfig from './settingsInitAction';
import shortid from 'shortid';
import {message} from 'antd';
import acScheme from './acScheme';
import acTempWorks from './acTempWorks';

export default{ 
    importCustomOption : function(newData){
        return {type:'IMPORT_CUSTOM_OPTION',newData}
    },
    addCustomOption : function(newData){
        return (dispatch, getState) => {

            let defaultValues = {
                'font-family'    : 'standard:System Font Stack',
                'font-variant'   : '400',
                'text-transform' : 'none',
                'font-size'      : {desktop:{value:'16',unit:'px'}},
                'letter-spacing' : {desktop:{value:'0',unit:'px'}},
                'line-height'    : {desktop:'1em'},
                'color'          : ''
                },
                tempItems = {},
                uid = shortid.generate();

            newData.checkedList.forEach(function(item){
                tempItems[item] = defaultValues[item];
            });
            
            let tempObj = { [uid] : {
                    category : 'Custom',
                    label : newData.label,
                    selector : newData.selector,
                    options : tempItems,
                    'responsive'     : true,
                    'expose'         : false   
                } };
            dispatch(initConfig.addCustomOptionToConfig(tempObj));
            return dispatch({type:'ADD_CUSTOM_OPTION',tempObj});
        }
    },
    removeCustomOption : function(newData){
        return (dispatch, getState) => {
            dispatch(initConfig.removeCustomOptionFromConfig(newData));
            return dispatch({type:'REMOVE_CUSTOM_OPTION',newData});
        }
    },
    editCustomOption : function( newData ){
        return (dispatch, getState) => {

            let state = getState(),
                savedValue = {},
                uid = newData.uid,
                defaultValues = {
                'font-family'    : 'standard:System Font Stack',
                'font-variant'   : '400',
                'text-transform' : 'none',
                'font-size'      : {desktop:{value:'16',unit:'px'}},
                'letter-spacing' : {desktop:{value:'0',unit:'px'}},
                'line-height'    : {desktop:'1em'},
                'color'          : ''
                },
                tempItems = {};
            if(typeof state.initConfig.savedValues[uid] === 'object'){
                savedValue = state.initConfig.savedValues[uid];
            }

            newData.checkedList.forEach(function(item){
                tempItems[item] = savedValue[item] || defaultValues[item];
            });
            newData.options = tempItems;
            dispatch(initConfig.editCustomOptionInConfig(newData));
            return dispatch({type:'EDIT_CUSTOM_OPTION',newData});
        }
    },
    addNewFont : function(newData){
        return ( dispatch, getState ) => {
                let file = newData.file,
                    name = 'asds',
                    fd = new FormData();

                fd.append('file', file);
                fd.append('name', name);
                fd.append('action', 'add_custom_font');
                fd.append('security', window.typehubAjax.nonce);
                dispatch( acTempWorks.tempStatus({task:'customFontUpload', status : true}) );
                jQuery.ajax({
                    type : 'POST',
                    url : window.ajaxurl,
                    data : fd,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        response = JSON.parse(response);
                  
                        switch(response.status){
                            case 'success' :
                                window.typehub_fonts.custom[response.name] = { src : response.url, variants : [{id:'400', name:"Normal"}] }
                                dispatch({type:'ADDED_CUSTOM_FONT', newData : response});
                                dispatch(acScheme.sendStore());
                                break;
                            case 'write permission denied' : 
                                message.error('Sorry! Please check access permissions in your server');
                                break;
                            case 'file already exists' : 
                                message.warning('Sorry! The font already exists');
                                break;
                            case 'invalid_zip' : 
                                message.warning('Sorry! The zip file seems to be invalid');
                                break;
                            case 'failed' :
                                message.error('Sorry! Upload failed, Please refresh the page and try again ');
                                break;
                            default :
                                break;
                        }

                        dispatch( acTempWorks.tempStatus({task:'customFontUpload', status : false}) );
                    }
                });
        }
    },
    removeCustomFont : function( name ){
        return ( dispatch, getState ) => {
            jQuery.ajax({
                type:'POST',
                url : window.ajaxurl,
                data : {
                    name : name,
                    security : window.typehubAjax.nonce,
                    action : 'remove_custom_font',
                },
                success: function(response){
                    delete window.typehub_fonts.custom[name];
                    dispatch({type:'REMOVE_CUSTOM_FONT', name});
                    return dispatch(acScheme.sendStore());

                }
            })
        }
    }
}