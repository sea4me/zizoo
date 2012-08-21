<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profiles extends CI_Controller {


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
	
	public function Profiles()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('DX_Auth');  
  $this->load->library('Form_validation');  		
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('facebook');
		$this->load->helper('file');
		$this->facebook->enable_debug(TRUE);
		
		$this->path = realpath(APPPATH . '../images');
		//initailizations 
	}
	public function index()
	{
		$data['message_element'] = "view_home";
		$data["title"] = "CLone of Air BNB";
		$this->load->view('template', $data);					
	}

	public function prof()
	{
		$data = array(
				'Fname' => $this->input->post('Fname'),
				'Lname' => $this->input->post('Lname'),
				'phnum' => $this->input->post('phnum'),
				'live' => $this->input->post('live'),
				'work' => $this->input->post('work'),
				'describe' => $this->input->post('desc'),
      );

		$this->db->where('id', $this->uri->segment(3));
		$this->db->update('profiles', $data);
		
		$data2['email'] = $this->input->post('email');
		$this->db->where('id', $this->uri->segment(3));
		$this->db->update('users', $data2);
		
		redirect ('/func/dashboard/'.$this->uri->segment(3),'refresh'); 
	}
	
	public function uploadphoto()
	{
		$this->load->model('Gallery');
		$id = $this->uri->segment(3);
		if($this->input->post('upload'))
		{
				if(!is_dir($this->path.'/'.$id))
			{
				mkdir($this->path.'/'.$id, 0777, true);
			}
			$config = array(
				'allowed_types' => 'jpg|jpeg|gif|png',
				'upload_path' => $this->path.'/'.$id
			);
			$this->load->library('upload', $config);
			$this->upload->do_upload();
		
		}
		redirect('func/editconfirm/'.$id, 'refresh');
	}
	
	public function paypal()
	{
		$type = $this->input->post('payment_period');
		$id = $this->input->post('hosting_id');
		$checkin = $this->input->post('checkin');
		$checkout = $this->input->post('checkout');
		$ckin = explode('/', $checkin);
		$ckout = explode('/', $checkout);
		$pay = $this->db->get_where('paywhom',array('id' => 1));
		$paywhom = $pay->result();
		$paywhom = $paywhom[0]->whom;
		
		
		if($ckin[0] == "mm")
		{
			redirect('/func/editConfirm/'.$id, "refresh");
		} 
		if($ckout[0] == "mm") 
		{
			redirect('/func/editConfirm/'.$id, "refresh");
		}
		
		$x = $this->db->get_where('price',array('id' => $id));
		$x1 = $x->result();
		$price = $x1[0]->night;
		
		
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
		
		
		$diff = strtotime($ckout[2].'-'.$ckout[0].'-'.$ckout[1]) - strtotime($ckin[2].'-'.$ckin[0].'-'.$ckin[1]);
		$days = ceil($diff/(3600*24));
		
		$amt = $price * $days;
		redirect(base_url().'/paypal/paypal.php?amt='.$amt.'&email='.$email,'refresh'); 
	}
	
	function costfilter()
	{
		$this->load->model('Gallery');
		$data['message_element'] = 'view_search_result';
		$data['title'] = "Search Elements";
		$min = $this->input->post('min');
		$max = $this->input->post('max');
		$query = $this->input->post('query');
		$pieces = explode(",", $query);
     	$data['pieces'] = $pieces;
     	$print ="";
     	$len = count($pieces);
     	$count = 0;
     	foreach($pieces as $test)
     	{
     		$this->db->flush_cache();		
     		$test = $this->db->escape_like_str($test);
     		$this->db->like('address',$test);
     		for($i = 0; $i<$count;$i++)
     		{
     			$this->db->not_like('address', $pieces[$i]);
     		}
     		
     		if($min > 0)
     		{
				$this->db->where('price >=', $min);
     		}
     		if($max < 300)
     		{
     			$this->db->where('price <=', $max);
     		}

     			
			$data['query'] = $this->db->get('list');
     		foreach($data['query']->result() as $row)
			{
			$images = $this->Gallery->get_images($row->id);
			if(count($images) == 0) $url = 'http://d3mjr4yb15zzlp.cloudfront.net/pictures/404802/small.jpg';
			else $url = $images[0]['url']; 
			
			$print .= '<div style="height:105px;overflow:visible;display:inline;"><li style="margin-top:10px;display:block;min-height:105px;_height:150px;" class="search_result" id="'.$row->id.'">';
			$print .= '<div class="pop_image_small">
                <div class="map_number">1</div>
                <a class="image_link" href="/func/editConfirm/'.$row->id.'" linkindex="98"><img width="639" height="426" title="ZEN TAO" src="'.$url.'" class="search_thumbnail"></a> 
           	</div>';
			$print .= '<div class="room_details">
                <h2 class="room_title">                  
			<a href="/func/editConfirm/'.$row->id.'" class="name" linkindex="100">'.$row->title.'</a>                  
                </h2>';
			$print .='<p class="address">'.$row->address.'</p>';
			$print .='<ul class="reputation"></ul>            
			</div>            
					<div class="price">                
					  	
					<div class="price_data">
							<!--<sup class="currency_if_required"></sup>-->
                    			<div class="currency_with_sup"><sup>$</sup>'.$row->price.'</div>
                    			
        				</div>  
        				<div lass="price_modifier">Per night</div>              
						          
					</div>        
			</li></div>';
			}
			$count++;	     
			
     	}
     	$data['print'] = $print;
		$data['query'] = $query;
		$this->load->view('template',$data);
	}
	
	public function roomfilter()
	{
		
		$this->load->model('Gallery');
		$data['message_element'] = 'view_search_result';
		$data['title'] = "Search Elements";
		$query = $this->input->post('query');
		$pieces = explode(",", $query);
     	$data['pieces'] = $pieces;
     	$print ="";
     	$res = $this->input->post('room_types');
     	
     	$len = count($pieces);
     	$count = 0;
     	foreach($pieces as $test)
     	{
     		$this->db->flush_cache();		
     		$test = $this->db->escape_like_str($test);
     		$this->db->like('address',$test);
     		for($i = 0; $i<$count;$i++)
     		{
     			$this->db->not_like('address', $pieces[$i]);
     		}
     		
     			if (is_array($res))
     				foreach($res as $r)
     				{
	     				$this->db->where('room_type', $r);
     				}
     		//Exececute the query
			$data['query'] = $this->db->get('list');
     		foreach($data['query']->result() as $row)
			{
			$images = $this->Gallery->get_images($row->id);
			if(count($images) == 0) $url = 'http://d3mjr4yb15zzlp.cloudfront.net/pictures/404802/small.jpg';
			else $url = $images[0]['url']; 
			
			$print .= '<div style="height:105px;overflow:visible;display:inline;"><li style="margin-top:10px;display:block;min-height:105px;_height:150px;" class="search_result" id="'.$row->id.'">';
			$print .= '<div class="pop_image_small">
                <div class="map_number">1</div>
                <a class="image_link" href="/func/editConfirm/'.$row->id.'" linkindex="98"><img width="639" height="426" title="ZEN TAO" src="'.$url.'" class="search_thumbnail"></a> 
           	</div>';
			$print .= '<div class="room_details">
                <h2 class="room_title">                  
			<a href="func/editConfirm/'.$row->id.'" class="name" linkindex="100">'.$row->title.'</a>                  
                </h2>';
			$print .='<p class="address">'.$row->address.'</p>';
			$print .='<ul class="reputation"></ul>            
			</div>            
					<div class="price">                
					  	
					<div class="price_data">
							<!--<sup class="currency_if_required"></sup>-->
        	            			<div class="currency_with_sup"><sup>$</sup>'.$row->price.'</div>
                    			
        				</div>  
        				<div lass="price_modifier">Per night</div>              
						          
					</div>        
			</li></div>';
			}
			$count++;	     
			
     	}
     	$data['print'] = $print;
		$data['query'] = $query;
		$this->load->view('template',$data);
	}
	
	
	public function updatepageadmin()
	{
		$data['youtube'] = $this->input->post('youtube');
		$data['google'] = $this->input->post('google');
		$data['adsense'] =  $this->input->post('adsense');
		$this->db->where('id', 1);
		$this->db->update('admin',$data);
		redirect('/home/admincontrols','refresh');
		
	}
	
	public function userphoto()
	{
		$id = $this->uri->segment(3);
		
			$target_path = realpath(APPPATH . '../images/users');
			
			if(!is_dir( realpath(APPPATH . '../images/users').'/'.$id))
			{
				mkdir( realpath(APPPATH . '../images/users').'/'.$id, 0777, true);
			}
			
			$target_path = $target_path .'/'.$id.'/userpic.jpg'; 

			if(move_uploaded_file($_FILES['upload123']['tmp_name'], $target_path)) {
			} else{
			}
			
			$thumb1 = realpath(APPPATH . '../images/users').'/'.$id.'/userpic_thumb.jpg';
			GenerateThumbFile($target_path,$thumb1,107,78);
			
			$thumb2 = realpath(APPPATH . '../images/users').'/'.$id.'/userpic_profile.jpg';
			GenerateThumbFile($target_path,$thumb2,209,209);
		
		
		
		redirect('/func/edituserprofile/'.$id, 'refresh');
	}
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */

	
	
	