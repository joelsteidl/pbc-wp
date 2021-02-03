import React from 'react';
import { connect } from 'react-redux';
import acScheme from '../../../actions/acScheme';
import SchemeListItem from './scheme-list-item';
import TransitionGroup from 'react-transition-group/TransitionGroup';
import Fade from '../../../helper/animation-fade';
import helpers from '../../../helper/helpers';

class SchemesList extends React.Component {

    constructor() {
        super();
        this.state = {
            hoveredItem: null,
            bufferredScheme:null
        }
        this.switchChange = this.switchChange.bind(this);
    }

    switchChange(schemeID, e) {
        this.setState({bufferredScheme:schemeID},()=>{
                this.props.dispatch(acScheme.changeSchemeMode({ schemeID: schemeID, mode: e }));
                this.props.hideScheme();
                this.setState({bufferredScheme:null});
         
        });

    }

    mouseEnter(obj){
        this.setState({ hoveredItem: obj })
    }

    mouseLeave(e){

        this.setState({ hoveredItem: null })
    }

    componentWillMount() {

        for (let fontFamily of Object.keys(this.props.store.fontSchemes)) {
            helpers.fontLoader(this.props.store.fontSchemes[fontFamily].fontFamily);
        }

    }

    render() {

        let filteredItemArray = Object.keys(this.props.store.fontSchemes).filter((val) =>
            this.props.store.fontSchemes[val].active === this.props.mode);
        return (
            <div  >
                <div style={{display:'flex',
                        background:'#fff',
                        borderBottom: '1px solid #e3e3e3',}} >
                <div
                    style={{
                        display: 'flex',
                        justifyContent: 'flex-start',
                        alignItems: 'center',
                        width: '100%',
                        padding: 10
                    }} >
                    <span style={{ fontWeight: 600,flexBasis:'50px', marginTop: -1 }} >
                        State
                        </span>
                    <div style={{ fontWeight: 600, flexBasis: '32.5%' }} >Scheme Name</div>
                    <div style={{ fontWeight: 600,flexBasis: '20%' }} >Font Family</div>
                    <div style={{fontWeight: 600, flexBasis: 'auto' }}>Sample</div>
                </div>
                    <span style={{ alignSelf: 'center', padding: 5 }} ><div style={{ height: 14, width: 14 }}></div></span>
                </div>
                
                <TransitionGroup>
       { filteredItemArray.map((obj) =>(
            <Fade
            key={obj} >
          
       <SchemeListItem
                mouseEnter={this.mouseEnter.bind(this)}
                obj={obj}
                mouseLeave={this.mouseLeave}
                itemCheckListener={this.props.itemCheckListener}
                mode={this.props.mode}
                bufferredScheme={this.state.bufferredScheme}
                hoveredItem={this.state.hoveredItem}
                switchChange={this.switchChange}
                store={this.props.store}
                schemeDeleteListener={this.props.schemeDeleteListener}
                clickedScheme={this.props.clickedScheme}
                hideScheme={this.props.hideScheme}
            />
    </Fade>
            ))}
        </TransitionGroup>
            </div>
        )
    }
}

function mapStateToProps(store, ownProps) {
    return {
        store
    }
}
export default connect(mapStateToProps)(SchemesList);