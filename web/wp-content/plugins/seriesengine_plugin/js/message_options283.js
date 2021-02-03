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
	
	jQuery(document).on("change", "#message_speaker", function() {
		var speakervalue = jQuery(this).val();
		if ( speakervalue == "n" ) {
			jQuery('#newspeakersection').show();
		} else {
			jQuery('#newspeakersection').hide();
		};
	});
	
	function limitText(limitField, limitCount, limitNum) {
		if (limitField.value.length > limitNum) {
			limitField.value = limitField.value.substring(0, limitNum);
		} else {
			limitCount.value = limitNum - limitField.value.length;
		}
	}
	
	jQuery(document).on("click", "#addnewtopic", function() {
		var newtopicname = jQuery("#topic_name").val();
		var newtopiclength = jQuery("#topic_name").val().length;
		if (newtopiclength >= 1) {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxmessagenewtopic',
		            'topicname': newtopicname
		        },
		        success:function(data) {
		        	
		        	jQuery("#topic_name").val('');
					jQuery('#enmse-topiclist').append(jQuery('<div>').html(data));
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
		return false;
	});

	function sescroll(){
	    var tag = jQuery("#enmse-message-options");
	    jQuery("html, body").animate({scrollTop: tag.offset().top}, 400, function() {
	    	jQuery("html, body").clearQueue();
	    });
	}

	function sscrolldown(){
	    var tag = jQuery("#enmsescripturearea");
	    jQuery("html, body").animate({scrollTop: tag.offset().top}, 400, function() {
	    	jQuery("html, body").clearQueue();
	    });
	}

	function fscrolldown(){
	    var tag = jQuery("#enmsefilearea");
	    jQuery("html, body").animate({scrollTop: tag.offset().top}, 400, function() {
	    	jQuery("html, body").clearQueue();
	    });
	}
	
	jQuery(document).on("click", "#addnewspeaker", function() {
		var newspeakerfirst = jQuery("#speaker_first_name").val();
		var newspeakerlast = jQuery("#speaker_last_name").val();
		var newspeakerlength = jQuery("#speaker_first_name").val().length;
		if (newspeakerlength >= 1) {
			if ( newspeakerfirst == "First" || newspeakerlast == "Last" ) {
				return false;
			} else {
				jQuery.ajax({
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxmessagenewspeaker',
			            'firstname': newspeakerfirst,
			            'lastname': newspeakerlast
			        },
			        success:function(data) {
			        	
			        	jQuery('#newspeakersection').hide();
						jQuery("#speaker_first_name").val('First');
						jQuery("#speaker_last_name").val('Last');
						jQuery("#speaker_first_name").css('color','#cbcbcb');
						jQuery("#speaker_last_name").css('color','#cbcbcb');
						jQuery('#message_speaker').html(data);
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			};
		};
		return false;
	});
	
	jQuery(document).on("click", "#addnewfile", function() {
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
				jQuery.ajax({ 
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxmessagenewfile',
			            'file_name': newfilename,
			            'file_url': newfileurl,
			            'file_new_window': newfilenewwindow,
			            'file_username': fileusername,
			            'message_id': messageid,
			            'featured': newfilefeatured,
			            'new': '1'
			        },
			        success:function(data) {
			        	
			        	jQuery("#file_name").val('');
						jQuery("#file_url").val('');
						jQuery('#enmsefilearea').html(data);
						jQuery('#file_featured').attr('checked', false);
						fscrolldown();
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
		};
		return false;
	});
	
	jQuery(document).on("click", "#editfile", function() {
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
				jQuery.ajax({ 
			        url: seajax.ajaxurl, 
			        data: {
			            'action': 'seriesengine_ajaxmessageeditfileform',
			            'file_name': newfilename,
			            'file_url': newfileurl,
			            'file_new_window': newfilenewwindow,
			            'file_username': fileusername,
			            'fid': fileid,
			            'mid': messageid,
			            'featured': newfilefeatured,
			            'update': 1
			        },
			        success:function(data) {
			        	
			        	jQuery('#enmsefileform').html(data);

			        	jQuery.ajax({ 
					        url: seajax.ajaxurl, 
					        data: {
					            'action': 'seriesengine_ajaxmessagenewfile',
					            'file_username': fileusername,
					            'message_id': messageid,
					            'featured': newfilefeatured,
					        },
					        success:function(data) {
					        	
					        	jQuery('#enmsefilearea').html(data);
								fscrolldown();
					        },
					        error: function(errorThrown){
					            console.log(errorThrown);
					        }
					    });
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    }); 
		};
		return false;
	});
	
	jQuery(document).on("click", ".seriesengine_filedelete", function() {
		var answer = confirm("Are you SURE you want to remove this link/download from this Message? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			var f = jQuery(this).attr("rel");
			if ( f == 1 ) {
				var featured = "1"
			} else {
				var featured = "0";
			};
			var messageid = jQuery("#enmsemid").val();
			jQuery.ajax({ 
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxmessagedeletefile',
		            'did': id,
		            'mid': messageid,
		            'f': featured
		        },
		        success:function(data) {
		        	
		        	jQuery("#frow_"+id).fadeOut();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
		return false;
	});
	
	jQuery(document).on("click", ".seriesengine_editfile", function() {
		var id = jQuery(this).attr("name");
		var username = jQuery('#file_username').val();
		jQuery.ajax({ 
	        url: seajax.ajaxurl, 
	        data: {
	            'action': 'seriesengine_ajaxmessageeditfileform',
	            'file_username': username,
	            'fid': id
	        },
	        success:function(data) {
	        	
	        	jQuery('#enmsefileform').html(data);
	        	sescroll();
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });
		return false;
	});

	jQuery(document).on("click", "#addnewscripture", function() {
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
			jQuery.ajax({ 
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxmessagenewscripture',
		            'start_book': newbook,
		            'start_chapter': newchapter,
		            'start_verse': newstartverse,
		            'end_verse': newendverse,
		            'trans': newtrans,
		            'focus': newfocus,
		            'username': scriptureusername,
		            'message_id': messageid,
		            'new': 1
		        },
		        success:function(data) {
		        	
		        	jQuery("#scripture_start_chapter").val('Chapter').css('color','#bebebe');
					jQuery("#scripture_start_verse").val('Verse').css('color','#bebebe');
					jQuery("#scripture_end_chapter").val('Chapter').css('color','#bebebe');
					jQuery("#scripture_end_verse").val('Verse').css('color','#bebebe');
					jQuery('#enmsescripturearea').html(data);
					jQuery('#scripture_focus').attr('checked', false);
					sscrolldown();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
		return false;
	});

	jQuery(document).on("click", "#editscripture", function() {
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
			jQuery.ajax({ 
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxmessageeditscripture',
		            'start_book': newbook,
		            'start_chapter': newchapter,
		            'start_verse': newstartverse,
		            'end_verse': newendverse,
		            'trans': newtrans,
		            'focus': newfocus,
		            'username': scriptureusername,
		            'message_id': messageid,
		            'scripture_id': scriptureid,
		            'update': 1,
		            'done': 1
		        },
		        success:function(data) {
		        	
		        	jQuery('#enmsescriptureform').html(data);

		        	jQuery.ajax({ 
				        url: seajax.ajaxurl, 
				        data: {
				            'action': 'seriesengine_ajaxmessagenewscripture',
				            'focus': newfocus,
				            'username': scriptureusername,
				            'message_id': messageid,
				            'done': 1
				        },
				        success:function(data) {
				        	
				        	jQuery('#enmsescripturearea').html(data);
							sscrolldown();
				        },
				        error: function(errorThrown){
				            console.log(errorThrown);
				        }
				    });
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
		return false;
	});

	jQuery(document).on("click", ".seriesengine_editscripture", function() {
		var id = jQuery(this).attr("name");
		var username = jQuery('#scripture_username').val();
		jQuery.ajax({ 
	        url: seajax.ajaxurl, 
	        data: {
	            'action': 'seriesengine_ajaxmessageeditscripture',
	            'username': username,
	            'scripture_id': id
	        },
	        success:function(data) {
	        	
	        	jQuery('#enmsescriptureform').html(data);
	        	sescroll();
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });
		return false;
	});

	jQuery(document).on("click", ".seriesengine_scripturedelete", function() {
		var answer = confirm("Are you SURE you want to remove this scripture reference from this Message? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			var f = jQuery(this).attr("rel");
			if ( f == 1 ) {
				var featured = "1"
			} else {
				var featured = "0";
			};
			var messageid = jQuery("#enmsemid").val();
			jQuery.ajax({ 
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxmessagedeletescripture',
		            'did': id,
		            'mid': messageid,
		            'f': featured
		        },
		        success:function(data) {
		        	
		        	jQuery("#row_"+id).fadeOut();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
		return false;
	});

	jQuery(document).on("change", "#scripture_start_book", function() {
		var thisval = jQuery(this).val();

		jQuery("#scripture_start_book > option").each(function() {
    		var theval = jQuery(this).val();
    		if ( theval == thisval ) {
    			jQuery("#scripture_end_book > option[value="+theval+"]").prop("selected","selected");
    		};
		});
	});

	jQuery(document).on("change", "#scripture_start_chapter", function() {
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

	jQuery(document).on("change", "#scripture_start_verse", function() {
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

	jQuery(document).on("focus", "#scripture_start_chapter", function() {
		if ( jQuery(this).val() == "Chapter" ) {
			jQuery(this).val('');
			jQuery(this).css('color','#000000');
		};
	});

	jQuery(document).on("focusout", "#scripture_start_chapter", function() {
		if ( jQuery(this).val() == "" ) {
			jQuery(this).val('Chapter');
			jQuery(this).css('color','#bebebe');
		};
	});

	jQuery(document).on("focus", "#scripture_start_verse", function() {
		if ( jQuery(this).val() == "Verse" ) {
			jQuery(this).val('');
			jQuery(this).css('color','#000000');
		};
	});

	jQuery(document).on("focusout", "#scripture_start_verse", function() {
		if ( jQuery(this).val() == "" ) {
			jQuery(this).val('Verse');
			jQuery(this).css('color','#bebebe');
		};
	});

	jQuery(document).on("focus", "#scripture_end_verse", function() {
		if ( jQuery(this).val() == "Verse" ) {
			jQuery(this).val('');
			jQuery(this).css('color','#000000');
		};
	});

	jQuery(document).on("focusout", "#scripture_end_verse", function() {
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
	jQuery(document).on("change", ".seriescheck", function() {
	  	var newoptions = "";
	  	var currentprimary = jQuery("#current_primary_series").attr("value");
	  	var seriestext = jQuery("#series_title_text").attr("value");
	  	jQuery(".seriescheck").each(function() {
	  		if ( jQuery(this).prop("checked") == false ){
	  			var ischecked = "";
	  		} else {
	  			var ischecked = "checked";
	  		};
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

	jQuery(document).on("change", "#enmse_filter", function() {
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