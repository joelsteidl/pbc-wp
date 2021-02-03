import React from 'react';
import { Checkbox, Select,Switch,Row,Col } from 'antd';
import shortid from 'shortid';

const Option = Select.Option;
const CheckboxGroup = Checkbox.Group;

class Filter extends React.Component {


    render() {
        const ddItems = this.props.filterProps.availableFields.map((item) =>
            <Option key={shortid.generate()} value={item.key} >{item.label}</Option>
        );
        const categoriesCheckBox = this.props.filterProps.categories.map((item)=>
        <div key={shortid.generate()} className='filter-category-item' ><Checkbox value={item}>{item}</Checkbox></div>
    );

        return (

            <div style={{width:350}} >
                <div>
                    <span style={{fontWeight:600}} > Filter By Category: </span>
                    <div style={{marginTop:5}} >
                        <CheckboxGroup value={this.props.filterProps.selectedCategory} onChange={this.props.filterProps.checkboxClickFn} >
                        <div>
                            {categoriesCheckBox}
                        </div>
                        </CheckboxGroup>
                    </div>
                </div>
                <div style={{marginTop:20}} >
                <span style={{fontWeight:600}}  >Filter By Field Type:</span>
                <div style={{marginTop:15,marginBottom:20}}  >
                    <Select getPopupContainer={triggerNode => triggerNode.parentNode} value={this.props.filterProps.filterredFields} onChange={this.props.filterProps.fieldFilterChange} mode='multiple' style={{ width: 300 }}  >

                        {ddItems}

                    </Select>
                    
                    </div>
                </div>
               { this.props.filterProps.responsiveFilterVisiblity && <div style={{marginBottom:20}} >
                <span style={{paddingRight:5}} >Responsive:</span>
                    <Switch size='small' checked={this.props.filterProps.filterSwitch}  onChange={this.props.filterProps.responsiveFilterChange} />
                </div>}
            </div>

        )
    }

}

export default Filter;