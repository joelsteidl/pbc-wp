//Wordpress editor js: works with both classic and gutenberg editor 
document.addEventListener("DOMContentLoaded", function(){

    //Rank math Content Analysis API Integration: rankmath.com/kb/content-analysis-api/
    if ( 'undefined' !== typeof wp.hooks && 'undefined' !== typeof TatsuWordpressEditor && '0' != TatsuWordpressEditor.post_content ) {
        var rank_math_tatsu_content = function () {
            return TatsuWordpressEditor.post_content;
        }
        wp.hooks.addFilter( 'rank_math_content', 'tatsu', rank_math_tatsu_content );
    }
});