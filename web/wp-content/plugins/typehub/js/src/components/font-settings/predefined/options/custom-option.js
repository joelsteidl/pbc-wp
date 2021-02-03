import React from 'react';
import {Modal, Button, Input, Checkbox} from 'antd';
import { connect } from 'react-redux';

const CheckboxGroup = Checkbox.Group;

class CustomOption extends React.Component{

    constructor(props){
        super(props);
        this.state = {
            label:'',
            selector:'',
            checkedList : []
        }
    }

    validateInputs(){
        let label = this.state.label,
            selector = this.state.selector;

        if( label.trim().length && selector.trim().length ){
            if( this.state.checkedList.length ){
                return true;
            }
        }

        return false;
    }

    modalCancel(){
        this.setState({
            label : '',
            selector: '',
            checkedList : []
        });
        this.props.cancelHandler();
    }

    componentWillMount() {
        let optionConfig = this.props.store.initConfig.optionConfig,
            editOption = this.props.editOption;
        if( editOption && optionConfig[editOption] ){
            let label = optionConfig[editOption].label,
                selector = optionConfig[editOption].selector,
                checkedList = Object.keys(optionConfig[editOption].options);
            this.setState({
                label,
                selector,
                checkedList
            })
        }
    }

    componentWillReceiveProps(nextProps) {
        let optionConfig = nextProps.store.initConfig.optionConfig,
            editOption = nextProps.editOption;
        if( editOption && optionConfig[editOption] ){
            let label = optionConfig[editOption].label,
                selector = optionConfig[editOption].selector,
                checkedList = Object.keys(optionConfig[editOption].options);
            this.setState({
                label,
                selector,
                checkedList
            })
        }
    }
    
    

    modalOkHandler(){

        if( this.props.editOption ){
            this.props.modalOkHandler( this.props.editOption, this.state.label, this.state.selector, this.state.checkedList );
        } else {
            this.props.modalOkHandler( this.state.label, this.state.selector, this.state.checkedList );
        }
        this.setState( {
            label : '',
            selector : '',
            checkedList : []
        } )
    }

    render(){
        let props = this.props,
            checkboxPlainOptions = {
                'font-family'    : 'Font Family',
                'font-variant'   : 'Font Variant',
                'text-transform' : 'Text Transform',
                'font-size'      : 'Font Size',
                'letter-spacing' : 'Letter Spacing',
                'line-height'    : 'Line height',
                'color'          : 'Font Color',
            },
            checkboxes = Object.keys(checkboxPlainOptions).map((item,i)=><Checkbox key={i} value={item}>{checkboxPlainOptions[item]}</Checkbox>);
        return (
            <Modal
            title = {props.title}
            visible = {props.modalVisible}
            mask={true}
            maskClosable={true}
            onCancel = {this.modalCancel.bind(this)}
            footer={[
                <Button key="cancel" onClick={this.modalCancel.bind(this)}>
                  Cancel
                </Button>,
                <Button key="ok" type="primary" disabled={!this.validateInputs.bind(this)()} onClick={this.modalOkHandler.bind(this)}>
                  Ok
                </Button>,
              ]}
        >
            <div className="typehub-custom-option-wrap" >
                <div className="typehub-custom-option-field" >
                    <span style={{width:100, display:'inline-block'}} >Label : </span>
                    <Input style={{width:300}} onChange={(e)=>this.setState({label:e.target.value})} value={this.state.label} />
                </div>
                <div className="typehub-custom-option-field" style={{marginTop:20}} >
                    <span style={{width:100, display:'inline-block'}} >CSS Selector : </span>
                    <Input style={{width:300}} onChange={(e)=>this.setState({selector:e.target.value})} value={this.state.selector} />
                </div>
                <div className="typehub-custom-option-field" style={{marginTop:20}} >
                    <span style={{width:100, display:'inline-block'}} >Fields : </span>
                    <div className="typehub-custom-fields" >
                        <CheckboxGroup
                            value={this.state.checkedList}
                            onChange={(e)=>this.setState({checkedList:e})}
                        >
                            {checkboxes}
                        </CheckboxGroup>
                    </div>
                </div>
            </div>
        </Modal>
        )
    }
}

function mapStateToProps(store, ownProps) {
    return {
        store
    }
}

export default connect(mapStateToProps)(CustomOption);