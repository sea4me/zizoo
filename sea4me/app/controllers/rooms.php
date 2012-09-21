<?php
class Rooms extends CI_Controller
{

 public function Rooms()
	{
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


	public function index()
	{
	 if( ($this->dx_auth->is_logged_in()) || ($this->facebook->logged_in()) )
		{
	 $sort=$this->input->get('f'); 
		$data['sort']=$sort;
		$data['title'] = "short your List";
		$data['message_element'] = "view_hosting";
		$this->load->view('template',$data);
		}
		else
		{
			redirect('home/signin');
		}
		
	}
	
	
	public function calendar_tab_inner($param = '')
	{
	  if($param == '')
			{
			 redirect('info/deny');
			}
			
			$day     = 1;
			$month   = $this->input->post('cal_month', TRUE);
			$year    = $this->input->post('cal_year', TRUE);
			
			$data['list_id']  = $param;
			$data['day']      = $day;
			$data['month']    = $month;
			$data['year']     = $year;
			
			$conditions     = array('list_id' => $param);
			$data['result'] = $this->Trips_model->get_calendar($conditions)->result();
			
	
	  $this->load->view('rooms/view_calendar_tab',$data);
	}
	
	
		
		public function sort_by_status()
	{
	 if( ($this->dx_auth->is_logged_in()) || ($this->facebook->logged_in()) )
		{
	 $sort = $this->input->get('f'); 
		$data['sort']  = $sort;
		$data['title'] = "Manage Listings";
		$data['message_element'] = "hosting/view_hosting";
		$this->load->view('template',$data);
		}
		else
		{
			redirect('home/signin');
		}
	}
	
	
	public function showHide()
	{
		if( ($this->dx_auth->is_logged_in()) || ($this->facebook->logged_in()) )
		{
			$sow_hide=$this->input->get('stat'); 
			$row_id=$this->input->get('rid');
					
			if($sow_hide == 1)
			{
				$data['status'] = 0;
				$this->db->where('id',$row_id);
				$this->db->update('list',$data);
				redirect('hosting');
			}
			else
			{
				$data['status'] = 1;
				$this->db->where('id',$row_id);
				$this->db->update('list',$data);
				redirect('hosting');
			}
			
			$data['title'] = "Hide and Show your List";
			$data['message_element'] = "view_hosting";
			$this->load->view('template',$data);
			
		}
		else
		{redirect('home/signin');

		}
	
}
}	 

?>