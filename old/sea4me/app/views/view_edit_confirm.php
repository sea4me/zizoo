<!-- Newer date picker required stuff -->
<link href="<?php echo base_url() . 'css/views/page3-datauri.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    window.onload = initPhotoGallery; 

</script>
<style type="text/css">
    .ui-datepicker {

    }
    .ui-datepicker tr {
        /*	width:260px;*/
    }
    .ui-datepicker td {

    }
</style>

<script type="text/javascript">var needs_to_message = false;</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // init the flag widget handler too
        jQuery('#content_flag').hide();

        //CogzidelRooms.init();
    });
</script>

<?php
$set = 0;
$res = $this->db->get_where('list', array('id' => $room_id));
$s = $res->result();
$resA = $this->db->get_where('amnities', array('id' => $room_id));
$resB = $this->db->get_where('price', array('id' => $room_id));
$z = $resB->result();

$q = array();
$q = $resA->result();

if ($this->dx_auth->is_logged_in()) {
    $userid = $this->dx_auth->get_user_id();
    $query = $this->db->get_where('list', array('user_id' => $userid));
    if ($query->num_rows > 0)
        foreach ($query->result() as $row)
            if ($row->id == $room_id) {
                $set = 1;
                break;
            }
}
?>
<?php if ($set): ?>
    <div id="new_hosting_actions" class="rounded_most">
        <h2> <?php echo anchor('func/editListing/' . $room_id, translate("Edit this Listing")); ?> <span class="smaller"> <?php echo translate("Upload photos, change pricing, edit details"); ?> </span> </h2>

        <hr class="toolbar_separator" /> 
        <h2> <?php echo anchor('func/edituserprofile/' . $this->dx_auth->get_user_id(), translate("Update Your Profile")) ?> <span class="smaller"> <?php echo translate("Upload a new profile image and change your profile"); ?> </span> </h2>
    </div>
<?php endif; ?>
<!--  end of the top yellow bit -->
<div id="rooms" class="rounded_top">
    <div id="room" class="clsDes_Top_Spac">
        <script type="text/javascript">
            function translate(target_lang) {
                google.load("language", "1", {
                    "callback": function(){
                        jQuery('.trans').each(function(i, c){
                            google.language.translate(c.innerHTML, '', target_lang, function(result){
                                c.innerHTML = result.translation;
                            });
                        });
                    }
                });
            }
        </script>
        <div id="the_roof">
            <?php if ($res->num_rows > 0): ?>
                <?php foreach ($res->result() as $r): ?>
                    <div id="room_snapshot">
                        <div class="clsH1_long_Border">
                            <h1><?php echo $r->title; ?><span style="float:right;"><?php echo $page_viewed; ?> <span style="font-size:12px;"><?php echo translate("Views"); ?></span></span></h1>
                            <div style="clear:both"></div>
                        </div>
                        <h3> <?php echo translate("Bed & Breakfast"); ?> - <?php echo $r->room_type; ?> <span class="middot">&middot;</span> <span id="display_address" class="no_float"><?php echo $r->address ?></span> </h3>
                    </div>

                    <div class="clear"></div>
                </div>
                <div id="left_column">
                    <div id="main_content" class="box">
                        <div class="clsDisign_Box">
                            <div class="clsTop_Pannel">
                                <div class="clsTop_Left">
                                    <div class="clsTop_Right">
                                        <div class="clsTop_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="CenterPannel">
                                <div class="top">&nbsp;</div>
                                <div class="middle">
                                    <ul id="main_content_sub_nav" class="rooms_sub_nav">
                                        <li onclick="select_tab('main', 'photos_div', jQuery(this)); initPhotoGallery();" class="main_link selected"> <a href="#photos"> <?php echo translate("Photos"); ?> </a></li>
                                        <li onclick="select_tab('main', 'maps_div', jQuery(this)); load_map_wrapper();" class="main_link"><a href="#maps"> <?php echo translate("Maps"); ?> </a><a href="#guidebook" style="display:none;"></a></li>
                                        <li id="content_flag">
                                            <form action="/user_flags" class="new_user_flag" id="new_user_flag" method="post">
                                                <div class="flag-container" style="display: none;">
                                                    <div class="click-target clearfix"> <span class="expand"></span>
                                                        <h3> <?php echo translate("Report this message privately"); ?> </h3>
                                                        <span class="status"></span> </div>
                                                    <ul>
                                                        <li><a href="#" data-reason-id="Inappropriate/offensive content"> <?php echo translate("Inappropriate/offensive content"); ?> </a>
                                                        <li><a href="#" data-reason-id="Misleading/suspicious information"> <?php echo translate("Misleading/suspicious information"); ?> </a>
                                                        <li><a href="#" data-reason-id="Spam"> <?php echo translate("Spam"); ?> </a>
                                                        <li class="other"><a href="#" data-reason-id="Other"> <?php echo translate("Other"); ?> </a>
                                                            <div class="other-container">
                                                                <input id="user_flag_other_note" name="user_flag[other_note]" placeholder="Enter a reason" size="30" type="text" />
                                                            </div>
                                                    </ul>
                                                    <input id="user_flag_flaggable_type" name="user_flag[flaggable_type]" type="hidden" value="listing" />
                                                    <input id="user_flag_flaggable_id" name="user_flag[flaggable_id]" type="hidden" value="135134" />
                                                    <input id="user_flag_name" name="user_flag[name]" type="hidden" />
                                                </div>
                                            </form>
                                        </li>
                                        <li id="fb_link">
                                            <!-- Place holder for the fb like -->
                                        </li>
                                    </ul>
                                    <div id="photos_div" class="main_content">
                                        <div class="galleria_wrapper">
                                            <?php
                                            if (count($images) > 0) {
                                                echo '<div id="galleria_container">';
                                                //echo '<div class="image-placeholder"><img alt="" src="http://s8.muscache.com/1300304855/images/page3/v3/room_default_no_photos.jpg" /></div>';
                                                foreach ($images as $image) {

                                                    echo '<img src="' . $image['url'] . '" width="639" height="426" />';
                                                }
                                                echo '</div>';
                                            }
                                            if (count($images) == 0) {
                                                echo '  <div class="image-placeholder"><img alt="Room_default_no_photos" height="426" src="' . base_url() . 'images/no_image.jpg" width="639" /></div>
  					<div id="galleria_container">
      		<img alt="" src="' . base_url() . 'images/no_image.jpg" />
  			</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div id="maps_div" class="main_content" style="display:none;">
                                        <div id="map"> </div>
                                        <script type="text/javascript">
                                            //<![CDATA[
                                            var map;
                                            var markers = []; // index 0 will be hosting location

                                            function load_google_map() {
                                                if (GBrowserIsCompatible()) {
                                                    var MAX_ZOOM = 14;
                                                    var MIN_ZOOM = 11;
                                                    var map = new GMap2(document.getElementById("map"));
                                                    map.addControl(new GSmallMapControl());
                                                    map.addControl(new GScaleControl());

                                                    var bounds = new GLatLngBounds();
                                                    var user_loc = new GLatLng(<?php echo $r->lat; ?>,<?php echo $r->long; ?>);
                                                    bounds.extend(user_loc);

                                                    map.setCenter(user_loc, 13);

                                                    var icon = new GIcon();
                                                    icon.image = "<?php echo base_url(); ?>images/radius.png";
                                                    icon.shadow = "<?php echo base_url(); ?>images/mm_20_shadow.png";
                                                    icon.iconSize = new GSize(100, 100);
                                                    icon.shadowSize = new GSize(0, 0);
                                                    icon.iconAnchor = new GPoint(50, 50);
                                                    icon.infoWindowAnchor = new GPoint(50, 50);

                                                    var marker = new GMarker(user_loc, icon);
                                                    map.addOverlay(marker);
                                                    markers.push(marker);  // index 0 will be hosting location
                                                    originalzoom = null;

                                                    // Place recommendations
                                                    GEvent.addListener(map, "zoomend", function(oldzoom, newzoom) {
                                                        if (newzoom > MAX_ZOOM) {
                                                            markers[0].hide();
                                                        } else {
                                                            markers[0].show();
                                                        }
                                                    });
                                                }

                                            }

                                            //]]>
                                        </script>
                                    </div>
                                    <div id="calendar_div" class="main_content" style="display:none;">
                                        <div id="calendar_tab_container" >
                                            <div id="calendar_tab">
                                                <div style="float:left;width:400px;">

                                                </div>

                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="bottom">&nbsp;</div>
                            </div>
                            <div class="BottomPannel">
                                <div class="clsBottom_Left">
                                    <div class="clsBottom_Right">
                                        <div class="clsBottom_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        var map_loaded = false;
                        function load_map_wrapper() {
                            if(map_loaded == false) {
                                load_google_map();
                                map_loaded = true;
                            }
                        }

                        jQuery(document).ready( function() {
                            jQuery("body").bind("unload", function(){ GUnload();});
                        });
                    </script>
                    <div id="details" class="box">
                        <div class="clsDisign_Box">
                            <div class="clsTop_Pannel">
                                <div class="clsTop_Left">
                                    <div class="clsTop_Right">
                                        <div class="clsTop_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="CenterPannel">
                                <div class="top">&nbsp;</div>
                                <div class="middle">
                                    <ul id="details_sub_nav" class="rooms_sub_nav">
                                        <li onclick="select_tab('details', 'description', jQuery(this));" class="details_link selected" id="description_link"><a href="javascript:void(0);"> <?php echo translate("Description"); ?> </a></li>
                                        <li onclick="select_tab('details', 'amenities', jQuery(this));" class="details_link"><a href="javascript:void(0);" id="amenities_link"> <?php echo translate("Amenities"); ?> </a></li>
                                    </ul>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function(){
                                            jQuery('#description_details li:nth-child(even)').addClass('alt');
                                        });
                                    </script>
                                    <div id="description" class="details_content">
                                        <div id="description_text" class="rounded_less">
                                            <div id="new_translate_button_wrapper" style="display: none;">
                                                <div id="new_translate_button"> <span class="label"> <?php echo translate("Translate this description to English"); ?> </span> </div>
                                            </div>
                                            <div id="description_text_wrapper" class="trans">
                                                <p><?php echo $r->desc; ?></p>
                                            </div>
                                        </div>
                                        <ul id="description_details" class="rounded_less">
                                            <li style="padding:0 0 8px 10px; font-size:14px;"> <?php echo translate("Details"); ?> </li>
                                            <li><span class="property"> <?php echo translate("Room type:"); ?> </span><span class="value"><?php echo $r->room_type; ?></span></li>
                                            <li><span class="property"> <?php echo translate("Bed type:"); ?> </span><span class="value"> <?php echo translate("Real Bed"); ?> </span></li>
                                            <li><span class="property"> <?php echo translate("Accommodates:"); ?> </span><span class="value"><?php echo $r->capacity; ?></span></li>
                                            <li><span class="property"> <?php echo translate("Bedrooms:"); ?> </span><span class="value"><?php echo $r->bedrooms; ?></span></li>
                                            <li><span class="property"> <?php echo translate("Extra people:"); ?> </span><span class="value" id="extra_people_pricing">
                                                    <?php if ($z[0]->addguests == 0) echo "No extra Charges"; else echo $z[0]->addguests; ?>
                                                </span></li>
                                            <li><span class="property"> <?php echo translate("city:"); ?> </span> <span class="value">
                                                    <?php
                                                    $pieces = explode(",", $r->address);
                                                    $i = count($pieces);
                                                    echo $pieces[$i - 2];
                                                    ?>
                                                </span> </li>
                                            <li><span class="property"> <?php echo translate("Cancellation:"); ?> </span><span class="value"> <?php echo translate("Flexible"); ?> </span></li>
                                        </ul>
                                    </div>
                                    <div id="amenities" style="display:none" class="details_content">

                                        <?php
                                        $in_arr = explode(',', $r->amenities);
                                        $tCount = $amnities->num_rows();
                                        $i = 1;
                                        $j = 1;
                                        foreach ($amnities->result() as $rows) {
                                            if ($i == 1)
                                                echo '<ul>';
                                            ?>
                                            <li>
                                                <?php if (in_array($j, $in_arr)) { ?>
                                                    <img class="amenity-icon" src="<?php echo base_url(); ?>images/has_amenity.png" height="17" width="17" alt="Has amenity / Allowed" title="Has amenity / Allowed" />
                                                <?php } else { ?>
                                                    <img class="amenity-icon" src="<?php echo base_url(); ?>images/no_amenity.png" height="17" width="17" alt="Doesn't have amenity / Not allowed" title="Doesn't have amenity / Not allowed" />
                                            <?php } ?>		
                                                <p><?php echo $rows->name; ?> <a class="tooltip" title="<?php echo $rows->description; ?>"><img alt="Questionmark_hover" src="<?php echo base_url(); ?>images/questionmark_hover.png" style="width:12px; height:12px;" /></a></p>
                                            </li>
                                            <?php
                                            if ($i == 8) {
                                                $i = 0;
                                                echo '</ul>';
                                            } else if ($j == $tCount) {
                                                echo '</ul>';
                                            } $i++;
                                            $j++;
                                        }
                                        ?>  

                                        <div class="clear"></div>

                                    </div>
                                    <div id="house_rules" style="display:none" class="details_content">
                                        <p> <?php echo translate("This host has not specified any house rules."); ?> </p>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <!-- /middle -->
                                <div class="bottom">&nbsp;</div>
                            </div>
                            <div class="BottomPannel">
                                <div class="clsBottom_Left">
                                    <div class="clsBottom_Right">
                                        <div class="clsBottom_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /details -->
                    <div class="clear"></div>
                    <div id="lwlb_link" class="lwlb_lightbox" style="position:relative">
                        <div class="clsDisign_Box">
                            <div class="clsTop_Pannel">
                                <div class="clsTop_Left">
                                    <div class="clsTop_Right">
                                        <div class="clsTop_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="CenterPannel">
                                <div class="clsEdit_Left_Bor">
                                    <h1> <?php echo translate("Share Where"); ?> </h1>
                                </div>
                                <div class="clsShare_close_Icon"> <a href="#" onclick="lwlb_hide('lwlb_link');return false;"> <?php echo translate("close"); ?> </a> </div>
                                <p> <?php echo translate("Spread the love! Share this URL:"); ?> </p>
                                <input name="share_room_url" value="<?php echo base_url() . 'rooms/' . $room_id; ?>" style="width:360px; font-size:13px;" id="share_room_url" onclick="jQuery('#share_room_url').focus(); jQuery('#share_room_url').select();"/>
                                <br />
                            </div>
                            <div class="BottomPannel">
                                <div class="clsBottom_Left">
                                    <div class="clsBottom_Right">
                                        <div class="clsBottom_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
                <!-- left_column ends here -->
                <div id="right_column">
                    <div id="book_it" class="box">
                        <div class="clsDisign_Box">
                            <div class="clsTop_Pannel">
                                <div class="clsTop_Left">
                                    <div class="clsTop_Right">
                                        <div class="clsTop_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="CenterPannel">
                                <div class="top">&nbsp;</div>
                                <div class="middle">
                                    <div id="book_it_default" class="rounded">
                                        <div id="pricing" class="book_it_section">
                                            <p style="width:253px; float:left;"> <?php echo translate("From"); ?> </p>
                                            <h2 id="price_amount">$<?php echo $s[0]->price; ?></h2>
                                            <h4 id="price_amount"> <?php echo translate("per night"); ?> </h4>
                                            <div class="clear"></div>
                                        </div>
                                        <div id="dates" class="book_it_section clearfix"> <?php echo form_open('paypal/index/' . $room_id, array('class' => "info", 'id' => "book_it_form", 'name' => "book_it_form")); ?>
                                            <input id="hosting_id" name="hosting_id" type="hidden" value="<?php echo $room_id; ?>" />
                                            <div class="date_section">
                                                <label for="checkin"><?php echo translate("Check in"); ?></label>
                                                <input class="checkin" id="checkin" name="checkin" type="text" />
                                            </div>
                                            <div class="date_section">
                                                <label for="checkout"><?php echo translate("Check out"); ?></label>
                                                <input class="checkout" id="checkout" name="checkout" type="text" />
                                            </div>
                                            <div class="num_guests_section">
                                                <label for="number_of_guests"><?php echo translate("Guests"); ?></label>
                                                <select id="number_of_guests" name="number_of_guests" onchange="refresh_subtotal();">
                                                    <option value="1">1</option>
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
                                                    <option value="16">16+</option>
                                                </select>
                                            </div>
                                            <div class="clear"></div>
                                            <br/>
                                            <input value="<?php echo translate("Book Now"); ?>" style="float:right;" class="v3_button v3_blue v3_fixed_width" type="submit" />
                                            <div class="clear"></div>
                                            <br/>
                                            </form>
                                        </div>
                                        <div id="book_it_status" class="book_it_section">

                                            <div id="book_it_disabled" style="display:none;">
                                                <p id="book_it_disabled_message" class="bad"> <?php echo translate("This property is unavailable."); ?> </p>

                                                <a class='v3_button v3_orange v3_fixed_width' id='view_other_listings_button' onclick="if(check_inputs()){redo_search();}; return false;" href=""> <?php echo translate("View Other Listings"); ?> </a> <br />
                                            </div>
                                            <div id="show_more_subtotal_info" style="display:none;"> <a href="javascript:void(0);" onclick="jQuery('#more_subtotal_info_text, #less_subtotal_info_text').toggle(); jQuery('#more_subtotal_info_arrow, #less_subtotal_info_arrow').toggle(); jQuery('#subtotal_info').toggle();"><span id="more_subtotal_info_arrow"></span><span id="less_subtotal_info_arrow" style="display:none;"></span><span id="more_subtotal_info_text"><?php echo translate("more info"); ?></span><span id="less_subtotal_info_text" style="display:none;"><?php echo translate("less info"); ?></span></a>
                                                <div id="subtotal_info" style="display:none;"> <?php echo translate("Excludes Cogzidel service fee "); ?> (<span id="service_fee"></span>) </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <!-- middle -->
                                <div class="bottom">&nbsp;</div>
                            </div>
                            <div class="BottomPannel">
                                <div class="clsBottom_Left">
                                    <div class="clsBottom_Right">
                                        <div class="clsBottom_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="user" class="box">
                        <div class="clsDisign_Box">
                            <div class="clsTop_Pannel">
                                <div class="clsTop_Left">
                                    <div class="clsTop_Right">
                                        <div class="clsTop_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="CenterPannel">
                                <div class="top">&nbsp;</div>
                                <div class="middle"> <a id="show_more_user_info" href="javascript:void(0);"><span id="more_info_arrow"></span><span id="less_info_arrow" style="display:none;"></span> <span id="more_info_text" onclick="jQuery('#user_info_big, #less_info_text').show();jQuery('#image_holder).hide();"><?php echo translate("more info"); ?></span> <span id="less_info_text" onclick="jQuery('#image_holder, #more_info_text').show();jQuery(''#user_info_big, #less_info_text').hide();" style="display:none;"><?php echo translate("less info"); ?></span></a>
                                    <div id="user_info_small" class="user_info gray_gradient_fade rounded_less">
                                        <h2 style="margin-bottom:10px;">
                                            <?php
                                            $x = $this->db->get_where('users', array("id" => $r->user_id));
                                            foreach ($x->result() as $x1)
                                                echo $x1->username;
                                            ?>
                                        </h2>
                                        <div id="image_holder"> <img alt="<?php echo $x1->username; ?>" height="100" onclick="jQuery('#user_info_small, #user_info_big').toggle(); jQuery('#more_info_text, #less_info_text').toggle(); jQuery('#more_info_arrow, #less_info_arrow').toggle(); " src="<?php echo $this->Gallery->profilepic($x1->id) ?>" style="cursor:pointer;" title="User" width="100" /> </div>

                                        <div class="clear"></div>
                                    </div>
                                    <div id="user_info_big" class="user_info gray_gradient_fade rounded_less" style="display:none">
                                        <h2 style="margin-bottom:10px;">
                                            <?php
                                            $x = $this->db->get_where('users', array("id" => $r->user_id));
                                            foreach ($x->result() as $x1)
                                                echo $x1->username;
                                            ?>
                                        </h2>
        <?php
        $zed = $this->db->get_where('profiles', array('id' => $r->user_id));
        $z1 = $zed->result();
        ?>
                                        <img style="padding:5px; background:#b3b3b1;" alt=<?php echo $x1->username; ?> height="225" onclick="jQuery('#user_info_small, #user_info_big').toggle(); jQuery('#more_info_text, #less_info_text').toggle(); jQuery('#more_info_arrow, #less_info_arrow').toggle(); " src="<?php echo $this->Gallery->profilepic($x1->id) ?>" style="cursor:pointer;" width="225" />
                                        <ul>
                                            <li><span class="property"> <?php echo translate("First Name:"); ?> </span><?php if (isset($z1[0]->Fname)) echo $z1[0]->Fname; ?></li>
                                            <li><span class="property"> <?php echo translate("Last Name:"); ?> </span><?php if (isset($z1[0]->Fname)) echo $z1[0]->Lname; ?></li>
                                            <li><span class="property"> <?php echo translate("Living in:"); ?> </span> <?php if (isset($z1[0]->Fname)) echo $z1[0]->live; ?></li>
                                            <li><span class="property"> <?php echo translate("Working in:"); ?> </span><?php if (isset($z1[0]->Fname)) echo $z1[0]->work; ?> </li>
                                            <li><span class="property"> <?php echo translate("About Me:"); ?> </span><?php if (isset($z1[0]->Fname)) echo $z1[0]->describe; ?> </li>
                                        </ul>

                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="bottom">&nbsp;</div>
                            </div>
                            <div class="BottomPannel">
                                <div class="clsBottom_Left">
                                    <div class="clsBottom_Right">
                                        <div class="clsBottom_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="related_listings box" id="my_other_listings">
                        <div class="clsDisign_Box">
                            <div class="clsTop_Pannel">
                                <div class="clsTop_Left">
                                    <div class="clsTop_Right">
                                        <div class="clsTop_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="CenterPannel">
                                <div class="top">&nbsp;</div>
                                <div class="middle">
                                    <div class="related_listings_content gray_gradient_fade rounded_less">
                                        <!-- This section deals with the other listings by the same user -->
                                        <div class="clsEdit_Side_Bar">
                                            <h2> <?php echo translate("My Other Listings"); ?> </h2>
                                        </div>
                                            <?php $ans = $this->db->get_where('list', array("user_id" => $r->user_id));
                                            ?>
                                        <h4><?php echo $ans->num_rows; ?> <?php echo translate("rooms"); ?> </h4>
                                        <ul>
                                            <?php if ($ans->num_rows > 0): ?>
                                                <?php
                                                foreach ($ans->result() as $a):

                                                    $images = $this->Gallery->get_images($a->id);
                                                    if (count($images) == 0)
                                                        $url = base_url() . 'images/no_image.jpg';
                                                    else
                                                        $url = $images[0]['url'];
                                                    ?>
                                                    <?php
                                                    echo '<li>
                        <div class="related_listing_left">
                        <a href=' . base_url() . 'rooms/' . $a->id . ' id="related_listing_photo"><img alt="asasadafadasf" height="62" src="' . $url . '" title="asasadafadasf" width="93" /></a>
                        </div>';

                                                    echo '<div class="related_listing_right">';
                                                    echo anchor('rooms/' . $a->id, $a->title);

                                                    echo '<div class="subtitle">$' . $a->price . '/night <br />' . $a->room_type . '</div>
                        </div>';
                                                    echo '<div class="clear"></div>
                    </li>';
                                                    ?>
            <?php endforeach; ?>
        <?php endif; ?>
                                        </ul>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="bottom">&nbsp;</div>
                            </div>
                            <div class="BottomPannel">
                                <div class="clsBottom_Left">
                                    <div class="clsBottom_Right">
                                        <div class="clsBottom_Mid"> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $b = $this->db->get_where('admin', array('id' => 1));
                    $b1 = $b->result();
                    if ($b1[0]->adsense):
                        ?>
                        <div class="related_listings box" id="similar_listings">
                            <div class="top">&nbsp;</div>
                            <div class="middle">
                                <div class="related_listings_content gray_gradient_fade rounded_less clearfix">
                                    <h3> <?php echo translate("Ads"); ?> </h3>
            <?php echo $q[0]->adsense; ?> </div>
                                <!-- /related_listings_content -->
                            </div>
                            <!-- middle -->
                            <div class="bottom">&nbsp;</div>
                        </div>
                <?php endif; ?>
                </div>
    <?php endforeach; ?>
<?php else: ?>
            <h1> <?php echo translate("Sorry Such a room number does not exit "); ?> </h1>
<?php endif; ?>
        <div id="lwlb_overlay"></div>

        <div id="lwlb_needs_to_message" class="lwlb_lightbox2" style="display:none;">
            <div class="header">
                <div class="h1">
                    <h1> <?php echo translate("Please confirm availability"); ?> </h1>
                </div>
                <div class="close"><a href="#" onclick="lwlb_hide_and_reset('lwlb_needs_to_message');return false;"><img src="/images/lightboxes/close_button.gif" /></a></div>
                <div class="clear"></div>
            </div>
            <br/>
            <br/>
            <p> <?php echo translate("This host requires that you confirm availability before making a reservation.  Please send a message to the host and wait for a response before booking."); ?> </p>
            <br/>
            <br/>
            <p><span class='v3_button v3_blue' onclick="jQuery('#lwlb_needs_to_message').hide();jQuery('#user_contact_link').click();"> <?php echo translate("Contact Host"); ?> </span></p>
        </div>
        <div id="lwlb_contact_container"></div>
        <!-- set up a dummy link that we click later with js -->
        <a style="display:none;" id="fb_share_dummy_link" name="fb_share" type="icon_link" href="http://www.facebook.com/sharer.php"> <?php echo translate("Share"); ?> </a>
        <div class="clear"></div>
    </div>
    <!-- /rooms -->
</div>
<script type="text/javascript">

    window.fbAsyncInit = function() {
        FB.init({
            appId  : '02e3aebb07b4f37b41893ae7713c8fdc',
            status : true, 
            cookie : true, 
            xfbml  : true  
        });

        FB.getLoginStatus(function(response) {
            if (response && (response.status !== "unknown")) {
                jQuery.cookie("fbs", response.status);
            } else {
                jQuery.cookie("fbs", null);
            }
        });
				
        jQuery(document).trigger('fbInit');
    };

    (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());


    var needs_to_message = false;
    var ajax_already_messaged_url = "/messaging/ajax_already_messaged/3934";
    var ajax_lwlb_contact_url = "/rooms/ajax_lwlb_contact/3249";

    function action_email() {
        response = confirm("You must create a free account to use this feature. Continue?");
        if (response) window.location = "/users/signup_login?redirect_params%5Baction%5D=show&redirect_params%5Baction_to_take%5D=email&redirect_params%5Bcontroller%5D=rooms&redirect_params%5Bid%5D=3249";
    }

    function action_twitter() {
        popup('http://twitter.com/home/?status=Stay+at+%22Luxury%20B&amp;amp;B,%20New%20Delhi-Pine%20Room%22%20in%20New%20Delhi,%20India%20-+http://www.cogzidel.com%2Frooms%2F3249%20via%20@cogzidel%20%23Travel', 'console', 650, 1024);
    }

    function redo_search(opts) {
        opts = (opts === undefined ? {} : opts);

        opts.useAddressAsLocation = (opts.useAddressAsLocation === undefined ? true : opts.useAddressAsLocation);

        var urlParts = ["/search?"];

        if(opts.useAddressAsLocation === true){
            var locationParam = '';

            if(jQuery('#display_address')){
                locationParam += jQuery('#display_address').data('location');
            } else if(jQuery('.current_crumb .locality')){ //we can remove this else if block after Oct 12, 2010 -Chris
                locationParam += jQuery('.current_crumb .locality').html();
                if(jQuery('.current_crumb .region')){
                    locationParam += ', ';
                    locationParam += jQuery('.current_crumb .region').html();
                }
            }

            if(locationParam && locationParam != 'null' && locationParam != ''){
                urlParts = urlParts.concat(["location=", locationParam, '&sort_by=2&']);
            }
        }

        var checkinValue = jQuery('#checkin').val();
        var checkoutValue = jQuery('#checkout').val();

        if(checkinValue !== 'mm/dd/yyyy' && checkoutValue !== 'mm/dd/yyyy'){
            urlParts = urlParts.concat(["checkin=", checkinValue, "&checkout=", checkoutValue, '&']);
        }

        urlParts = urlParts.concat(["number_of_guests=", jQuery('#number_of_guests').val()]);

        url = urlParts.join('');

        window.location = url;

        return true;
    }

    function change_month2(cal_year) {
        var $spin = jQuery('#calendar_loading_spinner').show();

        // dim out the current calendar
        var $table = jQuery('#calendar_table')
        .css('opacity', .5)
        .css('filter', 'alpha(enabled=true)');
        
        // now load the calendar content
        jQuery('#calendar_tab_variable_content').load("<?php echo site_url('rooms/calendar_tab_inner') . '/' . $room_id; ?>", 
        {cal_month: jQuery('#cal_month').val(), cal_year: cal_year},
        function(response) {
            $table.css('opacity', 1.0)
            .css('filter', 'alpha(enabled=false)');
            $spin.hide();
        });
    }

    var initial_month_loaded = false;
    function load_initial_month(cal_year) {
        var $spin;
        if (initial_month_loaded === false) {
            var $spin = jQuery('#calendar_loading_spinner').show();
            jQuery('#calendar_tab_variable_content').load("<?php echo site_url('rooms/calendar_tab_inner') . '/' . $room_id; ?>",
            {cal_month: jQuery('#cal_month').val(), cal_year: cal_year},
            function() {
                $spin.hide();
                initial_month_loaded = true;
            }
        );
        }
    }

    var Translations = {
        translate_button: {
      
            show_original_description : 'Show original description',
            translate_this_description : 'Translate this description to English'
        },
        per_month: "per month",
        long_term: "Long Term Policy"
    }

    /* after pageload */
    jQuery(document).ready(function() {
        // initialize star state
        Cogzidel.Bookmarks.starredIds = [];
        Cogzidel.Bookmarks.initializeStarIcons();


        page3Slideshow.enableKeypressListener();

       
        var backToSearchHtml = ['<div id="back_to_search_container"><a rel="nofollow" onclick="if(redo_search({useAddressAsLocation : false})){return false;}" href="/search" id="back_to_search_link">', "Back to Search", '</a></div>'].join('');

     
        
        if(jQuery('a#view_other_listings_button')){
            jQuery('a#view_other_listings_button').attr('href', jQuery('#back_to_search_link').attr('href'));
        }
        /* end code for back to page2 */

        $('#new_hosting_actions a').click(function(e) {
            ajax_log('signup_funnel', 'click_new_hosting_action');
        });
        // init the flag widget handler too
        jQuery('#content_flag').hide();

        CogzidelRooms.init({inIsrael: false, 
            hostingId: 3249,
            otherHostingPrices: {"76670":"$73","76659":"$63","76662":"$63","76597":"$73"},
            nightlyPrice: "$63",
            weeklyPrice: "$440",
            monthlyPrice: "$1764"});

<?php if ($this->session->userdata('Vcheckin') != '') { ?>
            jQuery("#checkin").val('<?php echo $this->session->userdata('Vcheckin'); ?>');
<?php } ?>
<?php if ($this->session->userdata('Vcheckout') != '') { ?>
            jQuery("#checkout").val('<?php echo $this->session->userdata('Vcheckout'); ?>');
<?php } ?>

<?php if ($this->session->userdata('Vnumber_of_guests') != '') { ?>
            jQuery("#number_of_guests").val('<?php echo $this->session->userdata('Vnumber_of_guests'); ?>');
<?php } else { ?>
            jQuery("#number_of_guests").val('1');
<?php } ?>
        refresh_subtotal();

        jQuery('#extra_people_pricing').html("$10 / night after the first guest");


        jQuery('#weekly_price_string').html("$440");


        add_data_to_cookie('viewed_page3_ids', 3249);
        
        
        
        jQuery.ajax({
            url: '<? echo base_url(); ?>/ajax_increment_impressions',
            type: 'post',
            data: {
                param: ''
            }
        });

        jQuery.get("/rooms/sublet_available/3249?checkin=&checkout=", function(data) {
            jQuery("#right_column").prepend(data);
        });
        jQuery("#similar_listings").load("/rooms/similar_listings/3249?checkin=&checkout=&guests=1");
        jQuery.getJSON("/rooms/social_connections/3249", function(data) {
            var INITIAL_CONNECTIONS = 5;
            var i, len, list, $moreConnections, $moreCount, template;
            var relationships = data.relationships;

            if (relationships && relationships.length > 0) {
                len = relationships.length;
                list = jQuery("#social_connections_list");
                template = jQuery("#social_connection_template");

                for (i = 0; i < Math.min(INITIAL_CONNECTIONS, len); i++) {
                    list.append(template.jqote(relationships[i], '*'));
                }

                if (len > INITIAL_CONNECTIONS) {
                    $moreConnections = $("#more-connections").show();
                    $moreCount = $("#more-count")
                    .html(len - INITIAL_CONNECTIONS);

                    $moreConnections.one("click", function() {
                        for (i = INITIAL_CONNECTIONS; i < len; i++) {
                            list.append(template.jqote(relationships[i], '*'));
                        }
                        $moreConnections.hide();
                        $moreConnections = $moreCount = null;
                        return false;
                    });
                }
                jQuery("#social_connections").show();
            }
        });

    });


    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-2725447-1']);
    _gaq.push(['_setDomainName', '.cogzidel.com']);

    (function() {
        var m = /affiliate=([^;]*)/.exec(document.cookie);
        if (m) {_gaq.push(["_setCustomVar", 1, "affiliate", m[1]]);}
    })();

    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

    jQuery(document).ready(function() {
        Cogzidel.init({userLoggedIn: false});
    });

    Cogzidel.FACEBOOK_PERMS = "email,user_birthday,user_likes,user_education_history,user_hometown,user_interests,user_activities,user_location";
</script>