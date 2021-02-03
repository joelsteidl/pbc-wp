import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import cloneDeep from 'clone-deep';
import { Provider } from 'react-redux';
import configStore from './store/store'
import helpers from './helper/helpers';

var abc = {
    initConfig: {
        optionConfig:window.typehubStore.optionConfig
          ,
        fieldConfig: {
            "font-family": {
                "type": "select",
                "label": "Font Family",
                "default": "standard:System Font Stack",
                responsive:false
            },
            "color": {
                "type": "color",
                "label": "Font Color",
                "default": "rgba(0,0,0,1)",
                responsive:false
            },
            "font-variant": {
                "type": "select",
                "label": "Font Variant",
                "default": "400",
                responsive:false
            },
            "text-transform": {
                "type": "select",
                "label": "Text Transform",
                "options": [
                    "Uppercase",
                    "Lowercase",
                    "Capitalize",
                    "None",
                    "Inherit",
                    "Initial"
                ],
                "default": "none",
                responsive:false
            },
            "font-size": {
                "type": "number",
                "label": "Font Size",
                "options": {
                    "units": [
                        "px",
                        "%",
                        "em"
                    ],
                    "default": "px"
                },
                "default": "18",
                responsive:true
            },
            "line-height": {
                "type": "number",
                "label": "Line Height",
                "options": {
                    "units": [
                        "px",
                        "%",
                        "em"
                    ],
                    "default": "px"
                },
                "default": "30",
                responsive:true
            },
            "letter-spacing": {
                "type": "number",
                "label": "Letter Spacing",
                "options": {
                    "units": [
                        "px",
                        "%",
                        "em"
                    ],
                    "default": "px"
                },
                "default": "0",
                responsive:true
            },
            "font-smoothing": {
                "type": "select",
                "label": "Font Smoothing",
                "options": {
                    "antialiased": "Antialiased",
                    "subpixel-antialiased": "Subpixel Antialiased",
                    "none": "None"
                },
                "default": ""
            },
            "style": {
                "type": "text",
                "label": "Custom Styles",
                "default": "",
                "responsive": true
            }
        },
        savedValues:cloneDeep(window.typehubStore.savedValues)
    }
};
abc.initConfig.savedValues = savedValuesGenerator(abc.initConfig.optionConfig,abc.initConfig.savedValues,abc.initConfig.fieldConfig);

const store = configStore( abc );
ReactDOM.render(    <Provider store={store} >
                        <App />
                    </Provider>, document.getElementById('root'));


function savedValuesGenerator(optionConfig,savedValues,fieldConfig){

    for(var selector of Object.keys(optionConfig)){
        if(!savedValues[selector]){
            savedValues = Object.assign({},savedValues,{[selector]:0});
        }
            for(let eachField of Object.keys(optionConfig[selector].options)){
                if(savedValues[selector][eachField] === undefined){
                if((fieldConfig[eachField] && fieldConfig[eachField].type === 'select') || ( fieldConfig[eachField] && fieldConfig[eachField].type === 'color')){
                    if(optionConfig[selector].options[eachField].default !== undefined){
                        savedValues[selector] = Object.assign({},savedValues[selector],{[eachField]:optionConfig[selector].options[eachField].default});
                    }else{
                        savedValues[selector] = Object.assign({},savedValues[selector],{[eachField]:optionConfig[selector].options[eachField]});
                    }
                }else if(fieldConfig[eachField] && fieldConfig[eachField].type === 'number'){
                    if(optionConfig[selector].options[eachField].default !== undefined){
                        savedValues[selector] = Object.assign({},savedValues[selector],{[eachField]:{desktop:{value:optionConfig[selector].options[eachField].default,unit:'px'}}});
                    }else{
                        savedValues[selector] = Object.assign({},savedValues[selector],{[eachField]:{desktop:helpers.getCSSValueAndUnit(optionConfig[selector].options[eachField])}});
                    }
                }
            }
        } 
    }
    return savedValues;
    }