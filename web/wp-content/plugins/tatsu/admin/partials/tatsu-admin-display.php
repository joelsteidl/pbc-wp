<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.brandexponents.com
 * @since      1.0.0
 *
 * @package    Tatsu
 * @subpackage Tatsu/admin/partials
 */


if( !function_exists( 'tatsu_global_section_settings_options' ) ){
    function tatsu_global_section_settings_options(){


        $title_content = '<h1> Tatsu Global Section Settings </h1>';

        echo  '<div class="tatsu_global-section-settings" > 
                '.$title_content.'
                <div id="tatsu_global_section_settings_wrap"></div>
                <div id="tatsu_add-new-ruleset" > Add New Ruleset  </div>
                <div class="global-section-btn-wrap" >
                <button id="tatsu_global_section_settings_submit" class="button button-primary" type="button"  > Save </button>
                <a id="tatsu_global_section_settings_export" class="tatsu-global-section-export" > Export </a>
                </div>
              </div>';
        ?>

        <form style="margin:20px;" method="post" id="tatsu_global_section_settings_form" action="options.php">
            <textarea id="tatsu_global_Section_hidden_field" style="display:none;"  name="tatsu_global_section_data" ></textarea>
        <?php
        settings_fields( 'tatsu_global_section_settings' );
        do_settings_sections( 'tatsu_global_section_settings' );
        

        echo '</form>';
    }
}

if( !function_exists( 'tatsu_global_section_settings_on_posts_callback' ) ) {
    function tatsu_global_section_settings_on_posts_callback( $post ){

        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'tatsu_global_settings_on_post_nonce', 'tatsu_global_settings_on_post_nonce' );

        $position_values = get_post_meta(get_the_ID() , '_tatsu_global_section_on_post', true );

        $global_section_array = tatsu_get_global_sections();

        if( empty( $position_values ) ){
            $position_values = array();
        }
        $section_value_top = array_key_exists( 'top', $position_values ) ? $position_values[ 'top' ] : '';								
        $global_section_list_for_top = tatsu_get_select_box_content_post( $global_section_array, $section_value_top );

        $section_value_penultimate = array_key_exists( 'penultimate', $position_values ) ? $position_values[ 'penultimate' ] : '';			

        $global_section_list_for_penultimate = tatsu_get_select_box_content_post( $global_section_array, $section_value_penultimate );


        $section_value_bottom = array_key_exists( 'bottom', $position_values ) ? $position_values[ 'bottom' ] : '';	
        $global_section_list_for_bottom = tatsu_get_select_box_content_post( $global_section_array, $section_value_bottom );



        $title_content = '<h1> Tatsu Global Section Settings </h1>';
        
        $top_content = '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Top</label><select name="position_top"  >'.$global_section_list_for_top.'</select></div>';
        $penultimate_content = '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Penultimate</label><select  name="position_penultimate"  >'.$global_section_list_for_penultimate.'</select></div>';
        $bottom_content = '<div class="be-settings-page-option" ><label class="be-settings-page-option-label" >Bottom</label><select name="position_bottom"  >'.$global_section_list_for_bottom.'</select></div>';

        echo $top_content . $penultimate_content . $bottom_content;
    }
}

if( !function_exists( 'tatsu_get_select_box_content_post' ) ) {
    function tatsu_get_select_box_content_post( $global_section_array, $position_val ){

        $temp_content = '<option value="inherit" '.( $position_val === 'inherit' ? "selected" : " "  ) .'   >Inherit</option>';
        $temp_content .= '<option value="none" '.( $position_val === 'none' ? "selected" : " "  ) .'  >None</option>';
        foreach ($global_section_array as $key => $value) {
            $temp_content .= '<option value="'.$key.'" '. ( $position_val === (string) $key ? "selected" : " "  ) .' >'.$value.'</option>';
        }
        return $temp_content;
    }
}

?>