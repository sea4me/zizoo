<div class="content">
    <h2><b><?php echo translate_admin('Dashboard'); ?></b></h2>
    <h3 class="clsNoborder"><b><?php echo translate_admin('Latest Activity'); ?></b></h3>
    <?php
    $no_user = $this->db->get('users')->num_rows();
    $no_list = $this->db->get('list')->num_rows();
    ?>
    <div id="selLatest">
        <div class="selQuickStatus clearfix">
            <div class="selQuickStatusleft clsFloatLeft">
                <p><img src="<?php echo base_url() . '/css/images/chat.gif'; ?>" height="40" width="45" alt="img" /></p>
            </div>         
            <div class="selQuickStatusRight clsFloatRight">
                <ul class="clearfix">
                    <li class="clsMember clear"><table width="300"><tr><td width="60%"><?php echo translate_admin('Total Users'); ?> :</td> <td width="10%"><?php if (isset($no_user)) echo $no_user; ?></td> <td width="30%"><a href="<?php echo admin_url('backend/users'); ?>"><?php echo translate_admin('Members'); ?></a></td></tr></table></li>

                    <li class="clsClosedprojects"><table width="300"><tr><td width="60%"><?php echo translate_admin('Total List'); ?> :</td> <td width="10%"><?php if (isset($no_list)) echo $no_list; ?></td><td width="30%"><a href="<?php echo admin_url('backend/lists'); ?>"> <?php echo translate_admin('Lists'); ?></a></td></tr></table></li>

                </ul>
            </div>
        </div>
    </div>
    <div class="clsBottom clearfix"> 
        <div class="clsBottomleft clsFloatLeft">
            <h3 class="clsNoborder"><?php echo translate_admin('Version'); ?></h3>
            <ul>
                <li><a href="#"><?php echo translate_admin('Installed Version'); ?> - 1.0</a></li>
            </ul>
        </div>
        <div class="clsBottomRight clsFloatRight">
        </div>
    </div>
</div>