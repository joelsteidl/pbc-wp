import React from 'react';
import {Button,message,Spin} from 'antd';
class WebfontGenerator extends React.Component{

    constructor(props){
        super(props);
        this.state = {
            ttfotfFile:'',
            ttfotfFildAdded:false,
            webkitGenerating:false
        }
    }

    getFontFile(e){
        var ttfotf_file = e.target.files[0]; // accesing file
        var ttfot_filename = ttfotf_file.name;
        let extension = ttfot_filename.split('.').pop();
        if(extension=='otf'||extension=='ttf'){
            this.setState({ttfotfFile:ttfotf_file,ttfotfFildAdded:true});
        }else{
             message.warn('Please select a ttf/otf file only');
        }
        
    }

    getZipFromFontFile(e){
        if( this.state.ttfotfFildAdded){
            message.info('Generating webfont kit. Please wait!');
            this.setState({webkitGenerating:true});
            var thisObj = this;
            const fd = new FormData();        
            fd.append('uploadedfile', this.state.ttfotfFile); // appending file
            var xhr = new XMLHttpRequest();
            var xhrURL = 'https://brandexponents.com/webfont-generator-api/webfont-generator.php';
            
            xhr.open('POST', xhrURL, true);
            xhr.responseType = 'blob';
            xhr.onload = function(e) {
                if (this.status == 200) {
                    //getting zip file name from header
                     var filename_header = xhr.getResponseHeader("Content-Disposition");
                    //ex - attachment; filename=mnu-pom-uih-juy-gyu-bold.zip
                    filename_header = filename_header.split("=");
                    var webfont_zip_name = filename_header.pop();
                    
                    //preparing for download
                    var blob = new Blob([this.response], {type: 'application/zip'});
                    var downloadUrl = URL.createObjectURL(blob);
                    var a = document.createElement("a");
                    a.href = downloadUrl;
                    a.download = webfont_zip_name;
                    document.body.appendChild(a);
                    a.click();
                    message.info('Please upload the downloaded zip file below to start using your font in typehub.');
                //Empty values
                 let Inputfontfile = document.getElementById('uploadFontFileInput');
                 Inputfontfile.value = '';
                 thisObj.setState({ttfotfFile:'',ttfotfFildAdded:false,webkitGenerating:false});
                    if(typeof this.response.res !='undefined' && this.response.res === false){
                        message.warn(this.response.msg);
                        console.log(this.response.msg);
                    }
                }else{
                    if(typeof this.response.res !='undefined' && this.response.res === false){
                        message.warn(this.response.msg);
                        console.log(this.response.msg);
                    }
                    console.log("Response fail");
                }
            };
            xhr.send(fd);
        }else{
            message.warn('Please select a ttf/otf file');
        }
    }

    render(){
        let spinWheel = '';
            if(this.state.webkitGenerating){
                spinWheel =<Spin />;
            }
            
            return (
                <div style={{marginBottom:10,background: '#fff',padding:15}}>
                    <h3><strong>Step 1.</strong> Generate webfont kit</h3>
                    <input type='file' id="uploadFontFileInput" onChange={this.getFontFile.bind(this)}/>
                    <p>Upload your font's TTF or OTF file here to generate the webfont kit</p>
                    <Button style={{marginRight: 10}} type="primary" disabled={this.state.webkitGenerating} onClick={this.getZipFromFontFile.bind(this)} >Generate</Button>  
                    {spinWheel}
                </div>
            )
    }
}


  export default WebfontGenerator;