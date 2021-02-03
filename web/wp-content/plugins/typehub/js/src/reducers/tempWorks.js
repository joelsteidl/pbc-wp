import cloneDeep from 'clone-deep';

export default(state = {progress:[],onGoing:false, anyProcess : {}},action) => {
    
    var tempState = cloneDeep(state);
    switch (action.type) {
        case 'BUTTON_LOADING_STATE':
            return Object.assign({},state,{loader:action.newData.loader});
        case 'SAVED_STORE':
            return Object.assign({},state,action.newData);
        case 'LOCAL_FONTS':
            return Object.assign({},state,{ localFonts:action.newData });
        case 'REMAINING_FONTS':
            return Object.assign({},state,{ progress:action.fonts });
        case 'ON_GOING':
            return Object.assign({},state,{onGoing:action.onGoing});
        case 'TEMP_STATUS':
            tempState.anyProcess[action.data.task] = action.data.status;
            return tempState;
        default:
            return state;
    }
}