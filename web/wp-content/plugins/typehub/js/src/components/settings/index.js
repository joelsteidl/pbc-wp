import React from 'react';
import { Input, Icon, Popover, Modal, notification, Switch } from 'antd';
import { connect } from 'react-redux';
import helpers from '../../helper/helpers';
import settings from '../../actions/acSettings';
import acSettings from '../../actions/acSettings';
import acTempWorks from '../../actions/acTempWorks';
import deepEqual from 'deep-equal';

class Settings extends React.Component {

    constructor(props) {
        super(props);
        this.state = { 
            deletionModalVisibility: false, 
            localFontsSwitch: false, 
            kitIdState: { icon: 'check-circle-o', color: 'blue' }, 
            kitIdValue: (helpers.deepGet(this.props.store, ['settings', 'typekitId']) && props.store.settings.typekitId) || '',
            typekitSyncing : false
        }
    }

    syncTypekitFonts(){
        this.setState( {typekitSyncing : true} );
        if( helpers.deepGet(this.props.store, ['settings', 'typekitId']) ){
            jQuery.ajax({
                url:window.ajaxurl,
                data:{
                    action: 'sync_typekit',
                    security: window.typehubAjax.nonce,
                    typekitId: this.props.store.settings.typekitId,
                },
                type:'POST',
            }).done((data)=>{
                if( data ){
                    this.props.dispatch(settings.saveSettings({ typekitId: this.props.store.settings.typekitId }));
                }
                this.setState( {typekitSyncing : false} );
            } ).fail((data)=>{
                console.log( 'failed to sync Typekit Fonts',data );
                this.syncing = false;
            });
        } else {

        }

    }

    saveKitId() {
        let value = this.state.kitIdValue;
        this.setState({
            kitIdValue: value,
            kitIdState: { icon: 'loading', color: '#000' }
        });
        if (value !== '') {
            jQuery.ajax({
                url:window.ajaxurl,
                data:{
                    action: 'load_typekit_fonts',
                    security: window.typehubAjax.nonce,
                    typekitId:value,
                },
                type:'POST',
            })
                .done((data) => {
                    if (data !== 'false' ) {
                        this.setState({ kitIdState: { icon: 'check-circle-o', color: 'blue' } });
                        this.props.dispatch(settings.saveSettings({ typekitId: value }));
                        notification.success({
                            message: 'Success',
                            description: "Fonts from your Typekit Kit are now available for selection.",
                            placement: 'bottomRight'
                        });
                    } else {
                        this.setState({ kitIdState: { icon: 'close-circle-o', color: 'red' } });
                        notification.error({
                            message: 'Incorrect Typekit ID',
                            description: "You have entered an invalid Typekit Id",
                            placement: 'bottomRight'
                        });
                    }
                })
                .fail((data) => console.log('fail', data));
        }
    }

    deleteKitId() {
        this.setState({ deletionModalVisibility: false, kitIdValue: '' });
        this.props.dispatch(settings.deleteTypekit());
    }

    localFontSwitch(e) {
        this.props.dispatch(acSettings.loadFromLocalSwitch(e));

    }

    render() {

        var googleFontsUsed = helpers.getUsedGoogleFonts(this.props.store.initConfig.savedValues, this.props.store.fontSchemes),
            downloadedFonts = this.props.store.tempWorks.localFonts,
            fontsToBeDownloaded = helpers.removeContentsOfArray(googleFontsUsed, downloadedFonts) || [],
            progressRemainingFonts = this.props.store.tempWorks.progress.length || 0;

        var stateChange = (!deepEqual(this.props.store.fontSchemes, this.props.store.tempWorks.fontSchemes)
            || !deepEqual(this.props.store.initConfig.savedValues, this.props.store.tempWorks.savedValues)
            || !deepEqual(this.props.store.settings, this.props.store.tempWorks.settings));

        return (
            <div>
                <Popover
                    trigger='click'
                    placement='bottom'
                    content={
                        <div>
                            <div style={{display:'flex',alignItems:'center'}} >
                                <div style={{fontWeight:500,}} >Typekit ID:</div> <div style={{marginLeft:20}} >{!helpers.deepGet(this.props.store, ['settings', 'typekitId']) ? <Input onChange={(e) => this.setState({ kitIdValue: e.target.value, kitIdState: { icon: 'check-circle-o', color: 'blue' } })} value={this.state.kitIdValue} style={{ marginLeft: 5, width: 180 }} /> : <span>{this.props.store.settings.typekitId}</span>}
                                {!helpers.deepGet(this.props.store, ['settings', 'typekitId']) ?
                                    <Icon onClick={this.saveKitId.bind(this)} style={{ marginLeft: 10, color: this.state.kitIdState.color, cursor: 'pointer' }} type={this.state.kitIdState.icon} /> :
                                    <span>
                                    <Icon onClick={this.syncTypekitFonts.bind(this)} className={ this.state.typekitSyncing ? 'rotating' : '' } style={{ marginLeft: 10, color: 'grey', cursor: 'pointer' }} type='sync' />
                                    <Icon onClick={() => this.setState({ deletionModalVisibility: true })} style={{ marginLeft: 10, color: 'red', cursor: 'pointer' }} type='delete' />
                                    </span>
                                }</div>
                            </div>
                            <div style={{ paddingTop: 20, display: 'flex', alignItems: 'center', justifyContent: 'space-between' }} >
                                <div style={{ display: 'inline-block' }} > <div style={{fontWeight:500}}  >Download Google Fonts to your server</div> <div style={{ fontSize:12 }} > ( for GDPR compliance )</div> </div>
                                <div style={{ display: 'inline-block', marginRight: 7,marginLeft:20 }} >
                                    {this.props.store.tempWorks.onGoing ?
                                        <div style={{position:'relative',display:'flex'}} >
                                            <svg xmlns="http://www.w3.org/2000/svg" className="rotating" width="32" height="32" viewBox="0 0 32 32">
                                                <g fill="none" fillRule="evenodd" transform="translate(1 1)">
                                                    <circle cx="15" cy="15" r="15" stroke="#DBDBDB" />
                                                    <path stroke="#3B99FC" strokeWidth="2" d="M14.5356518,0.518474122 C23.2378894,0.406444828 30.3170617,7.30455186 29.3605773,16.9784179" />
                                                </g>
                                            </svg>
                                            <span style={{position:'absolute',left:'50%',top:'50%',fontSize:11,transform:'translate(-50%,-50%)'}} >{fontsToBeDownloaded.length - progressRemainingFonts + '/' + fontsToBeDownloaded.length} </span>
                                        </div>
                                        : fontsToBeDownloaded.length ? <div style={{ height: 30, width: 30, cursor: 'pointer' }}
                                            onMouseEnter={stateChange ? () =>
                                                notification.error({
                                                    message: 'Cannot Download Now',
                                                    description: "Please save your settings to download fonts",
                                                    placement: 'bottomRight'
                                                }) : () => ''}
                                            onMouseLeave={() => notification.destroy()}
                                            onClick={!stateChange ? () => this.props.dispatch(acTempWorks.downloadFont(fontsToBeDownloaded)) : () => ''} >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                                <g fill="none" transform="translate(1 1)">
                                                    <circle cx="15" cy="15" r="15" stroke={!stateChange ? '#3B99FC' : '#e3e3e3'} />
                                                    <g fill={!stateChange ? '#3B99FC' : '#e3e3e3'} transform="translate(9 8)">
                                                        <polygon points="4.571 0 8.429 0 8.429 6.316 11 6.316 6.5 12 2 6.316 4.571 6.354" />
                                                        <rect width="13" height="1" y="14" rx=".5" />
                                                    </g>
                                                </g>
                                            </svg>
                                        </div> :
                                            <div style={{ width: 30, height: 30 }} >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                                    <g fill="none" fillRule="evenodd" stroke="#1FD03F" transform="translate(1 1)">
                                                        <circle cx="15" cy="15" r="15" />
                                                        <polyline points="10 14.801 12.297 18.058 20.639 13" transform="rotate(-15 15.32 15.529)" />
                                                    </g>
                                                </svg>
                                            </div>}
                                </div>
                            </div>
                            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', paddingTop: 20 }} >
                                <div  > <div style={{fontWeight:500}} >Load Google Fonts from your server</div> <div style={{fontSize:12}} > ( for GDPR compliance ) </div></div>
                                <div style={{marginLeft:20}} > <Switch checked={this.props.store.settings.loadFromLocal} onChange={this.localFontSwitch.bind(this)} /> </div>
                            </div>
                        </div>
                    } >
                    {this.props.children}
                </Popover>
                <Modal
                    title="Are You Sure ?"
                    visible={this.state.deletionModalVisibility}
                    onOk={this.deleteKitId.bind(this)}
                    onCancel={() => this.setState({ deletionModalVisibility: false })}
                >
                    <p> All the options you have set to a typekit font will be replaced with "System Font Stack" and this cannot be undone</p>
                </Modal>
            </div>
        )
    }
}

function mapStateToProps(store, ownProps) {
    return {
        store
    }
}
export default connect(mapStateToProps)(Settings);