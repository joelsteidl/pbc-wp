import React, { Component } from 'react';
import { Tabs, Button, message, Icon } from 'antd';
import FontScheme from './components/font-scheme/index';
import acSchemes from './actions/acScheme';
import FontSettings from './components/font-settings';
import helpers from './helper/helpers';
import { connect } from 'react-redux';
import deepEqual from 'deep-equal';
import acTempWorks from './actions/acTempWorks';
import ImportAndExport from './components/import-export';
import './gradient-picker/gradientColorPicker.css';
import FAQ from './components/faq';
import Settings from './components/settings';
import SettingsIcon from './images/settings-icon';
import CustomFonts from  './components/custom-fonts';

const TabPane = Tabs.TabPane;



class App extends Component {

  constructor(props) {
    super(props);
    this.saveStore = this.saveStore.bind(this);
    this.state = {
      key: 1,
      dragEnter: false
    };
    message.config({
      top: 50
    });
    //load typekit fonts if kit id is available
    helpers.deepGet(props.store, ['settings', 'typekitId']) && window.WebFont && window.WebFont.load({ typekit: { id: this.props.store.settings.typekitId } });
    this.tempFlag = false;
  }

  saveStore() {
    this.props.dispatch(acSchemes.sendStore());
  }

  tabChange(key) {
    this.setState({ key });
  }
  componentWillMount() {

    let tempSavedValues = this.props.store.initConfig.savedValues;
    let typekitFontsList = window.typehub_fonts.typekit ? Object.keys(window.typehub_fonts.typekit) : [];
    for (let options of Object.keys(tempSavedValues)) {
      if (tempSavedValues[options]['font-family']) {
        let fontFamilyValue = tempSavedValues[options]['font-family'].split(':');
        if (fontFamilyValue[0] === 'typekit') {
          if (!typekitFontsList.includes(fontFamilyValue[1])) {
            tempSavedValues[options]['font-family'] = 'standard:System Font Stack';
          }
        }
      }
    }
    this.props.dispatch(acTempWorks.saveStore({ savedValues: tempSavedValues, fontSchemes: this.props.store.fontSchemes, settings: this.props.store.settings, custom : this.props.store.custom }));
    this.props.dispatch(acTempWorks.sendLocalFontsNametoStore(window.local_google_fonts));

    document.addEventListener("keydown", function (e) {
      if (e.key == 's' && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
        e.preventDefault();
        if (this.tempFlag) {
          this.saveStore();
        } else {
          message.destroy(); 
          message.warning('No Changes Found');
        }

      }
    }.bind(this), false);

  }

  render() {
    
    let btnStyle = {
      padding: '14px 40px',
      borderRadius: '5px',
      marginTop: 14,
      marginRight: 10,
      color: '#fff',
      lineHeight: 1,
      cursor: 'pointer',
      backgroundColor: '#4AE262'

    };
    if ( !deepEqual(this.props.store.initConfig.savedValues, this.props.store.tempWorks.savedValues)
      || !deepEqual(this.props.store.settings, this.props.store.tempWorks.settings)
      || !deepEqual(this.props.store.fontSchemes, this.props.store.tempWorks.fontSchemes)
      || !deepEqual(this.props.store.custom, this.props.store.tempWorks.custom) ) {

      if (this.state.key !== '3') {
        window.onbeforeunload = function () {
          return "Unsaved changes will be lost if you leave this page, are you sure?";
        };
      }
      btnStyle.opacity = 1;
      this.tempFlag = true;
    } else {
      window.onbeforeunload = null;
      btnStyle.opacity = 0.5;

      this.tempFlag = false;
    }
    return (
      <div className="typehub-body" >


        <Tabs
          style={{ minHeight: '110vh' }}
          defaultActiveKey='1'
          tabBarGutter={0}
          tabBarExtraContent={<div style={{ display: 'flex', alignItems: 'baseline' }} >
            <Settings>
              <span style={{ cursor: 'pointer' }} >
                <SettingsIcon />
              </span>
            </Settings>
            <div
              onClick={this.tempFlag ? this.saveStore : () => { message.destroy(); console.log(this.props.store); return message.warning('No Changes Found') }}
              style={btnStyle} ><span style={{ marginRight: 5 }} > {  this.tempFlag || this.props.store.tempWorks.loader ? 'Save Changes' : 'Saved!'} </span>
              {this.props.store.tempWorks.loader && <Icon style={{ fontSize: 16 }} type="loading" />}
            </div>
          </div>
          }
          onChange={this.tabChange.bind(this)} >

          <TabPane tab={<img height='30px' src={`${window.typehub_server_config.plugin_url}/admin/js/typehub.png`} alt='Logo' />} disabled key='0'></TabPane>
          <TabPane tab='Font Values' key='1'><FontSettings /></TabPane>
          <TabPane tab='Schemes' key='2'><FontScheme /></TabPane>
          <TabPane tab='Import Export' key='3' ><ImportAndExport isActive={this.state.key == '3'} /></TabPane>
          <TabPane tab='Custom Fonts' key='4'><CustomFonts /></TabPane>
          <TabPane tab='FAQs' key='5'><FAQ /></TabPane>
        </Tabs>
      </div>
    );
  }
}

function mapStateToProps(store, ownProps) {
  return {
    store
  }
}

export default connect(mapStateToProps)(App);