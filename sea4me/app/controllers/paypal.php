<?php
/**
 * PayPal_Lib Controller Class (Paypal IPN Class)
 *
 * Paypal controller that provides functionality to the creation for PayPal forms, 
 * submissions, success and cancel requests, as well as IPN responses.
 *
 * The class requires the use of the PayPal_Lib library and config files.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Commerce
 * @author      Ran Aroussi <ran@aroussi.com>
 * @copyright   Copyright (c) 2006, http://aroussi.com/ci/
 *
 */

class Paypal extends CI_Controller {

	function Paypal()
	{
		parent::__construct();
		
		$this->load->library('Paypal_Lib');

		$this->load->library('DX_Auth');  
		$this->load->library('session');
		$this->load->library('email');
		
		$this->load->helper('url');
			
		$this->load->model('dx_auth/users', 'users');
		
		$this->load->model('Email_model');
		$this->load->model('Message_model');
        
	}
	
	function index()
	{
			if( (!$this->dx_auth->is_logged_in()) && (!$this->facebook->logged_in()) )
			{
						$newdata = array(
						        'list_id'                 => $this->uri->segment(3),
														'Lcheckin'                => $this->input->post('checkin'),
														'Lcheckout'               => $this->input->post('checkout'),
														'number_of_guests'					   => $this->input->post('number_of_guests'),
														'formCheckout'            => TRUE
										);
      $this->session->set_userdata($newdata);
							
					 redirect('home/signin','refresh');
			}
			
		  $this->form();

	}
	
	
	function form()
	{
	 if($this->session->userdata('formCheckout'))
		{
		 $checkin        = $this->session->userdata('Lcheckin');
  	$checkout       = $this->session->userdata('Lcheckout');
	  $data['guests'] = $this->session->userdata('number_of_guests');
		}
  else
		{
		$checkin        = $this->input->post('checkin');
		$checkout       = $this->input->post('checkout');
		$data['guests'] = $this->input->post('number_of_guests');
		}
		
		
		$data['checkin'] = $checkin;
		$data['checkout'] = $checkout;
		$ckin = explode('/', $checkin);
		$ckout = explode('/', $checkout);
//		print_r($ckout);
		$pay = $this->db->get_where('paywhom',array('id' => 1));
		$paywhom = $pay->result();
		$paywhom = $paywhom[0]->whom;
		$id = $this->uri->segment(3);
		
		if($ckin[0] == "mm")
		{
			//echo "Sorry not a valid date";
			redirect('rooms/'.$id, "refresh");
		} 
		if($ckout[0] == "mm") 
		{
			//echo "Sorry not a valid date";
			redirect('rooms/'.$id, "refresh");
		}
		
		$x = $this->db->get_where('price',array('id' => $this->uri->segment(3)));
		$x1 = $x->result();
		$price = $x1[0]->night;
		$placeid = $x1[0]->id;
		
		
		if($paywhom)
		{
			$query = $this->db->get_where('list',array('id' => $id));
			$q =	$query->result();
			$email = $q[0]->email; 	
		} 
		else
		{
			$query = $this->db->get_where('users',array('id' => 1));
			$q =	$query->result();
			$email = $q[0]->email;
		}
		
		$query = $this->db->get_where('list',array('id' => $id));
		$q =	$query->result();
		$data['address'] = $q[0]->address;
		$data['room_type'] = $q[0]->room_type;
		$data['total_guests'] = $q[0]->capacity;
		$data['tit'] = $q[0]->title;
		
		
		$diff = strtotime($ckout[2].'-'.$ckout[0].'-'.$ckout[1]) - strtotime($ckin[2].'-'.$ckin[0].'-'.$ckin[1]);
		
		$days = ceil($diff/(3600*24));
		
		$amt = $price * $days * $data['guests'];
		$data['subtotal'] = $amt;
		
		//Entering it into data variables
		$data['id']           = $id;
		$data['price']        = $price;
		$data['days']         = $days;
		$data['full_cretids'] = 'off';
		
		$data['commission'] = 0;
		//check admin premium condition and apply so for
		$query       = $this->db->get_where('paymode', array( 'id' => 2));
		$row         = $query->row();
		if($row->is_premium == 1)
		{
		  if($row->is_fixed == 1)
				{
				   $fix  = $row->fixed_amount; 
				   $amt = $amt + $fix;
							$data['commission'] = $amt ;
				}
				else
				{  
				   $per  = $row->percentage_amount; 
				   $camt = floatval(($amt * $per) / 100);
							$amt  = $amt + $camt;
							$data['commission'] = $camt ;
				}
		}
		else
		{
		$amt = $amt;
		}
				

		$data['amt'] = $amt;
		
		$data['result']  = $this->db->get('payments')->result();
	
		$array_items = array(
															'list_id'                 => '',
															'Lcheckin'                => '',
															'Lcheckout'               => '',
															'number_of_guests'					   => '',
															'formCheckout'            => ''
											);
  $this->session->unset_userdata($array_items);
		
		$data['title'] = "Confirm your booking";
		$data['message_element'] = "view_inter_book";
		$this->load->view('template',$data);
		
	}
	
	
	public function payment($param)
	{
			if($this->input->post('agrees_to_terms') != 'on')
			{
					$newdata = array(
										'list_id'                 => $param,
										'Lcheckin'                => $this->input->post('checkin'),
										'Lcheckout'               => $this->input->post('checkout'),
										'number_of_guests'					   => $this->input->post('number_of_guests'),
										'formCheckout'            => TRUE
						);
					$this->session->set_userdata($newdata);
			  $this->session->set_flashdata('flash_message', "<p style='color:#CC3300'><strong>You must agree to the Cancellation Policy and House Rules.</strong></p>");
		  	redirect('paypal/index/'.$param,'refresh');
			}
	
	  if($this->input->post('payment_method') == 'cc')
			{
			   $this->process_request();
			}
			else if($this->input->post('payment_method') == 'paypal')
			{
			   $this->submission();			
			}
			else if($this->input->post('payment_method') == '2c')
			{
						$this->submissionTwoc();	
			}
			else
			{
			   redirect('info');	
			}
	
	}
	
	

	
	function submission()
	{
		$checkin          = $this->input->post('checkin');
		$checkout         = $this->input->post('checkout');
		$number_of_guests = $this->input->post('number_of_guests');
		
		$ckin = explode('/', $checkin);
		$ckout = explode('/', $checkout);
		$pay = $this->db->get_where('paywhom',array('id' => 1));
		$paywhom = $pay->result();
		$paywhom = $paywhom[0]->whom;
		$id = $this->uri->segment(3);
		
		if($ckin[0] == "mm")
		{
			
			redirect('rooms/'.$id, "refresh");
		} 
		if($ckout[0] == "mm") 
		{
			
			redirect('rooms/'.$id, "refresh");
		}
		
		$x = $this->db->get_where('price',array('id' => $this->uri->segment(3)));
		$x1 = $x->result();
		$price = $x1[0]->night;
		$placeid = $x1[0]->id;
		
		
		if($paywhom)
		{
			$query = $this->db->get_where('list',array('id' => $id));
			$q =	$query->result();
			$email = $q[0]->email; 	
		} 
		else
		{
			$query = $this->db->get_where('users',array('id' => 1));
			$q =	$query->result();
			$email = $q[0]->email;
		}
		
		$query = $this->db->get_where('list',array('id' => $id));
		$q =	$query->result();
		
		$diff = strtotime($ckout[2].'-'.$ckout[0].'-'.$ckout[1]) - strtotime($ckin[2].'-'.$ckin[0].'-'.$ckin[1]);
		$days = ceil($diff/(3600*24));
		
		$user_travel_cretids     = 0;
		if($this->session->userdata('travel_cretids'))
		{
		   $amt                  = $this->session->userdata('travel_cretids');
					$user_travel_cretids  = $this->session->userdata('user_travel_cretids');
					$is_travelCretids     = md5('Yes Travel Cretids');
		}
		else
		{
	   	$amt              = $price * $days * $number_of_guests;
					
					//commission calculation
					$query       = $this->db->get_where('paymode', array( 'id' => 2));
					$row         = $query->row();
					if($row->is_premium == 1)
					{
							if($row->is_fixed == 1)
							{
										$fix  = $row->fixed_amount; 
										$amt = $amt + $fix;
							}
							else
							{  
										$per  = $row->percentage_amount; 
										$camt = floatval(($amt * $per) / 100);
										$amt  = $amt + $camt;
							}
					}
					else
					{
					$amt = $amt;
					}
					$is_travelCretids = md5('No Travel Cretids');
		}
		
		  //Entering it into data variables
		   $row     = $this->db->get_where('payments', array( 'id' => 2))->row();
					
		   $this->paypal_lib->add_field('business', $row->paypal_id);
	    $this->paypal_lib->add_field('return', site_url('paypal/success'));
	    $this->paypal_lib->add_field('cancel_return', site_url('paypal/cancel'));
	    $this->paypal_lib->add_field('notify_url', site_url('paypal/ipn')); // <-- IPN url
	    $this->paypal_lib->add_field('custom', $id.'@'.$this->dx_auth->get_user_id().'@'.$checkin.'@'.$checkout.'@'.$number_of_guests.'@'.$is_travelCretids.'@'.$user_travel_cretids);
					// Verify return

	    $this->paypal_lib->add_field('item_name', $this->dx_auth->get_site_title().' Transaction');
	    $this->paypal_lib->add_field('item_number', $placeid );
	    $this->paypal_lib->add_field('amount', $amt);

		// if you want an image button use this:
		$this->paypal_lib->image('button_03.gif');
		
		// otherwise, don't write anything or (if you want to 
		// change the default button text), write this:

		
	 $data['paypal_form'] = $this->paypal_lib->paypal_form();
	
		
		$this->paypal_lib->paypal_auto_form();
		
	}
	
	
	function auto_form()
	{
		   $this->paypal_lib->add_field('business', 'PAYPAL@EMAIL.COM');
	    $this->paypal_lib->add_field('return', site_url('paypal/success'));
	    $this->paypal_lib->add_field('cancel_return', site_url('paypal/cancel'));
	    $this->paypal_lib->add_field('notify_url', site_url('paypal/ipn')); // <-- IPN url
	    $this->paypal_lib->add_field('custom', '1234567890'); // <-- Verify return

	    $this->paypal_lib->add_field('item_name', 'Paypal Test Transaction');
	    $this->paypal_lib->add_field('item_number', '6941');
	    $this->paypal_lib->add_field('amount', '197');

	    $this->paypal_lib->paypal_auto_form();
	}
	
	
	function cancel()
	{
		echo "Cancelled";
		$this->load->view('paypal/cancel');
	}
	
	function success()
	{
	

		$data['pp_info'] = $_POST;  // Changed according to WIKI
		$this->load->view('paypal/success', $data);
	}
	
	
	function ipn()
	{
	 
		if($_REQUEST['payment_status'] == 'Completed')
		{
		$custom = $_REQUEST['custom'];
		$data   = array();
		$list   = array();
		$data   = explode('@',$custom); 
		
		$list['list_id']       = $data[0];
		$list['userby']        = $data[1];
		
		$query1      = $this->db->get_where('list', array('id' => $list['list_id']));
		$buyer_id    = $query1->row()->user_id;
		
		$list['userto']        = $buyer_id;
		$list['checkin']       = $data[2];
		$list['checkout']      = $data[3];
		$list['no_quest']      = $data[4];
		$list['price']         = $_REQUEST['mc_gross'];
		$list['credit_type']   = 1;
  
		$is_travelCretids    = $data[5];
		$user_travel_cretids = $data[6];
		
		if($_REQUEST['payment_status'] == 'Completed')
		{
		   	$list['status'] = 1;
		}
		else
		{
		   	$list['status'] = 0;
		}
			
			if($list['price'] > 75)
			{
			$user_id = $list['userby'];
		
			$row     = $details->row();
			$count   = $details->num_rows();
			if($count > 0)
			{
							
									if($details1->num_rows() == 0)
									{ 						
									$insertData                  = array();
									$insertData['user_id']       = $row->invite_from;
									$insertData['count_trip']    = 1;
									$insertData['amount']        = 25;
								
									}
									else
									{
									$count_trip   = $details1->row()->count_trip;
									$amount       = $details1->row()->amount;
									$updateKey                   = array('id' => $row->id);
									$updateData                  = array();
									$updateData['count_trip']    = $count_trip + 1;
									$updateData['amount']        = $amount + 25;
									
									}
				}
			}
			
			$q        =	$query1->result();
			$row_list = $query1->row();
		 $iUser_id = $q[0]->user_id;
			
			$row      = $details2->row();
			$count    = $details2->num_rows();
				if($count > 0)
				{
			
									if($details3->num_rows() == 0)
									{ 							
									$insertData                  = array();
									$insertData['user_id']       = $row->invite_from;
									$insertData['count_book']    = 1;
									$insertData['amount']        = 75;
					
									}
									else
									{
									$count_book   = $details3->row()->count_book;
									$amount       = $details3->row()->amount;
									$updateKey                   = array('id' => $row->id);
									$updateData                  = array();
									$updateData['count_trip']    = $count_book + 1;
									$updateData['amount']        = $amount + 75;
						
									}
				}
				
			$admin_email = $this->dx_auth->get_site_sadmin();
			$admin_name  = $this->dx_auth->get_site_title();
			
			$query3      = $this->db->get_where('users',array('id' => $list['userby']));
			$rows        =	$query3->row();
				
			$username    = $rows->username;
			$user_id     = $rows->id;
			$email_id    = $rows->email;
			
			$query4      = $this->users->get_user_by_id($buyer_id);
			$buyer_name  = $query4->row()->username;
			$buyer_email = $query4->row()->email;
			
			if($is_travelCretids == '7c4f08a53f4454ea2a9fdd94ad0c2eeb')
			{			
					  	
		     	$amount      = $query5->row()->amount;			
																
								$updateKey                   = array('user_id ' => $user_id);
								$updateData                  = array();
								$updateData['amount']        = $amount -	$user_travel_cretids;
						
								
								$list['credit_type']   = 2;
								$list['ref_amount']    = $user_travel_cretids;

							
							$row = $query4->row();
							
								//sent mail to administrator
							$email_name = 'tc_book_to_admin';
							$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_date}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $user_travel_cretids+$list['price'], "{payed_amount}" => $list['price'],"{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
							//Send Mail
							$this->Email_model->sendMail($admin_email,$email_id,ucfirst($username),$email_name,$splVars);
							

								//sent mail to buyer
							$email_name = 'tc_book_to_host';
							$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_date}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $list['price']);
							//Send Mail
							$this->Email_model->sendMail($buyer_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);

			}
			
					
			//Actual insertion into the database
			$this->db->insert('reservation',$list);		
			$reservation_id = $this->db->insert_id();
			
			//Send Message Notification
			$insertData = array(
				'list_id'         => $list['list_id'],
				'reservation_id'  => $reservation_id,
				'userby'          => $list['userby'],
				'userto'          => $list['userto'],
				'message'         => 'You have a new reservation request from '.ucfirst($username),
				'created'         => date('m/d/Y g:i A'),
				'message_type'    => 1
				);
			$this->Message_model->sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $row_list->title, $reservation_id);
			$message_id     = $this->db->insert_id();
			
			$actionurl = site_url('trips/request/'.$message_id);
				
   //Reservation Notification To Host
			$email_name = 'host_reservation_notification';
			$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_date}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $list['price'], "{action_url}" => $actionurl);
			//Send Mail
			$this->Email_model->sendMail($buyer_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
			
		 //Reservation Notification To Traveller
			$email_name = 'traveller_reservation_notification';
			$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username));
			//Send Mail
			$this->Email_model->sendMail($email_id,$admin_email,ucfirst($admin_name),$email_name,$splVars);
			
				//Reservation Notification To Administrator
				$email_name = 'admin_reservation_notification';
				$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_date}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $user_travel_cretids+$list['price'], "{payed_amount}" => $list['price'],"{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
				//Send Mail
				$this->Email_model->sendMail($admin_email,$email_id,ucfirst($username),$email_name,$splVars);
				
		}
	}
	
	
	//Date convert module
	public function dateconvert($date)
	{
		$ckout = explode('/', $date);
		$diff = $ckout[2].'-'.$ckout[0].'-'.$ckout[1];
		return $diff;
	}
}
?>