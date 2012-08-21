<div class="clsSettings">
    <div class="clsMainSettings">
		<div class="clsTitle">
	 <h3><?php echo 'Reservation List'; ?></h3>
	 </div>
<?php echo form_open('backend/payment/finance'); ?>

<?php  				
			//Show Flash Message
			if($msg = $this->session->flashdata('flash_message'))
			{
				echo $msg;
			}
		
		// Show error
		echo validation_errors();
		
				$tmpl = array (
                    'table_open'          => '<table class="table" border="0" cellpadding="4" cellspacing="0">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );

		$this->table->set_template($tmpl); 
		
		$this->table->set_heading('', translate_admin('List ID'), translate_admin('Traveller Name(ID)'), translate_admin('Host Name(ID)'), translate_admin('Check In'), translate_admin('Check Out'), translate_admin('Price'));
		
		if(count($result) > 0)
		{

		foreach ($result as $row) 
		{
		$query          = $this->users->get_user_by_id($row->userby);
		$booker_name    = $query->row()->username;
		
			$query1        = $this->users->get_user_by_id($row->userto);
	 	$hotelier_name = $query1->row()->username;
  	$hotelier_id   = $query1->row()->id;
			
			$this->table->add_row(
				form_checkbox('check[]', $row->id),
				$row->list_id,
				$booker_name.'('.$row->userby.')', 
				$hotelier_name.'('.$hotelier_id.')', 
				$row->checkin, 			
				$row->checkout,
				$row->price
				);
		}
		}
		else
		{
		$this->table->add_row(
		'',
		translate_admin('There is no reservation yet !'),
		''
		);
		
		}
		
		//echo form_open($this->uri->uri_string());
		/*echo '<div class="clsUser_Buttons"><ul class="clearfix"><li>';			
		echo form_submit('delete', 'Delete List');
		echo '</li><li>';
		echo form_submit('edit', 'Edit List');
		echo '</li></ul></div>';*/
		
		
		echo $this->table->generate(); 
		
		echo form_close();
		
		echo $pagination;
			
	?>
	</div>
	</div>