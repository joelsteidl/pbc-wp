import React from 'react';
import Subsets from './subset';
import FontPreview from './preview';
import {Button,Input} from 'antd';
import helpers from '../../../../helper/helpers';
import {connect} from 'react-redux';
import acScheme from '../../../../actions/acScheme'

class FontProperties extends React.Component{

    constructor(props){
        super(props);
        this.state={
            schemeName:props.schemeName || `Scheme ${Object.keys(props.store.fontSchemes).length}`,
            
        }
        this.saveScheme = this.saveScheme.bind(this);
    }

    saveScheme(){
        this.props.dispatch(acScheme.saveScheme({
            [this.props.schemeKey]:{
            name:this.state.schemeName,
            fontFamily:this.props.clickedFont,
            active:  typeof this.props.mode !== 'undefined' ? this.props.mode : true
            }
        }));
        this.props.addSchemeListener(false);
    }


    render(){

        this.clickedFontScource = this.props.clickedFont.split(':')[0]
        this.clickedFontName = this.props.clickedFont.split(':')[1];
        let subsetList = [{id:'latin',name:'Latin'}] ;
        if(this.clickedFontScource !== 'standard'){
            subsetList = window.typehub_fonts[this.clickedFontScource][this.clickedFontName] ? window.typehub_fonts[this.clickedFontScource][this.clickedFontName].subsets : [];
        }
        const subsets = subsetList.map((sub, index) => index+1 !== subsetList.length ?  `${sub.name} | ` : sub.name );
        let tempStyle = helpers.deepGet(this.props.store,['settings','typekitId']) ? {maxWidth:660} : {};
        return(
            
            <div style={Object.assign({},{flexBasis:'auto',flexGrow:1,marginLeft:30})} >

            <div style={{padding:10,background:'#fff',marginBottom:20}} >Scheme Name :   
                <Input 
                    placeholder="Scheme Name"
                    value={this.state.schemeName} 
                    style={{width:250,marginLeft:5}} 
                    onChange={(e)=>this.setState({schemeName:e.target.value})} /> 
                <div style={{position:'relative',display:'inline-block'}} >
                    <Button size='default' style={{width:100,marginLeft:20}} onClick={this.saveScheme} disabled={this.state.schemeName.trim().length  === 0} type="primary"> {this.props.place === 'adder'? 'Add Font' : 'Update'} </Button>

                    <Button size='default' style={{marginLeft:10,borderColor:'#f00',width:100}} type="danger" onClick={this.props.addSchemeListener.bind(this,false)}  >Cancel</Button>
                </div>
            </div>

            <FontPreview clickedFont={this.props.clickedFont} />
            <div style={{marginTop:20,background:'#fff'}} >
                <div style={{padding:10,marginBottom:1,fontWeight:500,display:'inline-block'}} >Available Subsets : </div>
                    {subsets}
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
export default connect(mapStateToProps)(FontProperties);