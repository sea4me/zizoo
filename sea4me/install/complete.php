<?php
session_start();

error_reporting(0);

if ($_SESSION['baseurl'] == '')
    $url = '../../';
else
    $url = $_SESSION['baseurl'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <!--[if IE]>
                <link rel="stylesheet" type="text/css" href="css/iefix.css" />
                <![endif]-->
        <title>DROPinn - Step4</title>
        <link rel="stylesheet" type="text/css" href="css/common.css" />
    </head>

    <body>
        <div id="selAtnio">
            <div id="header" class="clearfix">
                <div id="selLeftHeader">
                    <div id="selLogo">
                        <h1><a href="http://products.cogzidel.com/airbnb-clone">product logo</a></h1>
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
                            <img src="images/step4.png" alt="image" />

                        </div>
                    </div>
                </div>
                <div id="main">

                    <div class="block_tab">

                        <div class="clsDbServer clearfix">
                            <h2>Installation is Completed Successfully.</h2>
                            <br />
                            <p>Congratulations!! You have successfully installed DROPinn script on your server!</p>
                            <p>Please choose appropriate action:</p>
                            <p>Good Luck!</p>
                        </div>


                    </div>
                    <div class="clsSubmit">
                        <p><input type="button" class="clsBluebtn" name="home"  value="Site Home" onClick="window.location='<?php echo $url; ?>'"  style="cursor:pointer"/><input type="button" name="home" class="clsBluebtn"  value="Site Admin" onClick="window.location='<?php echo $url; ?>backend'"  style="cursor:pointer"/></p>
                    </div>
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