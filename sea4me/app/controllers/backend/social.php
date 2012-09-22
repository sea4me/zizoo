<?php

/**
 * DROPinn Admin Social Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		DROPinn
 * @subpackage	Controllers
 * @category	Admin Social
 * @author		Cogzidel Product Team
 * @version		Version 1.4
 * @link		http://www.cogzidel.com

 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Social extends CI_Controller {

    public function Social() {
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

    public function fb_settings() {
        if ($this->input->post('update')) {
            $data1['string_value'] = $this->input->post('fb_api_id');
            $this->db->where('code', 'SITE_FB_API_ID');
            $this->db->update('settings', $data1);

            $data2['string_value'] = $this->input->post('fb_api_secret');
            $this->db->where('code', 'SITE_FB_API_SECRET');
            $this->db->update('settings', $data2);

            echo 'Settings updated successfully';
        } else {
            $data['fb_api_id'] = $this->db->get_where('settings', array('code' => 'SITE_FB_API_ID'))->row()->string_value;
            $data['fb_api_secret'] = $this->db->get_where('settings', array('code' => 'SITE_FB_API_SECRET'))->row()->string_value;
            $data['message_element'] = "backend/social/fb_settings";
            $this->load->view('backend/admin_template', $data);
        }
    }

    public function google_settings() {
        if ($this->input->post('update')) {
            $data['string_value'] = $this->input->post('gmap_api_key');
            $this->db->where('code', 'SITE_GMAP_API_KEY');
            $this->db->update('settings', $data);

            echo 'Settings updated successfully';
        } else {
            $data['gmap_api_key'] = $this->db->get_where('settings', array('code' => 'SITE_GMAP_API_KEY'))->row()->string_value;
            $data['message_element'] = "backend/social/google_settings";
            $this->load->view('backend/admin_template', $data);
        }
    }

}

?>