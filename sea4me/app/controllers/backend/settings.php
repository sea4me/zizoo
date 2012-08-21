<?php
/**
 * DROPinn Admin Social Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		DROPinn
 * @subpackage	Controllers
 * @category	Admin Social
 * @author		Cogzidel Product Team
 * @version		Version 1.4
 * @link		http://www.cogzidel.com
  
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller
{

	public function Settings()
	{
			parent::__construct();
		
		$this->load->library('Table');
		$this->load->library('Pagination');
		$this->load->library('DX_Auth');
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('file');
		//load validation library
		$this->load->library('form_validation');

		$this->load->model('dx_auth/users', 'users');			
		$this->load->model('Change_model');
		
		// Protect entire controller so only admin, 
		// and users that have granted role in permissions table can access it.
		$this->dx_auth->check_uri_permissions();
		$this->path = realpath(APPPATH . '../');
	}
	
	public function index()
	{
			if($this->input->post('update'))
			{
				$data1['string_value']     = $this->input->post('site_title');
				$this->db->where('code', 'SITE_TITLE');
				$this->db->update('settings',$data1);
				
				$data2['string_value']    = $this->input->post('site_slogan');
				$this->db->where('code', 'SITE_SLOGAN');
				$this->db->update('settings',$data2);
				
				$data3['int_value']       = $this->input->post('offline');
				$this->db->where('code', 'SITE_STATUS');
				$this->db->update('settings',$data3);
				
				$data4['text_value']      = $this->input->post('offline_message');
				$this->db->where('code', 'OFFLINE_MESSAGE');
				$this->db->update('settings',$data4);
				
				$data5['text_value']      = $this->input->post('google_analytics');
				$this->db->where('code', 'GOOGLE_ANALYTICS_CODE');
				$this->db->update('settings',$data5);	
				
				$data6['string_value']    = $this->input->post('super_admin');
				$this->db->where('code', 'SITE_ADMIN_MAIL');
				$this->db->update('settings',$data6);
				
				if($_FILES["logo"]["name"])
				{
				$logo = $this->db->get_where('settings', array('code' => 'SITE_LOGO'))->row()->string_value;
    $real_logo = $this->path.'/logo/'.$logo;
				unlink($real_logo);
				
    	$config = array(
						'allowed_types' => 'jpg|jpeg|gif|png',
						'upload_path' => 'logo'
						);
					$this->load->library('upload', $config);
					$this->upload->do_upload('logo');
					
				$data7['string_value']    = $_FILES["logo"]["name"];
				$this->db->where('code', 'SITE_LOGO');
				$this->db->update('settings',$data7);
			}
		 	$query6                  = $this->db->get_where('settings', array('code' => 'SITE_LOGO'));

		 	$logo = '<img src="'.base_url().'logo/'.$query6->row()->string_value.'" alt="logo">';
				echo  $logo.'#Settings updated successfully';
			}
			else
			{
			$query1                  = $this->db->get_where('settings', array('code' => 'SITE_TITLE'));
			$data['site_title']      = $query1->row()->string_value;
			
			$query2                  = $this->db->get_where('settings', array('code' => 'SITE_SLOGAN'));
			$data['site_slogan']     = $query2->row()->string_value;
			
			$query3                  = $this->db->get_where('settings', array('code' => 'SITE_STATUS'));
			$data['site_status']     = $query3->row()->int_value;
			
			$query4                  = $this->db->get_where('settings', array('code' => 'OFFLINE_MESSAGE'));
			$data['offline_message'] = $query4->row()->text_value;
			
			$query5                  = $this->db->get_where('settings', array('code' => 'GOOGLE_ANALYTICS_CODE'));
			$data['google_analytics']= $query5->row()->text_value;
			
			$query6                  = $this->db->get_where('settings', array('code' => 'SITE_ADMIN_MAIL'));
			$data['super_admin']     = $query6->row()->string_value;
			
			$query7                  = $this->db->get_where('settings', array('code' => 'SITE_LOGO'));
			$data['logo']     							= base_url().'logo/'.$query7->row()->string_value;
			
			$data['message_element'] = "backend/settings/site_settings";
			$this->load->view('backend/admin_template', $data);
			}	
	}
	
	
	public function lang_front()
	{
	 if($this->input->post('update'))
		{
				$data['int_value']       = $this->input->post('language_translator');
				
				if($data['int_value'] == 1)
				$data['text_value']    = $this->input->post('core_lang');
				else
				$data['string_value']  = $this->input->post('google_lang');
				
				$this->db->where('code', 'FRONTEND_LANGUAGE');
				$this->db->update('settings',$data);
		}
		else
		{
		$query                       = $this->db->get_where('settings', array('code' => 'FRONTEND_LANGUAGE'));
		$data['language_translator'] = $query->row()->int_value;
		$data['core_lang']           = $query->row()->text_value;
		$data['google_lang']         = $query->row()->string_value;
		
		$data['languages']           = $this->Change_model->get_google_lang()->result();
		$data['languages_core']      = $this->Change_model->get_core_lang()->result();
		
 	$data['message_element'] = "backend/settings/lang_front";
		$this->load->view('backend/admin_template', $data);
		}
	}
	
	
	public function lang_back()
	{
	 if($this->input->post('update'))
		{
				$data['int_value']       = $this->input->post('language_translator');
				
				if($data['int_value'] == 1)
				$data['text_value']    = $this->input->post('core_lang');
				else
				$data['string_value']  = $this->input->post('google_lang');
				
				$this->db->where('code', 'BACKEND_LANGUAGE');
				$this->db->update('settings',$data);
		}
		else
		{
		$query                       = $this->db->get_where('settings', array('code' => 'BACKEND_LANGUAGE'));
		$data['language_translator'] = $query->row()->int_value;
		$data['core_lang']           = $query->row()->text_value;
		$data['google_lang']         = $query->row()->string_value;
		
		$data['languages']           = $this->Change_model->get_google_lang()->result();
		$data['languages_core']      = $this->Change_model->get_core_lang()->result();
		
 	$data['message_element'] = "backend/settings/lang_back";
		$this->load->view('backend/admin_template', $data);
		}
		}
	
	
	public function manage_meta()
	{
		if($this->input->post('update'))
		{
		 	$data1['string_value']     = $this->input->post('meta_keyword');
				$this->db->where('code', 'META_KEYWORD');
				$this->db->update('settings',$data1);
				
				$data2['string_value']    = $this->input->post('meta_description');
				$this->db->where('code', 'META_DESCRIPTION');
				$this->db->update('settings',$data2);
				
			echo 'Settings updated successfully';
		}
		else
		{
		$query1                  = $this->db->get_where('settings', array('code' => 'META_KEYWORD'));
		$data['meta_keyword']    = $query1->row()->string_value;
		
		$query2                  = $this->db->get_where('settings', array('code' => 'META_DESCRIPTION'));
		$data['meta_description'] = $query2->row()->string_value;
		
		$data['message_element'] = "backend/settings/manage_meta";
		$this->load->view('backend/admin_template', $data);
		}
	}
	
	public function change_password()
	{
		if($this->input->post('update'))
		{
		  $majorsalt = '';
				$password = $this->input->post('new_password');
			// if PHP5
			if (function_exists('str_split'))
			{
				$_pass = str_split($password);
			}
			// if PHP4
			else
			{
				$_pass = array();
				if (is_string($password))
				{
					for ($i = 0; $i < strlen($password); $i++)
					{
						array_push($_pass, $password[$i]);
					}
				}
			}
			foreach ($_pass as $_hashpass)
			{
				$majorsalt .= md5($_hashpass);
			}
			$final_pass = crypt(md5($majorsalt));
	
		 $data['password']     = $final_pass;
			$this->db->where('id', 1);
			$this->db->update('users',$data);
			
			echo 'Settings updated successfully';
		}
		else
		{
		$data['message_element'] = "backend/settings/change_password";
		$this->load->view('backend/admin_template', $data);
		}
	}
	
	public function how_it_works()
	{
	 if($this->input->post('update'))
		{
		   if($this->input->post('display_type') == 0)
					{
								if($_FILES["media"]["name"])
								{
								$media = $this->db->get_where('settings', array('code' => 'HOW_IT_WORKS'))->row()->string_value;
								$real_logo = $this->path.'/uploads/howit/'.$media;
								unlink($real_logo);
								
									$config = array(
										'allowed_types' => 'mp4|flv|FLV',
										'upload_path'   => 'uploads/howit'
										);
									$this->load->library('upload', $config);
									$this->upload->do_upload('media');
									
								//$this->upload->display_errors('<p>','</p>');
									
								$data1['string_value']    = $_FILES["media"]["name"];
								$this->db->where('code', 'HOW_IT_WORKS');
								$this->db->update('settings',$data1);
								
								$data2['int_value']    = 0;
								$this->db->where('code', 'HOW_IT_WORKS');
								$this->db->update('settings',$data2);
							}
					}
					else if($this->input->post('display_type') == 1)
					{
						$data1['text_value']    = $this->input->post('embed_code') ;
						$this->db->where('code', 'HOW_IT_WORKS');
						$this->db->update('settings',$data1);
						
						$data2['int_value']    = 1;
						$this->db->where('code', 'HOW_IT_WORKS');
						$this->db->update('settings',$data2);
						}
			
		}

  $data['display_type']    = $this->db->get_where('settings', array('code' => 'HOW_IT_WORKS'))->row()->int_value;
		$data['media']           = $this->db->get_where('settings', array('code' => 'HOW_IT_WORKS'))->row()->string_value;
		$data['embed_code']      = $this->db->get_where('settings', array('code' => 'HOW_IT_WORKS'))->row()->text_value;
		
		$data['message_element'] = "backend/settings/how_it_works";
		$this->load->view('backend/admin_template', $data);
	
	}
	
}

?>