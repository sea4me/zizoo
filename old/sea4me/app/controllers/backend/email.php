<?php

/**
 * DROPinn Admin Email Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		DROPinn
 * @subpackage	Controllers
 * @category	Admin Social
 * @author		Cogzidel Product Team
 * @version		Version 1.4
 * @link		http://www.cogzidel.com

  <Dropinn>
  Copyright (C) <2011>  <Cogzidel Technologies>

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>
  If you want more information, please email me at bala.k@cogzidel.com or
  contact us from http://www.cogzidel.com/contact
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email extends CI_Controller {

    public function Email() {
        parent::__construct();

        $this->load->library('Table');
        $this->load->library('Pagination');
        $this->load->library('DX_Auth');

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('file');
        //load validation library
        $this->load->library('form_validation');
        $this->load->library('email');

        $this->load->model('dx_auth/users', 'users');
        $this->load->model('Email_model');
        $this->load->model('common_model');

        // Protect entire controller so only admin, 
        // and users that have granted role in permissions table can access it.
        $this->dx_auth->check_uri_permissions();
        $this->path = realpath(APPPATH);
    }

    /**
     * Loads Email settings page.
     *
     * @access	private
     * @param	nil
     * @return	void
     */
    function index() {

        //Get All Email Termplates List
        $data['email_settings'] = $this->Email_model->getEmailSettings();

        $data['message_element'] = "backend/email/template";
        $this->load->view('backend/admin_template', $data);
    }

//End of index function

    /**
     * add EmailSettings.
     *
     * @access	private
     * @param	nil
     * @return	void
     */
    function addemailTemplate() {
        //Intialize values for library and helpers	
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('addemailTemplate')) {
            //Set rules
            $this->form_validation->set_rules('email_title', 'Email Title', 'required|trim|xss_clean|callback_categoryNameCheck');
            $this->form_validation->set_rules('email_subject', 'Email Subject', 'required');
            $this->form_validation->set_rules('email_body_text', 'Plain Text Body', 'required');
            $this->form_validation->set_rules('email_body_html', 'Html Body', 'required');

            if ($this->form_validation->run()) {

                //prepare update data
                $insertData = array();
                $insertData['id'] = '';
                $insertData['type'] = $this->input->post('email_type');
                $insertData['title'] = $this->input->post('email_title');
                $insertData['mail_subject '] = $this->input->post('email_subject');
                $insertData['email_body_text'] = $this->input->post('email_body_text');
                $insertData['email_body_html'] = $this->input->post('email_body_html');

                //add Email Settings
                $this->Email_model->addEmailSettings($insertData);
                //Notification message
                $this->session->set_flashdata('flash_message', $this->common_model->admin_flash_message('success', 'Updated Successfully'));
                redirect_admin('email');
            }
        } //If - Form Submission End	
        //Load View
        $data['message_element'] = "backend/email/add_template";
        $this->load->view('backend/admin_template', $data);
    }

    /**
     * Edit EmailSettings.
     *
     * @access	private
     * @param	nil
     * @return	void
     */
    function edit() {
        //Get id of the category	
        $id = is_numeric($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        //Intialize values for library and helpers	
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('editEmailSetting')) {
            //Set rules
            $this->form_validation->set_rules('email_title', 'Email Title', 'required|trim|xss_clean');
            $this->form_validation->set_rules('email_subject', 'Email Subject', 'required');
            $this->form_validation->set_rules('email_body_text', 'Plain Text Body', 'required');
            $this->form_validation->set_rules('email_body_html', 'Html Body', 'required');

            if ($this->form_validation->run()) {

                //prepare update data
                $updateData = array();
                $updateData['title'] = $this->input->post('email_title');
                $updateData['mail_subject'] = $this->input->post('email_subject');
                $updateData['email_body_text'] = $this->input->post('email_body_text');
                $updateData['email_body_html'] = $this->input->post('email_body_html');

                //Update Email Settings
                $this->Email_model->updateEmailSettings($id, $updateData);
                //Notification message
                $this->session->set_flashdata('flash_message', $this->common_model->admin_flash_message('success', 'Updated Successfully'));
                redirect_admin('email');
            }
        } //If - Form Submission End
        //Set Condition To Fetch The Email Settings info
        $condition = array('id' => $id);

        //Get Email Settings
        $data['emailSettings'] = $this->Email_model->getEmailSettings($condition);

        //Load View
        $data['message_element'] = "backend/email/edit_template";
        $this->load->view('backend/admin_template', $data);
    }

//End of editEmailSettings function

    function editTemplate() {
        $this->load->model('emailtemplatemodel');
        $outputData['emailTemplates_list'] = false;
        $outputData['emailTemplates_edit'] = true;
        $template_id = $this->uri->segment(4);
        $this->load->library('validation');
        $this->_emailtemplatesFrm();
        if (!isset($_POST['email_template'])) {
            $outputData['templates'] = $this->emailtemplatemodel->readEmailTemplate($template_id);
            if ($outputData['templates'] != false)
                $outputData['templatesArr'] = $outputData['templates'];
        }
        if (isset($_POST['cancel_template']))
            redirect('admin/emailTemplates');
        if ($this->validation->run() == false)
            $outputData['validationError'] = $this->validation->error_string;
        else {
            if (isset($_POST['email_template'])) {
                $this->emailtemplatemodel->updateEmailTemplate($_POST);
                //Set the flash data
                $this->session->set_flashdata('successMsg', $this->lang->line('emailtemplates_success_msg'));
                redirect('admin/emailTemplates/editTemplate/' . $_POST['template_key']);
            }
        }
        $this->smartyextended->view('../admin/emailtemplates', $outputData);
    }

    function _emailtemplatesFrm() {
        $rules['template_subject'] = 'trim|required|alphanumeric';
        $rules['template_content'] = 'trim|required|alphanumeric';
        $fields['template_subject'] = 'E-Mail Subject';
        $fields['template_content'] = 'E-mail Content';

        $this->validation->set_rules($rules);
        $this->validation->set_fields($fields);
    }

    /**
     * delete EmailSettings.
     *
     * @access	private
     * @param	nil
     * @return	void
     */
    function delete() {
        //Load model
        $this->load->model('email_model');
        //Get id of the category	
        $id = is_numeric($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $condition = array('email_templates.id' => $id);
        $this->email_model->deleteEmailSettings($condition);
        //Notification message
        $this->session->set_flashdata('flash_message', $this->common_model->admin_flash_message('success', 'Deleted Successfully'));
        redirect_admin('email');
    }

//function end	

    public function settings() {

        if ($this->input->post('update')) {
            $data1['value'] = $this->input->post('mailer_type');
            $this->db->where('code', 'MAILER_TYPE');
            $this->db->update('email_settings', $data1);

            $data2['value'] = $this->input->post('smtp_port');
            $this->db->where('code', 'SMTP_PORT');
            $this->db->update('email_settings', $data2);

            $data3['value'] = $this->input->post('smtp_user');
            $this->db->where('code', 'SMTP_USER');
            $this->db->update('email_settings', $data3);

            $data4['value'] = $this->input->post('smtp_pass');
            $this->db->where('code', 'SMTP_PASS');
            $this->db->update('email_settings', $data4);

            $data5['value'] = $this->input->post('mailer_mode');
            $this->db->where('code', 'MAILER_MODE');
            $this->db->update('email_settings', $data5);

            echo 'Email settings updated successfully';
        } else {
            $query1 = $this->db->get_where('email_settings', array('code' => 'MAILER_TYPE'));
            $data['mailer_type'] = $query1->row()->value;

            $query2 = $this->db->get_where('email_settings', array('code' => 'SMTP_PORT'));
            $data['smtp_port'] = $query2->row()->value;

            $query3 = $this->db->get_where('email_settings', array('code' => 'SMTP_USER'));
            $data['smtp_user'] = $query3->row()->value;

            $query4 = $this->db->get_where('email_settings', array('code' => 'SMTP_PASS'));
            $data['smtp_pass'] = $query4->row()->value;

            $query5 = $this->db->get_where('email_settings', array('code' => 'MAILER_MODE'));
            $data['mailer_mode'] = $query5->row()->value;

            $data['message_element'] = "backend/email/settings";
            $this->load->view('backend/admin_template', $data);
        }
    }

    public function mass_email() {
        if ($this->input->post('submit')) {
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');

            $admin_email = $this->dx_auth->get_site_sadmin();

            if ($this->input->post('is_private') == 1) {
                $emails = $this->input->post('email_to');
                $mail_list = explode(',', $emails);

                if (!empty($mail_list)) {
                    foreach ($mail_list as $email_to) {
                        if ($this->email->valid_email($email_to)) {

                            $toEmail = $email_to;
                            $fromEmail = $admin_email;
                            $fromName = $this->dx_auth->get_site_title();

                            $email_name = 'admin_mass_email';

                            $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{dynamic_content}" => $message, "{subject}" => $subject);

                            $this->Email_model->sendMail($toEmail, $fromEmail, $fromName, $email_name, $splVars);
                        }
                    }
                }
            } else {
                $this->db->where('id !=', 1);
                $users = $this->db->get('users')->result();
                foreach ($users as $user) {
                    if ($this->email->valid_email($user->email)) {

                        $toEmail = $user->email;
                        $fromEmail = $admin_email;
                        $fromName = $this->dx_auth->get_site_title();

                        $email_name = 'admin_mass_email';

                        $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{dynamic_content}" => $message, "{subject}" => $subject);

                        $this->Email_model->sendMail($toEmail, $fromEmail, $fromName, $email_name, $splVars);
                    }
                }
            }
            echo 'Mail sent successfully';
        } else {
            $data['message_element'] = "backend/email/mass_email";
            $this->load->view('backend/admin_template', $data);
        }
    }

}

?>