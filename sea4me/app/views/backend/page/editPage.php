<script type="text/javascript" src="<?php echo base_url()?>css/tiny_mce/tiny_mce.js" ></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
</script>
  <div class="clsSettings">
    <div class="clsMainSettings">
      <?php
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}		
	  ?>
	  <?php
	  	//Content of a group
		if(isset($pages) and $pages->num_rows()>0)
		{
			$page = $pages->row();
	  ?>
	 	<h3><?php echo translate_admin('Edit Page'); ?></h3>
			<form method="post" action="<?php echo admin_url('page/editPage')?>/<?php echo $page->id;  ?>">
   <table class="table" cellpadding="2" cellspacing="0">
			
		  <tr>
					<td class="clsName"><?php echo translate_admin('Page Title'); ?><span class="clsRed">*</span></td>
					<td>
					<input class="" type="text" name="page_title" value="<?php echo $page->page_title; ?>">
					</td>
				</tr>
		  <?php echo form_error('page_title'); ?> <br />
				
   <tr>
				<td class="clsName"><?php echo translate_admin('Page Name'); ?><span class="clsRed">*</span></td>
				<td>
					<input class="" type="text" name="page_name" value="<?php echo $page->page_name; ?>">
				</td>
			</tr>
		 <?php echo form_error('page_name'); ?> <br />
      
	  <tr>
				<td class="clsName"><?php echo translate_admin('Page Content'); ?><span class="clsRed">*</span></td>
				<td class="clsNoborder">
				<textarea id="elm1" name="page_content" rows="15" cols="80" style="width: 80%"><?php echo $page->page_content;?></textarea>
				<?php echo form_error('page_content');?>
				</td>
			</tr>
	  
    <tr>
				<td></td>
				<td>
		  <input type="hidden" name="page_operation" value="edit" />
		  <input type="hidden" name="id"  value="<?php echo $page->id; ?>"/>
    <input type="submit" class="clsSubmitBt1" value="<?php echo translate_admin('Submit'); ?>"  name="editPage"/></td>
	  	</tr>  
        
	  </table>
	</form>
	  <?php
	  }
	  ?>
    </div>
  </div>
  <!-- End of clsSettings -->