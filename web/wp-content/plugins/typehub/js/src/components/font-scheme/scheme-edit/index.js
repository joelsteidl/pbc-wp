import React from 'react';
import SelectFont from './select-font'
import FontProperties from './font-preview'
import Transition from 'react-transition-group/Transition';

class SchemeEdit extends React.Component{

    constructor(props){
        super(props);
        this.state={clickedFont: props.selectedFont || 'google:ABeeZee',
                    keyName: props.schemeKey
                }
        this.fontClicked = this.fontClicked.bind(this);


    }

    fontClicked(item,source){
            this.setState({clickedFont:`${source}:${item}`});
    }

    componentWillReceiveProps(nextProps) {
        this.setState({keyName: nextProps.schemeKey});
    }

    render(){

        const transitionStyles = { 
            entering: { opacity: 1,height:500,margin:'20px 40px 30px 40px',transition: 'all 600ms ease' },
            entered:  { opacity: 1,height:500,margin:'20px 40px 30px 40px',transition: 'all 400ms ease' },
            exiting:{opacity:0,height:0,margin:'0px 40px 0px 40px',transition: 'all 500ms ease'},
            exited:{opacity:0,height:0,margin:'0px 40px 0px 40px',transition: 'all 300ms ease'}
          };
          const defaultStyles = {display:'flex',justifyContent:'space-between'};
        return (
            <Transition in={this.props.in} mountOnEnter unmountOnExit timeout={{enter:300,exit:600}}  >
            {(state)=><div style={Object.assign({},defaultStyles,transitionStyles[state])} >
            
         <SelectFont clickedFont={this.state.clickedFont} clicker={this.fontClicked} /> 
          
                <FontProperties 
                    schemeKey={this.state.keyName} 
                    schemeName={this.props.schemeName} 
                    addSchemeListener={this.props.addSchemeListener} 
                    clickedFont={this.state.clickedFont}
                    checkedList={this.props.checkedList}
                    mode={this.props.mode}
                    place={this.props.place}
                    />
                
            </div>}
            </Transition>
        )
    }

}
export default SchemeEdit;