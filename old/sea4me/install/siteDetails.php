<?php
session_start();

error_reporting(0);

include "db.php";

if (isset($_POST['submit']) && $_POST['submit'] == 'Submit' &&
        trim($_POST['site_title']) != '' &&
        trim($_POST['fb_api_id']) != '' &&
        trim($_POST['fb_api_secret']) != '' &&
        trim($_POST['gmap_api_key']) != '' &&
        trim($_POST['site_admin_mail']) != '' &&
        trim($_POST['admin_name']) != '' &&
        trim($_POST['admin_password']) != '') {

    osc_db_connect($_SESSION['mysql_host'], $_SESSION['mysql_uname'], $_SESSION['mysql_password']);
    osc_db_select_db($_SESSION['mysql_db']);

    $majorsalt = '';
    $password = $_POST['admin_password'];
    // if PHP5
    if (function_exists('str_split')) {
        $_pass = str_split($password);
    }
    // if PHP4
    else {
        $_pass = array();
        if (is_string($password)) {
            for ($i = 0; $i < strlen($password); $i++) {
                array_push($_pass, $password[$i]);
            }
        }
    }
    foreach ($_pass as $_hashpass) {
        $majorsalt .= md5($_hashpass);
    }
    $final_pass = crypt(md5($majorsalt));

    osc_db_query('UPDATE settings set string_value = "' . trim($_POST['site_title']) . '",created = "' . time() . '" WHERE code = "SITE_TITLE"');
    osc_db_query('UPDATE settings set string_value = "' . trim($_POST['fb_api_id']) . '",created = "' . time() . '" WHERE code = "SITE_FB_API_ID"');
    osc_db_query('UPDATE settings set string_value = "' . trim($_POST['fb_api_secret']) . '",created = "' . time() . '" WHERE code = "SITE_FB_API_SECRET"');
    osc_db_query('UPDATE settings set string_value = "' . trim($_POST['gmap_api_key']) . '",created = "' . time() . '" WHERE code = "SITE_GMAP_API_KEY"');
    osc_db_query('UPDATE settings set string_value = "' . trim($_POST['site_admin_mail']) . '",created = "' . time() . '" WHERE code = "SITE_ADMIN_MAIL"');

    srand((double) microtime() * 1000000);
    $coupon_code = rand(10000, 99999);

    osc_db_query('INSERT into users set role_id  = "2", ref_id = "' . md5(trim($_POST['admin_name'])) . '", coupon_code = "' . $coupon_code . '", username 	= "' . trim($_POST['admin_name']) . '", password = "' . $final_pass . '", email = "' . $_POST['site_admin_mail'] . '",	last_ip  = "' . $_SERVER['REMOTE_ADDR'] . '", created  = "' . date('Y-m-d H:i:s') . '"');

    header('Location: complete.php');
} elseif (isset($_POST['submit']) && $_POST['submit'] == 'Submit') {
    $site_title = trim($_POST['site_title']);
    $fb_api_id = trim($_POST['fb_api_id']);
    $fb_api_secret = trim($_POST['fb_api_secret']);
    $gmap_api_key = trim($_POST['gmap_api_key']);
    $site_admin_mail = trim($_POST['site_admin_mail']);
    $admin_name = trim($_POST['admin_name']);
    $admin_password = trim($_POST['admin_password']);

    $error = 'All the fields are required';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <!--[if IE]>
                <link rel="stylesheet" type="text/css" href="css/iefix.css" />
                <![endif]-->
        <title>DROPinn - Step3</title>
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
                            <img src="images/step3.png" alt="image" />

                        </div>
                    </div>
                </div>
                <div id="main">			
                    <div class="block_tab">

                        <form name="settings" method="post" action="">
                            <div class="clsDbServer clearfix">
                                <h2>Site Settings</h2>
                                <?php
                                if (isset($error))
                                    echo '<div id="error" class="error">' . $error . '</div><BR>';
                                ?>
                                <br />
                                <p><label>Site Title:</label></p>
                                <p><input type="text" class="clsTextLarge" name="site_title" value="<?php if (isset($site_title)) echo $site_title; ?>"/><span>*</span></p>

                                <p><label>FB Application ID:</label></p>
                                <p><input type="text" class="clsTextLarge" name="fb_api_id" value="<?php if (isset($fb_api_id)) echo $fb_api_id; ?>"/><span>*</span></p>

                                <p><label>FB Application Secret:</label></p>
                                <p><input type="text" class="clsTextLarge" name="fb_api_secret" value="<?php if (isset($fb_api_secret)) echo $fb_api_secret; ?>"/><span>*</span></p>

                                <p><label>Google Map Key:</label></p>
                                <p><input type="text" class="clsTextLarge" name="gmap_api_key" value="<?php if (isset($gmap_api_key)) echo $gmap_api_key; ?>"/><span>*</span></p>

                                <p><label>Site Admin Email:</label></p>
                                <p><input type="text" class="clsTextLarge" name="site_admin_mail" value="<?php if (isset($site_admin_mail)) echo $site_admin_mail; ?>"/><span>*</span></p>

                                <p><label>Admin Username:</label></p>
                                <p><input type="text" class="clsTextLarge" name="admin_name" value="<?php if (isset($admin_name)) echo $admin_name; ?>"/><span>*</span></p>

                                <p><label>Admin Password:</label></p>
                                <p><input type="text" class="clsTextLarge" name="admin_password" value="<?php if (isset($admin_password)) echo $admin_password; ?>"/><span>*</span></p>


                                <p><span>* Require</span></p>


                            </div>
                            <div class="clsSubmit" style="padding:0 0 15px 0;">
                                <p><input type="submit" class="clsBluebtn"  value="Submit" name="submit"  style="cursor:pointer"/></p>
                            </div>  
                        </form>
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