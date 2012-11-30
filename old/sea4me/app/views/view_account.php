<!-- Required css stylesheets -->

<link href="<?php echo base_url() . 'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

<!-- End of stylesheet inclusion -->
<?php $this->load->view('includes/dash_header'); ?>
<div class="box">
    <div class="top"></div>
    <ul class="subnav">
        <li class="active"><a href="<?php echo base_url(); ?>func/account"><?php echo translate("Notification"); ?></a></li>
        <li><a href="<?php echo base_url(); ?>func/payout"><?php echo translate("Payout Preferences"); ?></a></li>
        <li><a href="<?php echo base_url(); ?>func/transaction"><?php echo translate("Transaction History"); ?></a></li>
        <li><a href="<?php echo base_url(); ?>func/recommendation"><?php echo translate("Get Recommendations"); ?></a></li>
    </ul>
    <div class="middle e-mailsetting clsDes_Top_Spac">
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
                <div class="clsH1_long_Border">
                    <h1><?php echo translate("Email Setting"); ?></h1>
                </div>
                <?php echo form_open('func/emailSetting'); ?>
                <!--EMAIL SETTING-->

                <div class="section notification_section">
                    <div class="notification_area">
                        <div class="notification_header">
                            <h3><?php echo translate("Send me emails when"); ?>:</h3>
                            <h4><?php echo translate("We promise not to spam, and you can disable these at any time."); ?></h4>
                        </div>
                        <div class="notification_action">
                            <ul>
                                <li><input type="checkbox" value="1" name="offers" id="offers" checked="checked"> <?php echo $this->dx_auth->get_site_title(); ?> <?php echo translate("has periodic offers and deals on"); ?> <a target="_blank" href="javascript:void(0);" style="color: #0000CC"><?php echo translate("really cool destinations."); ?></a></li>
                                <li><input type="checkbox" value="1" name="news" id="news" checked="checked"> <?php echo $this->dx_auth->get_site_title(); ?> <?php echo translate("has"); ?> <a target="_blank" href="javascript:void(0);" style="color:#0000CC"><?php echo translate("fun company news"); ?></a>, <?php echo translate("as well as periodic emails."); ?></li>
                                <!--<li><input name="user_profile_info[opt_in_newsletter_email]" type="hidden" value="0" /><input checked="checked" id="user_profile_info_opt_in_newsletter_email" name="user_profile_info[opt_in_newsletter_email]" type="checkbox" value="1" /> I can help make the Dropinn experience better for everyone through completing quick surveys and questionnaires.</li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="notification_area">
                        <div class="notification_header">
                            <h3><?php echo translate("Remind me when"); ?>:</h3>
                            <h4><?php echo translate("Enabling these emails ensures the best possible experience for both hosts and guests."); ?></h4>
                        </div>
                        <div class="notification_action">
                            <ul>
                                <li><input type="checkbox" value="1" name="upcoming_reservation" id="upcoming_reservation" checked="checked"> <?php echo translate("I have an upcoming reservation."); ?></li>
                                <li><input type="checkbox" value="1" name="new_review" id="new_review" checked="checked"> <?php echo translate("I have received a new review."); ?></li>
                                <li><input type="checkbox" value="1" name="leave_review" id="leave_review" checked="checked"><?php echo translate("I need to leave a review for one of my guests."); ?> </li>
                                <li><input type="checkbox" value="1" name="standby" id="standby"><?php echo translate("I can fill my last-minute vacancies with"); ?> <a target="_blank" href="javascript:void(0);" style="color:#0000CC"><?php echo translate("standby guests"); ?></a>.</li>
                                <li><input type="checkbox" value="1" name="pdate_calendar" id="pdate_calendar" checked="checked"> <?php echo translate("I can improve my ranking in the search results by updating my calendar."); ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="buttons">
                        <input type="submit" value="<?php echo translate("Save Email Settings"); ?>" name="commit" class="v3_button">
                    </div>
                </div>
                <!--EMAIL SETTING-->
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
    <div class="bottom"></div>
</div>
</div>