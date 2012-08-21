<script src="<?php echo base_url(); ?>js/jquery.countdown.js" type="text/javascript"></script>
<?php
// Print The Confrmation

$confirmation = '';
$confirmation .= '<p style="padding:5px 5px 5px 725px"><a style="color:#38859B;cursor:pointer;" onClick="javascript:window.print();"><strong>'.translate('Print').'</strong></a></p>';
$confirmation .= '<table border="1" width="100%">';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Property").'</td>';
$confirmation .= '<td>'.get_list_by_id($result->list_id)->title.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Check in").'</td>';
$confirmation .= '<td>'.$result->checkin.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Check out").'</td>';
$confirmation .= '<td>'.$result->checkout.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Nights").'</td>';
$confirmation .= '<td>'.$nights.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Guests").'</td>';
$confirmation .= '<td>'.$no_quest.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Cancellation").'</td>';
$confirmation .= '<td>'.$nights.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Rate").'( '. translate("per night") .' )'.'</td>';
$confirmation .= '<td>'.$per_night.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Subtotal").'</td>';
$confirmation .= '<td>'.$subtotal.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Host fee").'</td>';
$confirmation .= '<td>'.$commission.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Total Payout").'</td>';
$confirmation .= '<td>'.$total_payout.'</tr>';
$confirmation .= '</tr>';

$confirmation .= '<tr>';
$confirmation .= '<td>'.translate("Status").'</td>';
$confirmation .= '<td>'.translate($result->name).'</tr>';
$confirmation .= '</tr>';

$confirmation .= '</table>';

?>

	<script type="text/javascript">
	function print_confirmation() {
		var myWindow;
		myWindow=window.open('','_blank','width=800,height=500');
		myWindow.document.write("<p><?php echo addslashes($confirmation); ?></p>");
		myWindow.print();
	}
</script>

<div id="Single_Reservr_Blk" class="clearfix">
<div style="overflow:hidden;" id="left">
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
          <div class="middle">
            <div class="clsSide_border_Samll">
              <h2>
                <?php echo translate("Quick Links");?>
              </h2>
            </div>
            <ul>
              <li><a href=<?php echo base_url().'func/hosting'; ?>>
                <?php echo translate("View/Edit Listings");?>
                </a></li>
              <li><a href=<?php echo base_url().'func/reserve'; ?>>
                <?php echo translate("Reservations");?>
                </a></li>
            </ul>
          </div>
          <div style="clear:both"></div>
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
<div id="main_reserve">
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
								<div class="clsBorder5">
		<h1><?php echo translate("Reservation Request"); ?> </h1></div>
		<?php if($result->status != 1) { ?>
		<p class="text_right">
		<span class="View_MyPrint">
	 <a href="javascript:void(0);" onclick="javascript:print_confirmation();"><?php echo translate("Print Confirmation");  ?></a>
		</span>
		</p>
		<?php } ?>
<ul id="details_breakdown_1" class="dashed_table_1 clearfix">
<li class="top clearfix">
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Property"); ?></span></span>
<span class="data"><span class="inner"><?php echo get_list_by_id($result->list_id)->title; ?></span></span>
</li>

<li class="clearfix">
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Check in"); ?></span></span>
<span class="data"><span class="inner"><?php echo $result->checkin; ?></span></span>
</li>

<li class="clearfix">
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Check out"); ?></span></span>
<span class="data"><span class="inner"><?php echo $result->checkout; ?></span></span>
</li>

<li class="clearfix">
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Nights"); ?></span></span>
<span class="data"><span class="inner"><?php echo $nights; ?></span></span>
</li>

<li class="clearfix">
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Guests"); ?></span></span>
<span class="data"><span class="inner"><?php echo $no_quest; ?></span></span>
</li>

<li class="bottom">
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Cancellation"); ?></span></span>
<span class="data"><span class="inner"><?php echo $nights; ?></span></span>
</li>
</ul>


<ul id="details_breakdown_1" class="dashed_table_1 clearfix">

<li class="top clearfix">
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Rate").'( '. translate("per night") .' )'; ?></span></span>
<span class="data"><span class="inner">$<?php echo $per_night; ?></span></span>
</li>

<li class="clearfix">
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Subtotal"); ?></span></span>
<span class="data"><span class="inner">$<?php echo $subtotal; ?></span></span>
</li>

<li class="clearfix">
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Host fee"); ?></span></span>
<span class="data"><span class="inner">$<?php echo $commission; ?></span></span>
</li>

<li class="clearfix">
<span class="label"><span class="inner"><span class="checkout_icon" id="icon_cal"></span><?php echo translate("Total Payout"); ?></span></span>
<span class="data"><span class="inner">$<?php echo $total_payout; ?></span></span>
</li>

<li class="clearfix bottom">
<span class="label" style="text-align:center;"><span class="inner"><span class="checkout_icon" id="icon_cal"></span>
<?php if($result->status == 1) { ?>
<?php echo translate("Expires in"); ?>
<?php
$timestamp = strtotime($result->book_date);
$date = date("D, d M Y H:i:s",strtotime('+1 day',$timestamp));
?>
<div id="expire" style="font-size:20px;"></div>
<?php } else { ?>
<?php echo translate("Status"); ?>
<?php } ?>
</span></span>

<?php if($result->status == 1) { ?>

<span class="data" style="padding: 10px 10px 34px;"><span class="inner">
<input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $result->id; ?>" />
<a class="Reserve_Accept" id="req_accept" href="javascript:show_hide(1);"><?php echo translate("Accept"); ?></a>
<a class="Reserve_Decline" id="req_decline" href="javascript:show_hide(2);"><?php echo translate("Decline"); ?></a>
<div id="accept" style="display:none">
<form name="accept_req" action="<?php echo site_url('trips/accept'); ?>" method="post">
<p>
<input type="checkbox" id="block_date" name="block_date" />
<?php echo translate("Block my calendar from")." ".$result->checkin." ".translate("through")." ".$result->checkout; ?>
</p>

<p><?php echo translate("Type optional message to guest")."..."; ?></p>

<p><textarea name="comment" id="comment"></textarea></p>

<p><input type="button" class="accept_button" name="accepted" value="<?php echo translate("Accept"); ?>" onclick="javascript:req_action('accept');" /></p>
</form>
</div>
<div id="decline" style="display:none">
<form name="decline_req" action="<?php echo site_url('trips/decline'); ?>" method="post">
<p>
<input type="checkbox" name="block_date2" />
<?php echo translate("Block my calendar from")." ".$result->checkin." ".translate("through")." ".$result->checkout; ?>
</p>
<p><?php echo translate("Type optional message to guest")."..."; ?></p>

<p><textarea name="comment" id="comment2"></textarea></p>

<p><input type="button" class="decline_button" name="decliend" value="<?php echo translate("Decline"); ?>" onclick="javascript:req_action('decline');" /></p>
</form>
</div>
</span>


</span>
<?php } else { ?>

<span class="data" style="padding: 10px 10px 34px;"><span class="inner">
<?php 
echo translate($result->name);
?>
</span></span>

<?php } ?>
</li>
</ul>
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
        </div>
								</div>
								<div style="clear:both"></div>
								</div>
							
<script type="text/javascript">

<?php if($result->status == 1) { ?>	

$('#expire').countdown({
		until: new Date("<?php echo $date; ?>"),
		format: 'dHMS',
		layout:'{hn}:'+'{mn}:'+'{sn}',
		/*onExpiry: liftOff,*/
		expiryText:"Expired"
	});
	
	
function liftOff()
{ 
  var reservation_id = $("#reservation_id").val();
	
   	 $.ajax({
				 type: "POST",
					url: "<?php echo site_url('trips/expire'); ?>",
					async: true,
					data: "reservation_id="+reservation_id,
					success: function(data)
		  	{	
						location.reload(true);
			 	}
		  });			
}

<?php } ?>

function show_hide(id)
{
		if(id == 1)
		{
		document.getElementById('req_accept').className  = 'Reserve_click';
		document.getElementById('req_decline').className = 'Reserve_Decline';
		 $('#decline').hide();
		 $('#accept').show();
		}
		else
		{
		document.getElementById('req_accept').className  = 'Reserve_Accept';
		document.getElementById('req_decline').className = 'Reserve_click';
		 $('#decline').show();
		 $('#accept').hide();
		}	
}


function req_action(id)
{
 var reservation_id = $("#reservation_id").val();
	 
 if(id == "accept")
	{
 var is_block = $("#block_date").val();
	var comment  = $("#comment").val();
	}
	else
	{
 var is_block = $("#block_date2").val();
	var comment  = $("#comment2").val();
	}
	
	var ok=confirm("Are you sure to "+id+" request?");
		if(!ok)
		{
			return false;
		}
		
		document.getElementById(id).innerHTML = '<img src="<?php echo base_url().'images/loading.gif' ?>">';
		
	   $.ajax({
				 type: "POST",
					url: "<?php echo site_url('trips'); ?>/"+id,
					async: true,
					data: "is_block="+is_block+"&comment="+comment+"&reservation_id="+reservation_id,
					success: function(data)
		  	{	
					 document.getElementById(id).innerHTML = data;
			 	}
		  });
}

</script>