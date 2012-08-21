<!-- Required css stylesheets -->

<link href="<?php echo base_url().'css/views/dashboard_v2.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'css/views/print.css'; ?>" media="print" rel="stylesheet" type="text/css" />

<!-- End of stylesheet inclusion -->
  <?php $this->load->view('includes/dash_header'); ?>
    
  
  <div class="box">
    <div class="top"></div>
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
				<div>
										<div class="clsH1_long_Border"><p><h1><b><?php echo translate("Starred Items"); ?></b></h1></p>	</div>			
						
								<?php if(!empty($starred))
								       {
													
													       if($this->dx_auth->is_logged_in())
																				{
																								$id = $this->dx_auth->get_user_id();
																								if($starred=='true')
																							 $this->db->where('starred',$starred);
																								//$this->db->or_where('user_id',$id);
																								$query = $this->db->get_where('list');
																								if( $query->num_rows > 0 )
																								{
																										 foreach($query->result() as $row)
																											{
																															echo '<li class="listing">
																																								<div class="thumbnail">';
																															
																															echo '<img alt="Host_pic" src="http://www.cogzidel.com/images/host_pic.gif" /></div>';
																															echo '<div class="listing-info"><h3>';
																																										echo anchor('rooms/'.$row->id,$row->title);
																																										echo '</h3>';
																																										echo '<span class="actions">
																																												<span class="action_button">';
																																										echo anchor('func/editListing/'.$row->id,"Edit Listing",array('class' => 'icon edit'));
																																										echo '</span>
																																												<span class="action_button">';
																																										echo anchor('rooms/'.$row->id,"View Listing",array('class' => 'icon view'));
																																										echo '</span>
																																										<span class="action_button">';
																																										echo anchor('func/deletelisting/'.$row->id,"Delete Listing",array('class' => 'icon view'));
																																										echo '</span>
																																										</div>
																																							<div class="clear"></div>
																																						</li>';
																														}
																								}
																				}     		
															} 
															else
															{
										?>					
									<div>
												<?php echo form_open("search",array('id' => 'search_form')); ?>  
												<p><?php echo translate("You have no current trips."); ?> </p><br>
												<input value="Where are you going?" onclick="clear_location(this);" type="text" class="location rounded_left" autocomplete="off" id="location" style="width:250px;float:left; margin-right:10px;" name="location" /></div>
												<input id="submit_location" onclick="if (check_inputs()) {$('#search_form').submit();}return false;" class="v3_button v3_fixed_width search_v3_submit_location" type="button" value="<?php echo translate("Search"); ?>" name="submit_location"> 
											 <?php echo form_close(); ?>
								</div>
								
								<?php } ?>

							</div>	</div>
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
    <div class="bottom"></div>
  </div>
</div>

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