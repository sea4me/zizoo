<?php

/**
 * DROPinn Hosting Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		Dropinn
 * @subpackage	Controllers
 * @category	Hosting
 * @author		Cogzidel Product Team
 * @version		Version 1.5.2
 * @link		http://www.cogzidel.com

 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hosting extends CI_Controller {

    public function Hosting() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->helper('form');

        $this->load->library('DX_Auth');
        $this->load->library('session');
        $this->load->library('form_validation');

        $this->load->model('Trips_model');
    }

    public function index() {
        if (($this->dx_auth->is_logged_in()) || ($this->facebook->logged_in())) {
            $data['title'] = "Your Hosting data";
            $data['message_element'] = "hosting/view_hosting";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    public function my_reservation() {
        if (($this->dx_auth->is_logged_in()) || ($this->facebook->logged_in())) {
            $conditions = array('userto' => $this->dx_auth->get_user_id(), 'status >=' => 3);
            $data['result'] = $this->Trips_model->get_reservation($conditions);

            $data['title'] = "Edit your Profile";
            $data['message_element'] = "hosting/view_myreservation";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    public function cancel_host($params1 = '', $params2 = '') {
        if ($this->input->post('reservation_id')) {
            $reservation_id = $this->input->post('reservation_id');

            $admin_email = $this->dx_auth->get_site_sadmin();
            $admin_name = $this->dx_auth->get_site_title();

            $conditions = array('reservation.id' => $reservation_id);
            $row = $this->Trips_model->get_reservation($conditions)->row();

            $query1 = $this->users->get_user_by_id($row->userby);
            $traveler_name = $query1->row()->username;
            $traveler_email = $query1->row()->email;

            $query2 = $this->users->get_user_by_id($row->userto);
            $host_name = $query2->row()->username;
            $host_email = $query2->row()->email;

            $list_title = $this->db->get_where('list', array('id' => $row->list_id))->row()->title;

            $updateKey = array('id' => $reservation_id);
            $updateData = array();
            $updateData['status '] = 5;
            $this->Trips_model->update_reservation($updateKey, $updateData);

            //Send Mail To Traveller
            $email_name = 'traveler_reservation_cancel';
            $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
            $this->Email_model->sendMail($traveler_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

            //Send Mail To Host
            $email_name = 'host_reservation_cancel';
            $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
            $this->Email_model->sendMail($host_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

            //Send Mail To Administrator
            $email_name = 'admin_reservation_cancel';
            $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
            $this->Email_model->sendMail($admin_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);
        } else {
            $data['reservation_id'] = $params1;
            $data['list_id'] = $params2;
            $this->load->view('hosting/view_cancel_host', $data);
        }
    }

    public function policies() {
        if (($this->dx_auth->is_logged_in()) || ($this->facebook->logged_in())) {
            $data['title'] = "your standbys";
            $data['message_element'] = "hosting/view_policies";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

}

?>