(function($){
    /*
   * This plugin expects a hidden div to be present after the form field. On bringing focus to the field,
   * the div will be unhidden. On bringing focus out of the field, the div will be hidden.
   */
    $.fn.formTipHelper = function(){
        return this.each(function(i, v){
            $(v).focus(function(){
                $(v).next('div').fadeIn(200);
            });
            $(v).blur(function(){
                $(v).next('div').fadeOut(400);
            });
        });
    }
})(jQuery);