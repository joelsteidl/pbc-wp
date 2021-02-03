import cloneDeep from 'clone-deep';

export default (state=window.typehubStore.fontSchemes,action) => {
    switch(action.type){
        case 'SAVE_SCHEME':
            return Object.assign({},state,action.scheme);
        case 'CHANGE_SCHEME_MODE':
        let temp = Object.assign({},state[action.mode.schemeID],{active:action.mode.mode});
            return Object.assign({},state,{[action.mode.schemeID]:temp});
        case 'DELETE_SCHEME':
            let temp1 = cloneDeep(state);
            delete temp1[action.scheme.scheme];
            return temp1;
        case 'IMPORT_SCHEMES':
            return action.schemes;
        case 'REMOVE_TYPEKIT':
            
            let tempSchemes = cloneDeep(state);
            for(let scheme of Object.keys(tempSchemes)){
                let fontOfScheme = tempSchemes[scheme].fontFamily.split(':');
                if( fontOfScheme[0] === 'typekit'){
                    tempSchemes[scheme].fontFamily = "standard:System Font Stack";
                }
            }
            return tempSchemes; 
        default:
            return state;
    }
}