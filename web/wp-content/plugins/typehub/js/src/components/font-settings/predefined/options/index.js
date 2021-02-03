import React from 'react';
import { Icon, Input, Checkbox, Modal, Popover, Button } from 'antd';
import { connect } from 'react-redux';
import ListOptions from './ListOptions';
import Filter from './filter';
import Fi from './filter-icon';
import custom from '../../../../actions/acCustom';
import CustomOption from './custom-option';

class Options extends React.Component {

    constructor(props){
        super(props);
        this.state = {
            modalVisible : false,
            label:'',
            selector:''
        }
    }

    mouseEnterAnimation(e) {
        e.target.childNodes[0].classList.add('firstChild');
        e.target.childNodes[1].classList.add('secondChild');
    }

    mouseLeaveAnimation(e) {
        e.target.childNodes[0].classList.remove('firstChild');
        e.target.childNodes[1].classList.remove('secondChild');
    }

    modalCancel(){
        this.setState({modalVisible:false})
    }

    modalOkHandler( label, selector, checkedList ){
        
        this.props.dispatch( custom.addCustomOption({label, selector, checkedList}) );
        this.setState({modalVisible:false})
    }

    render() {

        let categories = ['All'];
        let searchBarWidth='85%';
        if(!!this.props.filterProps.filterredFields.length){
            searchBarWidth='81%';
        }
        for (let option of Object.keys(this.props.store.initConfig.optionConfig)) {
            !categories.includes(this.props.store.initConfig.optionConfig[option].category) && categories.push(this.props.store.initConfig.optionConfig[option].category);
        }

        return (
            <div style={{ minWidth: 370, marginLeft: 40 }} >
                <div style={{ background: '#fff', marginBottom: 1, padding:'15px 10px' }} >
                    {!!this.props.filterProps.filterredFields.length ?
                        <Checkbox style={{ marginTop: 14, marginLeft: 10, float: 'left' }} indeterminate={this.props.checkBoxThings.indeterminent} checked={this.props.checkBoxThings.masterCheckBox} onChange={this.props.checkBoxThings.AllCheckListener} /> :
                        ''}

                    <Input style={{ padding: 10, width: searchBarWidth, float: 'left' }} suffix={<Icon type="search" style={{ color: 'rgba(0,0,0,.25)', paddingRight: 10 }} />} placeholder="Search" onChange={this.props.searchTxtChangeListener} />
                    
                    <div style={{ height: 24, width: 24, marginTop: 14, marginRight: 14, float: 'right', position: 'relative' }} >

                        {this.props.filterProps.selectedCategories.length !== 0 || this.props.filterProps.filterredFields.length !== 0 || this.props.filterProps.filterSwitch ?
                            <div
                                style={{ backgroundColor: '#ee6b6b', height: 16, width: 16, borderRadius: 25, position: 'absolute', color: '#fff',zIndex:3 ,right: -7, top: -8, cursor: 'pointer' }}
                                onClick={this.props.filterProps.clearFiltersFn}
                                onMouseEnter={this.mouseEnterAnimation}
                                onMouseLeave={this.mouseLeaveAnimation}
                            >
                                <div style={{ height: 1.2, width: 10, position: 'absolute', left: 3, top: 8, backgroundColor: '#fff' }} ></div>
                                <div style={{ height: 1.2, width: 10, position: 'absolute', left: 3, top: 8, backgroundColor: '#fff' }} ></div>
                            </div> : ''}

                        <Popover trigger={'click'} placement='rightTop' content={<Filter filterProps={this.props.filterProps} />} >

                            <span style={{ cursor: 'pointer',display:'inline-block',height:24,width:24 }} >
                                <Fi />
                            </span>
                            
                            <div style={{position:'absolute',top:17,fontSize:10,color:'#aaa',cursor:'pointer'}} >Filter</div>

                        </Popover>
                    </div >
                    <div style={{clear:'both'}} ></div>
                </div>
                <div  >
                    <ListOptions
                        clickedOption={this.props.clickedOption}
                        clicked={this.props.optionItemClick}
                        text={this.props.searchTxt}
                        selectedList={this.props.selectedList}
                        checkBoxThings={this.props.checkBoxThings}
                        filterThings={this.props.filterProps}
                    />
                </div>
                <div className="typehub-add-new-option" onClick={()=> this.setState({modalVisible:true}) } > Add New Option </div>
                <CustomOption 
                    modalVisible = {this.state.modalVisible}
                    cancelHandler = {this.modalCancel.bind(this)}
                    title = {'Add Custom Option'}
                    modalOkHandler = {this.modalOkHandler.bind(this)}

                />
            </div>
        )
    }
}

function mapStateToProps(store, ownProps) {
    return {
        store
    }
}

export default connect(mapStateToProps)(Options);