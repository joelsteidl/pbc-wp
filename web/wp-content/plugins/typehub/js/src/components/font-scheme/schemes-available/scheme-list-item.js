import React from 'react';
import SchemeEdit from '../scheme-edit';
import { Switch, List, Icon,Popconfirm } from 'antd';
import shortId from 'shortid';

class SchemeListItem extends React.Component{

    constructor( props ){
        super( props );
    }
    
    render() {
    var props = this.props;
    let switchMode = props.mode;
    let currentItemFont = props.store.fontSchemes[props.obj].fontFamily.split(':');

        if(currentItemFont[0] === 'standard'){
            currentItemFont[1] = window.typehub_fonts.standard[currentItemFont[1]];
        }else if(currentItemFont[0] === 'typekit'){
            currentItemFont[1] = window.typehub_fonts.typekit[currentItemFont[1]] ? window.typehub_fonts.typekit[currentItemFont[1]].cssname : window.typehub_fonts.standard[currentItemFont[1]];
        }

return <div
onMouseEnter={props.mouseEnter.bind(this,props.obj)}
onMouseLeave={props.mouseLeave.bind(this)}
>

<div  style={{
    display: 'flex', background: '#fff',
    cursor: 'pointer',
    position:'relative',
    borderBottom: '1px solid #e3e3e3'
}}
>
    <div
        style={{
            display: 'flex',
            justifyContent: 'flex-start',
            alignItems: 'center',
            width: '100%',
            padding: 10,
        }} 
        onClick={props.itemCheckListener.bind(this, props.obj)}
        >
        <span style={{flexBasis:'50px', marginTop: -1 }} >
            {props.bufferredScheme === props.obj ? switchMode = !switchMode : switchMode = props.mode}
            <Switch onChange={props.switchChange.bind(this, props.obj)} checked={switchMode} size="small" />
        </span>
        <div style={{ fontWeight: 500, flexBasis: '32.5%' }} >{props.store.fontSchemes[props.obj].name}</div>
        <div style={{ flexBasis: '20%' }} >{props.store.fontSchemes[props.obj].fontFamily.split(':')[1]}</div>
        <div style={{ fontFamily: currentItemFont[1], flexBasis: 'auto' }}>The spectacle before us was indeed sublime</div>
    </div>
    {!props.mode && !(['primary','secondary'].includes(props.obj))  && props.hoveredItem === props.obj ?
        <span style={{ alignSelf: 'center', padding: 5 }}  >
        <Popconfirm trigger='click' placement='left' title='Are you sure?' onConfirm={props.schemeDeleteListener.bind(this, props.obj)}   >
            <Icon type="delete" />
        </Popconfirm>
        </span> : <span style={{ alignSelf: 'center', padding: 5 }} ><div style={{ height: 14, width: 14 }}></div></span>}
        {props.clickedScheme === props.obj &&
            <div 
                style={{
                    background:'#fff',
                    height:20,
                    width:20,
                    top:'100%',
                    borderBottom:'1px solid #e3e3e3',
                    borderRight:'1px solid #e3e3e3',
                    left:'50%',
                    margin:'-10px 0',
                    transform:'rotate(45deg)',
                    position:'absolute'}}
            >
            </div>
        }
</div>
{ <div  >
        <SchemeEdit in={props.clickedScheme === props.obj} place='editor' addSchemeListener={props.hideScheme} checkedList={props.store.fontSchemes[props.obj].subsets} schemeName={props.store.fontSchemes[props.obj].name} selectedFont={props.store.fontSchemes[props.obj].fontFamily} mode={props.mode} schemeKey={props.obj} />
    </div>
}

</div>
}
}

export default SchemeListItem;