import React from 'react';
import {Button,Upload,message, notification, Icon} from 'antd';
import {connect} from 'react-redux';
import helper from '../../helper/helpers.js';
import clonedeep from 'clone-deep';
import initConfig from '../../actions/settingsInitAction';
import acScheme from '../../actions/acScheme';
import acCustom from '../../actions/acCustom';
import acSettings from '../../actions/acSettings';


const Dragger = Upload.Dragger;

class ImportAndExport extends React.Component{

    
    constructor(props){
        super(props);
        this.customDragEntered = false;
        this.state = { 
            uploadFile: true, 
            importButton: false,
            text: "Click on this area or drag and drop a file to upload"
        }
        this.onDrop = this.onDrop.bind(this);
        this.exportFn = this.exportFn.bind(this);
        this.importFn = this.importFn.bind(this);
        this.dd = this.dd.bind(this);
        notification.config({
            top:30
        })
    }

    componentWillReceiveProps(nextProps){
        this.setState({content: nextProps.content})
    }

    componentDidMount() {
        var header = document.getElementById("typehub-header"),
            dragEntered = false,
            body = document.body,
            dropped = false;
        document.ondragenter = (e) => {
          let ele = document.getElementsByClassName( 'be-typehub-import-export' )[0];
          if( this.props.isActive && !this.customDragEntered && null != ele && !body.classList.contains( 'be-typehub-show-dropzone' ) ) {
             body.classList.add( 'be-typehub-show-dropzone' );
             this.customDragEntered = true;
          }
        }
    
        document.ondragleave = (e) => {
          if( this.customDragEntered && null != e.target && e.target.classList.contains( 'be-typehub-dropzone' ) ) {
            this.customDragEntered = false;
            body.classList.remove( 'be-typehub-show-dropzone' );
          }
        }
      }

    dd(ev){
        // Prevent default behavior (Prevent file from being opened)
        ev.preventDefault();
        if (ev.dataTransfer.items ) {
            // Use DataTransferItemList interface to access the file(s)
            // If dropped items aren't files, reject them
            if (ev.dataTransfer.items[0].type === 'application/json' && ev.dataTransfer.items[0].kind === 'file') {
                var file = ev.dataTransfer.items[0].getAsFile();
                var f = ev.dataTransfer.files[0];
                var reader = new FileReader();
                reader.onloadend = function(e){
                    this.setState({content:JSON.parse(e.target.result), uploadFile: false, text: f.name});
                    document.body.classList.remove( 'be-typehub-show-dropzone' );
                    this.customDragEntered = false;
                }.bind(this)
                reader.readAsBinaryString(f);
            }else{
                message.error('Uploaded file is not a .json file');
                document.body.classList.remove( 'be-typehub-show-dropzone' );
                this.customDragEntered = false;
            }
        }
    }

    exportFn(){

        let tempSavedValues = helper.postProcessSavedValues(this.props.store.initConfig.savedValues,this.props.store.initConfig.fieldConfig);

        let data = {meta:'typehub-data',savedValues:tempSavedValues,fontSchemes:this.props.store.fontSchemes,settings:this.props.store.settings,custom:this.props.store.custom};
    


        let dataStr = JSON.stringify(data);
        let dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
        
        let timeStamp = timenow();

        let exportFileDefaultName = `typehub_${timeStamp}.json`;
        let linkElement = document.createElement('a');
        linkElement.setAttribute('href', dataUri);
        linkElement.setAttribute('download', exportFileDefaultName);
        linkElement.click();    
    }

    onDrop(e){
        if(this.state.uploadFile){ 
            var f = e.file.originFileObj;
            var fileName = e.file.name;
            if(e.file.status === 'uploading'){
                this.setState({loadingVisible: true});
            }
            if(e.file.status === 'done'){
            var reader = new FileReader();
            reader.onloadend = function(e){
                this.setState({content:JSON.parse(e.target.result), uploadFile: false, text: fileName, loadingVisible: false});
            }.bind(this)
            reader.readAsBinaryString(f);
            }
        }
    }
    importFn(){

        if(this.state.content.meta === 'typehub-data'){
            let importedData = {fontSchemes:this.state.content.fontSchemes,savedValues:this.state.content.savedValues,settings:this.state.content.settings,custom:this.state.content.custom}

            let tempCurSavedValues = helper.postProcessSavedValues(this.props.store.initConfig.savedValues,this.props.store.initConfig.fieldConfig);

            if(this.state.content){
                let newData = {fontSchemes:Object.assign({},this.props.store.fontSchemes,importedData.fontSchemes),
                settings:Object.assign({},this.props.store.settings,importedData.settings),
                custom:Object.assign({},this.props.store.custom,importedData.custom),
                               savedValues:Object.assign({},tempCurSavedValues,importedData.savedValues)}

                this.props.dispatch(acScheme.importSchemes(newData.fontSchemes));
                this.props.dispatch(acCustom.importCustomOption(newData.custom));
                this.props.dispatch(initConfig.saveStore(newData.savedValues));

                notification.success({
                    message: 'Success!',
                    description: 'Your data has been imported successfully, Please save the changes ',
                    style:{
                        top:100
                    }
                  });
                }
        }else{

            notification.error({
                message: 'Sorry!',
                description: 'This doesn\'t seems to be a valid typehub data file'
              });
        }

        this.setState({content: {}, uploadFile: true, text: "Click on this area or drag and drop a file to upload"})

    }



    render(){
        return(
            <div style={{margin:'0px 40px',background:'#fff',padding:20}} className = "be-typehub-import-export">
                <div style={{height: "120px"}}>
                    <span style={{display: "block",
                                marginBottom: "8px",
                                color: "#313233",
                                fontSize: "16px",
                                fontWeight: "400"}} >Download a backup of your settings :</span>

                    <Button type='primary' onClick={this.exportFn} >Export</Button>
                </div>

                <div>
                    <span style={{display: "block",
                                marginBottom: "8px",
                                color: "#313233",
                                fontSize: "16px",
                                fontWeight: "400"}} >Import settings from a backup file :</span>
                    <Dragger disabled={!this.state.uploadFile} onChange={this.onDrop}  accept='.json' multiple={false} onRemove={()=> this.setState({content: null, uploadFile: true, text: "Click on this area or drag and drop a file to upload"})}
                    showUploadList = {false}>

                        <div style={{height:99,width:300,display:'flex',flexDirection:'column'}} >
                            <div style={{position:'absolute',top:'30%',left:'50%',marginLeft:-10, height: "20px", width: "20px", cursor: 'pointer'}} onClick={!this.state.uploadFile?()=> this.setState({content: {}, uploadFile: true, text: "Click on this area or drag and drop a file to upload"}): null}>
                                <Icon type={!this.state.uploadFile?"cross":"plus"} style={{color: !this.state.uploadFile?"#1890FF":"#9fa2a8", fontSize: '25px'}}/>
                            </div>
                            <span style={{color: !this.state.uploadFile?"#1890FF":"#9fa2a8",fontSize: "13px",position:'absolute',top: '50%',left: '50%',    transform: 'translate(-50%)'}}>{this.state.text} </span>
                        </div>

                    </Dragger>

                    <Button disabled={this.state.uploadFile} style={{marginTop: "14px"}} type='primary' onClick={this.importFn} >Import <Icon style={{color: "#1890FF", marginLeft: '10px', display: this.state.loadingVisible? 'inline-block' : 'none'}} type="loading" /></Button>
                </div>
                <div className = "be-typehub-dropzone" onDragOver = { (e) => {
                    e.preventDefault();
                } } onDrop = {this.dd} >
                    <h1 style = {{color : '#fff'}}> Drop files to upload </h1>
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



export default connect(mapStateToProps)(ImportAndExport);


function timenow(){
    var now= new Date(),
    

    date = now.getDate(),
    month = now.getMonth() + 1,
    year = now.getFullYear(),
    h= now.getHours(), 
    m= now.getMinutes(), 
    s= now.getSeconds();


    if(m<10) m= '0'+m;
    if(s<10) s= '0'+s;
    
    return `${year}_${month}_${date}_${h}_${m}_${s}`;
}