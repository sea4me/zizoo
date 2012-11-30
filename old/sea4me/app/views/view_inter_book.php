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

    <?php
    //Show Flash Message
    if ($msg = $this->session->flashdata('flash_message')) {
        echo $msg;
    }
    ?>

    <div id="book_it" class="rounded_more drop_shadow_standard">



        <?php echo form_open('paypal/index/' . $id); ?>

        <input id="hosting_id" name="hosting_id" type="hidden" value="<?php echo $id; ?>" />
        <input id="checkin" name="checkin" type="hidden" value="<?php echo $checkin; ?>" />
        <input id="checkout" name="checkout" type="hidden" value="<?php echo $checkout; ?>" />
        <input id="number_of_guests" name="number_of_guests" type="hidden" value="<?php echo $guests; ?>" />


        <div id="how_it_works" class="book_it_section">
            <div class="clsH1_long_Border">
                <h1><?php echo translate("1. How it works"); ?></h1></div>

            <div class="content_box">
                <p>
                    <?php echo translate("Please provide your billing details now and the place shall be booked for your purpose"); ?>

                </p>

                <div class="clear"></div>
            </div>

        </div>

        <div id="property_details" class="book_it_section">
            <div class="clsH1_long_Border">
                <h1><?php echo translate("2. Property details"); ?></h1></div>
            <div class="content_box">
                <img src=<?php echo $this->Gallery->helper_image($id); ?> height="140" width="210" class="main_photo"/>

                <div id="hosting_details">

                    <h2><a href=<?php echo base_url() . 'rooms/' . $id; ?> target="_blank"><?php echo $tit; ?></a></h2>
                    <div id="hosting_address" class="rounded_more">
                        <?php echo $address; ?>
                    </div>
                    <div class="clear"></div>
                    <p><?php echo $room_type; ?><!-- <a class="tooltip" title="Bed Type"><img alt="Questionmark_hover" src="https://d2zqixp6jsrrm.cloudfront.net/1300304855/images/icons/questionmark_hover.png" style="width:12px; height:12px;" /></a>--></p>
                    <p><?php echo translate("Accommodates "); ?><?php echo $guests; ?> <?php echo translate("guests"); ?></p>

                </div>
                <div class="clear"></div>
            </div>
        </div>

        <div id="trip_details" class="book_it_section">
            <div class="clsH1_long_Border"> <h1><?php echo translate("3. Trip Details"); ?></h1></div>


            <ul id="details_breakdown" class="dashed_table">

                <li class="top">
                    <span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Check in"); ?></span></span>
                    <span class="data"><span class="inner"> <?php echo $checkin; ?> <em class="check_in_out_time"><?php echo translate("(Flexible check in time)"); ?></em></span></span>
                </li>
                <li>
                    <span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Check out"); ?></span></span>
                    <span class="data"><span class="inner"> <?php echo $checkout; ?> <em class="check_in_out_time"><?php echo translate("(Flexible check out time)"); ?></em></span></span>

                </li>
                <li>
                    <span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Nights"); ?></span></span>
                    <span class="data"><span class="inner"><?php echo $days; ?></span></span>
                </li>
                <li class="bottom">
                    <span class="label"><span class="inner"><span class="checkout_icon" id="icon_person"></span><?php echo translate("Guests"); ?></span></span>

                    <span class="data"><span class="inner"><?php echo $guests; ?></span></span>
                </li>
                <div class="clear"></div>
            </ul>

            <ul id="price_breakdown" class="dashed_table">
                <li class="top">
                    <span class="label">
                        <span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Rate (per night)"); ?>


                        </span>
                    </span>
                    <span class="data">
                        <span class="inner">
                            $<?php echo $price; ?><sup></sup><span class="optional_usd"><?php //echo translate("/$15");   ?></span>
                        </span>
                    </span>
                </li>

                <li>
                    <span class="label"><span class="inner"><span class="checkout_icon" id="icon_calc"></span>
                            <?php echo translate("Subtotal"); ?>
                        </span></span>
                    <span class="data">
                        <span class="inner">
                            $<?php echo $subtotal; ?><sup></sup><span class="optional_usd"><?php //echo translate("/$46");  ?></span>

                        </span>
                    </span>
                </li>



                <li>
                    <span class="label">
                        <span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Commission"); ?>
                        </span>
                    </span>
                    <span class="data">
                        <span class="inner">
                            $<?php echo $commission; ?>
                        </span>
                    </span>
                </li>

                <li class="bottom" id="total">
                    <span class="label"><span class="inner"><span class="checkout_icon icon_star"></span><?php echo translate("Total"); ?></span></span>
                    <span class="data">
                        <span class="inner">
                            $<?php echo $amt; ?>

                            <sup></sup><span class="optional_usd"><?php echo translate("/$52"); ?><sup><?php echo translate("USD"); ?></sup></span>
                        </span>

                    </span>
                </li>
            </ul>
        </div>

        <?php echo form_close(); ?>

        <?php if ($full_cretids == 'off') { ?>

            <?php echo form_open('paypal/payment/' . $id); ?>

            <?php
            $value = '';


            if ($result[0]->is_installed == 1 && $result[0]->is_active == 1) {
                $showP = '';
                if ($value == '') {
                    $value = 'paypal';
                }
            } else {
                $showP = ' payment_method_hidden';
            }
            ?>

            <div id="payment_options" class="book_it_section">
                <div class="clsH1_long_Border">
                    <h1><?php echo translate("4. Payment options"); ?> <span id="country_name" style="display:none;"></span></h1>
                </div>

                <div class="payment_tabs">


                    <!-- #payment_method_cc -->

                    <div id="payment_method_paypal" class="payment_method_content<?php echo $showP; ?>" title="">
                        <input type="hidden" value="USD" name="payment_method_paypal_currency" id="payment_method_paypal_currency">
                        <h2><?php echo translate("PayPal"); ?></h2>
                        <div class="currency_alert"><?php echo translate("This payment transacts in"); ?> $USD. <?php echo translate("Your total charge is"); ?> $<?php echo $amt; ?>.</div>

                        <p class="payment_method_explanation paypal_explanation">
                            <span style="font-weight:bold;"><?php echo translate("Instructions"); ?>:</span>
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


            <div id="policies" class="book_it_section">
                <div class="clsH1_long_Border">
                    <h1><?php echo translate("5. Policies"); ?></h1></div>
                <ul class="dashed_table">
                    <li class="top">
                        <span class="label">
                            <span class="inner"><span class="checkout_icon" id="icon_crossed_out"></span><?php echo translate("Cancellation"); ?></span>
                        </span>
                        <span class="data">

                            <span class="inner">
                                <a href="javascript:void(0);" onclick="show_super_lightbox('cancel_policy_data'); return false;" target="_blank"><?php echo translate("Flexible"); ?></a>
                            </span>
                        </span>
                    </li>
                    <li class="bottom">
                        <span class="label">
                            <span class="inner"><span class="checkout_icon" id="icon_house"></span><?php echo translate("House Rules"); ?></span>

                        </span>
                        <span class="data">
                            <span class="inner">
                                <a href="#" onclick="show_super_lightbox('house_rules_data'); return false;" target="_blank"><?php echo translate("Read Policy"); ?></a>
                                <a href="#" onclick="return false;"></a>
                            </span>
                        </span>
                    </li>


                    <div class="clear"></div>
                </ul>
            </div>

            <input type="hidden" value="<?php echo $value; ?>" name="payment_method" id="payment_method">

            <div class="book_it_section" style="padding-bottom:10px;">
                <p id="book_it_fine_print" style='width:592px; overflow:hidden;'><input type="checkbox" style="width:20px; float:left;" id="agrees_to_terms" name="agrees_to_terms" onclick="$('p4_book_it_button').disabled = '';" /><span style="display:block; float:left; padding-left:6px;"><?php echo translate("I agree to the cancellation policy and house rules."); ?></span></p>



                <input type="hidden" value=<?php echo $checkin; ?> name="checkin" />
                <input type="hidden" value=<?php echo $checkout; ?> name="checkout" />
                <input type="hidden" value=<?php echo $guests; ?> name="number_of_guests" />



                <input type="submit" class="big_green_butt" id="p4_book_it_button" name="book_it_button" value="<?php echo translate("Book it"); ?>" style="margin:10px 0 0 10px;"/>



            </div>

            <?php echo form_close(); ?>

        <?php } else { ?>

            <div id="policies" class="book_it_section">
                <div class="clsH1_long_Border">
                    <h1><?php echo translate("4. Policies"); ?></h1></div>
                <ul class="dashed_table">
                    <li class="top">
                        <span class="label">
                            <span class="inner"><span class="checkout_icon" id="icon_crossed_out"></span><?php echo translate("Cancellation"); ?></span>
                        </span>
                        <span class="data">

                            <span class="inner">
                                <a href="http://www.cogzidel.com/home/cancellation_policies" onclick="show_super_lightbox('cancel_policy_data'); return false;" target="_blank"><?php echo translate("Flexible"); ?></a>
                            </span>
                        </span>
                    </li>
                    <li class="bottom">
                        <span class="label">
                            <span class="inner"><span class="checkout_icon" id="icon_house"></span><?php echo translate("House Rules"); ?></span>

                        </span>
                        <span class="data">
                            <span class="inner">
                                <a href="#" onclick="show_super_lightbox('house_rules_data'); return false;" target="_blank"><?php echo translate("Read Policy"); ?></a>
                                <a href="#" onclick="return false;"></a>
                            </span>
                        </span>
                    </li>


                    <div class="clear"></div>
                </ul>
            </div>
            <p id="book_it_fine_print" style='width:592px; overflow:hidden;'><input type="checkbox" style="width:20px; float:left;" id="agrees_to_terms" name="agrees_to_terms" onclick="$('p4_book_it_button').disabled = '';" /><span style="display:block; float:left; padding-left:6px;"><?php echo translate("I agree to the cancellation policy and house rules."); ?></span></p>

            <?php echo form_open('referrals/booking/' . $this->uri->segment(3)); ?>

            <input type="hidden" value=<?php echo $checkin; ?> name="checkin" />
            <input type="hidden" value=<?php echo $checkout; ?> name="checkout" />
            <input type="hidden" value=<?php echo $guests; ?> name="number_of_guests" />	
            <input type="submit" class="v3_button" id="p4_book_it_button" name="book_it_button" value="<?php echo translate("Book it"); ?>" style="margin:10px 0 0 10px;"/>
            <?php echo form_close(); ?>

        <?php } ?>

        <!-- /Form -->
    </div><!-- #book_it -->
</div><!-- .narrow_page_bg -->

<div id="cancel_policy_data" class="super_lightbox">
    <a class="hide_super_lightbox" href="javascript:void(0);" onclick="hide_super_lightbox('cancel_policy_data'); return false;"><?php translate("[X] Close", $this->session->userdata('lang')); ?></a>
    <!-- <h3><?php echo translate("Flexible Cancellation Policy"); ?></h3>  -->


    <h4><?php echo translate("Flexible: Full refund 1 day prior to arrival, except fees"); ?></h4>
    <ul>
        <li><?php echo translate("Must be made a full 24 hours prior to 12:00 AM local time on the day of check in.  For example, if check-in is on Friday, cancel by the previous Wednesday at midnight."); ?></li>
        <li><?php echo translate("If the guest arrives and decides to leave early, the nights not spent 24 hours after the official cancellation are 100% refunded."); ?></li>
        <li><?php echo translate("If the guest cancels less than 24 hours before check-in, the first night is non-refundable."); ?></li>
        <li><?php echo translate("If the guest cancels after the check-in date, the nights beginning 24 hours after the cancellation will be refunded."); ?></li>

        <li><?php echo translate("Cleaning fees are always refunded if the guest did not check in."); ?></li>
        <li><?php echo translate("The Cogzidel service fee is non-refundable."); ?></li>
        <li><?php echo translate("If there is a complaint from either party, notice must be given to Cogzidel within 24 hours of check-in."); ?></li>
        <li><?php echo translate("Cogzidel will mediate when necessary, and has the final say in all disputes."); ?></li>
        <li><?php echo translate("A reservation is not officially canceled until the guest receives a cancellation confirmation e-mail from Cogzidel. To get your cancellation e-mail, go to Travel Plans."); ?></li>

    </ul>


</div>

<div id="house_rules_data" class="super_lightbox">
    <a class="hide_super_lightbox" href="javascript:void(0);" onclick="hide_super_lightbox('house_rules_data'); return false;"><?php translate("[X] Close"); ?></a>

    <h3><?php echo translate("House Rules"); ?></h3>
    <h4><?php echo $this->Gallery->gethouserules($id); ?></h4>
</div>


<div id="security_deposit_data" class="super_lightbox">
    <a class="hide_super_lightbox" href="javascript:void(0);" onclick="hide_super_lightbox('security_deposit_data'); return false;"><?php translate("[X] Close"); ?></a>

    <p style="margin:10px 0;">
        <?php echo translate("If the host reports a problem, we will capture the entire authorized amount while we gather additional information from both parties. If a compromise is

        reached, we will refund the agreed upon amount. Although it is primarily up to the host to determine the extent of the damage, Cogzidel tracks every claim

        that is made, and if a host develops a trend of claiming damages in order to keep the security deposit, the host may removed from " . $this->dx_auth->get_site_title() . "."); ?>
    </p>

</div>


<div id="pricing_explanation" class="super_lightbox">
    <a class="hide_super_lightbox" href="javascript:void(0);" onclick="hide_super_lightbox('pricing_explanation'); return false;"><?php translate("[X] Close"); ?></a>

    <h3><?php echo translate("Subtotal Breakdown"); ?></h3>

    <p style="margin: 10px 0 0 0;">
        <?php echo translate("A variety of factors contribute to how the subtotal is calculated. Below is a detailed explanation."); ?>
    </p>

    <?php echo translate("&lt;br /&gt;06/24/2011 has daily price of  $16 USD (variable)&lt;br /&gt;06/25/2011 has daily price of  $15 USD (default)&lt;br /&gt;06/26/2011 has daily price of  $15 USD (default)&lt;br /&gt;Total price is $46 USD"); ?>

</div>

<div id="transparent_bg_overlay"></div>

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
    function update_payment_options(country_code){
        $('ajax_method_spinner').show();

        //alert("update_payment_options");

        while(global_tabber_obj.tabs.size() > 1){
            removeLastTab();
        }

        $('payment_method').value = payment_method_value;
  

        $('credit_card_country').value = country_code;
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

        addTab('Paypal', 'payment_method_paypal', 'paypal');


        select_active_tab();

        $('payment_method').value = payment_method_value;
        jQuery('#existing_cc').change();

        

       

        jQuery('input').live('keypress', function (e) {
            if ( e.keyCode == 13 ){
                if(jQuery('#coupon_code').hasClass('coupon_focus')){
                    $('submit_context').value = 'apply_coupon';
                    clean_up_and_book_it();
                }else{
                    $('submit_context').value = 'book_it_button';
                    clean_up_and_book_it();
                }
                return false;    
            }
        });
								

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