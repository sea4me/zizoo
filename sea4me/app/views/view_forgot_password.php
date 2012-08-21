<!-- Stylesheets -->
<div class="clsForget_Bg">
  <!--<div id="notice">
    <?php //translate("Please enter an e-mail address.",$this->session->userdata('lang'));?>
  </div>-->
  <div id="simple">
    <div id="content">
      <div id="forgot_password_container">
       <div class="clsH1_long_Border">
        <h1>
          <?php echo translate("Reset Password"); ?>
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
        <p>
          <?php echo translate("Enter your e-mail address to have the password associated with that account reset. A new password will be e-mailed to the address."); ?>
        </p>
        <form action="<?php echo base_url()."auth/forgot_password";?>" method="post">
          <div class="textInput" id="inputEmail">
            <div class="bgWrapper">
             <p> <label for="forgot_email" class="labelBlur">
              <?php echo translate("Email"); ?>
              </label>
              <input id="forgot_email" name="email" type="text" />
              </p>
            </div>
          </div>
          <p style="margin-left:38px;">
            <input class="button-glossy green forget_butt" name="commit" type="submit" value="Reset Password" />
            <span style="margin-left:15px;"><a href="javascript:void(0);" class="cancel">
          <?php echo translate("Cancel"); ?>
          </a></span>
          </p>
          <h3 class="or-separator signpainter">or</h3>
          <h2 class="signIn">
            <?php echo translate("Already an member?"); ?>
            <a href="<?php echo base_url().'home/signin'?>">
            <?php echo translate("Sign In"); ?>
            </a></h2>
        </form>
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
      <script type="text/javascript">
(function($){
  $('#forgot_password_container form').submit(function(){
    $(this).disableSubmit();
  });
  $('#forgot_password_container a.cancel').click(function(){
    $.colorbox.close();
  });
})(jQuery);
</script>
    </div>
  </div>
</div>
