<?php

/**
 * DROPinn Admin Contact Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		DROPinn
 * @subpackage	Controllers
 * @category	Admin Contact
 * @author		Cogzidel Product Team
 * @version		Version 1.4
 * @link		http://www.cogzidel.com

 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function Contact() {
        parent::__construct();

        $this->load->library('Table');
        $this->load->library('Pagination');
        $this->load->library('DX_Auth');

        $this->load->helper('form');
        $this->load->helper('url');

        //load validation library
        $this->load->library('form_validation');


        $this->load->model('dx_auth/users', 'users');

        // Protect entire controller so only admin, 
        // and users that have granted role in permissions table can access it.
        $this->dx_auth->check_uri_permissions();
    }

    public function index() {
        if ($this->input->post('update')) {

            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['name'] = $this->input->post('name');
            $data['street'] = $this->input->post('street');
            $data['city'] = $this->input->post('city');
            $data['state'] = $this->input->post('state');
            $data['country'] = $this->input->post('country');
            $data['pincode'] = $this->input->post('pincode');

            $this->db->where('id', 1);
            $this->db->update('contact_info', $data);

            echo 'Contact info updated successfully';
        } else {
            $data['row'] = $this->db->get_where('contact_info', array('id' => '1'))->row();
            $data['message_element'] = "backend/contact/view_contact_info";
            $this->load->view('backend/admin_template', $data);
        }
    }

}