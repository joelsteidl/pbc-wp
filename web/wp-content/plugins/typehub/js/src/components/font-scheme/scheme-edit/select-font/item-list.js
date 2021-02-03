import React from 'react';
import  List  from 'react-virtualized/dist/es/List';

class ItemList extends React.Component {


    componentWillMount() {
        this.shouldAddFive = true;
    }

    componentDidMount() {
        this.shouldAddFive = false;
    }

    render(){
        let props = this.props;
    
        let listWidth = props.settings ? 380 : 320; 
    
        var itemsArray = [];

    if(window.typehub_fonts.hasOwnProperty(props.source)){
        itemsArray = Object.keys(window.typehub_fonts[props.source]).map(item=> { return {display:item,value:item}});
    }else if(props.source === 'schemes'){
        itemsArray =  props.activeFontSchemes.map(scheme =>  {return { display:`${props.fontSchemes[scheme].name} - ${props.fontSchemes[scheme].fontFamily.split(':')[1]}`,value:scheme}}) 
    }

    const filteredArray = itemsArray.filter(item => item.display.toLowerCase().startsWith(props.text.toLowerCase()));
    let itemBG = {background:'#fff'};
var selectedIndex = 0;
    filteredArray.forEach((item,index)=>
    {
               if(props.clickedFont && props.clickedFont.split(':')[1] === filteredArray[index].display || props.clickedFont.split(':')[1] === filteredArray[index].value){
                selectedIndex = index;
               }
    })
    function fontListRender({key,index,isScrolling,isVisible,style}){
   
   let classes = 'font-list-item';
        if( props.clickedFont && props.clickedFont.split(':')[1] === filteredArray[index].display || props.clickedFont.split(':')[1] === filteredArray[index].value ){ 
            classes = 'font-list-item selected ';
        }
    
      return (

          <div
              key={key} 
              style={style}
              onClick={props.clicked.bind(this,filteredArray[index].value,props.source)}
              className={classes}
          >
              {filteredArray[index].display}
          </div>
      )
  }


    return(     
    <div  >
    
        <List
                width={listWidth}
                height={375}
                scrollToIndex={ this.shouldAddFive ? selectedIndex+5 : selectedIndex }
                rowCount={filteredArray.length}
                rowHeight={40}
                rowRenderer={fontListRender}
        />
  </div>
    );
}
}
export default ItemList;