<link href="<?php echo base_url() . 'css/views/page2-datauri.css'; ?>" media="screen" rel="stylesheet" type="text/css" />

<div id="v3_search" class="list_view rounded_more condensed_header_view" style='background: url("http://cogzidel.com/images/page2/v3/v3_search_bg.gif?1300304855") repeat-y scroll 0 0 white;' >
    <div id="search_header" class="rounded_top"></div>
    <!-- search_header -->
    <div id="search_params"> <?php echo form_open('search', array('id' => 'search_form')); ?>
        <form id="search_form" onsubmit="clean_up_and_submit_search_request(); return false;">
            <label for="location" class="inner_text" id="location_label" style="display:none;">
                <?php echo translate("City, address, or zip code"); ?>
            </label>
            <input type="text" class="location rounded_left" autocomplete="off" id="location" name="location" style="height:47px;" />
            <div id="search_inputs">
                <div class="dates_section">
                    <div class="heading">
                        <?php echo translate("Check in"); ?>
                    </div>
                    <input id="checkin" class="checkin date active" name="checkin" autocomplete="off" />
                </div>
                <div class="dates_section">
                    <div class="heading">
                        <?php echo translate("Check out"); ?>
                    </div>
                    <input id="checkout" class="checkout date active" name="checkout" autocomplete="off" />
                </div>
                <div class="guests_section">
                    <div class="heading">
                        <?php echo translate("Guests"); ?>
                    </div>
                    <select id="number_of_guests" name="number_of_guests">
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
            </div>
            <input class="v3_button v3_fixed_width search_v3_submit_location" type="submit" id="submit_location" name="submit_location" value="Search"/>
            <div id="search_magnifying_glass"></div>
            <input type="hidden" name="page" id="page" value="1" />
        </form>

        <!-- search_inputs -->
        <div id="search_type_toggle">
            <div class="search_type_option rounded_left search_type_option_active" id="search_type_list">
                <?php echo translate("List"); ?>
            </div>
            <div class="search_type_option" id="search_type_photo">
                <?php echo translate("Photo"); ?>
            </div>
            <!--  id="search_type_map" -->
            <a href="<?php echo base_url() . 'home'; ?>" >
                <div class="search_type_option rounded_right" >
                    <?php echo translate("Home"); ?>
                </div>
            </a> </div>
    </div>
    <!-- search_params -->
    <div id="standby_action_area" style="display:none;">
        <div> <b><a id="standby_link" href="/messaging/standby" target="_blank">
                    <?php echo translate("Do you need a place <i>pronto</i>? Join our Standby list!"); ?>
                </a></b> </div>
    </div>



    <div id="search_body" style="margin:10px 0 0 10px;">
        <div class="clsDisign_Box">
            <div class="clsTop_Pannel">
                <div class="clsTop_Left">
                    <div class="clsTop_Right">
                        <div class="clsTop_Mid">
                        </div>
                    </div>
                </div>
            </div>
            <div class="CenterPannel">

                <div>
                    <ul>
                        <?php echo $print; ?>
                    </ul>
                    <div style="clear:both"></div>
                    <?php if ($print == ""): ?>
                        <h3>
                            <?php echo translate("Sorry No results to display"); ?>
                        </h3>
                    <?php endif; ?>
                    <div style="clear:both"></div>
                </div>
                <div id="results_filters" style="">
                    <div id="filters_text"><?php echo translate("Filters:"); ?></div>
                    <ul id="applied_filters">
                    </ul>
                </div>
                <!--<div id="connect_banner" style="display:none;"> <a id="fb-connect-banner-button" href="#">
                <?php translate("Connect with Facebook"); ?>
                  </a>
                  <h2>
                <?php translate("See where your friends have traveled.", $this->session->userdata('lang')); ?>
                  </h2>
                -->
                <ul id="results">
                </ul>
                <!-- results -->
                <div id="results_footer" style="display:none;">
                    <div class="results_count"></div>
                    <div id="results_pagination"></div>
                </div>
                <!-- results_footer -->
                <!-- -->
            </div>
            <div class="BottomPannel">
                <div class="clsBottom_Left">
                    <div class="clsBottom_Right">
                        <div class="clsBottom_Mid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="search_filters_wrapper" class="rounded_bottom_right" style="float:right;margin-left:-3px !important; margin-top:10px!important; margin-right:10px!important;">
        <div id="search_filters">


            <div id="hidebyramesh" style="display:none;">
                <div id="map_wrapper" style="display:none;">
                    <div id="search_map"></div>
                    <div id="map_view_loading" class="rounded_more" style="display:none;"><img src="/images/page2/v3/page2_spinner.gif" style="display:block; float:left; padding:0 12px 0 0;"/>Loading...</div>
                    <div id="map_message" style="display:none;"></div>
                    <div id="first_time_map_question" style="display:none;">
                        <div id="first_time_map_question_content" class="rounded">
                            <div id="first_time_map_question_arrow"></div>
                            <p>Check this box to see new search results as you move the map.</p>

                            <a id="redo_search_in_map_link_on" href="javascript:void(0);">Yes, please</a>
                            <a id="redo_search_in_map_link_off" href="javascript:void(0);">No, thanks</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo form_open('search'); ?>
            <input type="hidden" name="location" value="<?php echo $query; ?>" />
            <input type="hidden" name="checkin"  value="<?php echo $checkin; ?>" />
            <input type="hidden" name="checkout" value="<?php echo $checkout; ?>" />
            <input type="hidden" name="number_of_guests"  value="<?php echo $number_of_guests; ?>" />
            <ul class="collapsable_filters">
                <li class="search_filter" id="room_type_container">
                    <div class="clsDisign_Box">
                        <div class="clsTop_Pannel">
                            <div class="clsTop_Left">
                                <div class="clsTop_Right">
                                    <div class="clsTop_Mid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="CenterPannel">
                            <div class="clsBorder_Side_Bar">
                                <a class="filter_toggle"></a>
                                <a class="filter_header" href="javascript:void(0);" style="height:25px;">
                                    <?php echo translate("Room type"); ?>
                                </a>
                            </div>
                            <!-- Search filter content is below this -->
                            <ul class="search_filter_content">
                                <li class="clearfix">
                                    <label for="room_type_0">
                                        <input type="checkbox" <?php
                                    if (is_array($room_types) > 0) {
                                        if (in_array('Entire home/apt', $room_types))
                                            echo 'checked="checked"';
                                    }
                                    ?> value="Entire home/apt" name="room_types[]" id="room_type_0">
<?php echo translate("Entire home/apt"); ?>
                                    </label>
                                </li>

                                <li class="clearfix">
                                    <label for="room_type_1">
                                        <input type="checkbox" <?php
if (is_array($room_types) > 0) {
    if (in_array('Private room', $room_types))
        echo 'checked="checked"';
}
?> value="Private room" name="room_types[]" id="room_type_1">
                                        <?php echo translate("Private room"); ?>
                                    </label>
                                </li>

                                <li class="clearfix">
                                    <label for="room_type_2">
                                        <input type="checkbox" <?php
                                        if (is_array($room_types) > 0) {
                                            if (in_array('Shared room', $room_types))
                                                echo 'checked="checked"';
                                        }
                                        ?> value="Shared room" name="room_types[]" id="room_type_2">
                            <?php echo translate("Shared room"); ?>
                                    </label>
                                </li>

                                <li>
                                    <input type="submit" class='v3_button v3_fixed_width search_v3_submit_location' value="<?php echo translate("Filter results"); ?>"/>
                                </li>
                            </ul>
                            <div style="clear:both"></div>
<?php /* echo form_close(); */ ?>
                            <div style="clear:both"></div>
                        </div>
                        <div style="clear:both"></div>
                        <div class="BottomPannel">
                            <div class="clsBottom_Left">
                                <div class="clsBottom_Right">
                                    <div class="clsBottom_Mid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </li>
                <li style="clear:both;"></li>
                <li class="search_filter" id="price_container" style="margin:10px 0 0 0">
                    <div class="clsDisign_Box">
                        <div class="clsTop_Pannel">
                            <div class="clsTop_Left">
                                <div class="clsTop_Right">
                                    <div class="clsTop_Mid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="CenterPannel">
                            <div class="clsBorder_Side_Bar">
                                <a class="filter_toggle"></a> <a class="filter_header" href="javascript:void(0);" style="height:25px;">
<?php echo translate("Price"); ?>
                                </a>
                            </div>
                            <div class="search_filter_content"> <?php echo form_open('search'); ?>
                                <ul>
                                    <li><span>
<?php echo translate("Min :"); ?>
                                        </span><br/>
                                        <input type="text" value="<?php if (isset($min)) echo $min; ?>" placeholder="<?php echo translate("Enter min price"); ?>" name='min'  />
                                    </li>
                                    <li><span>
<?php echo translate("Max :"); ?>
                                        </span><br/>
                                        <input type="text" value="<?php if (isset($max)) echo $max; ?>" placeholder="<?php echo translate("Enter max price"); ?>" name='max'  />
                                    </li>
                                    <li>
                                        <input type="submit" value="<?php echo translate("Filter by cost"); ?>" class='v3_button v3_fixed_width search_v3_submit_location' />
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="BottomPannel">
                            <div class="clsBottom_Left">
                                <div class="clsBottom_Right">
                                    <div class="clsBottom_Mid">
                                    </div>
                                </div>
                            </div>
                        </div></div>
                </li>
            </ul>

<?php echo form_close(); ?>




<?php translate("Loading...", $this->session->userdata('lang')); ?>
        </div>-->
        <div id="search_filters_toggle" class="search_filters_toggle_on rounded_left"></div>
    </div>
</div>



</div>


<ul id="blank_state_content" style="display:none;">
    <li id="blank_state">
        <div id="blank_state_molecule"></div>
        <div id="blank_state_text">
            <h3>
<?php echo translate("Your search was a little too specific."); ?>
            </h3>
            <p>
<?php echo translate("We suggest unchecking a couple of filters, or searching for a different city."); ?>
            </p>
        </div>
    </li>
</ul>




<style type="text/css">
    .ac_results { border-color:#a8a8a8; border-style:solid; border-width:1px 2px 2px; margin-left:1px; }
</style>
<script type="text/x-jqote-template" id="badge_template">
    <![CDATA[
    <li class="badge badge_type_<*= this.badge_type *>">
        <span class="badge_image">
            <span class="badge_text"><*= this.badge_text *></span>
        </span>
        <span class="badge_name"><*= this.badge_name *></span>
    </li>
    ]]>
</script>
<script type="text/x-jqote-template" id="list_view_item_template">
    <![CDATA[
    <li id="room_<*= this.hosting_id *>" class="search_result">
        <div class="pop_image_small">
            <div class="map_number"><*= this.result_number *></div>
            <a href="/rooms/<*= this.hosting_id *>" class="image_link" title="<*= this.hosting_name *>"><img alt="<*= this.hosting_name *>" class="search_thumbnail" height="426" src="<*= this.hosting_thumbnail_url *>" title="<*= this.hosting_name *>" width="639" /></a>
        </div>

        <div class="user_thumb">
            <a href="/rooms/<*= this.hosting_id *>"><img alt="<*= this.user_name *>" height="36" src="<*= this.user_thumbnail_url *>" title="<*= this.user_name *>" width="36" /></a>
        </div>

        <div class="room_details">
            <h2 class="room_title">
                <a class="name" href="/rooms/<*= this.hosting_id *>"><*= this.hosting_name *></a>
                <a href="#" id="star_<*= this.hosting_id *>" title="Add this listing as a 'favorite'" class="star_icon_container"><div class="star_icon"></div></a>
            </h2>
            <* if(this.distance) { *>
            <p class="address_max_width"><*= this.address *></p>
            <p class="distance"><*= this.distance *> <*= Translations.distance_away *></p>
            <* } else { *>
            <p class="address"><*= this.address *></p>
            <* } *>
            <ul class="reputation"></ul>
        </div>
        <div class="price">
            <div class="price_data">
                <sup class="currency_if_required"><*= CogzidelSearch.currencySymbolRight *></sup>
                <div class='currency_with_sup'><sup><*= CogzidelSearch.currencySymbolLeft *></sup><*= this.price *></div>
            </div>
            <div class="price_modifier">
                Per night
            </div>
        </div>

        <* if (this.connections.length > 0) { *>

        <div class="room-connections-wrapper">
            <span class="room-connections-arrow"></span>
            <div class="room-connections">
                <ul>
                    <* for (var k = 0; k < Math.min(this.connections.length, 3); k++) { *>
                    <li>
                        <img height="28" width="28" alt="" src="<*= this.connections[k].pic_url_small *>" />
                        <div class="room-connections-title">
                            <div class="room-connections-title-outer">
                                <div class="room-connections-title-inner">
                                    <*= this.connections[k].caption *>
                                </div>
                            </div>
                        </div>
                    </li>
                    <* } *>
                </ul>
            </div>
        </div>
        <* } *>
    </li>
    ]]>
</script>
<script type="text/x-jqote-template" id="applied_filters_template">
    <![CDATA[
    <li id="applied_filter_<*= this.filter_id *>"><span class="af_text"><*= this.filter_display_name *></span><a class="filter_x_container"><span class="filter_x"></span></a></li>
    ]]>
</script>
<script type="text/x-jqote-template" id="list_view_airtv_template">
    <![CDATA[
    <div id="airtv_promo">
        <img src="/images/page2/v3/airtv_promo_pic.jpg" />
        <h2><*= this.airtv_headline *></h2>
        <h3><*= this.airtv_description *> <b><?php echo translate("Watch Now!"); ?></b></h3>
    </div>
    ]]>
</script>
<div id="filters_lightbox" style="display:none;" class="rounded_most">
    <ul id="filters_lightbox_nav" class="rounded_top">
        <li class="filters_lightbox_nav_element" id="lightbox_nav_room_type">
            <a href="javascript:void(0);">
                <?php echo translate("Property"); ?>
            </a></li>
        <li class="filters_lightbox_nav_element" id="lightbox_nav_neighborhood"><a href="javascript:void(0);">
<?php echo translate("Neighborhood"); ?>
            </a></li>
        <li class="filters_lightbox_nav_element" id="lightbox_nav_amenities"><a href="javascript:void(0);">
                    <?php echo translate("Amenities"); ?>
            </a></li>
        <li class="filters_lightbox_nav_element" id="lightbox_nav_host"><a href="javascript:void(0);">
<?php echo translate("Host"); ?>
            </a></li>
    </ul>
    <ul id="lightbox_filters_not">
        <li class="lightbox_filter_container" id="lightbox_container_room_type" style="display:none;">
            <div class="lightbox_filters_left_column">
                <h3>
                            <?php echo translate("Room Type"); ?>
                </h3>
                <ul id="lightbox_filter_content_room_type" class="search_filter_content">
                </ul>
                <h3>
<?php echo translate("Size"); ?>
                </h3>
                <ul id="lightbox_filter_content_size" class="search_filter_content">
                    <li>
                        <label for="min_bedrooms">
<?php echo translate("Min Bedrooms"); ?>
                        </label>
                        <select class="dropdown" id="min_bedrooms" name="min_bedrooms">
                            <option value=""></option>
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
                        </select>
                    </li>
                    <li>
                        <label for="min_bathrooms">
<?php echo translate("Min Bathrooms"); ?>
                        </label>
                        <select class="dropdown" id="min_bathrooms" name="min_bathrooms">
                            <option value=""></option>
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
                        </select>
                    </li>
                    <li>
                        <label for="min_beds">
<?php echo translate("Min Beds"); ?>
                        </label>
                        <select class="dropdown" id="min_beds" name="min_beds">
                            <option value=""></option>
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
                    </li>
                </ul>
            </div>
            <div class="lightbox_filters_right_column">
                <h3>
<?php echo translate("Property Type"); ?>
                </h3>
                <ul id="lightbox_filter_content_property_type_id" class="search_filter_content">
                </ul>
            </div>
        </li>
        <li class="lightbox_filter_container" id="lightbox_container_neighborhood" style="display:none;">
            <ul class="search_filter_content">
            </ul>
        </li>
        <li class="lightbox_filter_container" id="lightbox_container_amenities" style="display:none;">
            <ul class="search_filter_content">
            </ul>
        </li>
        <li class="lightbox_filter_container" id="lightbox_container_host" style="display:none;">
            <div class="lightbox_filters_left_column">
                <!--
                        <h3>Profile Completion</h3>
                        <ul id="lightbox_filter_content_profile_completion" class="search_filter_content"></ul>
                -->
                <h3>
<?php echo translate("Languages Spoken"); ?>
                </h3>
                <ul id="lightbox_filter_content_languages" class="search_filter_content">
                </ul>
            </div>
            <div class="lightbox_filters_right_column">
                <!--
                        <h3>My Groups</h3>
                        <ul id="lightbox_filter_content_group_ids" class="search_filter_content"></ul>
                -->
            </div>
            <ul class="search_filter_content">
            </ul>
        </li>
    </ul>
    <!-- lightbox_filters -->
    <div id="lightbox_filter_action_area" class="rounded_bottom"> <a href="javascript:void(0);" onclick="SearchFilters.closeFiltersLightbox();">
<?php echo translate("Cancel"); ?>
        </a>
        <input id="lightbox_search_button" class="v3_button v3_fixed_width search_v3_submit_location search_v3_submit_alternative" type="submit" value="<?php echo translate("Search"); ?>"/>
    </div>
</div>
<!-- filters_lightbox -->


<div id="fb-root"></div> 

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
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1049231994/?label=0W9CCND30wEQ-oSo9AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.5&sensor=false"></script>


<script type="text/javascript">

    window.fbAsyncInit = function() {
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
    };

    (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());


		
    if ((navigator.userAgent.indexOf('iPhone') == -1) && (navigator.userAgent.indexOf('iPod') == -1) && (navigator.userAgent.indexOf('iPad') == -1)) {
        jQuery(window).load(function() {
            LazyLoad.js([
                "<?php echo base_url() . 'js' ?>/jquery.autocomplete_custom.pack.js",
                "<?php echo base_url() . 'js' ?>/en_autocomplete_data.js"],
            function() {
                jQuery("#location").autocomplete(autocomplete_terms, {
                    minChars: 1, width: 322, max:20, matchContains: false, autoFill: true,
                    formatItem: function(row, i, max) {
                        //to show counts, uncomment
                        //return row.k + " <span class='autocomplete_extra_info'>(" + row.c + ")</span>";
                        return Cogzidel.Utils.decode(row.k);
                    },
                    formatMatch: function(row, i, max) {
                        return Cogzidel.Utils.decode(row.k);
                    },
                    formatResult: function(row) {
                        return Cogzidel.Utils.decode(row.k);
                    }
                });
            }
        );
        });
    }
    jQuery(document).ready(function(){
        Cogzidel.Bookmarks.starredIds = [];

        CogzidelSearch.$.bind('finishedrendering', function(){ 
            Cogzidel.Bookmarks.initializeStarIcons(function(e, isStarred){ 
                // hide the listing result from the set of search results when the result is unstarred
                if(!isStarred && CogzidelSearch.isViewingStarred){
                    if(CogzidelSearch.currentViewType == 'list')
                        $('#room_' + $(e).data('hosting_id')).slideUp(500);
                    else if(CogzidelSearch.currentViewType == 'photo')
                        $('#room_' + $(e).data('hosting_id')).fadeOut(500);
                }
            }) 
        });

        SearchFilters.amenities.a_11 = ["Smoking Allowed", false];
        SearchFilters.amenities.a_12 = ["Pets Allowed", false];
        SearchFilters.amenities.a_1 = ["TV", false];
        SearchFilters.amenities.a_2 = ["Cable TV", false];
        SearchFilters.amenities.a_3 = ["Internet", false];
        SearchFilters.amenities.a_4 = ["Wireless Internet", false];
        SearchFilters.amenities.a_5 = ["Air Conditioning", false];
        SearchFilters.amenities.a_30 = ["Heating", false];
        SearchFilters.amenities.a_21 = ["Elevator in Building", false];
        SearchFilters.amenities.a_6 = ["Handicap Accessible", false];
        SearchFilters.amenities.a_7 = ["Pool", false];
        SearchFilters.amenities.a_8 = ["Kitchen", false];
        SearchFilters.amenities.a_9 = ["Parking Included", false];
        SearchFilters.amenities.a_13 = ["Washer / Dryer", false];
        SearchFilters.amenities.a_14 = ["Doorman", false];
        SearchFilters.amenities.a_15 = ["Gym", false];
        SearchFilters.amenities.a_25 = ["Hot Tub", false];
        SearchFilters.amenities.a_27 = ["Indoor Fireplace", false];
        SearchFilters.amenities.a_28 = ["Buzzer/Wireless Intercom", false];
        SearchFilters.amenities.a_16 = ["Breakfast", false];
        SearchFilters.amenities.a_31 = ["Family/Kid Friendly", false];
        SearchFilters.amenities.a_32 = ["Suitable for Events", false];

        CogzidelSearch.currencySymbolLeft = '$';
        CogzidelSearch.currencySymbolRight = "";
        SearchFilters.minPrice = 10;
        SearchFilters.maxPrice = 300;
        SearchFilters.minPriceMonthly = 150;
        SearchFilters.maxPriceMonthly = 5000;

        var options = {};

 
        if(CogzidelSearch.searchHasBeenModified()){
            options = {"location":"<?php echo $query; ?>","number_of_guests":"<?php echo $number_of_guests; ?>","action":"index","checkin":"<?php echo $checkin; ?>","guests":"<?php echo $number_of_guests; ?>","checkout":"<?php echo $checkout; ?>","submit_location":"Search","controller":"search"};
        } else {
            options = {"location":"<?php echo $query; ?>","number_of_guests":"<?php echo $number_of_guests; ?>","action":"index","checkin":"<?php echo $checkin; ?>","guests":"<?php echo $number_of_guests; ?>","checkout":"<?php echo $checkout; ?>","submit_location":"Search","controller":"search"};
        }



        CogzidelSearch.isViewingStarred = false;
       

        if(options.search_view) {
            CogzidelSearch.forcedViewType = options.search_view;
        }






        Translations.clear_dates = "Clear Dates";
        Translations.entire_place = "Entire Place";
        Translations.friend = "friend";
        Translations.friends = "friends";
        Translations.loading = "Loading";
        Translations.neighborhoods = "Neighborhoods";
        Translations.private_room = "Private Room";
        Translations.review = "review";
        Translations.reviews = "reviews";
        Translations.superhost = "superhost";
        Translations.shared_room = "Shared Room";
        Translations.today = "Today";
        Translations.you_are_here = "You are Here";
        Translations.a_friend = "a friend";
        Translations.distance_away = "away";
        Translations.instant_book = "Instant Book";
        Translations.show_more = "Show More...";
        Translations.learn_more = "Learn More";
        Translations.social_connections = "Social Connections";

        Translations.amenities = "Amenities";
        Translations.room_type = "Room Type";
        Translations.price = "Price";
        Translations.keywords = "Keywords";
        Translations.property_type = "Property Type";
        Translations.bedrooms = "Bedrooms";
        Translations.bathrooms = "Bathrooms";
        Translations.beds = "Beds";
        Translations.languages = "Languages";
        Translations.collection = "Collection";

        //zoom in to see more properties message in map view
        Translations.redo_search_in_map_tip = "\"Redo search in map\" must be checked to see new results as you move the map";
        Translations.zoom_in_to_see_more_properties = "Zoom in to see more properties";

        //when map is zoomed in too far
        Translations.your_search_was_too_specific = "Your search was a little too specific.";
        Translations.we_suggest_unchecking_a_couple_filters = "We suggest unchecking a couple filters, zooming out, or searching for a different city.";

        TrackingPixel.params.uuid = "yq0m0k6hjg";
        TrackingPixel.params.user = "";
        TrackingPixel.params.af = "";
        TrackingPixel.params.c = "";
        TrackingPixel.params.pg = '2';

        CogzidelSearch.init(options);

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
<script type="text/javascript" charset="utf-8">NREUMQ.push(["nrf2","beacon-1.newrelic.com","fc09a36731",2237,"dlwMQktaWAgBEB1BVlRBAV4WXFoAARo=",0,40])</script>