<script type="text/javascript">
    function startCallback() {
		
        if(document.getElementById("new_password").value == document.getElementById("confirm_password").value)
        {
            document.getElementById("error").style.display = "none";
            document.getElementById('message').innerHTML = '<img src="<?php echo base_url() . 'images/loading.gif' ?>">';
            // make something useful before submit (onStart)
            return true;
        }
        else
        {
            document.getElementById("error").style.display = "block";
            return false;
        }
    }

    function completeCallback(response) {
        document.getElementById('message').innerHTML = response;
    }
</script>

<div class="clsSettings">
    <div class="clsMainSettings">
        <div class="clsTitle">
            <h3><?php echo translate_admin('Change Password'); ?></h3>
        </div>

        <form action="<?php echo admin_url('backend/settings/change_password'); ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})">	

            <table class="table" cellpadding="2" cellspacing="0">

                <tr>
                    <td class="clsName"><?php echo translate_admin('New Password'); ?><span class="clsRed">*</span></td>
                    <td> <input id="new_password" type="text" name="new_password" value=""> <p id="error" style="display:none; color:#CC3300"> <?php echo translate_admin('Password and Confirm Password didnt match.'); ?> </p></td>
                </tr>		

                <tr>
                    <td class="clsName"><?php echo translate_admin('Confirm Password'); ?><span class="clsRed">*</span></td>
                    <td> <input id="confirm_password" type="text" size="55" name="confirm_password" value=""></td>
                </tr>			

                <tr>
                    <td></td>
                    <td>
                        <div class="clearfix">
                            <span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update" value="<?php echo translate_admin('Update'); ?>" style="width:90px;" /></span>
                            <span style="float:left; padding:20px 0 0 0;"><div id="message"></div></span>
                        </div>
                    </td>
                </tr>

            </table>

            <?php echo form_close(); ?>

    </div>
</div>