<?php

class Auth extends CI_Controller {

    // Used for registering and changing password form validation
    var $min_username = 4;
    var $max_username = 20;
    var $min_password = 4;
    var $max_password = 20;

    function Auth() {
        parent::__construct();

        $this->load->library('Form_validation');
        $this->load->library('DX_Auth');

        $this->load->helper('url');
        $this->load->helper('form');

        $this->load->library('session');

        $this->load->model('dx_auth/users', 'users');
        $this->load->model('dx_auth/user_temp', 'user_temp');
        $this->load->model('dx_auth/login_attempts', 'login_attempts');
    }

    function index() {
        $this->login();
    }

    /* Callback function */

    function username_check($username) {
        $result = $this->dx_auth->is_username_available($username);
        if (!$result) {
            $this->form_validation->set_message('username_check', 'Username already exist. Please choose another username.');
        }

        return $result;
    }

    function email_check($email) {
        $result = $this->dx_auth->is_email_available($email);
        if (!$result) {
            $this->form_validation->set_message('email_check', 'Email is already used by another user. Please choose another email address.');
        }

        return $result;
    }

    function captcha_check($code) {
        $result = TRUE;

        if ($this->dx_auth->is_captcha_expired()) {
            // Will replace this error msg with $lang
            $this->form_validation->set_message('captcha_check', 'Your confirmation code has expired. Please try again.');
            $result = FALSE;
        } elseif (!$this->dx_auth->is_captcha_match($code)) {
            $this->form_validation->set_message('captcha_check', 'Your confirmation code does not match the one in the image. Try again.');
            $result = FALSE;
        }

        return $result;
    }

    function recaptcha_check() {
        $result = $this->dx_auth->is_recaptcha_match();
        if (!$result) {
            $this->form_validation->set_message('recaptcha_check', 'Your confirmation code does not match the one in the image. Try again.');
        }

        return $result;
    }

    /* End of Callback function */

    function login() {
        $val = $this->form_validation;

        if ($this->input->post('loginAdmin')) {
            //Set rules
            $val->set_rules('username', 'Username', 'trim|required|xss_clean');
            $val->set_rules('password', 'Password', 'trim|required|xss_clean');
            $val->set_rules('remember', 'Remember me', 'integer');

            if ($this->form_validation->run()) {
                $login = $val->set_value('username');
                $password = $val->set_value('password');
                $remember = $val->set_value('remember');
                // Get which function to use based on config
                if ($this->config->item('DX_login_using_username') AND $this->config->item('DX_login_using_email')) {
                    $get_user_function = 'get_login';
                } else if ($this->config->item('DX_login_using_email')) {
                    $get_user_function = 'get_user_by_email';
                } else {
                    $get_user_function = 'get_user_by_username';
                }

                // Get user query
                if ($query = $this->users->$get_user_function($login) AND $query->num_rows() == 1) {
                    // Get user record
                    $row = $query->row();

                    // Check if user is banned or not
                    if ($row->banned > 0) {
                        $this->session->set_flashdata('flash_message', "Login failed! you are banned");
                        redirect('auth/login', 'refresh');
                    }
                    // If it's not a banned user then try to login
                    else {
                        $password = $this->dx_auth->_encode($password);
                        $stored_hash = $row->password;

                        // Is password matched with hash in database ?
                        if (crypt($password, $stored_hash) === $stored_hash) {
                            // Log in user 
                            $this->dx_auth->_set_session($row);

                            if ($row->newpass) {
                                // Clear any Reset Passwords
                                $this->users->clear_newpass($row->id);
                            }

                            if ($remember) {
                                // Create auto login if user want to be remembered
                                $this->dx_auth->_create_autologin($row->id);
                            }

                            // Set last ip and last login
                            $this->dx_auth->_set_last_ip_and_last_login($row->id);
                            // Clear login attempts
                            $this->dx_auth->_clear_login_attempts();

                            // Trigger event
                            $this->dx_auth_event->user_logged_in($row->id);
                            redirect('backend', 'refresh');
                        } else {
                            $this->session->set_flashdata('flash_message', "Login failed! Incorrect username or password");
                            redirect('auth/login', 'refresh');
                        }
                    }
                } else {
                    $this->session->set_flashdata('flash_message', "Login failed! Incorrect username or password");
                    redirect('auth/login', 'refresh');
                }
            }//If End - Check For Form Validation
        } //IF End- Check For Form Submission	

        $data['message_element'] = "backend/view_login";
        $data['auth_message'] = 'You are already logged in.';
        $this->load->view('backend/admin_template', $data);
    }

    function logout() {
        $this->dx_auth->logout();

        $data['auth_message'] = 'You have been logged out.';
        $this->load->view($this->dx_auth->logout_view, $data);
    }

    function register() {
        if (!$this->dx_auth->is_logged_in() AND $this->dx_auth->allow_registration) {
            $val = $this->form_validation;

            // Set form validation rules			
            $val->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[' . $this->min_username . ']|max_length[' . $this->max_username . ']|callback_username_check|alpha_dash');
            $val->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[' . $this->min_password . ']|max_length[' . $this->max_password . ']|matches[confirm_password]');
            $val->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
            $val->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');

            if ($this->dx_auth->captcha_registration) {
                $val->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback_captcha_check');
            }

            // Run form validation and register user if it's pass the validation
            if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email'))) {
                // Set success message accordingly
                if ($this->dx_auth->email_activation) {
                    $data['auth_message'] = 'You have successfully registered. Check your email address to activate your account.';
                } else {
                    $data['auth_message'] = 'You have successfully registered. ' . anchor(site_url($this->dx_auth->login_uri), 'Login');
                }

                // Load registration success page
                $this->load->view($this->dx_auth->register_success_view, $data);
            } else {
                // Is registration using captcha
                if ($this->dx_auth->captcha_registration) {
                    $this->dx_auth->captcha();
                }

                // Load registration page
                $this->load->view($this->dx_auth->register_view);
            }
        } elseif (!$this->dx_auth->allow_registration) {
            $data['auth_message'] = 'Registration has been disabled.';
            $this->load->view($this->dx_auth->register_disabled_view, $data);
        } else {
            $data['auth_message'] = 'You have to logout first, before registering.';
            $this->load->view($this->dx_auth->logged_in_view, $data);
        }
    }

    function register_recaptcha() {
        if (!$this->dx_auth->is_logged_in() AND $this->dx_auth->allow_registration) {
            $val = $this->form_validation;

            // Set form validation rules
            $val->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[' . $this->min_username . ']|max_length[' . $this->max_username . ']|callback_username_check|alpha_dash');
            $val->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[' . $this->min_password . ']|max_length[' . $this->max_password . ']|matches[confirm_password]');
            $val->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
            $val->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');

            // Is registration using captcha
            if ($this->dx_auth->captcha_registration) {
                // Set recaptcha rules.
                // IMPORTANT: Do not change 'recaptcha_response_field' because it's used by reCAPTCHA API,
                // This is because the limitation of reCAPTCHA, not DX Auth library
                $val->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback_recaptcha_check');
            }

            // Run form validation and register user if it's pass the validation
            if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email'))) {
                // Set success message accordingly
                if ($this->dx_auth->email_activation) {
                    $data['auth_message'] = 'You have successfully registered. Check your email address to activate your account.';
                } else {
                    $data['auth_message'] = 'You have successfully registered. ' . anchor(site_url($this->dx_auth->login_uri), 'Login');
                }

                // Load registration success page
                $this->load->view($this->dx_auth->register_success_view, $data);
            } else {
                // Load registration page
                $this->load->view('auth/register_recaptcha_form');
            }
        } elseif (!$this->dx_auth->allow_registration) {
            $data['auth_message'] = 'Registration has been disabled.';
            $this->load->view($this->dx_auth->register_disabled_view, $data);
        } else {
            $data['auth_message'] = 'You have to logout first, before registering.';
            $this->load->view($this->dx_auth->logged_in_view, $data);
        }
    }

    function activate() {
        // Get username and key
        $username = $this->uri->segment(3);
        $key = $this->uri->segment(4);

        // Activate user
        if ($this->dx_auth->activate($username, $key)) {
            $data['auth_message'] = 'Your account have been successfully activated. ' . anchor(site_url($this->dx_auth->login_uri), 'Login');
            $this->load->view($this->dx_auth->activate_success_view, $data);
        } else {
            $data['auth_message'] = 'The activation code you entered was incorrect. Please check your email again.';
            $this->load->view($this->dx_auth->activate_failed_view, $data);
        }
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
            //$this->load->view($this->dx_auth->forgot_password_view);
            $data['title'] = "Change Your Password";
            $data['message_element'] = "view_forgot_password";
            $this->load->view('template', $data);
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
                $data['auth_message'] = 'Your password has successfully been changed.<br /><br /><br /><a href="' . base_url() . 'home" >Go back to Home Page</a>';
                $this->load->view($this->dx_auth->change_password_success_view, $data);
            } else {
                $data['title'] = "Change Password";
                $data['message_element'] = $this->dx_auth->change_password_view;
                $this->load->view('template', $data);
            }
        } else {
            // Redirect to login page
            redirect('/home/signin');
        }
    }

    function cancel_account() {
        // Check if user logged in or not
        if ($this->dx_auth->is_logged_in()) {
            $val = $this->form_validation;

            // Set form validation rules
            $val->set_rules('password', 'Password', "trim|required|xss_clean");

            // Validate rules and change password
            if ($val->run() AND $this->dx_auth->cancel_account($val->set_value('password'))) {
                // Redirect to homepage
                redirect('', 'location');
            } else {
                $this->load->view($this->dx_auth->cancel_account_view);
            }
        } else {
            // Redirect to login page
            $this->dx_auth->deny_access('login');
        }
    }

    // Example how to get permissions you set permission in /backend/custom_permissions/
    function custom_permissions() {
        if ($this->dx_auth->is_logged_in()) {
            echo 'My role: ' . $this->dx_auth->get_role_name() . '<br/>';
            echo 'My permission: <br/>';

            if ($this->dx_auth->get_permission_value('edit') != NULL AND $this->dx_auth->get_permission_value('edit')) {
                echo 'Edit is allowed';
            } else {
                echo 'Edit is not allowed';
            }

            echo '<br/>';

            if ($this->dx_auth->get_permission_value('delete') != NULL AND $this->dx_auth->get_permission_value('delete')) {
                echo 'Delete is allowed';
            } else {
                echo 'Delete is not allowed';
            }
        }
    }

    function deny() {
        $data['title'] = "Access Deny";
        $data['message_element'] = 'view_deny';
        $this->load->view('template', $data);
    }

}

?>