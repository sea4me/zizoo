
<div id="home_static" class="newfeatures">
    <!-- BEGIN STATIC LAYOUT -->

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
            <div class="View_Contact clearfix">
                <div class="clsH1_long_Border">
                    <h1><?php echo translate("Contact us"); ?></h1>
                </div>
                <div class="content clearfix" id="about_static">

                    <?php
                    //Show Flash Message
                    if ($msg = $this->session->flashdata('flash_message')) {
                        echo $msg;
                    }
                    ?>
                    <div class="clsFloatLeft Cont_Adrees">
                        <p><label><?php echo translate("Phone Support"); ?></label><?php if (isset($row->phone) && $row->phone != '') echo $row->phone; else echo "-"; ?></p>
                        <p><label><?php echo translate("Email Support"); ?></label><?php if (isset($row->email) && $row->email != '') echo $row->email; else echo "-" ?></p>
                        <p><label><?php echo translate("Meet us AT"); ?></label><?php if (isset($row->name) && $row->name != '') echo $row->name; else echo "-" ?></p>
                        <?php if (isset($row->street)) echo '<p><label>&nbsp;</label>' . $row->street . '</p>'; ?>
                        <?php if (isset($row->city)) echo '<p><label>&nbsp;</label>' . $row->city . '</p>'; ?>
                        <p><label>&nbsp;</label><?php if (isset($row->state)) echo $row->state; ?>&nbsp;-&nbsp;<?php if (isset($row->pincode) && $row->pincode != '0') echo $row->pincode; else "-"; ?></p>
                        <?php if (isset($row->country)) echo '<p><label>&nbsp;</label>' . $row->country . '</p>'; ?>
                    </div>
                    <div class="row clsFloatRight" style="width:500px;">
                        <div class="column fullwidth">

                            <!-- Feedback Form start -->
                            <div class="feedback-form">
                                <div id="feedback-unsubmitted">


                                    <form action="<?php echo site_url('pages/contact'); ?>" id="submit_message_form" method="post">                

                                        <div class="column half">
                                            <div class="user-info">

                                                <label class="inner_text" for="name"><?php echo translate("Name"); ?></label><input id="name" name="name" placeholder="Name" type="text" />
                                                <?php echo form_error('name'); ?>
                                            </div>
                                        </div>

                                        <div class="column half">
                                            <div class="user-info">

                                                <label class="inner_text" for="email"><?php echo translate("Email Address"); ?></label><input id="email" name="email" placeholder="Email Address" type="text" />
                                                <?php echo form_error('email'); ?>
                                            </div>
                                        </div>

                                        <div class="column half">
                                            <div class="feedback-info">
                                                <label class="inner_text" for="message"><?php echo translate("Feedback"); ?></label>
                                                <textarea id="message" name="message" placeholder="Feedback" rows="4"></textarea>
                                                <?php echo form_error('message'); ?>
                                            </div>
                                        </div>
                                        <div class="column half">
                                            <div class="feedback-info">
                                                <label>&nbsp;</label>
                                                <input class="v3_button" id="message_submit" name="commit" type="submit" value="<?php echo translate("Send"); ?>" />
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>

                            <!-- End of feedback form  -->

                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
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
    <!-- END STATIC LAYOUT -->