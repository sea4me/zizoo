<?php

/**
 * DROPinn Admin Payment Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		DROPinn
 * @subpackage	Controllers
 * @category	Admin Payment
 * @author		Cogzidel Product Team
 * @version		Version 1.3
 * @link		http://www.cogzidel.com

  <Dropinn>
  Copyright (C) <2011>  <Cogzidel Technologies>

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>
  If you want more information, please email me at bala.k@cogzidel.com or
  contact us from http://www.cogzidel.com/contact
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends CI_Controller {

    function Payment() {
        parent::__construct();

        $this->load->library('Table');
        $this->load->library('Pagination');
        $this->load->library('DX_Auth');

        $this->load->helper('form');
        $this->load->helper('url');

        //load validation library
        $this->load->library('form_validation');


        $this->load->model('dx_auth/users', 'users');

        // Protect entire controller so only admin, 
        // and users that have granted role in permissions table can access it.
        $this->dx_auth->check_uri_permissions();
    }

    function index() {
        $this->form_validation->set_error_delimiters('<p>', '</p>');

        if ($this->input->post('addGateway')) {
            //Set rules
            $this->form_validation->set_rules('name_gate', 'Pay Gateway', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {
                $id = $this->input->post('name_gate');

                $data['is_installed'] = 1;
                $data['is_active'] = $this->input->post('is_active');

                if ($id == 1) {
                    $data['pe_user'] = $this->input->post('pe_user');
                    $data['pe_password'] = $this->input->post('pe_password');
                    $data['pe_key'] = $this->input->post('pe_key');
                } else if ($id == 2) {
                    $data['paypal_id'] = $this->input->post('paypal_id');
                    $data['paypal_url'] = $this->input->post('paypal_url');
                } else if ($id == 3) {
                    $data['twoc_ventorid'] = $this->input->post('ventor_id');
                    $data['twoc_security'] = $this->input->post('security');
                }

                $this->db->where('id', $id);
                $this->db->update('payments', $data);
                $this->session->set_flashdata('flash_message', "<p style='color:#009900'><strong>Pay gateway added successfully.</strong></p>");
                redirect_admin('payment/manage_gateway');
            }
        }

        $query = $this->db->get_where('payments', array('is_installed !=' => 1));
        $data['result'] = $query->result();

        $data['message_element'] = "backend/payment/add_gateway";
        $this->load->view('backend/admin_template', $data);
    }

    function manage_gateway($id = '') {
        $check = $this->input->post('check');
        if ($this->input->post('delete')) {
            if (empty($check)) {
                $this->session->set_flashdata('flash_message', "Sorry, You have select atleast one!");
                redirect_admin('payment/manage_gateway');
            }

            foreach ($check as $c) {
                $this->db->delete('payments', array('id' => $c));
            }
            $this->session->set_flashdata('flash_message', "Pay Deleted Successfully");
            redirect_admin('payment/manage_gateway');
        } else if ($this->input->post('edit')) {
            if (empty($check)) {
                $this->session->set_flashdata('flash_message', "Sorry, You have select atleast one!");
                redirect_admin('payment/manage_gateway');
            }

            if (count($check) == 1) {
                $query = $this->db->get_where('payments', array('id' => $check[0]));
                $data['result'] = $query->row();

                $query1 = $this->db->get_where('payments');
                $data['payments'] = $query1->result();

                $data['payId'] = $check[0];
                $data['message_element'] = "backend/payment/edit_gateway";
                $this->load->view('backend/admin_template', $data);
            } else {
                $this->session->set_flashdata('flash_message', "Please select any one pay method to edit!");
                redirect_admin('payment/manage_gateway');
            }
        } else if ($this->input->post('update')) {
            $payId = $this->input->post('payId');

            if ($payId == 1) {
                $data['pe_user'] = $this->input->post('pe_user');
                $data['pe_password'] = $this->input->post('pe_password');
                $data['pe_key'] = $this->input->post('pe_key');
            } else {
                $data['paypal_id'] = $this->input->post('paypal_id');
                $data['paypal_url'] = $this->input->post('paypal_url');
            }

            $data['is_active'] = $this->input->post('is_active');
            $this->db->where('id', $payId);
            $this->db->update('payments', $data);

            $this->session->set_flashdata('flash_message', "Payment changes updated successfully");
            redirect_admin('payment/manage_gateway');
        } else {
            if (isset($id) && $id != '') {
                $get = $this->db->get_where('payments', array('id' => $id))->row();
                if ($get->is_active == 1) {
                    $change = 0;
                } else {
                    $change = 1;
                }

                $data['is_active'] = $change;
                $this->db->where('id', $id);
                $this->db->update('payments', $data);
            }
            $data['payments'] = $this->db->get_where('payments', array('is_installed' => 1));

            $data['message_element'] = "backend/payment/manage_gateway";
            $this->load->view('backend/admin_template', $data);
        }
    }

    function paymode($id = '') {
        $check = $this->input->post('check');
        if ($this->input->post('edit')) {
            if (empty($check)) {
                $this->session->set_flashdata('flash_message', "Sorry, You have select atleast one!");
                redirect_admin('payment/paymode');
            }
            if (count($check) == 1) {
                $data['payId'] = $check[0];
                if ($check[0] == 1) {
                    $data['result'] = $this->db->get_where('paymode', array('id' => 1))->row();
                    $data['message_element'] = "backend/payment/list_pay";
                    $this->load->view('backend/admin_template', $data);
                } else if ($check[0] == 2) {
                    $data['result'] = $this->db->get_where('paymode', array('id' => 2))->row();
                    $data['message_element'] = "backend/payment/accommodation_pay";
                    $this->load->view('backend/admin_template', $data);
                } else {
                    $data['result'] = $this->db->get_where('paymode', array('id' => 3))->row();
                    $data['message_element'] = "backend/payment/reservation_request";
                    $this->load->view('backend/admin_template', $data);
                }
            } else {
                $this->session->set_flashdata('flash_message', "Please select any one pay mode to edit!");
                redirect_admin('payment/paymode');
            }
        } else if ($this->input->post('update')) {
            $payId = $this->input->post('payId');

            $data['is_premium'] = $this->input->post('is_premium');
            $data['is_fixed'] = $this->input->post('is_fixed');
            $data['fixed_amount'] = $this->input->post('fixed_amount');
            $data['percentage_amount'] = $this->input->post('percentage_amount');

            $this->db->where('id', $payId);
            $this->db->update('paymode', $data);

            echo "Updated Successfully!";
        } else {
            if (isset($id) && $id != '') {
                $get = $this->db->get_where('paymode', array('id' => $id))->row();
                if ($get->is_premium == 1) {
                    $change = 0;
                } else {
                    $change = 1;
                }

                $data['is_premium'] = $change;
                $this->db->where('id', $id);
                $this->db->update('paymode', $data);
            }
            $data['payMode'] = $this->db->get('paymode');

            $data['message_element'] = "backend/payment/paymode";
            $this->load->view('backend/admin_template', $data);
        }
    }

    function finance() {
        $query = $this->db->get('reservation');

        // Get offset and limit for page viewing
        $offset = (int) $this->uri->segment(3);
        // Number of record showing per page
        $row_count = 10;

        // Get all users
        $data['result'] = $this->db->get('reservation', $row_count, $offset)->result();

        // Pagination config
        $p_config['base_url'] = site_url('backend/payment/finance');
        $p_config['uri_segment'] = 3;
        $p_config['num_links'] = 2;
        $p_config['total_rows'] = $query->num_rows();
        $p_config['per_page'] = $row_count;

        // Init pagination
        $this->pagination->initialize($p_config);
        // Create pagination links
        $data['pagination'] = $this->pagination->create_links2();

        $data['message_element'] = "backend/payment/reservation_list";
        $this->load->view('backend/admin_template', $data);
    }

}

?>