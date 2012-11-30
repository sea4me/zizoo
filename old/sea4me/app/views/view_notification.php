<!-- Required css stylesheets -->

<link href="<?php echo base_url() . 'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

<!-- End of stylesheet inclusion -->
<?php $this->load->view('includes/dash_header'); ?>
<div class="box">
    <div class="top"></div>
    <ul class="subnav">
        <li class="active"><a href="<?php echo base_url(); ?>func/account"></a><?php echo translate("Notification"); ?></li>
        <li><a href="<?php echo base_url(); ?>func/payout"><?php echo translate("Payout Preferences"); ?></a></li>
        <li><a href="<?php echo base_url(); ?>func/transaction"><?php echo translate("Transaction History"); ?></a></li>
        <li><a href="<?php echo base_url(); ?>func/recommendation"><?php echo translate("Get Recommendations"); ?></a></li>
        <li><a href="<?php echo base_url(); ?>func/reviews"><?php echo translate("Reviews & Recommendations"); ?></a></li>
        <li><a href="<?php echo base_url(); ?>func/referrals"><?php echo translate("Referrals"); ?></a></li>
    </ul>
    <div class="middle">
        <p style="background:#666666"><h2>Email Setting</h2></p>
        <?php echo form_open('func/emailSetting'); ?>

        <div class="section notification_section">
            <div class="notification_area">
                <div class="notification_header">
                    <h3><?php echo translate("Send me emails when:"); ?></h3>
                    <h4><?php echo translate("We promise not to spam, and you can disable these at any time."); ?></h4>
                </div>
                <div class="notification_action">
                    <ul>
                        <li><input type="checkbox" value="1" name="offers" id="offers" checked="checked"> <?php echo $this->dx_auth->get_site_title(); ?> <?php echo translate("has periodic offers and deals on"); ?> <a target="_blank" href="javascript:void(0);"><?php echo translate("really cool destinations"); ?></a>.</li>
                        <li><input type="checkbox" value="1" name="news" id="news" checked="checked"> <?php echo $this->dx_auth->get_site_title(); ?> <?php echo translate("has"); ?> <a target="_blank" href="javascript:void(0);"><?php echo translate("fun company news"); ?></a>, <?php echo translate("as well as periodic emails."); ?></li>

                    </ul>
                </div>
            </div>
            <div class="notification_area">
                <div class="notification_header">
                    <h3><?php echo translate("Remind me when:"); ?></h3>
                    <h4><?php echo translate("Enabling these emails ensures the best possible experience for both hosts and guests."); ?></h4>
                </div>
                <div class="notification_action">
                    <ul>
                        <li><input type="checkbox" value="1" name="upcoming_reservation" id="upcoming_reservation" checked="checked"> <?php echo translate("I have an upcoming reservation."); ?></li>
                        <li><input type="checkbox" value="1" name="new_review" id="new_review" checked="checked"> <?php echo translate("I have received a new review."); ?></li>
                        <li><input type="checkbox" value="1" name="leave_review" id="leave_review" checked="checked"> <?php echo translate("I need to leave a review for one of my guests."); ?></li>
                        <li><input type="checkbox" value="1" name="standby" id="standby"> <?php echo translate("I can fill my last-minute vacancies with"); ?> <a target="_blank" href="http://www.cogzidel.com/hosting/standbys"><?php echo translate("standby guests"); ?></a>.</li>
                        <li><input type="checkbox" value="1" name="pdate_calendar" id="pdate_calendar" checked="checked"> <?php echo translate("I can improve my ranking in the search results by updating my calendar."); ?></li>
                    </ul>
                </div>
            </div>
            <div class="buttons">
                <input type="submit" value="<?php echo translate("Save Email Settings"); ?>" name="commit" class="v3_button">
            </div>
        </div>


    </div>
    <div class="bottom"></div>
</div>
</div>

