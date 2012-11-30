(function($){
    /**
   * This plugin links a navbar (consisting of an unordered list) to panel
   * content (contained in an unordered list where the elements are 1-to-1 mapped with
   * the navbar list).
   *
   * The following assumptions are made:
   *   - The plugin is invoked on a ul with some ID e.g. #<yournavid>
   *   - THe DOM contains a ul containing of the various panels with ID #<yournavid>_panels
   *   - #<yournavid>_panels contains the same number of li elements as #<yournavid>
   *   - Selected nav list items and panels will have the class "selected"
   */
    $.fn.tabberizer = function(){
        return this.each(function(){
            var _ulRef = $(this);
            var _ulId = _ulRef.attr('id');

            _ulRef.find("li").each(function(){
                $(this).click(function(){
                    var i = parseInt(_ulRef.find("li").index(this));
                    $('#' + _ulId + ', #' + _ulId + "_panels").find('li.selected').removeClass('selected');
                    $(this).addClass("selected");
                    $('#' + _ulId + "_panels").find('li:nth-child(' + (i + 1) + ')').addClass('selected');
                });
            });
        });
    }
})(jQuery);
