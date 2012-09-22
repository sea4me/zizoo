<?php

/**
 * DROPinn Trips Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		Dropinn
 * @subpackage	Controllers
 * @category	Trips
 * @author		Cogzidel Product Team
 * @version		Version 1.5.2
 * @link		http://www.cogzidel.com

 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trips extends CI_Controller {

    public function Trips() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('cookie');

        $this->load->library('Form_validation');
        $this->load->library('DX_Auth');
        $this->load->library('session');

        $this->load->model('dx_auth/users', 'users');
        $this->load->model('Email_model');
        $this->load->model('Message_model');
        $this->load->model('Trips_model');
    }

    public function request($param = '') {
        if (isset($param)) {
            $reservation_id = $param;

            $conditions = array('reservation.id' => $reservation_id, 'reservation.userto' => $this->dx_auth->get_user_id());
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

    public function accept() {
        $reservation_id = $this->input->post('reservation_id');
        $is_block = $this->input->post('is_block');
        $comment = $this->input->post('comment');

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

        $traveler = $this->db->get_where('profiles', array('id' => $row->userby))->row();
        $host = $this->db->get_where('profiles', array('id' => $row->userto))->row();

        //Traveller Info
        if (!empty($traveler)) {
            $FnameT = $traveler->Fname;
            $LnameT = $traveler->Lname;
            $liveT = $traveler->live;
            $phnumT = $traveler->phnum;
        } else {
            $FnameT = '';
            $LnameT = '';
            $liveT = '';
            $phnumT = '';
        }

        //Host Info
        if (!empty($host)) {
            $FnameH = $host->Fname;
            $LnameH = $host->Lname;
            $liveH = $host->live;
            $phnumH = $host->phnum;
        } else {
            $FnameH = '';
            $LnameH = '';
            $liveH = '';
            $phnumH = '';
        }

        //for calendar
        if ($is_block == 'on') {
            
        }

        //Send Message Notification To Traveler
        $insertData = array(
            'list_id' => $row->list_id,
            'reservation_id' => $reservation_id,
            'userby' => $row->userto,
            'userto' => $row->userby,
            'message' => "Congratulation, Your reservation request is granted by $host_name for $list_title.",
            'created' => date('m/d/Y g:i A'),
            'message_type' => 2
        );
        $this->Message_model->sentMessage($insertData);


        $updateKey = array('id' => $reservation_id);
        $updateData = array();
        $updateData['status '] = 3;
        $this->Trips_model->update_reservation($updateKey, $updateData);

        //Send Mail To Traveller
        $email_name = 'traveler_reservation_granted';
        $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name), "{Fname}" => $FnameH, "{Lname}" => $LnameH, "{livein}" => $liveH, "{phnum}" => $phnumH);
        $this->Email_model->sendMail($traveler_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

        //Send Mail To Host
        $email_name = 'host_reservation_granted';
        $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name), "{Fname}" => $FnameT, "{Lname}" => $LnameT, "{livein}" => $liveT, "{phnum}" => $phnumT);
        $this->Email_model->sendMail($host_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

        //Send Mail To Administrator
        $email_name = 'admin_reservation_granted';
        $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($admin_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);
    }

    public function decline() {
        $reservation_id = $this->input->post('reservation_id');
        $is_block = $this->input->post('is_block');
        $comment = $this->input->post('comment');

        $admin_email = $this->dx_auth->get_site_sadmin();
        $admin_name = $this->dx_auth->get_site_title();

        $conditions = array('id' => $reservation_id);
        $row = $this->Trips_model->get_reservation($conditions)->row();

        $query1 = $this->users->get_user_by_id($row->userby);
        $traveler_name = $query1->row()->username;
        $traveler_email = $query1->row()->email;

        $query2 = $this->users->get_user_by_id($row->userto);
        $host_name = $query2->row()->username;
        $host_email = $query2->row()->email;

        $list_title = $this->db->get_where('list', array('id' => $row->list_id))->row()->title;

        //for calendar
        if ($is_block == 'on') {
            
        }

        //Send Message Notification To Traveller
        $insertData = array(
            'list_id' => $row->list_id,
            'reservation_id' => $reservation_id,
            'userby' => $row->userto,
            'userto' => $row->userby,
            'message' => "Sorry, Your reservation request is declined by $host_name for $list_title.",
            'created' => date('m/d/Y g:i A'),
            'message_type' => 2
        );
        $this->Message_model->sentMessage($insertData);
        $message_id = $this->db->insert_id();


        $updateKey = array('id' => $reservation_id);
        $updateData = array();
        $updateData['status '] = 4;
        $this->Trips_model->update_reservation($updateKey, $updateData);

        //Send Mail To Traveller
        $email_name = 'traveler_reservation_declined';
        $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name), "{comment}" => $comment);
        $this->Email_model->sendMail($traveler_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

        //Send Mail To Host
        $email_name = 'host_reservation_declined';
        $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($host_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

        //Send Mail To Administrator
        $email_name = 'admin_reservation_declined';
        $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($admin_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);
    }

    public function expire() {
        $admin_email = $this->dx_auth->get_site_sadmin();
        $admin_name = $this->dx_auth->get_site_title();

        $reservation_id = $this->input->post('reservation_id');

        $conditions = array('reservation.id' => $reservation_id);
        $row = $this->Trips_model->get_reservation($conditions)->row();

        $query1 = $this->users->get_user_by_id($row->userby);
        $traveler_name = $query1->row()->username;
        $traveler_email = $query1->row()->email;

        $query2 = $this->users->get_user_by_id($row->userto);
        $host_name = $query2->row()->username;
        $host_email = $query2->row()->email;

        $list_title = $this->db->get_where('list', array('id' => $row->list_id))->row()->title;


        //Send Message Notification
        $insertData = array(
            'list_id' => $row->list_id,
            'reservation_id' => $reservation_id,
            'userby' => $row->userto,
            'userto' => $row->userby,
            'message' => "Sorry, Your reservation request is expired by $host_name for $list_title.",
            'created' => date('m/d/Y g:i A'),
            'message_type ' => 2
        );


        $this->Message_model->sentMessage($insertData);
        $message_id = $this->db->insert_id();

        $updateKey = array('id' => $reservation_id);
        $updateData = array();
        $updateData['status '] = 2;
        $this->Trips_model->update_reservation($updateKey, $updateData);

        //Send Mail To Traveller
        $email_name = 'traveler_reservation_expire';
        $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($traveler_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

        //Send Mail To Host
        $email_name = 'host_reservation_expire';
        $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($host_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);

        //Send Mail To Administrator
        $email_name = 'admin_reservation_expire';
        $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title, "{host_name}" => ucfirst($host_name));
        $this->Email_model->sendMail($admin_email, $admin_email, ucfirst($admin_name), $email_name, $splVars);
    }

    public function conversation($param = '') {

        $this->form_validation->set_error_delimiters('<p style="clear:both;color: #FF0000;"><label>&nbsp;</label>', '</p>');
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('comment', 'Message', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {
                $insertData = array(
                    'list_id' => $this->input->post('list_id'),
                    'reservation_id' => $this->input->post('reservation_id'),
                    'userby' => $this->input->post('userby'),
                    'userto' => $this->input->post('userto'),
                    'message' => "Sorry, Your reservation request is expired by $host_name for $list_title.",
                    'created' => date('m/d/Y g:i A'),
                    'message_type ' => 3
                );

                $this->Message_model->sentMessage($insertData);
            }
        }

        if ($param == '') {
            redirect('info');
        }

        $data['conversation_id'] = $param;
        $conditions = array("messages.conversation_id" => $param, "messages.userby" => $this->dx_auth->get_user_id());
        $or_where = array("messages.userto" => $this->dx_auth->get_user_id());

        $query = $this->Message_model->get_messages($conditions, $or_where);

        if ($query->num_rows() == 0) {
            redirect('info');
        }

        $condition = array("messages.conversation_id" => $param);
        $orderby = array('created', "DESC");
        $result = $data['messages'] = $this->Message_model->get_messages($condition, NULL, $orderby);
        $row = $result->row();

        if ($row->userby == $this->dx_auth->get_user_id()) {
            $coversation_userID = $row->userto;
        } else {
            $coversation_userID = $row->userby;
        }

        $data['list_id'] = $row->list_id;
        $data['reservation_id'] = $row->reservation_id;

        $data['conv_userData'] = get_user_by_id($coversation_userID);

        $data['title'] = "Coversations";
        $data['message_element'] = 'trips/view_conversation';
        $this->load->view('template', $data);
    }

    public function send_message($param = '') {
        if ($param == '') {
            redirect('info');
        }
        $userby = $this->dx_auth->get_user_id();
        $userto = $param;
        $query = $this->db->query("SELECT * FROM `messages` WHERE (`userby` >= '" . $userby . "' AND `userto` <='" . $userto . "') OR (`userby` >= '" . $userto . "' AND `userto` <='" . $userby . "')");
        $row = $query->row();

        $conversation_id = $row->conversation_id;
        redirect('trips/conversation/' . $conversation_id);
    }

}

?>