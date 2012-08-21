<div class="CancelReserve_LightBox">
<div class="clsBorder5">
<h1> <?php echo translate("Checkin"); ?> </h1>
</div>
<form id="checkin" name="checkin-trips" action="<?php echo site_url('travelling/checkin'); ?>" method="post">
<p> <?php echo translate("Are you sure to checkin?"); ?> </p>
<p> 
<input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>" >
<input type="submit" class="decline_button Cs3Green_Butt" name="checkin" value="<?php echo translate("Checkin"); ?>" /> 
</p>

</div>