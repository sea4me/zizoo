<!-- Required css stylesheets -->
<script type="text/javascript" src="<?php echo base_url() . 'js/jquery.fancybox-1.3.4.pack.js'; ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'css/jquery.fancybox-1.3.4.css' ?>" media="screen" />

<link href="<?php echo base_url() . 'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

<!-- End of stylesheet inclusion -->
<?php
$this->load->view('includes/dash_header');
$this->load->view('includes/hosting_header');

// Print The Reservation List
$content = '';
$content .= '<p style="padding:5px 5px 5px 725px"><a style="color:#38859B;cursor:pointer;" onClick="javascript:window.print();"><strong>' . translate('Print') . '</strong></a></p>';
$content .= '<table border="1" width="100%">';
$content .= '<tr>';
$content .= '<th>' . translate("Status") . '</th>';
$content .= '<th>' . translate("Dates and Location") . '</th>';
$content .= '<th>' . translate("Guest") . '</th>';
$content .= '<th>' . translate("Details") . '</th>';
$content .= '</tr>';

foreach ($result->result() as $row) {

    $content .= '<tr>';
    $content .= '<td>' . $row->name . '</td>';
    $content .= '<td><p>' . $row->checkin . ' - ' . $row->checkout . '</p><p><strong>' . get_list_by_id($row->list_id)->title . '</strong></p><p><em>' . get_list_by_id($row->list_id)->address . '</em></p></td>';
    $content .= '<td><p><img height="50" width="50" alt="image" style="float:left; margin:0 10px 10px 0;" src="' . $this->Gallery->profilepic($row->userby, 2) . '" />' . ucfirst(get_user_by_id($row->userby)->username) . '</p</td>';
    $content .= '<td>$' . $row->price . '</td>';
    $content .= '</tr>';
}

$content .= '</table>';
?>


<script type="text/javascript">
<?php foreach ($result->result() as $row) { ?>
        $(document).ready(function() {
            $("#cancellation_<?php echo $row->id; ?>").fancybox({	});
        });
<?php } ?>
</script>

<script type="text/javascript">
    function print_reservation() {
        var myWindow;
        myWindow=window.open('','_blank','width=800,height=500');
        myWindow.document.write("<p><?php echo addslashes($content); ?></p>");
        myWindow.print();
    }
</script>

<div class="clsDes_Top_Spac" id="View_MyReserve">
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

            <?php if ($result->num_rows() > 0) { ?>

                <p class="text_right"><span class="View_MyPrint"> <a href="javascript:void(0);" onclick="javascript:print_reservation();"><?php echo translate("Print this page"); ?></a> </span></p>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <th> <?php echo translate("Status"); ?> </th>
                        <th> <?php echo translate("Dates and Location"); ?> </th>
                        <th> <?php echo translate("Guest"); ?> </th>
                        <th> <?php echo translate("Details"); ?> </th>
                    </tr>

                    <?php foreach ($result->result() as $row) { ?>
                        <tr>
                            <td width="15%"> <p class="View_my_Accept_Bg"><span><?php echo $row->name; ?></span></p> </td>
                            <td width="30%">
                                <p> <?php echo $row->checkin . ' - ' . $row->checkout; ?> </p> <br />
                                <p class="clsBold"> <?php echo anchor('rooms/' . $row->list_id, get_list_by_id($row->list_id)->title); ?> </p> 
                                <p> <?php echo get_list_by_id($row->list_id)->address; ?> </p> 
                            </td>
                            <td width="30%">
                                <p> <img height="50" width="50" alt="image" style="float:left; margin:0 10px 10px 0;" src="<?php echo $this->Gallery->profilepic($row->userby, 2); ?>" />
                                    <span class="clsBold"><?php echo ucfirst(get_user_by_id($row->userby)->username); ?></span></p>
                                <span class="clsMyReser_SendMsg"><a href="<?php echo site_url('trips/send_message/' . $row->userby); ?>"><?php echo translate("View") . ' / ' . translate("Send") . ' ' . translate("Message"); ?></a></span>
                            </td>
                            <td width="15%">
                                <p>$<?php echo $row->price; ?></p>
                                <p class="clsBold"><?php echo anchor('trips/request/' . $row->id, translate("View Confirmation")); ?></p>
                                <?php if ($row->status < 8) { ?>
                                    <p class="clsBold"><a id="cancellation_<?php echo $row->id; ?>" href="<?php echo site_url('hosting/cancel_host/' . $row->id . '/' . $row->list_id); ?>"><?php echo translate("Cancel Reservation"); ?></a></p>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
                <div style="clear:both"></div>
            <?php } else { ?>
                <p class="no_listings" style="padding:0px;"><?php echo translate("You have no reservations."); ?>
                    <br>
                    <a class="Link_Green_Bg" style="width:150px; margin:10px 0 0 0" href="<?php echo base_url() ?>home/addlist"><span><?php echo translate("Create a new listing"); ?></span></a>
                </p>
            <?php } ?>
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