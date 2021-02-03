import React from 'react';
import helpers from '../../../../helper/helpers';


class FontPreview extends React.Component {
    constructor(props) {
        super(props);
        this.clickedFontScource = props.clickedFont.split(':')[0]
        this.clickedFontName = props.clickedFont.split(':')[1];
        this.state = {

        };

    }

    componentWillReceiveProps(nextProps) {
        this.clickedFontScource = nextProps.clickedFont.split(':')[0]
        this.clickedFontName = nextProps.clickedFont.split(':')[1];
    }

    shouldComponentUpdate(nextProps,nextState){
        return nextProps.clickedFont.split(':')[1] !== this.props.clickedFont.split(':')[1] || nextProps.clickedFont.split(':')[0] !== this.props.clickedFont.split(':')[0]
    }

    render() {

     
        helpers.fontLoader(this.props.clickedFont);

        let fontVariantList;

        if(['google','custom','typekit'].includes(this.clickedFontScource)){
           fontVariantList = window.typehub_fonts[this.clickedFontScource][this.clickedFontName] ? window.typehub_fonts[this.clickedFontScource][this.clickedFontName].variants.sort(compare) : [{id:400,name:'Normal 400'}] ;
        }else{
            fontVariantList = [{id:400,name:'Normal 400'}];

            if(this.clickedFontName === 'System Font Stack'){
                fontVariantList = [
                    { id: '100', name: 'Ultra Light 100' },
                    { id: '100italic', name: 'Ultra Light 100 Italic' },
                    { id: '200', name: 'Light 200' },
                    { id: '200italic', name: 'Light 200 Italic' },
                    { id: '300', name: 'Book 300' },
                    { id: '300italic', name: 'Book 300 Italic' },
                    { id: '400', name: 'Normal 400' },
                    { id: '400italic', name: 'Normal 400 Italic' },
                    { id: '500', name: 'Medium 500' },
                    { id: '500italic', name: 'Medium 500 Italic' },
                    { id: '600', name: 'Semi-Bold 600' },
                    { id: '600italic', name: 'Semi-Bold 600 Italic' },
                    { id: '700', name: 'Bold 700' },
                    { id: '700italic', name: 'Bold 700 Italic' },
                    { id: '800', name: 'Extra-Bold 800' },
                    { id: '800italic', name: 'Extra-Bold 800 Italic' },
                    { id: '900', name: 'Ultra-Bold 900' },
                    { id: '900italic', name: 'Ultra-Bold 900 Italic' }                                                  
                ];
            }else{
                fontVariantList = [{ id: '400', name: 'Normal 400' },
                                        { id: '400italic', name: 'Normal 400 Italic' },
                                        { id: '700', name: 'Bold 700' },
                                        { id: '700italic', name: 'Bold 700 Italic' }];
            }

        }
        let currentfontFamily = this.clickedFontName;
        if(this.clickedFontScource === 'standard'){
            currentfontFamily = window.typehub_fonts.standard[this.clickedFontName];
        }else if(this.clickedFontScource === 'typekit'){
            currentfontFamily =  window.typehub_fonts.typekit[this.clickedFontName] ? window.typehub_fonts.typekit[this.clickedFontName].cssname : window.typehub_fonts.standard["System Font Stack"];
        }

        const listContent = fontVariantList.map((variant,index) => {

            return  <div key={index} style={{background:'#fff',padding:10,width:'100%',display:'flex'}} >
            <div style={{flexBasis:200}} >
                {variant.name}
            </div>
                <div style={ {fontFamily:currentfontFamily, fontWeight:variant.id,flex:'auto'}}  >
                    <div style={isNaN(variant.id) ? {fontStyle:'italic',fontWeight:variant.id.substring(0,3)} : {}} > 
                        The spectacle before us was indeed sublime. 
                    </div>
                </div>
            </div>

});

        return (
            <div>
            <div style={{ background: '#fff',padding:10,marginBottom:1,fontWeight:500 }} > Font Preview </div>
            <div style={{maxHeight:300,overflowY:'auto'}} >
            
                {listContent}
                </div>
            </div>
        )
    }
}
function compare(a, b) {
    if (a.id < b.id)
        return -1;
    if (a.id > b.id)
        return 1;
    return 0;
}


export default FontPreview;