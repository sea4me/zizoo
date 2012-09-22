<div class="clsSettings">
    <div class="clsMainSettings">

        <?php
        //Show Flash Message
        if ($msg = $this->session->flashdata('flash_message')) {
            echo $msg;
        }
        ?>

        <div class="clsTitle">
            <h3><?php echo translate_admin('Manage How It Works'); ?></h3>
        </div>

        <form name="howit" action="" method="post" enctype="multipart/form-data">	

            <table class="table" cellpadding="2" cellspacing="0">

                <tr>
                    <td class="clsName"><?php echo translate_admin('Display Type'); ?><span class="clsRed">*</span></td>
                    <td> 
                        <select id="display_type" name="display_type" onChange="javascript:showhide(this.value);">
                            <option value="0">Video Type</option>
                            <option value="1">Embed Type</option>
                        </select>
                    </td>
                </tr>

                <?php
                if ($display_type == 0) {
                    $showM = 'table-row';
                    $showE = 'none';
                } else {
                    $showM = 'none';
                    $showE = 'table-row';
                }
                ?>	

                <tr id="media" style="display:<?php echo $showM; ?>;">
                    <td class="clsName"><?php echo translate_admin('Video'); ?><span class="clsRed">*</span></td>
                    <td> 
                        <p> <input type="file" name="media"> &nbsp;
                            <a style="color:#3333FF" href="<?php echo site_url('info/how_it_works'); ?>" target="_blank">Click Here</a> to see the current video.
                    </td>
                </tr>	

                <tr id="embed" style="display:<?php echo $showE; ?>;">
                    <td class="clsName"><?php echo translate_admin('Embed Code'); ?><span class="clsRed">*</span></td>
                    <td> 
                        <textarea class="text_area" cols="60" rows="5" name="embed_code"><?php if (isset($embed_code)) echo $embed_code; ?></textarea>
                    </td>
                </tr>			

                <tr>
                    <td></td>
                    <td>
                        <div class="clearfix">
                            <span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update" value="<?php echo translate_admin('Update'); ?>" style="width:90px;" /></span>
                        </div>
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>

<script language="Javascript">
    jQuery("#display_type").val('<?php echo $display_type; ?>');

    function showhide(id)
    {
        if(id == 0)
        {
            document.getElementById("media").style.display            = "table-row";
            document.getElementById("embed").style.display            = "none";
        }
        else
        { 
            document.getElementById("media").style.display             = "none";
            document.getElementById("embed").style.display             = "table-row";	
        }

    }
</script>