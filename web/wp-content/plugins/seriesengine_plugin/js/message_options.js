jQuery(document).ready(function(){ /* ----- Series Engine - JavaScript for Messages functions ----- */
	
	jQuery('#enmse-message-general').click(function() {
		jQuery('#enmse-message-general').parent().addClass('selected');
		jQuery('#enmse-message-video').parent().removeClass('selected');
		jQuery('#enmse-message-podcast').parent().removeClass('selected');
		jQuery('#enmse-message-files').parent().removeClass('selected');
		jQuery('#enmse-message-scripture').parent().removeClass('selected');
		jQuery("#enmse-additional-video").hide();
		jQuery("#enmse-basic-information").show();				
		jQuery("#enmse-podcast-content").hide();
		jQuery("#enmse-related-files").hide();
		jQuery("#enmse-scripture").hide();
	});
	
	jQuery('#enmse-message-video').click(function() { 
		jQuery('#enmse-message-general').parent().removeClass('selected');
		jQuery('#enmse-message-video').parent().addClass('selected');
		jQuery('#enmse-message-podcast').parent().removeClass('selected');
		jQuery('#enmse-message-files').parent().removeClass('selected');
		jQuery('#enmse-message-scripture').parent().removeClass('selected');
		jQuery("#enmse-additional-video").show();
		jQuery("#enmse-basic-information").hide();				
		jQuery("#enmse-podcast-content").hide();
		jQuery("#enmse-related-files").hide();
		jQuery("#enmse-scripture").hide();
	});
	
	jQuery('#enmse-message-podcast').click(function() { 
		jQuery('#enmse-message-general').parent().removeClass('selected');
		jQuery('#enmse-message-video').parent().removeClass('selected');
		jQuery('#enmse-message-podcast').parent().addClass('selected');
		jQuery('#enmse-message-files').parent().removeClass('selected');
		jQuery('#enmse-message-scripture').parent().removeClass('selected');
		jQuery("#enmse-additional-video").hide();
		jQuery("#enmse-basic-information").hide();				
		jQuery("#enmse-podcast-content").show();
		jQuery("#enmse-related-files").hide();
		jQuery("#enmse-scripture").hide();
	});
	
	jQuery('#enmse-message-files').click(function() { 
		jQuery('#enmse-message-general').parent().removeClass('selected');
		jQuery('#enmse-message-video').parent().removeClass('selected');
		jQuery('#enmse-message-podcast').parent().removeClass('selected');
		jQuery('#enmse-message-files').parent().addClass('selected');
		jQuery('#enmse-message-scripture').parent().removeClass('selected');
		jQuery("#enmse-additional-video").hide();
		jQuery("#enmse-basic-information").hide();				
		jQuery("#enmse-podcast-content").hide();
		jQuery("#enmse-related-files").show();
		jQuery("#enmse-scripture").hide();
	});

	jQuery('#enmse-message-scripture').click(function() { 
		jQuery('#enmse-message-general').parent().removeClass('selected');
		jQuery('#enmse-message-video').parent().removeClass('selected');
		jQuery('#enmse-message-podcast').parent().removeClass('selected');
		jQuery('#enmse-message-files').parent().removeClass('selected');
		jQuery('#enmse-message-scripture').parent().addClass('selected');
		jQuery("#enmse-additional-video").hide();
		jQuery("#enmse-basic-information").hide();				
		jQuery("#enmse-podcast-content").hide();
		jQuery("#enmse-related-files").hide();
		jQuery("#enmse-scripture").show();
	});
	
	jQuery("#message_audio_url").change(function() {
		var audiovalue = jQuery(this).val();
		jQuery("#message_audio_url_dummy").val(audiovalue);
	});
	
	jQuery("#message_audio_url_dummy").change(function() {
		var audiovaluetwo = jQuery(this).val();
		jQuery("#message_audio_url").val(audiovaluetwo);
	});
	
	jQuery("#message_speaker").live("change", function() {
		var speakervalue = jQuery(this).val();
		if ( speakervalue == "n" ) {
			jQuery('#newspeakersection').show();
		} else {
			jQuery('#newspeakersection').hide();
		};
		jQuery("#message_audio_url_dummy").val(audiovalue);
	});
	
	function limitText(limitField, limitCount, limitNum) {
		if (limitField.value.length > limitNum) {
			limitField.value = limitField.value.substring(0, limitNum);
		} else {
			limitCount.value = limitNum - limitField.value.length;
		}
	}
	
	jQuery('#addnewtopic').live("click", function() { 
		var newtopicname = jQuery("#topic_name").val();
		var newtopiclength = jQuery("#topic_name").val().length;
		if (newtopiclength >= 1) {
			var formdata = jQuery("#enmseform").serialize();
			var findurl = jQuery('#enmsepluginurl').val();
			var serandom = Math.floor(Math.random()*1001);
			var encodedval = encodeURIComponent(newtopicname);
			var urltoload = findurl+"?topicname="+encodedval+"&enmse_random="+serandom;

			function loadrefreshedtopiclist() {
				jQuery("#topic_name").val('');
				jQuery('#enmse-topiclist').append(jQuery('<div>').load(urltoload));
			};
			jQuery.post(urltoload, formdata, loadrefreshedtopiclist);
		};
		
		return false;
	});

	function sescroll(){
	    var tag = jQuery("#enmse-message-options");
	    if (navigator.userAgent.indexOf("Chrome") != -1 ) {
	    	jQuery("html").animate({scrollTop: tag.offset().top}, 400, function() {
		    	jQuery("html").clearQueue();
		    });
	    } else {
	    	jQuery("body").animate({scrollTop: tag.offset().top}, 400, function() {
		    	jQuery("body").clearQueue();
		    });
	    } 
	}

	function sscrolldown(){
	    var tag = jQuery("#enmsescripturearea");
	    if (navigator.userAgent.indexOf("Chrome") != -1 ) {
	    	jQuery("html").animate({scrollTop: tag.offset().top}, 400, function() {
		    	jQuery("html").clearQueue();
		    });
	    } else {
	    	jQuery("body").animate({scrollTop: tag.offset().top}, 400, function() {
		    	jQuery("body").clearQueue();
		    });
	    } 
	}

	function fscrolldown(){
	    var tag = jQuery("#enmsefilearea");
	    if (navigator.userAgent.indexOf("Chrome") != -1 ) {
	    	jQuery("html").animate({scrollTop: tag.offset().top}, 400, function() {
		    	jQuery("html").clearQueue();
		    });
	    } else {
	    	jQuery("body").animate({scrollTop: tag.offset().top}, 400, function() {
		    	jQuery("body").clearQueue();
		    });
	    } 
	}
	
	jQuery('#addnewspeaker').live("click", function() { 
		var newspeakerfirst = jQuery("#speaker_first_name").val();
		var newspeakerlast = jQuery("#speaker_last_name").val();
		var newspeakerlength = jQuery("#speaker_first_name").val().length;
		if (newspeakerlength >= 1) {
			if ( newspeakerfirst == "First" || newspeakerlast == "Last" ) {
				return false;
			} else {
				var formdata = jQuery("#enmseform").serialize();
				var findurl = jQuery('#enmsespeakerurl').val();
				var serandom = Math.floor(Math.random()*1001);
				var encodedvalone = encodeURIComponent(newspeakerfirst);
				var encodedvaltwo = encodeURIComponent(newspeakerlast);
				var urltoload = findurl+"?firstname="+encodedvalone+"&lastname="+encodedvaltwo+"&enmse_random="+serandom;
				
				function loadrefreshedspeakerlist() {
					jQuery('#newspeakersection').hide();
					jQuery("#speaker_first_name").val('First');
					jQuery("#speaker_last_name").val('Last');
					jQuery("#speaker_first_name").css('color','#cbcbcb');
					jQuery("#speaker_last_name").css('color','#cbcbcb');
					jQuery('#message_speaker').load(urltoload);
				};
				jQuery.post(urltoload, formdata, loadrefreshedspeakerlist);
			};
		};
		return false;
	});
	
	jQuery('#addnewfile').live("click", function() {
		var newfilename = jQuery("#file_name").val();
		var newfileurl = jQuery("#file_url").val();
		var newfilenewwindow = jQuery("#file_new_window").val();
		if ( jQuery("#file_featured").is(":checked") ) {
			var newfilefeatured = 1;
		} else {
			var newfilefeatured = 0;
		};
		var messageid = jQuery("#enmsemid").val();
		var fileusername = jQuery("#file_username").val();
		var newfilenamelength = jQuery("#file_name").val().length;
		var newfileurllength = jQuery("#file_url").val().length;
		if (newfilenamelength >= 1 && newfileurllength >= 1 ) {
				var formdata = jQuery("#enmseform").serialize();
				var findurl = jQuery('#enmsefileurl').val();
				var serandom = Math.floor(Math.random()*1001);
				var encodedvalthree = messageid;
				var encodedvalfour = encodeURIComponent(fileusername);
				var encodedvalone = encodeURIComponent(newfilename);
				var encodedvaltwo = encodeURIComponent(newfileurl);
				var encodedvalfive = encodeURIComponent(newfilenewwindow);
				var encodedvalsix = encodeURIComponent(newfilefeatured);
				var urltoload = findurl+"?file_name="+encodedvalone+"&file_url="+encodedvaltwo+"&file_new_window="+encodedvalfive+"&file_username="+encodedvalfour+"&message_id="+encodedvalthree+"&featured="+encodedvalsix+"&enmse_random="+serandom+"&new=1";
				var urltoloadtwo = findurl+"?file_name="+encodedvalone+"&file_url="+encodedvaltwo+"&file_new_window="+encodedvalfive+"&file_username="+encodedvalfour+"&message_id="+encodedvalthree+"&featured="+encodedvalsix+"&enmse_random="+serandom;
				function loadrefreshedfilelist() {
					jQuery("#file_name").val('');
					jQuery("#file_url").val('');
					jQuery('#enmsefilearea').load(urltoloadtwo);
					jQuery('#file_featured').attr('checked', false);
				};
				jQuery.post(urltoload, formdata, loadrefreshedfilelist);
				fscrolldown()
		};
		return false;
	});
	
	jQuery('#editfile').live("click", function() { 
		var newfilename = jQuery("#file_name").val();
		var newfileurl = jQuery("#file_url").val();
		var newfilenewwindow = jQuery("#file_new_window").val();
		if ( jQuery("#file_featured").is(":checked") ) {
			var newfilefeatured = 1;
		} else {
			var newfilefeatured = 0;
		};
		var fileid = jQuery("#file_id").val();
		var fileusername = jQuery("#file_username").val();
		var messageid = jQuery("#enmsemid").val();
		var newfilenamelength = jQuery("#file_name").val().length;
		var newfileurllength = jQuery("#file_url").val().length;
		if (newfilenamelength >= 1 && newfileurllength >= 1 ) {
				var formdata = jQuery("#enmseform").serialize();
				var findurl = jQuery('#enmsefileedit').val();
				var serandom = Math.floor(Math.random()*1001);
				var anotherfindurl = jQuery('#enmsefileurl').val();
				var encodedvalone = encodeURIComponent(newfilename);
				var encodedvaltwo = encodeURIComponent(newfileurl);
				var encodedvalfive = encodeURIComponent(newfilenewwindow);
				var encodedvalthree = fileid;
				var encodedvalfour = encodeURIComponent(fileusername);
				var encodedvalsix = encodeURIComponent(newfilefeatured);
				var urltoload = findurl+"?file_name="+encodedvalone+"&file_url="+encodedvaltwo+"&file_new_window="+encodedvalfive+"&file_username="+encodedvalfour+"&fid="+encodedvalthree+"&mid="+messageid+"&featured="+encodedvalsix+"&enmse_random="+serandom+"&update=1";
				var anotherurltoload = anotherfindurl+"?message_id="+messageid+"&file_username="+encodedvalfour+"&featured="+encodedvalsix+"&enmse_random="+serandom;

				function loadrefreshedfilelist() {
					jQuery('#enmsefileform').load(urltoload+"&done=1");
					jQuery('#enmsefilearea').load(anotherurltoload+"&done=1");
				};
				jQuery.post(urltoload, formdata, loadrefreshedfilelist);
				fscrolldown()
		};
		return false;
	});
	
	jQuery('.seriesengine_filedelete').live("click", function() {
		var answer = confirm("Are you SURE you want to remove this link/download from this Message? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			var f = jQuery(this).attr("rel");
			if ( f == 1 ) {
				var featured = "&f=1"
			} else {
				var featured = "";
			};
			var messageid = jQuery("#enmsemid").val();
			var formdata = jQuery("#enmseform").serialize();
			var findurl = jQuery('#enmsefiledelete').val();
			var serandom = Math.floor(Math.random()*1001);
			var urltoload = findurl+"?did="+id+"&mid="+messageid+featured+"&enmse_random="+serandom;
			
			function loadrefreshedfilelist() {
				jQuery("#row_"+id).fadeOut();
			};
			jQuery.post(urltoload, formdata, loadrefreshedfilelist);
		};
		return false;
	});
	
	jQuery('.seriesengine_editfile').live("click", function() {
		var id = jQuery(this).attr("name");
		var findurl = jQuery('#enmsefileedit').val();
		var username = jQuery('#file_username').val();
		var serandom = Math.floor(Math.random()*1001);
		var urltoload = findurl+"?fid="+id+"&file_username="+username+"&enmse_random="+serandom;
		jQuery('#enmsefileform').load(urltoload);
		sescroll();
		return false;
	});

	jQuery('#addnewscripture').live("click", function() {
		var newbook = jQuery("#scripture_start_book").val();
		var newchapter = jQuery("#scripture_start_chapter").val();
		var newstartverse = jQuery("#scripture_start_verse").val();
		var newendverse = jQuery("#scripture_end_verse").val();
		var newtrans = jQuery("#scripture_trans").val();
		if ( jQuery("#scripture_focus").is(":checked") ) {
			var newfocus = 1;
		} else {
			var newfocus = 0;
		};
		var messageid = jQuery("#enmsemid").val();
		var scriptureusername = jQuery("#scripture_username").val();
		if ( (newchapter == "" || newchapter == "Chapter") || (newstartverse == "" || newstartverse == "Verse") || (newendverse == "" || newendverse == "Verse") ) {
			alert("Please supply more information about your scripture reference.");
		} else {
			var formdata = jQuery("#enmseform").serialize();
				var findurl = jQuery('#enmsescriptureurl').val();
				var serandom = Math.floor(Math.random()*1001);
				var encodedvalthree = messageid;
				var valbook = encodeURIComponent(newbook);
				var valchapter = encodeURIComponent(newchapter);
				var valverse = encodeURIComponent(newstartverse);
				var valendverse = encodeURIComponent(newendverse);
				var valtrans = encodeURIComponent(newtrans);
				var valfocus = encodeURIComponent(newfocus);
				var valusername = encodeURIComponent(scriptureusername);
				var urltoload = findurl+"?start_book="+valbook+"&start_chapter="+valchapter+"&start_verse="+valverse+"&end_verse="+valendverse+"&trans="+valtrans+"&focus="+valfocus+"&username="+valusername+"&message_id="+encodedvalthree+"&enmse_random="+serandom+"&new=1";
				var urltoloadtwo = findurl+"?start_book="+valbook+"&start_chapter="+valchapter+"&start_verse="+valverse+"&end_verse="+valendverse+"&trans="+valtrans+"&focus="+valfocus+"&username="+valusername+"&message_id="+encodedvalthree+"&enmse_random="+serandom;
				function loadrefreshedfilelist() {
					jQuery("#scripture_start_chapter").val('Chapter').css('color','#bebebe');
					jQuery("#scripture_start_verse").val('Verse').css('color','#bebebe');
					jQuery("#scripture_end_chapter").val('Chapter').css('color','#bebebe');
					jQuery("#scripture_end_verse").val('Verse').css('color','#bebebe');
					jQuery('#enmsescripturearea').load(urltoloadtwo);
					jQuery('#scripture_focus').attr('checked', false);
				};
				jQuery.post(urltoload, formdata, loadrefreshedfilelist);
				sscrolldown();
		};
		return false;
	});

	jQuery('#editscripture').live("click", function() { 
		var newbook = jQuery("#scripture_start_book").val();
		var newchapter = jQuery("#scripture_start_chapter").val();
		var newstartverse = jQuery("#scripture_start_verse").val();
		var newendverse = jQuery("#scripture_end_verse").val();
		var newtrans = jQuery("#scripture_trans").val();
		if ( jQuery("#scripture_focus").is(":checked") ) {
			var newfocus = 1;
		} else {
			var newfocus = 0;
		};
		var scriptureid = jQuery("#scripture_id").val();
		var messageid = jQuery("#enmsemid").val();
		var scriptureusername = jQuery("#scripture_username").val();
		if ( (newchapter == "" || newchapter == "Chapter") || (newstartverse == "" || newstartverse == "Verse") || (newendverse == "" || newendverse == "Verse") ) {
			alert("Please supply more information about your scripture reference.");
		} else {
			var formdata = jQuery("#enmseform").serialize();
			var findurl = jQuery('#enmsescriptureedit').val();
			var anotherfindurl = jQuery('#enmsescriptureurl').val();
			var serandom = Math.floor(Math.random()*1001);
			var encodedvalthree = messageid;
			var valbook = encodeURIComponent(newbook);
			var valchapter = encodeURIComponent(newchapter);
			var valverse = encodeURIComponent(newstartverse);
			var valendverse = encodeURIComponent(newendverse);
			var valtrans = encodeURIComponent(newtrans);
			var valfocus = encodeURIComponent(newfocus);
			var valusername = encodeURIComponent(scriptureusername);
			var urltoload = findurl+"?start_book="+valbook+"&start_chapter="+valchapter+"&start_verse="+valverse+"&end_verse="+valendverse+"&trans="+valtrans+"&focus="+valfocus+"&username="+valusername+"&message_id="+encodedvalthree+"&scripture_id="+scriptureid+"&enmse_random="+serandom+"&update=1";
			var anotherurltoload = anotherfindurl+"?message_id="+messageid+"&username="+valusername+"&focus="+valfocus+"&enmse_random="+serandom;
			function loadrefreshedfilelist() {
				jQuery('#enmsescriptureform').load(urltoload+"&done=1");
				jQuery('#enmsescripturearea').load(anotherurltoload+"&done=1");
			};
			jQuery.post(urltoload, formdata, loadrefreshedfilelist);
			sscrolldown();
		};
		return false;
	});

	jQuery('.seriesengine_editscripture').live("click", function() {
		var id = jQuery(this).attr("name");
		var findurl = jQuery('#enmsescriptureedit').val();
		var username = jQuery('#scripture_username').val();
		var serandom = Math.floor(Math.random()*1001);
		var urltoload = findurl+"?scripture_id="+id+"&username="+username+"&enmse_random="+serandom;
		jQuery('#enmsescriptureform').load(urltoload);
		sescroll();
		return false;
	});

	jQuery('.seriesengine_scripturedelete').live("click", function() {
		var answer = confirm("Are you SURE you want to remove this scripture reference from this Message? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			var f = jQuery(this).attr("rel");
			if ( f == 1 ) {
				var featured = "&f=1"
			} else {
				var featured = "";
			};
			var messageid = jQuery("#enmsemid").val();
			var formdata = jQuery("#enmseform").serialize();
			var findurl = jQuery('#enmsescripturedelete').val();
			var serandom = Math.floor(Math.random()*1001);
			var urltoload = findurl+"?did="+id+"&mid="+messageid+featured+"&enmse_random="+serandom;
			
			function loadrefreshedfilelist() {
				jQuery("#row_"+id).fadeOut();
			};
			jQuery.post(urltoload, formdata, loadrefreshedfilelist);
		};
		return false;
	});

	jQuery("#scripture_start_book").live("change", function() {
		var thisval = jQuery(this).val();

		jQuery("#scripture_start_book > option").each(function() {
    		var theval = jQuery(this).val();
    		if ( theval == thisval ) {
    			jQuery("#scripture_end_book > option[value="+theval+"]").prop("selected","selected");
    		};
		});
	});

	jQuery("#scripture_start_chapter").live("change", function() {
		var thisval = jQuery(this).val();

		if ( thisval != "" ) {
			if ( jQuery("#scripture_end_chapter").val() == "Chapter" ) {
				jQuery("#scripture_end_chapter").val(thisval).css('color','#bebebe');
			};
		} else {
			jQuery("#scripture_end_chapter").val("Chapter").css('color','#bebebe');
			jQuery(this).val('Chapter');
			jQuery(this).css('color','#bebebe');
		};
	});

	jQuery("#scripture_start_verse").live("change", function() {
		var thisval = jQuery(this).val();

		if ( thisval != "" ) {
			if ( jQuery("#scripture_end_verse").val() == "Verse" ) {
				jQuery("#scripture_end_verse").val(thisval).css('color','#000000');
			};
		} else {
			if ( jQuery("#scripture_end_verse").val() == "Verse" ) {
				jQuery("#scripture_end_verse").val("Verse").css('color','#bebebe');
			};
			jQuery(this).val('Verse');
			jQuery(this).css('color','#bebebe');
		};
	});

	jQuery("#scripture_start_chapter").live("focus", function () {
		if ( jQuery(this).val() == "Chapter" ) {
			jQuery(this).val('');
			jQuery(this).css('color','#000000');
		};
	});

	jQuery("#scripture_start_chapter").live("focusout", function () {
		if ( jQuery(this).val() == "" ) {
			jQuery(this).val('Chapter');
			jQuery(this).css('color','#bebebe');
		};
	});

	jQuery("#scripture_start_verse").live("focus", function () {
		if ( jQuery(this).val() == "Verse" ) {
			jQuery(this).val('');
			jQuery(this).css('color','#000000');
		};
	});

	jQuery("#scripture_start_verse").live("focusout", function () {
		if ( jQuery(this).val() == "" ) {
			jQuery(this).val('Verse');
			jQuery(this).css('color','#bebebe');
		};
	});

	jQuery("#scripture_end_verse").live("focus", function () {
		if ( jQuery(this).val() == "Verse" ) {
			jQuery(this).val('');
			jQuery(this).css('color','#000000');
		};
	});

	jQuery("#scripture_end_verse").live("focusout", function () {
		if ( jQuery(this).val() == "" ) {
			jQuery(this).val('Verse');
			jQuery(this).css('color','#bebebe');
		};
	});
	
	jQuery("#speaker_first_name").focus(function () {
		jQuery(this).val('');
		jQuery(this).css('color','#000000');
	});
	
	jQuery("#speaker_last_name").focus(function () {
		jQuery(this).val('');
		jQuery(this).css('color','#000000');
	});

	// Upload Message Graphic
	  jQuery('.enmse-upload-message-graphic').click( function( event ){

	  	var file_frame;

	  	var getthumbsize = jQuery("#enmsethumb").val();
	 
	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose a Graphic for Your Message",
	      button: {
	        text: "Set Graphic",
	      },
	      multiple: false
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();

	      var checkfororig = attachment.width;
		  if ( checkfororig > getthumbsize ) {
			   if (attachment.sizes["Series Engine Graphic"]) { 
	      			jQuery('#message_thumbnail').val(attachment.sizes["Series Engine Graphic"]["url"]);
					jQuery("#message-thumb-load").html('<br /><img src="' + attachment.sizes["Series Engine Graphic"]["url"] + '" />');
      		   } else {
            		alert("Just FYI, you uploaded this image before you installed Series Engine, but it may not be large enough (according to your settings in Settings > Series Engine). You can still use it, but it may not look the best on your site.");
      		   		jQuery('#message_thumbnail').val(attachment.sizes["full"]["url"]);
					jQuery("#message-thumb-load").html('<br /><img src="' + attachment.sizes["full"]["url"] + '" />');
      		   };
      	  } else if ( checkfororig == getthumbsize ) {
	           jQuery('#message_thumbnail').val(attachment.url);
			   jQuery("#message-thumb-load").html('<br /><img src="' + attachment.url + '" />');
      	  } else {
      	       alert("Please upload an image that's at least " + getthumbsize + "px wide.");
      	  };

	    });
	 
	    file_frame.open();
	  });

	  // Upload Message Files
	  jQuery('.enmse-upload-message-file').click( function( event ){

	  	var file_frame;
	 
	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose or Upload a File to WordPress",
	      button: {
	        text: "Select File",
	      },
	      multiple: false
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();
	      jQuery('#file_url').val(attachment.url);
	    });
	 
	    file_frame.open();
	  });

	  // Upload Message Files
	  jQuery('.enmse-upload-message-audio').click( function( event ){

	  	var file_frame;
	 
	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose an Audio File",
	      button: {
	        text: "Select File",
	      },
	      multiple: false
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();
	      //alert(JSON.stringify(attachment, null, 4));

	      if ( attachment.type == "audio" ) {
	      	jQuery('#message_audio_url').val(attachment.url);
	      	jQuery('#message_audio_url_dummy').val(attachment.url);
	      } else {
	      	alert("Please upload or select an audio file.")
	      };
	      
	    });
	 
	    file_frame.open();
	  });

	  jQuery('.enmse-upload-message-podcast-audio').click( function( event ){

	  	var file_frame;
	 
	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose an Audio File",
	      button: {
	        text: "Select File",
	      },
	      multiple: false
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();
	      //alert(JSON.stringify(attachment, null, 4));

	      if ( attachment.type == "audio" ) {
	      	jQuery('#message_audio_url').val(attachment.url);
	      	jQuery('#message_audio_url_dummy').val(attachment.url);
	      } else {
	      	alert("Please upload or select an audio file.")
	      };
	      
	    });
	 
	    file_frame.open();
	  });

	  // Upload Message Files
	  jQuery('.enmse-upload-message-video').click( function( event ){

	  	var file_frame;
	 
	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose a Video File",
	      button: {
	        text: "Select File",
	      },
	      multiple: false
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();
	      //alert(JSON.stringify(attachment, null, 4));

	      if ( attachment.type == "video" ) {
	      	jQuery('#message_video_embed_url').val(attachment.url);
	      } else {
	      	alert("Please upload or select a video file.");
	      	file_frame.open();
	      };
	      
	    });
	 
	    file_frame.open();
	  });

	  // Upload Message Files
	  jQuery('.enmse-upload-message-additional-video').click( function( event ){

	  	var file_frame;
	 
	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose a Video File",
	      button: {
	        text: "Select File",
	      },
	      multiple: false
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();
	      //alert(JSON.stringify(attachment, null, 4));

	      if ( attachment.type == "video" ) {
	      	jQuery('#message_additional_video_embed_url').val(attachment.url);
	      } else {
	      	alert("Please upload or select a video file.");
	      	file_frame.open();
	      };
	      
	    });
	 
	    file_frame.open();
	  });

	    // Upload Podcast Graphic
	  jQuery('.enmse-upload-message-podcast-image').click( function( event ){

	    var file_frame;
	    
	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }
	 
	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose an Image for Your Podcasts",
	      button: {
	        text: "Set Image",
	      },
	      multiple: false 
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();
	      var checkfororig = attachment.width;

	      if ( attachment.width < 1400 || attachment.height < 1400 ) {
	        alert("Please upload or choose an image that's at least 1400px x 1400px.");
	      } else {
	        jQuery('#message_podcast_image').val(attachment.url);
	        jQuery("#message-podcast-image-load").html('<br /><img src="' + attachment.url + '" />');
	      };
	    });
	 
	    file_frame.open();
	  });

	jQuery("#message_podcast_image").change(function() {
		var findval = jQuery(this).val();
		if ( findval == "" ) {
			jQuery("#message-podcast-image-load").html('');
		} else {
			jQuery("#message-podcast-image-load").html('<br /><img src="' + findval + '" />');
		};
	});

	  // Find options for Primary Series
	  jQuery(".seriescheck").live("change", function() {
	  	var newoptions = "";
	  	var currentprimary = jQuery("#current_primary_series").attr("value");
	  	var seriestext = jQuery("#series_title_text").attr("value");
	  	jQuery(".seriescheck").each(function() {
	  		var ischecked = jQuery(this).attr("checked");
	  		var optiontext = jQuery(this).attr("title");
	  		var numberval = jQuery(this).attr("value");
	  		if ( ischecked == "checked" ) {
	  			if ( currentprimary != null && numberval == currentprimary ) {
	  				newoptions += "<option value=\"" + numberval +"\" selected=\"selected\">" + optiontext + "</option>";
	  			} else {
	  				newoptions += "<option value=\"" + numberval +"\">" + optiontext + "</option>";
	  			};
	  		};
	  		ischecked = null;
	  		optiontext = null;
	  	});
	  	if ( newoptions == "" ) {
	  		newoptions = "<option value=\"0\">- No " + seriestext +" Assigned -</option>";
	  	};
		jQuery("#message_primary_series").html(newoptions);
	});

	 jQuery("#enmse_filter").live("change", function() {
		selectval = jQuery(this).val();
		url = jQuery("#enmsepluginurl").val();
		if ( selectval == 1 ) {
			jQuery("#enmse_series").show();
			jQuery("#enmse_speakers").hide();
			jQuery("#enmse_topic").hide();
			jQuery("#enmse_book").hide();
		} else if ( selectval == 2 ) {
			jQuery("#enmse_series").hide();
			jQuery("#enmse_speakers").show();
			jQuery("#enmse_topic").hide();
			jQuery("#enmse_book").hide();
		} else if ( selectval == 3 ) {
			jQuery("#enmse_series").hide();
			jQuery("#enmse_speakers").hide();
			jQuery("#enmse_topic").show();
			jQuery("#enmse_book").hide();
		} else if ( selectval == 4 ) {
			jQuery("#enmse_series").hide();
			jQuery("#enmse_speakers").hide();
			jQuery("#enmse_topic").hide();
			jQuery("#enmse_book").show();
		} else {
			window.location.assign(url);
		};
	});

	jQuery(document).on("change", "#enmse_series", function() {
		selectval = jQuery(this).val();
		url = jQuery("#enmsepluginurl").val();
		window.location.assign(url + "&enmse_sid=" + selectval);
	});
	jQuery(document).on("change", "#enmse_speakers", function() {
		selectval = jQuery(this).val();
		url = jQuery("#enmsepluginurl").val();
		window.location.assign(url + "&enmse_spid=" + selectval);
	});
	jQuery(document).on("change", "#enmse_topic", function() {
		selectval = jQuery(this).val();
		url = jQuery("#enmsepluginurl").val();
		window.location.assign(url + "&enmse_tid=" + selectval);
	});
	jQuery(document).on("change", "#enmse_book", function() {
		selectval = jQuery(this).val();
		url = jQuery("#enmsepluginurl").val();
		window.location.assign(url + "&enmse_bid=" + selectval);
	});

});