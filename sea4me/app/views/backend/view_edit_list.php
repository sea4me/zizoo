<script type="text/javascript">
    function startCallback() {
        document.getElementById('message').innerHTML = '<img src="<?php echo base_url() . 'images/loading.gif' ?>">';
        // make something useful before submit (onStart)
        return true;
    }

    function completeCallback(response) {
        document.getElementById('message').innerHTML = response;
    }
			
    function startCallback2() {
        document.getElementById('message2').innerHTML = '<img src="<?php echo base_url() . 'images/loading.gif' ?>">';
        // make something useful before submit (onStart)
        return true;
    }

    function completeCallback2(response) {
        document.getElementById('message2').innerHTML = response;
    }
			
    function startCallback3() {
        document.getElementById('message3').innerHTML = '<img src="<?php echo base_url() . 'images/loading.gif' ?>">';
        // make something useful before submit (onStart)
        return true;
    }

    function completeCallback3(response) {
        var res = response;
        var getSplit = res.split('#'); 
        document.getElementById('galleria_container').innerHTML = getSplit[0];
        document.getElementById('message3').innerHTML           = getSplit[1];
    }
			
    function startCallback4() {
        document.getElementById('message4').innerHTML = '<img src="<?php echo base_url() . 'images/loading.gif' ?>">';
        // make something useful before submit (onStart)
        return true;
    }

    function completeCallback4(response) {
        document.getElementById('message4').innerHTML = response;
    }
	
</script>


<script type="text/javascript" src="<?php echo base_url() ?>js/webtoolkit.aim.js"></script>
<div class="clsSettings">
    <div class="clsMainSettings">
        <div class="clsNav">
            <ul>
                <li><a id="priceA" href="javascript:showhide('4');"><b><?php echo translate_admin('Pricing'); ?></b></a></li>
                <li><a id="photoA" href="javascript:showhide('3');"><b><?php echo translate_admin('Photos'); ?></b></a></li>
                <li><a id="aminitiesA" href="javascript:showhide('2');"><b><?php echo translate_admin('Aminities'); ?></b></a></li>
                <li><a id="descriptionA" class="clsNav_Act" href="javascript:showhide('1');"><b><?php echo translate_admin('Description'); ?></b></a></li>
            </ul>
        </div>
        <div class="clsTitle">
            <h3><?php echo translate_admin('Edit Listing'); ?></h3>
        </div>

        <div id="description">
            <form action="<?php echo base_url() . 'backend/backend/managelist'; ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})">
                <table class="table">
                    <tr>
                        <td><?php echo translate_admin("Property type"); ?></td>
                        <td>
                            <select style="width:100px;" class="fixed-width" id="hosting_property_type_id" name="property_id">
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
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo translate_admin("Accommodates"); ?></td>
                        <td>
                            <select style="width:100px;" class="fixed-width" id="hosting_person_capacity" name="capacity" >
                                <option value="1">1 person</option>
                                <option value="2">2 people</option>
                                <option value="3">3 people</option>
                                <option value="4">4 people</option>
                                <option value="5">5 people</option>
                                <option value="6">6 people</option>
                                <option value="7">7 people</option>
                                <option value="8">8 people</option>
                                <option value="9">9 people</option>
                                <option value="10">10 people</option>
                                <option value="11">11 people</option>
                                <option value="12">12 people</option>
                                <option value="13">13 people</option>
                                <option value="14">14 people</option>
                                <option value="15">15 people</option>
                                <option value="16">16+ people</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo translate_admin("Bedrooms"); ?></td>
                        <td>
                            <select style="width:100px;" class="fixed-width" id="hosting_bedrooms" name="bedrooms"><option value=""></option>
                                <option value="1">1 bedroom</option>
                                <option value="2">2 bedrooms</option>
                                <option value="3">3 bedrooms</option>
                                <option value="4">4 bedrooms</option>

                                <option value="5">5 bedrooms</option>
                                <option value="6">6 bedrooms</option>
                                <option value="7">7 bedrooms</option>
                                <option value="8">8 bedrooms</option>
                                <option value="9">9 bedrooms</option>
                                <option value="10">10 bedrooms</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo translate_admin("Room type"); ?></td>
                        <td>
                            <select style="width:100px;" class="fixed-width" id="hosting_room_type" name="room_type">
                                <option value="Private room">Private room</option>
                                <option value="Shared room">Shared room</option>
                                <option value="Entire home/apt">Entire home/apt</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo translate_admin("Title"); ?></td>
                        <td><input type="text" size="112" name="title" value="<?php echo $result->title; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo translate_admin("Address"); ?></td>
                        <td><textarea name="address"><?php echo $result->address; ?></textarea></td>
                    </tr>

                    <tr>
                        <td><?php echo translate_admin("Description"); ?></td>
                        <td><textarea name="desc"><?php echo $result->desc; ?></textarea></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <div class="clearfix">
                                <span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update_desc" value="<?php echo translate_admin("Update"); ?>" style="width:90px;" /></span>
                                <span style="float:left; padding:20px 0 0 0;"><div id="message"></div></span>
                            </div>
                        </td>
                    </tr>
                    <input type="hidden" name="list_id" value="<?php echo $result->id; ?>">

                </table> 
            </form>
        </div>


        <div id="aminities" style="display:none;">
            <form action="<?php echo base_url() . 'backend/backend/managelist'; ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback2, 'onComplete' : completeCallback2})">

                <table class="table">
                    <tr>
                        <td><input value="11" id="amenity_11" name="smoking" type="checkbox" <?php if ($aminities->smoking) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_11"><?php echo translate_admin("Smoking Allowed"); ?> </label></td>
                        <td><input value="12" id="amenity_12" name="pets" type="checkbox" <?php if ($aminities->pets) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_12"><?php echo translate_admin("Pets Allowed"); ?> </label></td>
                    </tr>
                    <tr>
                        <td><input value="1" id="amenity_1" name="tv" type="checkbox" <?php if ($aminities->tv) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_1"><?php echo translate_admin("TV"); ?> </label></td>
                        <td><input value="2" id="amenity_2" name="cable" type="checkbox" <?php if ($aminities->cable) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_2"><?php echo translate_admin("Cable TV "); ?></label></td>
                    </tr>
                    <tr>
                        <td><input value="3" id="amenity_3" name="internet" type="checkbox" <?php if ($aminities->internet) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_3"><?php echo translate_admin("Internet"); ?> <a class="tooltip" title="Internet (wired or wireless)"><img alt="Questionmark_hover" src="<?php echo base_url() . 'images/questionmark_hover.png'; ?>" style="width:16px; height:16px;" /></a> </label></td>
                        <td><input value="4" id="amenity_4" name="wireless" type="checkbox" <?php if ($aminities->wireless) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_4"><?php echo translate_admin("Wireless Internet"); ?> <a class="tooltip" title="A wireless router that guests can access 24/7."><img alt="Questionmark_hover" src="<?php echo base_url() . 'images/questionmark_hover.png'; ?>" style="width:16px; height:16px;" /></a> </label></td>
                    </tr>
                    <tr>
                        <td><input value="5" id="amenity_5" name="ac" type="checkbox" <?php if ($aminities->ac) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_5"><?php echo translate_admin("Air Conditioning"); ?> </label></td>
                        <td><input value="30" id="amenity_30" name="heating" type="checkbox" <?php if ($aminities->heating) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_30"><?php echo translate_admin("Heating"); ?> </label></td>
                    </tr>
                    <tr>
                        <td> <input value="21" id="amenity_21" name="elevator" type="checkbox" <?php if ($aminities->elevator) echo 'CHECKED'; ?>/></td>
                        <td> <label for="amenity_21"><?php echo translate_admin("Elevator in Building"); ?> </label></td>
                        <td><input value="6" id="amenity_6" name="handicap" type="checkbox" <?php if ($aminities->handicap) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_6"><?php echo translate_admin("Handicap Accessible"); ?> <a class="tooltip" title="The property is easily accessible.  Guests should communicate about individual needs."><img alt="Questionmark_hover" src="<?php echo base_url() . 'images/questionmark_hover.png'; ?>" style="width:16px; height:16px;" /></a> </label></td>
                    </tr>
                    <tr>
                        <td><input value="7" id="amenity_7" name="pool" type="checkbox" <?php if ($aminities->pool) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_7"><?php echo translate_admin("Pool"); ?> <a class="tooltip" title="A private swimming pool"><img alt="Questionmark_hover" src="<?php echo base_url() . 'images/questionmark_hover.png'; ?>" style="width:16px; height:16px;" /></a> </label></td>
                        <td><input value="8" id="amenity_8" name="kitchen" type="checkbox" <?php if ($aminities->kitchen) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_8"><?php echo translate_admin("Kitchen"); ?> <a class="tooltip" title="Kitchen is available for guest use"><img alt="Questionmark_hover" src="<?php echo base_url() . 'images/questionmark_hover.png'; ?>" style="width:16px; height:16px;" /></a> </label></td>
                    </tr>
                    <tr>
                        <td><input value="9" id="amenity_9" name="parking" type="checkbox" <?php if ($aminities->parking) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_9"><?php echo translate_admin("Parking Included"); ?> </label></td>
                        <td><input value="13" id="amenity_13" name="washer" type="checkbox" <?php if ($aminities->washer) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_13"><?php echo translate_admin("Washer / Dryer"); ?> <a class="tooltip" title="Paid or Free, in building"><img alt="Questionmark_hover" src="<?php echo base_url() . 'images/questionmark_hover.png'; ?>" style="width:16px; height:16px;" /></a> </label></td>
                    </tr>
                    <tr>
                        <td><input value="14" id="amenity_14" name="doorman" type="checkbox" <?php if ($aminities->doorman) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_14"><?php echo translate_admin("Doorman"); ?> </label></td>
                        <td><input value="15" id="amenity_15" name="gym" type="checkbox" <?php if ($aminities->gym) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_15"><?php echo translate_admin("Gym"); ?> <a class="tooltip" title="Guests have free access to a gym"><img alt="Questionmark_hover" src="<?php echo base_url() . 'images/questionmark_hover.png'; ?>" style="width:16px; height:16px;" /></a> </label></td>
                    </tr>
                    <tr>
                        <td><input value="25" id="amenity_25" name="hottub" type="checkbox" <?php if ($aminities->hottub) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_25"><?php echo translate_admin("Hot Tub"); ?> </label></td>
                        <td><input value="27" id="amenity_27" name="fireplace" type="checkbox" <?php if ($aminities->fireplace) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_27"><?php echo translate_admin("Indoor Fireplace"); ?> </label></td>
                    </tr>
                    <tr>
                        <td><input value="28" id="amenity_28" name="intercom" type="checkbox" /></td>
                        <td> <label for="amenity_28"><?php echo translate_admin("Buzzer/Wireless Intercom"); ?> </label></td>
                        <td><input value="16" id="amenity_16" name="breakfast" type="checkbox" <?php if ($aminities->breakfast) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_16"><?php echo translate_admin("Breakfast"); ?> <a class="tooltip" title="Breakfast is provided."><img alt="Questionmark_hover" src="<?php echo base_url() . 'images/questionmark_hover.png'; ?>" style="width:16px; height:16px;" /></a> </label></td>
                    </tr>
                    <tr>
                        <td><input value="31" id="amenity_31" name="kids" type="checkbox" <?php if ($aminities->kids) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_31"><?php echo translate_admin("Family/Kid Friendly"); ?> <a class="tooltip" title="The property is suitable for hosting famitres with children."><img alt="Questionmark_hover" src="<?php echo base_url() . 'images/questionmark_hover.png'; ?>" style="width:16px; height:16px;" /></a> </label></td>
                        <td><input value="32" id="amenity_32" name="events" type="checkbox" <?php if ($aminities->events) echo 'CHECKED'; ?> /></td>
                        <td><label for="amenity_32"><?php echo translate_admin("Suitable for Events"); ?> <a class="tooltip" title="The property can accommodate a gathering of 25 or more attendees."><img alt="Questionmark_hover" src="<?php echo base_url() . 'images/questionmark_hover.png'; ?>" style="width:16px; height:16px;" /></a> </label></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <div class="clearfix">
                                <span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update_aminities" value="<?php echo translate_admin("Update"); ?>" style="width:90px;" /></span>
                                <span style="float:left; padding:20px 0 0 0;"><div id="message2"></div></span>
                            </div>
                        </td>
                    </tr>
                    <input type="hidden" name="list_id" value="<?php echo $result->id; ?>">
                </table>

            </form>
        </div>

        <div id="photo" style="display:none; text-align:left;">
            <form enctype="multipart/form-data" action="<?php echo base_url() . 'backend/backend/managelist'; ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback3, 'onComplete' : completeCallback3})">
                <p style="text-align:left; border-top:4px solid #CCCCCC; font-size:15px; font-weight:bold; padding:10px 0 10px;"><span> <?php echo translate_admin("Choose to delete photo"); ?> </span>

                    <?php
                    if (count($images) > 0) {
                        echo '<div id="galleria_container"><ul class="clearfix">';
                        $i = 1;
                        foreach ($images as $image) {
                            echo '<li>';
                            echo '<p><label><input type="checkbox" name="image[]" value="' . $image['path'] . '" /></label>';
                            echo '<img src="' . $image['url'] . '" width="150" height="150" /></p>';
                            echo '</li>';
                            $i++;
                        }
                        echo '</ul></div>';
                    }
                    ?>
                </p>
                <input type="hidden" name="list_id" value="<?php echo $result->id; ?>">
                <p> <span style="margin:0 10px 0 0;"> <?php echo translate_admin("Upload new photo"); ?> </span>
                    <input id="new_photo_image" name="userfile"  size="24" type="file" />
                </p>

                <div class="clearfix">
                    <span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update_photo" value="<?php echo translate_admin("Update"); ?>" style="width:90px;" /></span>
                    <span style="float:left; padding:20px 0 0 0;"><div id="message3"></div></span>
                </div>
            </form>
        </div>

        <div id="price" style="display:none;">
            <form action="<?php echo base_url() . 'backend/backend/managelist'; ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback4, 'onComplete' : completeCallback4})">
                <table class="table">
                    <tr>
                        <td><?php echo translate_admin("Currency"); ?></td>
                        <td>
                            <select id="hosting_native_currency" name="currency">
                                <option value="AUD">AUD</option>
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
                                <option value="USD">USD</option>
                                <option value="ZAR">ZAR</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo translate_admin("Nightly"); ?></td>
                        <td><input type="text" name="nightly" value="<?php echo $price->night; ?>"></td>
                    </tr>

                    <tr>
                        <td><?php echo translate_admin("Weekly"); ?></td>
                        <td><input type="text" name="weekly" value="<?php echo $price->week; ?>"></td>
                    </tr>


                    <tr>
                        <td><?php echo translate_admin("Monthly"); ?></td>
                        <td><input type="text" name="monthly" value="<?php echo $price->month; ?>"></td>
                    </tr>


                    <tr>
                        <td><?php echo translate_admin("Additional Guests"); ?></td>
                        <td><input id="hosting_price_for_extra_person_native" name="extra" size="30" type="text" value=<?php echo $price->addguests; ?> /></td>
                    </tr>


                    <tr>
                        <td><?php echo translate_admin("Cleaning Fees"); ?></td>
                        <td><input id="hosting_extras_price_native" name="cleaning" size="30" type="text" value="<?php echo $price->cleaning; ?>"></td>
                    </tr>


                    <tr>
                        <td><?php echo translate_admin("Security Deposit"); ?></td>
                        <td><input id="hosting_security_deposit_native" name="security" size="30" value="<?php echo $price->security; ?>"></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <div class="clearfix">
                                <span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update_price" value="<?php echo translate_admin("Update"); ?>" style="width:90px;" /></span>
                                <span style="float:left; padding:20px 0 0 0;"><div id="message4"></div></span>
                            </div>
                        </td>
                    </tr>
                    <input type="hidden" name="list_id" value="<?php echo $result->id; ?>">

                </table> 
            </form>
        </div>

    </div>
</div>
</div>

<!-- TinyMCE inclusion -->
<script type="text/javascript" src="<?php echo base_url() ?>css/tiny_mce/tiny_mce.js" ></script>

<script language="Javascript">

    jQuery("#property_id").val('<?php echo $result->property_id; ?>');
    jQuery("#room_type").val('<?php echo $result->room_type; ?>');
    jQuery("#hosting_person_capacity").val('<?php echo $result->capacity; ?>');
    jQuery("#hosting_bedrooms").val('<?php echo $result->bedrooms; ?>');

    jQuery("#hosting_native_currency").val('<?php echo $price->currency; ?>');

    tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
    });

</script>  
<!-- End of inclusion of files -->
<script type="text/javascript">
    function showhide(id)
    {
        if(id == 1)
        {
            document.getElementById("description").style.display = "block";
            document.getElementById("aminities").style.display = "none";
            document.getElementById("photo").style.display = "none";
            document.getElementById("price").style.display = "none";
			
            document.getElementById('descriptionA').className = 'clsNav_Act';
            document.getElementById('aminitiesA').className = '';
            document.getElementById('photoA').className = '';
            document.getElementById('priceA').className = '';
        }
        else if(id == 2)
        {
            document.getElementById("aminities").style.display = "block";
            document.getElementById("description").style.display = "none";
            document.getElementById("photo").style.display = "none";
            document.getElementById("price").style.display = "none";
			
            document.getElementById('descriptionA').className = '';
            document.getElementById('aminitiesA').className = 'clsNav_Act';
            document.getElementById('photoA').className = '';
            document.getElementById('priceA').className = '';
        }
        else if(id == 3)
        {
            document.getElementById("photo").style.display = "block";
            document.getElementById("description").style.display = "none";
            document.getElementById("aminities").style.display = "none";
            document.getElementById("price").style.display = "none";
			
            document.getElementById('descriptionA').className = '';
            document.getElementById('aminitiesA').className = '';
            document.getElementById('photoA').className = 'clsNav_Act';
            document.getElementById('priceA').className = '';
        }
        else
        {
            document.getElementById("price").style.display = "block";
            document.getElementById("description").style.display = "none";
            document.getElementById("aminities").style.display = "none";
            document.getElementById("photo").style.display = "none";
			
            document.getElementById('descriptionA').className = '';
            document.getElementById('aminitiesA').className = '';
            document.getElementById('photoA').className = '';
            document.getElementById('priceA').className = 'clsNav_Act';
        }
    }
</script>