(function($){
    var addToggleButton = function() {
            var buttonHtml = $($('#tatsu-gutenberg-switch-button').html()),
                gutenberg = $('#editor');
            if( '1' ===  TatsuGutenbergSettings.editedWithTatsu ) {
                buttonHtml.on('click', function(e) {
                    e.preventDefault();
                    showWarningModal();
                });
            }
            if( 0 < gutenberg.length ) {
                gutenberg.find('.edit-post-header-toolbar').append(buttonHtml);
            }
        },
        showWarningModal = function() {
            var modal = $($('#tatsu-switch-to-gutenberg').html());
            $('body').append(modal);
        }
        addTatsuPanel = function() {
            var tatsuEditorPanel = $($('#tatsu-gutenberg-editor-panel').html()),
                gutenbergBlockList = $('#editor').find('.editor-block-list__layout, .editor-post-text-editor');
            if( 0 < gutenbergBlockList.length ) {
                gutenbergBlockList.after(tatsuEditorPanel);
            }
        };
    $(function() {
        setTimeout(function() {
            addToggleButton();
            addTatsuPanel();
        }, 0)
    })
})(jQuery)