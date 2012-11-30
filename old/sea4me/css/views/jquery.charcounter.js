(function($){
    $.fn.charCounter = function(charLimit){
        return this.each(function(i, e){
            // find the character counter container by finding the first sibling element
            // with the 'countvalue' class.
            var statusEl = $(this).siblings('.countvalue:first');

            jQuery(e).keyup(function(){
                var charsLeft = charLimit - jQuery(this).val().length;
                statusEl.html(charsLeft);

                if(charsLeft <= 0){
                    statusEl.addClass('error');
                    statusEl.removeClass('warning');
                }
                else if(charsLeft <= 5){
                    statusEl.removeClass('error');
                    statusEl.addClass('warning');
                }
                else {
                    statusEl.removeClass('error');
                    statusEl.removeClass('warning');
                }
            });

            // trigger this once in the beginning to set the initial state
            jQuery(e).keyup();
        });
    };
})(jQuery);