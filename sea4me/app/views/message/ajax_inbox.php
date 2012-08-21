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

if($row->is_read == 0) echo '<strong>'; echo anchor(''.$row->url.'/'.$message_id, $row->message, array("onclick" => "javascript:is_read(".$row->id.")"); if($row->is_read == 0) echo '</strong>'; ?>
<br>
<span><?php echo substr(get_list_by_id($row->list_id)->title,0,10) ?></span>
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
<p class="clearfix"><span><a class="<?php echo $class; ?>" id="starred_<?php echo $row->id; ?>" href="javascript:void(0);" onclick="javascript:starred('<?php echo $row->id; ?>');"></a></span><span><a onclick="javascript:deleted('<?php echo $row->id; ?>');" href="javascript:void(0);" id="delete_<?php echo $row->id; ?>">Delete</a></span></p>
</div>
</li>

<?php } } else { ?>

<li class="clearfix">
<?php echo translate("Nothing to show you."); ?>
</li> 

<?php } ?>