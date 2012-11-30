<?php

/**
 * DROPinn Info Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		Info
 * @subpackage	Controllers
 * @category	Info
 * @author		Cogzidel Product Team
 * @version		Version 1.1
 * @link		http://www.cogzidel.com

 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Info extends CI_Controller {

    public function Info() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('DX_Auth');
        $this->load->library('session');
        $this->load->helper('cookie');
    }

    public function index() {
        $data['title'] = "Access Deny";
        $data['message_element'] = 'view_deny';
        $this->load->view('template', $data);
    }

    public function deny() {
        $data['title'] = "Access Deny";
        $data['message_element'] = 'view_deny';
        $this->load->view('template', $data);
    }

    public function success() {
        $data['title'] = $this->dx_auth->get_site_title();
        $data['message_element'] = 'view_success';
        $this->load->view('template', $data);
    }

    public function how_it_works() {

        $data['display_type'] = $this->db->get_where('settings', array('code' => 'HOW_IT_WORKS'))->row()->int_value;
        $data['media'] = $this->db->get_where('settings', array('code' => 'HOW_IT_WORKS'))->row()->string_value;
        $data['embed_code'] = $this->db->get_where('settings', array('code' => 'HOW_IT_WORKS'))->row()->text_value;

        $data['title'] = 'How ' . $this->dx_auth->get_site_title() . ' Works';
        $data['message_element'] = 'view_howit';
        $this->load->view('template', $data);
    }

}

?>