<?php /* ?><?php 
  /*	session_start();
  if(isset($_SESSION['views']))
  {
  unset($_SESSION['views']);
  redirect('/home/signin');
  //$_SESSION['views']=$_SESSION['views']+1;
  }
  else
  $_SESSION['views']=1; */
?>

<div id="signup2">
    <div id="content">
        <div id="section_signup" style="">
            <div id="middle">
                <div class="clsH1_long_Border">
                    <h1>
                        <?php echo translate("Create a Free Account"); ?>
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
                        <div class="clearfix">
                            <!-- <div style="padding-top:5px;height:20px;"><span>FB-Login</span></div> -->
                            <div class="clsFloatLeft clsNor_Sign_In"> <span class="login_prompt">
                                    <?php echo translate("Or standard sign up:"); ?>
                                </span> <?php echo form_open("home/submit", 'id="form"'); /* $ref = $this->input->cookie('ref_email', TRUE); */ ?>
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
                                                    <td class="tip"><span id="email_error"><?php echo $email_error; ?></span></td>
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
                                <p>
                                    <input class='v3_button v3_green' type='submit' style="float:left;margin-left:118px; margin-top:5px;" value="<?php echo translate("Sign up"); ?>"/>
                                <div class="clear"></div>
                                </p>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    <div style="clear:both"></div>
                    <div class="BottomPannel">
                        <div class="clsBottom_Left">
                            <div class="clsBottom_Right">
                                <div class="clsBottom_Mid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <!--  End of form for sign up -->
            </div>

            <div class="clear"></div>
        </div>
    </div>
    <br/>
