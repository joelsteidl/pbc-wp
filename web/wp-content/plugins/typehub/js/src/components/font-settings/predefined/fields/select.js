import React from 'react';
import {Select} from 'antd';

const Option = Select.Option;

class CustomSelect extends React.Component{


    shouldComponentUpdate(nextProps,nextState){
        
        if(this.props.defaultValue !== nextProps.defaultValue || this.props.list !== nextProps.list ){
            return true;
        }
        return false;

    }


render(){


    const OptionList = this.props.list.map(item => {
        return <Option key={item} value={item.id}>{item.name}</Option>
    });
    return <div  className='fieldItem'>
    <div className='field-label'>
        {this.props.compName} :  
    </div>
        <Select value={this.props.defaultValue.id} onChange={this.props.changeListener.bind(this,this.props.slug,this.props.defaultValue)} style={{width:180,marginLeft:5}} > 
            {OptionList}
        </Select>
    
        </div>
    }
}
export default CustomSelect;