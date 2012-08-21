	<?php  	
				//Show Flash Message
			if($msg = $this->session->flashdata('flash_message'))
			{
				echo $msg;
			}
						
		// Show reset password message if exist
		if (isset($reset_message))
			echo $reset_message;
		
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
		
		$this->table->set_heading('', translate_admin('Username'), translate_admin('Email'), translate_admin('Role'), translate_admin('Banned'), translate_admin('Last IP'), translate_admin('Last login'), translate_admin('Created'));
		
		foreach ($users as $user) 
		{
			$banned = ($user->banned == 1) ? 'Yes' : 'No';
			
			$this->table->add_row(
				form_checkbox('checkbox_'.$user->id, $user->id),
				$user->username, 
				$user->email, 
				$user->role_name, 			
				$banned, 
				$user->last_ip,
				date('Y-m-d', strtotime($user->last_login)), 
				date('Y-m-d', strtotime($user->created)));
		}
		
		echo form_open($this->uri->uri_string());
		
		echo '<div class="clsUser_Buttons"><ul class="clearfix"><li>';		
		echo form_submit('ban', translate_admin('Ban user'));
		echo '</li><li>';
		echo form_submit('unban', translate_admin('Unban user'));
		echo '</li><li>';
		echo form_submit('reset_pass', translate_admin('Reset password'));
		echo '</li></ul></div>';
		
		
		
		echo $this->table->generate(); 
		
		echo form_close();
		
		echo $pagination;
			
	?>