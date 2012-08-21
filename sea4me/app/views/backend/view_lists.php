<?php echo form_open('backend/backend/managelist'); ?>

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
		
		$this->table->set_heading('', translate_admin('LIST ID'), translate_admin('USER NAME'), translate_admin('ADDRESS'), translate_admin('TITLE'), translate_admin('DESCRIPTION'), translate_admin('CAPACITY'), translate_admin('PRICE'));
		
		foreach ($users as $user) 
		{
		if(isset($user->user_id))
		{
				$query = $this->users->get_user_by_id($user->user_id);
									// Get user record
				$user_name = $query->row()->username;
				
					$this->table->add_row(
						form_checkbox('check[]', $user->id),
						$user->id, 
						$user_name, 
						$user->address, 			
						$user->title, 
						substr($user->desc, 0, 100).'...',
						$user->capacity, 
						$user->price);
			}
		}
		
		echo '<div class="clsUser_Buttons"><ul class="clearfix"><li>';			
		echo form_submit('delete', translate_admin('Delete List'));
		echo '</li><li>';
		echo form_submit('edit', translate_admin('Edit List'));
		echo '</li></ul></div>';
		
		
		echo $this->table->generate(); 
		
		echo form_close();
		
		echo $pagination;
			
	?>