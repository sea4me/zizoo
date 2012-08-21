<?php
/**
 * DROPinn Message Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		Dropinn
 * @subpackage	Controllers
 * @category	Message
 * @author		Cogzidel Product Team
 * @version		Version 1.5.2
 * @link		http://www.cogzidel.com
 
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {

	public function Message()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('cookie');
		
		$this->load->library('DX_Auth');  	
		$this->load->library('session');
		$this->load->library('facebook');
		
		$this->load->model('Message_model');
		$this->facebook->enable_debug(TRUE);
	}
	
	public	function inbox()
 {
	   $conditions       = array("messages.userto " => $this->dx_auth->get_user_id());
		 	$data['messages'] = $this->Message_model->get_messages($conditions);
				
				$data['title']    = "Inbox";
				$data['message_element'] = 'message/inbox';
				$this->load->view('template',$data);		
	}
	
	public function starred()
	{
	 $message_id   	              = $this->input->post('message_id');
		$to_change   	               = $this->input->post('to_change');
		$updateKey      										   = array('id' => $message_id);
		
		$updateData                  = array();
		$updateData['is_starred']    = $to_change;
		$this->Message_model->updateMessage($updateKey,$updateData);
		
		if($to_change == 0)
		{
		  echo "Message unstarred successfully.";
		}
		else
		{
		  echo "Message starred successfully.";
		}
	}
	
	public function delete()
	{
	  $message_id   	= $this->input->post('message_id');
			
			$this->Message_model->deleteMessage($message_id);
			
	  $conditions       = array("messages.userto " => $this->dx_auth->get_user_id());
		 $data['messages'] = $this->Message_model->get_messages($conditions);
				
			$this->load->view('message/ajax_inbox',$data);					
	}
	
	public function is_read()
	{
	 $message_id   	= $this->input->post('message_id');
	
		$updateKey      										= array('id' => $message_id);
		$updateData               = array();
		$updateData['is_read ']   = 1;
		$this->Message_model->updateMessage($updateKey,$updateData);
	}
	
}
?> 