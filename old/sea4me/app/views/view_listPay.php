<!-- Included Style Sheets --> 
<link href="<?php echo base_url() . 'css/views/checkout.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/tabber.css'; ?>" media="screen" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url(); ?>js/prototype.js" type="text/javascript"></script>

<!-- End of style sheet inclusion -->

<script src="<?php echo base_url(); ?>js/tooltips_good.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/tabber-minimized.js" type="text/javascript"></script>

<style type="text/css">
    span.optional_usd{display:none !important;}
</style>
<div class="narrow_page_bg rounded_most relative">
    <div class="rounded_more drop_shadow_standard" id="book_it">

        <?php echo form_open('listpay'); ?>

        <?php
        $value = '';
        if ($result[0]->is_installed == 1 && $result[0]->is_active == 1) {
            $showPE = '';
            if ($value == '') {
                $value = 'cc';
            }
        } else {
            $showPE = ' payment_method_hidden';
        }

        if ($result[1]->is_installed == 1 && $result[1]->is_active == 1) {
            $showP = '';
            if ($value == '') {
                $value = 'paypal';
            }
        } else {
            $showP = ' payment_method_hidden';
        }

        if ($result[2]->is_installed == 1 && $result[2]->is_active == 1) {
            $show2C = '';
            if ($value == '') {
                $value = '2c';
            }
        } else {
            $show2C = ' payment_method_hidden';
        }
        ?>

        <div id="payment_options" class="book_it_section">
            <div class="clsH1_long_Border">
                <h1><?php echo translate("Payment options"); ?> <span id="country_name" style="display:none;"></span></h1>
            </div>

            <div class="payment_tabs">

                <div class="payment_method_content<?php echo $showPE; ?>" id="payment_method_cc">
                    <input id="payment_method_cc_currency" name="payment_method_cc_currency" type="hidden" value="USD" />
                    <h2 id="cccccccc"><?php echo translate("Credit Card"); ?></h2>

                    <center><img src="http://www.paymentexpress.com/dpslogo.gif"></center>

                    <table  align="center" width="550" style="FONT-SIZE: 10pt;margin-top:15px; FONT-FAMILY: Arial, Helvetica, sans-serif" border="0">
                        <tr>
                            <td>
                                <table align="center" style="FONT-SIZE: 10pt; FONT-FAMILY: Arial, Helvetica, sans-serif">
                                    <tr>
                                        <td colspan="2"><?php echo translate("Name (as it appears on the card)"); ?><BR>
                                            <input type="text" name="CardName" value=""  size="26">
                                            <?php echo form_error('CardName'); ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="margin-left:10px;"><?php echo translate("Expiry Date"); ?><BR>
                                            <select name="ExMnth"><option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                            <select name="ExYear"><option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                            </select><br><br>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2"><?php echo translate("Card Number"); ?><br>
                                            <input type="text" name="CardNum" value="" maxlength="16" size="26">
                                            <?php echo form_error('CardNum'); ?>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>
                    </table>



                    <div class="clear"></div>
                </div>
                <input type="hidden" value="<?php echo $id; ?>" name="listId">


                <div id="payment_method_paypal" class="payment_method_content<?php echo $showP; ?>" title="">
                    <input type="hidden" value="USD" name="payment_method_paypal_currency" id="payment_method_paypal_currency">
                    <h2><?php echo translate("PayPal"); ?></h2>
                    <div class="currency_alert"><?php echo translate("This payment transacts in"); ?> $USD. <?php echo translate("Your total charge is"); ?> $<?php echo $amt; ?>.</div>

                    <p class="payment_method_explanation paypal_explanation">
                        <span style="font-weight:bold;"><?php echo translate("Instructions:"); ?></span>
                        <br>
                        <?php echo translate("After clicking 'Book it' you will be redirected to PayPal to complete payment."); ?>
                        <span style="font-weight:bold;">
                            <?php echo translate("You must complete the process or the transaction will not occur."); ?>
                        </span>
                    </p>

                    <div class="clear"></div>
                </div>

                <div id="payment_method_2c" class="payment_method_content<?php echo $show2C; ?>" title="">
                    <h2><?php echo translate("2Checkout"); ?></h2>
                    <div class="currency_alert"><?php echo translate("This payment transacts in"); ?> $USD. <?php echo translate("Your total charge is"); ?> $<?php echo $amt; ?>.</div>

                    <p class="payment_method_explanation paypal_explanation">
                        <span style="font-weight:bold;"><?php echo translate("Instructions:"); ?></span>
                        <br>
                        <?php echo translate("After clicking 'Book it' you will be redirected to PayPal to complete payment."); ?>
                        <span style="font-weight:bold;">
                            <?php echo translate("You must complete the process or the transaction will not occur."); ?>
                        </span>
                    </p>

                    <div class="clear"></div>
                </div>


            </div>
        </div>

        <input type="hidden" value="<?php echo $value; ?>" name="payment_method" id="payment_method">

        <div class="book_it_section" style="padding-bottom:10px;">
            <p id="book_it_fine_print" style='width:592px; overflow:hidden;'><input type="checkbox" style="width:20px; float:left;" id="agrees_to_terms" name="agrees_to_terms" onclick="$('p4_book_it_button').disabled = '';" /><span style="display:block; float:left; padding-left:6px;"><?php translate("I agree the terms and conditions.", $this->session->userdata('lang')); ?></span></p>

            <input type="submit" class="big_green_butt" id="p4_book_it_button" name="book_it_button" value="<?php echo translate("Book it"); ?>" style="margin:10px 0 0 10px;"/>


        </div>

        <?php echo form_close(); ?>
    </div>
</div>				
<script>

    var alreadySubmitted = false;

    function clean_up_and_book_it(){

        if(alreadySubmitted === false){

            $('p4_book_it_button').disabled = 'disabled';
            $('p4_book_it_button').setStyle({cursor:'progress'});
            $('book_it_click_message').show();

            for(x = 0; x < fields_to_clear_on_submit.size(); x++){
                f = fields_to_clear_on_submit[x];
                if(f.defaultValue == f.value){
                    f.value = '';
                }
            }

            $('book_it_form').submit();

            alreadySubmitted = true;
        } else {
            //this is a double submit
            return false;
        }

    }


    function apply_error_class_to_ajax_fields_with_errors(){
        error_count = ajax_fields_with_errors.size();
        for(i=0;i<error_count;i++){
            if($(ajax_fields_with_errors[i])){
                $(ajax_fields_with_errors[i]).addClassName('error');
            }
        }

    }

    function update_labels_if_js(){
        move_all_labels_to_adjacent_inputs();
        remove_if_js();
    }

    function select_active_tab(){
        if($('payment_method_tab_link_' + payment_method_value)){
            $('payment_method_tab_link_' + payment_method_value).onclick();
        }
        else{
            //default to showing CC instead of nothing
            $('payment_method_tab_link_<?php echo $value; ?>').onclick();
        }
    }

    function update_p4_book_it_button(method){
        $('p4_book_it_button').value = "Book it using" + " " + method;
    }

    function move_all_labels_to_adjacent_inputs(){
        $$('label.inner_text').each(function(e){
            move_label_to_input(e);
        });
    }

    function move_label_to_input(e){
        input_field = e.next('input');

        user_value = input_field.value;
        input_field.defaultValue = e.innerHTML;
        input_field.value = e.innerHTML;

        if(user_value.length == 0){
            //input_field.defaultValue = e.innerHTML;
        } else {
            input_field.value = user_value;
            input_field.addClassName('active');
        }

        input_field.observe('focus', function(){
            if(this.value==this.defaultValue) { this.value=''; this.addClassName('active'); }
            this.removeClassName('error');
        });
        input_field.observe('blur', function(){
            if(this.value=='') { this.value=this.defaultValue; this.removeClassName('active');} else { this.removeClassName('error'); }
        });

        fields_to_clear_on_submit.push(input_field);
        e.remove(); 
    }

    function remove_if_js(){
        $$('.remove_if_js').each(function(e){
            e.remove(); 
        });
    }

    jQuery('document').ready(function(){
        $('p4_book_it_button').disabled = 'disabled';

        fields_to_clear_on_submit = new Array();

        ajax_fields_with_errors = new Array();

        move_all_labels_to_adjacent_inputs();
        remove_if_js();

        payment_options_tabber_obj = tabberAutomatic();
<?php if ($result[0]->is_installed == 1 && $result[0]->is_active == 1) { ?>
            addTab('Credit Card', 'payment_method_cc', 'cc');
<?php } if ($result[1]->is_installed == 1 && $result[1]->is_active == 1) { ?>
            addTab('Paypal', 'payment_method_paypal', 'paypal');
<?php } if ($result[2]->is_installed == 1 && $result[2]->is_active == 1) { ?>
            addTab('2Checkout', 'payment_method_2c', '2c');
<?php } ?>


        select_active_tab();

        $('payment_method').value = payment_method_value;
        jQuery('#existing_cc').change();

        jQuery('#agrees_to_terms').click(function(){
								
            if($('agrees_to_terms').checked)
            {
                $('p4_book_it_button').disabled = ''; 
            }
            else
            {
                $('p4_book_it_button').disabled = 'disabled'; 
            }
        }); 

    });

    var payment_method_value = '<?php echo $value; ?>';
</script>