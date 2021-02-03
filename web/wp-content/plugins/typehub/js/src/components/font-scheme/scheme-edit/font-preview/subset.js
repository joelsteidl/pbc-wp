import React from 'react';
import {Col,Row,Checkbox,Input} from 'antd';

class Subsets extends React.Component{

    shouldComponentUpdate(nextProps,nextState){
        return this.props.source !== nextProps.source || this.props.clickedFont !== nextProps.clickedFont;
    }

    render(){

        var props = this.props;
let selectedFontSubsets = window.typehub_fonts[props.source][props.clickedFont] ? window.typehub_fonts[props.source][props.clickedFont].subsets : [] ;
    const subsList = selectedFontSubsets.map((sub, index) => {
        return <Col key={index} span={6}>
                {sub.name}
        </Col>
    });

        return(
        <div style={{ marginTop: 20,padding:20, background: '#fff' }} >
        <div style={{paddingLeft:5}} >Scheme Name :  <Input placeholder="Scheme Name" value={props.schemeName} style={{width:250}} onChange={props.nameChangeListener} /> </div>
            <Row style={{paddingTop:10}} >
                {subsList}
            </Row>
        </div>
        )
}
}
export default Subsets;