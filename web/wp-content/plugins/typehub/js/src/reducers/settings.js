export default (state=window.typehubStore.settings,action) => {
    switch(action.type){
        case 'SAVE_SETTINGS':
            return Object.assign({},state,action.newData);
        case 'DELETE_TYPEKITID':
            return {};
        case 'LOAD_FROM_LOCAL_SWITCH':
            return Object.assign({},state,{loadFromLocal:action.status});
        default:
            return state;
    }
}