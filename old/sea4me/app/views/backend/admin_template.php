<?php $this->load->view('backend/includes/header'); ?>

<?php

echo '<div id="wrapper"><div id="content">';
if ($this->dx_auth->is_admin()):
    $this->load->view('backend/includes/sidebar');
endif;
echo '<div id="main">';
$this->load->view($message_element);
echo '</div></div></div>';
?>

<?php

$this->load->view('backend/includes/footer.php');
?>