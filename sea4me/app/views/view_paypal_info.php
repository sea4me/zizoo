<!-- Required css stylesheets -->

<link href="<?php echo base_url().'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

<!-- End of stylesheet inclusion -->
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
      <!--Display Payout Details-->
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
       <br><br>
      <!--Desplay Payout Details-->
      
        <div style="" id="payout_edit">
			<style>
              #paypal_payout table td { padding:3px; }
            </style>
                <div id="paypal_payout">
                    <div class="clsH1_long_Border">
			<h1>PayPal Information</h1></div>
                   
                <form method="post" action="<?php echo base_url().'func/payout'?>">        
                <input type="hidden" value="<?php echo $country?>" name="country" id="country">
                <input type="hidden" value="<?php echo $payout_type?>" name="payout_type" id="email">
                
                        <table>
                          <tbody><tr>
                            <td>To what e-mail should we send the money?</td>
                            <td>
                              <input type="text" value="" size="30" name="email" id="email"><br>
                              <span style="font-size:0.85em;color:#8b8b8b;">This email address must be associated with a valid Paypal account.</span><br>
                              <a target="_blank" style="font-size:0.85em;" href="https://www.paypal.com/cgi-bin/webscr?cmd=_registration-run">Don't have a paypal account?</a>
                            </td>
                          </tr>
                          <tr>
                            <td>In what currency would you like to be paid?</td>
                            <td><select name="currency" id="currency"><option selected="selected" value="USD">USD</option></select></td>
                            </tr>
                        </tbody></table>
                        <br>
                        <input type="submit" value="<?php echo translate("Save"); ?>" class="v3_button" onclick="return verify_entry_function();" name="commit">
                        or <a  href="<?php echo base_url().'func/payout'?>"><?php echo translate("Cancel"); ?></a>
                </form>
                </div>
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
		 
		 $('#next').click(
			function(event)
			{
				$("#payout_country_select").hide("slow");
			    $("#in").show("slow");
			}
		 );
		 
		 $('#cancel').click(
			function(event)
			{
			   
			
				
			}
		 );
		 
		
</script>