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


        $title_content = '<h1> Global Section Settings </h1>';
        
        echo  '<div class="tatsu_global-section-settings" > '.$title_content.'<div id="tatsu_global_section_settings_wrap"></div><div id="tatsu_add-new-ruleset" > Add New Ruleset  </div><button id="tatsu_global_section_settings_submit" class="button button-primary" type="button"  > Save </button></div>';
        ?>

        <form style="margin:20px;" method="post" id="tatsu_global_section_settings_form" action="options.php">
            <textarea id="tatsu_global_Section_hidden_field" style="display:none;"  name="tatsu_global_section_data" ></textarea>
        <?php
        settings_fields( 'tatsu_global_section_settings' );
        do_settings_sections( 'tatsu_global_section_settings' );
        

        echo '</form>';
    }
}

?>