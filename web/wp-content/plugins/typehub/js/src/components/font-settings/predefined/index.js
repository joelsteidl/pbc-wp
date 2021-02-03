import React from 'react';
import Options from './options';
import Field from './fields'
import { connect } from 'react-redux';
import helper from '../../../helper/helpers';
import FontPreview from './font-preview';
import deepEqual from 'deep-equal';


class FontSettings extends React.Component {

    constructor(props) {
        super();
        var categories = [];
        for (let option of Object.keys(props.store.initConfig.optionConfig)) {
            !categories.includes(props.store.initConfig.optionConfig[option].category) && categories.push(props.store.initConfig.optionConfig[option].category);
        }
        this.state = {
            clickedOption: 'h1',
            selectedCategory: [],
            checkedItems: [],
            masterCheckBox: false,
            availableItem: [],
            searchTxt: '',
            listItems: [],
            indeterminent: false,
            categories: categories,
            availableFields: [],
            filterredFields: [],
            filterSwitch: false,
            showResponsiveControls: false,
            selectedDevice : 'desktop'

        };
        this.optionItemClicker = this.optionItemClicker.bind(this);
        this.dropDownClickListener = this.dropDownClickListener.bind(this);
        this.eachCheckBoxChange = this.eachCheckBoxChange.bind(this);
        this.AllCheckListener = this.AllCheckListener.bind(this);
        this.changeListener = this.changeListener.bind(this);
        this.listRender = this.listRender.bind(this);
        this.masterCheckUpdater = this.masterCheckUpdater.bind(this);
        this.fieldFilterChange = this.fieldFilterChange.bind(this);
        this.responsiveFilterChange = this.responsiveFilterChange.bind(this);
        this.clearFilters = this.clearFilters.bind(this);
        this.getSelectedDevice = this.getSelectedDevice.bind(this);
    }

    clearFilters() {
        this.setState({
            filterSwitch: false,
            filterredFields: [],
            selectedCategory: [],
            checkedItems: [],
            clickedOption: '',
            searchTxt: '',
            filterSwitch:false,
            showResponsiveControls:false,
            masterCheckBox: false,
            indeterminent: false
        }, () => this.listRender());
    }

    responsiveFilterChange(e) {
        this.setState({
            filterSwitch: e,
            checkedItems: [],
            clickedOption: '',
            masterCheckBox: false,
            indeterminent: false
        }, () => this.listRender());
    }

    fieldFilterChange(e) {


        var selectedList = {}, availableFields = [];
        
        let configItems = this.props.store.initConfig.optionConfig;
        let fieldConfig = this.props.store.initConfig.fieldConfig;

        for (var eachKey of Object.keys(configItems)) {
            let c = 0;
            let categoryTempFlag = true;
            if (this.state.selectedCategory.length) {
                if (!this.state.selectedCategory.includes(configItems[eachKey].category)) {
                    categoryTempFlag = false;
                }
            }

            if (categoryTempFlag) {
               
                for (let temp of Object.keys(configItems[eachKey].options)) {
                    let keyResponsive;
                    if (configItems[eachKey].options[temp].responsive === undefined) {
                        keyResponsive = fieldConfig[temp] ? fieldConfig[temp].responsive : false ;
                    } else {
                        keyResponsive = configItems[eachKey].options[temp].responsive;
                    }
                    if (responsiveFilterHelper(this.state.filterSwitch, keyResponsive)) {

                        let flag = false;

                       
                        if (e.length) {
                            for (let tempItem of e) {
                                if (tempItem === temp && keyResponsive) {
                                    c++;
                                }
                            }
                            
                            if (c === e.length) {
                                flag = true;
                            }
                        }

                        if ((!e.length || helper.arrayContainArray(Object.keys(configItems[eachKey].options), e)) && flag) {

                            selectedList = Object.assign({}, selectedList, { [eachKey]: configItems[eachKey] });
                        
                        }
                        if(Object.keys(selectedList).length){
                            this.setState({showResponsiveControls:true})
                        }else{
                            this.setState({showResponsiveControls:false,filterSwitch:false});
                        }
                    }
                }
            }
        }


        this.setState({
            filterredFields: e,
            checkedItems: [],
            clickedOption:'',
            masterCheckBox: false,
            indeterminent: false
        }, () => this.listRender());
    }

    changeListener(e) {
        this.setState({ searchTxt: e.target.value }, () => this.listRender());
    }

    eachCheckBoxChange(item) {

        if (this.state.checkedItems.includes(item)) {
            let tempArray = helper.removeElementFromArray(this.state.checkedItems, item);
            this.setState({
                checkedItems: tempArray,
                clickedOption: ''
            }, () => this.masterCheckUpdater());
        } else {
            this.setState({
                checkedItems: [...this.state.checkedItems, item],
                clickedOption: ''
            }, () => this.masterCheckUpdater());
        }
    }

    AllCheckListener(e) {
        if (this.state.indeterminent) {

            this.setState({
                masterCheckBox: false,
                checkedItems: [],
                clickedOption: ''
            }, () => this.masterCheckUpdater());

        } else {
            if (e.target.checked) {
                this.setState({
                    masterCheckBox: true,
                    checkedItems: this.state.availableItem,
                    clickedOption: ''
                });
            } else {
                this.setState({
                    masterCheckBox: false,
                    checkedItems: [],
                    clickedOption: ''
                });
            }
        }

    }

    listRender() {
        var selectedList = {}, availableFields = [];
        let configItems = this.props.store.initConfig.optionConfig;
        let fieldConfig = this.props.store.initConfig.fieldConfig;


        for (var eachKey of Object.keys(configItems)) {

            let categoryTempFlag = true;
            if (this.state.selectedCategory.length) {
                if (!this.state.selectedCategory.includes(configItems[eachKey].category)) {
                    categoryTempFlag = false;
                }
            }

            if (categoryTempFlag) {
                let c = 0;
                for (let temp of Object.keys(configItems[eachKey].options)) {
                    let keyResponsive;
                    if (configItems[eachKey].options[temp].responsive === undefined) {
                        keyResponsive = fieldConfig[temp] && fieldConfig[temp].responsive;
                    } else {
                        keyResponsive = configItems[eachKey].options[temp].responsive;
                    }
                    if (responsiveFilterHelper(this.state.filterSwitch, keyResponsive)) {

                        let flag = true;

                        if (this.state.filterSwitch && this.state.filterredFields.length) {

                            for (let tempItem of this.state.filterredFields) {
                                if (tempItem === temp && keyResponsive) {
                                    c++;
                                }
                            }

                            if (c !== this.state.filterredFields.length) {
                                flag = false;
                            }
                        }

                        if ((!this.state.filterredFields.length ||
                            helper.arrayContainArray(Object.keys(configItems[eachKey].options), this.state.filterredFields)) && flag) {
                            selectedList = Object.assign({}, selectedList, { [eachKey]: configItems[eachKey] });

                            !arrayIncludesItemHelper(availableFields, temp) && availableFields.push({ key: temp, label: fieldConfig[temp] ? fieldConfig[temp].label : 'null' });
                        }
                    }
                }
            }
        }
        this.setState({
            listItems: selectedList,
            availableFields: availableFields
        });
        let optionListArr = Object.keys(selectedList);

        const filteredArray = optionListArr.filter(item => selectedList[item].label.toLowerCase().includes(this.state.searchTxt.toLowerCase()));
        let tempArray = [];
        for (let item of filteredArray) {
            tempArray.push(item);
        }

        this.setState({ availableItem: tempArray });
    }

    optionItemClicker(clickedItem, e) {
        if (e.target.nodeName === 'DIV') {
            if (!this.state.checkedItems.length) {
                let temp = clickedItem;
                this.setState({ clickedOption: temp });
            } else {
                this.eachCheckBoxChange(clickedItem);
            }
        }
    }

    masterCheckUpdater() {
        if (this.state.availableItem.length === this.state.checkedItems.length) {
            this.setState({ masterCheckBox: true, indeterminent: false });
        } else if (this.state.checkedItems.length &&
            this.state.checkedItems.length < this.state.availableItem.length) {
            this.setState({
                masterCheckBox: false,
                indeterminent: true
            });
        } else {
            this.setState({ masterCheckBox: false, indeterminent: false });
        }
    }

    dropDownClickListener(e) {

        this.setState({
            selectedCategory: e,
            checkedItems: [],
            clickedOption:'',
            masterCheckBox: false
        }, () => this.listRender());

    }

    componentWillMount() {
        this.listRender();
    }

    componentDidUpdate(prevProps, prevState) {
        
        let oldConfigLength = Object.keys(prevProps.store.initConfig.optionConfig).length,
            newConfigLength = Object.keys(this.props.store.initConfig.optionConfig).length,
            isCustomChanged = !deepEqual( this.props.store.custom, prevProps.store.custom );
    
        if( oldConfigLength < newConfigLength || isCustomChanged){
            this.listRender();   
        }
    }
    

    componentWillReceiveProps(nextProps, prevState) {

        let newConfigLength = Object.keys(nextProps.store.initConfig.optionConfig).length,
            oldConfigLength  = Object.keys(this.props.store.initConfig.optionConfig).length,
            isCustomChanged = !deepEqual( this.props.store.custom, nextProps.store.custom );
        
        if( oldConfigLength > newConfigLength ) {
            this.setState({
                checkedItems: [],
                clickedOption:'',
                masterCheckBox: false,
                indeterminent: false
            }, () => this.listRender());
        } else if( oldConfigLength < newConfigLength || isCustomChanged ){
            this.listRender();   
        }
    }

    getSelectedDevice( display ){
        this.setState({
            selectedDevice : display
        })
    }

    render() {
        return (
            <div style={{display:'flex',marginTop:20,alignItems:'flex-start'}} >
                <Options clickedOption={this.state.clickedOption}
                    optionItemClick={this.optionItemClicker}
                    selectedCategory={this.state.selectedCategory}
                    searchTxt={this.state.searchTxt}
                    searchTxtChangeListener={this.changeListener}
                    selectedList={this.state.listItems}
                    checkBoxThings={{
                        anythingChecked: !!this.state.checkedItems.length,
                        eachCheckBoxFn: this.eachCheckBoxChange,
                        checkedItemsArray: this.state.checkedItems,
                        AllCheckListener: this.AllCheckListener,
                        masterCheckBox: this.state.masterCheckBox,
                        availableItem: this.state.availableItem,
                        indeterminent: this.state.indeterminent
                    }}
                    filterProps={{
                        categories: this.state.categories,
                        selectedCategories: this.state.selectedCategory,
                        checkboxClickFn: this.dropDownClickListener,
                        availableFields: this.state.availableFields,
                        filterredFields: this.state.filterredFields,
                        fieldFilterChange: this.fieldFilterChange,
                        selectedCategory: this.state.selectedCategory,
                        responsiveFilterChange: this.responsiveFilterChange,
                        filterSwitch: this.state.filterSwitch,
                        responsiveFilterVisiblity:this.state.showResponsiveControls,
                        clearFiltersFn: this.clearFilters
                    }}
                />
                {
                    (this.state.checkedItems.length > 0 || this.state.clickedOption !== '') &&
                    <div className="typehub-settings-right-wrap" >
                    <Field
                        filterSwitch={this.state.filterSwitch}
                        filterredFields={this.state.filterredFields}
                        getSelectedDevice = {this.getSelectedDevice}
                        checkedItemArray={this.state.checkedItems.length > 0 ? this.state.checkedItems : [this.state.clickedOption]} />
            
                    <FontPreview 
                        clickedOption = {this.state.clickedOption}
                        selectedDevice = {this.state.selectedDevice}
                    />
                    </div>
                }
            </div>
        )
    }

}

function mapStateToProps(store, ownProps) {
    return {
        store
    }
}



export default connect(mapStateToProps)(FontSettings);

function arrayIncludesItemHelper(arr, element) {
    for (var item of arr) {
        if (item.key === element) {
            return true;
        }
    }
}

function responsiveFilterHelper(switchState, keyResponsive) {
    if (switchState) {
        if (keyResponsive) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}