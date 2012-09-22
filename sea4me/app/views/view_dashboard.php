<!--  Required external style sheets -->
<link href="<?php echo base_url() . 'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/silver.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<!-- End of style sheet inclusion -->
<link href="<?php echo base_url() . 'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />
<?php $this->load->view('includes/dash_header'); ?>
<?php if ($this->uri->segment(3) != $this->dx_auth->get_user_id()): ?>
    <h1>
        <?php echo translate("Sorry you are not authorised to view this page"); ?>
    </h1>
<?php else: ?>
    <?php
    $query = $this->db->get_where('users', array('id' => $this->uri->segment(3)));
    $q = array();
    $q = $query->result();
    $email = $q[0]->email;
    //echo $email;
    ?>
    <div id="dashboard" class="clsDes_Top_Spac">

        <div id="left" style="overflow:hidden;">
            <div class="clsDisign_Box">
                <div class="clsTop_Pannel">
                    <div class="clsTop_Left">
                        <div class="clsTop_Right">
                            <div class="clsTop_Mid"> </div>
                        </div>
                    </div>
                </div>
                <div class="CenterPannel">
                    <div id="user_box" class="box">
                        <div class="top">&nbsp;</div>
                        <div class="middle">
                            <div style="text-align:center;" id="user_pic" onclick="show_ajax_image_box();"> <img alt="" src="<?php echo $this->Gallery->profilepic($this->dx_auth->get_user_id(), 2); ?>" title=""  /> </div>
                            <h1>
                                <?php if (strlen($this->dx_auth->get_username()) > 14): ?>
                                    <?php
                                    $query = $this->db->get_where('profiles', array('id' => $this->dx_auth->get_user_id()));
                                    $q5 = $query->result();
                                    echo $q5[0]->Fname . ' ' . $q5[0]->Lname;
                                    //	$this->dx_auth->get_username(); 
                                    ?>
                                <?php else: ?>
                                    <?php echo $this->dx_auth->get_username(); ?>
                                <?php endif; ?>
                                <br />
                                <span style="font-size:.55em; font-weight:bold; margin-left:2px;"><?php echo anchor('func/edituserprofile/' . $this->uri->segment(3), 'Edit Profile') ?></span></h1>
                        </div>
                        <!-- middle -->
                        <div class="bottom">&nbsp;</div>
                    </div>
                </div>
                <div class="BottomPannel">
                    <div class="clsBottom_Left">
                        <div class="clsBottom_Right">
                            <div class="clsBottom_Mid"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /user -->
            <div class="clsDisign_Box">
                <div class="clsTop_Pannel">
                    <div class="clsTop_Left">
                        <div class="clsTop_Right">
                            <div class="clsTop_Mid"> </div>
                        </div>
                    </div>
                </div>
                <div class="CenterPannel">
                    <div id="quick_links" class="box">
                        <div class="top">&nbsp;</div>
                        <div class="middle">
                            <div class="clsSide_border_Samll">
                                <h2>
                                    <?php echo translate("Quick Links"); ?>
                                </h2>
                            </div>
                            <ul>
                                <li><a href=<?php echo base_url() . 'hosting'; ?>>
                                        <?php echo translate("View/Edit Listings"); ?>
                                    </a></li>
                                <li><a href="<?php echo site_url('hosting/my_reservation'); ?>">
                                        <?php echo translate("Reservations"); ?>
                                    </a></li>
                            </ul>
                        </div>
                        <div style="clear:both"></div>
                        <div class="bottom">&nbsp;</div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="BottomPannel">
                    <div class="clsBottom_Left">
                        <div class="clsBottom_Right">
                            <div class="clsBottom_Mid"> </div>
                        </div>
                    </div>
                </div>
                <div style="clear:both"></div>
                <!-- /snapshot -->
            </div>
        </div>
        <!-- /left -->
        <div id="main" style="float:right;width:698px;">

            <div class="clsDisign_Box">
                <div class="clsTop_Pannel">
                    <div class="clsTop_Left">
                        <div class="clsTop_Right">
                            <div class="clsTop_Mid"> </div>
                        </div>
                    </div>
                </div>

                <div class="CenterPannel">
                    <div id="system_alert" class="box" >
                        <div class="top">&nbsp;</div>
                        <div class="middle"> <span style="font-weight:bold">
                                <?php echo translate("Welcome to " . $this->dx_auth->get_site_title() . "!"); ?>
                            </span>
                            <span style="font-size:14px; padding-top:8px;"> <span style="line-height:16px; padding:6px 0 10px 0; display:block;">
                                    <?php echo translate("This is your Dashboard, the place to manage your rental. Update all your personal information from here.."); ?>
                                </span> 
                            </span> </div>
                        <div class="bottom">&nbsp;</div>
                    </div>
                </div>

                <div class="BottomPannel">
                    <div class="clsBottom_Left">
                        <div class="clsBottom_Right">
                            <div class="clsBottom_Mid"> </div>
                        </div>
                    </div>
                </div>									
            </div>

            <div class="clsDisign_Box">
                <div class="clsTop_Pannel">
                    <div class="clsTop_Left">
                        <div class="clsTop_Right">
                            <div class="clsTop_Mid"> </div>
                        </div>
                    </div>
                </div>

                <div class="CenterPannel">
                    <div id="system_alert" class="box" >
                        <div class="top">&nbsp;</div>
                        <div class="middle"> 
                            <div class="clsBorder5">
                                <h1><?php echo translate("Messages ( " . $new_notify_rows . " new )"); ?> </h1>
                            </div>
                            <div id="Msg_Inbox_Small">
                                <ul>
                                    <?php
                                    if ($new_notify->num_rows() > 0) {
                                        foreach ($new_notify->result() as $row) { //print_r($row); 
                                            ?>	

                                            <li class="clearfix">
                                                <div class="clsMsg_User clsFloatLeft">
                                                    <a href="#"><img height="50" width="50" alt="" src="<?php echo $this->Gallery->profilepic($row->userby, 2); ?>" /></a>
                                                    <p><a href="#"><?php echo get_user_by_id($row->userby)->username; ?></a> <br />
                                                        <!--31 minutes--></p>
                                                </div>
                                                <div class="clsMeg_Detail clsFloatLeft">
                                                    <p>
                                                        <?php
                                                        if ($row->conversation_id != 0)
                                                            $message_id = $row->conversation_id; else
                                                            $message_id = $row->reservation_id;

                                                        if ($row->is_read == 0)
                                                            echo '<strong>'; echo anchor('' . $row->url . '/' . $message_id, $row->message, array("onclick" => "javascript:is_read(" . $row->id . ")"));
                                                        if ($row->is_read == 0)
                                                            echo '</strong>';
                                                        ?>
                                                        <br>
                                                        <span><?php echo substr(get_list_by_id($row->list_id)->title, 0, 10) ?></span>
                                                        <span>(<?php echo $row->checkin . ' - ' . $row->checkout; ?>)</span>
                                                    </p>
                                                </div>
                                                <div class="clsMeg_Off clsFloatLeft">
                                                    <p>
                                                        <span><?php echo $row->name; ?></span>
                                                        <br>
                                                        <span>$<?php echo $row->price; ?></span>
                                                    </p>
                                                </div>
                                            </li>

                                        <?php }
                                    } else {
                                        ?>

                                        <li class="clearfix">
        <?php echo translate("Nothing to show you."); ?>
                                        </li> 

    <?php } ?>

                                </ul>
                                <p style="width:150px; margin:10px 0 0; float:right;"><a class="Link_Green_Bg" href="<?php echo site_url('message/inbox'); ?>"><span>Go to all messages</span></a></p>
                                <div style="clear:both"></div>
                            </div>
                        </div>
                        <div class="bottom">&nbsp;</div>
                    </div>
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
    <!-- /main -->
    <div class="clear"></div>
    </div>

<?php endif; ?>
<script type="text/javascript">
    jQuery("#user_pic").hover(
    function(){jQuery('#edit_image_hover').fadeIn(100);},
    function(){jQuery('#edit_image_hover').fadeOut(100);}
);

    function is_read(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('message/is_read'); ?>",
            async: true,
            data: "message_id="+id
        });
    }

</script>