import React from 'react';
import {Popover} from 'antd';
import ColorPicker from '../../../../gradient-picker/gradientColorPicker';
import helpers from '../../../../helper/helpers';

class ColorSelect extends React.Component{


     shouldComponentUpdate(nextProps,nextState){
        
        if(this.props.defaultValue !== nextProps.defaultValue ){
            return true;
        }
        return false;

    } 

render(){
    let colorInput  = '#ffffff';
    
    if(typeof this.props.defaultValue === 'string'){
        colorInput = {active:'solid',
                      solid:{
                          color:this.props.defaultValue
                      }
                    }
    }else{
        colorInput = this.props.defaultValue;
    }

    return <div  style={{display:'flex',alignItems:'flex-end',justifyContent:'flex-end',alignItems:'center'}} className='fieldItem'>
        <div style={{marginRight:5,paddingBottom:5}} className='field-label'  >
            {this.props.compName} :  
        </div>

            <div style={{height:30,display:'flex',justifyContent:'flex-start',width:180}} >
        <Popover trigger={'click'} placement='rightBottom' autoAdjustOverflow={true} 
                content={   <ColorPicker 
                                enableGradient = {false}
                                color = {colorInput}
                                colorHub={window.colorhub || '' }
                                calculateTop = { ()=> null }
                                quickChange = { true }
                                enableSwatch={window.colorhub ? !!window.colorhub.swatches : false}
                                enablePalette = {window.colorhub ? !!window.colorhub.palettes : false}
                                gradientAngle = "45"
                                onChange = {this.props.changeListener.bind(this,'color',this.props.defaultValue)} />}>
                <div style={{height:25,width:60,borderRadius:15,border:'1px solid rgba(0,0,0,0.25)',background:helpers.getColorValue(this.props.defaultValue)}}  >   </div>
        

        </Popover>
</div>
        </div>
    }
}
export default ColorSelect;