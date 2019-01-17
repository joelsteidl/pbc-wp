<?php
    if( !function_exists( 'tatsu_star_rating' ) ) {
        function tatsu_star_rating( $atts, $content ) {
            $atts = shortcode_atts( array (
                'rating'            => '',
                'alignment'         => 'left',
                'range_color'       => '',
                'fill_color'        => '',
                'margin'            => '',
                'animate' => 0,
                'animation_type' => 'fadeIn',
                'animation_delay' => 0,
                'key' => be_uniqid_base36(true),
            ), $atts );
            extract( $atts );

            $animate = ( isset( $animate ) && 1 == $animate ) ? ' tatsu-animate' : '';

            $classes = array( 'tatsu-module', 'tatsu-star-rating', 'tatsu-'. $key );
            $custom_style_tag  = be_generate_css_from_atts( $atts, 'tatsu_star_rating', $atts['key'] );

       

            if( !empty( $alignment ) ) {
                $classes[] = 'tatsu-star-rating-align-' . $alignment;
            }else {
                $classes[] = 'tatsu-star-rating-align-left';
            }

            $rating = !empty( $rating ) && is_numeric( $rating ) ? (float)$rating : 5;
            $filled_width = ( $rating/5 ) * 100;
            $filled_style = sprintf( 'style = "width : %s%%";', $filled_width );

            ob_start();
            ?>
                <div class = "<?php echo implode( ' ', $classes ); ?>">
                    <?php echo $custom_style_tag; ?>
                    <div class = "tatsu-star-rating-inner <?php echo $animate;?>" data-animation="<?php echo $animation_type;?>" data-animation-delay=" <?php echo $animation_delay;?>" >
                        <div class = "tatsu-star-rating-range">
                            <span class = "tatsu-star-rating-star">   
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg> 
                            </span>                                  
                            <span class = "tatsu-star-rating-star">    
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>         
                            </span>                                 
                            <span class = "tatsu-star-rating-star">     
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>      
                            </span>                                 
                            <span class = "tatsu-star-rating-star">    
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>    
                            </span>                                 
                            <span class = "tatsu-star-rating-star">           
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1189 6866 1190.9 6871.348 1196 6871.348 1191.838 6874.488 1193.327 6880 1189 6876.695 1184.675 6880 1186.162 6874.488 1182 6871.348 1187.1 6871.348" transform="translate(-1182 -6866)"/></svg>     
                            </span>    
                        </div>
                        <div <?php echo $filled_style; ?> class = "tatsu-star-rating-filled">
                            <span class = "tatsu-star-rating-star">    
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
                            </span>                                  
                            <span class = "tatsu-star-rating-star">    
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
                            </span>                                 
                            <span class = "tatsu-star-rating-star">     
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
                            </span>                                 
                            <span class = "tatsu-star-rating-star">    
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>    
                            </span>                                 
                            <span class = "tatsu-star-rating-star">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"><polygon points="1170 6866 1171.9 6871.348 1177 6871.348 1172.838 6874.488 1174.327 6880 1170 6876.695 1165.675 6880 1167.162 6874.488 1163 6871.348 1168.1 6871.348" transform="translate(-1163 -6866)"/></svg>
                            </span>    
                        </div>
                    </div>
                </div>
            <?php
            return ob_get_clean();
        }
        add_shortcode( 'tatsu_star_rating', 'tatsu_star_rating' );
    }