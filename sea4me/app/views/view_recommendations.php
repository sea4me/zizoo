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
					<li><a href="<?php echo base_url();?>func/payout"><?php echo translate("Payout Preferences"); ?></a></li>
					<li><a href="<?php echo base_url();?>func/transaction"><?php echo translate("Transaction History"); ?></a></li>
					<li class="active"><a href="<?php echo base_url();?>func/recommendation"><?php echo translate("Get Recommendations"); ?></a></li>
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
         <div class="clsH1_long_Border"><h1><?php echo translate("Share This URL"); ?></h1></div>
                <div>
                <?php echo form_open("func/recommendation",'id="form"')?>
                <input type="text" name="share_url" value="<?php echo base_url().'func/vouch?id='.$this->dx_auth->get_user_id();?>" size="140">
                </div><br>
                <div style="clear:both">
																<?php echo translate("Share this Personal Recommendation URL with your friends so they can leave you recommendations."); ?>
                <a href="#"><?php echo translate("Help!"); ?></a>
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
        </div>      </div>
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
         <div class="clsH1_long_Border"><h1><?php echo translate("Email your friends"); ?></h1></div>
          <p style="width:360px;"><?php echo translate("Enter up to 10 email addresses, separated by commas. We will send an individual email that includes your"); ?> <span style="font-weight:bold;"><?php echo translate("Personal Recommendation URL"); ?></span> <?php echo translate("to each person."); ?></p>
          <br>
          <textarea name="emal_to_friend" value="" cols="40" ></textarea>
    		 
			       
   
         
          <p style="margin:10px 0 0 0;">
          <input type="submit" value="<?php echo translate("Invite these people"); ?>" name="commit" class="big_blue_button big_green_butt individual_address_submit_button">
          </p>
			  
			  <?php  ?>
          
          </div> </div>
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

