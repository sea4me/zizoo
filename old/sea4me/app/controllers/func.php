<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Func extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    //Constructor

    public function Func() {
        parent::__construct();

        $this->load->library('DX_Auth');
        $this->load->library('Form_validation');
        $this->load->library('session');
        $this->load->library('email');

        $this->load->helper('form');
        $this->load->helper('url');

        $this->load->model('Email_model');
        $this->load->model('Message_model');
        $this->load->model('Trips_model');
    }

    public function addNewEntry() {
        $data['user_id'] = $this->dx_auth->get_user_id();
        $data['address'] = $this->input->post("formatAddress");
        $data['exact'] = $this->input->post("exact_address");

        if ($data['exact'] == "yes")
            $data['directions'] = NULL;
        else
            $data['directions'] = $this->input->post("directions");

        $data['lat'] = $this->input->post("lat");
        $data['long'] = $this->input->post("lng");


        $data['property_id'] = $this->input->post('property_id'); // needs new type of table to keep track of this

        $data['room_type'] = $this->input->post("room_type");

        $data['bedrooms'] = $this->input->post("bedrooms");

        $data['title'] = $this->input->post("Hname");

        $data['desc'] = $this->input->post("desc");

        $data['capacity'] = $this->input->post('capacity');
        $data['roomtype'] = $this->input->post('room_type');
        $data['price'] = $this->input->post("native_price");

        $data['currency'] = $this->input->post('native_currency');
        $data['email'] = $this->input->post("email");
        $data['phone'] = $this->input->post("phone");


        $this->db->insert('list', $data);

        //Getting the info just entered
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('title', $data['title']);
        $this->db->where('desc', $data['desc']);

        $query = $this->db->get('list');

        $q = $query->result();

        $data2['id'] = $q[0]->id;
        $data2['night'] = $data['price'];
        $data2['currency'] = $data['currency'];
        $this->db->insert('price', $data2);

        $data3['id'] = $q[0]->id;
        $this->db->insert('amnities', $data3);

        $query = $this->db->get_where('paymode', array('id' => 1));
        $row = $query->row();

        if ($row->is_premium == 1) {
            $data4['status'] = 0;
            $this->db->where('id', $data2['id']);
            $this->db->update('list', $data4);

            $query = $this->db->get_where('paymode', array('id' => 1));
            $row = $query->row();

            $this->session->set_userdata('amount', $row->fixed_amount);
            $this->session->set_userdata('Lid', $data2['id']);

            redirect('listpay');
        } else {
            //Redirect to page
            redirect('rooms/' . $data2['id'], 'refresh');
        }
    }

    public function editConfirm($room_id) {
        $res = $this->db->get_where('list', array('id' => $room_id));
        $title = $res->row()->title;
        $page_viewed = $res->row()->page_viewed;

        $data['page_viewed'] = $this->Trips_model->update_pageViewed($room_id, $page_viewed);

        $id = $this->uri->segment(3);
        $this->load->model('Gallery');
        $data['images'] = $this->Gallery->get_images($room_id);

        $conditions = array('list_id' => $room_id, 'userto' => $res->row()->user_id);
        $data['result'] = $this->Trips_model->get_review($conditions);

        $conditions = array('list_id' => $room_id, 'userto' => $res->row()->user_id);

        $data['title'] = substr($title, 0, 70);
        $data['message_element'] = "view_edit_confirm";
        $data['room_id'] = $room_id;
        $data['amnities'] = $this->db->get('amnities');

        $this->load->view('template', $data);
    }

    public function search() {
        $star = $this->input->get('starred');
        //get starred list status

        $this->load->model('Gallery');
        $data['message_element'] = 'view_search_result';
        $data['title'] = "Search Elements";
        $query = $this->input->post('location');
        $pieces = explode(",", $query);
        $data['pieces'] = $pieces;
        $print = "";
        $len = count($pieces);
        $count = 0;
        $sno = 1;
        foreach ($pieces as $test) {
            $this->db->flush_cache();
            $test = $this->db->escape_like_str($test);
            $this->db->like('address', $test);
            for ($i = 0; $i < $count; $i++) {
                $this->db->not_like('address', $pieces[$i]);
            }
            //Exececute the query
            $this->db->where('starred', $star); //get strrared record
            $data['query'] = $this->db->get('list');
            foreach ($data['query']->result() as $row) {
                $images = $this->Gallery->get_images($row->id);
                if (count($images) == 0)
                    $url = 'http://d3mjr4yb15zzlp.cloudfront.net/pictures/404802/small.jpg';
                else
                    $url = $images[0]['url'];

                $print .= '<div style="height:105px;overflow:visible;display:inline;"><li style="margin-top:10px;display:block;min-height:105px;_height:150px;" class="search_result" id="' . $row->id . '">';
                $print .= '<div class="pop_image_small">
                <div class="map_number">' . $sno . '</div>
                <a class="image_link" href="' . base_url() . 'func/editConfirm/' . $row->id . '" linkindex="98"><img width="639" height="426" title="ZEN TAO" src="' . $url . '" class="search_thumbnail"></a> 
           	</div>';
                $print .= '<div class="room_details">
                <h2 class="room_title">                  
			                <a href="' . base_url() . 'func/editConfirm/' . $row->id . '" class="name" linkindex="100">' . $row->title . '</a>                  
                 <!--<a href="' . base_url() . 'func/starred/?star=' . $row->id . '"><img src="' . base_url() . 'images/star.jpg" height=25 width=25></a>--> </h2>';
                $print .='<div class="address">' . $row->address . '</div>';
                $print .='<ul class="reputation"></ul>            
			</div>            
					<div class="price">                
					  	
					<div class="price_data">
							<!--<sup class="currency_if_required"></sup>-->
                    			<div class="currency_with_sup"><sup>$</sup>' . $row->price . '</div>
                    			
        				</div>  
        				<div lass="price_modifier">Per night</div>              
						          
					</div>        
			</li></div>';
                $sno++;
            }
            $count++;
        }
        $data['print'] = $print;
        $data['query'] = $query;
        $this->load->view('template', $data);
    }

    public function dashboard() {
        if (($this->dx_auth->is_logged_in())) {
            $data['title'] = "Your Dashboard";
            $data['message_element'] = "view_dashboard";




            $conditions = array("messages.userto" => $this->dx_auth->get_user_id());
            $data['new_notify'] = $this->Message_model->get_messages($conditions);

            $conditions = array("messages.userto" => $this->dx_auth->get_user_id(), "messages.is_read" => 0);
            $data['new_notify_rows'] = $this->Message_model->get_messages($conditions)->num_rows();

            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    public function editListing() {
        if ($this->dx_auth->is_logged_in()) {

            $data['title'] = "Edit your Listing";
            $data['message_element'] = "view_edit_listing";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    public function photoListing() {
        $data['title'] = "Add photo for this listing";
        $data['message_element'] = "view_list_photo";
        $this->load->view('template', $data);
    }

    public function standbys() {
        if ($this->dx_auth->is_logged_in()) {

            $data['title'] = "your standbys";
            $data['message_element'] = "view_standbys";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    public function points() {
        if ($this->dx_auth->is_logged_in()) {

            $data['title'] = "Know your Rank";
            $data['message_element'] = "view_points";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    public function promote() {
        if ($this->dx_auth->is_logged_in()) {
            $data['title'] = "your standbys";
            $data['message_element'] = "view_promote";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    public function edituserprofile() {
        if ($this->dx_auth->is_logged_in()) {

            $data['title'] = "Edit your Profile";
            $data['message_element'] = "view_edit_profile";
            $this->load->view('template', $data);
        } else {
            redirect('/home/signin');
        }
    }

    public function update() {
        $data = array(
            'property_id' => $this->input->post('property_id'),
            'room_type' => $this->input->post('room_type'),
            'desc' => $this->input->post('desc'),
            'capacity' => $this->input->post('capacity'),
            'bedrooms' => $this->input->post('bedrooms')
        );

        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('list', $data);



        $data2 = array(
            'kitchen' => $this->input->post('kitchen'),
            'doorman' => $this->input->post('doorman'),
            'gym' => $this->input->post('gym'),
            'washer' => $this->input->post('washer'),
            'parking' => $this->input->post('parking'),
            'elevator' => $this->input->post('elevator'),
            'handicap' => $this->input->post('handicap'),
            'pool' => $this->input->post('pool'),
            'hottub' => $this->input->post('hottub'),
            'fireplace' => $this->input->post('fireplace'),
            'breakfast' => $this->input->post('breakfast'),
            'kids' => $this->input->post('kids'),
            'events' => $this->input->post('events'),
            'smoking' => $this->input->post('smoking'),
            'pets' => $this->input->post('pets'),
            'tv' => $this->input->post('tv'),
            'cable' => $this->input->post('cable'),
            'internet' => $this->input->post('internet'),
            'wireless' => $this->input->post('wireless'),
            'ac' => $this->input->post('ac'),
            'heating' => $this->input->post('heating'),
            'manual' => $this->input->post('manual')
        );
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('amnities', $data2);


        redirect('func/editlisting/' . $this->uri->segment(3), 'refresh');
    }

    public function updatepricing() {
        $data = array(
            'currency' => $this->input->post('currency'),
            'night' => $this->input->post('nightly'),
            'week' => $this->input->post('weekly'),
            'month' => $this->input->post('monthly'),
            'addguests' => $this->input->post('extra'),
            'security' => $this->input->post('security'),
            'cleaning' => $this->input->post('cleaning')
        );

        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('price', $data);

        redirect('func/editpricing/' . $this->uri->segment(3), 'refresh');
    }

    public function editpricing() {
        if ($this->dx_auth->is_logged_in()) {
            $data['title'] = "Edit the price information for your site";
            $data['message_element'] = 'view_pricing';
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    //Stared List
    public function starred() {
        if ($this->dx_auth->is_logged_in()) {
            $star = $this->input->get('star');
            $this->db->where('id', $star);
            $this->db->select('starred');
            $status = $this->db->get('list');
            $str_status = $status->first_row();
            $star_mark = $str_status->starred;
            if ($star_mark == 'false') {
                $data['starred'] = 'true';
                $this->db->update('list', $data, array('id' => $star));
            } else {
                $data['starred'] = 'false';
                $this->db->update('list', $data, array('id' => $star));
            }
            redirect('func/search/' . $this->uri->segment(3), 'refresh');
        } else {
            redirect('home/signin');
        }
    }

    public function dateconvert($date) {
        $ckout = explode('/', $date);
        $diff = $ckout[2] . '-' . $ckout[0] . '-' . $ckout[1];
        return $diff;
    }

    public function searchbydate() {
        //get starred list status		
        $star = $this->input->get('starred');
        //Get the checkin and chekout dates
        $checkin = '';
        $checkout = '';
        $stack = array();
        $room_types = array();
        $checkin = $this->input->post('checkin');
        $checkout = $this->input->post('checkout');
        $nof_guest = $this->input->post('number_of_guests');
        $room_types = $this->input->post('room_types');
        $min = $this->input->post('min');
        $max = $this->input->post('max');

        $array_items = array(
            'Vcheckin' => '',
            'Vcheckout' => '',
            'Vcheckout' => '',
        );
        $this->session->unset_userdata($array_items);

        if ($this->input->post('checkin') != '' || $this->input->post('checkin') != 'mm/dd/yy') {
            $freshdata = array(
                'Vcheckin' => $this->input->post('checkin'),
                'Vcheckout' => $this->input->post('checkout'),
                'Vnumber_of_guests' => $this->input->post('number_of_guests'),
            );
            $this->session->set_userdata($freshdata);
        }



        if ($checkin != '--' && $checkout != '--' && $checkin != "yy-mm-dd" && $checkout != "yy-mm-dd") {
            $ans = $this->db->query("SELECT id,list_id FROM `calendar` WHERE `booked_days` = '" . $checkin . "' OR `booked_days` = '" . $checkout . "' GROUP BY `list_id`");
            $this->db->flush_cache();
            // Now after the checkin is completed
            if (!empty($a)) {
                foreach ($a as $a1) {
                    array_push($stack, $a1->list_id);
                }
            }
        }

        $this->load->model('Gallery');
        $data['message_element'] = 'view_search_result';
        $data['title'] = "Search Elements";
        $query = $this->input->post('location');
        $pieces = explode(",", $query);
        $data['pieces'] = $pieces;
        $print = "";
        $len = count($pieces);
        $count = 0;
        $sno = 1;
        foreach ($pieces as $test) {
            $this->db->flush_cache();
            $test = $this->db->escape_like_str($test);
            $this->db->like('address', $test);

            for ($i = 0; $i < $count; $i++) {
                $this->db->not_like('address', $pieces[$i]);
            }

            if (!empty($stack)) {
                $this->db->where_not_in('id', $stack);
            }

            if ($nof_guest > 1) {
                $this->db->where('capacity', $nof_guest);
            }

            if (!empty($star)) {
                $this->db->where('starred', $star);
            }

            if (is_array($room_types)) {
                if (count($room_types) > 0) {
                    foreach ($room_types as $r) {
                        $this->db->where('room_type', $r);
                    }
                }
            }

            if (isset($min)) {
                if ($min > 0) {
                    $this->db->where('price >=', $min);
                }
            } else {
                if (isset($max)) {
                    $min = 0;
                }
            }

            if (isset($max)) {
                if ($max > $min) {
                    $this->db->where('price <=', $max);
                }
            }

            $this->db->where('status !=', 0);

            //Exececute the query
            $data['query'] = $this->db->get('list');
            foreach ($data['query']->result() as $row) {
                $images = $this->Gallery->get_images($row->id);
                if (count($images) == 0)
                    $url = base_url() . 'images/no_image.jpg';
                else
                    $url = $images[0]['url'];

                $print .= '<div style="height:105px;overflow:visible;display:inline;"><li style="margin-top:10px;display:block;min-height:105px;_height:150px;" class="search_result" id="' . $row->id . '">';
                $print .= '<div class="pop_image_small">
                <div class="map_number">' . $sno . '</div>
                <a class="image_link" href="' . base_url() . 'rooms/' . $row->id . '" linkindex="98"><img width="639" height="426" title="ZEN TAO" src="' . $url . '" class="search_thumbnail"></a> 
           	</div>';
                $print .= '<div class="room_details">
                <h2 class="room_title">                  
			</p><a href="' . base_url() . 'rooms/' . $row->id . '" class="name" linkindex="100">' . $row->title . '</a>                  
                </h2> <!--<a href="' . base_url() . 'func/starred/?star=' . $row->id . '"><img src="' . base_url() . 'images/star.png" height=25 width=25></a>--></p>';
                $print .='<p class="address">' . $row->address . '</p>';
                $print .='<ul class="reputation"></ul>            
			</div>            
					<div class="price">                
					  	
					<div class="price_data">
							<!--<sup class="currency_if_required"></sup>-->
                    			<div class="currency_with_sup"><sup>$</sup>' . $row->price . '</div>
                    			
        				</div>  
        				<div lass="price_modifier">Per night</div>              
						          
					</div>        
			</li></div>';
                $sno++;
            }
            $count++;
        }
        $data['print'] = $print;
        $data['query'] = $query;
        $data['checkin'] = $this->input->post('checkin');
        $data['checkout'] = $this->input->post('checkout');
        $data['number_of_guests'] = $this->input->post('number_of_guests');
        $data['room_types'] = $room_types;
        $data['min'] = $min;
        $data['max'] = $max;

        $this->load->view('template', $data);
    }

    public function deletelisting() {
        if ($this->dx_auth->is_logged_in()) {
            $id = $this->uri->segment(3);
            $this->db->delete('list', array('id' => $id));
            $this->db->delete('price', array('id' => $id));
            $this->db->delete('amnities', array('id' => $id));
            redirect('func/hosting/' . $id, 'refresh');
        } else {
            redirect('home/signin');
        }
    }

    public function account() {

        if ($this->dx_auth->is_logged_in()) {

            $data['title'] = "Edit Account details";
            $data['message_element'] = "view_account";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

//Notification
    # Choosing option to send or denay mail and notification

    public function notification() {
        if ($this->dx_auth->is_logged_in()) {

            $data['title'] = "Edit Account details";
            $data['message_element'] = "view_notification";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

//Payout Preferences
    public function payout() {
        if ($this->dx_auth->is_logged_in()) {

            if ($this->input->post()) {
                $data['country'] = $this->input->post('country');
                $data['payout_type'] = $this->input->post('payout_type');
                $data['email'] = $this->input->post('email');
                $data['currency'] = $this->input->post('currency');
                $this->db->insert('payout_preferences', $data);
            }


            $data['title'] = "Your Payment Method details";
            $data['message_element'] = "view_payout";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    public function payoutMethod() {
        if ($this->dx_auth->is_logged_in()) {
            $country = $this->input->post('country');
            $data['country'] = $country;
            $data['title'] = "Your Payment Method details";
            $data['message_element'] = "view_payout_method";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    public function paypalInfo() {
        if ($this->dx_auth->is_logged_in()) {
            $country = '';
            $payout_type = '';
            if ($this->input->post()) {
                $country = $this->input->post('country');
                $payout_type = $this->input->post('payout_type');
            }
            $data['payout_type'] = $payout_type;
            $data['country'] = $country;
            $data['title'] = "Your Payment Method details";
            $data['message_element'] = "view_paypal_info";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    public function setDefault() {
        if ($this->dx_auth->is_logged_in()) {
            if ($this->input->post('default_email')) {
                //unset the previous default email
                $this->db->where("default_email", "default");
                $unset_default_email['default_email'] = '';
                $this->db->update('payout_preferences', $unset_default_email);

                //set new default email	 
                $default_email = $this->input->post('default_email');
                $data['default_email'] = "default";
                $this->db->where('email', $default_email);
                $this->db->update('payout_preferences', $data);
            }

            $data['title'] = "Set Default Payout Preferences";
            $data['message_element'] = "view_payout";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    //Payout Preferences
    #	Once you have reservations
    #   The money that you have earned will be displayed here.
    public function transaction() {
        if ($this->dx_auth->is_logged_in()) {

            $data['title'] = "Your Transaction details";
            $data['message_element'] = "view_transaction";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    //Recommentaion
    #	Reviews are allowed only at the end of a trip booked through dropinn.
    #	Recommendations are earned by inviting your friends to vouch for you.
    public function recommendation() {
        if ($this->dx_auth->is_logged_in()) {
            $username = $this->dx_auth->get_username();
            $user_id = $this->dx_auth->get_user_id();
            if ($this->input->post()) {
                $share_url = $this->input->post('share_url');
                $email = $this->input->post('emal_to_friend');
                $mail_list = explode(',', $email);

                $admin_email = $this->dx_auth->get_site_sadmin();

                $email_name = 'user_vouch';

                $mailer_mode = $this->db->get_where('email_settings', array('code' => 'MAILER_MODE'))->row()->value;

                if ($mailer_mode == 'html')
                    $anchor = anchor('func/vouch?id=' . $user_id, 'Click here');
                else
                    $anchor = site_url('func/vouch?id=' . $user_id);

                $splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{username}" => ucfirst($username), "{click_here}" => $anchor);


                if (!empty($mail_list)) {
                    foreach ($mail_list as $email_to) {
                        if ($this->email->valid_email($email_to)) {
                            //Send Mail
                            $this->Email_model->sendMail($email_to, $admin_email, $this->dx_auth->get_site_title(), $email_name, $splVars);
                        } else {
                            $data['email_status'][] = $email_to;
                        }
                    }
                }
            }
            $data['title'] = "Your Transaction details";
            $data['message_element'] = "view_recommendations";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    //Recommend your Friends
    # Your friends can Recomend you when you invite them
    public function vouch() {


        if ($this->dx_auth->is_logged_in()) {

            if (!$this->dx_auth->is_logged_in()) {
                redirect('home/signup/');
            }
            //Insert the Recommendation detial
            if ($this->input->post()) {
                $data['user_id'] = $this->input->post('usr_id');
                $data['friend_id'] = $this->input->post('frnd_id');
                $data['friend_name'] = $this->dx_auth->get_username();
                $data['message'] = $this->input->post('message');
                $this->db->insert('recommends', $data);
                redirect('func/dashboard/' . $this->dx_auth->get_user_id(), 'refresh');
            }


            $data['title'] = "Recommend your friends";
            $data['message_element'] = "view_vouch";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    //Delete the Friends Recommend
    public function deleteRecommend() {

        if ($this->dx_auth->is_logged_in()) {

            if ($this->input->get('dlt')) {
                $friend_id = $this->input->get('dlt');
                $user_id = $this->input->get('id');
                $this->db->where("friend_id", $friend_id);
                $this->db->where("user_id", $user_id);
                $this->db->delete('recommends');
                redirect('func/vouch?id=' . $user_id, 'refresh');
            }
        } else {
            redirect('home/signin');
        }
    }

    //Setting
    public function emailSetting() {
        if ($this->dx_auth->is_logged_in()) {
            $data['offers'] = $this->input->post('offers');
            $data['news'] = $this->input->post('news');
            $data['upcoming_reservation'] = $this->input->post('upcoming_reservation');
            $data['new_review'] = $this->input->post('new_review');
            $data['leave_review'] = $this->input->post('leave_review');
            $data['standby'] = $this->input->post('standby');
            $data['update_calendar'] = $this->input->post('pdate_calendar');

            //insert the data
            $this->db->insert('user_settings', $data);

            $data['title'] = "Your Email Settings";
            $data['message_element'] = "view_account";
            $this->load->view('template', $data);
        } else {
            redirect('home/signin');
        }
    }

    public function reserve() {
        $user = $this->dx_auth->get_user_id();
        $this->db->where('user_id', $user);
        $this->db->select('id');
        $query = $this->db->get('list');
        $q1 = $query->result();
        $output = "";
        $a1 = array();
        foreach ($q1 as $q) {
            array_push($a1, $q->id);
        }
        if (count($a1) > 0) {
            $this->db->flush_cache();
            $this->db->where_in('id', $a1);
            $b1 = $this->db->get('reservation');
            $this->db->flush_cache();
            if ($b1->num_rows() > 0) {
                $b2 = $b1->result();
                foreach ($b2 as $b) {
                    $output = 'Reserved From : ' . $b->from . '<br />';
                    $output .= 'Reserved to : ' . $b->to . '<br />';
                    $output .= 'Total Price : ' . $b->price . '<br /><hr />';
                }
            }
        }
        $data['output'] = $output;
        $data['message_element'] = 'view_reserve';
        $data['title'] = "Reservation Details";
        $this->load->view('template', $data);
    }

    public function confirmpay() {
        $data['title'] = "Confirm your booking";
        $data['message_element'] = "view_inter_book";
        $this->load->view('template', $data);
    }

}