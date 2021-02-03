import cloneDeep from 'clone-deep';

let defaultValue = {};

if( window.typehubStore.custom ){
    if( !Array.isArray(window.typehubStore.custom) ){
        defaultValue = window.typehubStore.custom;
    }
}

export default (state = defaultValue, action) => {
    let tempState = cloneDeep(state);
    switch(action.type){
        case 'IMPORT_CUSTOM_OPTION':
            return action.newData;
        case 'ADD_CUSTOM_OPTION':
            tempState.options = Object.assign ({}, tempState.options, action.tempObj);
            return tempState;
        case 'REMOVE_CUSTOM_OPTION':
            let key = action.newData;
            delete tempState.options[key];
            return tempState;
        case 'EDIT_CUSTOM_OPTION':
            let uid = action.newData.uid;
            if( tempState.options[uid] ){
                tempState.options[uid].label = action.newData.label;
                tempState.options[uid].selector = action.newData.selector;
                tempState.options[uid].options = action.newData.options;
            }
            return tempState;
        case 'ADDED_CUSTOM_FONT':
            let tempObj = { [action.newData.name] : { src : action.newData.url, variants : [{id:'400', name : 'Normal'}] } }
            tempState.fonts = Object.assign({}, tempState.fonts, tempObj);
            return tempState;
        case 'REMOVE_CUSTOM_FONT':
            delete tempState.fonts[action.name];
            return tempState;
        default:
            return state;
    }
}