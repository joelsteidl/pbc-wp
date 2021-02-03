export default {
  isEmpty: (mixed_var) => {

    if (!mixed_var || '' === mixed_var || ('object' === typeof mixed_var && 0 === Object.keys(mixed_var)) || false === mixed_var) {
      return true;
    }
    return false;

  },
  deepGet: function deepGet(obj, propertiesArray) {

    if (!obj) {
      return null;
    }
    if (0 === propertiesArray.length) {
      return 1;
    }
    return deepGet(obj[propertiesArray[0]], propertiesArray.slice(1));

  },

  removeElementFromArray: function (arrayy, element) {

    return arrayy.filter(e => e !== element)
  },
  getCSSValueAndUnit: function unit(value) {

    if (!value || !value.length) {
      return ' '
    }
    var len = value.length
    var i = len
    while (i--) {
      if (!isNaN(value[i])) {
        return {
          value: value.slice(0, i + 1, len),
          unit: value.slice(i + 1, len)
        } || ' '
      }
    }
    return ' '
  },
  arrayContainArray: (superset, subset) => {
    if (0 === subset.length) {
      return false;
    }
    return subset.every(function (value) {
      return (superset.indexOf(value) >= 0);
   
    });
  },
  fontLoader: (fontt) => {

    let fonttSplit = fontt.split(':');

    switch (fonttSplit[0]) {
      case 'google':
        if (window.WebFont) {
          window.WebFont.load({
            google: {
              families: [fonttSplit[1] + ':100,200,300,400,500,600,700,800,900']
            }
          });
        } else {
          message.error( "Please Check Internet Connection 1" );
        }
        break;
      case 'typekit':
        break;
      case 'custom':
        if (window.WebFont) {
          window.WebFont.load({
            custom: {
              families: [fonttSplit[1]],
              urls: [window.typehub_fonts.custom[fonttSplit[1]] ?  window.typehub_fonts.custom[fonttSplit[1]].src : '']
            },
            timeout: 2000
          });
        } else {
          message.error( "Please Check Internet Connection 3" );
        }
        break;
      case 'schemes':
        this.fontLoader( fonttSplit[1] )
        break;
        default:
        break;

    }

  },
  postProcessSavedValues: function (savedValues, fieldConfig) {

    for (var option of Object.keys(savedValues)) {
      for (var field of Object.keys(savedValues[option])) {
        if (fieldConfig.hasOwnProperty(field) && fieldConfig[field].type === 'number') {
          if (typeof savedValues[option][field] === 'object' && !savedValues[option][field].value) {
            var valueBuffer = null, flag = false;
            for (var device of Object.keys(savedValues[option][field])) {
              valueBuffer = valueBuffer || device;

              if (flag && savedValues[option][field][valueBuffer].value === savedValues[option][field][device].value &&
                savedValues[option][field][valueBuffer].unit === savedValues[option][field][device].unit
              ) {
                if ( device !== 'mobile' ) {
                  delete savedValues[option][field][device];
                }
              } else {
                valueBuffer = device;
              }
              flag = true;
            }
          }
        }
      }
    }
    return savedValues;
  },
  getUsedGoogleFonts:function(savedValues, fontSchemes){
    var usedFonts = [];
    for(var value of Object.keys( savedValues ) ) {
      if( savedValues[value].hasOwnProperty('font-family') ){
        let temp = savedValues[value]['font-family'].split( ':' );
        if( 'google' === temp[0] ){
          if( !usedFonts.includes( temp[1] ) ){
            usedFonts.push( temp[1] );
          }
        }else if( 'schemes' === temp[0] ){
          let temp1 = fontSchemes[temp[1]].fontFamily.split(':');
          if( 'google' === temp1[0] ){
            if( !usedFonts.includes( temp1[1] ) ){
              usedFonts.push( temp1[1] );
            }
          }
        }
      }
		}
  return usedFonts;
  },
  intersect:function(a, b) {
    var t;
    if (b.length > a.length) t = b, b = a, a = t; // indexOf to loop over shorter
    return a.filter(function (e) {
        return b.indexOf(e) > -1;
    });
},
removeContentsOfArray:function(myArray,toRemove){
    return myArray.filter( ( el ) => !toRemove.includes( el ) );
},
getColorValue : function(value){
  if( value ){
    if( typeof value === 'string' ){
        return value;
    } else if( typeof value === 'object' && window.colorhub ) {
        var id = value.id;

        if( id ){
            var idArr = id.split(':');
            if( idArr[0] === 'swatch' ){
                var swatches = window.colorhub.swatches;
                return swatches[idArr[1]] ? swatches[idArr[1]].color : '';    
            }else if( idArr[0] === 'palette' ) {
                var palettes = window.colorhub.palettes,
                currentPalette = palettes.allPalettes[palettes.currentPalette];

                return currentPalette[idArr[1]];
            }
            
        } else {
            return value.solid.color;
        }
    }
  }
}
};
