jQuery(document).ready(function(){
    //REMOVE SPYRO FORM MODULE IN PAGE 
    if(jQuery('body').hasClass("tatsu-page-builder")){
        jQuery(document).on('input','.be-pb-module-search-input',function(){
            if(jQuery('body').hasClass("single-tatsu_forms")){
                jQuery(document).find('.be-pb-module-list-area').find('.be-pb-Tatsu.Forms-card').parent('.be-pb-modulelist-card').remove();
            }else{
                jQuery(document).find('.be-pb-module-list-area').find('.be-pb-Spyro.Form-card').parent('.be-pb-modulelist-card').remove();
            }
        });
    }

    //SPYRO FORM IN TATSU FORMS BUILDER
    if(jQuery('body').hasClass("tatsu-page-builder") && jQuery('body').hasClass("single-tatsu_forms")){
        jQuery('#tatsu-preview').load(function(){
            var iframe = jQuery('#tatsu-preview').contents();
            setTimeout(function(){
                //remove header, footer, add section, drag section icons 
                var style_tag = '<style>#tatsu-selection-tooltip, .be-pb-section-adder, .exp-post-single-header-wrap, .tatsu-add-tools-helper, .tatsu-add-tools-icon-wrapper,.tatsu-add-tools-helper,.exp-post-single-footer, .exp-post-single .exp-posts-nav{display: none;}</style>';
                iframe.find('head').append(style_tag);
                // iframe.find('.exp-post-single-header-wrap').first().remove();
                // iframe.find('.tatsu-add-tools-helper').remove();
                // iframe.find('.exp-post-single-footer').first().remove();
                //Disable Add New section
                jQuery(document).find('.be-pb-section-adder').css('pointer-events','none');
                
                
                //select spyro form module
                var forms = iframe.find(".spyro-form").length;
                var tatsu_empty_col = iframe.find(".tatsu-empty-col");
                if (typeof forms !=='undefined' && forms){
                    //alert("already have form");
                } else if(typeof tatsu_empty_col !=='undefined'){
                    //Auto select spyro form
                    tatsu_empty_col.click();
                    setTimeout(function(){ 
                        var spyro_module = jQuery(document).find('.be-pb-module-list-area').find('.be-pb-Spyro.Form-card').parent('.be-pb-modulelist-card');
                        spyro_module.trigger('click');
                    },500);
                }
            },350);

            iframe.on('click',".tatsu-empty-col",function(){
                var forms = iframe.find(".spyro-form").length;
                if (typeof forms !=='undefined' && forms){
                    alert("You have already added a form.");
                } else {
                    setTimeout(function(){ 
                        var spyro_module = jQuery(document).find('.be-pb-module-list-area').find('.be-pb-Spyro.Form-card').parent('.be-pb-modulelist-card');
                        spyro_module.trigger('click');
                    },500);
                }
            });

            jQuery(document).on('click','.be-pb-leftPanel-tab-link',function(){
                setTimeout(function(){ 
                    //Disable Add New section
                    jQuery(document).find('.be-pb-section-adder').css('pointer-events','none');
                },100);
            })
            
            
        });
    }
});