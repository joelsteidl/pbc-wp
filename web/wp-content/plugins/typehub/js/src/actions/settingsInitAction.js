export default{ 
    saveStore: function(configData){
        return {type:'SAVE_STORE',configData};
    },
    saveChangesSelect:function(newData){
        return function( dispatch, getState ) {
            let state = getState();
            return dispatch({type:'SAVE_CHANGES_SELECT',newData,state});
        }
    },
    saveChangesNumber:function(newData){
        return {type:'SAVE_CHANGES_NUMBER',newData};
    },
    selectedSchemeDeleted:function(newData){
        return {type:'SELECTED_SCHEME_DELETED',newData}
    },
    loadingStateChange:function(newData){
        return {type:'BUTTON_LOADING_STATE',newData}
    },
    removeTypekitFonts:function(newData){
        return {type:'REMOVE_TYPEKIT_FONTS'}
    },
    addCustomOptionToConfig: function(newData){
        return { type: 'ADD_CUSTOM_OPTION_TO_CONFIG', newData }
    },
    editCustomOptionInConfig: function(newData){
        return { type: 'EDIT_CUSTOM_OPTION_IN_CONFIG', newData }
    },
    removeCustomOptionFromConfig: function(newData){
        return { type: 'REMOVE_CUSTOM_OPTION_FROM_CONFIG', newData }
    }
}