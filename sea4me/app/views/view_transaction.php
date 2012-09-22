<!-- Required css stylesheets -->

<link href="<?php echo base_url() . 'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

<?php $this->load->view('includes/dash_header'); ?>
<div class="box">
    <div class="top"></div>
    <ul class="subnav">
        <li><a href="<?php echo base_url(); ?>func/account"></a><?php echo translate("Notification"); ?></li>
        <li><a href="<?php echo base_url(); ?>func/payout"><?php echo translate("Payout Preferences"); ?></a></li>
        <li class="active"><a href="<?php echo base_url(); ?>func/transaction"><?php echo translate("Transaction History"); ?></a></li>
        <li><a href="<?php echo base_url(); ?>func/recommendation"><?php echo translate("Get Recommendations"); ?></a></li>
    </ul>
    <div class="middle clsDes_Top_Spac">
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
                    <h1><?php echo translate("Transaction History"); ?></h1></div>
                <div>
                    <?php echo translate("Once you have reservations, the money that you have earned will be displayed here."); ?>
                </div>
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