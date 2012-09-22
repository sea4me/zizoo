<div id="sellogin">
    <?php
    //Show Flash Message
    if ($msg = $this->session->flashdata('flash_message')) {
        echo $msg;
    }
    ?>

    <!--CONTENT-->
    <div class="innercontent">
        <h2><?php echo translate_admin("Member Area"); ?> - <?php echo translate_admin("Login"); ?> </h2>
        <div class="form_error"> </div>
        <form method="post" action="<?php echo site_url('auth/login'); ?>">
            <p>
                <label><?php echo translate_admin("Username"); ?> <span class="clsRed">*</span></label>
                <input class="focus" type="text" name="username" value="<?php echo set_value('username'); ?>"/>
            </p>
            <?php if (form_error('username')) { ?>
                <p>
                    <?php echo form_error('username'); ?></p>
            <?php } ?>
            <p>
                <label><?php echo translate_admin("Password"); ?><span class="clsRed">*</span></label>
                <input class="focus" type="password" name="password" value=""/>
            </p>
            <p>
                <?php if (form_error('username')) { ?>
                    <?php echo form_error('password'); ?> </p>
            <?php } ?>
            <p>
                <label>&nbsp;</label>
                <input class="clsSubmitBt1 " value="<?php echo translate_admin("Submit"); ?>" name="loginAdmin" type="Submit">
                <input class="clsSubmitBt1" value="<?php echo translate_admin("Reset"); ?>" name="reset" type="reset">
            </p>
        </form>
    </div>
    <!--END OF CONTENT-->
</div>