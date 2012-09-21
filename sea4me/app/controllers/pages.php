<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
		
	//Constructor
	public function Pages()
	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->helper('url');
		
		$this->load->library('DX_Auth');  
                $this->load->library('Form_validation');  		
		$this->load->library('session');
		
		$this->load->model('common_model');

	}
	
	//Main control handler
     
	public function feedbacksuccess()
	{
		$data['message_element'] = 'view_feedback_success';
		$data['title'] = 'Thanks for the feedback';
		$this->load->view('template',$data);
	}
	
	
	 public function contact()
		{
			$this->form_validation->set_error_delimiters('<p style="clear:both;color: #FF0000;"><label>&nbsp;</label>', '</p>');
   if($this->input->post('commit'))
			{
					$name 				= $this->input->post('name');
					$email 			= $this->input->post('email');
					$feedback = $this->input->post('message');
					
					$admin_email = $this->dx_auth->get_site_sadmin();
					$admin_name  = $this->dx_auth->get_site_title();
					
					$this->form_validation->set_rules('name','Name','required|trim|xss_clean');
					$this->form_validation->set_rules('email','Email','required|valid_email|trim|xss_clean');
					$this->form_validation->set_rules('message','Message','required|trim|xss_clean');
					
					if($this->form_validation->run())
					{	
								$body  = 'An Feedback has been successfully received from ';
								$body .= $name . ' on '.date('m/d/Y') . ' at ' . date('g:i A') . "\n\n";
								$body .= " Details:\n";
								$body .=  $feedback;
						
								// load email lib and email results
								$this->load->library('email');
								$this->email->to($admin_email);
								$this->email->from($email, $name);
								$this->email->subject('Feedback received');
								$this->email->message($body);	
								$this->email->send();
								
							 $this->session->set_flashdata('flash_message', $this->common_model->flash_message('success','Thanks for being part of our community! We will contact you asap.'));
								redirect('pages/contact');
					}
			}
			$data['row']    = $this->db->get_where('contact_info', array('id' => '1'))->row();
			$data['title'] = 'Contact Us';
			$data['message_element'] = 'view_contact';
			$this->load->view('template',$data);
		}
		
	 public function about()
		{
			$query = $this->db->get_where('pages',array('id' => 1));
			$q = $query->result();
			$data['content'] =  $q[0]->about;
			$data['title'] = 'About Us';
			$data['message_element'] = 'view_about';
			$this->load->view('template',$data);
		}
     

     
	 public function services()
		{
			$query = $this->db->get_where('pages',array('id' => 1));
			$q = $query->result();
			$data['content'] =  $q[0]->services;
			$data['title'] = 'Services Offered';
			$data['message_element'] = 'view_services';
			$this->load->view('template',$data);
		}
		
		public function view($param = '')
		{
			$query = $this->db->get_where('page',array('page_url' => $param));
			if($query->num_rows() < 0)
			{
			 redirect('info');
			}
			else
			{
			$row = $query->row();
			
			$data['title'] 								       = $row->page_title;
			$data['page_content'] 								= $row->page_content;
			$data['page_name'] 								 		= $row->page_name;
			$data['message_element'] 					= 'view_pages';
			$this->load->view('template',$data);	
			}
		}
}