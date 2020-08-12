jQuery(document).ready(function(){ /* ----- Series Engine - JavaScript for Podcast functions ----- */
	
	jQuery('#podcast_option').change(function() { // Choose a starting point
		var startvalue = jQuery(this).val();
		var stvalue = jQuery("#podcast_st").val();
		if (startvalue == "series") {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxpodcastloadseries',
		            'enmse_stid': stvalue
		        },
		        success:function(data) {
		        	jQuery('#podcast_series_topic').html(data);
					jQuery('#podcast_series_topic').show();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		} else if (startvalue == "topic") {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxpodcastloadtopic',
		            'enmse_stid': stvalue
		        },
		        success:function(data) {
		        	jQuery('#podcast_series_topic').html(data);
					jQuery('#podcast_series_topic').show();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		} else if (startvalue == "speaker") {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxpodcastloadspeaker',
		            'enmse_stid': stvalue
		        },
		        success:function(data) {
		        	jQuery('#podcast_series_topic').html(data);
					jQuery('#podcast_series_topic').show();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		 } else {
			jQuery('#podcast_series_topic').hide();
		};
	});
	
	jQuery('#podcast_st').change(function() { // Choose a starting point
		var startvalue = jQuery('#podcast_option').val();
		var stvalue = jQuery(this).val();
		var pluginurl = jQuery('#enmse-get-plugin-link').attr("title");
		var xxse = encodeURIComponent(jQuery('#xxse').val());
		var serandom = Math.floor(Math.random()*1001);
		if (startvalue == "series") {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxpodcastloadseries',
		            'enmse_stid': stvalue
		        },
		        success:function(data) {
		        	jQuery('#podcast_series_topic').html(data);
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		} else if (startvalue == "topic") {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxpodcastloadtopic',
		            'enmse_stid': stvalue
		        },
		        success:function(data) {
		        	jQuery('#podcast_series_topic').html(data);
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		} else if (startvalue == "speaker") {
			jQuery.ajax({
		        url: seajax.ajaxurl, 
		        data: {
		            'action': 'seriesengine_ajaxpodcastloadspeaker',
		            'enmse_stid': stvalue
		        },
		        success:function(data) {
		        	jQuery('#podcast_series_topic').html(data);
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
	});
	
	/*window.send_to_editor = function(html){ //Send Media Upload values to code editor!
			var alttest = html.match(/img alt/);
			if (alttest != null) {
				var titletest = html.match(/title=/);
				if (titletest != null) {
					var source = html.match(/src=\".*\" title/);
				    source = source[0].replace(/^src=\"/, "").replace(/" title$/, "");
				    jQuery("#podcast_logo_url").attr('value', source);
				} else {
					var source = html.match(/src=\".*\" class/);
				    source = source[0].replace(/^src=\"/, "").replace(/" class$/, "");
				    jQuery("#podcast_logo_url").attr('value', source);
				};
			} else {
				var source = html.match(/src=\".*\" alt/);
			    source = source[0].replace(/^src=\"/, "").replace(/" alt$/, "");
			    jQuery("#podcast_logo_url").attr('value', source);
			};
	    tb_remove();
	}; */

	// Upload Message Graphic
	  jQuery('.enmse-upload-podcast-image').click( function( event ){

	  	var file_frame;
	 
	    event.preventDefault();
	 
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "Choose a Graphic for Your Podcast",
	      button: {
	        text: "Set Graphic",
	      },
	      multiple: false
	    });
	 
	    file_frame.on( 'select', function() {
	      attachment = file_frame.state().get('selection').first().toJSON();
	      var checkfororig = attachment.width;
	      if ( checkfororig > 1400 ) {
			if (attachment.sizes["Series Engine Graphic Thumb"]) { 
	      		jQuery('#podcast_logo_url').val(attachment.sizes["Series Engine Podcast Graphic"]["url"]);
	      		jQuery("#podcast-thumb-load").html('<br /><img src="' + attachment.sizes["Series Engine Podcast Graphic"]["url"] + '" style="width: 36%" />');
      		} else {
      			alert("This image is either too small, or was uploaded before Series Engine was installed. You'll need to choose a larger image, or reupload the image so Series Engine can generate an image that's the correct size.");
      		};
      	   } else if ( checkfororig == 1400 ) {
	      		jQuery('#podcast_logo_url').val(attachment.url);
	      		jQuery("#podcast-thumb-load").html('<br /><img src="' + attachment.url + '" style="width: 36%" />');
      	   } else {
      			alert("Please upload an image that's at least 1400px wide.");
      	   };
	    });
	 
	    file_frame.open();
	  });

});