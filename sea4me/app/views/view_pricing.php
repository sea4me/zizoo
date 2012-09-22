<!--  Stylesheets -->
<link href="<?php echo base_url(); ?>css/views/dashboard_v2.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/views/silver.css" media="screen" rel="stylesheet" type="text/css" />
<!-- End of inclusion of style sheets -->
<!-- Required Scripts -->
<script type="text/javascript">
    jQuery.noConflict();
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.3/prototype.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.2/scriptaculous.js"></script>
<script src="http://s8.muscache.com/1300304855/javascripts/calendar_date_select/calendar_date_select.js" type="text/javascript"></script>
<script src="http://s1.muscache.com/1300304855/javascripts/calendar_date_select/format_american.js" type="text/javascript"></script>
<script src="http://s5.muscache.com/1307434824/assets/common.js" type="text/javascript"></script>
<script src="http://s1.muscache.com/1301534339/javascripts/jquery.tabberizer.js" type="text/javascript"></script>
<script src="http://s1.muscache.com/1300304855/javascripts/tooltips_good.js" type="text/javascript"></script>
<script src="http://s9.muscache.com/1303024875/javascripts/jquery.currencychanger.js" type="text/javascript"></script>
<style>
    #transparent_bg_overlay{ display: none; position: fixed; top: 0%; left: 0%; width: 100%; height: 100%; background-color: black; z-index:999998; -moz-opacity: 0.5; opacity:.50; filter: alpha(opacity=50); }
    .super_lightbox { line-height:20px; display: none; position: fixed; top: 25%; left: 25%; width: 50%; padding: 16px; border: 2px solid #333333; background-color: white; z-index:999999; overflow: auto; color:#333333}
    .super_lightbox h3{font-size:21px; font-weight:bold; border-bottom:2px solid #333; margin-bottom:15px; }
    .super_lightbox a.hide_super_lightbox{font-size:15px; display:block; float:right; padding-bottom:10px; overflow:hidden; }
</style>
<script src="http://s3.muscache.com/1300304855/javascripts/jqote.js" type="text/javascript"></script>
<script src="http://s0.muscache.com/1305924789/javascripts/dashboard_v2.js" type="text/javascript"></script>
<script src="http://s0.muscache.com/1307433405/javascripts/jquery.mapshelper.js" type="text/javascript"></script>
<script type="text/x-jqote-template" id="notification-item-template">
    <![CDATA[
    <div class="<*= this.type *>">
        <span class="close"/>
        <span class="label"><*= this.label *></span>
    </div>
    ]]>
</script>
<script src="http://s4.muscache.com/1307433405/javascripts/edit_room_v2.js" type="text/javascript"></script>
<script type="text/x-jqote-template" id="availability_button_template">
    <![CDATA[
    <span class="clearfix current-availability icon <*= this.status *>">
        <span class="label"><*= this.label *></span>
        <span class="expand"></span>
    </span>
    <div class="toggle-info" style="display: none;">
        <div class="instructions"><*= this.instructions *></div>
        <div class="toggle-action-container">
            <a href="<*= this.url *>" class="toggle-action icon <*= this.next_status *>"><*= this.toggle_label *></a>
        </div>
    </div>
    ]]>
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.subnav').tabberizer();

        jQuery('#hosting_native_currency').currencychanger({"ZAR":{"rate":6.7935,"name":"Rand","symbol":"R"},"CHF":{"rate":0.8367,"name":"Swiss Francs","symbol":"CHF"},"HKD":{"rate":7.7795,"name":"Hong Kong Dollars","symbol":"$"},"EUR":{"rate":0.6856,"name":"Euro","symbol":"\u0026euro;"},"HUF":{"rate":182.33,"name":"Forint","symbol":"Ft"},"SEK":{"rate":6.1874,"name":"Sweden, Kronor","symbol":"kr"},"DKK":{"rate":5.1121,"name":"Danish Kroner","symbol":"kr"},"AUD":{"rate":0.9338,"name":"Australian Dollars","symbol":"$"},"ILS":{"rate":3.376,"name":"New Shekels","symbol":"\u0026#8362;"},"BRL":{"rate":1.582,"name":"Brazilian Reais","symbol":"R$"},"CAD":{"rate":0.9808,"name":"Canadian Dollar","symbol":"$"},"USD":{"rate":1,"name":"United States Dollars","symbol":"$"},"JPY":{"rate":80.07,"name":"Yen","symbol":"\u0026yen;"},"CZK":{"rate":16.654,"name":"Czech Koruny","symbol":"\u0026#75;\u0026#269;"},"RUB":{"rate":27.8416,"name":"Rubles","symbol":"\u0026#1088;\u0026#1091;\u0026#1073;"},"GBP":{"rate":0.6116,"name":"Pounds","symbol":"\u0026pound;"},"NOK":{"rate":5.3778,"name":"Krone","symbol":"kr"}});

        Cogzidel.Utils.initVideoLightbox('#advanced_pricing_video_link', 'Learn about Advanced Pricing', '<object width="460" height="290"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://player.vidcaster.com/v1.swf" /><param name="flashvars" value="config=http://www.vidcaster.com/embed/eFh/v1/" /><embed src="http://player.vidcaster.com/v1.swf" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" flashvars="config=http://www.vidcaster.com/embed/eFh/v1/" width="460" height="290"></embed></object>')

        jQuery('form#hosting_edit_form').submit(function(){
            var _formRef = this;
            var _spinner = jQuery('div.form-submit span.spinner', this);
            _spinner.show();

            var _submitButton = jQuery(":submit", this);
            _submitButton.attr('disabled', 'disabled');

            jQuery.ajax({
                url: "/rooms/update/135134",
                type: "POST",
                data: jQuery(this).serialize(),
                dataType: "json",
                success: function(data){
                    if(data['result'] == 'success'){
                        CogzidelDashboard.createNotificationItem('Your listing was successfully saved!', 'info', _formRef);
                    }
                    else if(data['result'] == 'error'){
                        CogzidelDashboard.createNotificationItem(data['message'], 'error', _formRef);
                    }

                    _spinner.hide();
                    _submitButton.removeAttr('disabled');
                    jQuery('html, body').animate({scrollTop: 0}, 'slow');
                }
            });

            return false;
        });

        var checkFlatMonthly;

        if (jQuery("#sublet_checkin").length) {
            checkFlatMonthly = function() {
                var dateFormat = jQuery.datepicker._defaults.dateFormat;
                var SUBLET_CROSSOVER_DAYS = 25 * 86400000; // Days * MS in one day
                var startDate = jQuery.datepicker.parseDate(dateFormat, jQuery("#sublet_checkin").val());
                var endDate = jQuery.datepicker.parseDate(dateFormat, jQuery("#sublet_checkout").val());

                if ((endDate - startDate) > SUBLET_CROSSOVER_DAYS) {
                    jQuery("#per-month-span").show();
                    jQuery("#flat-rate-span").hide();
                } else {
                    jQuery("#per-month-span").hide();
                    jQuery("#flat-rate-span").show();
                }
            }
        } else {
            checkFlatMonthly = function() {};
        }

        jQuery("#hosting_edit_form").cogzidelInputDateSpan({
            checkin: "#sublet_checkin",
            checkout: "#sublet_checkout",
            onCheckinClose: checkFlatMonthly,
            onCheckoutClose: checkFlatMonthly
        });

        jQuery("#hosting_is_sublet").change(function() {
            if (jQuery(this).is(":checked")) {
                jQuery("#hosting_sublet_dates").show();
                jQuery("#sublet_checkin, #sublet_checkout").removeAttr("disabled");
            } else {
                jQuery("#hosting_sublet_dates").hide();
                jQuery("#sublet_checkin, #sublet_checkout").attr("disabled", "disabled");
            }
        }).change(); 

        checkFlatMonthly(); 
    });

    function after_save() {
        jQuery(".spinner").hide();
        jQuery(".submit").removeAttr("disabled");
    }

    jQuery(document).ready(function(){
        jQuery('#daily_pricing_form').cogzidelInputDateSpan(); 

        jQuery('#submit_daily_pricing_form').live('submit', function(){
            var $this = jQuery(this);
            var $spinner = $this.find('.spinner').show(); 
            jQuery('#submit-error').html('');

            jQuery.getJSON($this.attr('action'), $this.serialize(), function(data){
                $spinner.hide();

                if(data.result == 'error'){
                    jQuery('#submit-error').html(data.reason);    
                }
                else {
                    jQuery('#daily_section').html(data.payload);
                    after_save();

                    jQuery('#daily_pricing_form').cogzidelInputDateSpan();
                }
            });

            return false;
        });
    });
    jQuery(document).ready(function(){
        CogzidelDashboard.init(); 

        jQuery('ul.edit_room_nav li a').click(function(){
            jQuery('ul.edit_room_nav span.icon.spinner').removeClass('spinner');
            jQuery(this).find('span.icon').addClass('spinner');
        });

    
    });

    var buttonContent = {
        active: {
            label: "Active",
            instructions: "Hide your listing to remove it from search results:",
            toggle_label: "Hide"
        },
        inactive: {
            label: "Hidden",
            instructions: "Activate your listing to have it show up in search results:",
            toggle_label: "Activate"
        }
    };

    jQuery(document).ready(function(){
        jQuery('div.set-availability').availabilityWidget(buttonContent);
    });

</script>

<?php
$id = $this->uri->segment(3);
$query = $this->db->get_where('list', array('id' => $id));
$q = $query->result();

$r = array();
$query2 = $this->db->get_where('price', array('id' => $id));
$r = $query2->result();
?>

<div id="command_center">
    <div id="dashboard_v2">
        <div class="row">
            <div class="col full heading">
                <div class="heading_content">
                    <div class="edit_listing_photo">
                        <?php
                        $images = $this->Gallery->get_images($this->uri->segment(3));
                        if (count($images) == 0) {
                            $url = base_url() . 'images/no_image.jpg';
                        } else {
                            $url = $images[0]['url'];
                        }
                        ?>
                        <img alt="Host_pic" height="65" src="<?php echo $url; ?>" /> </div>
                    <div class="listing_info">
                        <h3><?php echo anchor('rooms/' . $this->uri->segment(3), $q[0]->title, array('id' => "listing_title_banner")) ?></h3>
                        <span class="actions"> <span class="action_button"> <?php echo anchor('rooms/' . $this->uri->segment(3), translate('View Listing'), array('class' => "icon view")) ?> </span> <span id="availability-error-message"></span> </span> </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col one-fourth nav"> <?php echo anchor('hosting', translate('View All Listing'), array('class' => 'to-parent')); ?>
                <div class="nav-container">
                    <ul class="edit_room_nav">
                        <li > <a class="details" href=<?php echo base_url() . 'func/editListing/' . $this->uri->segment(3); ?>> <span class="icon"></span>Description</a> </li>
                        <li> <?php echo anchor('func/photoListing/' . $this->uri->segment(3), translate('Photos'), array('class' => 'icon')) ?> </li>

                        <li class="selected"> <a class="pricing" href=<?php echo base_url() . 'func/editpricing/' . $this->uri->segment(3); ?> ><span class="icon"></span>Pricing and Terms</a> </li>
                    </ul>
                    <ul class="edit_room_nav">
                    </ul>
                </div>
            </div>
            <div class="col three-fourths content">
                <div id="notification-area"></div>
                <div id="dashboard-content">
                    <div id="transparent_bg_overlay"></div>
                    <span id="default_daily_price" style="display: none;"></span>
                    <ul class="panels" id="nav_pricing_panels">
                        <li class="selected">
                            <form action=<?php echo base_url() . 'func/updatepricing/' . $id; ?> method="post">
                                <div class="box">
                                    <h2><span class="edit_room_icon pricing"></span><?php echo translate("Basic Pricing"); ?></h2>
                                    <div class="middle">
                                        <ul>
                                            <li>
                                                <label for="hosting_native_currency">Currency</label>
                                                <select id="hosting_native_currency" name="currency">
                                                    <option value="AUD" <?php if ($r[0]->currency == "AUD") echo 'selected="selected"'; ?>>AUD</option>
                                                    <option value="BRL" <?php if ($r[0]->currency == "BRL") echo 'selected="selected"'; ?>>BRL</option>
                                                    <option value="CAD" <?php if ($r[0]->currency == "CAD") echo 'selected="selected"'; ?>>CAD</option>
                                                    <option value="CHF" <?php if ($r[0]->currency == "CHF") echo 'selected="selected"'; ?>>CHF</option>
                                                    <option value="CZK" <?php if ($r[0]->currency == "CZK") echo 'selected="selected"'; ?>>CZK</option>
                                                    <option value="DKK" <?php if ($r[0]->currency == "DKK") echo 'selected="selected"'; ?>>DKK</option>
                                                    <option value="EUR" <?php if ($r[0]->currency == "EUR") echo 'selected="selected"'; ?>>EUR</option>
                                                    <option value="GBP" <?php if ($r[0]->currency == "GBP") echo 'selected="selected"'; ?>>GBP</option>
                                                    <option value="HKD" <?php if ($r[0]->currency == "HKD") echo 'selected="selected"'; ?>>HKD</option>
                                                    <option value="HUF" <?php if ($r[0]->currency == "HUF") echo 'selected="selected"'; ?>>HUF</option>
                                                    <option value="ILS" <?php if ($r[0]->currency == "ILS") echo 'selected="selected"'; ?>>ILS</option>
                                                    <option value="JPY" <?php if ($r[0]->currency == "JPY") echo 'selected="selected"'; ?>>JPY</option>
                                                    <option value="NOK" <?php if ($r[0]->currency == "NOK") echo 'selected="selected"'; ?>>NOK</option>
                                                    <option value="RUB" <?php if ($r[0]->currency == "RUB") echo 'selected="selected"'; ?>>RUB</option>
                                                    <option value="SEK" <?php if ($r[0]->currency == "SEK") echo 'selected="selected"'; ?>>SEK</option>
                                                    <option value="USD" <?php if ($r[0]->currency == "USD") echo 'selected="selected"'; ?>>USD</option>
                                                    <option value="ZAR" <?php if ($r[0]->currency == "ZAR") echo 'selected="selected"'; ?>>ZAR</option>
                                                </select>
                                            </li>
                                            <li>
                                                <label for="hosting_price_native"><?php echo translate("Nightly"); ?></label>
                                                <span class="currency_symbol">$</span>
                                                <input id="hosting_price_native" name="nightly" size="30" type="text" value=<?php echo $r[0]->night; ?> />
                                            </li>
                                            <li>
                                                <label for="hosting_weekly_price_native"><?php echo translate("Weekly"); ?></label>
                                                <span class="currency_symbol">$</span>
                                                <input id="hosting_weekly_price_native" name="weekly" value=<?php if ($r[0]->week) echo $r[0]->week; else echo '""'; ?> size="30" type="text" />
                                                <span class="protip">We recommend <em>$84 to $89</em> based on your nightly price</span> </li>
                                            <li>
                                                <label for="hosting_monthly_price_native"><?php echo translate("Monthly"); ?></label>
                                                <span class="currency_symbol">$</span>
                                                <input id="hosting_monthly_price_native" name="monthly" value=<?php
                        if ($r
                                [0]->month)
                            echo $r[0]->month; else
                            echo '""';
                        ?> size="30" type="text" />
                                                <span class="protip"><?php echo translate("We recommend "); ?><em>$351 to $370</em> <?php echo translate("based on your nightly price"); ?></span> </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="box">
                                    <h2><span class="edit_room_icon additional"></span><?php echo translate("Additional Costs"); ?></h2>
                                    <div class="middle">
                                        <ul>
                                            <li>
                                                <label for="hosting_price_for_extra_person_native"><?php echo translate("Additional Guests"); ?></label>
                                                <span class="currency_symbol">$</span>
                                                <input id="hosting_price_for_extra_person_native" name="extra" size="30" type="text" value=<?php if ($r[0]->addguests) echo $r[0]->addguests; else echo '""'; ?> />
                                                <span class="protip"><?php echo translate("Per night for each guest after"); ?>
                                                    <select id="hosting_guests_included" name="guests">
                                                        <option value="1" selected="selected">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                    </select>
                                                </span> </li>
                                            <li>
                                                <label for="hosting_extras_price_native"><?php echo translate("Cleaning Fees"); ?></label>
                                                <span class="currency_symbol">$</span>
                                                <input id="hosting_extras_price_native" name="cleaning" size="30" type="text" value=<?php if ($r[0]->cleaning) echo $r[0]->cleaning; else echo '""'; ?> />
                                            </li>
                                            <li>
                                                <label for="hosting_security_deposit_native"><?php echo translate("Security Deposit"); ?></label>
                                                <span class="currency_symbol">$</span>
                                                <input id="hosting_security_deposit_native" name="security" size="30" value=<?php if ($r[0]->security) echo $r[0]->security; else echo '""'; ?> type="text" />
                                                <span class="protip"><?php echo translate("This is a refundable amount"); ?></span> </li>
                                        </ul>
                                    </div>
                                </div>
                                <input class="button-glossy green" type="submit" style="margin:50px;"value="Save" />
                                <div>
                                    <div class="clear"></div>
                                </div>
                            </form>
                        </li>
                        <li>
                            <div class="box" id="daily_section">
                                <style>
                                    td.delete { width:30px; }
                                    td.amount { font-weight:bold; width:50px; }
                                    span.day_names { font-size:9px; width:60px; }
                                    td.date_range { width:250px; line-height:20px; }
                                </style>
                                <script>
                                    var g_last_currency_code = "USD";
                                    function change_native_currency() {
                                        var symbols = $H({"EEK":"kr","ZAR":"R","CHF":"CHF","HKD":"$","ARS":"$","EUR":"\u0026euro;","LVL":"Ls","NZD":"$","HUF":"Ft","MXN":"$","SEK":"kr","THB":"\u0026#3647;","COP":"$","DKK":"kr","GTQ":"Q","LTL":"Lt","AUD":"$","DOP":"RD$","ILS":"\u0026#8362;","SGD":"$","BRL":"R$","CAD":"$","HNL":"L","RON":"lei","USD":"$","UYU":"\u0026#35;\u0026#85;","CLP":"$","PLN":"\u0026#22;\u0026#322;","JPY":"\u0026yen;","BGN":"\u0026#1083;\u0026#1074;","CZK":"\u0026#75;\u0026#269;","RUB":"\u0026#1088;\u0026#1091;\u0026#1073;","BOB":"$b","GBP":"\u0026pound;","NOK":"kr"});
                                        var symbol = symbols.get($('native_currency').value);

                                        var rates = $H({"ZAR":6.7935,"HKD":7.7795,"CHF":0.8367,"EUR":0.6856,"SEK":6.1874,"HUF":182.33,"DKK":5.1121,"ILS":3.376,"AUD":0.9338,"USD":1,"CAD":0.9808,"BRL":1.582,"JPY":80.07,"RUB":27.8416,"CZK":16.654,"NOK":5.3778,"GBP":0.6116});
                                        var fx_rate = rates.get($('native_currency').value) / rates.get(g_last_currency_code);


                                        $$('.currency_symbol').each(function(e) { e.innerHTML = symbol; });
                                        $$('.price_field').each(function(e) { if (e.value) e.value = parseInt(Math.round(e.value*fx_rate)); });

                                        g_last_currency_code = $('native_currency').value;
                                    }
                                </script>
                                <h2>Daily Pricing</h2>
                                <div class="padded-text">
                                    <div id="daily_pricing_form">
                                        <form action=<?php echo base_url() . '/func/updateprice/' . $id; ?> id="submit_daily_pricing_form" method="post">
                                            Mark as
                                            <select id="operation" name="operation" onchange="if (this.value==&quot;Available&quot;) { jQuery(&quot;#daily_price_options&quot;).show(); } else { jQuery(&quot;#daily_price_options&quot;).hide(); };">
                                                <option value="Available" selected="selected">Available</option>
                                                <option value="Not Available">Not Available</option>
                                            </select>
                                            from
                                            <input class="checkin" id="start_date" name="start_date" style="width:80px;" type="text" value="mm/dd/yy" />
                                            inclusively through
                                            <input class="checkout" id="end_date" name="end_date" style="width:80px;" type="text" value="mm/dd/yy" />
                                            . <span id="daily_price_options"> Price should be <span class="currency_symbol">$</span>
                                                <input id="price_native" name="price_native" style="width:30px;" type="text" value="" />
                                                . </span>
                                            <div>
                                                <input class="submit" id="daily_range_submit" name="commit" type="submit" value="Update" />
                                                <img id="daily_range_spinner" class="spinner" src="/images/spinner.gif" style="display:none;"/> <span id="submit-error" class="error-text"></span> <span style="font-style: italic">Changes delayed up to 5 minutes.</span>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="box" id="weekly_section">
                                <style>
                                    table.season { width:100%; }
                                    table.season td.label { font-weight:bold; }

                                    table.weekly input { width:25px; margin-right: 5px; }
                                    table.weekly .currency { font-size:9px; }
                                    td.dates { width: 75px; font-size: 0.85em; }

                                    table.season,
                                    table.weekly { line-height: 30px; }
                                </style>
                                <h2>Weekly Pricing</h2>
                                <div class="padded-text">
                                    <form action="/hosting/ajax_save_pricing_subsection?hosting_id=135134&amp;section=weekly" method="post" onsubmit="$('weekly_submit').disabled=true;Element.show('weekly_spinner');; new Ajax.Request('/hosting/ajax_save_pricing_subsection?hosting_id=135134&amp;section=weekly', {asynchronous:true, evalScripts:true, parameters:Form.serialize(this)}); return false;">
                                        <div class="pricing-display">
                                            <p> If not specified below, the weekly price is $
                                                <input id="weekly_price_native" name="weekly_price_native" style="width:35px;" type="text" />
                                                per week.<br/>
                                                Note: Weekly pricing overrides variable daily pricing. Be sure to update your weekly rates to include any increases or decreases in nightly rates. </p>
                                        </div>
                                        <p> Apply weekly price to
                                            <select id="is_weekly_price_prorated" name="is_weekly_price_prorated">
                                                <option value="false">exactly 7-day periods</option>
                                                <option value="true" selected="selected">any stay of 7 or more days</option>
                                            </select>
                                        </p>
                                        <table class="season">
                                            <tr>
                                                <td class="label">Spring 2011</td>
                                                <td class="label">Summer 2011</td>
                                                <td class="label">Autumn 2011</td>
                                                <td class="label">Winter 2012</td>
                                                <td class="label">Spring 2012</td>
                                            </tr>
                                            <tr>
                                                <td><table class="weekly">
                                                        <tr>
                                                            <td class="dates" valign="middle">Jun 6-12</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-06-06" name="weekly_price[2011-06-06]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jun 13-19</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-06-13" name="weekly_price[2011-06-13]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                                <td><table class="weekly">
                                                        <tr>
                                                            <td class="dates" valign="middle">Jun 20-26</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-06-20" name="weekly_price[2011-06-20]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jun 27 - Jul 3</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-06-27" name="weekly_price[2011-06-27]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jul 4-10</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-07-04" name="weekly_price[2011-07-04]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jul 11-17</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-07-11" name="weekly_price[2011-07-11]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jul 18-24</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-07-18" name="weekly_price[2011-07-18]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jul 25-31</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-07-25" name="weekly_price[2011-07-25]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Aug 1-7</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-08-01" name="weekly_price[2011-08-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Aug 8-14</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-08-08" name="weekly_price[2011-08-08]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Aug 15-21</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-08-15" name="weekly_price[2011-08-15]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Aug 22-28</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-08-22" name="weekly_price[2011-08-22]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Aug 29 - Sep 4</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-08-29" name="weekly_price[2011-08-29]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Sep 5-11</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-09-05" name="weekly_price[2011-09-05]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Sep 12-18</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-09-12" name="weekly_price[2011-09-12]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                                <td><table class="weekly">
                                                        <tr>
                                                            <td class="dates" valign="middle">Sep 19-25</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-09-19" name="weekly_price[2011-09-19]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Sep 26 - Oct 2</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-09-26" name="weekly_price[2011-09-26]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Oct 3-9</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-10-03" name="weekly_price[2011-10-03]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Oct 10-16</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-10-10" name="weekly_price[2011-10-10]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Oct 17-23</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-10-17" name="weekly_price[2011-10-17]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Oct 24-30</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-10-24" name="weekly_price[2011-10-24]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Oct 31 - Nov 6</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-10-31" name="weekly_price[2011-10-31]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Nov 7-13</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-11-07" name="weekly_price[2011-11-07]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Nov 14-20</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-11-14" name="weekly_price[2011-11-14]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Nov 21-27</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-11-21" name="weekly_price[2011-11-21]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Nov 28 - Dec 4</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-11-28" name="weekly_price[2011-11-28]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Dec 5-11</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-12-05" name="weekly_price[2011-12-05]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Dec 12-18</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-12-12" name="weekly_price[2011-12-12]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                                <td><table class="weekly">
                                                        <tr>
                                                            <td class="dates" valign="middle">Dec 19-25</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-12-19" name="weekly_price[2011-12-19]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Dec 26 - Jan 1</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2011-12-26" name="weekly_price[2011-12-26]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jan 2-8</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-01-02" name="weekly_price[2012-01-02]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jan 9-15</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-01-09" name="weekly_price[2012-01-09]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jan 16-22</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-01-16" name="weekly_price[2012-01-16]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jan 23-29</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-01-23" name="weekly_price[2012-01-23]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jan 30 - Feb 5</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-01-30" name="weekly_price[2012-01-30]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Feb 6-12</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-02-06" name="weekly_price[2012-02-06]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Feb 13-19</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-02-13" name="weekly_price[2012-02-13]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Feb 20-26</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-02-20" name="weekly_price[2012-02-20]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Feb 27 - Mar 4</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-02-27" name="weekly_price[2012-02-27]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Mar 5-11</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-03-05" name="weekly_price[2012-03-05]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Mar 12-18</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-03-12" name="weekly_price[2012-03-12]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                                <td><table class="weekly">
                                                        <tr>
                                                            <td class="dates" valign="middle">Mar 19-25</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-03-19" name="weekly_price[2012-03-19]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Mar 26 - Apr 1</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-03-26" name="weekly_price[2012-03-26]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Apr 2-8</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-04-02" name="weekly_price[2012-04-02]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Apr 9-15</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-04-09" name="weekly_price[2012-04-09]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Apr 16-22</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-04-16" name="weekly_price[2012-04-16]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Apr 23-29</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-04-23" name="weekly_price[2012-04-23]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Apr 30 - May 6</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-04-30" name="weekly_price[2012-04-30]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">May 7-13</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-05-07" name="weekly_price[2012-05-07]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">May 14-20</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-05-14" name="weekly_price[2012-05-14]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">May 21-27</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-05-21" name="weekly_price[2012-05-21]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">May 28 - Jun 3</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-05-28" name="weekly_price[2012-05-28]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jun 4-10</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-06-04" name="weekly_price[2012-06-04]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates" valign="middle">Jun 11-17</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="weekly_price_2012-06-11" name="weekly_price[2012-06-11]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table>
                                        <br />
                                        <input class="submit" id="weekly_submit" name="commit" type="submit" value="Save Changes" />
                                        <img id="weekly_spinner" class="spinner" src="/images/spinner.gif" style="display:none;"/>
                                    </form>
                                </div>
                            </div>
                            <div class="box" id="monthly_section">
                                <style>
                                    table.season { width:100%; }
                                    table.season td.label { font-weight:bold; }

                                    table.monthly td.dates { width:40px; text-align: right; padding-right: 5px; }
                                    table.monthly input { width:35px; margin-right: 20px; }

                                </style>
                                <h2>Monthly Pricing</h2>
                                <div class="padded-text">
                                    <form action="/hosting/ajax_save_pricing_subsection?hosting_id=135134&amp;section=monthly" method="post" onsubmit="$('monthly_submit').disabled=true;Element.show('monthly_spinner');; new Ajax.Request('/hosting/ajax_save_pricing_subsection?hosting_id=135134&amp;section=monthly', {asynchronous:true, evalScripts:true, parameters:Form.serialize(this)}); return false;">
                                        <div class="pricing-display">
                                            <p> If not specified below, the monthly price is $
                                                <input id="monthly_price_native" name="monthly_price_native" style="width:35px;" type="text" />
                                                per month. </p>
                                        </div>
                                        <p> Apply monthly price to
                                            <select id="is_monthly_price_prorated" name="is_monthly_price_prorated">
                                                <option value="false">exactly 28-day periods</option>
                                                <option value="true" selected="selected">any stay of 28 or more days</option>
                                            </select>
                                        </p>
                                        <table class="season">
                                            <tr>
                                                <td class="label">Spring 2011</td>
                                                <td class="label">Summer 2011</td>
                                                <td class="label">Autumn 2011</td>
                                                <td class="label">Winter 2012</td>
                                                <td class="label">Spring 2012</td>
                                            </tr>
                                            <tr>
                                                <td><table class="monthly">
                                                        <tr>
                                                            <td class="dates">June</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2011-06-01" name="monthly_price[2011-06-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates">July</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2011-07-01" name="monthly_price[2011-07-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates">August</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2011-08-01" name="monthly_price[2011-08-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                                <td><table class="monthly">
                                                        <tr>
                                                            <td class="dates">September</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2011-09-01" name="monthly_price[2011-09-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates">October</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2011-10-01" name="monthly_price[2011-10-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates">November</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2011-11-01" name="monthly_price[2011-11-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                                <td><table class="monthly">
                                                        <tr>
                                                            <td class="dates">December</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2011-12-01" name="monthly_price[2011-12-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates">January</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2012-01-01" name="monthly_price[2012-01-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates">February</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2012-02-01" name="monthly_price[2012-02-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                                <td><table class="monthly">
                                                        <tr>
                                                            <td class="dates">March</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2012-03-01" name="monthly_price[2012-03-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates">April</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2012-04-01" name="monthly_price[2012-04-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates">May</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2012-05-01" name="monthly_price[2012-05-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                                <td><table class="monthly">
                                                        <tr>
                                                            <td class="dates">June</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2012-06-01" name="monthly_price[2012-06-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates">July</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2012-07-01" name="monthly_price[2012-07-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="dates">August</td>
                                                            <td><span class="currency_symbol">$</span>
                                                                <input id="monthly_price_2012-08-01" name="monthly_price[2012-08-01]" type="text" value="" />
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table>
                                        <br />
                                        <input class="submit" id="monthly_submit" name="commit" type="submit" value="Save Changes" />
                                        <img id="monthly_spinner" class="spinner" src="/images/spinner.gif" style="display:none;"/>
                                    </form>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="box" id="pricing_tools">
                                <form action="/hosting/ajax_price_check?hosting_id=135134" id="price-test-form" method="post">
                                    <div class="box" id="pricing_tools">
                                        <h2> <span class="edit_room_icon craigslist"></span>
                                            <div> Use this tool to test whether the price for this listing is being calculated properly.<br/>
                                                The full pricing breakdown will appear below once you click the 'Test Pricing' button. </div>
                                        </h2>
                                        <div class="middle">
                                            <ul>
                                                <li>
                                                    <label for="price_check_checkin_date">Check in</label>
                                                    <input class="checkin" id="price_check_checkin_date" name="price_check_checkin_date" type="text" value="06/07/2011" />
                                                </li>
                                                <li>
                                                    <label for="price_check_checkout_date">Check out</label>
                                                    <input class="checkout" id="price_check_checkout_date" name="price_check_checkout_date" type="text" value="06/08/2011" />
                                                </li>
                                                <li>
                                                    <label for="price_check_checkout_date">Guests</label>
                                                    <select id="price_check_guests" name="price_check_guests">
                                                        <option value="1" selected="selected">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                    </select>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-submit">
                                        <input class="button-glossy green" name="commit" type="submit" value="Test Pricing" />
                                        <span class="spinner"></span>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="box">
                                        <div class="middle">
                                            <ul>
                                                <li id="price_test_result_container" style="display: none">
                                                    <label for="breakdown">Pricing Breakdown</label>
                                                    <div id="price_test_result"> <span class="pricing_error"></span> <span class="pricing_breakdown"></span> </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- edit_room -->
