jQuery(document).ready(function() { /* ----- Groups Engine - Admin JavaScript ----- */
	jQuery('#explorerbg, #exploreactionbg, #exploreactiontext, #explorebuttonbg, #creditstext, #explorebuttonbgroll, #explorebuttontext, #filterbg, #filtertext, #filterfieldbg, #filterfieldborder, #filterfieldtext, #filtersubmitbg, #filtersubmittext, #grouplistheadertext, #grouplisttext, #grouplistlink, #grouplistrow, #pagebuttonbg, #pagebuttontext, #pagenumber, #pagenumberselectedbg, #pagenumberselectedtext, #singletitle, #singledetails, #singledetailsbg, #singledetailstext, #singledetailslink, #singledetailslabel, #singledetailssharebg, #singledetailssharebgroll, #singledetailssharetext, #relatedbg, #relatedtext, #relatedlink, #contacttitle, #contactinstructions, #contactformlabel, #contactformfieldbg, #contactformfieldtext, #contactformsubmitbg, #contactformsubmittext, #errorbg, #errortext, #successbg, #successtext, #shareboxbg, #shareboxtext, #shareboxbuttonbg, #shareboxbuttontext, #updatebg, #updatetext, #updatestatustext, #updatelink, #updatenotebg, #updatenotetext, #updateformfieldbg, #updateformfieldtext, #updateformsubmitbg, #updateformsubmittext, #loadingbg, #loadingtext').ColorPicker({
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
	
	jQuery('.ge-colorfield').change(function() {
		var eleid = jQuery(this).attr("id");
		var color = jQuery(this).attr("value");
		jQuery('#c-'+eleid).css("background-color","#"+color);
	});
	
	jQuery('#enmge-settings-general').click(function() {
		jQuery('#enmge-settings-general').parent().addClass('selected');
		jQuery('#enmge-settings-styles').parent().removeClass('selected');
		jQuery('#enmge-settings-labels').parent().removeClass('selected');
		jQuery('#enmge-settings-archivesection').parent().removeClass('selected');
		jQuery("#enmge-style-settings").hide();
		jQuery("#enmge-label-settings").hide();
		jQuery("#enmge-general-settings").show();
		jQuery("#enmge-archivesection-settings").hide();
	});
	
	jQuery('#enmge-settings-styles').click(function() { 
		jQuery('#enmge-settings-general').parent().removeClass('selected');
		jQuery('#enmge-settings-styles').parent().addClass('selected');
		jQuery('#enmge-settings-labels').parent().removeClass('selected');
		jQuery('#enmge-settings-archivesection').parent().removeClass('selected');
		jQuery("#enmge-style-settings").show();
		jQuery("#enmge-label-settings").hide();
		jQuery("#enmge-general-settings").hide();
		jQuery("#enmge-archivesection-settings").hide();				
	});

	jQuery('#enmge-settings-labels').click(function() { 
		jQuery('#enmge-settings-general').parent().removeClass('selected');
		jQuery('#enmge-settings-styles').parent().removeClass('selected');
		jQuery('#enmge-settings-labels').parent().addClass('selected');
		jQuery('#enmge-settings-archivesection').parent().removeClass('selected');
		jQuery("#enmge-style-settings").hide();
		jQuery("#enmge-label-settings").show();
		jQuery("#enmge-general-settings").hide();
		jQuery("#enmge-archivesection-settings").hide();				
	});

	jQuery('#enmge-settings-archivesection').click(function() { 
		jQuery('#enmge-settings-general').parent().removeClass('selected');
		jQuery('#enmge-settings-styles').parent().removeClass('selected');
		jQuery('#enmge-settings-labels').parent().removeClass('selected');
		jQuery('#enmge-settings-archivesection').parent().addClass('selected');
		jQuery("#enmge-style-settings").hide();
		jQuery("#enmge-label-settings").hide();
		jQuery("#enmge-general-settings").hide();
		jQuery("#enmge-archivesection-settings").show();				
	});
	
	function limitText(limitField, limitCount, limitNum) {
		if (limitField.value.length > limitNum) {
			limitField.value = limitField.value.substring(0, limitNum);
		} else {
			limitCount.value = limitNum - limitField.value.length;
		}
	}

	jQuery('.enmge-upload-pointer').click( function( event ){

	  	var file_frame;

	 	var getthumbsize = jQuery("#enmgearchivethumb").val();
	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }
	 
	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose a Graphic to Use as a Pointer",
	      button: {
	        text: "Set Pointer",
	      },
	      multiple: false 
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();
	      var checkfororig = attachment.width;
			  if ( checkfororig > getthumbsize ) {
				   if (attachment.sizes["Groups Engine Pointer"]) { 
	      			jQuery('#pointer').val(attachment.sizes["Groups Engine Pointer"]["url"]);
	      			jQuery("#pointer-load").html('<br /><img src="' + attachment.sizes["Groups Engine Pointer"]["url"] + '" />');
	      		} else {
	      			alert("This image was uploaded before you installed or updated Groups Engine. You'll need to reupload the image so Groups Engine can generate an image that's the correct size.");
	      		};
	      	} else if ( checkfororig == getthumbsize ) {
	      		jQuery('#pointer').val(attachment.url);
	      		jQuery("#pointer-load").html('<br /><img src="' + attachment.url + '" />');
	      	} else {
	      		alert("Please upload an image that's 48x48px wide.");
	      	};
	    });
	 
	    file_frame.open();
	});

	jQuery('.enmge-upload-customloading').click( function( event ){

	  	var file_frame;

	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }
	 
	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose a Graphic to Use as a Loading Image",
	      button: {
	        text: "Set Graphic",
	      },
	      multiple: false 
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();
	      		jQuery('#customloading').val(attachment.url);
	      		jQuery("#customloading-load").html('<br /><img src="' + attachment.url + '" />');
	    });
	 
	    file_frame.open();
	});

	jQuery('.enmge-upload-customloadingretina').click( function( event ){

	  	var file_frame;

	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }
	 
	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose a Graphic to Use as a Retina Loading Image",
	      button: {
	        text: "Set Graphic",
	      },
	      multiple: false 
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();
	      		jQuery('#customloadingretina').val(attachment.url);
	      		jQuery("#customloadingretina-load").html('<br /><img src="' + attachment.url + '" />');
	    });
	 
	    file_frame.open();
	});

});