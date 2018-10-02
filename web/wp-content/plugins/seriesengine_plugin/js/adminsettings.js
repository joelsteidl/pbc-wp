jQuery(document).ready(function() { /* ----- Series Engine - Admin JavaScript ----- */
	jQuery('#audiobg, #audioprog, #explorertitletext, #pagebuttonbg, #gridrowbg, #playerbordercolor, #gridrowtitle, #gridrowbible, #gridrowfile, #gridrowmediabg, #gridrowmediatext, #pagebuttontext, #pagenumber, #pagenumberselectedbg, #pagenumberselectedtext, #explorerbackground, #explorerselectborder, #explorerselect, #explorerselecttext, #explorerbutton, #explorerbuttontext, #mstitletext, #msdatetext, #playerselectedtabbackground, #playerselectedtabtext, #playertabbackground, #playertabtext, #playerdetailsbackground, #detailstext, #detailstitletext, #detailsrelatedtext, #detailslinks, #downloadsbg, #downloadsspacer, #downloadlinks, #sharebuttonbackground, #sharebuttontext, #sharelinkbackground, #sharelinktext, #sharelinkbuttonbackground, #sharelinkbuttontext, #comptitletext, #compoddrow, #comprowtitletext, #compaltrowtitletext, #comprowdatetext, #compaltrowdatetext, #complinks, #loadingbackground, #loadingtext, #archivetitle, #archiverow, #archiveseriestitle, #archivedatecount, #archivelinks, #poweredbytext').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			jQuery(el).val(hex);
			jQuery(el).ColorPickerHide();
			var eleid = jQuery(el).attr("id");
			var ccolor = jQuery(el).attr("value");
			jQuery('#c-'+eleid).css("background-color","#"+ccolor);
		},
		onBeforeShow: function () {
			jQuery(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		jQuery(this).ColorPickerSetColor(this.value);
	});
	
	jQuery('.se-colorfield').change(function() {
		var eleid = jQuery(this).attr("id");
		var color = jQuery(this).attr("value");
		jQuery('#c-'+eleid).css("background-color","#"+color);
	});

	jQuery('#responsivemobile').change(function() {
		var color = jQuery(this).attr("value");
		jQuery('#mobilenumber').html(color);
	});

	jQuery('#responsivefull').change(function() {
		var color = jQuery(this).attr("value");
		jQuery('#fullnumber').html(color);
	});
	
	jQuery('#enmse-settings-general').click(function() {
		jQuery('#enmse-settings-general').parent().addClass('selected');
		jQuery('#enmse-settings-styles').parent().removeClass('selected');
		jQuery('#enmse-settings-labels').parent().removeClass('selected');
		jQuery('#enmse-settings-archivesection').parent().removeClass('selected');
		jQuery("#enmse-style-settings").hide();
		jQuery("#enmse-label-settings").hide();
		jQuery("#enmse-general-settings").show();
		jQuery("#enmse-archivesection-settings").hide();
	});
	
	jQuery('#enmse-settings-styles').click(function() { 
		jQuery('#enmse-settings-general').parent().removeClass('selected');
		jQuery('#enmse-settings-styles').parent().addClass('selected');
		jQuery('#enmse-settings-labels').parent().removeClass('selected');
		jQuery('#enmse-settings-archivesection').parent().removeClass('selected');
		jQuery("#enmse-style-settings").show();
		jQuery("#enmse-label-settings").hide();
		jQuery("#enmse-general-settings").hide();
		jQuery("#enmse-archivesection-settings").hide();				
	});

	jQuery('#enmse-settings-labels').click(function() { 
		jQuery('#enmse-settings-general').parent().removeClass('selected');
		jQuery('#enmse-settings-styles').parent().removeClass('selected');
		jQuery('#enmse-settings-labels').parent().addClass('selected');
		jQuery('#enmse-settings-archivesection').parent().removeClass('selected');
		jQuery("#enmse-style-settings").hide();
		jQuery("#enmse-label-settings").show();
		jQuery("#enmse-general-settings").hide();
		jQuery("#enmse-archivesection-settings").hide();				
	});

	jQuery('#enmse-settings-archivesection').click(function() { 
		jQuery('#enmse-settings-general').parent().removeClass('selected');
		jQuery('#enmse-settings-styles').parent().removeClass('selected');
		jQuery('#enmse-settings-labels').parent().removeClass('selected');
		jQuery('#enmse-settings-archivesection').parent().addClass('selected');
		jQuery("#enmse-style-settings").hide();
		jQuery("#enmse-label-settings").hide();
		jQuery("#enmse-general-settings").hide();
		jQuery("#enmse-archivesection-settings").show();				
	});
	
	function limitText(limitField, limitCount, limitNum) {
		if (limitField.value.length > limitNum) {
			limitField.value = limitField.value.substring(0, limitNum);
		} else {
			limitCount.value = limitNum - limitField.value.length;
		}
	}

	// Upload Series Graphic for Archives
  jQuery('.enmse-upload-series-placeholder').click( function( event ){

  	var file_frame;

 	  var getthumbsize = jQuery("#enmsearchivethumb").val();
    event.preventDefault();
 
    if ( file_frame ) {
      file_frame.open();
      return;
    }
 
    file_frame = wp.media.frames.file_frame = wp.media({
      title: "Choose a Graphic to Use as a Placeholder",
      button: {
        text: "Set Graphic",
      },
      multiple: false 
    });
 
    file_frame.on( 'select', function() {
      attachment = file_frame.state().get('selection').first().toJSON();
      var checkfororig = attachment.width;
		  if ( checkfororig > getthumbsize ) {
			   if (attachment.sizes["Series Engine Graphic Thumb"]) { 
      			jQuery('#placeholderimage').val(attachment.sizes["Series Engine Graphic Thumb"]["url"]);
      			jQuery("#placeholderimage-thumb-load").html('<br /><img src="' + attachment.sizes["Series Engine Graphic Thumb"]["url"] + '" />');
      		} else {
      			alert("This image was uploaded before you installed or updated Series Engine. You'll need to reupload the image so Series Engine can generate an image that's the correct size.");
      		};
      	} else if ( checkfororig == getthumbsize ) {
      		jQuery('#placeholderimage').val(attachment.url);
      		jQuery("#placeholderimage-thumb-load").html('<br /><img src="' + attachment.url + '" />');
      	} else {
      		alert("Please upload an image that's at least " + getthumbsize + "px wide.");
      	};
    });
 
    file_frame.open();
  });
});