	<ul class="subnav" id="submenu">
	
			<?php
			if($this->uri->segment(1) == 'hosting' && $this->uri->segment(2) == '')  echo '<li class="active">'; else echo '<li>'; 
			
				echo anchor('hosting',translate("Manage Listings")); 
				
				echo '</li>';
		 ?>

		<?php
			if($this->uri->segment(2) == 'my_reservation') echo '<li class="active">'; else echo '<li>';
			 
				echo anchor('hosting/my_reservation',translate("My Reservations")); 

    echo '</li>';
		 ?>

		<!--<li><a href="<?php echo base_url()?>func/standbys">Standby Guests</a></li>
		<li><a href="<?php echo base_url()?>func/promote">Promote</a></li>-->
		<!--<li><a href="<?php echo base_url().'func/editpricing/'.$this->dx_auth->get_user_id()?>">Pricing</a></li>-->
		<?php	if($this->uri->segment(2) == 'policies') echo '<li class="active">'; else echo '<li>'; 
		
			echo anchor('hosting/policies',translate("Policies")); 
			
			echo '</li>';
		?>
	</ul>