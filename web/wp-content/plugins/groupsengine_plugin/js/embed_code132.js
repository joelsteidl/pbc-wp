jQuery(document).ready(function(){ /* ----- Groups Engine - Generate Custom Embed Code ----- */

	jQuery(document).on("click", "#enmge-generate-embed-code", function() {
		var em = jQuery("#enmge_embedtype").val();
		var gt = jQuery("#enmge_grouptype").val();
		var t = jQuery("#enmge_topic").val();
		var l = jQuery("#enmge_location").val();
		var m = jQuery("#enmge_meeting").val();
		var d = jQuery("#enmge_day").val();
		var st = jQuery("#enmge_st").val();
		var et = jQuery("#enmge_et").val();
		var sa = jQuery("#enmge_sa").val();
		var ea = jQuery("#enmge_ea").val();
		var z = jQuery("#enmge_zip").val();
		var cz = jQuery("#enmge_cz").val();
		var zl = jQuery("#enmge_zl").val();
		var v = jQuery("#enmge_v").val();
		var vo = jQuery("#enmge_vo").val();

		var cl = jQuery("#enmge_cl").val();
		var glcl = jQuery("#enmge_glcl").val();
		var gl = jQuery("#enmge_gl").val();

		var fo = jQuery("#enmge_fo").val();

		var sm = jQuery("#enmge_sm").val();
		var glsm = jQuery("#enmge_glsm").val();
		var pag = jQuery("#enmge_pag").val();

		var start = jQuery("#enmge_start").val();

		var sort = jQuery("#enmge_sort").val();
		var status = jQuery("#enmge_status").val();

		if ( em == 2 ) {
			var gid = jQuery("#enmge_gid").val();
		} else {
			var gid = 0;
		};

		if ( jQuery("#enmge_xgt").attr("checked") ) {
			var xgt = 1;
		} else {
			var xgt = 0;
		};

		if ( jQuery("#enmge_xgt").attr("checked") ) {
			var xgt = 1;
		} else {
			var xgt = 0;
		};

		if ( jQuery("#enmge_xt").attr("checked") ) {
			var xt = 1;
		} else {
			var xt = 0;
		};

		if ( jQuery("#enmge_xl").attr("checked") ) {
			var xl = 1;
		} else {
			var xl = 0;
		};

		if ( jQuery("#enmge_xm").attr("checked") ) {
			var xm = 1;
		} else {
			var xm = 0;
		};

		if ( jQuery("#enmge_xd").attr("checked") ) {
			var xd = 1;
		} else {
			var xd = 0;
		};

		if ( jQuery("#enmge_xst").attr("checked") ) {
			var xst = 1;
		} else {
			var xst = 0;
		};

		if ( jQuery("#enmge_xsa").attr("checked") ) {
			var xsa = 1;
		} else {
			var xsa = 0;
		};

		if ( jQuery("#enmge_xz").attr("checked") ) {
			var xz = 1;
		} else {
			var xz = 0;
		};

		jQuery.ajax({
	        url: geajax.ajaxurl, 
	        data: {
	            'action': 'groupsengine_ajaxembedgencode',
	            'enmge_gtid': gt,
	            'enmge_status': status,
	            'enmge_start': start,
	            'enmge_em': em,
	            'enmge_sort': sort,
	            'enmge_gid': gid,
	            'enmge_tid': t,
	            'enmge_lid': l,
	            'enmge_m': m,
	            'enmge_d': d,
	            'enmge_st': st,
	            'enmge_et': et,
	            'enmge_sa': sa,
	            'enmge_ea': ea,
	            'enmge_zip': z,
	            'enmge_cz': cz,
	            'enmge_zl': zl,
	            'enmge_v': v,
	            'enmge_vo': vo,
	            'enmge_cl': cl,
	            'enmge_glsm': glsm,
	            'enmge_sm': sm,
	            'enmge_pag': pag,
	            'enmge_glcl': glcl,
	            'enmge_gl': gl,
	            'enmge_fo': fo,
	            'enmge_xgt': xgt,
	            'enmge_xt': xt,
	            'enmge_xl': xl,
	            'enmge_xm': xm,
	            'enmge_xd': xd,
	            'enmge_xst': xst,
	            'enmge_xsa': xsa,
	            'enmge_xz': xz
	        },
	        success:function(data) {
	        	jQuery('#enmge-embed-code').html(data);
	        	jQuery("#enmge-embed-code").show();
	        },
	        error: function(errorThrown){
	            console.log(errorThrown);
	        }
	    });

		jQuery(this).html("Generate New Code");		
		return false;
	});

	jQuery(document).on("change", "#enmge_findgrouptype", function() {
		var gtvalue = jQuery(this).val();
		if ( gtvalue != "n" ) {
			jQuery.ajax({
		        url: geajax.ajaxurl, 
		        data: {
		            'action': 'groupsengine_ajaxembedfindgroup',
		            'enmge_gtid': gtvalue
		        },
		        success:function(data) {

		        	jQuery("#groupoptions").hide();
					jQuery("#enmge-generate-embed-code").hide();
					jQuery("#enmge-embed-code").hide();
		        	jQuery('#choosegroup').html(data);
		        	jQuery("#choosegroup").show();
		        },
		        error: function(errorThrown){
		            console.log(errorThrown);
		        }
		    });
		};
	});
	
	// Simple/Advanced Tabs
	jQuery('#enmge-simple-embed').click(function() {
		jQuery('#enmge-simple-embed').parent().addClass('selected');
		jQuery('#enmge-custom-embed').parent().removeClass('selected');
		jQuery("#enmge-custom").hide();
		jQuery("#enmge-simple").show();	
		return false;			
	});
	
	jQuery('#enmge-custom-embed').click(function() { 
		jQuery('#enmge-simple-embed').parent().removeClass('selected');
		jQuery('#enmge-custom-embed').parent().addClass('selected');
		jQuery("#enmge-custom").show();
		jQuery("#enmge-simple").hide();	
		return false;			
	});

	// Hide and Show Elements

	jQuery(document).on("change", "#enmge_embedtype", function() {
		var emvalue = jQuery(this).val();
		if ( emvalue == 2) {
			jQuery("#findgrouparea").show();
			jQuery("#grouplistarea").hide();
			jQuery("#advanced").hide();
			jQuery("#enmge-generate-embed-code").hide();
			jQuery("#enmge-embed-code").hide();
		} else if ( emvalue == 1 ) {
			jQuery("#findgrouparea").hide();
			jQuery("#grouplistarea").show();
			jQuery("#advanced").hide();
			jQuery("#groupoptions").hide();
			jQuery("#enmge-generate-embed-code").show();
			jQuery("#enmge-embed-code").hide();
		};
	});

	jQuery(document).on("change", "#enmge_gid", function() {
		var gid = jQuery(this).val();
		if ( gid > 0 ) {
			jQuery("#groupoptions").show();
			jQuery("#enmge-generate-embed-code").show();
			jQuery("#enmge-embed-code").hide();
		};
	});

	jQuery(document).on("click", "#advancedlink", function() {
		var emvalue = jQuery("#enmge_embedtype").val();
		jQuery("#advanced").toggle();
		jQuery("#enmge-embed-code").hide();
		if ( emvalue == 2 ) {
			jQuery("#contactleader").hide();
			jQuery("#indmap").hide();
		} else {
			jQuery("#contactleader").show();
			jQuery("#indmap").show();
		}
		return false;
	});

	jQuery(document).on("change", "#enmge_gl", function() {
		var glvalue = jQuery(this).val();
		if ( glvalue == 1) {
			jQuery("#grouplistarea").show();
			jQuery("#enmge-embed-code").hide();
		} else {
			jQuery("#grouplistarea").hide();
			jQuery("#enmge-embed-code").hide();
		};
	});

	jQuery(document).on("change", "#enmge_fo", function() {
		var fovalue = jQuery(this).val();
		jQuery("#enmge-embed-code").hide();
		if ( fovalue == 1 ) {
			jQuery("#filterrow").show();
		} else {
			jQuery("#filterrow").hide();
		}
		return false;
	});

	jQuery(document).on("change", "#enmge_sm, #enmge_sort, #enmge_status, #enmge_start, #enmge_glsm, #enmge_pag, #enmge_grouptype, #enmge_topic, #enmge_findgrouptype, #enmge_cl, #enmge_location, #enmge_meeting, #enmge_day, #enmge_st, #enmge_et, #enmge_sa, #enmge_ea, #enmge_zip, #enmge_v, #enmge_cz, #enmge_zl, #enmge_vo, #enmge_fo, #enmge_xgt, #enmge_xt, #enmge_xl, #enmge_xm, #enmge_xd, #enmge_xst, #enmge_xsa, #enmge_xz", function() {
		jQuery("#enmge-embed-code").hide();
	});


});