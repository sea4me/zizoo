(function($){

  $.fn.currencychanger = function(currencyinfo){
    var prev_currency = this.val();

    return this.change(function(eventObject){
        new_currency = jQuery(this).val();
        var ci = currencyinfo[new_currency];
        var fx_rate = ci['rate'] / currencyinfo[prev_currency]['rate'];

        jQuery('.currency_symbol').html(ci['symbol']);
        jQuery('.currency_symbol + input[type="text"]').val(function(index, value){ return value == "" ? "" : parseInt(Math.round(value * fx_rate)); });

        prev_currency = new_currency;
    });
  };
})(jQuery);
