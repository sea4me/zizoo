<?php 
error_reporting(1);
error_reporting(E_ALL ^ E_NOTICE);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="Expires" CONTENT="0">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<title>Admin Section</title>
<script type="text/javascript" src="<?php echo base_url() ?>js/common.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/webtoolkit.aim.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/script.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/admin.css" />
</head>
<body>
<!--LAYOUT-->
<!--HEADER-->
<div class="clsContainer">
   <!--HEADER-->
   <div id="header" class="clsClearFixSub">
   <div id="selLeftHeader" class="clsFloatLeft">

     <h1 class="logo"> <a href="<?php echo site_url('backend'); ?>"><?php echo $this->dx_auth->get_site_title(); ?></a></h1>
	 </div>
	  <div id="selRightHeader" class="clsFloatRight">
       <ul id="mainnav">
        <li><a href="<?php echo site_url('backend'); ?>"><?php echo translate_admin("Admin Home"); ?></a></li>
        <li><a href="<?php echo base_url();?>"><?php echo translate_admin("Site Home"); ?></a></li>
        <?php if($this->dx_auth->is_admin()) { ?> 
								<li><a href="<?php echo site_url('home/logout');?>"> <?php  echo translate_admin("Logout"); ?> </a></li> 
								<?php  } ?>
       </ul>
	  </div>
    </div>
				  <!--END OF HEADER-->