(function ($) {
	'use strict';
	$(document).ready(function () {
		var $doc = $(document),	
			$win = $(window),
			$body = $('body');
		$doc.on( 'click', '#edit_with_tatsu_button', function(e) {
			if($body.hasClass('post-new-php')) {
				e.preventDefault();
				
				var $wpTitle = $('#title'),
					$wpTitleLabel = $('#title-prompt-text');
				if (!$wpTitle.val()) {
					$wpTitleLabel.addClass('screen-reader-text');
					$wpTitle.val('Tatsu #' + $('#post_ID').val());
				}
				$doc.on('heartbeat-tick.autosave', function () {
					$win.off('beforeunload.edit-post');
					location.href = $('#edit_with_tatsu_button').attr('href');
				});
				if($body.hasClass('post-type-tatsu_header') || $body.hasClass('post-type-tatsu_footer')) {
					$('#publish').trigger('click');
				}else if (wp.autosave) {
					wp.autosave.server.triggerSave();
				}
			}
		});
	
		$(document).on('click', '#edit_with_wordpress_editor', function () {
			$('#tatsu_edited_with').val('editor');
			$('body').removeClass('edited_with_tatsu').addClass('edited_with_editor');
		});

		if( $('#tatsu_global_section_settings_wrap').length ){
		(function () {

			var rulesets = [];
		

			$( '#tatsu_add-new-ruleset' ).click(function(){
				var $a =  jQuery(get_settings_panel( getNewRuleset() ));
				$('#tatsu_global_section_settings_wrap').append($a);
				 setTimeout( function() {
					var target = $a.find('select.tatsu_myselectclass');
					target.chosen();
					target.change(function(e){
						updateChange()
					});
					$a.find('.tatsu_remove-ruleset').click(function(){
						if( $('.tatsu_global-section-panel').length > 1 ){
							var tempId = $(this).attr('data-id');
							jQuery('.tatsu_global-section-panel[data-id='+tempId+']').remove();
						}else{
							alert("There should be atleast one active ruleset");
						}
						updateChange()
					});
					updateChange()
				 }, 0 );
			});
			if (window.tatsu_global_section_data.hasOwnProperty('global_section_data') && window.tatsu_global_section_data.global_section_data) {
				
				var gSectionData = JSON.parse(window.tatsu_global_section_data.global_section_data);
				rulesets = gSectionData.rulesets;
			} else {
				rulesets.push(getNewRuleset());
			}
			for (var ruleset in rulesets) {
					document.getElementById('tatsu_global_section_settings_wrap').innerHTML += get_settings_panel(rulesets[ruleset]);
			}

			setTimeout(function(){
				$('select.tatsu_myselectclass').chosen();

				$('select.tatsu_myselectclass').change(function(e){
					updateChange()
				});

				$('.tatsu_remove-ruleset').click(function(){
					if( $('.tatsu_global-section-panel').length > 1 ){
						var tempId = $(this).attr('data-id');
						jQuery('.tatsu_global-section-panel[data-id='+tempId+']').remove();
					}else{
						alert("There should be atleast one active ruleset");
					}
					updateChange()
				});
	
			},0);
			function get_settings_panel(ruleset) {
				var globalSectionList = window.tatsu_global_section_data.global_section_list;
				ruleset.data.exclTypes = ruleset.data.exclTypes || [];
				var content = '<div data-id="'+ruleset.id+'" class="tatsu_global-section-panel" >';
				content += '<div class="tatsu_remove-ruleset" data-id="'+ ruleset.id +'" >x</div><div class="be-settings-page-option global-section-include-box" ><label class="be-settings-page-option-label" > Include </label><select id="post_types' + ruleset.id + '" class="tatsu_myselectclass" multiple="" >' + getPostTypeCheckBoxes(window.tatsu_global_section_data.all_post_types, ruleset.data.types,'include') + '</select></div><div class="be-settings-page-option global-section-exclude-box global-section-hide-exclusion " ><label class="be-settings-page-option-label" > Exclude </label><select id="excl_post_types' + ruleset.id + '" class="tatsu_myselectclass" multiple="" >' + getPostTypeCheckBoxes(window.tatsu_global_section_data.all_post_types, ruleset.data.exclTypes,'exclude') + '</select></div>';

				content += '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Top</label><select id="position_top' + ruleset.id + '" >' + getSelectBoxContent(globalSectionList, ruleset.data.top) + '</select></div>';
				content += '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Penultimate</label><select id="position_penultimate' + ruleset.id + '"  >' + getSelectBoxContent(globalSectionList, ruleset.data.penultimate) + '</select></div>';
				content += '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Bottom</label><select id="position_bottom' + ruleset.id + '"  >' + getSelectBoxContent(globalSectionList, ruleset.data.bottom) + '</select></div>';

				content += '</div>';

				return content;

				function getSelectBoxContent(globalSectionList, value) {
					var globalSectionListDOM = '<option value="none"  >None</option>';

					for (var item in globalSectionList) {
						globalSectionListDOM += '<option value="' + item + '" ' + (item === value ? "selected" : " ") + ' >' + globalSectionList[item] + '</option>';
					}
					return globalSectionListDOM;
				}

				function getPostTypeCheckBoxes(post_type_options, post_types_values, type) {
					var post_type_checkboxes = type === 'include' ?'<option value="all" '+ (post_types_values.indexOf('all') !== -1 ? "selected" : '' )+' >All</option>' : '';
					for (var postTypeSlug in post_type_options) {
						var post_type_options_element = '';
						for( var item in post_type_options[ postTypeSlug ].items ){
							post_type_options_element += '<option value="' + item + '" '+ (post_types_values.indexOf(item) !== -1 ? "selected" : '' )+' >' + post_type_options[ postTypeSlug ].items[item] + '</option>';
						}
						post_type_checkboxes += '<optgroup label="'+ post_type_options[ postTypeSlug ].label +'" >'+ post_type_options_element+'</optgroup>';
					}
					return post_type_checkboxes;
				}
			}

			$('#tatsu_global_section_settings_export').click(function () {

				var currentData = JSON.stringify(getCurrentData());
				console.log( getCurrentData() )
                var data = '{}';
                if( window.hasOwnProperty( 'tatsu_global_section_data' ) ){
                    if( window.tatsu_global_section_data.hasOwnProperty( 'global_section_data' ) ){
                        data = window.tatsu_global_section_data.global_section_data;
                    }
                }
				
				if( data !== currentData ){
					alert( 'Please save the changes to export current settings' );
				} else {
					var dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(data);
        
					var exportFileDefaultName = 'global-section-settings.json';
					var linkElement = document.createElement('a');
					linkElement.setAttribute('href', dataUri);
					linkElement.setAttribute('download', exportFileDefaultName);
					linkElement.click();
					
				}
            });

			$('#tatsu_global_section_settings_submit').click(function () {

			
				$('#tatsu_global_Section_hidden_field').val(JSON.stringify(getCurrentData()));
				var submitValidationFlag = true;
				$('.global-section-include-box .tatsu_myselectclass').each( function(i,e){
					if( !$(e).val() ){
						var tempId = $(e).attr('id');
						$(e).after('<div class="tatsu_global-section-empty-warn" >Please select a post type to Save </div>');
						$('#'+tempId+'_chosen').click(function(){
							$('.tatsu_global-section-empty-warn').remove();
						});
						submitValidationFlag = false;
					}
				});
				if( submitValidationFlag ){
					$( '#tatsu_global_section_settings_form' ).submit();
				}
			});

			updateChange()

			function updateChange(){
				setTimeout(function(){

					$('.global-section-include-box .tatsu_myselectclass').each( function(i,e){
						var selectedTypes = [];
						var tempVal = $(e).val();
						if( tempVal ){
							for( var item in tempVal ){
								if( selectedTypes.indexOf( tempVal[item] ) === -1 ){
									selectedTypes.push( tempVal[item] );
								}
							}
						}
						var curRuleset = $( this ).closest('.tatsu_global-section-panel'),
							curExcludeBox = curRuleset.find( '.global-section-exclude-box' ),
							curExcludeSelect = curExcludeBox.find('select');

							if( selectedTypes.indexOf( 'all' ) !== -1 ){
								curExcludeBox.removeClass('global-section-hide-exclusion');
							} else {
									curExcludeBox.addClass('global-section-hide-exclusion');
									curExcludeSelect.val([]);
							}

						$(this).find( 'option' ).each(function(i,e){
						
							if( selectedTypes.indexOf( 'all' ) !== -1 ){
								if( $( this ).val() !== "all" ){
									$( this ).removeAttr( 'selected' );
									$( this ).attr( 'disabled','disabled' );
								}
							} else {
								$(this).removeAttr('disabled');
							}
						});
					});
					$('select.tatsu_myselectclass').trigger('chosen:updated');
				},0);
			}

			function uniqId(){
				return Math.random().toString(36).substr(2, 16);
				}
			
			function getNewRuleset(){
				return {
					id: uniqId(),
					data: { types: [], top: '', penultimate: '', bottom: '' }}
			}
			function getCurrentData(){
				var newRulesets = [],
					postSettings = {},
					allPostTypes = getAllPostTypeSlugs();


				$('.tatsu_global-section-panel').each( function(i,e){
					var elementId = $(e).attr('data-id'),
						tempTypes = $('#post_types' + elementId).val() || [],
						tempTop = $('#position_top' + elementId).val() || [],
						tempPenultimate = $('#position_penultimate' + elementId).val()|| [],
						tempBottom = $('#position_bottom' + elementId).val()|| [],
						tempExclTypes = [];

					if( tempTypes.indexOf && tempTypes.indexOf( 'all' ) !== -1 ){
						tempExclTypes = $('#excl_post_types' + elementId).val() || [];
					}
					
					var tempRuleSet = { id: elementId, data: { types: tempTypes || [], top: tempTop, penultimate: tempPenultimate, bottom: tempBottom, exclTypes: tempExclTypes } };

					newRulesets.push(tempRuleSet);
					
					if( tempTypes.indexOf( 'all' ) !== -1 && tempExclTypes.length ){
						tempTypes = removeArrayFromArray( allPostTypes, tempExclTypes );
					}
					if( tempTypes ){
						for ( var j in tempTypes ){
							if( tempTop !== 'none' ){
								if( postSettings[tempTypes[j]] ){
									postSettings[tempTypes[j]]['top'] = tempTop;
								} else {
									postSettings[tempTypes[j]] = { top : tempTop };
								}	
							}
							if( tempPenultimate !== 'none' ){
								if( postSettings[tempTypes[j]] ){
									postSettings[tempTypes[j]]['penultimate'] = tempPenultimate;
								} else {
									postSettings[tempTypes[j]] = { penultimate : tempPenultimate };
								}
							}
							if( tempBottom !== 'none' ){
								if( postSettings[tempTypes[j]] ){
									postSettings[tempTypes[j]]['bottom'] = tempBottom;
								} else {
									postSettings[tempTypes[j]] = { bottom : tempBottom };
								}
							}
						}
					}
				});
				return {rulesets:newRulesets,post_settings:postSettings};
			}

			function removeArrayFromArray( targetArray, subArray ){
				return targetArray.filter( function( item ){
					if( subArray.indexOf( item ) === -1 ){
						return true;
					}
				});
			}

			function getAllPostTypeSlugs(){
				var postTypesObject = window.tatsu_global_section_data,
					postTypes = [];

				if( window.tatsu_global_section_data ){
					postTypesObject = window.tatsu_global_section_data.all_post_types;
				}

				for( var postType in postTypesObject ){
					if( postTypesObject[postType].hasOwnProperty('items') ){
						var items =  Object.keys (postTypesObject[postType].items);
						postTypes = postTypes.concat(items);
					}
				}

				return postTypes;
			}

		}());
		}
	});


})(jQuery);
