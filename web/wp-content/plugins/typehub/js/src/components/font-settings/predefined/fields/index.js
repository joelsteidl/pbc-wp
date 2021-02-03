import React from 'react';
import { Radio } from 'antd';
import CustomSelect from './select';
import { connect } from 'react-redux';
import NumberInputFields from './NumberInputFields';
import helper from '../../../../helper/helpers'
import settings from '../../../../actions/settingsInitAction';
import FontFamily from './fontFamily';
import ColorSelect from './color';
import deepEqual from 'deep-equal';
import shortId from 'shortid';

const RadioButton = Radio.Button;
const RadioGroup = Radio.Group;

var fieldContent = [];
var renderedKeys = [];
class Fields extends React.Component {
    constructor() {
        super();
        this.state = { responsiveOption: 'desktop'};
        this.onSelectChange = this.onSelectChange.bind(this);
        this.callerFunction = this.callerFunction.bind(this);
        this.responsiveOptionChange = this.responsiveOptionChange.bind(this);

        this.fieldOrder = ['font-family', 'font-variant', 'font-size', 'line-height', 'letter-spacing', 'text-transform', 'color'];
        this.isResposive = 0;
        this.showResponsiveChanger = false;
    }

    onSelectChange(key, keyDefault, value) {

        let tempValue = value;
        if (key === 'color') {
            if( value != '' && typeof value === 'object'){    
                if(value.active){
                    var activeState = value.active,
                        attValueTemp;
                    if( typeof value[activeState] === 'object' ){
                        attValueTemp = value[activeState].color;    
                    }

                    if(value.id){
                        tempValue = {
                            id: value.id,
                            color: attValueTemp
                        }
                    }else{
                        tempValue = attValueTemp
                    }
                }
            } else {
                tempValue = value;
            }
        }

        this.props.dispatch(settings.saveChangesSelect({
            items: this.props.checkedItemArray,
            field: key,
            value: tempValue,
            default: keyDefault,
            device: this.state.responsiveOption
        }));
    }

    responsiveOptionChange(e) {
        renderedKeys = [];
        fieldContent = [];
        this.setState({ responsiveOption: e.target.value });
        this.props.getSelectedDevice(e.target.value);
    }

    callerFunction(option,similarValues) {
        const optionConfig = this.props.store.initConfig.optionConfig[option];
        const fieldConfig = this.props.store.initConfig.fieldConfig;
        const savedValues = this.props.store.initConfig.savedValues[option];
        const savedFonts = window.typehub_fonts;

        var tempFont = '';
        this.fieldOrder.forEach((key) => {

            if (optionConfig.options.hasOwnProperty(key)) {

                if (!this.props.filterredFields.length || this.props.filterredFields.includes(key)) {
                    if (!renderedKeys.includes(key)) {
                        let tempIteratorObject = { name: fieldConfig[key].label, type: fieldConfig[key].type, slug: key };

                        let decideResponsiveness = false;

                        if (optionConfig.options[key].responsive === undefined) {
                            decideResponsiveness = fieldConfig[key].responsive;
                        } else {
                            decideResponsiveness = optionConfig.options[key].responsive;
                        }


                        if ((this.state.responsiveOption === 'desktop' || decideResponsiveness) && responsiveFilterHelper(this.props.filterSwitch, decideResponsiveness)) {
                            renderedKeys.push(key);
                            if (tempIteratorObject.type === 'select') {

                                if (!savedValues[key]) {
                                    if (optionConfig.options[key].default === '') {
                                        tempIteratorObject.default = fieldConfig[key].default;
                                    }else{
                                        tempIteratorObject.default = optionConfig.options[key].default;
                                    }
                                } else {
                                        tempIteratorObject.default = savedValues[key];
                                }

                                tempIteratorObject.list = fieldConfig[key].options;
                                if (key === 'font-family') {
                                    if (tempIteratorObject.default.split(':')[0] === 'schemes') {
                                        if (! this.props.store.fontSchemes[tempIteratorObject.default.split(':')[1]]) {
                                            tempIteratorObject.default = 'standard:System Font Stack';
                                        }
                                    }
                                    fieldContent.push(<FontFamily
                                        key={shortId.generate()}
                                        compName={tempIteratorObject.name}
                                        slug={tempIteratorObject.slug}
                                        changeListener={this.onSelectChange}
                                        defaultValue={ this.props.filterredFields.length ? similarValues[key] :tempIteratorObject.default}
                                    />);

                                } if (key === 'font-variant') {
                                    tempFont = savedValues['font-family'];
                                    if (!helper.isEmpty(tempFont)) {
                                        tempIteratorObject.list = [];
                                        let clickedFont = tempFont.split(':');
                                        if (tempFont.split(':')[0] === 'schemes') {
                                            if (! this.props.store.fontSchemes[clickedFont[1]]) {
                                                clickedFont = 'standard:System Font Stack';
                                            }else{
                                                clickedFont = this.props.store.fontSchemes[clickedFont[1]].fontFamily.split(':');
                                            }

                                        }else{
                                            clickedFont = tempFont.split(':');
                                        }
                                        if (['google','custom','typekit'].includes(clickedFont[0])) {
                                                if(savedFonts[clickedFont[0]][clickedFont[1]]){
                                                     savedFonts[clickedFont[0]][clickedFont[1]].variants.forEach((value) => {
                                                     tempIteratorObject.list.push(value);
                                                    });
                                                }else{
                                                    tempIteratorObject.list = [{ id: '400', name: 'Normal 400' },
                                                    { id: '400italic', name: 'Normal 400 Italic' },
                                                    { id: '700', name: 'Bold 700' },
                                                    { id: '700italic', name: 'Bold 700 Italic' }];
                                                }
                                        }else if(clickedFont[0] === 'standard'){

                                            if(clickedFont[1] === 'System Font Stack'){
                                                tempIteratorObject.list = [
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
                                            tempIteratorObject.list = [{ id: '400', name: 'Normal 400' },
                                                                        { id: '400italic', name: 'Normal 400 Italic' },
                                                                        { id: '700', name: 'Bold 700' },
                                                                        { id: '700italic', name: 'Bold 700 Italic' }];
                                            }
                                        } else {
                                            tempIteratorObject.list = [{ id: '400', name: 'Normal 400' }];
     
                                        }
                                        
                                        if (variantDefaultCompareHelper(tempIteratorObject.list, tempIteratorObject.default)) {                                         
                                            tempIteratorObject.default = { id: tempIteratorObject.default, name: tempIteratorObject.list.filter(item=>tempIteratorObject.default === item.id)[0].name }
                                        } else {
                                            tempIteratorObject.default = { id: '400', name: 'Normal 400' };
                                        }                  
                                    } else {
                                        tempIteratorObject.list = [{ id: '400', name: 'Normal 400' }];
                                        tempIteratorObject.default = { id: '400', name: 'Normal 400' };
                                    }
                                }
                                if (key === 'text-transform') {
                                    tempIteratorObject.list = tempIteratorObject.list.map((item) => { return { id: item.toLowerCase(), name: item } });
                                    if (typeof tempIteratorObject.default === 'string') {
                                        let tempName = tempIteratorObject.list.filter((item) => item.id === tempIteratorObject.default)[0];
                                        tempIteratorObject.default = { id: tempIteratorObject.default, name: tempName.name }
                                    }else{
                                        tempIteratorObject.default = { id: 'none', name: 'None' }
                                    }
                                }

                                key !== 'font-family' && key !== 'color' && fieldContent.push(<CustomSelect
                                    key={key}
                                    compName={tempIteratorObject.name}
                                    slug={tempIteratorObject.slug}
                                    changeListener={this.onSelectChange}
                                    defaultValue={this.props.filterredFields.length ? {id:similarValues[key]} :tempIteratorObject.default}
                                    list={tempIteratorObject.list}
                                />);
                            } else if (tempIteratorObject.type === 'number') {
                                this.isResposive = 1;
                                if (savedValues[key].desktop || savedValues[key].value) {
                                    if (savedValues[key].desktop) {
                                        if (savedValues[key][this.state.responsiveOption]) {
                                            tempIteratorObject.default = savedValues[key][this.state.responsiveOption].value;
                                            tempIteratorObject.unitDefault = savedValues[key][this.state.responsiveOption].unit;
                                        } else {
                                            let resOptionsArr = ['mobile', 'tablet', 'laptop', 'desktop'], flag = false;

                                            for (let option of resOptionsArr) {
                                                if (this.state.responsiveOption === option) {
                                                    flag = true;
                                                }
                                                if (flag && savedValues[key][option]) {
                                                    tempIteratorObject.default = savedValues[key][option].value;
                                                    tempIteratorObject.unitDefault = savedValues[key][option].unit;
                                                }
                                            }
                                        }
                                    } else {
                                        tempIteratorObject.default = savedValues[key].value;
                                        tempIteratorObject.unitDefault = savedValues[key].unit;
                                    }
                                } else {

                                    tempIteratorObject.default = fieldConfig[key].default;
                                    tempIteratorObject.unitDefault = fieldConfig[key].options.default;
                                }

                                tempIteratorObject.list = fieldConfig[key].options.units;

                                let numDefaultValue,numUnitDefault;

                                if(this.props.filterredFields.length){
                                    if(similarValues[key][this.state.responsiveOption]){

                                        numDefaultValue = similarValues[key][this.state.responsiveOption].value;
                                    }else{
                                        let resOptionsArr = ['mobile', 'tablet', 'laptop', 'desktop'], flag = false;

                                        for (let option of resOptionsArr) {
                                            if (this.state.responsiveOption === option) {
                                                flag = true;
                                            }
                                            if (flag && similarValues[key][option]) {
                                                numDefaultValue = similarValues[key][option].value;
                                            }
                                        }
                                    }
                                }else{
                                    numDefaultValue = tempIteratorObject.default;
                                }
                                
                                fieldContent.push(<NumberInputFields
                                    key={key}
                                    extrasForDispatch={{
                                        items: this.props.checkedItemArray,
                                        device: this.state.responsiveOption
                                    }}
                                    slug={tempIteratorObject.slug}
                                    compName={tempIteratorObject.name}
                                    defaultValue={numDefaultValue }
                                    unitDefault={tempIteratorObject.unitDefault}
                                    list={tempIteratorObject.list}

                                />);

                            } else if (tempIteratorObject.type === 'color') {

                                if (savedValues[key].desktop) {
                                    tempIteratorObject.default = savedValues[key].desktop;
                                } else {
                                    tempIteratorObject.default = savedValues[key];
                                }
                                fieldContent.push(<ColorSelect
                                    defaultValue={tempIteratorObject.default}
                                    key={option}
                                    changeListener={this.onSelectChange}
                                    compName={tempIteratorObject.name}
                                />)
                            }
                        }
                    }
                }
            }
        }
        );
        if(this.isResposive > 0){
            this.showResponsiveChanger = true;
        }else{
            this.showResponsiveChanger = false;
        }
    }

    componentWillReceiveProps(nextProps) {
        if (nextProps.checkedItemArray[0] !== this.props.checkedItemArray[0] ||
            nextProps.checkedItemArray.length !== this.props.checkedItemArray.length) {
            this.isResposive = 0;
            this.setState({responsiveOption:'desktop'})
        }

    }

    render() {
        renderedKeys = [];
        fieldContent = [];


        let checkedItems = this.props.checkedItemArray.map(item=>{
            return this.props.store.initConfig.savedValues[item]
        })
        let filterredFields = this.props.filterredFields;
        let responsiveState = this.state.responsiveOption;
        let similarFieldValues = checkedItems.reduce(function( a, b ) {
            let x = {};
            filterredFields.forEach( ( key ) => {
                
                    x[key] = a[key];
            }); 
            Object.keys(x).forEach( ( key )=> {
                
                if(typeof b[key] !== 'object' && x[key] != b[key] ){
                    x[key] = ' ';
                }else if(typeof b[key] === 'object'){ 
                    if(b[key].hasOwnProperty(responsiveState) && x[key].hasOwnProperty(responsiveState)){
                        if(!deepEqual(b[key][responsiveState],x[key][responsiveState])){
                            x[key] = ' ';
                        }else{
                            x[key] = {[responsiveState]:x[key][responsiveState]};
                        }
                    }else{
                        x[key] = ' ';
                    }
                }

            }); 
            return x;
        });

        for (var item of this.props.checkedItemArray) {
            this.callerFunction(item,similarFieldValues);
        }

        for(let option of this.props.checkedItemArray ){
            this.props.store.initConfig.optionConfig
        }

        let optionResponsiveness = this.props.checkedItemArray.every((option)=>this.props.store.initConfig.optionConfig[option].responsive === true);


        return (
            <div className='field-content' style={{ marginLeft: 40, background: '#fff', padding: 25,minWidth:360}} >

            {this.showResponsiveChanger && optionResponsiveness &&
                <div style={{ marginBottom: 30 }}  >
                    <RadioGroup onChange={this.responsiveOptionChange} value={this.state.responsiveOption}>
                        <RadioButton value="desktop">Desktop</RadioButton>
                        <RadioButton value="laptop">Laptop</RadioButton>
                        <RadioButton value="tablet">Tablet</RadioButton>
                        <RadioButton value="mobile">Mobile</RadioButton>
                    </RadioGroup>
                </div>
            }

                {fieldContent}
            </div>
        )
    }
}

function mapStateToProps(store, ownProps) {
    return {
        store
    }
}

export default connect(mapStateToProps)(Fields);


function responsiveFilterHelper(switchState, keyResponsive) {
    if (switchState) {
        if (keyResponsive) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

function variantDefaultCompareHelper(arr, defaultValue) {
  
    return arr.some((e) => e.id === defaultValue)

}