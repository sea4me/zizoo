<?php 
  echo form_open('backend/payment/manage_gateway');
			
			//Show Flash Message
			
			if($msg = $this->session->flashdata('flash_message'))
			{
				echo $msg;
			}
		
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
		
		$this->table->set_heading('', translate_admin('Payment Name'), translate_admin('Is Install?'), translate_admin('Is Active?'));
		
		$notification = '';
		
		if($payments->num_rows() > 0)
		{
				foreach ($payments->result() as $row) 
				{
					if($row->is_installed == 1)
					{
							$is_install = 'Yes';
					}
					else
					{
							$is_install = 'No';
					}
					
					if($row->is_active == 1)
					{ 
					  $change_to  = translate_admin('Click to deactive');
							$isActive   = 'Yes';
					}
					else
					{
					  $change_to  = translate_admin('Click to active');
							$isActive   = 'No';
					}
					
					$change = '<a href="'.admin_url('payment/manage_gateway/'.$row->id).'"><img src="'.base_url().'images/change.jpg" title="'.$change_to.'" alt="'.$change_to.'" /></a>';
					
					$this->table->add_row(
						form_checkbox('check[]', $row->id),
						$row->payment_name, 
						$is_install, 
						$isActive.'&nbsp;&nbsp;&nbsp;'.$change
						);
				}
		}
		else
		{
		  $notification = '<p> '.translate_admin('There is no payment list.') .' '.anchor('backend/payment',translate_admin('Click here')).' '.translate_admin('to add the first payment').'</p>';
		}
		
		//echo form_open($this->uri->uri_string());
		echo '<div class="clsUser_Buttons"><ul class="clearfix"><li>';			
		echo form_submit('delete', translate_admin('Delete Payment'));
		echo '</li><li>';
		echo form_submit('edit', translate_admin('Edit Payment'));
		echo '</li></ul></div>';
		
		
		echo $this->table->generate(); 
		
		echo $notification;
		
		echo form_close();
	?>