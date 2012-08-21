<!--  Required external style sheets -->

<link href="<?php echo base_url().'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/silver.css'; ?>" media="screen" rel="stylesheet" type="text/css" />



<!-- End of style sheet inclusion -->



    
<link href="<?php echo base_url().'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />
<?php $this->load->view('includes/dash_header'); ?>

<?php if(0): ?>
	<h1><?php translate("Sorry you are not authorised to view this page",$this->session->userdata('lang'));?></h1>
<?php else: ?> 

	<?php $query = $this->db->get_where('users' , array('id' => $this->uri->segment(3)));
		$q = array();	
		$q = $query->result();
	?>

    <div id="dashboard" class="clsDes_Top_Spac">
        <div id="left" style="overflow:hidden;">
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
            <div id="user_box" class="box">

                <div class="top">&nbsp;</div>
                <div class="middle">

                    <div id="user_pic" onclick="show_ajax_image_box();">
                            <img alt="" height="209" src="<?php echo base_url().'css/views/web-user.jpg'; ?>" title="Cogzidel Clone User" width="209" />
                    </div>
             
                </div><!-- middle -->
                <div class="bottom">&nbsp;</div>
            </div><!-- /user -->
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
                <div id="quick_links" class="box">
                    <div class="top">&nbsp;</div>
                    <div class="middle">
                        <h2><?php echo translate("Quick Links"); ?></h2>
                        <ul>

                                <li><a href=<?php echo base_url().'func/hosting'; ?>><?php echo translate("View/Edit Listings");?></a></li>
                                <li><a href=<?php echo base_url().'func/reserve'; ?>><?php echo translate("Reservations");?></a></li>
                                
                        </ul>

                    </div>
                    <div class="bottom">&nbsp;</div>
                    <div style="clear:both"></div>
                </div>
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


        </div><!-- /left -->

        <div id="main" style="float:right;width:698px;">
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
                <div id="system_alert" class="box" >
                    <div class="top">&nbsp;</div>
                    <div class="middle">
					<?php  
							echo $output;
					?>
					
					
				
                    </div>
                    <div class="bottom">&nbsp;</div>
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


        </div><!-- /main -->
            <div class="clear"></div>
    </div><!-- /dashboard -->
<!-- /command_center -->


<?php endif; ?>
<script type="text/javascript">
jQuery("#user_pic").hover(
    function(){jQuery('#edit_image_hover').fadeIn(100);},
    function(){jQuery('#edit_image_hover').fadeOut(100);}
);

</script>

            <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 1049231994;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "666666";
            var google_conversion_label = "0W9CCND30wEQ-oSo9AM";
            var google_conversion_value = 0;
            /* ]]> */
            </script>

            <script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
            </script>
            <noscript>
            <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1049231994/?label=0W9CCND30wEQ-oSo9AM&amp;guid=ON&amp;script=0"/>
            </div>
            </noscript>