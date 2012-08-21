<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class DX_Auth_Event
{
	var $ci;
	
	function DX_Auth_Event()
	{
		$this->ci =& get_instance();
	}
	
	function user_activated($user_id)
	{
		// Load models
		$this->ci->load->model('dx_auth/user_profile', 'user_profile');
		
		// Create user profile
		$this->ci->user_profile->create_profile($user_id);
	}
	
	// This event occurs right after user login
	function user_logged_in($user_id)
	{
	}
	
	// This event occurs right before user logout
	function user_logging_out($user_id)
	{
	}
	
	// This event occurs right after user change password
	function user_changed_password($user_id, $new_password)
	{
	}
	
	// This event occurs right before user account is canceled
	function user_canceling_account($user_id)
	{
		// Load models
		$this->ci->load->model('dx_auth/user_profile', 'user_profile');
		
		// Delete user profile
		$this->ci->user_profile->delete_profile($user_id);
	}
	
	function checked_uri_permissions($user_id, &$allowed)
	{	
	}
	
	function got_permission_value($user_id, $key)
	{	
	}
	
	function got_permissions_value($user_id, $key)
	{	
	}
	
	function sending_account_email($data, &$content)
	{
		// Load helper
		$this->ci->load->helper('url');
		
		// Create content	
		$content = sprintf($this->ci->lang->line('auth_account_content'), 
			$this->ci->config->item('DX_website_name'), 
			$data['username'], 
			$data['email'], 
			$data['password'], 
			site_url($this->ci->config->item('DX_login_uri')),
			$this->ci->config->item('DX_website_name'));
	}
	
	function sending_activation_email($data, &$content)
	{
		// Create content
		$content = sprintf($this->ci->lang->line('auth_activate_content'), 
			$this->ci->config->item('DX_website_name'), 
			$data['activate_url'],
			$this->ci->config->item('DX_email_activation_expire') / 60 / 60,
			$data['username'], 
			$data['email'],
			$data['password'],
			$this->ci->config->item('DX_website_name'));
	}
	
	function sending_forgot_password_email($data, &$content)
	{
		// Create content
		$content = sprintf($this->ci->lang->line('auth_forgot_password_content'), 
			$this->ci->config->item('DX_website_name'), 
			$data['reset_password_uri'],
			$data['password'],
			$data['key'],
			$this->ci->config->item('DX_webmaster_email'),
			$this->ci->config->item('DX_website_name'));
	}
}

?>