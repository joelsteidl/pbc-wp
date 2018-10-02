(function ($) {
	'use strict';

	$(document).ready(function () {
		$(document).on('click', '#edit_with_wordpress_editor', function () {
			$('#tatsu_edited_with').val('editor');
			$('body').removeClass('edited_with_tatsu').addClass('edited_with_editor');
		});

		if( $('#tatsu_global_section_settings_wrap').length ){
		(function () {

			var rulesets = [];

			var selectedTypes = [];
			updateChange();

			$( '#tatsu_add-new-ruleset' ).click(function(){
				var $a =  jQuery(get_settings_panel( getNewRuleset() ));
				$('#tatsu_global_section_settings_wrap').append($a);
				 setTimeout( function() {
					var target = $a.find('select.tatsu_myselectclass');
					target.chosen();
					target.change(function(e){
						updateChange();
					});
					$a.find('.tatsu_remove-ruleset').click(function(){
						if( $('.tatsu_global-section-panel').length > 1 ){
							var tempId = $(this).attr('data-id');
							jQuery('.tatsu_global-section-panel[data-id='+tempId+']').remove();
						}else{
							alert("There should be atleast one active ruleset");
						}
						updateChange();
					});
					updateChange();
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
					updateChange();
				});

				$('.tatsu_remove-ruleset').click(function(){
					if( $('.tatsu_global-section-panel').length > 1 ){
						var tempId = $(this).attr('data-id');
						jQuery('.tatsu_global-section-panel[data-id='+tempId+']').remove();
					}else{
						alert("There should be atleast one active ruleset");
					}
					updateChange();
				});
	
			},0);
			function get_settings_panel(ruleset) {
				var globalSectionList = window.tatsu_global_section_data.global_section_list;

				var content = '<div data-id="'+ruleset.id+'" class="tatsu_global-section-panel" >';
				content += '<div class="tatsu_remove-ruleset" data-id="'+ ruleset.id +'" >x</div><div class="be-settings-page-option" ><label class="be-settings-page-option-label" > Post Types </label><select id="post_types' + ruleset.id + '" class="tatsu_myselectclass" multiple="" >' + getPostTypeCheckBoxes(window.tatsu_global_section_data.all_post_types, ruleset.data.types) + '</select></div>';

				content += '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Top</label><select id="position_top' + ruleset.id + '"  >' + getSelectBoxContent(globalSectionList, ruleset.data.top) + '</select></div>';
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

				function getPostTypeCheckBoxes(post_type_options, post_types_values) {
					var post_type_checkboxes = '';
					for (var key in post_type_options) {
						post_type_checkboxes += '<option value="' + key + '" '+ (post_types_values.indexOf(key) !== -1 ? "selected" : '' )+' >' + post_type_options[key] + '</option>';
					}
					return post_type_checkboxes;
				}
			}




			$('#tatsu_global_section_settings_submit').click(function () {

				var newRulesets = [];

				var postSettings = {};
				$('.tatsu_global-section-panel').each( function(i,e){
					var elementId = $(e).attr('data-id'),
						tempTypes = $('#post_types' + elementId).val(),
						tempTop = $('#position_top' + elementId).val(),
						tempPenultimate = $('#position_penultimate' + elementId).val(),
						tempBottom = $('#position_bottom' + elementId).val();

					var tempRuleSet = { id: elementId, data: { types: tempTypes || [], top: tempTop, penultimate: tempPenultimate, bottom: tempBottom } };

					newRulesets.push(tempRuleSet);

					if( tempTypes ){
						for ( var j in tempTypes ){
							postSettings[tempTypes[j]] = {top: tempTop, penultimate: tempPenultimate, bottom: tempBottom}
						}
					}
				});

				$('#tatsu_global_Section_hidden_field').val(JSON.stringify({rulesets:newRulesets,post_settings:postSettings}));
				var submitValidationFlag = true;
				$('.tatsu_myselectclass').each( function(i,e){
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

			function updateChange(){
				selectedTypes = [];
				$('.tatsu_myselectclass').each( function(i,e){
					if( $(e).val() ){
					for( var item of $(e).val()){
						if( !selectedTypes.indexOf( item ) !== -1 ){
							selectedTypes.push(item);
						}
					}
				}
				});
				
				$( '.tatsu_myselectclass option' ).each(function(i,e){

					
					if( selectedTypes.indexOf($(e).val()) !== -1 && !($(e).parent().val() && $(e).parent().val().indexOf($(e).val()) !== -1 ) ) {
						$(e).attr('disabled','disabled');
					}else{
						$(e).removeAttr( 'disabled' );
					}
				});

				$('select.tatsu_myselectclass').trigger('chosen:updated');
			}

			function uniqId(){
				return Math.random().toString(36).substr(2, 16);
				}
			
			function getNewRuleset(){
				return {
					id: uniqId(),
					data: { types: [], top: '', penultimate: '', bottom: '' }}
			}
		}());
		}
	});


})(jQuery);
