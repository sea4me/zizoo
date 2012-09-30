<?php
$old_password = array(
    'name' => 'old_password',
    'id' => 'old_password',
    'size' => 30,
    'value' => set_value('old_password')
);

$new_password = array(
    'name' => 'new_password',
    'id' => 'new_password',
    'size' => 30
);

$confirm_new_password = array(
    'name' => 'confirm_new_password',
    'id' => 'confirm_new_password',
    'size' => 30
);
?>

<!--  Required external style sheets -->

<link href="<?php echo base_url() . 'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/silver.css'; ?>" media="screen" rel="stylesheet" type="text/css" />

<style>
    fieldset { border:0; }
</style>

<!-- End of style sheet inclusion -->

<link href="<?php echo base_url() . 'css/views/print.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<?php $this->load->view('includes/dash_header'); ?>

<?php if ($this->uri->segment(3) != $this->dx_auth->get_user_id()): ?>
    <h1>Sorry you are not authorised to view this page</h1>
<?php else: ?> 

    <?php
    $query = $this->db->get_where('users', array('id' => $this->uri->segment(3)));
    $q = array();
    $q = $query->result();
    ?>

    <div id="dashboard" class="clsDes_Top_Spac">
        <div id="left" style="overflow:hidden;">
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
                    <div id="user_box" class="box">

                        <div class="top">&nbsp;</div>
                        <div class="middle">

                            <div id="user_pic" style="text-align:center;" onclick="show_ajax_image_box();">
                                <img alt="" src="<?php echo $this->Gallery->profilepic($this->dx_auth->get_user_id(), 2); ?>" title=""  />
                            </div>

                            <h1><?php echo $q[0]->username; ?><br /><span style="font-size:.55em; font-weight:bold; margin-left:2px;"><?php echo anchor('/func/edituserprofile/' . $this->uri->segment(3), 'Edit Profile') ?></span></h1>


                        </div><!-- middle -->
                        <div class="bottom">&nbsp;</div>
                    </div><!-- /user -->
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
                    <div id="quick_links" class="box">
                        <div class="top">&nbsp;</div>
                        <div class="middle">
                            <div class="clsSide_border_Samll">

                                <h2>Quick Links</h2></div>
                            <ul>

                                <li><a href=<?php echo base_url() . 'hosting'; ?>>View/Edit Listings</a></li>
                                <li><a href=<?php echo base_url() . 'func/reserve'; ?>>Reservations</a></li>
                            </ul>

                        </div>
                        <div class="bottom">&nbsp;</div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="BottomPannel">
                    <div class="clsBottom_Left">
                        <div class="clsBottom_Right">
                            <div class="clsBottom_Mid">
                            </div>
                        </div>
                    </div>
                </div>
            </div><br />



        </div><!-- /left -->

        <div id="main" style="float:left;width:698px;">
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
                    <fieldset>

                        <?php echo form_open($this->uri->uri_string()); ?>

                        <?php echo $this->dx_auth->get_auth_error(); ?>

                        <dl>
                            <dt><?php echo form_label('Old Password', $old_password['id']); ?></dt>
                            <dd>
                                <?php echo form_password($old_password); ?>
                                <?php echo form_error($old_password['name']); ?>
                            </dd><br />

                            <dt><?php echo form_label('New Password', $new_password['id']); ?></dt>
                            <dd>
                                <?php echo form_password($new_password); ?>
                                <?php echo form_error($new_password['name']); ?>
                            </dd><br />

                            <dt><?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?></dt>
                            <dd>
                                <?php echo form_password($confirm_new_password); ?>
                                <?php echo form_error($confirm_new_password['name']); ?>
                            </dd><br /><br />

                            <dt></dt>

                            <center>	<dd><?php echo form_submit(array('name' => 'change', 'value' => 'Change Password', 'class' => 'button_change_password_green')); ?></dd></center>
                        </dl><br />

                        <?php echo form_close(); ?>
                    </fieldset>
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
        </div><!-- /main -->



        <div class="clear"></div>
    </div><!-- /dashboard -->
    <!-- /command_center -->


<?php endif; ?>
<script type="text/javascript">
    jQuery("#user_pic").hover(
    function(){jQuery('#edit_image_hover').fadeIn(100);},
    function(){jQuery('#edit_image_hover').fadeOut(100);}
);

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



