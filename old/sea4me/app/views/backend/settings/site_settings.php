<script type="text/javascript">
    function startCallback() {
        document.getElementById('message').innerHTML = '<img src="<?php echo base_url() . 'images/loading.gif' ?>">';
        // make something useful before submit (onStart)
        return true;
    }

    function completeCallback(response)
    {
        var res = response;
        var getSplit = res.split('#'); 
        document.getElementById('img_logo').innerHTML = getSplit[0];
        document.getElementById('message').innerHTML  = getSplit[1];
    }
</script>

<div class="clsSettings">
    <div class="clsMainSettings">
        <div class="clsTitle">
            <h3><?php echo translate_admin('Global Settings'); ?></h3>
        </div>

        <form action="<?php echo admin_url('settings'); ?>" method="post" enctype="multipart/form-data" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})">	

            <table class="table" cellpadding="2" cellspacing="0">

                <tr>
                    <td class="clsName"><?php echo translate_admin('Site Title'); ?></td>
                    <td> <input type="text" size="55" name="site_title" value="<?php if (isset($site_title)) echo $site_title; ?>"></td>
                </tr>		

                <tr>
                    <td class="clsName"><?php echo translate_admin('Site Slogan'); ?></td>
                    <td> <input type="text" size="55" name="site_slogan" value="<?php if (isset($site_slogan)) echo $site_slogan; ?>"></td>
                </tr>		

                <tr>
                    <td class="clsName"><?php echo translate_admin('Super Admin'); ?></td>
                    <td> <input type="text" size="55" name="super_admin" value="<?php if (isset($super_admin)) echo $super_admin; ?>"></td>
                </tr>		

                <tr>
                    <td class="clsName"><?php echo translate_admin('Site Offline'); ?></td>
                    <td>
                        <input type="radio" <?php if ($site_status == 0) echo 'checked="checked"'; ?> value="0" name="offline">
                        No
                        <input type="radio" <?php if ($site_status == 1) echo 'checked="checked"'; ?> value="1" name="offline">
                        Yes
                    </td>
                </tr>

                <tr>
                    <td class="clsName"><?php echo translate_admin('Offline Message'); ?></td>
                    <td>
                        <textarea name="offline_message" style="width:400px; height:40px" rows="2" cols="60" class="text_area"><?php if (isset($offline_message)) echo $offline_message; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td class="clsName"><?php echo translate_admin('Google Analytics Code'); ?></td>
                    <td>
                        <textarea name="google_analytics" style="width:400px; height:100px" rows="10" cols="60" class="text_area"><?php if (isset($google_analytics)) echo $google_analytics; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td class="clsName"><?php echo translate_admin('Change Logo'); ?></td>
                    <td>
                        <input id="new_photo_image" name="logo"  size="24" type="file" />
                        <p id="img_logo"> <img src="<?php echo $logo; ?>" alt="logo"></p>
                    </td>
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