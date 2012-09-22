<link href="<?php echo base_url(); ?>css/views/dashboard_v2.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/views/silver.css" media="screen" rel="stylesheet" type="text/css" />

<style type="text/css">

    #galleria_container {
        text-align: left;
    }
    #galleria_container li {
        float:left;
        margin:0 0 10px 0;
    }
    #galleria_container label {
        float:left;
        width:25px;
        margin:0px;
    }

</style>

<script type="text/javascript" src="<?php echo base_url() ?>js/webtoolkit.aim.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/script.js"></script>

<script type="text/javascript">

    function startCallback() {
        document.getElementById('message').innerHTML = '<img src="<?php echo base_url() . 'images/loading.gif' ?>">';
        // make something useful before submit (onStart)
        return true;
    }

    function completeCallback(response) {
        var res = response;
        document.getElementById('galleria_container').innerHTML = res;
        $("#message").show();
        $("#message").html('<p style="color:#009933"><strong><em> List Photo`s Updated successfully </em></strong></p>');
        $("#message").delay(1000).fadeOut('slow');
    }
</script>

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

                    <?php $this->load->view('includes/editList_header.php'); ?>

                </div>
            </div>


            <div id="notification-area"></div>

            <div class="col three-fourths content">
                <ul class="subnav" id="photos">
                    <li id="upload-tab" onclick="javascript:showhide(1);" class="selected">Upload</li>
                    <li id="edit-tab" onclick="javascript:showhide(2);">Edit</li>
                </ul>

                <div id="notification-area"></div>
                <div id="dashboard-content">
                    <div id="message"></div>

                    <div id="new_photo" class="col half">

                        <div class="padded-text">

                            <form enctype="multipart/form-data" action="<?php echo site_url('func/photoListing/' . $this->uri->segment(3)); ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})">
                                <label id="upload_photo" for="new_photo">Upload photo</label>

                                <input  name="userfile"  size="24" type="file" />
                                <input type="submit" value="<?php echo translate("Upload"); ?>" name="update_photo" />
                            </form>


                            <div id="upload_feedback"></div>
                            <p><?php echo translate("You can upload a maximum of 100 photos to your listing."); ?><br/>
                                <?php echo translate("Suggested Size is 640x425 pixels, 2MB or less."); ?> <a href="javascript:void(0);"><?php echo translate("Photo tips."); ?></a></p>
                        </div>
                    </div>

                    <div id="photo_list" class="col half" style="display:none;">
                        <p style="text-align:left;  font-size:15px; font-weight:bold; padding:10px 0 10px;"><span> <?php echo translate_admin("Choose to delete photo"); ?> </span>
                        <form enctype="multipart/form-data" action="<?php echo site_url('func/photoListing/' . $this->uri->segment(3)); ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})">
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
                            <input type="submit" value="<?php echo translate("Update"); ?>" name="update_photo" />
                        </form>
                        </p>

                    </div>

                </div>

            </div></div></div>

    <script type="text/javascript">
        function showhide(id)
        {
            if(id == 1)
            {
                document.getElementById("new_photo").style.display = "block";
                document.getElementById("photo_list").style.display = "none";
			
                document.getElementById('upload-tab').className = 'selected';
                document.getElementById('edit-tab').className = '';
            }
            else
            {
                document.getElementById("photo_list").style.display = "block";
                document.getElementById("new_photo").style.display = "none";
		
                document.getElementById('edit-tab').className = 'selected';
                document.getElementById('upload-tab').className = '';
            }
        }
    </script>