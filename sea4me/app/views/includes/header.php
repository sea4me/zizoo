<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Meta Content from user -->

        <meta name="description" content=<?php if (isset($meta_description)) echo $meta_description; else echo ""; ?> />
        <meta name="keywords" content=<?php if (isset($meta_keyword)) echo $meta_keyword; else echo ""; ?> />
        <!-- End of meta content -->


        <title><?php echo $title ?> </title>

        <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="Cogzidel" />

        <link href="<?php echo base_url(); ?>css/common.css" media="screen" rel="stylesheet" type="text/css" />


        <?php $this->load->view('includes/map'); ?>

        <script>var NREUMQ=[];NREUMQ.push(["mark","firstbyte",new Date().getTime()]);(function(){var d=document;var e=d.createElement("script");e.type="text/javascript";e.async=true;e.src="<?php echo base_url(); ?>js/rum.js";var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(e,s);})()</script>

        <script type="text/javascript">
            var base_url = '<?php echo base_url(); ?>';
            var default_value = '<?php echo translate("Where are you going?"); ?>';
        </script>

        <script src="<?php echo base_url(); ?>js/common.js" type="text/javascript"></script>

        <script type="text/javascript" src="<?php echo base_url() . 'js/jquery.validate.js'; ?>"></script>

        <script src="<?php echo base_url(); ?>js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>

        <?php if ($this->uri->segment(2) == 'searchbydate' || $this->uri->segment(1) == 'search') { ?>
            <script src="<?php echo base_url(); ?>js/page2.js" type="text/javascript"></script>
        <?php } else if ($this->uri->segment(2) == 'editConfirm' || $this->uri->segment(1) == 'rooms') { ?>
            <script src="<?php echo base_url(); ?>js/page3.js" type="text/javascript"></script>
        <?php } else { ?>
            <script src="<?php echo base_url(); ?>js/page1.js" type="text/javascript"></script>
        <?php } ?>





    </head>

    <body>
        <div id="fb-root"></div>
        <!--Top Header-->

        <div id="TopHeader" class="clsClearFix">
            
        
        



        <?php
        /* $query=$this->db->query("SELECT starred FROM list WHERE starred='true'");
          $starred=$query->result();
          $star_count=count($starred); */
        ?>

        <!--Header-->
        <div id="Header" class="clsClearFix">
            <div id="selLogo" class="clsFloatLeft">
                <?php
                $logo = $this->db->get_where('settings', array('code' => 'SITE_LOGO'))->row()->string_value;
                $query = $this->db->get_where('settings', array('code' => 'FRONTEND_LANGUAGE'));
                $trans_lang = $query->row()->int_value;
                $default_lang = $query->row()->string_value;
                $user_lang = $this->session->userdata('locale');
                if ($user_lang == '') {
                    $locale = $default_lang;
                } else {
                    $locale = $user_lang;
                }
                ?>
                <h1><a href="<?php echo base_url(); ?>"><img width="188px" height="74px" src="<?php echo base_url() . 'logo/' . $logo; ?>" title="<?php echo $this->dx_auth->get_site_title(); ?>"/></a></h1>
            </div>
            <div id="selTopNav" class="clsFloatRight">
                <ul class="clsClearFix">
                    <?php if (!($this->dx_auth->is_logged_in())): ?>
                        <li class="clsBg"><?php echo anchor('home/signup', translate("Sign Up")); ?></li>
                        <li class="clsBg"><?php echo anchor('home/signin', translate("Sign In")); ?></li>
                    <?php else: ?>
                        <li class="clsBg"> <?php echo translate("Hello"); ?>
                            <?php
                            if (strlen($this->dx_auth->get_username()) > 14):
                                $query = $this->db->get_where('profiles', array('id' => $this->dx_auth->get_user_id()));
                                $q = $query->result();
                                echo $q[0]->Fname . ' ' . $q[0]->Lname . '!';
                            else:
                                echo $this->dx_auth->get_username(). '!';
                            endif;
                            ?>&nbsp;&nbsp;</li>
                        <li class="clsBg"><?php echo anchor('func/dashboard/' . $this->dx_auth->get_user_id(), translate("Dashboard")); ?></li>
                        <?php if ($this->dx_auth->is_admin()): ?>
                            <li class="clsBg"><?php echo anchor('backend', translate("Admin Panel"), array("target" => "_blank")); ?></li>
                        <?php endif; ?>
                        <li class="clsBg"><?php echo anchor('home/logout', translate("Logout")); ?></li>
                    <?php endif; ?>
                    <li class="clsBg"><a href="<?php echo site_url('info/how_it_works'); ?>"><?php echo translate("How It Works"); ?></a></li>

                    <li class="clsListSpace"><?php echo anchor('home/addlist', translate('Add Boat')); ?></li>
                </ul>



            </div>
        </div>
        </div>
                <!--TopHeader Ends-->
        <!--Header Ends-->