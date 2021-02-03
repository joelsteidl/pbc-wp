import cloneDeep from 'clone-deep';
import helpers from '../helper/helpers';

export default (state = {}, action) => {


    let abc = cloneDeep(state);
    let value;


    switch (action.type) {
        case 'SAVE_STORE':
            let clonedState = state;
            clonedState.savedValues = action.configData;
            return Object.assign({}, clonedState);
        case 'SAVE_CHANGES_SELECT':
            value = action.newData.value;
            for (let eachItem of action.newData.items) {
                if (state.optionConfig[eachItem].options.hasOwnProperty(action.newData.field)) {
                    abc.savedValues[eachItem][action.newData.field] = value;
                }
                if (action.newData.field === 'font-family') {

                    let fontFamilyValue = abc.savedValues[eachItem]["font-family"];
                    let fontVariantValue = abc.savedValues[eachItem]["font-variant"];
                    let variantList = [];

                    if (fontFamilyValue.split(':')[0] === 'schemes') {
                        if (!action.state.fontSchemes[fontFamilyValue.split(':')[1]]) {
                            fontFamilyValue = 'standard:System Font Stack';
                        } else {
                            fontFamilyValue = action.state.fontSchemes[fontFamilyValue.split(':')[1]].fontFamily;
                        }
                    }

                    if (['google','typekit', 'custom'].includes(fontFamilyValue.split(':')[0])) {
                        if( !helpers.isEmpty( window.typehub_fonts[fontFamilyValue.split(':')[0]] ) ){
                            if (window.typehub_fonts[fontFamilyValue.split(':')[0]][fontFamilyValue.split(':')[1]]) {
                                window.typehub_fonts[fontFamilyValue.split(':')[0]][fontFamilyValue.split(':')[1]].variants.forEach((value) => {
                                    variantList.push(value);
                                });
                            } else {
                                variantList = [{ id: 400, name: 'Normal 400' }];
                            }
                        }
                    } else {

                        if(fontFamilyValue.split(':')[1] === 'System Font Stack'){
                            variantList = [
                                { id: '100', name: 'Ultra Light 100' },
                                { id: '100italic', name: 'Ultra Light 100 Italic' },
                                { id: '200', name: 'Light 200' },
                                { id: '200italic', name: 'Light 200 Italic' },
                                { id: '300', name: 'Book 300' },
                                { id: '300italic', name: 'Book 300 Italic' },
                                { id: '400', name: 'Normal 400' },
                                { id: '400italic', name: 'Normal 400 Italic' },
                                { id: '500', name: 'Medium 500' },
                                { id: '500italic', name: 'Medium 500 Italic' },
                                { id: '600', name: 'Semi-Bold 600' },
                                { id: '600italic', name: 'Semi-Bold 600 Italic' },
                                { id: '700', name: 'Bold 700' },
                                { id: '700italic', name: 'Bold 700 Italic' },
                                { id: '800', name: 'Extra-Bold 800' },
                                { id: '800italic', name: 'Extra-Bold 800 Italic' },
                                { id: '900', name: 'Ultra-Bold 900' },
                                { id: '900italic', name: 'Ultra-Bold 900 Italic' }                                                  
                            ];
                        }else{
                            variantList = [
                                { id: '400', name: 'Normal 400' },
                                { id: '400italic', name: 'Normal 400 Italic' },
                                { id: '700', name: 'Bold 700' },
                                { id: '700italic', name: 'Bold 700 Italic' }
                            ];
                        }


                    }
                    if (!variantDefaultCompareHelper(variantList, fontVariantValue)) {
                        abc.savedValues[eachItem]["font-variant"] = '400';
                    }

                }

            }
            return abc;

        case 'SAVE_CHANGES_NUMBER':

            let selectedDevice = action.newData.device;
            value = action.newData.value;

            for (let eachItem of action.newData.items) {
                if (state.optionConfig[eachItem].options.hasOwnProperty(action.newData.field)) {
                    if (state.savedValues[eachItem][action.newData.field].desktop) {
                        abc.savedValues[eachItem][action.newData.field] = Object.assign({}, abc.savedValues[eachItem][action.newData.field], { [selectedDevice]: { unit: action.newData.unit, value: action.newData.value } });
                    } else {
                        abc.savedValues[eachItem][action.newData.field] = { desktop: { unit: action.newData.unitDefault, value: action.newData.valueDefault } };
                        abc.savedValues[eachItem][action.newData.field] = Object.assign({}, abc.savedValues[eachItem][action.newData.field], { [selectedDevice]: { unit: action.newData.unit, value: action.newData.value } });
                    }
                }
            }
            return abc;

        case 'SELECTED_SCHEME_DELETED':

            let tempSavedValues = cloneDeep(state);

            for (let option of Object.keys(tempSavedValues.savedValues)) {
                if (tempSavedValues.savedValues[option]['font-family'] === `schemes:${action.newData.scheme}`) {
                    tempSavedValues.savedValues[option]['font-family'] = 'standard:System Font Stack';
                }
            }

            return tempSavedValues;

        case 'REMOVE_TYPEKIT_FONTS':
            let tempstate = cloneDeep(state.savedValues);
            for (let options of Object.keys(tempstate)) {
                if (tempstate[options]['font-family']) {
                    let fontFamilyValue = tempstate[options]['font-family'].split(':');
                    if (fontFamilyValue[0] === 'typekit') {
                        tempstate[options]['font-family'] = 'standard:System Font Stack';
                    }
                }
            }

            return Object.assign({},state,{savedValues:tempstate});
        case 'ADD_CUSTOM_OPTION_TO_CONFIG':
            let optionKey = Object.keys(action.newData)[0];
            abc.optionConfig = Object.assign({}, abc.optionConfig, action.newData);
            abc.savedValues[optionKey] = action.newData[optionKey].options;
            return abc;
        case 'REMOVE_CUSTOM_OPTION_FROM_CONFIG':
            let key = action.newData;
            delete abc.optionConfig[key];
            delete abc.savedValues[key];
            return abc;
        case 'EDIT_CUSTOM_OPTION_IN_CONFIG' :
            let configKey = action.newData.uid,
                label = action.newData.label,
                selector = action.newData.selector,
                options = action.newData.options;

            if( typeof abc.optionConfig[configKey] === 'object' ){
                abc.optionConfig[configKey].label = label;
                abc.optionConfig[configKey].selector = selector;
                abc.optionConfig[configKey].options = options;
                abc.savedValues[configKey] = options;
            }

            return abc;
        default:
            return state;
    }
}

function variantDefaultCompareHelper(arr, defaultValue) {

    return arr.some((e) => e.id === defaultValue)

}