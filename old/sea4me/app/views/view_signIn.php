<?php
session_start();
if (isset($_SESSION['views'])) {
    unset($_SESSION['views']);
    redirect('/home/signin');
    //$_SESSION['views']=$_SESSION['views']+1;
}
else
    $_SESSION['views'] = 1;
?>

<div id="signup2">
    <div id="content">
        <div id="section_signup" style="display:none;">
            <div id="middle">
                <div class="clsH1_long_Border">
                    <h1>
                        <?php echo translate("Sign up for Sea4me"); ?>
                    </h1>
                </div>
                <div class="clsDisign_Box">
                    <div class="clsTop_Pannel">
                        <div class="clsTop_Left">
                            <div class="clsTop_Right">
                                <div class="clsTop_Mid">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="CenterPannel">
                        <div class="clsNor_Sign_In clearfix">
                            <div class="clsFloatLeft clsSign_Up_Lt">
                                <span class="login_prompt">
                                    <?php echo translate("Create a Free Account:"); ?>
                                </span> <?php echo form_open("home/submit", 'id="form"') ?>
                                <div class="group">
                                    <div class="wide_box">
                                        <div class="inner">
                                            <table>
                                                <tr>
                                                    <td class="label"><?php echo translate("User Name"); ?></td>
                                                    <td><input type="text" name="username" id="username" /></td>
                                                    <td><?php echo $username_error; ?> </td>
                                                </tr>
                                                <tr>
                                                    <td class="label"><?php echo translate("E-Mail"); ?></td>
                                                    <td><input type="text" name="email" id="email" /></td>
                                                    <td><span id="email_error"><?php echo $email_error; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="label"><?php echo translate("Password"); ?></td>
                                                    <td><input id="create_password" name="password" size="30" type="password" /></td>
                                                    <td><span id="password_error"><?php echo $password_error; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="label"><?php echo translate("Re-Type Password"); ?></td>
                                                    <td><input id="create_password" name="re-password" size="30" type="password" /></td>
                                                    <td><span id="password_error"><?php echo $retype_error; ?></span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input class='v3_button v3_green' type='submit' style="float:left;margin-left:118px;padding:10px;" value="Sign up"/>
                                    <div class="clear"></div>
                                </div>
                                </form><div id="right_side">
                                    <div class="yellow_box">
                                        <div class="inner">
                                            <p><?php echo translate("Already a member"); ?>?&nbsp;<a href="#" onclick="$('#section_signup').hide();$('#section_signin').show();return false;">
                                                    <?php echo translate("Sign in"); ?>
                                                </a></p></div>
                                    </div>
                                </div>
                                <!--  End of form for sign up -->
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                    <div class="BottomPannel">
                        <div class="clsBottom_Left">
                            <div class="clsBottom_Right">
                                <div class="clsBottom_Mid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div id="section_signin" style="">
            <div id="middle">
                <div class="clsTop_Cont_Sign">
                    <div class="clsH1_long_Border">
                        <h1>
                            <?php echo translate("Welcome back - Sign in"); ?>
                        </h1>
                    </div>
                </div>
                <div class="clsDisign_Box">
                    <div class="clsTop_Pannel">
                        <div class="clsTop_Left">
                            <div class="clsTop_Right">
                                <div class="clsTop_Mid">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="CenterPannel">
                        <div class="clearfix clsSign_Hole_Blk">
                            <!-- Facebook login goes here -->

                            <div class="clsNor_Sign_In">
                                <p><span class="login_prompt">
                                        <?php echo translate("Standard sign in:"); ?>
                                    </span></p> 
                                <?php
                                //Show Flash Message
                                if ($msg = $this->session->flashdata('flash_message')) {
                                    echo $msg;
                                }
                                ?>
                                <?php echo form_open("home/signin", 'id="signin"') ?>
                                <div class="group">
                                    <div class="wide_box">
                                        <div class="inner">
                                            <table>
                                                <tr>
                                                    <td class="label"><?php echo translate("User Name"); ?></td>
                                                    <td><input type="text" name="username" id="username" value="" />
                                                        <?php echo form_error('username'); ?>
                                                    </td>
                                                    <td class="tip"><?php echo $user_error ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="label"><?php echo translate("Password"); ?></td>
                                                    <td><input id="password" name="password" type="password" value="" />
                                                        <?php echo form_error('password'); ?></td>
                                                    <td class="tip">&nbsp;</td>
                                                </tr>
                                                <tr><td>&nbsp;</td><td colspan="2"><?php echo anchor('auth/forgot_password', 'Forgot?') ?></td></tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input class='v3_button' name="SignIn" type='submit' style="float:left;margin-left:119px;padding:10px;" value='<?php echo translate("Sign in"); ?>'/>
                                    <div class="clear"></div>
                                </div>
                                <!--  Right side -->
                                <div id="right_side">
                                    <div class="yellow_box">
                                        <div class="inner">
                                            <p><span><?php echo translate("Create Your Account:"); ?></span> &nbsp;
                                                <a href="#" onclick="$('#section_signin').hide();$('#section_signup').show();return false;"><?php echo translate("Sign up"); ?>
                                                </a></p> </div>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                    </div>
                    <div class="BottomPannel">
                        <div class="clsBottom_Left">
                            <div class="clsBottom_Right">
                                <div class="clsBottom_Mid">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="clear:both;"></div>
                    </form>
                </div>

                <div class="clear"></div>
            </div>
        </div>
    </div>