var computeGradient = function(colorObject){
    var colorValue = '';
        var colorStops = Object.keys(colorObject.colorPositions).length,
            
        gradientObject = colorObject;
        if(colorStops == 1){
            colorValue = gradientObject.colorPositions[0];
        }else{
            colorValue = 'linear-gradient(' ;
            colorValue = colorValue + gradientObject.angle + 'deg';
            for(var position in gradientObject.colorPositions){
                colorValue = colorValue + ',' + gradientObject.colorPositions[position] + ' ' + position + '%'
            }
            colorValue = colorValue + ')';
        }
    return colorValue;
}

module.exports = function(colorPickerData){
    var colorValue = '';
    if(typeof colorPickerData == 'string'){
        return colorPickerData
    }else{
        if(colorPickerData.hasOwnProperty('active')){
            if(colorPickerData.active == 'solid'){
                return colorPickerData.solid.color;
            }else{
                return computeGradient(colorPickerData.gradient.color);    
            }
        }else{
            return computeGradient(colorPickerData);
        }
    }
}