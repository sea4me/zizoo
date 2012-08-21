<link href="<?php echo base_url().'css/views/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<?php $this->load->view('includes/dash_header'); ?>
<div class="clsDes_Top_Spac">
<div class="clsDisign_Box">
  <div class="clsTop_Pannel">
    <div class="clsTop_Left">
      <div class="clsTop_Right">
        <div class="clsTop_Mid"> </div>
      </div>
    </div>
  </div>
  <div class="CenterPannel">
    <div class="clsH1_long_Border">
      <h1><?php echo translate("Inbox"); ?></h1>
      <div id="Msg_Inbox_Big">
						<div id="message"></div>
            <ul id="messages_list">
																<?php
																 if($messages->num_rows() > 0) 
																 {
																		foreach($messages->result() as $row) { //print_r($row); ?>	
																		
																		 	<li class="clearfix">
                    	<div class="clsMsg_User clsFloatLeft">
                        	<a href="#"><img height="50" width="50" alt="" src="<?php echo $this->Gallery->profilepic($row->userby,2); ?>" /></a>
                            <p><a href="#"><?php echo get_user_by_id($row->userby)->username; ?></a> <br />
                            <!--31 minutes--></p>
                        </div>
                        <div class="clsMeg_Detail clsFloatLeft">
                            <p>
                                <?php
																																 if($row->conversation_id != 0) $message_id = $row->conversation_id; else $message_id = $row->reservation_id;
																																	
																																 if($row->is_read == 0) echo '<strong>'; echo anchor(''.$row->url.'/'.$message_id, $row->message, array("onclick" => "javascript:is_read(".$row->id.")")); if($row->is_read == 0) echo '</strong>'; ?>
                                <br>
                                <span><?php echo substr(get_list_by_id($row->list_id)->title,0,10); ?></span>
                                <span>(<?php echo $row->checkin.' - '.$row->checkout; ?>)</span>
                            </p>
                        </div>
                        <div class="clsMeg_Off clsFloatLeft">
                              <p>
                              	<span><?php echo $row->name; ?></span>
                                <br>
                                <span>$<?php echo $row->price; ?></span>
                              </p>
                        </div>
																								
																								<div class="clsMsg_Del clsFloatLeft">
																								<?php if($row->is_starred == 0) $class = "clsMsgDel_Unfil"; else $class = "clsMsgDel_fil"; ?>
                    	     <p class="clearfix">
																										<span><a class="<?php echo $class; ?>" id="starred_<?php echo $row->id; ?>" href="javascript:void(0);" onclick="javascript:starred('<?php echo $row->id; ?>');"></a></span>
																										<span><a onclick="javascript:deleted('<?php echo $row->id; ?>');" href="javascript:void(0);" id="delete_<?php echo $row->id; ?>"><?php echo translate("Delete"); ?></a></span>
																										</p>
                        </div>
                    </li>
																		
															<?php } } else { ?>
															
																		<li class="clearfix">
																					<?php echo translate("Nothing to show you."); ?>
																		</li> 
																					
															<?php } ?>
																
            </ul>
            
            <div style="clear:both"></div>
       </div>
    </div>
  </div>
  <div class="BottomPannel">
    <div class="clsBottom_Left">
      <div class="clsBottom_Right">
        <div class="clsBottom_Mid"> </div>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">

function starred(id)
{

var className = $('#starred_'+id).attr('class');

	if(className == 'clsMsgDel_Unfil')
	{
	$("#starred_"+id).removeClass("clsMsgDel_fil").addClass("clsMsgDel_fil");
	var to_change = 1;
	}
	else
	{
	$("#starred_"+id).removeClass("clsMsgDel_fil").addClass("clsMsgDel_Unfil");
	var to_change = 0;
	}
	
	$.ajax({
				 type: "POST",
					url: "<?php echo site_url('message/starred'); ?>",
					async: true,
					data: "message_id="+id+"&to_change="+to_change,
					success: function(data)
		  	{	
					$("#message").html(data);
					$("#message").show();
					$("#message").delay(1000).fadeOut('slow');
			 	}
		  });
}

function deleted(id)
{
  var ok=confirm("Are you sure to delete the message?");
		if(!ok)
		{
			return false;
		}
	$.ajax({
				 type: "POST",
					url: "<?php echo site_url('message/delete'); ?>",
					async: true,
					data: "message_id="+id,
					success: function(data)
		  	{	
					$("#message").html("Message deleted successfully.");
					$("#message").show();
					$("#message").delay(1000).fadeOut('slow');
					
					$("#messages_list").html(data);
			 	}
		  });
}

function is_read(id)
{
	$.ajax({
				 type: "POST",
					url: "<?php echo site_url('message/is_read'); ?>",
					async: true,
					data: "message_id="+id
		  });
}

</script>