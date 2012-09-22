<script type="text/javascript">
    function startCallback() {
        document.getElementById('message').innerHTML = '<img src="<?php echo base_url() . 'images/loading.gif' ?>">';
        // make something useful before submit (onStart)
        return true;
    }

    function completeCallback(response) {
        document.getElementById('message').innerHTML = response;
    }
</script>

<div class="clsSettings">
    <div class="clsMainSettings">
        <div class="clsTitle">
            <h3><?php echo translate_admin('Manage Contact Info'); ?></h3>
        </div>

        <form action="<?php echo admin_url('contact'); ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})">	

            <table class="table" cellpadding="2" cellspacing="0">

                <tr>
                    <td class="clsName"><?php echo translate_admin('Phone'); ?><span class="clsRed">*</span></td>
                    <td> <input type="text" size="45" name="phone" value="<?php if (isset($row->phone)) echo $row->phone; ?>"></td>
                </tr>		

                <tr>
                    <td class="clsName"><?php echo translate_admin('E-Mail'); ?><span class="clsRed">*</span></td>
                    <td> <input type="text" size="45" name="email" value="<?php if (isset($row->email)) echo $row->email; ?>"></td>
                </tr>

                <tr>
                    <td class="clsName"><?php echo translate_admin('Name / Company Name'); ?><span class="clsRed">*</span></td>
                    <td> <input type="text" size="45" name="name" value="<?php if (isset($row->name)) echo $row->name; ?>"></td>
                </tr>		

                <tr>
                    <td class="clsName"><?php echo translate_admin('Street Address'); ?><span class="clsRed">*</span></td>
                    <td> <input type="text" size="45" name="street" value="<?php if (isset($row->street)) echo $row->street; ?>"></td>
                </tr>	

                <tr>
                    <td class="clsName"><?php echo translate_admin('City'); ?><span class="clsRed">*</span></td>
                    <td> <input type="text" size="45" name="city" value="<?php if (isset($row->city)) echo $row->city; ?>"></td>
                </tr>		

                <tr>
                    <td class="clsName"><?php echo translate_admin('State'); ?><span class="clsRed">*</span></td>
                    <td> <input type="text" size="45" name="state" value="<?php if (isset($row->state)) echo $row->state; ?>"></td>
                </tr>	

                <tr>
                    <td class="clsName"><?php echo translate_admin('Country'); ?><span class="clsRed">*</span></td>
                    <td> <input type="text" size="45" name="country" value="<?php if (isset($row->country)) echo $row->country; ?>"></td>
                </tr>

                <tr>
                    <td class="clsName"><?php echo translate_admin('Pincode'); ?><span class="clsRed">*</span></td>
                    <td> <input type="text" size="45" name="pincode" value="<?php if (isset($row->pincode)) echo $row->pincode; ?>"></td>
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