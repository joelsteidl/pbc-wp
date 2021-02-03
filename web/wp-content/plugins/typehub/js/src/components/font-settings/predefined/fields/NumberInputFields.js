import React from 'react';
import {Select,InputNumber,Input} from 'antd';
import {connect} from 'react-redux';
import settings from '../../../../actions/settingsInitAction';

const Option = Select.Option;

class NumberInputFiels extends React.Component{

    constructor(props){
        super(props);
        this.state = {unitValue:props.unitDefault,
                        value:props.defaultValue};
        this.onChange = this.onChange.bind(this);
        this.initialValue = props.defaultValue;
    }



    onChange(value){
        if(this.props.list.includes(value)){
            this.setState({unitValue:value});
            this.props.dispatch(settings.saveChangesNumber({
                items:this.props.extrasForDispatch.items,
                field:this.props.slug,
                value:this.props.defaultValue,
                unit:value,
                unitDefault:this.props.unitDefault,
                valueDefault:this.props.defaultValue,
                device:this.props.extrasForDispatch.device}));

        }else{
            if( isValueValid(this.props.slug,value) && !isNaN(value) && value !== ''){
                this.setState({value:value});
                this.props.dispatch(settings.saveChangesNumber({
                items:this.props.extrasForDispatch.items,
                field:this.props.slug,
                unit:this.props.unitDefault,
                value:value,
                unitDefault:this.props.unitDefault,
                valueDefault:this.props.defaultValue,
                device:this.props.extrasForDispatch.device
            }));
        }
        }
    }


    shouldComponentUpdate(nextProps,nextState){
        if( this.props.defaultValue !== nextProps.defaultValue || this.props.unitDefault !== nextProps.unitDefault){
            return true;
        }
        return false;
    }
    render(){
        const OptionList = this.props.list.map(item => {
            return <Option key={item} value={item}>{item}</Option>
        });
    return <div  className='fieldItem'>
        <Input.Group compact ><div className='field-label' style={{paddingTop:5}} >{this.props.compName} :</div>
        <InputNumber 
            style={{width:110,marginLeft:5}} 
            onChange={this.onChange} 
            value={this.props.defaultValue}
            formatter={value => !isNaN(value) || value === '-' ? value : value}
            />
            <Select value={this.props.unitDefault} onChange={this.onChange} style={{width:70}} >
                {OptionList}
            </Select>
            </Input.Group>
        </div>
    }
}

function mapStateToProps(store,ownProps){
    return {
        store
    }
}

export default connect(mapStateToProps)(NumberInputFiels);


function isValueValid(key,value){

    if(['font-size','line-height'].includes(key)){
        if(value >= 0){
            return true;
        }else{
            return false;
        }
    }else{
        return true;
    }

}