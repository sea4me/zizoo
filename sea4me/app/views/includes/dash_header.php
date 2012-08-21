<div id="command_center">
<ul id="nav">
	<li id="dashboard">
	<?php
	 if($this->uri->segment(2) == 'dashboard')
	 echo anchor('func/dashboard/'.$this->dx_auth->get_user_id(),translate("Dashboard"),array("class" => "Search_Active")); 
		else
		echo anchor('func/dashboard/'.$this->dx_auth->get_user_id(),translate("Dashboard"),array("class" => "")); 
		?>
	</li>
	
		<li id="rooms">
	<?php
	 if($this->uri->segment(1) == 'message'  && $this->uri->segment(2) == 'inbox')
	 echo anchor('message/inbox',translate("Inbox"),array("class" => "Search_Active")); 
		else
		echo anchor('message/inbox',translate("Inbox"),array("class" => "")); 
		?>
	</li>
	
	<li id="rooms">
	<?php
	 if($this->uri->segment(1) == 'hosting' || $this->uri->segment(2) == 'myReservation' || $this->uri->segment(2) == 'policies')
	 echo anchor('hosting',translate("Hosting"),array("class" => "Search_Active")); 
		else
		echo anchor('hosting',translate("Hosting"),array("class" => "")); 
		?>
	</li>
	
	<li id="rooms">
	<?php
	 if($this->uri->segment(1) == 'travelling')
	 echo anchor('travelling/current_trip',translate("Traveling"),array("class" => "Search_Active"));
		else
		echo anchor('travelling/current_trip',translate("Traveling"),array("class" => ""));
		 ?>
	</li>
	
 <li id="rooms">
	<?php
	 if($this->uri->segment(2) == 'account')
	 echo anchor('func/account/'.$this->dx_auth->get_user_id(),translate("Account"),array("class" => "Search_Active"));
		else
		echo anchor('func/account/'.$this->dx_auth->get_user_id(),translate("Account"),array("class" => ""));
		?>
	</li>
	
	<?php if ( !$this->facebook->logged_in() ): ?>
	<li id="rooms">
	<?php
	if($this->uri->segment(2) == 'change_password')
	 echo anchor('auth/change_password/'.$this->dx_auth->get_user_id(),translate("Change Password"),array("class" => "Search_Active")); 
	else
		echo anchor('auth/change_password/'.$this->dx_auth->get_user_id(),translate("Change Password"),array("class" => "")); 
		?>
	</li>
	<?php endif; ?>
	
</ul>