import React from 'react';
import { Checkbox,Icon,Tooltip, Popconfirm } from 'antd';
import { connect } from 'react-redux';
import LightBox from 'react-image-lightbox';
import custom from '../../../../actions/acCustom';
import CustomOption from './custom-option';

class ListOptions extends React.Component {
    constructor(props){
        super(props);
        this.state = {
            hoveredItem:null,
            clickedImage:null,
            modalVisible : false,
            editOption : ''
        }
        this.mouseLeave = this.mouseLeave.bind(this);
    }
    mouseEnter(e){
        this.setState({hoveredItem:e});
    }
    mouseLeave(){
        this.setState({hoveredItem:null});
    }

    modalOkHandler( uid, label, selector, checkedList ){
        this.props.dispatch( custom.editCustomOption( {uid,label, selector, checkedList} ) );
        this.setState({modalVisible:false});
    }

    modalCancel(){
        this.setState({modalVisible:false, editOption : ''})
    }

    infoClick(item,label){
        if(this.props.store.initConfig.optionConfig[item].img){

        }
    }
    showModal(option){
        this.setState({
            modalVisible : true,
            editOption : option
        });
    }

    deleteCustomOption( key ){
        this.props.dispatch( custom.removeCustomOption(key) );
    }

    render() {


        let listContent = this.props.checkBoxThings.availableItem.map((item)=> {
            if( !this.props.store.initConfig.optionConfig[item] ){
                return
            }
            this.props.clickedOption === item ? 
            itemBG = { position:'relative', background: '#e3e3e3', marginBottom:1,color: '#313233', cursor: 'pointer', fontWeight: 600, padding: 10,paddingLeft:20, } :
            itemBG = { position:'relative', background: '#fff',marginBottom:1, cursor: 'pointer', padding: 10,paddingLeft:20 }

            if(item === this.state.hoveredItem){
                itemBG = Object.assign({},itemBG,{background:'#eee'});
            }

            var checkBoxValue;
            if(this.props.checkBoxThings.checkedItemsArray.includes(item)){
                checkBoxValue = true;
            }else{
                checkBoxValue = false;
            }
        return <div 
        onClick={this.props.clicked.bind(this,item)} 
        key={item}
        onMouseEnter={this.mouseEnter.bind(this,item)} 
        onMouseLeave={this.mouseLeave}
        style={itemBG} >
        { !!this.props.filterThings.filterredFields.length ? (this.props.checkBoxThings.anythingChecked || this.state.hoveredItem === item) ?
         <Checkbox style={{marginRight:10}}
                checked = { checkBoxValue }
                onChange = { this.props.checkBoxThings.eachCheckBoxFn.bind(this,item) } /> : 
                <span style={{height:16,width:16,marginRight:10,display:'inline-block'}} ></span> :'' }
        {this.props.selectedList[item].label}

        {   item === this.state.hoveredItem &&
                (this.props.store.initConfig.optionConfig[item].desc ?
                <Tooltip trigger='click' title={this.props.store.initConfig.optionConfig[item].desc}>
                    <Icon style={{position:'absolute',fontWeight:400,right:20,top:14,color:'unset'}} type="question-circle-o" />
                </Tooltip> :
                
                this.props.store.initConfig.optionConfig[item].img &&  
                <Icon onClick={()=>this.setState({clickedImage:this.props.store.initConfig.optionConfig[item].img})} style={{position:'absolute',fontWeight:400,right:20,top:14,color:'unset'}} type="question-circle-o" /> )

        }
        {
            (
                item === this.state.hoveredItem && this.props.store.initConfig.optionConfig[item].category === 'Custom' && 
                [
                <Icon style={{position:'absolute',right:50,top:14,color:'#1890ff'}} type="edit" onClick={this.showModal.bind(this, item)} />,
                <Popconfirm trigger='click' placement='top' title='Are you sure?' onConfirm={this.deleteCustomOption.bind(this,item)}  >
                    <Icon style={{position:'absolute',right:20,top:14,color:'red'}} type="delete"  />
                </Popconfirm>]
            )
        }
        </div>});

        let itemBG = {};
        return (<div style={{height:'calc(100vh - 200px)',overflow:'auto'}} >

            {listContent}

            {this.state.clickedImage &&

                <LightBox 
                    mainSrc={this.state.clickedImage}
                    enableZoom={false}
                    style={{top:32}}
                    onCloseRequest={() => this.setState({ clickedImage: null })}
                />
            }
            <CustomOption 
                    modalVisible = {this.state.modalVisible}
                    cancelHandler = {this.modalCancel.bind(this)}
                    title = {'Edit Custom Option'}
                    editOption = {this.state.editOption}
                    modalOkHandler = {this.modalOkHandler.bind(this)}

                />
        </div>
        );
    }
}

function mapStateToProps(store, ownProps) {
    return {
        store
    }
}

export default connect(mapStateToProps)(ListOptions);