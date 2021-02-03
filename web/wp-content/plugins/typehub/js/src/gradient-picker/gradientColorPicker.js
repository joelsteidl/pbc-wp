var React = require('react'),
    ReactDOM = require('react-dom'),
    Swatches = require( './tools/swatches' ),
    Palettes = require( './tools/palettes' ),
    SketchPicker = require('react-color').SketchPicker;
       

class GradientColorPicker extends React.Component{

    getDefaultValues(){
        return({
            newColor : "rgba(0,0,0,1)",
            defaultSolidColor : "rgba(255,255,255,1)",
            defaultGradientBar : [
                                {barIndex: 0, color: 'rgba(255,255,255,1)', position: 0, isClicked: false},
                                {barIndex: 1, color: 'rgba(0,0,0,1)', position: 170, isClicked: false}
                            ], 
            defaultGradientAngle : '45'
        })
    }

    constructor(props){
        super(props);
        // Variables to populate State
        var activeState = '',
            gradientBarArray = [],
            solidColor = this.getDefaultValues().defaultSolidColor,
            gradientBar = this.getDefaultValues().defaultGradientBar,
            gradientAngle = this.getDefaultValues().defaultGradientAngle,
            currentGradientColor = '',
            currentGradientKey = 1,
            maxBarKey = 0,
            isSolidVisible = true, 
            isGradientVisible = false,
            isSwatchVisible = false,
            selectedSwatch = '',
            selectedSwatchType = '',
            searchSwatch = '',
            isPaletteVisible = false,
            selectedPalette = '',
            selectedPaletteType = '';
        
        // Form Gradient Array from Props
        if(props.color.hasOwnProperty('gradient')){
            gradientBarArray = this.createGradientArray(props.color.gradient.color.colorPositions);
            gradientBar = gradientBarArray;
            gradientAngle =  props.color.gradient.color.angle;
            currentGradientColor = gradientBarArray[0].color;
            currentGradientKey = 1;
            maxBarKey = gradientBarArray.length;
        }

        // Get Solid Color from Props
        if(props.color.hasOwnProperty('solid') && this.validateColor(props.color.solid.color)){
            solidColor = props.color.solid.color;
        }

        // Get Active Panel from Props 
        activeState = props.color.active != '' ? props.color.active : 'solid';

         // Get Swatch/Palette Information from Props
         if( props.color.hasOwnProperty('id') && props.colorHub !== '' ){
            var id = props.color.id, 
                colorType = id.startsWith('swatch') ? 'swatch' : '';
                colorType = id.startsWith('palette') ? 'palette' : colorType;
            var colorKey = id.split(':')[1];
            if(this.isColorKeyValid(colorType, colorKey)){
                if(colorType === 'swatch'){
                    selectedSwatch = colorKey,
                    isSwatchVisible = true,
                    isSolidVisible = false
                }else{
                    selectedPalette = parseInt(colorKey),
                    isPaletteVisible = true,
                    isSolidVisible = false
                }
            }
        }else{ // Enable panel only if a Swatch or Palette is not selected
            if(activeState == 'gradient'){
                isGradientVisible = true;
                isSolidVisible = false;
            }else{  
                isSolidVisible = true;
                isGradientVisible = false;
            }  
        } 
        // Store State - OPTIONAL
        this.InitalState = this.state;

        // Set Initial State
        this.state = {   
            color: solidColor,     
            currentGradientColor: currentGradientColor,              
            currentGradientKey : currentGradientKey,
            maxBarKey : gradientBar.length, 
            isVisible: true,
            isSolidVisible: isSolidVisible,
            isGradientVisible: isGradientVisible,
            gradientAngle: gradientAngle, 
            gradientBar : gradientBar,
            isSwatchVisible : isSwatchVisible,
            selectedSwatch : selectedSwatch,
            selectedSwatchType : selectedSwatchType,
            searchSwatch : searchSwatch,
            isPaletteVisible : isPaletteVisible,
            selectedPalette : selectedPalette,
            selectedPaletteType: selectedPaletteType
        }

        this.showPalette = this.showPalette.bind(this);
        this.validateColor = this.validateColor.bind(this);
        this.createGradientArray = this.createGradientArray.bind(this);
        this.isColorKeyValid = this.isColorKeyValid.bind(this);
        this.gradientSort = this.gradientSort.bind(this);
        this.computeGradient = this.computeGradient.bind(this);
        this.showSolidPicker = this.showSolidPicker.bind(this);
        this.showGradientPicker = this.showGradientPicker.bind(this);
        this.showSwatches = this.showSwatches.bind(this);
        this.showPalette = this.showPalette.bind(this);
        this.changeAngle = this.changeAngle.bind(this);
        this.addnewPicker = this.addnewPicker.bind(this);
        this.handlePicker = this.handlePicker.bind(this);
        this.movePicker = this.movePicker.bind(this);
        this.removePicker = this.removePicker.bind(this);
        this.setGradientColor = this.setGradientColor.bind(this);
        this.changeColor = this.changeColor.bind(this);
        this.swatchClick = this.swatchClick.bind(this);
        this.paletteClick = this.paletteClick.bind(this);
        this.colorPickerData = this.colorPickerData.bind(this);
        this.colorPickerTab = this.colorPickerTab.bind(this);
        this.colorPalette = this.colorPalette.bind(this);
    }

    componentDidMount() {

        //Calculate top based on panel selected
        var panel = this.state.isSolidVisible ? 'solid' : (  
                        this.state.isGradientVisible ? 'gradient' : (
                            this.state.isSwatchVisible ? 'swatch' :
                                'palette'
                        )
                    );
        this.props.calculateTop( panel );

    }

    /** HELPER FUNCTIONS **/
    // Validate Color
    validateColor(color){

		var result = true,
				dummyElement = document.createElement( 'div' );
		dummyElement.style.backgroundColor = color;
		if( 0 === dummyElement.style.backgroundColor.length ) {
				result = false;
		}
		dummyElement = null;
		return result;

	}
    // To Create Gradient Array from Color Object
    createGradientArray(gradientObject){
        var i = 0,
        gradientBarArray = [];
        for(var position in gradientObject){
            if(this.validateColor(gradientObject[position])){
                gradientBarArray[i] = {
                    barIndex : i + 1,
                    color : gradientObject[position],
                    position : position * (170/100),
                    isClicked : false,
                }
                i = i+1;
            }
        }
        return gradientBarArray;
    }
    // Validate a Swatch or Pallette ID in Prop against Color Hub Data
    isColorKeyValid(colorType, colorKey){
        var colorHubData = this.props.colorHub; 
        if(colorType === 'swatch'){
            for(var swatch in colorHubData.swatches){
                if(swatch === colorKey){
                    return true;
                }
            }
        }else if(colorType === 'palette'){
            var currentPaletteArray = this.getCurrentColorHubPalette(colorHubData.palettes);
            for(var palette in currentPaletteArray){
                if(palette == parseInt(colorKey)){
                    return true;
                }
            }
        }
        return false;
    }
    // Get the current Color Hub Palette
    getCurrentColorHubPalette(palettes){
        var currentPaletteID = palettes.currentPalette;
        return palettes.allPalettes[currentPaletteID];
    }

    // Sort Gradient Color Stops based on position
    gradientSort(gradientBarArray){
        var sortedArray = gradientBarArray.sort(function(a,b){
          {return a.position - b.position}
        });
        return sortedArray;
    }
    // Compute Gradient Value from State Array
    computeGradient(theState,includeAngle,angle){
        var computedGradient = '';
        if(theState.gradientBar.length >= 2){
            computedGradient = 'linear-gradient(';
            computedGradient = computedGradient + (includeAngle ? angle : '90') + 'deg ' ;

            this.gradientSort(theState.gradientBar).map(function(item,index){
                computedGradient = computedGradient + ',' + item.color + ' ' + Math.floor(item.position/170 * 100) + '%' ;
            })
            computedGradient = computedGradient + ')' ;
        }else if(theState.gradientBar.length === 1){
            computedGradient = theState.gradientBar[0].color;
        }else{
            computedGradient = theState.color;
        }
        return computedGradient;
    }

    convertComponent(colorValue){
        var hex = colorValue.toString(16);
        return hex.length == 1 ? "0" + hex : hex;
    }
    

    /** ACTIONS **/
    // Enable Solid Picker 
    showSolidPicker(){
        this.setState({
            isSolidVisible: true,
            isGradientVisible: false,
            isSwatchVisible : false,
            isPaletteVisible : false
        }, this.props.calculateTop.bind( null, 'solid' ));
        this.props.onChange(this.colorPickerData('panelChange','solid'));
    }
    // Enable Gradient Picker
    showGradientPicker(){
        this.setState({
            isSolidVisible: false,
            isGradientVisible: true,
            isSwatchVisible : false,
            isPaletteVisible : false
        }, this.props.calculateTop.bind( null, 'gradient' ) );
        this.props.onChange(this.colorPickerData('panelChange','gradient'));
    }
    // Enable Swatches
    showSwatches(){
        this.setState({
            isSolidVisible: false,
            isGradientVisible: false,
            isSwatchVisible : true,
            isPaletteVisible : false
        }, this.props.calculateTop.bind( null, 'swatch' ) );
        this.props.onChange(this.colorPickerData('panelChange','swatch'));
    }
    // Enable Palette
    showPalette(){
        this.setState({
            isSolidVisible: false,
            isGradientVisible: false,
            isSwatchVisible : false,
            isPaletteVisible : true
        }, this.props.calculateTop.bind( null, 'palette' ))
        this.props.onChange(this.colorPickerData('panelChange','palette'));
    }
    // Color Change
    changeColor (type,index,choosenColor){
        var rgbaColor = 'rgba(' + choosenColor.rgb.r + ',' + choosenColor.rgb.g + ',' + choosenColor.rgb.b + ',' + choosenColor.rgb.a + ')';
        if(type === 'solid'){
            this.setState({
                color: rgbaColor,
                selectedSwatch: '',
                selectedSwatchType: '',
                selectedPalette : '',
                selectedPaletteType : ''
            })
            this.props.onChange(this.colorPickerData('solidColorChange',rgbaColor));
        }else if(type === 'gradient'){
            var stateGradientBar = this.state.gradientBar;
            for(var i in stateGradientBar){
                if(stateGradientBar[i].barIndex === index){
                    stateGradientBar[i].color = rgbaColor;
                }
            }
            this.setState({
                gradientBar: stateGradientBar,
                currentGradientColor: rgbaColor,
                selectedSwatch: '',
                selectedSwatchType: '',
                selectedPalette : '',
                selectedPaletteType : ''
            })
            this.props.onChange(this.colorPickerData('gradientColorChange',stateGradientBar));
        }
    }
    // Current Color Chosen on the Gradient Bar
    setGradientColor(currentColor,index){
        this.setState({
          currentGradientColor: currentColor,
          currentGradientKey: index
        })
    }
    // To change Angle
    changeAngle(event){
        this.setState({
            gradientAngle : event.target.value,
            selectedSwatch: '',
            selectedSwatchType: '',
            selectedPalette : '',
            selectedPaletteType : ''
        })
        this.props.onChange(this.colorPickerData('angleChange', event.target.value));
        
    }
    // Add new color Stop
    addnewPicker(event){
        var rect = ReactDOM.findDOMNode(this.refs['gradientbar']).getBoundingClientRect(),
            newPickerIndex = this.state.maxBarKey + 1,
            newPickerPosition = Math.floor(event.pageX - rect.left),
            newGradientBar = this.state.gradientBar,
            newPicker = {
              barIndex: newPickerIndex, 
              position: newPickerPosition,
              color: this.getDefaultValues().newColor,
              isClicked: false
            };
            newGradientBar.push(newPicker);
        this.setState({
            maxBarKey : newPickerIndex,
            gradientBar : newGradientBar,
            currentGradientKey : newPickerIndex, 
            currentGradientColor : this.getDefaultValues().newColor,
            selectedSwatch: '',
            selectedSwatchType: '',
            selectedPalette : '',
            selectedPaletteType : ''
        }) 
        this.props.onChange(this.colorPickerData('gradientColorChange',newGradientBar));
    }
    // Toggle picker selection on Mouse up / down
    handlePicker(clickStatus,currentIndex,event){
        var newGradientBar = this.state.gradientBar,
            currentBarIndex = this.state.currentGradientKey;
        if(clickStatus === true){
            currentBarIndex = currentIndex;
        }
        
        for(var i in newGradientBar){
            if(newGradientBar[i].barIndex === currentBarIndex && newGradientBar[i].isClicked !== clickStatus){
                newGradientBar[i].isClicked = clickStatus;
                this.setState({
                    gradientBar: newGradientBar,
                    currentGradientKey: currentBarIndex,
                    selectedSwatch: '',
                    selectedSwatchType: '',
                    selectedPalette : '',
                    selectedPaletteType : ''
                }) 
                this.props.onChange(this.colorPickerData('gradientColorChange',newGradientBar));
            }
        }
    }
    // To change Color Stop Position
    movePicker(event){
        event.preventDefault();
        var newGradientBar = this.state.gradientBar,
            currentBarIndex = this.state.currentGradientKey,
            rect = ReactDOM.findDOMNode(this.refs['gradientbar']).getBoundingClientRect(),
            pickerPosition = Math.floor(event.screenX - rect.left);
        for(var i in newGradientBar){
            if(newGradientBar[i].barIndex === currentBarIndex){
                if(newGradientBar[i].isClicked === true){  
                    if(pickerPosition >= 0 && pickerPosition <= 166){            
                        newGradientBar[i].position = pickerPosition;
                    }else if(pickerPosition < 0){
                        newGradientBar[i].position = 0;
                    }else{
                        newGradientBar[i].position = 170;
                    }
                    this.setState({
                        gradientBar: newGradientBar,
                        selectedSwatch: '',
                        selectedSwatchType: '',
                        selectedPalette : '',
                        selectedPaletteType : ''
                    }) 
                    this.props.onChange(this.colorPickerData('gradientColorChange',newGradientBar));
                }
            }
        }  
    }
    // To Remove Color Stop
    removePicker(key){
        if(this.state.gradientBar.length > 1){
          var newGradientBar = this.state.gradientBar;
              newGradientBar.splice(key,1);
          this.setState({
            gradientBar: newGradientBar,
            currentGradientKey: 1,
            selectedSwatch: '',
            selectedSwatchType: '',
            selectedPalette : '',
            selectedPaletteType : ''
          })
        }
        this.props.onChange(this.colorPickerData('gradientColorChange',newGradientBar));
    }
    // On Swatch Click
    swatchClick(selectedSwatch){
        var swatchColor = selectedSwatch.color; 
        if(this.state.selectedSwatch === selectedSwatch.key){
            this.setState({
                selectedSwatch: '',
                selectedSwatchType: ''
            })
            this.props.onChange(this.colorPickerData('',''));
        }else{
            if(typeof swatchColor === 'object'){
                // Form Gradient Array from Swatch Data
                var gradientBarArray = this.createGradientArray(swatchColor.colorPositions);

                this.setState({
                    gradientBar : gradientBarArray,
                    gradientAngle: swatchColor.angle,
                    currentGradientKey : 1, 
                    currentGradientColor : gradientBarArray[0].color,
                    maxBarKey : gradientBarArray.length,
                    selectedSwatch : selectedSwatch.key,
                    selectedSwatchType : 'gradient',
                    selectedPalette: '',
                    selectedPaletteType: ''
                })

                this.props.onChange(this.colorPickerData('swatchChangeGradient',selectedSwatch));
            }else{
                // Update Solid Color from Swatch Data
                this.setState({
                    color: swatchColor,
                    selectedSwatch : selectedSwatch.key,
                    selectedSwatchType : 'solid',
                    selectedPalette: '',
                    selectedPaletteType: ''
                })
                this.props.onChange(this.colorPickerData('swatchChangeSolid',selectedSwatch));
            }
        }
    }
    // On Palette Click
    paletteClick(paletteID, paletteColor){
        if(this.state.selectedPalette === paletteID){
            this.setState({
                selectedPalette: '',
                selectedPaletteType: ''
            })
            this.props.onChange(this.colorPickerData('',''));
        }else{
            if(typeof paletteColor === 'object'){
                // Form Gradient Array from Palette Data
                var gradientBarArray = this.createGradientArray(paletteColor.colorPositions);

                this.setState({
                    gradientBar : gradientBarArray,
                    gradientAngle: paletteColor.angle,
                    currentGradientKey : 1, 
                    currentGradientColor : gradientBarArray[0].color,
                    maxBarKey : gradientBarArray.length,
                    selectedPalette: paletteID,
                    selectedPaletteType: 'gradient',
                    selectedSwatch: '',
                    selectedSwatchType : ''
                })
                this.props.onChange(this.colorPickerData('paletteChangeGradient',{ key: paletteID, color: paletteColor } ) );
            }else{
                // Update Solid Color from Palette Data
                this.setState({
                    color: paletteColor,
                    selectedPalette: paletteID,
                    selectedPaletteType: 'solid',
                    selectedSwatch: '',
                    selectedSwatchType : ''
                })
                this.props.onChange(this.colorPickerData('paletteChangeSolid',{ key: paletteID, color: paletteColor } ) );
            }
        }
    }

    /** DATA SENT TO PARENT COMPONENTS **/
    colorPickerData(changeType, changeInfo){

        var colorPicker = {};

        // Set Default Values from State
        var gradientBarArray = this.state.gradientBar, 
            angle = this.state.gradientAngle;

        if(this.state.isGradientVisible || this.state.selectedSwatchType === 'gradient' ){
            colorPicker.active = 'gradient'
        }else{
            colorPicker.active = 'solid'
        }

        colorPicker.solid = {color: this.state.color} ;
        // Modify Data based on Change Info
        switch (changeType){
            case 'panelChange': 
                colorPicker.active = changeInfo;
                if(changeInfo === 'swatch' || changeInfo === 'palette'){
                    if(this.state.selectedSwatchType === 'gradient'){
                        colorPicker.active = 'gradient';
                    }else{
                        colorPicker.active = 'solid';
                    }
                }
                if(this.state.selectedSwatch !== ''){
                    colorPicker.id = 'swatch:'+this.state.selectedSwatch;
                }
            break; 
            case 'solidColorChange':
                colorPicker.solid.color = changeInfo; 
            break;
            case 'gradientColorChange':
                gradientBarArray = changeInfo; 
            break;
            case 'swatchChangeSolid':
                colorPicker.active = 'solid';
                colorPicker.solid = { color: changeInfo.color };
                colorPicker.id = 'swatch:'+changeInfo.key;
            break;
            case 'swatchChangeGradient':
                colorPicker.active = 'gradient';
                colorPicker.gradient = { color: changeInfo.color };
                colorPicker.id = 'swatch:'+changeInfo.key;
            break;   
            case 'paletteChangeSolid':
                colorPicker.active = 'solid';
                colorPicker.solid = { color: changeInfo.color };
                colorPicker.id = 'palette:'+changeInfo.key;
            break;
            case 'paletteChangeGradient':
                colorPicker.active = 'gradient';
                colorPicker.gradient = { color: changeInfo.color };
                colorPicker.id = 'palette:'+changeInfo.key;
            break;    
            case 'angleChange':
                angle = changeInfo;
            break;    
        }
        if( changeType !== 'swatchChangeGradient' && changeType !== 'paletteChangeGradient' ){
            // changeType !== 'swatchChangeSolid' && changeType !== 'paletteChangeSolid' 
            colorPicker.gradient = { color: { angle: angle } };
            colorPicker.gradient.color.colorPositions = {};
            if(gradientBarArray.length >= 2){
                this.gradientSort(gradientBarArray).map(function(item,index){
                    colorPicker.gradient.color.colorPositions[Math.floor(item.position/170 * 100)] = item.color ;
                })
            }else if(gradientBarArray.length === 1){
                colorPicker.gradient.color.colorPositions[0] = gradientBarArray[0].color;
            }  
        }
        return colorPicker;
    }

    // Markup to print Color Picker Tab 
    colorPickerTab(){
        return(
            <div className = "be-color-picker-tab">
                { (this.props.enableGradient || this.props.enableSwatch || this.props.enablePalette) && <span onClick = {this.showSolidPicker.bind(this)} className = {this.state.isSolidVisible ? "visible-palette" : "" } >Solid</span> }
                { this.props.enableGradient && <span onClick = {this.showGradientPicker.bind(this)} className = {this.state.isGradientVisible ? "visible-palette" : "" } >Gradient</span> }
                { this.props.enableSwatch && <span onClick = {this.showSwatches.bind(this)} className = {this.state.isSwatchVisible ? "visible-palette" : "" } >Swatch</span> }
                { this.props.enablePalette && <span onClick = {this.showPalette.bind(this)} className = {this.state.isPaletteVisible ? "visible-palette" : "" } >Palette</span> }
            </div>
        )
    }
    // Markup to print Color Picker Paletter
    colorPalette(){
        var gradientBarStyle = {
          background: this.computeGradient(this.state,false) 
        };    
        if(this.state.isSolidVisible){
            return(
                <div className = "be-color-palette">
                    <SketchPicker color= {this.state.color} onChange = { this.props.quickChange ? this.changeColor.bind( this,'solid',0 ) : '' } onChangeComplete = { this.changeColor.bind( this,'solid',0 ) }/>
                </div>
            )
        }else if(this.state.isGradientVisible){
            return(
                <div className = "be-color-palette">
                    <div className ="gradient-wrap">
                        <div className = "gradient-settings">
                            <input type="number" label="Degree" className="be-color-picker-gradient-angle" value= {this.state.gradientAngle} onChange = { this.changeAngle.bind(this) }/>
                            <p>Angle</p>
                        </div>
                        <div    onMouseUp = {this.handlePicker.bind(this,false,0)} 
                                onMouseMove = {this.movePicker.bind(this)} 
                                className = "gradient-bar-wrapper">
                            <div className = "gradient-bar" ref="gradientbar" onClick = {this.addnewPicker.bind(this)} style = { gradientBarStyle } ></div>
                            <div> 
                                <ul className="gradient-picker">
                                {
                                    this.gradientSort(this.state.gradientBar).map(function(item,index){
                                    var pickerStyle = {
                                        marginLeft : (item.position - 6) + 'px',
                                        background : item.color
                                    };
                                    return <li  draggable = "false" 
                                                key = {index} 
                                                onDoubleClick = {this.removePicker.bind(this,index)}  
                                                onMouseDown = {this.handlePicker.bind(this,true,item.barIndex)}  
                                                onMouseUp = {this.handlePicker.bind(this,false,0)} 
                                                onClick = {this.setGradientColor.bind(this,item.color,item.barIndex)} 
                                                style = { pickerStyle }>
                                            </li>
                                    },this)
                                }
                                </ul>
                            </div>
                        </div>
                    </div>
                <SketchPicker onChange = { this.props.quickChange ? this.changeColor.bind(this,'gradient',this.state.currentGradientKey) : '' } onChangeComplete = {this.changeColor.bind(this,'gradient',this.state.currentGradientKey)} color= {this.state.currentGradientColor}/>
                </div>
            )
        }else if(this.state.isSwatchVisible){
            return(
                <Swatches
                    swatchClick={this.swatchClick}
                    enableGradient = {this.props.enableGradient}
                    colorHub = {this.props.colorHub}
                    selectedSwatch = {this.state.selectedSwatch}
                />
            )
        }else if(this.state.isPaletteVisible){
            return(
                <Palettes 
                    paletteClick = {this.paletteClick}
                    enableGradient = {this.props.enableGradient}
                    colorHub = {this.props.colorHub}
                    selectedPalette = {this.state.selectedPalette}
                />
            )
        }
    }
    
    // Main Render Method
    render() {
        return (
          <div>
            <div className="be-gradient-color-panel">
            {
                this.colorPickerTab()
            }
            {
                this.colorPalette()
            }
            </div>
          </div>
        );
    }
}

module.exports = GradientColorPicker;