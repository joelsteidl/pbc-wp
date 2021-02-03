import React from 'react';
import { Upload, Icon, Button, Popconfirm, message, Alert } from 'antd';
import custom from '../../actions/acCustom';
import { connect } from 'react-redux';
import helpers from '../../helper/helpers';
import WebfontGenerator from './WebfontGenerator';

const Dragger = Upload.Dragger;

class CustomFont extends React.Component{

    constructor(props){
        super(props);
        this.customDragEntered = false;
        this.state = {
            file :'',
            text: "Click on this area or drag and drop a file to upload",
            fileAdded : false,
            fileLoading : false
        }
    }

    UploadFn(e){
        if( this.state.fileLoading ){
            message.info('Loading file. Please wait!');
            return;
        }
        if( this.state.fileAdded ){
            this.props.dispatch( custom.addNewFont( {file: this.state.file} ) );
            this.setState({file : '', fileAdded: false, text:"Click on this area or drag and drop a file to upload"});
        } else {
            message.warn('Please select a zip file to upload');
        }
    }

    upldChange(e){
        if( e.file.status === 'uploading' ){
            this.setState({fileLoading : true});
        } else if(e.file.status === 'done'){
            var f = e.file.originFileObj;
            this.setState( {file:f,text:f.name, fileLoading : false, fileAdded : true } );
        }
    }

    deleteCustomFont( name ){
        this.props.dispatch( custom.removeCustomFont( name ) );
    }

    render(){
        let customFontList,
            fontUploading = this.props.store.tempWorks.anyProcess.customFontUpload;

        if( window.typehub_fonts.custom ){
            let customFonts = window.typehub_fonts.custom,
                customFontKeys = Object.keys( customFonts ),
                addedViaTypehub = [];

            if( helpers.deepGet( this.props.store, ['custom','fonts'] ) ){
                addedViaTypehub = Object.keys(this.props.store.custom.fonts);
            }

            customFontList = customFontKeys.map(function( item,i ){
                return <div key={i} className="typehub-custom-font-list" > {item} {addedViaTypehub.indexOf( item ) !== -1 ? <Popconfirm trigger='click' placement='top' title='Are you sure?' onConfirm={this.deleteCustomFont.bind(this,item)}  ><Icon style={{color:'red', position:'absolute', right:10, top:10, cursor:'pointer'}} type="delete" /></Popconfirm> : ''}</div>
            }.bind(this));

        } else {
            customFontList = <div className="typehub-custom-fonts-not-added" >
                Sorry! You don't have any custom fonts yet.
                </div>;
        }
            return (
                <div>
                <Alert 
                    style={{margin: '0 40px'}}
                    message={<div>NOTE: Upload your font's TTF or OTF file to generate the webfont kit. Download the package and upload downloaded package (webfont kit) below to start using your font in typehub.</div>}
                    type='info' />
                
                <div className="typehub-custom-font-wrap" >
                    <div className="typehub-custom-font-left" >
                        {customFontList}
                    </div>
                    <div className="typehub-custom-font-right" >
                        <WebfontGenerator />
                        <div style={{background: '#fff',padding:15}}>
                        <h3><strong>Step 2.</strong> Upload webfont kit</h3>
                        <Dragger onChange={this.upldChange.bind(this)} disabled={this.state.fileAdded} accept='.zip' multiple={false} onRemove={()=> this.setState({fileAdded: false, text: "Click on this area or drag and drop a file to upload"})}
                        showUploadList = {false}>

                            <div style={{height:175, width: '100%',display:'flex',flexDirection:'column', cursor: 'pointer'}} onClick={this.state.fileAdded ? (e)=>{this.setState({fileAdded : false, file: '',text: "Click on this area or drag and drop a file to upload"}); e.stopPropagation();}: ()=>{} } >
                                <div style={{position:'absolute',top:'30%',left:'50%',marginLeft:-10, height: "20px", width: "20px", cursor: 'pointer'}} >
                                    <Icon type={ fontUploading || this.state.fileLoading ? "loading" : "plus"} className={ "upload-icon " + (this.state.fileAdded ? "file-added" : "")} style={{color: !this.state.fileAdded?"#1890FF":"red", fontSize: '25px'}}/>
                                </div>
                                <span style={{fontSize: "13px",position:'absolute',top: '50%',left: '50%', transform: 'translate(-50%)'}} >{this.state.text} </span>
                            </div>

                        </Dragger>
                        <p>Upload webfont kit here to start using your font in typehub.</p>
                        <Button style={{marginTop: 10}} disabled={fontUploading} type="primary" onClick={this.UploadFn.bind(this)} >Upload</Button>
                        </div>
                    </div>
                </div>
                </div>
            )
    }
}

function mapStateToProps(store, ownProps) {
    return {
      store
    }
  }
  
  export default connect(mapStateToProps)(CustomFont);