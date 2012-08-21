<!-- Required css stylesheets -->

<link href="<?php echo base_url().'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

  <?php $this->load->view('includes/dash_header'); ?>
    <div class="box">
    <div class="top"></div>
     <ul class="subnav">
					<li><a href="<?php echo base_url();?>func/account"></a><?php echo translate("Notification"); ?></li>
					<li class="active"><a href="<?php echo base_url();?>func/payout"><?php echo translate("Payout Preferences"); ?></a></li>
					<li><a href="<?php echo base_url();?>func/transaction"><?php echo translate("Transaction History"); ?></a></li>
					<li><a href="<?php echo base_url();?>func/recommendation"><?php echo translate("Get Recommendations"); ?></a></li>
					<li><a href="<?php echo base_url();?>func/reviews"><?php echo translate("Reviews & Recommendations"); ?></a></li>
					<li><a href="<?php echo base_url();?>func/referrals"><?php echo translate("Referrals"); ?></a></li>
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
			<h1><?php echo translate("Payout Method"); ?></h1></div>
       <br>
      
      <?php 
			     $this->db->select();
				 $query=$this->db->get('payout_preferences');
				 $result=$query->result();
  			if(!empty($result))
				{
				?>
               <table id="payout_methods" border="1" cellpadding="5" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                      <th class="name"><?php echo translate("Status"); ?></th>
                      <th class="rank"><?php echo translate("Method"); ?></th>
                      <th class="rank"><?php echo translate("Details"); ?></th>
                    </tr>
     <?php 
				   foreach($result as $row)
				   {
		  	?>
                <tr>
                   <?php if(!empty($row->default_email)){?>
                   <td style="width:130px;"> <?php echo translate("Verified"); ?><b><?php echo ' ('.$row->default_email.')'; ?></b></td>
                  <?php }else{?>
                  <td style="width:130px;"> <?php echo translate("Verified"); ?><b><?php echo $row->default_email; ?></b></td>
                  <?php }?>
                   <td style="width:100px;"><?php echo $row->payout_type;?></td>
                   <td><?php echo $row->email.'('.$row->currency.')'?></td>
               </tr>
            <?php
            	}
			 }	
			?>
               </tbody>
       </table>
       <br>
        <div style="" id="payout_new_select">
            <div><?php echo translate("We can send money to users in"); ?> <b><?php echo $country;?></b> <?php echo translate("as follows:"); ?></div><br>
            <table id="payout_method_descriptions" border="1" cellpadding="5" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <th style="width:150px;"><?php echo translate("Method"); ?></th>
                        <th style="width:125px;"><?php echo translate("Arrives On*"); ?></th>
                        <th style="width:100px;"><?php echo translate("Fees"); ?></th>
                        <th style="width:100px;"><?php echo translate("Currency"); ?></th>
                        <th style="width:275px;"><?php echo translate("Notes"); ?></th>
                     </tr>
                      
                     <tr>
                        <td class="type"><?php echo translate("PayPal"); ?></td>
                        <td><?php echo translate("Instant"); ?></td>
                        <td style="color:#FFFFFF"><?php echo translate("None"); ?></td>
                        <td>USD</td>
                        <td>&nbsp; </td>
                     </tr>
                      
                    <tr>
                        <td class="type"><?php echo translate("International Wire"); ?></td>
                        <td><?php echo translate("3-5 business days"); ?></td>
                        <td><?php echo translate("None"); ?></td>
                        <td>USD</td>
                        <td><?php echo translate("Your bank will likely charge a fee to receive the wire."); ?></td>
                    </tr>
                </tbody>
            </table>
            <div style="font-size:10px;">* <?php echo translate("Money is always released the day after check in but may take longer to arrive to you."); ?></div>
            <br>
            <form  method="post" action="<?php echo base_url().'func/paypalInfo'?>">
            <input type="hidden" value="<?php echo $country;?>" name="country">
            
            <?php echo translate("What method would you prefer?"); ?> 
												<select name="payout_type" id="payout_info_type"><option value="PayPal">PayPal</option>
                 <option value="Bank Transfer">Bank Transfer</option>
												</select>
                <input type="submit" class="v3_button" value="<?php echo translate("Next"); ?>" name="commit">
                or
                <a href="<?php echo base_url().'func/payout'?>"><?php echo translate("Cancel"); ?></a>
            </form></div>
     </div></div>
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

<script>
		$("#method").hide();
        $("#change").hide();
		$("#in").hide();
        $("#add_payment").click(function ( event ) {
          event.preventDefault();
		  $("#method").show("slow");
		  $("#change").hide("slow");
        });
		$("#change_default").click(function ( event ) {
          event.preventDefault();
		   $("#change").show("slow");
		   $("#method").hide("slow");
        });
		 	 
</script>