<link href="<?php echo base_url(); ?>css/views/dashboard_v2.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/views/silver.css" media="screen" rel="stylesheet" type="text/css" />

<!-- Get the required Data -->
<?php
$id = $this->uri->segment(3);
$query = $this->db->get_where('list', array('id' => $id));
$q = $query->result();
?>

<!--Required Data from db  -->    
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
                <?php echo anchor('hosting', 'View All Listing', array('class' => 'to-parent')); ?>  

                <div class="nav-container">
                    <ul class="edit_room_nav">
                        <li >
                            <a class="details" href=<?php echo base_url() . 'func/editListing/' . $this->uri->segment(3); ?>>
                                <span class="icon"></span><?php echo translate("Description"); ?></a>
                        </li>
                        <li class="selected">
                            <?php echo anchor('func/photoListing/' . $this->uri->segment(3), 'Photos', array('class' => 'icon')) ?>
                        </li>

                        <li ><a class="pricing" href=<?php echo base_url() . 'func/editpricing/' . $this->uri->segment(3); ?> ><span class="icon"></span>Pricing and Terms</a></li>

                    </ul>

                    <ul class="edit_room_nav">
                    </ul>

                </div>
            </div>
            <div class="col three-fourths content">

                <div id="notification-area"></div>
                <div id="dashboard-content">





                    <div>
                        <div class="box" id="photos">
                            <div class="top">
                                <h2 class="step"><span class="edit_room_icon photo"></span><?php echo translate("Photos"); ?></h2>

                            </div>

                            <div class="middle">
                                <div id="photo_gizmo">

                                    <div id="options_container">

                                    </div>

                                    <div id="top_part" class="row">
                                        <div id="add_new_photo" class="col half">

                                            <div class="padded-text">

                                                <?php echo form_open_multipart('profiles/uploadphoto/' . $this->uri->segment(3)); ?>
                                                <input id="hosting_id" name="hosting_id" type="hidden" value="135134" />
                                                <label id="upload_photo" for="new_photo">Upload photo</label>
                                                <input id="new_photo_image" name="userfile"  size="24" type="file" />
                                                <input type="submit" value="<?php echo translate("Upload"); ?>" name="upload" />
                                                </form>

                                                <iframe id="upload_frame" name="upload_frame" style="display:none;"></iframe>

                                                <div id="upload_feedback"></div>
                                                <p><?php echo translate("You can upload a maximum of 100 photos to your listing."); ?><br/>
                                                    <?php echo translate("Suggested Size is 640x425 pixels, 2MB or less."); ?> <a href="javascript:void(0);"><?php echo translate("Photo tips."); ?></a></p>
                                            </div>
                                        </div>

                                        <div id="instructions" class="col half">

                                            <div class="padded-text">
                                                <div id="other_options">
                                                    <span id="title"><?php echo translate("More options:"); ?></span>

                                                </div>
                                                <p><?php echo translate("Your main photo will go here. Click and Drag photos to reorder them."); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row top-border">
                                        <div id="left_side" class="col half rounded">
                                            <div class="photo-padding">

                                                <div id="current_photo_container" style="position:relative">
                                                    <img id="spinner" src="/images/blue_spinner.gif" height="16" width="16" style="position:absolute; top:25%; left:50%; margin-top:-8px; margin-left:-8px; display:none;" />
                                                    <div id="current_photo">
                                                        <p style="font-size:16px; padding:5px; color:#333333; font-weight:bold;">
                                                            <?php echo translate("Hello there. It looks like you have not uploaded any photos yet. You should get started by using the small form above!"); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="right_side" class="col half rounded">
                                            <div class="photo-padding">
                                                <div id="all_photos">
                                                    <ul id="sortable_photos" style="float:left;">
                                                    </ul>
                                                    <div style="float:left;text-align:center; float:left; padding:0 6px;">
                                                        <p id="sortable_photos_status_message" style="display:none;"></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div><!-- middle -->


                            <div class="bottom">&nbsp;</div>
                        </div><!-- box -->

                        <script type="text/javascript">
                            //<![CDATA[
                            Sortable.create("sortable_photos", {constraint:false, onUpdate:function(){new Ajax.Request('/rooms/ajax_update_image_order?hosting_id=135134', {asynchronous:true, evalScripts:true, parameters:Sortable.serialize("sortable_photos")})}, overlap:'horizontal', scroll:false})
                            //]]>
                        </script>
                    </div>



                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

</div>

<!-- edit_room -->