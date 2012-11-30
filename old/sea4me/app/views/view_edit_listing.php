<!-- Required Stylesheets -->
<link href="<?php echo base_url(); ?>css/views/dashboard_v2.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/views/silver.css" media="screen" rel="stylesheet" type="text/css" />

<!-- End of style sheets inclusion -->
<?php
$id = $this->uri->segment(3);
$query = $this->db->get_where('list', array('id' => $id));
$q = $query->result();
$query2 = $this->db->get_where('amnities', array('id' => $id));
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
                        <img alt="Host_pic" height="65" src="<?php echo $url; ?>" />
                    </div>

                    <div class="listing_info">
                        <h3><?php echo anchor('rooms/' . $this->uri->segment(3), $q[0]->title, array('id' => "listing_title_banner")) ?></h3>
                        <span class="actions">
                            <span class="action_button">

                                <?php echo anchor('rooms/' . $this->uri->segment(3), translate('View Listing'), array('class' => "icon view")) ?>
                            </span>
                            <span id="availability-error-message"></span>
                        </span>
                    </div>

                    <div class="clear"></div>

                </div>
            </div>

        </div>

        <div class="row">
            <div class="col one-fourth nav">
                <?php echo anchor('hosting', translate('View All Listing'), array('class' => 'to-parent')); ?>


                <div class="nav-container">
                    <ul class="edit_room_nav">
                        <li  class="selected">
                            <a class="details" href=<?php echo base_url() . 'func/editListing/' . $this->uri->segment(3); ?>>
                                <span class="icon"></span><?php echo translate("Description"); ?></a>
                        </li>
                        <li>
                            <?php echo anchor('func/photoListing/' . $this->uri->segment(3), translate('Photos'), array('class' => 'icon')); ?>
                        </li>

<!-- <li ><a class="calendar" href="/calendar/single/135134"><span class="icon"></span>Calendar</a> -->
                        <li>
                            <a class="pricing" href=<?php echo base_url() . 'func/editpricing/' . $this->uri->segment(3); ?> ><span class="icon"></span><?php echo translate("Pricing and Terms"); ?></a>
                        </li>
                    </ul>
                    <ul class="edit_room_nav">
<!-- <li ><a class="promote" href="/hosting/promote/135134"><span class="icon"></span>Promote</a> -->
                    </ul>

                </div>
            </div>
            <div class="col three-fourths content">

                <div id="notification-area"></div>
                <div id="dashboard-content">




                    <?php echo form_open('func/update/' . $this->uri->segment(3), array('name' => "hosting_edit_form")) ?>


                    <div class="box" id="listing_type_container">
                        <div class="top">
                            <h2 class="step"><span class="edit_room_icon"></span><?php echo translate("Listing Type"); ?></h2>

                        </div>
                        <div class="middle">
                            <ul id="details">
                                <li>
                                    <label for="hosting_property_type_id"><?php echo translate("Property type"); ?></label>
                                    <select class="fixed-width" id="hosting_property_type_id" name="property_id">
                                        <option value="1" <?php if ($q[0]->property_id == 1) echo 'selected="selected"'; ?>>Apartment</option>
                                        <option value="2" <?php if ($q[0]->property_id == 2) echo 'selected="selected"'; ?>>House</option>
                                        <option value="3" <?php if ($q[0]->property_id == 3) echo 'selected="selected"'; ?>>Bed & Breakfast</option>

                                        <option value="4" <?php if ($q[0]->property_id == 4) echo 'selected="selected"'; ?>>Cabin</option>
                                        <option value="11" <?php if ($q[0]->property_id == 11) echo 'selected="selected"'; ?>>Villa</option>
                                        <option value="5" <?php if ($q[0]->property_id == 5) echo 'selected="selected"'; ?>>Castle</option>
                                        <option value="9" <?php if ($q[0]->property_id == 9) echo 'selected="selected"'; ?>>Dorm</option>
                                        <option value="6" <?php if ($q[0]->property_id == 6) echo 'selected="selected"'; ?>>Treehouse</option>
                                        <option value="8" <?php if ($q[0]->property_id == 8) echo 'selected="selected"'; ?>>Boat</option>
                                        <option value="7" <?php if ($q[0]->property_id == 7) echo 'selected="selected"'; ?>>Automobile</option>
                                        <option value="12" <?php if ($q[0]->property_id == 12) echo 'selected="selected"'; ?>>Igloo</option>
                                        <option value="10" <?php if ($q[0]->property_id == 10) echo 'selected="selected"'; ?>>Lighthouse</option>
                                    </select>

                                    <div id="form_helper_property_type_id" class="form_helper" style="display:none;"><p><?php echo translate("What is the property type?"); ?></p></div>
                                    <div class="clear"></div>
                                </li>

                                <li>
                                    <label for="hosting_room_type"><?php echo translate("Room type"); ?></label>
                                    <select class="fixed-width" id="hosting_room_type" name="room_type">
                                        <option value="Private room" <?php if ($q[0]->room_type == "Private room") echo 'selected="selected"'; ?>>Private room</option>
                                        <option value="Shared room" <?php if ($q[0]->room_type == "Shared room") echo 'selected="selected"'; ?>>Shared room</option>
                                        <option value="Entire home/apt" <?php if ($q[0]->room_type == "Entire home/apt") echo 'selected="selected"'; ?>>Entire home/apt</option>
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
                                            <!-- 
                                            
                                            <input class="large charcount hosting_name" id="hosting_descriptions_en_name" maxlength="35" name="title" type="text" value=<?php echo $q[0]->title; ?> />
                                            <span id="hosting_name_char_count" class="countvalue">35</span>
                      
                                            
                                            <div class="clear"></div>
                                            
                                            -->
                                            <label for="hosting_name">
                                                <?php echo translate("Title"); ?> <br />
                                            </label>
                                            <span id="title_message"><?php echo $q[0]->title; ?></span>                      
                                            <input id="hosting_descriptions_en_delete" name="desc123" type="hidden" value="false" />
                                        </li>
                                        <li class="section_en">
                                            <label for="hosting_description" style="vertical-align:top;"><?php echo translate("Description"); ?> <a class="tooltip" title="Note: we automatically filter out any contact information that you provide in your description"><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a>
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
                                            <textarea id="hosting_descriptions_en_description" name="desc"><?php echo $q[0]->desc; ?></textarea>
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
                            <ul class="amenity_column">
                                <li>
                                    <input value="11" id="amenity_11" name="smoking" type="checkbox" <?php if (isset($r[0]->smoking)) if ($r[0]->smoking) echo 'CHECKED';  ?> />
                                    <label for="amenity_11"><?php echo translate("Smoking Allowed"); ?>
                                    </label>
                                </li>
                                <li>

                                    <input value="12" id="amenity_12" name="pets" type="checkbox" <?php if (isset($r[0]->pets)) if ($r[0]->pets) echo 'CHECKED';  ?> />
                                    <label for="amenity_12"><?php echo translate("Pets Allowed"); ?>
                                    </label>
                                </li>
                                <li>
                                    <input value="1" id="amenity_1" name="tv" type="checkbox" <?php if (isset($r[0]->tv)) if ($r[0]->tv) echo 'CHECKED';  ?> />
                                    <label for="amenity_1"><?php echo translate("TV"); ?>
                                    </label>
                                </li>
                                <li>

                                    <input value="2" id="amenity_2" name="cable" type="checkbox" <?php if (isset($r[0]->tv)) if ($r[0]->tv) echo 'CHECKED';  ?> />
                                    <label for="amenity_2"><?php echo translate("Cable TV"); ?>
                                    </label>
                                </li>
                                <li>
                                    <input value="3" id="amenity_3" name="internet" type="checkbox" <?php if (isset($r[0]->internet)) if ($r[0]->internet) echo 'CHECKED';  ?> />
                                    <label for="amenity_3"><?php echo translate("Internet"); ?>
                                        <a class="tooltip" title="Internet (wired or wireless)"><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a>
                                    </label>
                                </li>

                                <li>
                                    <input value="4" id="amenity_4" name="wireless" type="checkbox" <?php if (isset($r[0]->wireless)) if ($r[0]->wireless) echo 'CHECKED';  ?> />
                                    <label for="amenity_4"><?php echo translate("Wireless Internet"); ?>
                                        <a class="tooltip" title="A wireless router that guests can access 24/7."><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a>
                                    </label>
                                </li>
                                <li>
                                    <input value="5" id="amenity_5" name="ac" type="checkbox" <?php if (isset($r[0]->ac)) if ($r[0]->ac) echo 'CHECKED';  ?> />
                                    <label for="amenity_5"><?php echo translate("Air Conditioning"); ?>
                                    </label>

                                </li>
                                <li>
                                    <input value="30" id="amenity_30" name="heating" type="checkbox" <?php if (isset($r[0]->heating)) if ($r[0]->heating) echo 'CHECKED';  ?> />
                                    <label for="amenity_30"><?php echo translate("Heating"); ?>
                                    </label>
                                </li>
                            </ul>
                            <ul class="amenity_column">
                                <li>

                                    <input value="21" id="amenity_21" name="elevator" type="checkbox" <?php if (isset($r[0]->elevator)) if ($r[0]->elevator) echo 'CHECKED';  ?>/>
                                    <label for="amenity_21"><?php echo translate("Elevator in Building"); ?>
                                    </label>
                                </li>
                                <li>
                                    <input value="6" id="amenity_6" name="handicap" type="checkbox" <?php if (isset($r[0]->handicap)) if ($r[0]->handicap) echo 'CHECKED';  ?> />
                                    <label for="amenity_6"><?php echo translate("Handicap Accessible"); ?>
                                        <a class="tooltip" title="The property is easily accessible.  Guests should communicate about individual needs."><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a>
                                    </label>
                                </li>

                                <li>
                                    <input value="7" id="amenity_7" name="pool" type="checkbox" <?php if (isset($r[0]->pool)) if ($r[0]->pool) echo 'CHECKED';  ?> />
                                    <label for="amenity_7"><?php echo translate("Pool"); ?>
                                        <a class="tooltip" title="A private swimming pool"><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a>
                                    </label>
                                </li>
                                <li>
                                    <input value="8" id="amenity_8" name="kitchen" type="checkbox" <?php if (isset($r[0]->kitchen)) if ($r[0]->kitchen) echo 'CHECKED';  ?> />
                                    <label for="amenity_8"><?php echo translate("Kitchen"); ?>
                                        <a class="tooltip" title="Kitchen is available for guest use"><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a>

                                    </label>
                                </li>
                                <li>
                                    <input value="9" id="amenity_9" name="parking" type="checkbox" <?php if (isset($r[0]->parking)) if ($r[0]->parking) echo 'CHECKED';  ?> />
                                    <label for="amenity_9"><?php echo translate("Parking Included"); ?>
                                    </label>
                                </li>
                                <li>
                                    <input value="13" id="amenity_13" name="washer" type="checkbox" <?php if (isset($r[0]->washer)) if ($r[0]->washer) echo 'CHECKED';  ?> />

                                    <label for="amenity_13"><?php echo translate("Washer / Dryer"); ?>
                                        <a class="tooltip" title="Paid or Free, in building"><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a>
                                    </label>
                                </li>
                                <li>
                                    <input value="14" id="amenity_14" name="doorman" type="checkbox" <?php if (isset($r[0]->doorman)) if ($r[0]->doorman) echo 'CHECKED';  ?> />
                                    <label for="amenity_14"><?php echo translate("Doorman"); ?>
                                    </label>
                                </li>
                                <li>

                                    <input value="15" id="amenity_15" name="gym" type="checkbox" <?php if (isset($r[0]->gym)) if ($r[0]->gym) echo 'CHECKED';  ?> />
                                    <label for="amenity_15"><?php echo translate("Gym"); ?>
                                        <a class="tooltip" title="Guests have free access to a gym"><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a>
                                    </label>
                                </li>
                            </ul>
                            <ul class="amenity_column">
                                <li>
                                    <input value="25" id="amenity_25" name="hottub" type="checkbox" <?php if (isset($r[0]->hottub)) if ($r[0]->hottub) echo 'CHECKED';  ?> />

                                    <label for="amenity_25"><?php echo translate("Hot Tub"); ?>
                                    </label>
                                </li>
                                <li>
                                    <input value="27" id="amenity_27" name="fireplace" type="checkbox" <?php if (isset($r[0]->fireplace)) if ($r[0]->fireplace) echo 'CHECKED';  ?> />
                                    <label for="amenity_27"><?php echo translate("Indoor Fireplace"); ?>
                                    </label>
                                </li>
                                <li>
                                    <input value="28" id="amenity_28" name="intercom" type="checkbox" />

                                    <label for="amenity_28"><?php echo translate("Buzzer/Wireless Intercom"); ?>
                                    </label>
                                </li>
                                <li>
                                    <input value="16" id="amenity_16" name="breakfast" type="checkbox" <?php if (isset($r[0]->breakfast)) if ($r[0]->breakfast) echo 'CHECKED';  ?> />
                                    <label for="amenity_16"><?php echo translate("Breakfast"); ?>
                                        <a class="tooltip" title="Breakfast is provided."><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a>
                                    </label>
                                </li>
                                <li>

                                    <input value="31" id="amenity_31" name="kids" type="checkbox" <?php if (isset($r[0]->kids)) if ($r[0]->kids) echo 'CHECKED';  ?> />
                                    <label for="amenity_31"><?php echo translate("Family/Kid Friendly"); ?>
                                        <a class="tooltip" title="The property is suitable for hosting families with children."><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a>
                                    </label>
                                </li>
                                <li>
                                    <input value="32" id="amenity_32" name="events" type="checkbox" <?php if (isset($r[0]->events)) if ($r[0]->events) echo 'CHECKED';  ?> />
                                    <label for="amenity_32"><?php echo translate("Suitable for Events"); ?>
                                        <a class="tooltip" title="The property can accommodate a gathering of 25 or more attendees."><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a>
                                    </label>

                                </li>
                            </ul>

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

                                        <option value="1" <?php if ($q[0]->capacity == 1) echo 'selected="selected"'; ?>>1 person</option>
                                        <option value="2" <?php if ($q[0]->capacity == 2) echo 'selected="selected"'; ?>>2 people</option>
                                        <option value="3" <?php if ($q[0]->capacity == 3) echo 'selected="selected"'; ?>>3 people</option>
                                        <option value="4" <?php if ($q[0]->capacity == 4) echo 'selected="selected"'; ?>>4 people</option>
                                        <option value="5" <?php if ($q[0]->capacity == 5) echo 'selected="selected"'; ?>>5 people</option>
                                        <option value="6" <?php if ($q[0]->capacity == 6) echo 'selected="selected"'; ?>>6 people</option>
                                        <option value="7" <?php if ($q[0]->capacity == 7) echo 'selected="selected"'; ?>>7 people</option>
                                        <option value="8" <?php if ($q[0]->capacity == 8) echo 'selected="selected"'; ?>>8 people</option>
                                        <option value="9" <?php if ($q[0]->capacity == 9) echo 'selected="selected"'; ?>>9 people</option>
                                        <option value="10" <?php if ($q[0]->capacity == 10) echo 'selected="selected"'; ?>>10 people</option>

                                        <option value="11" <?php if ($q[0]->capacity == 11) echo 'selected="selected"'; ?>>11 people</option>
                                        <option value="12" <?php if ($q[0]->capacity == 12) echo 'selected="selected"'; ?>>12 people</option>
                                        <option value="13" <?php if ($q[0]->capacity == 13) echo 'selected="selected"'; ?>>13 people</option>
                                        <option value="14" <?php if ($q[0]->capacity == 14) echo 'selected="selected"'; ?>>14 people</option>
                                        <option value="15" <?php if ($q[0]->capacity == 15) echo 'selected="selected"'; ?>>15 people</option>
                                        <option value="16" <?php if ($q[0]->capacity == 16) echo 'selected="selected"'; ?>>16+ people</option>
                                    </select>
                                    <div id="form_helper_person_capacity" class="form_helper" style="display:none;"><p><?php echo translate("The Maximum number of guests."); ?></p></div>
                                    <div class="clear"></div>

                                </li>



                                <li>
                                    <label for="hosting_bedrooms"><?php echo translate("Bedrooms"); ?></label>
                                    <select class="fixed-width" id="hosting_bedrooms" name="bedrooms"><option value=""></option>
                                        <option value="1" <?php if ($q[0]->bedrooms == 1) echo 'selected="selected"'; ?>>1 bedroom</option>
                                        <option value="2" <?php if ($q[0]->bedrooms == 2) echo 'selected="selected"'; ?>>2 bedrooms</option>
                                        <option value="3" <?php if ($q[0]->bedrooms == 3) echo 'selected="selected"'; ?>>3 bedrooms</option>
                                        <option value="4" <?php if ($q[0]->bedrooms == 4) echo 'selected="selected"'; ?>>4 bedrooms</option>

                                        <option value="5" <?php if ($q[0]->bedrooms == 5) echo 'selected="selected"'; ?>>5 bedrooms</option>
                                        <option value="6" <?php if ($q[0]->bedrooms == 6) echo 'selected="selected"'; ?>>6 bedrooms</option>
                                        <option value="7" <?php if ($q[0]->bedrooms == 7) echo 'selected="selected"'; ?>>7 bedrooms</option>
                                        <option value="8" <?php if ($q[0]->bedrooms == 8) echo 'selected="selected"'; ?>>8 bedrooms</option>
                                        <option value="9" <?php if ($q[0]->bedrooms == 9) echo 'selected="selected"'; ?>>9 bedrooms</option>
                                        <option value="10" <?php if ($q[0]->bedrooms == 10) echo 'selected="selected"'; ?>>10 bedrooms</option>
                                    </select>
                                    <div id="form_helper_bedrooms" class="form_helper" style="display:none; width:320px;"><p><?php echo translate("How many bedrooms, couches, futons, etc. do you offer?"); ?></p></div>
                                    <div class="clear"></div>

                                </li>

                                <li>
                                    <label for="hosting_house_manual" style="vertical-align:top;"><?php echo translate("House Manual"); ?>
                                        <br/>
                                        <span class="helper">
                                            <?php echo translate("Private: Only guests with a confirmed reservation will receive this information.  For example, WIFI password, lockbox code, parking information."); ?>
                                        </span>
                                    </label>

                                    <textarea cols="40" id="hosting_house_manual" name="manual" rows="20"><?php if (isset($r[0]->manual)) echo $r[0]->manual; ?></textarea>
                                    <div id="form_helper_house_manual" class="form_helper" style="display:none;">
                                    </div>
                                    <div class="clear"></div>
                                </li>


                            </ul>

                            <div class="clear"></div>
                        </div><!-- middle -->

                        <div class="bottom">&nbsp;</div>
                    </div><!-- box -->



                    <div class="box">
                        <div class="top">
                            <h2 class="step"><span class="edit_room_icon address"></span><?php echo translate("Location Information"); ?></h2>
                        </div>
                        <div class="map-view">
                            <h3 class="map-description exact">

      <!-- <span class="protip">Contact support to change this address</span>  -->
                                <span class="icon"></span>
                                Exact address 
                                <span class="address"><?php echo $q[0]->address; ?></span>
                            </h3>
                            <div class="map-pane" id="private-map"> 
                            </div>
                        </div>

                        <div class="map-view">
                            <h3 class="map-description public"><span class="icon"></span><?php echo translate("Public View"); ?><span class="address"><?php echo $q[0]->address; ?></span></h3>
                            <div class="map-pane" id="public-map"> 
                            </div>
                        </div>
                        <div class="middle">
                            <ul id="location">
                                <li>

                                    <label for="address_street_view"><?php echo translate("Street View"); ?> <a class="tooltip" title="By Default we offset the location of your property to protect your privacy.&lt;br /&gt;You may show a more specific Street View location by choosing &quot;Closest to My Address&quot;.&lt;br /&gt;You may also choose to &quot;Hide Street View&quot;."><img alt="Questionmark_hover" src="http://s2.muscache.com/1300304855/images/icons/questionmark_hover.png" style="width:16px; height:16px;" /></a></label>
                                    <select class="fixed-width" id="address_street_view" name="address[street_view]"><option value="0">Hide Street View</option>
                                        <option value="1" selected="selected">Nearby (within 2 blocks)</option>
                                        <option value="2">Closest to My Address</option></select> <a href="#" id="street-view-link" style=""><?php echo translate("View"); ?></a>
                                    <div class="clear"></div>
                                </li>
                                <div style="display: none;">

                                    <div id="street-view-colorbox"></div>
                                </div>
                            </ul>
                            <div class="clear"></div>
                        </div>
                        <div class="bottom">&nbsp;</div>
                    </div>
                    <div>
                        <input class="button-glossy" style="width: auto;" type="submit" value="Save" />
                        <div class="clear"></div>
                    </div>
                    <div id="submit_new_room" class="form-submit">


                    </div>


                    </form>

                </div>
            </div>
        </div>
        <div class="clear"></div>

    </div><!-- edit_room -->


</div>


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
    jQuery.noConflict();
</script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.3/prototype.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.2/scriptaculous.js"></script>
<script src="http://s8.muscache.com/1300304855/javascripts/calendar_date_select/calendar_date_select.js" type="text/javascript"></script>

<script src="http://s1.muscache.com/1300304855/javascripts/calendar_date_select/format_american.js" type="text/javascript"></script>

<script src="http://s1.muscache.com/1300304855/javascripts/tooltips_good.js" type="text/javascript"></script>
<script src="http://s4.muscache.com/1300304855/javascripts/libphonenumber.compiled.js" type="text/javascript"></script>
<script src="http://s8.muscache.com/1307060988/javascripts/jquery.validatedphone.js" type="text/javascript"></script>

<script src="http://s7.muscache.com/1301534339/javascripts/jquery.formtiphelper.js" type="text/javascript"></script>
<script src="http://s6.muscache.com/1305241965/javascripts/jquery.charcounter.js" type="text/javascript"></script>
<script src="http://s3.muscache.com/1300304855/javascripts/jqote.js" type="text/javascript"></script>
<script src="http://s0.muscache.com/1305924789/javascripts/dashboard_v2.js" type="text/javascript"></script>
<script src="http://s7.muscache.com/1307210990/javascripts/jquery.mapshelper.js" type="text/javascript"></script>

<script type="text/x-jqote-template" id="notification-item-template">
    <![CDATA[
    <div class="<*= this.type *>">
        <span class="close"/>
        <span class="label"><*= this.label *></span>
    </div>

    ]]>

</script>

<script src="http://s0.muscache.com/1307149584/javascripts/edit_room_v2.js" type="text/javascript"></script>


<script type="text/javascript">
    //only allow 35 characters
    jQuery(document).ready(function(){
        jQuery('.hosting_name').charCounter(35);

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
            CogzidelDashboard.updateProgressBar(data.progress.score, data.next_steps, data.prompt);
        });
    }

    function accommodates_changed() {
        if($('hosting_person_capacity').value < $('hosting_guests_included').value){
            $('hosting_guests_included').value = $('hosting_person_capacity').value;
            $$('.guests_included').each(function(e) {e.innerHTML = $('hosting_person_capacity').value; });
        }
    }



    jQuery(document).ready(function() {
        jQuery('.button').hover(function() {jQuery(this).addClass('drop_shadow_soft')
        }, function(){
            jQuery(this).removeClass('drop_shadow_soft')
        });
        jQuery('#user_phone').validatedPhone();
        jQuery('#user_phone2').validatedPhone();
    
        jQuery('form#hosting_edit_form').submit(function(){
            var _formRef = this;

            // turn on spinner
            var _spinner = jQuery('div.form-submit span.spinner', this);
            _spinner.show();

            // disable submit button
            var _submitButton = jQuery(":submit", this);
            _submitButton.attr('disabled', 'disabled');

            jQuery.ajax({
                url: "/rooms/update/135134",
                type: "POST",
                data: jQuery(this).serialize(),
                dataType: "json",
                success: function(data){
                    if(data['result'] == 'success'){
                        var successString = 'Your listing was successfully saved!'
            
                        if(data['availability_on'] === true) {
                            successString += " It is now active."
                        }
            
                        CogzidelDashboard.createNotificationItem(successString, 'info', _formRef);
            
                        // update progress bar
                        if(data.progress) {
                            CogzidelDashboard.updateProgressBar(data.progress.score, data.next_steps, data.prompt, data.available);
                        }

                        // also update the name of the property in the banner
                        jQuery('#listing_title_banner').text(jQuery('#hosting_name').val());
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
    });


    google.load('maps', '3.2', {"other_params": "sensor=false"});
    jQuery(document).ready(function(){
        CogzidelDashboard.init(); 

        // add click handler to nav elements to change the icon to a spinner
        jQuery('ul.edit_room_nav li a').click(function(){
            jQuery('ul.edit_room_nav span.icon.spinner').removeClass('spinner');
            jQuery(this).find('span.icon').addClass('spinner');
        });

        // if the host doesn't have photos, then display an error notification
    
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


<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.grouped-options.pets input[type="radio"]').change(function(eventObj){
            if(!jQuery('#amenity_17').is(':checked')){
                jQuery('#amenity_18, #amenity_19, #amenity_20').attr('checked', '');
                jQuery('#pets-amenities').fadeOut();
            }
            else 
                jQuery('#pets-amenities').fadeIn();
        });
    });
    jQuery(document).ready(function(){
        CogzidelRoomEdit.init({
            exactCoords: new google.maps.LatLng(<?php echo $q[0]->lat; ?>, <?php echo $q[0]->long; ?>),
            fuzzyCoords: new google.maps.LatLng(<?php echo $q[0]->lat; ?>, <?php echo $q[0]->long; ?>),
            accuracy: 13,
            supportContent: '<p><strong>Rangoon St Unit, Chennai, Tamil Nadu, India</strong></p><p>Please contact <a href="#">Cogzidel support</a> to change this address.</p>'
        });
    });


    
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-2725447-1']);
    _gaq.push(['_setDomainName', '.cogzidel.com']);

    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

    jQuery(document).ready(function() {
        Cogzidel.init({userLoggedIn: true});
    });

</script>

<script type="text/javascript" charset="utf-8">NREUMQ.push(["nrf2","beacon-3.newrelic.com","fc09a36731",2237,"dlwMQktaWAgBEB1AXFpeERlcUV0Q",0,250])</script>