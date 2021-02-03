import React from 'react';
import {connect} from 'react-redux';
import helpers from '../../../../helper/helpers';
import invert from 'invert-color';

class FontPreview extends React.Component{

    constructor(){
        super();
        this.validateAndGetValue = this.validateAndGetValue.bind(this);
        this.getStyles = this.getStyles.bind(this);

        this.state = {
            darkTheme : false
        }
    }

    getFontFamily( family ){
        if( typeof family === 'string' ){
            var familyArr = family.split(':');

            var standardFonts = window.typehub_fonts.standard;
            if( !familyArr[1] ){
                return familyArr[0];
            } else {
                if( familyArr[0] === 'schemes' ){
                    if( !familyArr[1] ){
                        return '';
                    }
                    if( this.props.store.fontSchemes[familyArr[1]] ){
                        return this.getFontFamily( this.props.store.fontSchemes[familyArr[1]].fontFamily )
                    }
                    return '';
                } else if( standardFonts &&  standardFonts[ familyArr[1] ] ){
                    return standardFonts[ familyArr[1] ];
                } else {
                    helpers.fontLoader(family);
                    return familyArr[1];
                }
            }
        } else {
            return family
        }
    }

    validateAndGetValue( value, prop ){
        var selectedDevice = this.props.selectedDevice;
        if( value[prop] ){
            value = value[prop];
            if( value[selectedDevice] ){
                return value[selectedDevice].value + value[selectedDevice].unit;
            } else {
                return value.desktop.value + value.desktop.unit
            }
        }
    }

    rgbHelper( color ){
        var offset = 3;
        if( color.startsWith( 'rgba' ) ){
            offset = 5;
        }
        color = color.substring(offset, color.length-1)
        .replace(/ /g, '')
        .split(',').splice(0,3);

        return color;
    }

    getStyles(){

        if( !this.props.clickedOption ){
            return null;
        }
        var value = this.props.store.initConfig.savedValues[this.props.clickedOption],
            variantSplit = helpers.getCSSValueAndUnit( value['font-variant'] ) || { unit:'normal', value : 400 },
            color = helpers.getColorValue(value.color);

        return {
            fontFamily : this.getFontFamily(value['font-family']),
            fontWeight : variantSplit.value,
            fontStyle : variantSplit.unit,
            textTransform : value['text-transform'],
            fontSize : this.validateAndGetValue(value, 'font-size'),
            letterSpacing :this.validateAndGetValue(value, 'letter-spacing'),
            lineHeight : this.validateAndGetValue(value, 'line-height'),
            color : color
        };
    }

    render(){
        var styles = this.getStyles();

        return (
            this.props.clickedOption && <div
            className="typehub-font-preview" 
            style = {{background : this.state.darkTheme ? '#000' : '#fff'}}
          >
            <div className="typehub-preview-title" style = {{color : this.state.darkTheme ? '#fff' : '#000', borderColor : this.state.darkTheme ? '#1a1a1a' : '#e3e3e3'}} > <div >Preview</div> <div title="Change Skin" className="typehub-preview-color-switch" onClick={()=>this.setState({darkTheme : !this.state.darkTheme})} >  <svg style={{height:15, fill: 'currentColor' }} t="1557400858097" className="icon"  viewBox="0 0 1024 1024"><path d="M512.158447 1023.810054a511.905185 511.905185 0 1 1 512.316735-511.905185 512.696628 512.696628 0 0 1-512.316735 511.905185z m0-930.736701a418.831515 418.831515 0 1 0 419.148092 418.831516 419.433012 419.433012 0 0 0-419.148092-418.831516z m-256.174197 418.831516a256.047566 256.047566 0 0 1 256.174197-255.952593v511.905185a256.015908 256.015908 0 0 1-256.174197-255.825962z"></path></svg> </div>  </div>
            <div className="typehub-preview-content"  contentEditable style={styles}>
            Type here...
            </div>
          </div>
        );
    }

}

function mapStateToProps(store, ownProps) {
    return {
        store
    }
}

export default connect(mapStateToProps)(FontPreview);