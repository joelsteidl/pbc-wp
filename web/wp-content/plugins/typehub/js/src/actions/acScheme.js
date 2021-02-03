import cloneDeep from 'clone-deep';
import tempWorks from './acTempWorks';
import {message,notification} from 'antd';
import helper from '../helper/helpers';
import initConfig from './settingsInitAction';

export default{
    saveScheme:(scheme) => {
        return {type:'SAVE_SCHEME',scheme};
    },
    changeSchemeMode:(mode) => {
        return {type:'CHANGE_SCHEME_MODE',mode};
    },
    deleteScheme:(scheme) => {
        return (dispatch,getState)=>{
                dispatch(initConfig.selectedSchemeDeleted(scheme));
            return dispatch({type:'DELETE_SCHEME',scheme});
        }
    },sendStore:() => {
        return (dispatch, getState) => {
            var state = getState();
			var processedState = cloneDeep(state);
            dispatch(tempWorks.saveStore({savedValues:state.initConfig.savedValues,fontSchemes:state.fontSchemes,settings:state.settings,custom:state.custom}));
            processedState.savedValues = helper.postProcessSavedValues(processedState.initConfig.savedValues,processedState.initConfig.fieldConfig);
            var url = window.ajaxurl;
			dispatch(tempWorks.loadingStateChange({loader:true}));
            jQuery.ajax({
                url:url,
                data:{
                    action:"typehub_save_store",
                    security: window.typehubAjax.nonce,
                    store:JSON.stringify(processedState)
                },
                beforeSend : function ( xhr ) {
                    xhr.setRequestHeader( 'X-WP-Nonce', window.typehubAjax.nonce )
                },
				type:'POST'}) 
				.done((data)=>{
					if(data.trim() === 'success'){
                        notification.success({
                            message: 'Success!',
                            description: 'Changes Saved',
                            style:{
                                top:100
                            }
                          });
						dispatch(tempWorks.loadingStateChange({loader:false}));
					}else{
						message.info('Oops! Something went Wrong');
					}
				})
				.fail((err)=>{
					console.log(err);
			});

        }
    },importSchemes:(schemes)=>{
		return {type:'IMPORT_SCHEMES',schemes}
    },removeTypekitScheme:()=>{
        return {type:'REMOVE_TYPEKIT'}
    }
    

}