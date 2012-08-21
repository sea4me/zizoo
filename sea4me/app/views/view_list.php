<link href="<?php echo base_url().'css/views/post_room.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
	<!-- More Scripts more and more -->
	<script src="<?php echo base_url().'css/views/libphonenumber.compiled.js'; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'css/views/jquery.validatedphone.js'; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/post_home.js" type="text/javascript"></script>
	<script src="<?php echo base_url().'css/views/tooltips_good.js'; ?>" type="text/javascript"></script>

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.1&amp;sensor=false"></script>
	<script type="text/javascript" src="http://api.atlasct.co.il/sdk_v4/?key=cadc00bf738b6e71&amp;p=im"></script>

<div class="zshadow_bg">
<div class="narrow_page_bg rounded_most">
<?php if( ($this->dx_auth->is_logged_in()) || ($this->facebook->logged_in()) ): ?>

<?php echo form_open("func/addNewEntry",array('id' => 'new_room_form'))?>

<input id="redirect_params_sig" name="redirect_params[sig]" type="hidden" />


<input id="redirect_params_action" name="redirect_params[action]" type="hidden" value="set_user" />

		<input id="retry_params_sig" name="retry_params[sig]" type="hidden" />

<input id="retry_params_action" name="retry_params[action]" type="hidden" value="create" />
<input id="retry_params_id" name="retry_params[id]" type="hidden" />


		<div id="post_a_room" class="rounded_more drop_shadow_standard clsDes_Top_Spac">
        <div class="clsH1_long_Border">
				<h1><?php echo translate("List your space.");?></h1></div>
          
			<div id="post_a_room_header" class="rounded_top">
				

				<h2>
					<?php echo $this->dx_auth->get_site_title().translate(" lets you make money renting out your place. Your apartment will pay for itself!"); ?>
					
				</h2>
			</div>
			<div class="narrow_page_section post_room_step1 rounded_more" style="margin:0 10px;">
				<h2 class="rounded_top">
					<?php echo translate("Find Your Address"); ?>
					<span class="header-badge protected-badge"><span><?php echo translate("Protected"); ?></span></span>

				</h2>
				<p class="header_description">
					<?php echo translate("Your contact information and full address are only shared with guests that you have accepted. We hide these details from everybody else."); ?>
				</p>
				<div id="" class="narrow_page_section_content rounded_bottom">
					<div id="address_section">
    <div id="address_step1">
        <p><label id="location_search_label" class="tall_label" for="location_search"><?php echo translate("Full address:");?></label>
        <input type="text" class="location active" autocomplete="off" id="location_search" name="location_search" /><p>

        <p style="clear:both"><label style="margin:0px">&nbsp;</label><a id="change_location_link" class="rounded_less" style=""><?php echo translate("Change Location");?></a></p>
    </div>

    <div id="way_too_vague" class="vague_address_warning rounded" style="display:none">
        <p><?php echo translate("Whoops! The address you selected is not specific enough. Try entering your address with the full street number."); ?><br /></p>
    </div>
	<div id="didyoumean" style="display:none">

		<p><?php echo translate("Did you mean:");?></p>
		<ul id="didyoumean-addresses"></ul>
	</div>
    <div id="address_step2">
        <div id="map_container">
            <div id="map_canvas"></div>
            <div id="step1_extras" style="">
                <div id="selected_address">

                    <p id="your_address">
                    <?php echo translate("Your Address:"); ?></span>
                    <ul id="address_container">
                        <li id="formatted_address"></li>
                        <li id="exact_address_prompt">

							<p><?php echo translate("Is this your exact address?");?></p>
							<input type="radio" name="exact_address" id="exact_address_1" value="yes" checked="checked">
							<label for="exact_address_1"><b><?php echo translate("Yes"); ?></b> <?php echo translate("&mdash; this is my exact address");?></label><br />
							<input type="radio" name="exact_address" id="exact_address_2" value="no">
							<label for="exact_address_2"><b><?php echo translate("No");?></b> <?php echo translate("&mdash; this is the closest I can get, I need to give directions");?></label>

						</li>
                    </ul>
                </div>
            </div>
			<div class="contact_info_section_field" style="padding-top:15px;display:none;">
				<label for="hosting_directions" class="tall_label"><?php echo translate("Directions to your place:"); ?></label>
				<textarea class="active" cols="40" disabled="disabled" id="hosting_directions" name="directions" rows="8" style="height:auto; width: 380px;"></textarea>
			</div>

        </div>

        <ul id="location">
                <input id="address_formatted_address_native" name="formatAddress" type="hidden" />
                <input id="address_lat" name="lat" type="hidden" />
                <input id="address_lng" name="lng" type="hidden" />
				<input disabled="disabled" id="address_user_defined_location" name="udlocation" type="hidden" value="true" />
        </ul>
    </div>

</div>

					<div id="contact_info_section" class="get_started_subsection" style="">
						<div class="contact_info_section_field">
							<label for="hosting_email"><b class="header-badge protected-badge"></b><?php echo translate("Paypal - Email :"); ?>
							
							<!-- 
							<a class="tooltip" title="Please enter your paypal email id.&lt;br /&gt; This email address is how we will pay you."><img alt="Questionmark_hover" src="<?php echo base_url().'css/views/questionmark_hover.png'; ?>" style="width:; height:;" /></a>
							 -->
							</label>
							<input class="large active" id="hosting_email" name="email" size="30" type="text" />
					</div>

					<div class="contact_info_section_field">
						<label for="hosting_phone"><?php echo translate("Phone:"); ?>
							<a class="tooltip" title="Primary Contact Number (cell or landline).&lt;br /&gt; We will give this number to the guest only after you accept their reservation request."></a>

						</label>
						
						<input autocomplete="off" class="medium active" name="phone" size="30" type="text" />
						<input id="hosting_phone_country" name="hosting[phone_country]" type="hidden" />
					</div>

				</div>
			</div>
		</div>
			<div class="narrow_page_section post_room_step2 rounded_more" style="margin:0 10px">
            <br />
			<h2 class="rounded_top" style="clear:both;">
				<?php echo translate("Details"); ?>
				<span class="header-badge public-badge"><span><?php echo translate("Public"); ?></span><b></b></span>
			</h2>

			<p class="header_description">
			</p>
			<ul id="details" class="narrow_page_section_content rounded_bottom">
				<li>
					<label for="hosting_property_type_id"><?php echo translate("Property Type:"); ?></label>
					<select id="hosting_property_type_id" name="property_id">
					   <option value="1"><?php echo translate("Apartment"); ?></option>
								<option value="2"><?php echo translate("Collections");?>House</option>
								<option value="3"><?php echo translate("Bed & Breakfast");?></option>
								<option value="4"><?php echo translate("Cabin"); ?></option>
								<option value="11"><?php echo translate("Villa");?></option>
								<option value="5"><?php echo translate("Castle");?></option>
								<option value="9"><?php echo translate("Dorm");?></option>
								<option value="6"><?php echo translate("Treehouse");?></option>
								<option value="8"><?php echo translate("Boat");?></option>
								<option value="7"><?php echo translate("Automobile");?></option>
								<option value="12"><?php echo translate("Igloo");?></option>
								<option value="10"><?php echo translate("Lighthouse");?></option>
     </select>
				</li>
				<li>
					<label for="hosting_person_capacity"><?php echo translate("Accommodates:");?></label>
					<select id="hosting_person_capacity" name="capacity"><option value="1">1</option>
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
<option value="16">16+</option></select>
				</li>
				<li>
					<label for="hosting_room_type"><?php echo translate("Privacy:");?></label>
					<select id="hosting_room_type" name="room_type"><option value="Private room" selected="selected"><?php echo translate("Private room");?></option>

<option value="Shared room"><?php echo translate("Shared room"); ?></option>
<option value="Entire home/apt"><?php echo translate("Entire home/apt"); ?></option></select>
				</li>
				<li>
					<label for="hosting_bedrooms"><?php echo translate("Bedrooms:"); ?></label>
					<select id="hosting_bedrooms" name="bedrooms"><option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>

<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option></select>
				</li>
				<li>

				  <div class="label_with_description">
				    <label for="hosting_name" class="tall_label"><?php echo translate("Title:"); ?></label>
				  </div>
					<input class="large active" id="hosting_name" name="Hname" size="30" style="margin-right:2px;" type="text" />
					<span id="letter_count">35</span>
					<span id="title_message"></span>
				</li>
				<li>

				  <div class="label_with_description">
				    <label for="hosting_description" style="vertical-align:top;"><?php echo translate("Description:"); ?></label>
				  </div>
					<textarea cols="40" id="hosting_description" name="desc" rows="20" style="height:200px;width:380px;"></textarea>
				</li>
				<li class="sublets">
					<div style="margin-bottom: 10px;">
						<label for="is_sublet"><?php echo translate("One time sublet?"); ?></label>

						<input type="checkbox" id="is_sublet" name="is_sublet" />
					</div>
					<div id="sublet_dates" style="margin-left: 150px;">
						<div class="search_date" style="float: left; margin-right: 10px;">
							<label for="sublet_checkin" style="float: none;"><?php echo translate("Sublet start date"); ?></label>
							<div>
								<input type="text" id="sublet_checkin" class="checkin" name="sublet_checkin" value="mm/dd/yy" style="width: 150px;" />
							</div>

						</div>
						<div class="search_date" style="float: left;">
							<label for="sublet_checkout" style="float: none;"><?php echo translate("Sublet end date"); ?></label>
							<div>
								<input type="text" id="sublet_checkout" class="checkout" name="sublet_checkout" value="mm/dd/yy" style="width: 150px;" />
							</div>
						</div>
					</div>

				</li>
				<li>
					<label id="hosting_price_native_label" for="hosting_price_native"><?php echo translate("Price:");?></label>
					<select id="hosting_native_currency" name="native_currency" style="margin:9px 10px 0 0; float:none;"><option value="AUD">AUD</option>
<option value="BRL">BRL</option>
<option value="CAD">CAD</option>
<option value="CHF">CHF</option>
<option value="CZK">CZK</option>

<option value="DKK">DKK</option>
<option value="EUR">EUR</option>
<option value="GBP">GBP</option>
<option value="HKD">HKD</option>
<option value="HUF">HUF</option>
<option value="ILS">ILS</option>
<option value="JPY">JPY</option>
<option value="NOK">NOK</option>
<option value="RUB">RUB</option>

<option value="SEK">SEK</option>
<option value="USD" selected="selected">USD</option>
<option value="ZAR">ZAR</option></select>
					<input class="active" id="hosting_price_native" name="native_price" size="30" style="width:50px; float:none; margin-right:10px;" type="text" value="0" />
					<input id="price_suggestion_low" name="price_suggestion_low" type="hidden" />
					<input id="price_suggestion_high" name="price_suggestion_high" type="hidden" />
					<span id="per-night-span"><?php echo translate("per night");?></span>
					<span id="sublet-rates" style="display: none;">

						<span id="per-month-span"><?php echo translate("per month"); ?></span>
						<span id="flat-rate-span" style="display: none;"><?php echo translate("flat rate"); ?></span>
					</span>
					<p id="price_suggestion"><?php echo translate("We suggest:");?><span class="currency_symbol"></span><span id="price_suggestion_low_text"></span> &mdash; <span class="currency_symbol"></span><span id="price_suggestion_high_text"></span><a class="tooltip" title="This range is determined by nearby listings."><img alt="Questionmark_hover" src="<?php echo base_url().'css/views/questionmark_hover.png'; ?>" style="width:; height:;" /></a></p>
				</li>
			</ul>
	<p><label></label><input type="submit" name="sub" id="post_room_submit_button" class="big_green_butt" value="Save & Continue" /></p>
			<div id="error_summary" style="">
			<p><?php echo translate("Please fix the following errors:"); ?></p>
			<ul></ul>
		</div>
		</div>
			
       
	</div>

	</form>
</div>

</div>
<?php else: ?>
<?php redirect('home/signin','refresh')?>
<?php endif; ?>






<script type="text/javascript">
    var CogzidelCurrencyInitializer = (function() {
      
        var my = {};
        
        my.USD = 1;
        my.EUR = 0.6957;
        my.DKK = 5.187;
        my.CAD = 0.9747;
        my.JPY = 80.89;
        my.GBP = 0.6112;
        my.AUD = 0.9372;
        my.ZAR = 6.8205;
        
        return my;
    }());
    Cogzidel.Currency.setCurrencyConversions(CogzidelCurrencyInitializer);

</script>

<script type="text/javascript">
    var Translations = {
        title : {
            great : "Great Title!",
            pretty_good : "That title is pretty short!",
            please_enter : "Please enter a title!"

        },

        address : "Address",
        email_address: "Email Address",
        title : "Title",
        description : "Description",
        price : "Price",
        phone_number : "Phone Number",

        address_error : "We need your address - the street number and apartment are private except for paying guests.",
        email_address_error : "A valid email address is required.",
        phone_number_error : "A valid phone number is required for our records. It is only revealed to paying guests. Please include your full country code and area code in your native format.",
        room_name_error : "Please provide a title for your space! It will show up in Search Results.",
        description_error : "Please provide a description.",
        price_error : "Please enter a price.",
		priceTooSmall_error: "Price must be at least $10 USD.",

        video_lightbox_title : "Cogzidel.com - How It Works",

        private_room_phrase : 'Private room',
        shared_room_phrase : 'Shared room',
        entire_home_phrase : 'Entire home/apt',
        not_so_vague: "The address you entered is not clear enough. \u003Cbr /\u003E\u003Cbr /\u003EZoom the map and drag this pin to your exact location.",
		not_so_vague_2: "Continue dragging this pin until the address on the left is as close to your real address as possible.",
		your_listing: "Your listing",
		sublet_real_end: "Make sure the end date for your sublet is a real date.",
		sublet_real_start: "Make sure the start date for your sublet is a real date.",
		sublet_start_before: "The end date for your sublet has to come after the start date.",
		sublet_min_nights: "Sublets have to be a minimum of 14 nights."
    };
    
    var Urls = {
      ajax_worth : '/rooms/ajax_worth'
    }

    jQuery(document).ready(function() {
        PostRoom.mapZoomLevel = 1;
        PostRoom.hostingLat = 0.0;
        PostRoom.hostingLng = 0.0;
        PostRoom.localized_hiw_video_code = 'SaOFuW011G8';
		PostRoom.SUBLET_MARKETS = ["New York","San Francisco"];
		PostRoom.MINIMUM_SUBLET_STAY_MS = 14 * 86400000;
		PostRoom.SUBLET_CROSSOVER_MS = 25 * 86400000;


        var opts = {};

        PostRoom.init(opts);

        $('#price_suggestion').hide();
		$('#hosting_phone').validatedPhone();
		$('#location_search').focus();
    });
</script>




            <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 1049231994;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "666666";
            var google_conversion_label = "0W9CCND30wEQ-oSo9AM";
            var google_conversion_value = 0;
            /* ]]> */
            </script>
            <script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
            </script>

            <noscript>
            <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1049231994/?label=0W9CCND30wEQ-oSo9AM&amp;guid=ON&amp;script=0"/>
            </div>
            </noscript>



    <script type="text/javascript">

    


		jQuery(document).ready(function() {
			Cogzidel.init({userLoggedIn: false});
		});

    </script>
	<script type="text/javascript" charset="utf-8">NREUMQ.push(["nrf2","beacon-3.newrelic.com","fc09a36731",2237,"dlwMQktaWAgBEB1AXFpeERlaR1EFEAc=",0,68])</script>