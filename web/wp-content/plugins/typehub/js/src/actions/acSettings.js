import initSettings from './settingsInitAction';
import schemes from './acScheme';

export default{ 
    saveSettings : function(newData){
        return (dispatch,getState) => {
            if(window.WebFont){
            window.WebFont.load({typekit:{id:newData.typekitId}});
            var url = window.ajaxurl;
            jQuery.ajax({
                url:url,
                data:{
                    action: 'load_typekit_fonts',
                    security: window.typehubAjax.nonce,
                    typekitId:newData.typekitId,
                },
                type:'POST',
            }).done((data)=>{
                window.typehub_fonts.typekit = JSON.parse(data);
            }).fail((data)=>console.log(data))
        return dispatch({type:'SAVE_SETTINGS',newData});
        }else{
            message.error( "Please Check Internet Connection 2" );
        }
        }
    },
    deleteTypekit : function(){
        return (dispatch,getState) =>{
            dispatch(initSettings.removeTypekitFonts());
            dispatch(schemes.removeTypekitScheme());
            return dispatch({type:'DELETE_TYPEKITID'});
        }
    },
    loadFromLocalSwitch:function( status ){
        return {type:'LOAD_FROM_LOCAL_SWITCH',status:status};
    }
}