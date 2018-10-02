jQuery(document).ready(function(){ /* ----- Series Engine - JavaScript for Series functions ----- */
  /*window.send_to_editor = function(html){ //Send Media Upload values to code editor!
      var alttest = html.match(/img alt/);
      if (alttest != null) {
        var titletest = html.match(/title=/);
        if (titletest != null) {
          var source = html.match(/src=\".*\" title/);
            source = source[0].replace(/^src=\"/, "").replace(/" title$/, "");
            jQuery("#series_thumbnail_url").attr('value', source);
        } else {
          var source = html.match(/src=\".*\" class/);
            source = source[0].replace(/^src=\"/, "").replace(/" class$/, "");
            jQuery("#series_thumbnail_url").attr('value', source);
        };
      } else {
        var source = html.match(/src=\".*\" alt/);
          source = source[0].replace(/^src=\"/, "").replace(/" alt$/, "");
          jQuery("#series_thumbnail_url").attr('value', source);
      };
      tb_remove();
  }; */

  /*jQuery('.enmse-upload-series-graphic').click(function() {
  var send_attachment_bkp = wp.media.editor.send.attachment;
    wp.media.editor.send.attachment = function(props, attachment) {
      var checkforheader = attachment.width;
      if ( checkforheader > 350 ) {
        jQuery('#series_thumbnail_url').val(attachment.sizes["Series Engine Graphic"]["url"]);
      } else if( checkforheader == 350) {
        jQuery('#series_thumbnail_url').val(attachment.url);
      } else {
        alert("That image is too small to look right on the page. Please choose or upload a different one.");
      };
          wp.media.editor.send.attachment = send_attachment_bkp;
          console.log(attachment);
      }
    wp.media.editor.open();
      return false;
    });*/

   /*var _custom_media = true,
     _orig_send_attachment = wp.media.editor.send.attachment;

    jQuery('.enmse-upload-series-graphic').click(function(e) {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = jQuery(this);
        _custom_media = true;
        wp.media.editor.send.attachment = function(props, attachment){
        //alert(JSON.stringify(attachment));
          if ( _custom_media ) {
            jQuery('#series_thumbnail_url').val(attachment.sizes["Series Engine Graphic"]["url"]);
          } else {
            return _orig_send_attachment.apply( this, [props, attachment] );
          };
      }

      wp.media.editor.open(button);
      return false;
    });

  jQuery('.add_media').on('click', function(){
    _custom_media = false;
  }); */


 
  // Upload Series Graphic
  jQuery('.enmse-upload-series-graphic').click( function( event ){

    var file_frame;
 
    event.preventDefault();
    var getthumbsize = jQuery("#enmseembedwidth").val();
    if ( file_frame ) {
      file_frame.open();
      return;
    }

    file_frame = wp.media.frames.file_frame = wp.media({
      title: "Choose a Graphic for Your Series",
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
            jQuery('#series_thumbnail_url').val(attachment.sizes["Series Engine Graphic"]["url"]);
            jQuery('#series_graphic_thumb').val(attachment.sizes["Series Engine Graphic Thumb"]["url"]);
            jQuery('#series_widget_thumb').val(attachment.sizes["Series Engine Widget Thumb"]["url"]);

            jQuery("#series-thumb-load").html('<br /><img src="' + attachment.sizes["Series Engine Graphic"]["url"] + '" />');
            jQuery("#archive-thumb-load").html('<br /><img src="' + attachment.sizes["Series Engine Graphic Thumb"]["url"] + '" />');
            jQuery("#widget-thumb-load").html('<br /><img src="' + attachment.sizes["Series Engine Widget Thumb"]["url"] + '" />');          
          } else {
            alert("Just FYI, you uploaded this image before you installed Series Engine, but it may not be large enough (according to your settings in Settings > Series Engine). You can still use it, but it may not look the best on your site.");
            jQuery('#series_thumbnail_url').val(attachment.sizes["full"]["url"]);
            jQuery("#series-thumb-load").html('<br /><img src="' + attachment.sizes["full"]["url"] + '" />');
          };
        } else if ( checkfororig == getthumbsize ) {
          jQuery('#series_thumbnail_url').val(attachment.url);
          jQuery('#series_graphic_thumb').val(attachment.sizes["Series Engine Graphic Thumb"]["url"]);
          jQuery('#series_widget_thumb').val(attachment.sizes["Series Engine Widget Thumb"]["url"]);

          jQuery("#series-thumb-load").html('<br /><img src="' + attachment.url + '" />');
          jQuery("#archive-thumb-load").html('<br /><img src="' + attachment.sizes["Series Engine Graphic Thumb"]["url"] + '" />');
          jQuery("#widget-thumb-load").html('<br /><img src="' + attachment.sizes["Series Engine Widget Thumb"]["url"] + '" />');
        } else {
          alert("Please upload an image that's at least " + getthumbsize + "px wide.");
        };
    });
 
    file_frame.open();
  });

  // Upload Series Graphic for Archives
  jQuery('.enmse-upload-series-graphic-thumb').click( function( event ){

    var file_frame;

    var getthumbsize = jQuery("#enmsearchivethumb").val();
    event.preventDefault();
 
    if ( file_frame ) {
      file_frame.open();
      return;
    }
 
    file_frame = wp.media.frames.file_frame = wp.media({
      title: "Choose a Graphic for the Series Archives Page",
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
            jQuery('#series_graphic_thumb').val(attachment.sizes["Series Engine Graphic Thumb"]["url"]);
            jQuery("#archive-thumb-load").html('<br /><img src="' + attachment.sizes["Series Engine Graphic Thumb"]["url"] + '" />');
          } else {
            alert("Just FYI, you uploaded this image before you installed Series Engine, but it may not be large enough (according to your settings in Settings > Series Engine). You can still use it, but it may not look the best on your site.");
            jQuery('#series_graphic_thumb').val(attachment.sizes["full"]["url"]);
            jQuery("#archive-thumb-load").html('<br /><img src="' + attachment.sizes["full"]["url"] + '" />');
          };
        } else if ( checkfororig == getthumbsize ) {
          jQuery('#series_graphic_thumb').val(attachment.url);
          jQuery("#archive-thumb-load").html('<br /><img src="' + attachment.url + '" />');
        } else {
          alert("Please upload an image that's at least " + getthumbsize + "px wide.");
        };
    });
 
    file_frame.open();
  });

  // Upload Series Graphic for Widgets
  jQuery('.enmse-upload-series-widget-thumb').click( function( event ){

    var file_frame;
    
  var getthumbsize = jQuery("#enmsewidgetthumb").val();
    event.preventDefault();
 
    if ( file_frame ) {
      file_frame.open();
      return;
    }
 
    file_frame = wp.media.frames.file_frame = wp.media({
      title: "Choose a Graphic for Your Widgets",
      button: {
        text: "Set Graphic",
      },
      multiple: false 
    });
 
    file_frame.on( 'select', function() {
      attachment = file_frame.state().get('selection').first().toJSON();
      var checkfororig = attachment.width;
    if ( checkfororig > getthumbsize ) {
      if (attachment.sizes["Series Engine Widget Thumb"]) { 
            jQuery('#series_widget_thumb').val(attachment.sizes["Series Engine Widget Thumb"]["url"]);
            jQuery("#widget-thumb-load").html('<br /><img src="' + attachment.sizes["Series Engine Widget Thumb"]["url"] + '" />');
          } else {
            alert("Just FYI, you uploaded this image before you installed Series Engine, but it may not be large enough (according to your settings in Settings > Series Engine). You can still use it, but it may not look the best on your site.");
            jQuery('#series_widget_thumb').val(attachment.sizes["full"]["url"]);
            jQuery("#widget-thumb-load").html('<br /><img src="' + attachment.sizes["full"]["url"] + '" />');
          };
        } else if ( checkfororig == getthumbsize ) {
          jQuery('#series_widget_thumb').val(attachment.url);
          jQuery("#widget-thumb-load").html('<br /><img src="' + attachment.url + '" />');
        } else {
          alert("Please upload an image that's at least " + getthumbsize + "px wide.");
        }
    });
 
    file_frame.open();
  });

  // Upload Podcast Graphic
  jQuery('.enmse-upload-series-podcast-image').click( function( event ){

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
        jQuery('#series_podcast_image').val(attachment.url);
        jQuery("#podcast-image-load").html('<br /><img src="' + attachment.url + '" />');
      };
    });
 
    file_frame.open();
  });

  jQuery("#series_podcast_image").change(function() {
    var findval = jQuery(this).val();
    if ( findval == "" ) {
      jQuery("#podcast-image-load").html('');
    } else {
      jQuery("#podcast-image-load").html('<br /><img src="' + findval + '" />');
    };
  });

  jQuery("#series_widget_thumb").change(function() {
    var findval = jQuery(this).val();
    if ( findval == "" ) {
      jQuery("#widget-thumb-load").html('');
    } else {
      jQuery("#widget-thumb-load").html('<br /><img src="' + findval + '" />');
    };
  });

  jQuery("#series_graphic_thumb").change(function() {
    var findval = jQuery(this).val();
    if ( findval == "" ) {
      jQuery("#archive-thumb-load").html('');
    } else {
      jQuery("#archive-thumb-load").html('<br /><img src="' + findval + '" />');
    };
  });

  jQuery("#series_thumbnail_url").change(function() {
    var findval = jQuery(this).val();
    if ( findval == "" ) {
      jQuery("#series-thumb-load").html('');
    } else {
      jQuery("#series-thumb-load").html('<br /><img src="' + findval + '" />');
    };
  });



});