(function($){

    FLBuilder._registerModuleHelper('bb-seriesengine', {
        
        rules: {
            pag: {
                required: true
            },
            apag: {
                required: true
            }
        },

        init: function()
        {
            
        },
        
        submit: function()
        {
           var result = confirm('Save your changes to this instance of Series Engine?');
            
            return result; 
        }
    });

})(jQuery);