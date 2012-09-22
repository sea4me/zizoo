<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

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

    public function Home() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('DX_Auth');
        $this->load->library('Form_validation');
        $this->load->helper('form');
        $this->load->helper('cookie');
        $this->load->library('session');

        //initailizations 
        //Tiny MCE initializations
        $this->tinyMce = '<!-- TinyMCE -->
			<script type="text/javascript" src="' . base_url() . 'tiny_mce/tiny_mce.js"></script>
			<script type="text/javascript">
				tinyMCE.init({
					// General options
					mode : "textareas",
					theme : "simple"
				});
			</script>
			<!-- /TinyMCE -->
			';
    }

    public function index() {
        $data['message_element'] = "view_home";
        $data["title"] = $this->dx_auth->get_site_title();
        $data["meta_keyword"] = $this->db->get_where('settings', array('code' => 'META_KEYWORD'))->row()->string_value;
        $data["meta_description"] = $this->db->get_where('settings', array('code' => 'META_DESCRIPTION'))->row()->string_value;

        $this->load->model('Gallery');
        $query = $this->db->get('list', 10);
        $divprint = "";
        $scrprint = "";
        $count = 0;

        foreach ($query->result() as $row) {
            $count++;
            $images = $this->Gallery->get_images($row->id);
            if (count($images) != 0) {
                $url = $images[0]['url'];

                $profpic = $this->Gallery->profilepic($row->user_id, 1);

                $divprint .='<div class="cls_cen"><div class="clsImg">
			<a class="" href="' . base_url() . 'rooms/' . $row->id . '" linkindex="29" >';
                $divprint .= '<img width="682" height="310" src="' . $url . '"></a></div>';
                $divprint .= '    			
    			<div class="clsLady clsClearFix">
    			<div class="cls_lady_img">
    			<img alt="Profile Pics" src="' . $profpic . '">
    			</div>
    			<div class="cls_para">';
                $divprint .= '<p class="clsHead"><a href="' . base_url() . 'rooms/' . $row->id . '" >' . $row->title . '</a></p><p>' . $row->address . '</p>
			';
                $divprint .= '
    			<p>$' . $row->price . ' / night</p>
    			</div></div></div>';

                if ($count != count($query->result())) {
                    $scrprint.= '{"userPicUrl":"' . base_url() . 'images/no_avatar_thumb.jpg",';
                    $scrprint.='"smartLocation":"' . $row->address . '",';
                    $scrprint.='"price":"$' . $row->price . '",';
                    $scrprint.='"url":"' . base_url() . 'rooms/' . $row->id . '",';
                    $scrprint.='"name":"' . $row->address . '",';
                    $scrprint.='"picUrl":"' . $url . '",';
                    $scrprint.='"id":' . $row->id . '},';
                } else {
                    $scrprint.= '{"userPicUrl":"' . base_url() . 'images/no_avatar_thumb.jpg",';
                    $scrprint.='"smartLocation":"' . $row->address . '",';
                    $scrprint.='"price":"$' . $row->price . '",';
                    $scrprint.='"url":"' . base_url() . 'func/editconfirm/' . $row->id . '",';
                    $scrprint.='"name":"' . $row->title . '",';
                    $scrprint.='"picUrl":"' . $url . '",';
                    $scrprint.='"id":' . $row->id . '}';
                }
            }
        }
        $data['scrprint'] = $scrprint;
        $data['divprint'] = $divprint;
        $this->load->view('template', $data);
    }

    /* for sign up page */

    public function signup() {

        $data['message_element'] = "view_signUp";
        $data['username_error'] = "";
        $data['password_error'] = "";
        $data['email_error'] = "";
        $data['retype_error'] = "";
        $data['user_error'] = "";
        $data["title"] = "Sign Up/ Login";
        $this->load->view('template', $data);
    }

    public function submit() {

        //Get the post values
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $repass = $this->input->post('re-password');

        $data["title"] = "Sign Up for the site";


        //Initializations
        $data['username_error'] = "";
        $data['password_error'] = "";
        $data['email_error'] = "";
        $data['retype_error'] = "";

        if (!$this->dx_auth->is_username_available($username)) {
            $data['username_error'] = "Sorry username is not available";
        }
        if (!$this->dx_auth->is_email_available($email)) {
            $data['email_error'] = "Sorry this email has already been registered";
        }
        if (strlen($password) < 4) {
            $data['password_error'] = "Sorry password has too less characters";
        }
        if ($password != $repass) {
            $data['retype_error'] = "Passwords do not match";
        }

        if ($data['username_error'] == "" && $data['password_error'] == "" && $data['email_error'] == "" && $data['retype_error'] == "") {
            $data = $this->dx_auth->register($username, $password, $email);

            $this->dx_auth->login($username, $password, 'TRUE');

            //Need to add this data to user profile too 
            $add['id'] = $this->dx_auth->get_user_id();
            $add['email'] = $email;
            $this->db->insert('profiles', $add);

            redirect('home', 'refresh');
        } else {
            $data['message_element'] = "view_signUp";
            $this->load->view('template', $data);
        }
    }

    public function signin() {
        $data['username_error'] = "";
        $data['password_error'] = "";
        $data['email_error'] = "";
        $data['retype_error'] = "";
        $data['user_error'] = "";

        $this->form_validation->set_error_delimiters('<p>', '</p>');

        if ($this->input->post("SignIn")) {
            if (!$this->dx_auth->is_logged_in()) {
                $username = $this->input->post("username");
                $password = $this->input->post("password");

                // Set form validation rules
                $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean');
                $this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');
                $this->form_validation->set_rules('remember', 'Remember me', 'integer');

                if ($this->form_validation->run()) {
                    if ($this->dx_auth->login($username, $password, $this->form_validation->set_value('TRUE'))) {
                        $newdata = array(
                            'user' => $this->dx_auth->get_user_id(),
                            'username' => $this->dx_auth->get_username(),
                            'logged_in' => TRUE
                        );
                        $this->session->set_userdata($newdata);

                        if ($this->session->userdata('formCheckout')) {
                            redirect('paypal/index/' . $this->session->userdata('list_id'), 'refresh');
                        } else {
                            redirect('home/index', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('flash_message', "Either the username or password is wrong. Please try again!");
                    }
                }
            } else {
                $this->session->set_flashdata('flash_message', "You are already logged in. Logout to login again");
                redirect('home/index', 'refresh');
            }
        }
        $data['message_element'] = "view_signIn";
        $data["title"] = "Sign In / Sign Up";

        $this->load->view('template', $data);
    }

    function login() {

        $data['message_element'] = "view_signIn";
        $data['title'] = "Sign In / Sign up";
        $this->load->view('template', $data);
    }

    function forgot_password() {
        $val = $this->form_validation;

        // Set form validation rules  
        $val->set_rules('login', 'Username or Email address', 'trim|required|xss_clean');

        // Validate rules and call forgot password function  
        if ($val->run() AND $this->dx_auth->forgot_password($val->set_value('login'))) {
            $data['auth_message'] = 'An email has been sent to your email with instructions with how to activate your new password.';
            $this->load->view($this->dx_auth->forgot_password_success_view, $data);
        } else {
            $this->load->view($this->dx_auth->forgot_password_view);
        }
    }

    function reset_password() {
        // Get username and key  
        $username = $this->uri->segment(3);
        $key = $this->uri->segment(4);

        // Reset password  
        if ($this->dx_auth->reset_password($username, $key)) {
            $data['auth_message'] = 'You have successfully reset you password, ' . anchor(site_url($this->dx_auth->login_uri), 'Login');
            $this->load->view($this->dx_auth->reset_password_success_view, $data);
        } else {
            $data['auth_message'] = 'Reset failed. Your username and key are incorrect. Please check your email again and follow the instructions.';
            $this->load->view($this->dx_auth->reset_password_failed_view, $data);
        }
    }

    function change_password() {
        // Check if user logged in or not  
        if ($this->dx_auth->is_logged_in()) {
            $val = $this->form_validation;

            // Set form validation  
            $val->set_rules('old_password', 'Old Password', 'trim|required|xss_clean|min_length[' . $this->min_password . ']|max_length[' . $this->max_password . ']');
            $val->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length[' . $this->min_password . ']|max_length[' . $this->max_password . ']|matches[confirm_new_password]');
            $val->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean');

            // Validate rules and change password  
            if ($val->run() AND $this->dx_auth->change_password($val->set_value('old_password'), $val->set_value('new_password'))) {
                $data['auth_message'] = 'Your password has successfully been changed.';
                $this->load->view($this->dx_auth->change_password_success_view, $data);
            } else {
                $this->load->view($this->dx_auth->change_password_view);
            }
        } else {
            // Redirect to login page  
            $this->dx_auth->deny_access('login');
        }
    }

    /* Funcion for logout script 
     * 
     */

    function logout() {
        $data['message_element'] = "view_home";
        $data["title"] = "CLone of Air BNB";
        $this->dx_auth->logout();
        $data['auth_message'] = 'You have been logged out.';

        redirect('/home/signin', 'refresh');
    }

    public function addlist() {
        $data["title"] = "List your property";
        $data["message_element"] = "view_list";
        $this->load->view('template', $data);
    }

    public function viewlist() {
        $data["title"] = "View Your Newly added";
        $data["message_element"] = "view_new_host";
        $this->load->view('template', $data);
    }

    public function admincontrols() {
        $data['title'] = 'Controls for administrator';
        $data['message_element'] = 'view_admin';
        $this->load->view('template', $data);
    }

    //Required for language changes

    public function language() {
        $data['title'] = 'Controls Language';
        $data['message_element'] = 'view_langchange';
        $this->load->view('template', $data);
    }

    public function languages() {
        extract($_POST);
        $this->session->set_userdata('language', $dlang);
        $redirect_url = base_url() . $current;
        redirect($redirect_url);
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */