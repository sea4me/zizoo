<?php

/**
 * DROPinn Travelling Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		Dropinn
 * @subpackage	Controllers
 * @category	Travelling
 * @author		Cogzidel Product Team
 * @version		Version 1.5.2
 * @link		http://www.cogzidel.com

 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Travelling extends CI_Controller {

    public function Travelling() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->helper('form');

        $this->load->library('DX_Auth');
        $this->load->library('session');
        $this->load->library('form_validation');

        $this->load->model('Trips_model');
        $this->load->model('Email_model');
        $this->load->model('Message_model');
    }

    //Current Trips
    public function current_trip() {
        if ($this->dx_auth->is_logged_in()) {
            $cur_user_id = $this->dx_auth->get_user_id();
            $conditions = array("reservation.userby" => $cur_user_id, "reservation.status" => 7);
            $data['result'] = $this->Trips_model->get_reservation_trips($conditions);

            $data['title'] = "Your Current Trips";
            $data['message_element'] = "travelling/view_current_trips";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    //Upcomming Trips
    public function upcomming_trips() {

        if ($this->dx_auth->is_logged_in()) {
            $cur_user_id = $this->dx_auth->get_user_id();
            $conditions = array("reservation.userby" => $cur_user_id, "reservation.status >=" => 1, "reservation.status <" => 7);
            $data['result'] = $this->Trips_model->get_reservation_trips($conditions);

            $data['title'] = "Your Upcomming Trips";
            $data['message_element'] = "travelling/view_upcomming_trips";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    //Previous Trips
    public function previous_trips() {

        if ($this->dx_auth->is_logged_in()) {

            $cur_user_id = $this->dx_auth->get_user_id();
            $conditions = array("reservation.userby" => $cur_user_id, "reservation.status >=" => 8);
            $data['result'] = $this->Trips_model->get_reservation_trips($conditions);

            $data['title'] = "Your Previous Trips Trips";
            $data['message_element'] = "travelling/view_previous_trips";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    // Starred Item
    public function starred_items() {
        $starred = $this->input->get('starred');
        if ($starred == 'true')
            $data['starred'] = $starred;
        $data['title'] = "List your stared Item";
        $data['message_element'] = "travelling/view_starred_list";
        $this->load->view('template', $data);
    }

    public function host_details($param = '') {
        $data['title'] = "Host Details";
        $data['message_element'] = "travelling/view_host_details";
        $this->load->view('template', $data);
    }

    public function billing($param = '') {
        if (isset($param)) {
            $reservation_id = $param;

            $conditions = array('reservation.id' => $reservation_id, 'reservation.userby' => $this->dx_auth->get_user_id());
            $result = $this->Trips_model->get_reservation($conditions);

            if ($result->num_rows() == 0) {
                redirect('info');
            }

            $data['result'] = $result->row();
            $list_id = $data['result']->list_id;
            $no_quest = $data['no_quest'] = $data['result']->no_quest;

            $x = $this->db->get_where('price', array('id' => $list_id));
            $data['per_night'] = $price = $x->row()->night;

            $ckin = explode('/', $data['result']->checkin);
            $ckout = explode('/', $data['result']->checkout);

            $diff = strtotime($ckout[2] . '-' . $ckout[0] . '-' . $ckout[1]) - strtotime($ckin[2] . '-' . $ckin[0] . '-' . $ckin[1]);
            $data['nights'] = $days = ceil($diff / (3600 * 24));

            $amt = $price * $days * $no_quest;
            $data['subtotal'] = $amt;

            $data['commission'] = 0;
            //check admin premium condition and apply so for
            $query = $this->db->get_where('paymode', array('id' => 3));
            $row = $query->row();
            if ($row->is_premium == 1) {
                if ($row->is_fixed == 1) {
                    $fix = $row->fixed_amount;
                    $amt = $amt - $fix;
                    $data['commission'] = $amt;
                } else {
                    $per = $row->percentage_amount;
                    $camt = floatval(($amt * $per) / 100);
                    $amt = $amt - $camt;
                    $data['commission'] = $camt;
                }
            } else {
                $amt = $amt;
            }

            $data['total_payout'] = $amt;

            $data['title'] = "Reservation Request";
            $data['message_element'] = 'trips/request';
            $this->load->view('template', $data);
        } else {
            redirect('info');
        }
    }

    public function cancel_travel($params1 = '', $params2 = '') {
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
            $updateData['status '] = 6;
            $this->Trips_model->update_reservation($updateKey, $updateData);

            //Send Mail To Traveller
            $email_name = 'host_reservation_cancel';
            $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
            $this->Email_model->sendMail($traveler_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

            //Send Mail To Host
            $email_name = 'traveler_reservation_cancel';
            $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
            $this->Email_model->sendMail($host_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

            //Send Mail To Administrator
            $email_name = 'admin_reservation_cancel';
            $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
            $this->Email_model->sendMail($admin_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);
        } else {
            $conditions = array('reservation.id' => $params1);
            $row = $this->Trips_model->get_reservation($conditions)->row();

            $checkin = explode('/', $row->checkin);
            $checkout = explode('/', $row->checkout);

            $diff1 = strtotime($checkout[2] . '-' . $checkout[0] . '-' . $checkout[1]) - strtotime($checkin[2] . '-' . $checkin[0] . '-' . $checkin[1]);
            $days1 = ceil($diff1 / (3600 * 24));

            $diff2 = strtotime(date('Y-m-d')) - strtotime($checkin[2] . '-' . $checkin[0] . '-' . $checkin[1]);
            $days2 = ceil($diff2 / (3600 * 24));

            $data['nights'] = $days1;
            $data['non_nights'] = $days2;

            $data['reservation_id'] = $params1;
            $data['list_id'] = $params2;
            $this->load->view('travelling/view_cancel_travel', $data);
        }
    }

    public function checkin($param = '') {
        if ($this->input->post('checkin')) {
            $reservation_id = $this->input->post('reservation_id');
            $updateKey = array('id' => $reservation_id);
            $updateData = array();
            $updateData['status '] = 7;
            $this->Trips_model->update_reservation($updateKey, $updateData);

            redirect('travelling/current_trip');
        }

        $data['reservation_id'] = $param;
        $this->load->view('travelling/view_checkin', $data);
    }

    public function checkout($param = '') {
        if ($this->input->post('checkout')) {
            $reservation_id = $this->input->post('reservation_id');

            $updateKey = array('id' => $reservation_id);
            $updateData = array();
            $updateData['status '] = 8;
            $this->Trips_model->update_reservation($updateKey, $updateData);

            $conditions = array('reservation.id' => $reservation_id);
            $row = $this->Trips_model->get_reservation($conditions)->row();

            $username = ucfirst($this->dx_auth->get_username());

            $insertData = array(
                'list_id' => $row->list_id,
                'reservation_id' => $reservation_id,
                'userby' => $row->userby,
                'userto' => $row->userto,
                'message' => "$username wants the review from you.",
                'created' => date('m/d/Y g:i A'),
                'message_type ' => 4
            );

            $this->Message_model->sentMessage($insertData);

            redirect('travelling/previous_trips');
        }

        $data['reservation_id'] = $param;
        $this->load->view('travelling/view_checkout', $data);
    }

}

?>