<script type="text/javascript">
		function startCallback() {
		document.getElementById('message').innerHTML = '<img src="<?php echo base_url().'images/loading.gif' ?>">';
		// make something useful before submit (onStart)
		return true;
	}

	function completeCallback(response) {
		document.getElementById('message').innerHTML = response;
	}
</script>

<div class="clsSettings">
    <div class="clsMainSettings">
	     <div class="clsNav">
          <ul>
            <li><a href="<?php echo site_url('backend/payment/paymode'); ?>"><b><?php echo translate_admin('View All'); ?></b></a></li>
          </ul>
        </div>
		<div class="clsTitle">
	 <h3><?php echo translate_admin('Edit Host Listing'); ?></h3>
	 </div>
   	 
  <?php 
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}
	 ?>
		
<form action="<?php echo admin_url('payment/paymode'); ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})">	
	 <table class="table" cellpadding="2" cellspacing="0">
				
					<tr>
       <td class="clsName"><?php echo translate_admin('Is Premium?'); ?><span class="clsRed">*</span></td>
							<td>
							<select name="is_premium" class="usertype" id="is_premium" onchange="javascript:showpremium(this.value);">
							<option value="0"> No </option>
							<option value="1"> Yes </option>
							</select> 
							</td>
				</tr>
				
				<?php
				if($result->is_premium == 0)
				{ $show = 'none'; }
				else
				{ $show = 'block'; }
				?>
				
				
				<table class="table" id="showhide" style="display:<?php echo $show; ?>;">
					<tr>
       <td class="clsName"><?php echo translate_admin('Promotion Type'); ?></td>
							<td> <input type="radio" <?php if($result->is_fixed == 1) echo 'checked="checked"'; ?> name="is_fixed" onclick="javacript:showhideF(this.value);" value="1"> Fixed Pay</td>
							<td> <input type="radio" <?php if($result->is_fixed == 0) echo 'checked="checked"'; ?> name="is_fixed" onclick="javacript:showhideF(this.value);" value="0"> Percentage Pay</td>
				</tr>
				
				<?php
				if($result->is_fixed == 1)
				{ $showF = 'block'; $showP = 'none'; }
				else
				{ $showF = 'none'; $showP = 'block'; }
				?>	
				
				<tr id="fixed" style="display:<?php echo $showF; ?>;">
       <td class="clsName"><?php echo translate_admin('Fixed Amount'); ?><span class="clsRed">*</span></td>
							<td> <input type="text" name="fixed_amount" value="<?php echo $result->fixed_amount; ?>"></td>
				</tr>		
				
					<tr id="percentage" style="display:<?php echo $showP; ?>;">
       <td class="clsName"><?php echo translate_admin('Percentage Amount'); ?><span class="clsRed">*</span></td>
							<td> <input type="text" name="percentage_amount" value="<?php echo $result->percentage_amount; ?>"> %</td>
				</tr>			
				</table>
				
				<tr>
						<td></td>
						<td>
						<input type="hidden" name="payId" value="<?php echo $payId; ?>" />
						<div class="clearfix">
						<span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update" value="<?php echo translate_admin('Update'); ?>" style="width:90px;" /></span>
						<span style="float:left; padding:20px 0 0 0;"><div id="message"></div></span>
						</div>
						</td>
				</tr>
		
		</table>	
		<?php echo form_close(); ?>
		
    </div>
  </div>
		
<script language="Javascript">
jQuery("#is_premium").val('<?php echo $result->is_premium; ?>');

function showpremium(id)
{
	if(id == 1)
	{
			 document.getElementById("showhide").style.display = "block";
	}
	else
	{
	   document.getElementById("showhide").style.display = "none";
	}
}

function showhideF(id)
{
	if(id == 1)
	{
	document.getElementById("fixed").style.display      = "block";
	document.getElementById("percentage").style.display = "none";
	}
	else
	{
	document.getElementById("fixed").style.display      = "none";
	document.getElementById("percentage").style.display = "block";	
	}
}
</script>