import React,{Component} from 'react';
import {Input,Icon,Radio} from 'antd';
import ItemList from './item-list';
import {connect} from 'react-redux';
import helpers from '../../../../helper/helpers';

const RadioButton = Radio.Button;
const RadioGroup = Radio.Group;

class SelectFont extends Component{
    constructor(props){
        super(props);
        this.state = {text:'',clickedList: props.clickedFont.split(':')[0] || 'google'}        
    }


    render(){
        return(
            <div >
                <div style={{marginTop:1,padding:'20px 20px',background:'#fff'}} >
                    <RadioGroup onChange={(e)=>this.setState({clickedList:e.target.value})} value={this.state.clickedList}>
                            <RadioButton value="google">Google</RadioButton>
                            <RadioButton value="standard">Standard</RadioButton>
                            <RadioButton value="custom">Custom</RadioButton>
                            {helpers.deepGet(this.props.store,['settings','typekitId']) && <RadioButton value="typekit">Typekit</RadioButton> }
                    </RadioGroup>
                </div>
                <Input style={{padding:20,background:'#fff'}} suffix={<Icon type="search" style={{ color: 'rgba(0,0,0,.25)',paddingRight:20 }}/>} placeholder="Search Fonts" onChange={(e)=>this.setState({text:e.target.value})}/>

                <div id="font-list"  >

                    <ItemList clicked={this.props.clicker} settings={helpers.deepGet(this.props.store,['settings','typekitId']) ? this.props.store.settings : ''} source={this.state.clickedList} list={ window.typehub_fonts[this.state.clickedList]} text={this.state.text} clickedFont={this.props.clickedFont} /> 
                
                </div>
            </div>
        )
    }
}

function mapStateToProps(store,ownProps){
    return {store}
}

export default connect(mapStateToProps)(SelectFont);