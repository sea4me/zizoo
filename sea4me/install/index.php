<?php
session_start();
error_reporting(0);
require_once("../app/config/config.php");
include "db.php";

if(	$config['hostname'] != '' &&
		$config['db_username'] != '' && 
		$config['db'] != '')
	{
$link = @osc_db_connect(trim($config['hostname']), trim($config['db_username']), trim($config['db_password']));

if (!$link) 
{
   $error = 'Could not connect to the host specified. Error: ' . mysql_error();
}
else
{
	//Connected successfully
	$db_selected = @osc_db_select_db(trim($config['db']));
	
	if (!$db_selected) 
	{
	   $error	= $error . '<BR>Can\'t use the database specified. Error: ' . mysql_error();
	}
	
	//mysql_close($link);
}
//echo $error;exit;
$sql = " SHOW TABLES FROM ".trim($config['db']);

$result = osc_db_query($sql);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

$numtable = osc_db_num_rows($result);

mysql_free_result($result);

if($numtable > 0){
	header("Location: ../");
}

}
$compat_register_globals = true;

if (function_exists('ini_get') && (PHP_VERSION < 4.3) && ((int)ini_get('register_globals') == 0)) {
	$compat_register_globals = false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="css/iefix.css" />
	<![endif]-->
<title>DROPinn - Step1</title>
<link href="css/common.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
<div id="selAtnio">

<div id="header" class="clearfix">
                        <div id="selLeftHeader">
                          <div id="selLogo">
                             <h1><a href="http://products.cogzidel.com/airbnb-clone">productlogo logo</a></h1>
                          </div>
                        </div>
                        
                      </div>
  <div class="Main_block">

                      
                      <div id="selMenu_new">
                           <div class="clsGrayCenter1 clearfix">
                              <div id="selMenuLeft">
                                <h3>DROPinn INSTALLATION STEPS</h3>
                              </div>
                              <div id="selMenuRight">
                                <img src="images/step1.png" alt="image" />
                              
                          </div>
                        </div>
                      </div>
                     
					  <div id="main">
                         <div class="block_tab">
                                          
                                            <div class="clsCommon clearfix">
                                              <h2>System Requirements - Check the following requirements before installation:</h2>
                                              <div class="clsCommonInner clearfix">
                                                <div class="clsCommonLeft">
                                                  <p>Linux Server</p>
                                                </div>
                                                <div class="clsCommonRight">
                                                  <p><span></span></p>
                                                </div>
                                              </div>
                                              <div class="clear"></div>
                                              <div class="clsCommonInner GrayBg clearfix">
                                                <div class="clsCommonLeft">
                                                  <p>Apache Server</p>
                                                </div>
                                                <div class="clsCommonRight">
                                                  <p><span>2.2.4</span></p>
                                                </div>
                                              </div>
                                              <div class="clear"></div>
                                              <div class="clsCommonInner  clearfix">
                                                <div class="clsCommonLeft">
                                                  <p>PHP Version</p>
                                                </div>
                                                <div class="clsCommonRight">
                                                  <p><span>5.2.1</span></p>
                                                </div>
                                              </div>
                                              <div class="clear"></div>
                                              <div class="clsCommonInner GrayBg clearfix">
                                                <div class="clsCommonLeft">
                                                  <p>Mysql version</p>
                                                </div>
                                                <div class="clsCommonRight">
                                                  <p><span>5.0.33</span></p>
                                                </div>
                                              </div>
                                              <div class="clear"></div>
                                              <div class="clsCommonInner  clearfix">
                                                <div class="clsCommonLeft">
                                                  <p>&nbsp;</p>
                                                </div>
                                                <div class="clsCommonRight">
                                                  <p><span>&nbsp;</span></p>
                                                </div>
                                              </div>
                                            </div>
                                          
                                         </div>
                        <div class="block_tab">
                         
                                            <div class="clsCommon clearfix">
                                              <h2>PHP Extensions</h2>
                                              <div class="clsCommonInner clearfix">
                                                <div class="clsCommonLeft">
                                                  <p>MySQL Host Name (usually 'localhost')</p>
                                                </div>
                                                <div class="clsCommonRight">
                                                  <p><span></span></p>
                                                </div>
                                              </div>
                                              <div class="clear"></div>
                                              <div class="clsCommonInner GrayBg clearfix">
                                                <div class="clsCommonLeft">
                                                  <p>MySQL Username</p>
                                                </div>
                                                <div class="clsCommonRight">
                                                  <p><span>2.2.4</span></p>
                                                </div>
                                              </div>
                                              <div class="clear"></div>
                                              <div class="clsCommonInner  clearfix">
                                                <div class="clsCommonLeft">
                                                  <p>MySQL Password </p>
                                                </div>
                                                <div class="clsCommonRight">
                                                  <p><span>5.2.1</span></p>
                                                </div>
                                              </div>
                                              <div class="clear"></div>
                                              <div class="clsCommonInner  clearfix">
                                                <div class="clsCommonLeft">
                                                  <p>&nbsp;</p>
                                                </div>
                                                <div class="clsCommonRight">
                                                  <p><span>&nbsp;</span></p>
                                                </div>
                                              </div>
                                            </div>
                                         
                        </div>
			 <div class="clsSubmit">
			 <p><input type="button" class="clsBluebtn"  value="Continue" onClick="window.location='install.php'" style="cursor:pointer"/></p>
			 </div>
                      </div>

         
</div>
  <div id="Footer">
 <style>
  #Footer a:hover{
  	color:#fff;
	text-decoration:underline;
	}
	</style>

</div>
</body>
</html>