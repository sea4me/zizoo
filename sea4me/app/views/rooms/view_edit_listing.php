<!-- Required Stylesheets -->
 <link href="<?php echo base_url(); ?>css/views/dashboard_v2.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>css/views/silver.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>css/common-datauri.css" media="screen" rel="stylesheet" type="text/css" />
	
	<script src="<?php echo base_url(); ?>js/edit_listing.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/widgets.js" type="text/javascript"></script>

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
			    //only allow 35 characters
    jQuery(document).ready(function(){
      jQuery('.hosting_name').charCounter({
        warningcount: 5,
        inputchanged: function(charsLeft){ jQuery(this).siblings('.countvalue:first').html(charsLeft); },
        warningenter: function(){ jQuery(this).siblings('.countvalue:first').addClass('warning'); },
        warningexit: function(){ jQuery(this).siblings('.countvalue:first').removeClass('warning'); },
        limitreached: function(){ jQuery(this).siblings('.countvalue:first').addClass('error'); }
      });

      jQuery("#hosting_name").blur(function () {
          if(jQuery("#hosting_name").val().length > 6){
              jQuery("#title_message").html('Great Title!').show().delay(2000).fadeOut(1000);
              jQuery("#title_message").removeClass('bad');
              jQuery("#title_message").addClass('good');
          }
          else if (jQuery("#hosting_name").val().length > 0){
              jQuery("#title_message").html('That title is pretty short!').show().delay(2000).fadeOut(1000);
              jQuery("#title_message").removeClass('good');
              jQuery("#title_message").addClass('bad');
          }
          else {
              jQuery("#title_message").html('Please enter a title!').show().delay(2000).fadeOut(1000);
              jQuery("#title_message").removeClass('good');
              jQuery("#title_message").addClass('bad');
          }
      });

      jQuery('#address_street, #address_apt, #hosting_phone, #hosting_person_capacity, #hosting_room_type, #hosting_beds').formTipHelper();
    });

    function check_min_price() {
      if(parseInt(jQuery("#hosting_price_native").val()) < 10){
        jQuery("#hosting_price_native").val('9');
        jQuery('#price').html('Price must be $10 or more');
        //alert('The minimum nightly price is $10');
      }

      return true;
    }

    function wait_for_upload() {
        $('spinner').style.display = 'block';
        $('current_photo').style.opacity = '.4';
        $('current_photo').style.filter = 'alpha(opacity=40)';
    }

    function upload_complete() {
        $('current_photo').style.opacity = '1';
        $('spinner').style.display = 'none';
        $('current_photo').style.filter = 'alpha(opacity=100)';
        document.ajax_upload_form.reset();
    }

    function select_picture_thumbnail(picture_id) {
        jQuery('li.photo').removeClass('selected');
        jQuery('#photo_' + picture_id).addClass('selected');
    }

    function change_guests_included() {
        $$('.guests_included').each(function(e) {e.innerHTML = $('hosting_guests_included').value; });
    }
    
    function fetch_progress_bar_data(hosting_id) {
      jQuery.getJSON('/rooms/ajax_update_progress_bar', { 'hosting_id' : hosting_id }, function(data) {
        CogzidelDashboard.updateProgressBar(data.progress.score, data.next_steps, data.prompt, data.available);
      });
    }

    function accommodates_changed() {
        if($('hosting_person_capacity').value < $('hosting_guests_included').value){
            $('hosting_guests_included').value = $('hosting_person_capacity').value;
            $$('.guests_included').each(function(e) {e.innerHTML = $('hosting_person_capacity').value; });
        }
    }



    function ajax_submit_form() {
      var the_form = jQuery('#hosting_edit_form');
      jQuery.ajax({
        url: "<?php echo site_url('rooms/update/'.$this->uri->segment(3)); ?>",
        type: "POST",
        data: jQuery(the_form).serialize(),
        dataType: "json",
        success: function(data){
          if(data['result'] == 'success'){
            var successString = 'Your listing was successfully saved!';
            
            if(data['availability_on'] === true) {
              successString += ' It is now active.';
            }
            else if(data['available'] === false && data['old_availability'] === true) {
              successString += '  However, it has been deactivated. Please supply a little more information to reactivate it!';
            }
            
            CogzidelDashboard.createNotificationItem(successString, 'info', the_form);
            
            // update progress bar
            if(data.progress) {
              CogzidelDashboard.updateProgressBar(data.progress.score, data.next_steps, data.prompt, data.available);
            }

            // also update the name of the property in the banner
            jQuery('#listing_title_banner').text(jQuery('#hosting_name').val());
          }
          else if(data['result'] == 'error'){
            CogzidelDashboard.createNotificationItem(data['message'], 'error', the_form);
          }

          var _spinner = jQuery('div.form-submit span.spinner', the_form);
          var _submitButton = jQuery(":submit", the_form);

          _spinner.hide();
          _submitButton.removeAttr('disabled');
          jQuery('html, body').animate({scrollTop: 0}, 'slow');
        }
      });
      
    }

	jQuery(document).ready(function() {
		jQuery('.button').hover(function() {jQuery(this).addClass('drop_shadow_soft')
	}, function(){
			jQuery(this).removeClass('drop_shadow_soft')
		});
		jQuery('#user_phone').validatedPhone();
		jQuery('#user_phone2').validatedPhone();
    
    jQuery('form#hosting_edit_form').submit(function(){
      ajax_submit_form();
      return false;
    });
	});

  jQuery(document).ready(function(){
    CogzidelDashboard.init(); 

    
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
<!-- End of style sheets inclusion -->

<div id="command_center">

<div id="dashboard_v2">

  <div class="row">
    <div class="col full heading">

      <div class="heading_content">
        


<div class="edit_listing_photo">
<?php
$images = $this->Gallery->get_images($this->uri->segment(3));
						if(count($images) == 0)
						{
							$url = base_url().'images/no_image.jpg';
						}
						else
						{
							$url = $images[0]['url'];
						} 
?>
<img alt="Host_pic" height="65" src="<?php echo $url; ?>" />
</div>

<div class="listing_info">
  <h3><?php echo anchor('rooms/'.$this->uri->segment(3) ,$row->title, array('id' => "listing_title_banner") )?></h3>
  <?php /*?><span class="actions">
		<span class="clearfix current-availability icon active">    <span class="label">Active</span>    <span class="expand"></span>  </span>
        <span class="action_button">

      <?php echo anchor('rooms/'.$this->uri->segment(3) ,translate('View Listing'), array('class' => "icon view") )?>
    </span>
    <span id="availability-error-message"></span>
  </span><?php */?>
		<span class="actions">
    <!--<div data-unavailable-url="<?php echo base_url(); ?>rooms/change_availability/<?php echo $this->uri->segment(3); ?>?is_available=0" data-available-url="<?php echo base_url(); ?>rooms/change_availability/<?php echo $this->uri->segment(3); ?>?is_available=1" data-has-availability="true" class="set-availability action_button">
			
		</div>-->

    <span class="action_button">
      <a target="_NEW" class="icon view" href="<?php echo base_url(); ?>rooms/<?php echo $this->uri->segment(3); ?>">View Listing</a>
    </span>
    <div id="availability-error-message"></div>
  </span>
</div>

<div class="clear"></div>

      </div>
    </div>

  </div>
  
    <div class="row">
    <div class="col one-fourth nav">
      <?php echo anchor('hosting',translate('View All Listing'), array('class' => 'to-parent' )); ?>
     
     
           <div class="nav-container">
             <?php $this->load->view('includes/editList_header.php'); ?>
           </div>
    </div>
    <div class="col three-fourths content">
      
      <div id="notification-area"></div>
      <div id="dashboard-content">
        



<?php /*?><?php echo form_open('func/update/'.$this->uri->segment(3),array( 'name' => "hosting_edit_form"))?><?php */?>
  <form name="hosting_edit_form" method="post" id="hosting_edit_form" enctype="multipart/form-data" action="<?php site_url('rooms/update/'.$this->uri->segment(3)); ?>">         

    <div class="box" id="listing_type_container">
    <div class="top">
        <h2 class="step"><span class="edit_room_icon"></span><?php echo translate("Listing Type"); ?></h2>

    </div>
    <div class="middle">
        <ul id="details">
            <li>
                <label for="hosting_property_type_id"><?php echo translate("Property type"); ?></label>
                <select class="fixed-width" id="hosting_property_type_id" name="property_id">
																			<option value="1">Apartment</option>
																			<option value="2">House</option>
																			<option value="3">Bed & Breakfast</option>
																			<option value="4">Cabin</option>
																			<option value="11">Villa</option>
																			<option value="5">Castle</option>
																			<option value="9">Dorm</option>
																			<option value="6">Treehouse</option>
																			<option value="8">Boat</option>
																			<option value="7">Automobile</option>
																			<option value="12">Igloo</option>
																			<option value="10">Lighthouse</option>
																</select>

                <div id="form_helper_property_type_id" class="form_helper" style="display:none;"><p><?php echo translate("What is the property type?"); ?></p></div>
                <div class="clear"></div>
            </li>

            <li>
                <label for="hosting_room_type"><?php echo translate("Room type"); ?></label>
                <select class="fixed-width" id="hosting_room_type" name="room_type">
																		<option value="Private room">Private room</option>
																		<option value="Shared room">Shared room</option>
																		<option value="Entire home/apt">Entire home/apt</option>
															</select>

                <div id="form_helper_room_type" class="form_helper" style="display:none;"><p><?php echo translate("What is the room type?"); ?></p></div>
                <div class="clear"></div>
            </li>
        </ul>

        <div class="clear"></div>
    </div><!-- middle -->
    <div class="bottom">&nbsp;</div>

</div><!-- box -->


  <div id="description_language_en" class="box" style="">
      <div class="top">

          <h2 class="step">
            <p class="close_section"></p>
            <span class="edit_room_icon details"></span><?php echo translate("Description"); ?> <span class="language_hint"> (<?php echo translate("English"); ?>)</span>
          </h2>
      </div>
      
      
      <div class="middle">
          <ul id="description">

              <li class="description_language_section_container">
                <ul class="description_language_section">
          

                 <li class="section_en">
                      <label for="hosting_name">
                      <?php echo translate("Title"); ?><br>
                      </label>
                      <input type="text" value="<?php echo $row->title; ?>" name="hosting_descriptions" maxlength="35" id="hosting_descriptions_en_name" class="large charcount hosting_name">
                      <span class="countvalue" id="hosting_name_char_count">20</span>
                      <span id="title_message"></span>
                      <div class="clear"></div>
                  </li>
																	
																	 
                  <li class="section_en">
                      <label for="hosting_description" style="vertical-align:top;"><?php echo translate("Description"); ?> <a class="tooltip" title="Note: we automatically filter out any contact information that you provide in your description"><img alt="Questionmark_hover" src="<?php echo base_url(); ?>images/questionmark_hover.png" style="width:16px; height:16px;" /></a>
                          <span class="helper">
                              <br />

                              <br />
                              <span style="font-size:13px; font-weight:bold;"><?php echo translate("Tips for writing a great description:"); ?></span>
                              <br />
                              <?php echo translate("What makes your place unique?"); ?>
                              <br />
                              <?php echo translate("What is your neighborhood like?"); ?>
                              <br />
                              <?php echo translate("What is the state of the room offered?"); ?>
                              <br />
                          </span>

                      </label>
                      <textarea id="hosting_descriptions_en_description" name="desc"><?php echo $row->desc; ?></textarea>
                      <div class="clear"></div>
                  </li>
              </ul> 
            </li>
          </ul>
        
          <div class="clear"></div>
      </div><!-- middle -->
      
      
           <div class="bottom">&nbsp;</div>
  </div><!-- box -->


    <div class="box" id="amenities">
    <div class="top">
        <h2 class="step"><span class="edit_room_icon amenities"></span><?php echo translate("Amenities"); ?></h2>
    </div>

    <div class="middle">
        <input id="include_amenities" name="include_amenities" type="hidden" />
            
												<?php 
												 $in_arr = explode(',', $row->amenities);
											 	$tCount = $amnities->num_rows();
												 $i = 1; $j = 1; 
													foreach($amnities->result() as $rows) { if($i == 1) echo '<ul class="amenity_column">'; ?>
                    <li>
                   <input type="checkbox" <?php if(in_array($j, $in_arr)) echo 'checked="checked"'; ?> name="amenities[]" id="amenity_<?php echo $j; ?>" value="<?php echo $j; ?>">
																						<label for="amenity_<?php echo $j; ?>"><?php echo $rows->name; ?>
																														<a title="<?php echo $rows->description; ?>" class="tooltip"><img style="width:16px; height:16px;" src="<?php echo base_url(); ?>images/questionmark_hover.png" alt="Questionmark_hover"></a>
																						</label>
                    </li>
													<?php if($i == 8) { $i = 0; echo '</ul>'; } else if($j == $tCount) { echo '</ul>'; } $i++; $j++; } ?>           
            
        <div class="clear"></div>
    </div>
    <div class="bottom">&nbsp;</div>
</div><!-- /box -->

    <div class="box" id="details_container">
    <div class="top">

        <h2 class="step"><span class="edit_room_icon details"></span><?php echo translate("Details"); ?></h2>
    </div>
    <div class="middle">
        <ul id="details">

            <li>
                <label for="hosting_person_capacity"><?php echo translate("Accommodates"); ?></label>
                <select class="fixed-width" id="hosting_person_capacity" name="capacity" >
																<?php for($i = 1; $i <= 10; $i++) { ?>
																			<option value="<?php echo $i; ?>"><?php echo $i; ?> person<?php if($i > 1) echo 's'; ?></option>
																	<?php } ?>
               </select>
                <div id="form_helper_person_capacity" class="form_helper" style="display:none;"><p><?php echo translate("The Maximum number of guests."); ?></p></div>
                <div class="clear"></div>

            </li>
           
               
           
           <li>
                <label for="hosting_bedrooms"><?php echo translate("Bedrooms"); ?></label>
                <select class="fixed-width" id="hosting_bedrooms" name="bedrooms">
																		<option value=""></option>
																		<?php for($i = 1; $i <= 10; $i++) { ?>
																		<option value="<?php echo $i; ?>"><?php echo $i; ?> bedroom<?php if($i > 1) echo 's'; ?></option>
																		<?php } ?>
                </select>
                <div id="form_helper_bedrooms" class="form_helper" style="display:none; width:320px;"><p><?php echo translate("How many bedrooms, couches, futons, etc. do you offer?"); ?></p></div>
                <div class="clear"></div>

            </li>

            <li>
                <label for="hosting_beds">Beds</label>
                <select class="fixed-width" id="hosting_beds" name="beds">
																<?php for($i = 1; $i <= 16; $i++) { ?>
																      <option value="<?php echo $i; ?>"><?php echo $i; if($i == 16) echo '+'; ?> bed</option>
																	<?php } ?>
              </select>

                <div id="form_helper_beds" class="form_helper" style="display:none; width:320px;"><p>How many beds, couches, futons, etc. do you offer?</p></div>
                <div class="clear"></div>
            </li>

            <li>
                <label for="hosting_bed_type">Bed type</label>

                <select class="fixed-width" id="hosting_bed_type" name="hosting_bed_type">
																 <option value="Airbed">Airbed</option>
																		<option value="Futon">Futon</option>
																		<option value="Pull-out Sofa">Pull-out Sofa</option>
																		<option value="Couch">Couch</option>
																		<option value="Real Bed" selected="selected">Real Bed</option>
               </select>
                <div class="clear"></div>
            </li>
												
												<li class="clearfix">
                <label for="hosting_bathrooms">Bathrooms</label>
                <select name="hosting_bathrooms" id="hosting_bathrooms" class="fixed-width">
															    	<option selected="selected" value=""></option>
																				<option value="0">0 bathrooms</option>
																				<option value="0.5">0.5 bathrooms</option>
																				<option value="1">1 bathroom</option>
																				<option value="1.5">1.5 bathrooms</option>
																				<option value="2">2 bathrooms</option>
																				<option value="2.5">2.5 bathrooms</option>
																				<option value="3">3 bathrooms</option>
																				<option value="3.5">3.5 bathrooms</option>
																				<option value="4">4 bathrooms</option>
																				<option value="4.5">4.5 bathrooms</option>
																				<option value="5">5 bathrooms</option>
																				<option value="5.5">5.5 bathrooms</option>
																				<option value="6">6 bathrooms</option>
																				<option value="6.5">6.5 bathrooms</option>
																				<option value="7">7 bathrooms</option>
																				<option value="7.5">7.5 bathrooms</option>
																				<option value="8">8+ bathrooms</option>
																				</select>
            </li>

 
            <li>
                <label for="hosting_house_manual" style="vertical-align:top;"><?php echo translate("House Manual"); ?>
                <br/>
                  <span class="helper">
                    <?php echo translate("Private: Only guests with a confirmed reservation will receive this information.  For example, WIFI password, lockbox code, parking information."); ?>
                  </span>
                </label>

                <textarea cols="40" id="hosting_house_manual" name="manual" rows="20"><?php echo $row->manual; ?></textarea>
                <div id="form_helper_house_manual" class="form_helper" style="display:none;">
                </div>
                <div class="clear"></div>
            </li>


            </ul>

        <div class="clear"></div>
    </div><!-- middle -->

    <div class="bottom">&nbsp;</div>
</div><!-- box -->


    
		<div id="location-information-section" class="box">
		<div class="top">
    <h2 class="step">
      <span class="edit_room_icon address"></span>
      <?php echo translate("Location Information"); ?>
      <span id="edit_address_message" class="edit-address-message" style="display: none;"
        data-message-accuracy="<strong>That address is not accurate enough. Try adding a street number.</strong><br />If you continue to have problems, please <a href='<?php echo site_url('pages/contact'); ?>'>contact support</a> to change your address."
        data-message-find="<strong>We can only find your address if you choose an option from the dropdown.</strong><br />If you continue to have problems, please <a href='<?php echo site_url('pages/contact'); ?>'>contact support</a> to change your address."
        data-message-good="<strong>All set! Your address will be updated when you save your listing.</strong><br />You may change your address until you have confirmed two reservations."
        data-message-contact="<strong>We just can't seem to find you.</strong><br />If you continue to have problems, please <a href='<?php echo site_url('pages/contact'); ?>'>contact support</a> to change your address."></span>
    </h2>
  </div>

  <div class="map-view">
		
		<h3 class="map-description exact">
      <span class="protip">
          <a id="edit-address" href="#" style="display: inline;">Edit address</a>

          <a style="display: none;" id="cancel-edit-address" href="#">Cancel</a>
      </span>
      <span class="icon"></span>
      Exact address
      <span class="address" style="display: inline-block;"><?php echo $row->address; ?></span>
    </h3>
		<div class="map-pane" id="private-map"></div>
    </div>


  <div class="map-view">
		<h3 class="map-description public">
      <span class="icon"></span><?php echo translate("Public View"); ?>
        <span class="address editing" style="display: none;"><em>Currently editing...</em></span>
      <span class="address full" data-message-refresh="Refresh the page to see your updated public address"><?php echo $row->address; ?></span>
      <p><em>This is how your address appears on your public listing</em></p>
    </h3>
    <div class="map-pane" id="public-map"> 
    </div>
  </div>
		
	<div class="middle">
		<ul id="location">
				<li>

					<label for="address_street_view"><?php echo translate("Street View"); ?> 
					<a class="tooltip" title="By Default we offset the location of your property to protect your privacy.&lt;br /&gt;You may show a more specific Street View location by choosing &quot;Closest to My Address&quot;.&lt;br /&gt;You may also choose to &quot;Hide Street View&quot;.">
					<img alt="Questionmark_hover" src="<?php echo base_url(); ?>images/questionmark_hover.png" style="width:16px; height:16px;" /></a>
					</label>
					<select class="fixed-width" id="address_street_view" name="street_view">
					   <option value="0">Hide Street View</option>
        <option value="1" selected="selected">Nearby (within 2 blocks)</option>
        <option value="2">Closest to My Address</option>
					</select> <a href="#" id="street-view-link" style=""><?php echo translate("View"); ?></a>
					<div class="clear"></div>
				</li>
				
    <div style="display: none;">
      <div id="street-view-colorbox"></div>
    </div>
				
				<li>
					<label for="hosting_directions">Directions</label>
					<textarea rows="20" name="hosting_directions" id="hosting_directions" cols="40"><?php echo $row->directions; ?></textarea>
					<div class="clear"></div>
				</li>
		</ul>
		<div class="clear"></div>
	</div>
	
	<div class="bottom">&nbsp;</div>
</div>

<div>
<!--<input class="button-glossy" style="width: auto;" type="submit" value="Save" />-->
<div class="clear"></div>
</div>
    <div class="form-submit" id="submit_new_room">
      <input type="submit" value="Save" style="width: auto;" name="commit" id="edit_room_submit_button" class="button-glossy">
      <span class="spinner" style="display: none;"></span>
      <div class="clear"></div>
    </div>
    
   <input type="hidden" value="1" name="update_progress" id="update_progress"> 
</form>

      </div>
    </div>
  </div>
  <div class="clear"></div>

</div><!-- edit_room -->


</div>

	
		<!-- Google Code for Login Remarketing List -->
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 1049231994;
		var google_conversion_language = "en";
		var google_conversion_format = "3";
		var google_conversion_color = "666666";
		var google_conversion_label = "FTfiCNDdlgIQ-oSo9AM";
		var google_conversion_value = 0;
		/* ]]> */
		</script>

		<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1049231994/?label=FTfiCNDdlgIQ-oSo9AM&amp;guid=ON&amp;script=0"/>
		</div>
		</noscript>


	<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAa2Xs-T5zUjU89HwI6ooVuxTkVixRUD-Hiz0ASbLT_MA6wjuv0xROWzG0QuXewGYauEy-p8sBjnSOIw"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.5&sensor=false&language=en&amp;libraries=places"></script>



	<script type="text/javascript">
	jQuery("#hosting_property_type_id").val('<?php echo $row->property_id; ?>');
	jQuery("#hosting_room_type").val('<?php echo $row->room_type; ?>');
	
	jQuery("#hosting_person_capacity").val('<?php echo $row->capacity; ?>');
	jQuery("#hosting_bedrooms").val('<?php echo $row->bedrooms; ?>');
	jQuery("#hosting_beds").val('<?php echo $row->beds; ?>');
	jQuery("#hosting_bed_type").val('<?php echo $row->bed_type; ?>');
	jQuery("#hosting_bathrooms").val('<?php echo $row->bathrooms; ?>');
	
		jQuery("#address_street_view").val('<?php echo $row->street_view; ?>');
	
			window.fbAsyncInit = function() {
				if (window.FB) {
					FB.init({
						appId  : '02e3aebb07b4f37b41893ae7713c8fdc',
						status : true, // check login status
						cookie : true, // enable cookies to allow the server to access the session
						xfbml  : true  // parse XFBML
					});

					FB.getLoginStatus(function(response) {
						if (response && (response.status !== "unknown")) {
							jQuery.cookie("fbs", response.status);
						} else {
							jQuery.cookie("fbs", null);
						}
					});

					jQuery(document).trigger('fbInit');
				}
			};

			(function() {
				var e = document.createElement('script');
				e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
				e.async = true;
				document.getElementById('fb-root').appendChild(e);
			}());


		  var visibleSectionsCount = 1;
  
  jQuery(document).ready(function() {
    
    jQuery('#add_description_language').bind('change', function(e) {
      var section = jQuery('#description_language_' + e.target.value);

      // If section is already visible, return
      if(section.css('display') != 'none') {
        e.target.value = 'xx';
        return;
      }
      
      showSection(e.target.value);
      
      e.target.value = 'xx';
    });
    
    if(visibleSectionsCount < 2) {
      jQuery('.close_section').hide();
    }
    
    showOrHideEnglishHint();
    
    jQuery('#add_description_language option[value=' + 'en' + ']').attr('disabled', 'disabled');
    
    
  });
  
  function showOrHideEnglishHint() {
    var section = jQuery('#description_language_en');
    
    if(visibleSectionsCount === 1 && section.css('display') != 'none') {
      jQuery('.language_hint', section).hide();
    }
    else {
      jQuery('.language_hint', section).show();
    }
  }
  
  function showSection(section_name) {
    var section = jQuery('#description_language_' + section_name);
    if(section.is(':visible')) {
      return false;
    }

    if(section.is(':visible')) {
      return false;
    }
    
    if(section_name != 'xx') {
      jQuery('#hosting_descriptions_' + section_name + '_machine_translated').val(false);
      jQuery('#hosting_descriptions_' + section_name + '_source_locale').val(false);
      
      // Add it to the bottom of the form
      section.detach();
      section.appendTo('#multilingual_description_container');
      
      section.show();
      visibleSectionsCount++;
      jQuery('.close_section').show();
      
      jQuery('#add_description_language option[value=' + section_name + ']').attr('disabled', 'disabled');
    }
    
    showOrHideEnglishHint();
  }
  
  function hideSection(section_name) {
    var section = jQuery('#description_language_' + section_name);
    if(section.is(':hidden')) {
      return false;
    }

    section.hide();
    section.find('input[type="text"]').val('');
    section.find('textarea').val('');
    visibleSectionsCount--;
    
    if(visibleSectionsCount < 2) {
      jQuery('.close_section').hide();
    }
    
    jQuery('#add_description_language option[value=' + section_name + ']').removeAttr('disabled');
    
    showOrHideEnglishHint();
    
  }
  
  function noEnglish() {
    hideSection('en');
    
    jQuery.post('/users/ajax_doesnt_speak_english');
  }
  
  var translationSource = 'en';
  
  var translationCallCount = 0;
  function fetchTranslations() {
    
    setTimeout(forceAjaxSubmitForm, 10000);
    
    // is translationSource still valid? if not choose whatever's available. an edge case
    if(jQuery('#hosting_descriptions_' + translationSource + '_description').is(':hidden')) {
      translationSource = jQuery('.description_language_box:visible').first().attr('data-lang');
    };
    
    translationCallCount = 0;
    google.load("language", "1", {
      "callback": function(){
        // Which locales are OK to overwrite with a machine translation? 
        // LET'S FIND OUT
        jQuery('.description_language_box:hidden').each(function() {
          
          var overwriteField = jQuery(this);
          var lang = overwriteField.attr('data-lang');
          
          translationCallCount += 2;
          
          google.language.translate(jQuery('#hosting_descriptions_' + translationSource + '_description').val(), translationSource, lang, function(result) {
            if (result.translation) {
              jQuery('#hosting_descriptions_' + lang + '_description').val(result.translation);
              jQuery('#hosting_descriptions_' + lang + '_machine_translated').val(true);
              jQuery('#hosting_descriptions_' + lang + '_source_locale').val(translationSource);
            }
            
            translationCallCount -= 1;
            if(translationCallCount == 0) {
              ajax_submit_form();
            }
          });
          
          google.language.translate(jQuery('#hosting_descriptions_' + translationSource + '_name').val(), translationSource, lang, function(result) {
            if (result.translation) {
              jQuery('#hosting_descriptions_' + lang + '_name').val(result.translation);
              jQuery('#hosting_descriptions_' + lang + '_machine_translated').val(true);
              jQuery('#hosting_descriptions_' + lang + '_source_locale').val(translationSource);
            }
            
            translationCallCount -= 1;
            if(translationCallCount == 0) {
              ajax_submit_form();
            }
            
          });
        });
      }
    });
  }
  
  function forceAjaxSubmitForm() {
    if(translationCallCount > 0) {
      ajax_submit_form();
    }
  }
  

  
  var allLocales = ['de','en','es','fr','it','pt','ru','zh','ko'];
  var humanTranslatedLocales = [];
  humanTranslatedLocales.push('en');
  
jQuery(document).ready(function($) {
  $(".grouped-options.pets").delegate("input[type='radio']", "change", function(eventObj) {
    if(!$('#amenity_17').is(':checked')) {
      $('#pets-amenities').fadeOut(function() {
        $(this).find("input[type='checkbox']").removeAttr("checked");
      });
    } else {
      $('#pets-amenities').fadeIn();
    }
  }).find("input[type='radio']").first().change();
});
jQuery(document).ready(function() {
  CogzidelRoomEdit.init({
    exactCoords: new google.maps.LatLng(<?php echo round($row->lat, 6); ?>, <?php echo round($row->long, 6); ?>),
    fuzzyCoords: new google.maps.LatLng(<?php echo $row->lat; ?>, <?php echo $row->long; ?>),
    accuracy: 7,
    supportContent: "<p><strong><?php echo $row->address; ?></strong></p><p>Please contact <a href=\"<?php echo site_url('pages/contact'); ?>\"><?php echo $this->dx_auth->get_site_title(); ?> support</a> to change this address.</p>"
  });
});


		(function() {
  		var initOptions = {
  			userLoggedIn: true,
  			showRealNameFlow: false,
  			locale: "en"
  		};

  		if (jQuery.cookie("_name")) {
  			initOptions.userLoggedIn = true;
  		}

  		Cogzidel.init(initOptions);
		})();

		Cogzidel.FACEBOOK_PERMS = "email,user_birthday,user_likes,user_education_history,user_hometown,user_interests,user_activities,user_location";
	</script>

<script type="text/x-jqote-template" id="notification-item-template">
<![CDATA[
<div class="<*= this.type *>">
  <span class="close"/>
  <span class="label"><*= this.label *></span>
</div>
]]>
</script>