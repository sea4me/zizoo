<?php

/**
 * DROPinn Payment List Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		DROPinn
 * @subpackage	Controllers
 * @category	Pay List
 * @author		Cogzidel Product Team
 * @version		Version 1.4
 * @link		http://www.cogzidel.com

 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Listpay extends CI_Controller {

    public function Listpay() {
        parent::__construct();

        $this->load->helper('url');

        $this->load->library('DX_Auth');
        $this->load->library('Form_validation');
        $this->load->library('email');
        $this->load->helper('form');
        $this->load->library('session');

        //load validation library
        $this->load->library('form_validation');

        $this->load->library('Paypal_Lib');

        $this->load->library('Twoco_Lib');

        $this->load->model('dx_auth/users', 'users');
    }

    public function index() {

        $this->form_validation->set_error_delimiters('<p>', '</p>');

        if ($this->input->post('book_it_button')) {
            if ($this->input->post('payment_method') == 'cc') {
                //Set rules
                $this->form_validation->set_rules('CardName', 'Card Name', 'required|trim|xss_clean');
                $this->form_validation->set_rules('CardNum', 'Card Number', 'required|trim|xss_clean');

                if ($this->form_validation->run()) {
                    $this->process_request();
                }
            } else if ($this->input->post('payment_method') == 'paypal') {
                $this->submission();
            } else if ($this->input->post('payment_method') == '2c') {
                $this->submissionTwoc();
            } else {
                redirect('info');
            }
        }

        $data['id'] = $this->session->userdata('Lid');
        $data['amt'] = $this->session->userdata('amount');

        $data['result'] = $this->db->get('payments')->result();

        $data['title'] = 'Payment Option';
        $data['message_element'] = "view_listPay";

        $this->load->view('template', $data);
    }

    public function submission() {
        $list_id = $this->session->userdata('Lid');

        $row = $this->db->get_where('payments', array('id' => 2))->row();

        $this->paypal_lib->add_field('business', $row->paypal_id);
        $this->paypal_lib->add_field('return', site_url('listpay/success'));
        $this->paypal_lib->add_field('cancel_return', site_url('listpay/cancel'));
        $this->paypal_lib->add_field('notify_url', site_url('listpay/ipn')); // <-- IPN url
        $this->paypal_lib->add_field('custom', $list_id);
        // Verify return
        $this->paypal_lib->add_field('item_name', $this->dx_auth->get_site_title() . ' Transaction');
        $this->paypal_lib->add_field('item_number', $list_id);
        $this->paypal_lib->add_field('amount', $this->session->userdata('amount'));

        $this->paypal_lib->image('button_03.gif');

        $data['paypal_form'] = $this->paypal_lib->paypal_form();

        $this->paypal_lib->paypal_auto_form();
    }

    public function cancel() {
        redirect('home/addlist', 'refresh');
    }

    public function ipn() {
        if ($_REQUEST['payment_status'] == 'Completed') {
            $listId = $_REQUEST['custom'];
            $data['status'] = 1;
            $this->db->where('id', $listId);
            $this->db->update('list', $data);
        }
    }

    public function success() {
        if ($_REQUEST['payment_status'] == 'Completed') {
            $listId = $_REQUEST['custom'];
            redirect('func/editListing/' . $list_id, 'refresh');
        } else {
            redirect('home/addlist', 'refresh');
        }
    }

    public function submissionTwoc() {
        $list_id = $this->session->userdata('Lid');

        $row = $this->db->get_where('payments', array('id' => 3))->row();

        $this->twoco_lib->addField('sid', $row->twoc_ventorid);
        // Specify the order information
        $this->twoco_lib->addField('cart_order_id', rand(1, 100));
        $this->twoco_lib->addField('total', $this->session->userdata('amount'));
        // Specify the url where authorize.net will send the IPN
        $this->twoco_lib->addField('x_Receipt_Link_URL', site_url('listpay/twoC_ipn'));
        $this->twoco_lib->addField('return_url', site_url('listpay/twoC_success'));
        $this->twoco_lib->addField('tco_currency', 'USD');
        $this->twoco_lib->addField('merchant_order_id', $list_id);

        // Enable test mode if needed
        $this->twoco_lib->enableTestMode();

        // Let's start the train!
        $this->twoco_lib->submitPayment();
    }

    public function twoC_ipn() {
        foreach ($_REQUEST as $field => $value) {
            $this->ipnData["$field"] = $value;
        }

        $listId = $this->ipnData['vendor_order_id'];

        $data['status'] = 1;
        $this->db->where('id', $listId);
        $this->db->update('list', $data);
    }

    public function twoC_success() {
        foreach ($_REQUEST as $field => $value) {
            $this->ipnData["$field"] = $value;
        }

        $listId = $this->ipnData['vendor_order_id'];
        redirect('func/editListing/' . $list_id, 'refresh');
    }

    public function process_request() {
        $list_id = $this->session->userdata('Lid');
        $amt = $this->session->userdata('amount');

        $row = $this->db->get_where('payments', array('id' => 1))->row();

        if ($row->pe_user == "" || $row->pe_password == "") {
            echo "Sorry the process cannot be completed with this payment option. Please try to pay using PAYPAL. Redirecting you Shortly.....";
            redirect('home/addlist', 'refresh');
        }

        $name = $this->input->post('CardName');
        $expM = $this->input->post('ExMnth');
        $expM .= $this->input->post('ExYear');
        $num = $this->input->post('CardNum');


        $cmdDoTxnTransaction = "<Txn>";
        $cmdDoTxnTransaction .= "<PostUsername>$row->peuser</PostUsername>"; #Insert your DPS Username here
        $cmdDoTxnTransaction .= "<PostPassword>$row->pepass</PostPassword>"; #Insert your DPS Password here
        $cmdDoTxnTransaction .= "<Amount>$amt</Amount>";
        $cmdDoTxnTransaction .= "<TxnData1>$list_id</TxnData1>";
        $cmdDoTxnTransaction .= "<InputCurrency>USD</InputCurrency>";
        $cmdDoTxnTransaction .= "<CardHolderName>$name</CardHolderName>";
        $cmdDoTxnTransaction .= "<CardNumber>$num</CardNumber>";
        $cmdDoTxnTransaction .= "<DateExpiry>$expM</DateExpiry>";
        $cmdDoTxnTransaction .= "<TxnType>Purchase</TxnType>";
        $cmdDoTxnTransaction .= "<MerchantReference>" . $list_id . "</MerchantReference>";
        $cmdDoTxnTransaction .= "</Txn>";

        $URL = "sec.paymentexpress.com/pxpost.aspx";

        $this->curl->create('https://sec.paymentexpress.com/pxpost.aspx');
        $this->curl->option(CURLOPT_URL, 'https://sec.paymentexpress.com/pxpost.aspx');
        $this->curl->option(CURLOPT_POST, 1);
        $this->curl->option(CURLOPT_POSTFIELDS, $cmdDoTxnTransaction);
        $this->curl->option(CURLOPT_RETURNTRANSFER, 1);
        $this->curl->option(CURLOPT_SSL_VERIFYPEER, 0);
        $this->curl->option(CURLOPT_SSLVERSION, 3);

        $result = $this->curl->execute();

        $this->parse_xml($result);
    }

    public function parse_xml($data) {
        $list_id = $this->session->userdata('Lid');

        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser, $data, $vals);
        xml_parser_free($xml_parser);

        $params = array();
        $level = array();
        foreach ($vals as $xml_elem) {
            if ($xml_elem['type'] == 'open') {
                if (array_key_exists('attributes', $xml_elem)) {
                    list($level[$xml_elem['level']], $extra) = array_values($xml_elem['attributes']);
                } else {
                    $level[$xml_elem['level']] = $xml_elem['tag'];
                }
            }
            if ($xml_elem['type'] == 'complete') {
                $start_level = 1;
                $php_stmt = '$params';

                while ($start_level < $xml_elem['level']) {
                    $php_stmt .= '[$level[' . $start_level . ']]';
                    $start_level++;
                }

                if (array_key_exists('value', $xml_elem))
                    $php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
                else
                    $php_stmt .= '[$xml_elem[\'tag\']] = NULL;';
                eval($php_stmt);
            }
        }

        if (array_key_exists('0', $params['TXN'])) {
            $i = 0;
        } else {
            $i = 1;
        }


        if ($params['TXN'][$i]['CARDHOLDERRESPONSETEXT'] == 'APPROVED' &&
                $params['TXN'][$i]['CARDHOLDERHELPTEXT'] == 'The Transaction was approved' &&
                $params['TXN'][$i]['CARDHOLDERRESPONSEDESCRIPTION'] == 'The Transaction was approved' &&
                $params['TXN'][$i]['MERCHANTRESPONSETEXT'] == 'APPROVED' &&
                $params['TXN'][$i]['MERCHANTHELPTEXT'] == 'The Transaction was approved' &&
                $params['TXN'][$i]['MERCHANTRESPONSEDESCRIPTION'] == 'The Transaction was approved'
        ) {

            $x = explode('--', $params['TXN'][$i]['MERCHANTREFERENCE']);

            $data['status'] = 1;
            $this->db->where('id', $listId);
            $this->db->update('list', $data);

            echo "Transaction Successful. Redirecting....";
            redirect('func/editListing/' . $list_id, 'refresh');
        } else {
            echo "Transaction Not SuccessFul. Please try again....";
            redirect('home/addlist', 'refresh');
        }
    }

}