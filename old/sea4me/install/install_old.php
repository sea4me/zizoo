<?php
session_start();

error_reporting(0);

include "db.php";

$baseURL = 'http://' . $_SERVER['SERVER_NAME'] . str_replace('\\', '/', $_SERVER['PHP_SELF']);

$length = strlen($baseURL) - strlen('install/install.php');

$length2 = strlen($_SERVER['PHP_SELF']) - strlen('install/install.php');

$folder = substr($_SERVER['PHP_SELF'], 0, $length2);

//$folder = str_replace("/"," ",$folder);

$baseURL = substr($baseURL, 0, $length);

$mysqlHost = '';
$mysqlUname = '';
$mysqlPass = '';
$mysqlDB = '';

if (isset($_POST['submit']) && $_POST['submit'] == 'Submit' &&
        trim($_POST['base_url']) != '' &&
        trim($_POST['mysql_host']) != '' &&
        trim($_POST['mysql_uname']) != '' &&
        trim($_POST['mysql_db']) != '') {
    $error = '';
    $link = @osc_db_connect(trim($_POST['mysql_host']), trim($_POST['mysql_uname']), trim($_POST['mysql_password']));
    if (!$link) {
        $error = 'Could not connect to the host specified. Error: ' . mysql_error();
    } else {
        //Connected successfully
        $db_selected = @osc_db_select_db(trim($_POST['mysql_db']));

        if (!$db_selected) {
            $error = $error . '<BR>Can\'t use the database specified. Error: ' . mysql_error();
        }

        //mysql_close($link);
    }

    $baseURL = trim($_POST['base_url']);
    $mysqlHost = trim($_POST['mysql_host']);
    $mysqlUname = trim($_POST['mysql_uname']);
    $mysqlPass = trim($_POST['mysql_password']);
    $mysqlDB = trim($_POST['mysql_db']);

    if ($error == '') {
        $basePath = dirname(__FILE__);

        $db_error = false;
        $sql_file = $basePath . '/install.sql';

        osc_set_time_limit();

        osc_db_install($mysqlDB, $sql_file);

        /* Create the config file */
        $file1 = file_get_contents($basePath . '/temp/config1.cfg');
        $file2 = trim($_POST['base_url']);
        $file3 = file_get_contents($basePath . '/temp/config2.cfg');

        $file4 = '$config[\'hostname\'] = "' . trim($_POST['mysql_host']) . '";
$config[\'db_username\'] = "' . trim($_POST['mysql_uname']) . '";
$config[\'db_password\'] = "' . trim($_POST['mysql_password']) . '";
$config[\'db\'] = "' . trim($_POST['mysql_db']) . '";';

        $file5 = file_get_contents($basePath . '/temp/config3.cfg');
        $file9 = $folder;
        $file8 = file_get_contents($basePath . '/temp/config7.cfg');

        $file6 = trim($_POST['folder']);
        $file7 = file_get_contents($basePath . '/temp/config4.cfg');

        $configFile = $file1 . $file2 . $file3 . $file4 . $file5 . $file9 . $file8 . $file6 . $file7;

        $handle = fopen('config.php', 'w+');
        if ($handle) {
            fwrite($handle, $configFile);
            fclose($handle);
        }

        //Copy the config file
        if (file_exists($basePath . '../app/config/config.php')) {
            if (file_exists($basePath . '../app/config/config.php.bak'))
                @unlink($basePath . '../app/config/config.php.bak');

            @rename($basePath . '../app/config/config.php', $basePath . '../app/config/config.php.bak');
        }

        @chmod($basePath . '/../app/config/config.php', 0777);
        copy($basePath . '/config.php', $basePath . '/../app/config/config.php');


        $_SESSION['baseurl'] = trim($_POST['base_url']);
        $_SESSION['mysql_host'] = trim($_POST['mysql_host']);
        $_SESSION['mysql_uname'] = trim($_POST['mysql_uname']);
        $_SESSION['mysql_password'] = trim($_POST['mysql_password']);
        $_SESSION['mysql_db'] = trim($_POST['mysql_db']);

        rename($basePath . '/install.php', $basePath . '/install_old.php');
        header('Location: siteDetails.php');
    }
}
elseif (isset($_POST['submit']) && $_POST['submit'] == 'Submit') {
    $baseURL = trim($_POST['base_url']);
    $mysqlHost = trim($_POST['mysql_host']);
    $mysqlUname = trim($_POST['mysql_uname']);
    $mysqlPass = trim($_POST['mysql_password']);
    $mysqlDB = trim($_POST['mysql_db']);

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
        <title>DROPinn - Step2</title>
        <link href="css/common.css" rel="stylesheet" type="text/css" /> 
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
                            <img src="images/step2.png" alt="image" />

                        </div>
                    </div>
                </div>
                <div id="main">

                    <div class="block_tab">

                        <div class="clsDbServer clearfix">
                            <h2>Database Server</h2>
                            <br />
                            <?php
// PHP5?
                            if (!version_compare(phpversion(), '5.0', '>=')) {
                                echo 'OOps!! <strong>Installation error:</strong> in order to run DROPinn you need PHP5. Your current PHP version is: ' . phpversion();
                            } else {
                                if (isset($error))
                                    echo '<div id="error" class="error">' . $error . '</div><BR>';
                                ?> 
                                <form name="installFrm" method="post" action="">

                                    <p><label>Base URL:</label></p>
                                    <p><input type="text" name="base_url" class="clsTextLarge" value="<?php echo $baseURL; ?>"/><span>*</span></p>

                                    <p><label>Host Name:</label></p>
                                    <p><input type="text" name="mysql_host" class="clsTextLarge" value="<?php echo $mysqlUname; ?>"/><span>*</span></p>

                                    <p><label>User Name :</label></p>
                                    <p><input type="text" class="clsTextLarge" name="mysql_uname"/><span>*</span></p>

                                    <p><label>Password :</label></p>
                                    <p><input type="text" name="mysql_password" class="clsTextLarge" value="<?php echo $mysqlPass; ?>" /><span>*</span></p>

                                    <p><label>Database Name:</label></p>
                                    <p><input type="text" name="mysql_db" class="clsTextLarge" value="<?php echo $mysqlDB; ?>"/><span>*</span></p>

                                    <p><span>* Require</span></p>

                            </div>

                        </div>						   <div class="clsSubmit">
                            <p><input type="submit" class="clsBluebtn"  name="submit" value="Submit"  style="cursor:pointer"/>
                        </div>
                        </form>
                        <?php
                    } // End of else
                    ?>
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
