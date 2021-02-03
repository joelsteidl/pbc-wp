jQuery(document).ready(function(){ /* ----- Groups Engine - JavaScript for Groups functions ----- */
	
	jQuery('#enmge-group-general').click(function() {
		jQuery('#enmge-group-general').parent().addClass('selected');
		jQuery('#enmge-group-details').parent().removeClass('selected');
		jQuery('#enmge-group-location').parent().removeClass('selected');
		jQuery('#enmge-group-files').parent().removeClass('selected');
		jQuery("#enmge-details-area").hide();
		jQuery("#enmge-basic-information").show();				
		jQuery("#enmge-location-area").hide();
		jQuery("#enmge-related-files").hide();
	});
	
	jQuery('#enmge-group-details').click(function() { 
		jQuery('#enmge-group-general').parent().removeClass('selected');
		jQuery('#enmge-group-details').parent().addClass('selected');
		jQuery('#enmge-group-location').parent().removeClass('selected');
		jQuery('#enmge-group-files').parent().removeClass('selected');
		jQuery("#enmge-details-area").show();
		jQuery("#enmge-basic-information").hide();				
		jQuery("#enmge-location-area").hide();
		jQuery("#enmge-related-files").hide();
	});
	
	jQuery('#enmge-group-location').click(function() { 
		jQuery('#enmge-group-general').parent().removeClass('selected');
		jQuery('#enmge-group-details').parent().removeClass('selected');
		jQuery('#enmge-group-location').parent().addClass('selected');
		jQuery('#enmge-group-files').parent().removeClass('selected');
		jQuery("#enmge-details-area").hide();
		jQuery("#enmge-basic-information").hide();				
		jQuery("#enmge-location-area").show();
		jQuery("#enmge-related-files").hide();
	});
	
	jQuery('#enmge-group-files').click(function() { 
		jQuery('#enmge-group-general').parent().removeClass('selected');
		jQuery('#enmge-group-details').parent().removeClass('selected');
		jQuery('#enmge-group-location').parent().removeClass('selected');
		jQuery('#enmge-group-files').parent().addClass('selected');
		jQuery("#enmge-details-area").hide();
		jQuery("#enmge-basic-information").hide();				
		jQuery("#enmge-location-area").hide();
		jQuery("#enmge-related-files").show();
	});
	
	
	jQuery(document).on("click", "#addnewfile", function() {
		var groupid = jQuery("#enmgegid").val();
		if  ( groupid == null ) {
			groupid = 0;
		}
		var fileusername = jQuery("#file_username").val();
		var newfilenamelength = jQuery("#file_name").val().length;
		var newfileurllength = jQuery("#file_url").val().length;
		if (newfilenamelength >= 1 && newfileurllength >= 1 ) {
			var formdata = jQuery("#enmgeform").serialize();

			jQuery.ajax({ 
		        url: geajax.ajaxurl, 
		        data: {
		        	'method': 'POST',
		            'action': 'groupsengine_ajaxgroupnewfile',
		            'formdata': formdata,
		            'file_username': fileusername,
		            'group_id': groupid,
		            'new': 1
		        },
		        success:function(data) {
		        	
		        	jQuery("#file_name").val('');
					jQuery("#file_url").val('');
					jQuery('#enmgefilearea').html(data);
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
		var fileid = jQuery("#file_id").val();
		var fileusername = jQuery("#file_username").val();
		var groupid = jQuery("#enmgegid").val();
		if  ( groupid == null ) {
			groupid = 0;
		}
		var newfilenamelength = jQuery("#file_name").val().length;
		var newfileurllength = jQuery("#file_url").val().length;
		if (newfilenamelength >= 1 && newfileurllength >= 1 ) {
		    jQuery.ajax({ 
		        url: geajax.ajaxurl, 
		        data: {
		            'action': 'groupsengine_ajaxgroupeditfile',
		            'file_name': newfilename,
		            'file_url': newfileurl,
		            'file_username': fileusername,
		            'fid': fileid,
		            'gid': groupid,
		            'update': 1
		        },
		        success:function(data) {
		        	
		        	jQuery('#enmgefileform').html(data);

		        	jQuery.ajax({ 
				        url: geajax.ajaxurl, 
				        data: {
				            'action': 'groupsengine_ajaxgroupnewfile',
				            'file_username': fileusername,
				            'group_id': groupid
				        },
				        success:function(data) {
				        	
				        	jQuery('#enmgefilearea').html(data);
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
	
	jQuery(document).on("click", ".groupsengine_filedelete", function() {
		var answer = confirm("Are you SURE you want to remove this link/download from this Group? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");

			jQuery.ajax({ 
		        url: geajax.ajaxurl, 
		        data: {
		            'action': 'groupsengine_ajaxgroupdeletefile',
		            'did': id
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
	
	jQuery(document).on("click", ".groupsengine_editfile", function() {
		var id = jQuery(this).attr("name");
		var fileusername = jQuery("#file_username").val();

		jQuery.ajax({ 
	        url: geajax.ajaxurl, 
	        data: {
	            'action': 'groupsengine_ajaxgroupeditfile',
	            'fid': id,
	            'file_username': fileusername
	        },
	        success:function(data) {
	        	
	        	jQuery('#enmgefileform').html(data);
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });
		return false;
	});

		// Upload Message Graphic
	  jQuery('.enmge-upload-image').click( function( event ){

	  	var file_frame;

	  	var getthumbsize = jQuery("#enmgeimage").val();
	 
	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose a Photo for Your Group",
	      button: {
	        text: "Set Photo",
	      },
	      multiple: false
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();
	      //alert(JSON.stringify(attachment));

	      var checkfororig = attachment.width;
		  if ( checkfororig > getthumbsize ) {
			   if (attachment.sizes["Groups Engine Image"]) { 
	      			jQuery('#group_photo').val(attachment.sizes["Groups Engine Image"]["url"]);
					jQuery("#group-image-load").html('<br /><img src="' + attachment.sizes["Groups Engine Image"]["url"] + '" />');
      		   } else {
      			 alert("This image was uploaded before you installed or updated Groups Engine. You'll need to reupload the image so Groups Engine can generate an image that's the correct size.");
      		   };
      	  } else if ( checkfororig == getthumbsize ) {
	           jQuery('#group_photo').val(attachment.url);
			   jQuery("#group-image-load").html('<br /><img src="' + attachment.url + '" />');
      	  } else {
      	       alert("Please upload an photo that's at least " + getthumbsize + "px wide.");
      	  };

	    });
	 
	    file_frame.open();
	  });

	// Upload Message Files
	jQuery('.enmge-upload-group-file').click( function( event ){

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

	jQuery(document).on("click", "#addnewtopic", function() { 
		var newtopicname = jQuery("#topic_name").val();
		var newtopiclength = jQuery("#topic_name").val().length;
		if (newtopiclength >= 1) {
			jQuery.ajax({ 
		        url: geajax.ajaxurl,
		        data: {
		            'action': 'groupsengine_ajaxgroupnewtopic',
		            'topicname': newtopicname
		        },
		        success:function(data) {
		        	
		        	jQuery("#topic_name").val('');
					jQuery('#enmge-topiclist').append(jQuery('<div>').html(data));
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
		return false;
	});

	jQuery(document).on("click", "#addnewgrouptype", function() {
		var newgrouptypename = jQuery("#group_type_name").val();
		var newgrouptypelength = jQuery("#group_type_name").val().length;
		if (newgrouptypelength >= 1) {
			jQuery.ajax({ 
		        url: geajax.ajaxurl,
		        data: {
		            'action': 'groupsengine_ajaxgroupnewgrouptype',
		            'grouptypetitle': newgrouptypename
		        },
		        success:function(data) {
		        	
		        	jQuery("#group_type_name").val('');
					jQuery('#enmge-grouptypelist').append(jQuery('<div>').html(data));
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
		return false;
	});

	jQuery(document).on("click", "#group_noend", function() {
		var checkval = jQuery(this).attr("checked");
		if ( checkval == null ) {
			jQuery("#group_ends").removeAttr("disabled");
		} else {
			jQuery("#group_ends").attr("disabled","disabled");
		}
	});

	jQuery("#leader_name").focus(function () {
		var blabla = jQuery(this).val();
		if ( blabla == "Name" ) {
			jQuery(this).val('');
			jQuery(this).css('color','#000000');
		};
	});

	jQuery("#leader_name").blur(function () {
		var blabla = jQuery(this).val();
		if ( blabla == "" ) {
			jQuery("#leader_name").val('Name');
			jQuery(this).css('color','#cbcbcb');
		}
	});
	
	jQuery("#leader_email").focus(function () {
		var blabla = jQuery(this).val();
		if ( blabla == "Email" ) {
			jQuery(this).val('');
			jQuery(this).css('color','#000000');
		};
	});

	jQuery("#leader_email").blur(function () {
		var blabla = jQuery(this).val();
		if ( blabla == "" ) {
			jQuery("#leader_email").val('Email');
			jQuery(this).css('color','#cbcbcb');
		}
	});

	jQuery(document).on("click", "#addnewleader", function() {
		var newleadername = jQuery("#leader_name").val();
		var newleaderemail = jQuery("#leader_email").val();
		var groupid = jQuery("#enmgegid").val();
		if  ( groupid == null ) {
			groupid = 0;
		}
		var newleaderusername = jQuery("#leader_username").val();
		var newleaderlength = jQuery("#leader_email").val().length;
		if (newleaderlength >= 1) {
			if ( newleadername == "Name" || newleaderemail == "Email" ) {
				return false;
			} else {
				var formdata = jQuery("#enmgeform").serialize();

				jQuery.ajax({ 
			        url: geajax.ajaxurl,
			        data: {
			            'action': 'groupsengine_ajaxgroupnewleader',
			            'leader_username': newleaderusername,
			            'formdata': formdata,
			            'group_id': groupid,
			            'new': 1
			        },
			        success:function(data) {
			        	
			        	jQuery("#leader_name").val('Name');
						jQuery("#leader_email").val('Email');
						jQuery("#leader_name").css('color','#cbcbcb');
						jQuery("#leader_email").css('color','#cbcbcb');
						jQuery('#leader_list').html(data);
			        },
			        error: function(errorThrown){
			            console.log(errorThrown);
			        }
			    });
			};
		};
		return false;
	});

	jQuery(document).on("click", ".groupsengine_leaderdelete", function() {
		var answer = confirm("Are you SURE you want to remove this Leader from this Group? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");

			jQuery.ajax({ 
		        url: geajax.ajaxurl, 
		        data: {
		            'action': 'groupsengine_ajaxgroupdeleteleader',
		            'did': id
		        },
		        success:function(data) {
		        	
		        	jQuery("#lrow_"+id).fadeOut();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
		return false;
	});


});