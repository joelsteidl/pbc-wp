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
	
	
	jQuery('#addnewfile').live("click", function() { 
		var newfilename = jQuery("#file_name").val();
		var newfileurl = jQuery("#file_url").val();
		var groupid = jQuery("#enmgegid").val();
		var fileusername = jQuery("#file_username").val();
		var newfilenamelength = jQuery("#file_name").val().length;
		var newfileurllength = jQuery("#file_url").val().length;
		if (newfilenamelength >= 1 && newfileurllength >= 1 ) {
				var formdata = jQuery("#enmgeform").serialize();
				var findurl = jQuery('#enmgefileurl').val();
				var xxge = jQuery('#xxge').val();
				var serandom = Math.floor(Math.random()*1001);
				var encodedvalthree = groupid;
				var encodedvalfour = encodeURIComponent(fileusername);
				var urltoload = findurl+"?file_username="+encodedvalfour+"&group_id="+encodedvalthree+"&xxge="+xxge+"&enmge_random="+serandom;
				
				function loadrefreshedfilelist() {
					jQuery("#file_name").val('');
					jQuery("#file_url").val('');
					jQuery('#enmgefilearea').load(urltoload);
				};
				jQuery.post(urltoload, formdata, loadrefreshedfilelist);
		};
		return false;
	});
	
	jQuery('#editfile').live("click", function() { 
		var newfilename = jQuery("#file_name").val();
		var newfileurl = jQuery("#file_url").val();
		var fileid = jQuery("#file_id").val();
		var fileusername = jQuery("#file_username").val();
		var groupid = jQuery("#enmgegid").val();
		var newfilenamelength = jQuery("#file_name").val().length;
		var newfileurllength = jQuery("#file_url").val().length;
		if (newfilenamelength >= 1 && newfileurllength >= 1 ) {
				var formdata = jQuery("#enmgeform").serialize();
				var findurl = jQuery('#enmgefileedit').val();
				var xxge = jQuery('#xxge').val();
				var serandom = Math.floor(Math.random()*1001);
				var anotherfindurl = jQuery('#enmgefileurl').val();
				var encodedvalone = encodeURIComponent(newfilename);
				var encodedvaltwo = encodeURIComponent(newfileurl);
				var encodedvalthree = fileid;
				var encodedvalfour = encodeURIComponent(fileusername);
				var urltoload = findurl+"?file_name="+encodedvalone+"&xxge="+xxge+"&file_url="+encodedvaltwo+"&file_username="+encodedvalfour+"&fid="+encodedvalthree+"&gid="+groupid+"&enmge_random="+serandom;
				var anotherurltoload = anotherfindurl+"?message_id="+groupid+"&xxge="+xxge+"&file_username="+encodedvalfour+"&gid="+groupid+"&enmge_random="+serandom;

				function loadrefreshedfilelist() {
					jQuery('#enmgefileform').load(urltoload+"&done=1");
					jQuery('#enmgefilearea').load(anotherurltoload+"&done=1");
				};
				jQuery.post(urltoload, formdata, loadrefreshedfilelist);
		};
		return false;
	});
	
	jQuery('.groupsengine_filedelete').live("click", function() {
		var answer = confirm("Are you SURE you want to remove this link/download from this Group? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			var formdata = jQuery("#enmgeform").serialize();
			var findurl = jQuery('#enmgefiledelete').val();
			var xxge = jQuery('#xxge').val();
			var serandom = Math.floor(Math.random()*1001);
			var urltoload = findurl+"?did="+id+"&xxge="+xxge+"&enmge_random="+serandom;
			
			function loadrefreshedfilelist() {
				jQuery("#row_"+id).fadeOut();
			};
			jQuery.post(urltoload, formdata, loadrefreshedfilelist);
		};
		return false;
	});
	
	jQuery('.groupsengine_editfile').live("click", function() {
		var id = jQuery(this).attr("name");
		var findurl = jQuery('#enmgefileedit').val();
		var xxge = jQuery('#xxge').val();
		var serandom = Math.floor(Math.random()*1001);
		var urltoload = findurl+"?fid="+id+"&xxge="+xxge+"&enmge_random="+serandom;
		jQuery('#enmgefileform').load(urltoload);
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

	jQuery('#addnewtopic').live("click", function() { 
		var newtopicname = jQuery("#topic_name").val();
		var newtopiclength = jQuery("#topic_name").val().length;
		if (newtopiclength >= 1) {
			var formdata = jQuery("#enmgeform").serialize();
			var findurl = jQuery('#enmgepluginurl').val();
			var xxge = jQuery('#xxge').val();
			var serandom = Math.floor(Math.random()*1001);
			var encodedval = encodeURIComponent(newtopicname);
			var urltoload = findurl+"?topicname="+encodedval+"&xxge="+xxge+"&enmge_random="+serandom;

			function loadrefreshedtopiclist() {
				jQuery("#topic_name").val('');
				jQuery('#enmge-topiclist').append(jQuery('<div>').load(urltoload));
			};
			jQuery.post(urltoload, formdata, loadrefreshedtopiclist);
		};
		
		return false;
	});

	jQuery('#addnewgrouptype').live("click", function() { 
		var newgrouptypename = jQuery("#group_type_name").val();
		var newgrouptypelength = jQuery("#group_type_name").val().length;
		if (newgrouptypelength >= 1) {
			var formdata = jQuery("#enmgeform").serialize();
			var findurl = jQuery('#enmgepluginurl2').val();
			var xxge = jQuery('#xxge').val();
			var serandom = Math.floor(Math.random()*1001);
			var encodedval = encodeURIComponent(newgrouptypename);
			var urltoload = findurl+"?grouptypetitle="+encodedval+"&xxge="+xxge+"&enmge_random="+serandom;

			function loadrefreshedgrouptypelist() {
				jQuery("#group_type_name").val('');
				jQuery('#enmge-grouptypelist').append(jQuery('<div>').load(urltoload));
			};
			jQuery.post(urltoload, formdata, loadrefreshedgrouptypelist);
		};
		
		return false;
	});

	jQuery("#group_noend").live("click", function () {
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

	jQuery('#addnewleader').live("click", function() { 
		var newleadername = jQuery("#leader_name").val();
		var newleaderemail = jQuery("#leader_email").val();
		var groupid = jQuery("#enmgegid").val();
		var newleaderusername = jQuery("#leader_username").val();
		var newleaderlength = jQuery("#leader_email").val().length;
		if (newleaderlength >= 1) {
			if ( newleadername == "Name" || newleaderemail == "Email" ) {
				return false;
			} else {
				var formdata = jQuery("#enmgeform").serialize();
				var findurl = jQuery('#enmgeleaderurl').val();
				var xxge = jQuery('#xxge').val();
				var serandom = Math.floor(Math.random()*1001);
				var encodedvalthree = encodeURIComponent(newleaderusername);
				var urltoload = findurl+"?leader_username="+encodedvalthree+"&xxge="+xxge+"&group_id="+groupid+"&enmse_random="+serandom;
				
				function loadrefreshedleaderlist() {
					jQuery("#leader_name").val('Name');
					jQuery("#leader_email").val('Email');
					jQuery("#leader_name").css('color','#cbcbcb');
					jQuery("#leader_email").css('color','#cbcbcb');
					jQuery('#leader_list').load(urltoload);
				};
				jQuery.post(urltoload, formdata, loadrefreshedleaderlist);
			};
		};
		return false;
	});

	jQuery('.groupsengine_leaderdelete').live("click", function() {
		var answer = confirm("Are you SURE you want to remove this Leader from this Group? Click 'OK' to continue deleting...")
		if (answer){
			var id = jQuery(this).attr("name");
			var formdata = jQuery("#enmgeform").serialize();
			var findurl = jQuery('#enmgeleaderdelete').val();
			var xxge = jQuery('#xxge').val();
			var serandom = Math.floor(Math.random()*1001);
			var urltoload = findurl+"?did="+id+"&xxge="+xxge+"&enmge_random="+serandom;
			
			function loadrefreshedfilelist() {
				jQuery("#lrow_"+id).fadeOut();
			};
			jQuery.post(urltoload, formdata, loadrefreshedfilelist);
		};
		return false;
	});


});