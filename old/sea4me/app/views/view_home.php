<style type="text/css">
    #selBanner{
        display: none;
    }
    #slideshow_container {
        min-height:428px;
    }
</style>
<?php
$query = $this->db->get_where('admin', array('id' => 1));
$q = $query->result();
?>
<div id="main">
    <div id="selContentHome" class="clsClearFix">			

        <div id="selSearch" class="clsFloatLeft">

            <div class="cls_bor">
                <h1><?php echo translate("Find a Boat"); ?></h1>
                <form action="<?php echo site_url('search') ?>" id="search_form" method="post">     	
                    <div class="clsClearFix" id="search">

                        <div class="clsSearchBox clsFloatLeft">
                            <label for="location" class="inner_text" id="location_label" style="display:none;"><?php echo translate("Where are you going?"); ?> </label>
                            <input type="text" class="location rounded_left" autocomplete="off" id="location" name="location" />
                        </div>
                        
                    </div>
                    <p id="enter_location_error_message" class="bad" style="display:none; clear:both; margin-left: 27px; font-weight: bold; color:#fff;"><?php echo translate("Please set location"); ?></p>
                    <div class="cls_all clearfix">
                        <div class="cls_chat clearfix">
                            <p><input type="text" id="checkin" class="checkin" name="checkin" value="<?php echo translate("Check in"); ?>" /></p>
                        </div>
                        <div class="cls_chat clearfix">
                            <p><input type="text" id="checkout" class="checkout" name="checkout" value="<?php echo translate("Check in"); ?>" /></p>
                        </div>
                        <div class="cls_chat clsNoPadding">
                            <div class="cls_chatsel">
                                <p>
                                    <select name="number_of_guests" id="number_of_guests">
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
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="clsSearch">
                        <input type="submit" value="<?php echo translate("Search"); ?>" class="clsSearchButton" name="Submit">
                    </div>
                </form>
                <!--check box-->

            </div>

        </div>

        <div id="selBanner" class="clsFloatRight">
            <div id="slideshow_container">
                <?php echo $divprint; ?>
            </div>
            <script type="text/javascript">
                var loadImmediately = [];
            </script>

            <div class="rounded_top" id="slideshow_controls">
                <a id="ss_button_prev" href="javascript:void(0);" class="ss_button_icon"></a>
                <a id="ss_button_pause_play" href="javascript:void(0);" class="ss_button_icon ss_button_pause"></a>
                <a id="ss_button_next" href="javascript:void(0);" class="ss_button_icon"></a>
            </div>
        </div>

    </div>
</div>

<!--Invites-->
<div style="clear:both;"></div>

<div class="cls_drop ">
    <ul class="clsClearFix">
    <!--	<li><a href="<?php echo site_url('info/how_it_works'); ?>">
                    <img src="<?php echo base_url(); ?>css/images/img1.jpg" width="221" height="124" alt="" title="" />
                    <p class="cls_work"><?php echo translate("How It's Works"); ?></p>
                    </a>
            </li>
            <li class="clsImgNoBorder"><a href="<?php echo site_url('#'); ?>">
                    <img src="<?php echo base_url(); ?>css/images/himg3.png" width="240" height="140" alt="" title="" />
                    <p class="cls_inv"><?php echo translate("INVITE NOW"); ?></p></a>
            </li>
            <li><a href="#">
                    <img src="<?php echo base_url(); ?>css/images/img4.jpg" width="230" height="124" alt="" title="" />
                    <p class="cls_enter"><?php echo translate("ENTER NOW"); ?></p></a>
            </li>-->
    </ul>	
</div>




<div style="clear:both;"></div>

<!--Invites Ends-->

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


    jQuery(document).ready(function() {
        Translations.review = "review";
        Translations.reviews = "reviews";
        Translations.night = "night";

        var opts = {};

        CogzidelHomePage.init(opts);
        CogzidelHomePage.defaultSearchValue = "Where are you going?";
    });

    jQuery(window).load(function() {
        CogzidelHomePage.initSlideshow();
        jQuery('#selBanner').css({ display: 'block'});
    });

    if ((navigator.userAgent.indexOf('iPhone') == -1) && (navigator.userAgent.indexOf('iPod') == -1) && (navigator.userAgent.indexOf('iPad') == -1)) {
        jQuery(window).load(function() {
            LazyLoad.js([
                "<?php echo base_url(); ?>js/jquery.autocomplete_custom.pack.js",
                "<?php echo base_url(); ?>js/en_autocomplete_data.js"],
            function() {
                jQuery("#location").autocomplete(autocomplete_terms, {
                    minChars: 1, width: 301, max:20, matchContains: false, autoFill: true,
                    formatItem: function(row, i, max) {
	                   
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


</script>

<script type="text/javascript" charset="utf-8">NREUMQ.push(["nrf2","beacon-1.newrelic.com","fc09a36731",2237,"dlwMQktaWAgBEB1aXFhWTV9XUVEc",0,23])</script>