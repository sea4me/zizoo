<div class="CancelReserve_LightBox">
<div class="clsBorder5">
<h1> <?php echo translate("Cancel Reservation"); ?> </h1>
</div>

<p><?php echo translate("Changes to this reservation are governed by the following Standardized policy."); ?></p>

<ul>
<li><?php echo translate("No of nights").' : '.$nights ; ?></li>
<li><?php echo translate("Non-refundable nights").' : '.$non_nights ; ?></li>
<li><?php echo translate("Service fee is not refundable."); ?></li>
</ul>
</ul>

<form id="cancellationHost" name="cancel_host" action="<?php echo site_url('trips/cancel_host'); ?>" method="post">
<p><?php echo translate("Agree the cancellation policy"); ?>
<input style="float:left; margin:0 10px 0 0;" type="checkbox" name="cancel_policy" class="required" />

</p>
<div style="clear:both"></div>
<p><?php echo translate("Type optional message to guest")."..."; ?></p>

<p><textarea name="comment" id="comment" class="required"></textarea></p>

<p>
<input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>" >
<input type="hidden" name="list_id" value="<?php echo $list_id; ?>" >
<input type="submit" class="decline_button Cs3Green_Butt" name="cancel" value="<?php echo translate("Cancel"); ?>" />
</p>
</form>

</div>

<script type="text/javascript">
$(document).ready(function(){
$("#cancellationHost").validate({
   errorElement:"p",
			errorClass:"Frm_Error_Msg",
			focusInvalid: false,
			submitHandler: function(form) 
			{
					var ok=confirm("Are you sure to cancel the reservation?");
					if(!ok)
					{
						return false;
					}
					
					$.post("<?php echo site_url('trips/cancel_host'); ?>", $("#cancellationHost").serialize(),
							function(data)
							{
							
							}
						);
				}
			});
})

</script>