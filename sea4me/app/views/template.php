<?php $this->load->view('includes/header'); ?>

<?php
	echo '<div id ="main_content">';
	$this->load->view($message_element);
	echo '</div>';
?>
	

	
<?php 
	$this->load->view('includes/footer.php');
?>