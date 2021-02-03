import React from 'react';
import {Input,Icon,Radio} from 'antd';
import {connect} from 'react-redux';
import helpers from '../../../../helper/helpers';
import ItemList from '../../../font-scheme/scheme-edit/select-font/item-list';


const RadioButton = Radio.Button;
const RadioGroup = Radio.Group;

let displayDefault;
class FontFamilyComponent extends React.Component{

    constructor(props){
        super(props);
        this.fontCategoryList = ['google','custom','standard','schemes'];
		this.state = {
            isClicked:false,
			isMouseIn:false,
            searchTxt:'',
            clickedList: this.fontCategoryList.includes(props.defaultValue.split(':')[0]) ? props.defaultValue.split(':')[0] : 'google'
		}
		this.itemClickFn = this.itemClickFn.bind(this);
        this.searchFieldChange = this.searchFieldChange.bind(this);
    }
    
    itemClickFn(fontName,source){
		this.setState({
            isClicked:false,
            searchTxt:''
        });
        this.props.changeListener('font-family',displayDefault,source+':'+ fontName);
    } 

	searchFieldChange(e){
		this.setState({searchTxt:e.target.value});
	}

    componentWillMount() {
        document.addEventListener('click',()=> !this.state.isMouseIn && this.setState({isClicked:false,searchTxt:''}));
    }

    componentWillReceiveProps(nextProps) {

        this.setState({searchTxt:'',clickedList:this.fontCategoryList.includes(this.props.defaultValue.split(':')[0]) ? this.props.defaultValue.split(':')[0] : 'google'})
    }

    render(){



    let tempWidth = helpers.deepGet(this.props.store,['settings','typekitId']) ? 380 : 320;

    let iconStyle = {cursor:'pointer',fontSize:13,transition:'0.3s',color:'rgba(0,0,0,0.25)'}
    this.state.isClicked ? iconStyle.transform = 'rotate(180deg)' : '';
    
    displayDefault =  this.props.defaultValue.split(':')[1] ? 
    this.props.defaultValue.split(':')[0] === 'schemes' ?
                        !!this.props.store.fontSchemes[this.props.defaultValue.split(':')[1]] &&  this.props.store.fontSchemes[this.props.defaultValue.split(':')[1]].name : 
                        this.props.defaultValue.split(':')[1] :
                        this.props.defaultValue;


    return( <div className='fieldItem' style={{position:'relative'}}> 

    <div 
        className='virtualized-drop-down' style={{display:'flex',alignItems:'center'}} 
        onMouseEnter={()=>this.setState({isMouseIn:true})} 
        onMouseLeave={()=>this.setState({isMouseIn:false})}
        >
            <div className='field-label'  style={{marginRight:5}} >
        {this.props.compName} :
    </div>
        <Input 
            style={{width:180}}
            value={displayDefault} 
            readOnly
            onClick={()=>this.setState({isClicked:!this.state.isClicked})}
            suffix={<Icon type="down" style={iconStyle} onClick={()=>this.setState({isClicked:!this.state.isClicked})}/>}
        />

        { this.state.isClicked && 
			<div   style={{backgroundColor:'#fff',boxShadow:'rgba(163, 167, 171, 0.35) -1px 4px 20px 3px',position:'absolute',right:0,top:'105%',width:tempWidth,cursor:'pointer',zIndex:10,borderRadius:'5px'}} >
            <div  >

                <div id='font-family-radio' style={{marginBottom:1,padding:'20px 0px 10px 25px',borderTop:'1px solid rgba(0,0,0,0.06)',background:'#fff'}} >
                <RadioGroup onChange={(e)=>this.setState({clickedList:e.target.value})} value={this.state.clickedList}>
                        <RadioButton value="google">Google</RadioButton>
                        <RadioButton value="standard">Standard</RadioButton>
                        <RadioButton value="custom">Custom</RadioButton>
                        <RadioButton value="schemes">Schemes</RadioButton>
                        {helpers.deepGet(this.props.store,['settings','typekitId']) && <RadioButton value="typekit">Typekit</RadioButton> }
                </RadioGroup>
                </div>
                <Input style={{padding:'10px 24px',background:'#fff'}} suffix={<Icon type="search" style={{ color: 'rgba(0,0,0,.25)',paddingRight:20 }}/>} placeholder="Search Fonts" onChange={(e)=>this.setState({searchTxt:e.target.value})}/>


                <div id="font-list" style={{marginTop:1}} >

                    <ItemList 
                        clicked={this.itemClickFn} 
                        settings={helpers.deepGet(this.props.store,['settings','typekitId']) ? this.props.store.settings : ''}
                        source={this.state.clickedList} 
                        fontSchemes={this.props.store.fontSchemes} 
                        settings={this.props.store.settings}
                        activeFontSchemes={Object.keys(this.props.store.fontSchemes).filter(scheme=>this.props.store.fontSchemes[scheme].active)} 
                        text={this.state.searchTxt} 
                        clickedFont={this.props.defaultValue} /> 
                
                </div>
            </div>
                
			</div>}
        </div>
        </div>
    )
}
}
function mapStateToProps(store,ownProps){
    return {
        store
    }
}


export default connect(mapStateToProps)(FontFamilyComponent);