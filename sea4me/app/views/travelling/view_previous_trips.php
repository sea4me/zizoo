<!-- Required css stylesheets -->
<script type="text/javascript" src="<?php echo base_url() . 'js/jquery.fancybox-1.3.4.pack.js'; ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'css/jquery.fancybox-1.3.4.css' ?>" media="screen" />

<link href="<?php echo base_url() . 'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

<!-- End of stylesheet inclusion -->
<?php
$this->load->view('includes/dash_header');

// Print The Reservation List
$content = '';
$content .= '<p style="padding:5px 5px 5px 725px"><a style="color:#38859B;cursor:pointer;" onClick="javascript:window.print();"><strong>' . translate('Print') . '</strong></a></p>';
$content .= '<table border="1" width="100%">';
$content .= '<tr>';
$content .= '<th>' . translate("Status") . '</th>';
$content .= '<th>' . translate("Location") . '</th>';
$content .= '<th>' . translate("Host") . '</th>';
$content .= '<th>' . translate("Dates") . '</th>';
$content .= '</tr>';

foreach ($result->result() as $row) {

    $content .= '<tr>';
    $content .= '<td>' . $row->name . '</td>';
    $content .= '<td><p><strong>' . get_list_by_id($row->list_id)->title . '</strong></p><p><em>' . get_list_by_id($row->list_id)->address . '</em></p></td>';
    $content .= '<td><p><img height="50" width="50" alt="image" style="float:left; margin:0 10px 10px 0;" src="' . $this->Gallery->profilepic($row->userto, 2) . '" />' . ucfirst(get_user_by_id($row->userto)->username) . '</p</td>';
    $content .= '<td>$' . $row->checkin . ' - ' . $row->checkout . '</td>';
    $content .= '</tr>';
}

$content .= '</table>';
?>

<script type="text/javascript">

    function print_reservation() {
        var myWindow;
        myWindow=window.open('','_blank','width=800,height=500');
        myWindow.document.write("<p><?php echo addslashes($content); ?></p>");
        myWindow.print();
    }
</script>

<?php $this->load->view('includes/travelling_header'); ?>
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
            <div id="previous">
                <div class="clsH1_long_Border"><p><h1><b><?php echo translate("Upcomming Trips"); ?></b></h1></p>	</div>						 		 
                <?php if ($result->num_rows() > 0) { ?>

                    <p class="text_right" style="margin:10px 0 0;"><span class="View_MyPrint"> <a href="javascript:void(0);" onclick="javascript:print_reservation();"><?php echo translate("Print this page"); ?></a> </span></p>
                    <table class="Table_Bor_Bttm" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <th> <?php echo translate("Status"); ?> </th>
                            <th> <?php echo translate("Location"); ?> </th>
                            <th> <?php echo translate("Host"); ?> </th>
                            <th> <?php echo translate("Dates"); ?> </th>
                            <th> <?php echo translate("Options"); ?> </th>
                        </tr>

                        <?php foreach ($result->result() as $row) { ?>
                            <tr>
                                <td> <p class="View_my_Accept_Bg"><span><?php echo $row->name; ?></span></p> </td>
                                <td width="30%">
                                    <p class="clsBold"> <?php echo anchor('travelling/host_details/' . $row->id, get_list_by_id($row->list_id)->address); ?> </p> 
                                </td>
                                <td width="27%">
                                    <p> <img height="50" width="50" alt="image" style="float:left; margin:0 10px 10px 0;" src="<?php echo $this->Gallery->profilepic($row->userto, 2); ?>" />
                                        <span class="clsBold"><?php echo ucfirst(get_user_by_id($row->userto)->username); ?></span></p>
                                    <span class="clsMyReser_SendMsg"><a href="<?php echo site_url('trips/send_message/' . $row->userby); ?>"><?php echo translate("View") . ' / ' . translate("Send") . ' ' . translate("Message"); ?></a></span>
                                </td>
                                <td><?php echo $row->checkin . ' - ' . $row->checkout; ?></td>
                                <td>
                                    <p class="clsBold"><?php echo anchor('travelling/billing/' . $row->id, translate("View Billing")); ?></p>
                                    <p class="clsBold"><a href="<?php echo site_url('trips/send_message/' . $row->userby); ?>"><?php echo translate("Message History"); ?></a></p>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>

                <?php } else { ?>

                    <div id="searching">
                        <?php echo form_open("search", array('id' => 'search_form')); ?>  
                        <p><?php echo translate("You have no current trips."); ?> </p><br>
                        <input value="Where are you going?" onclick="clear_location(this);" type="text" class="location rounded_left" autocomplete="off" id="location" style="width:250px;float:left; margin-right:10px;" name="location" /></div>
                    <input id="submit_location" onclick="if (check_inputs()) {$('#search_form').submit();}return false;" class="v3_button v3_fixed_width search_v3_submit_location" type="button" value="<?php echo translate("Search"); ?>" name="submit_location"> 
                    <?php echo form_close(); ?>
                </div>

            <?php } ?>	
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

</div> <!-- this tag for Header file -->

<!-- Footer Scripts -->

<script type="text/javascript">
    function is_not_set_location() { return (!$('#location').val() || ("Where are you going?"== $('#location').val())) }
    
    function clear_location (box) {
        if (is_not_set_location()) box.value = '';
    }
    
    function check_inputs() {
        if (is_not_set_location()) { alert("Please set location"); return false; }
        return true;
    }
</script>