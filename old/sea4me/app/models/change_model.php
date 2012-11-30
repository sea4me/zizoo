<?php

/**
 * DROPinn Change Model Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		DROPinn
 * @subpackage	Models
 * @category	Referrals_model 
 * @author		Cogzidel Product Team
 * @version		Version 1.1
 * @link		http://www.cogzidel.com
 */
class Change_model extends CI_Model {

    //Constructor
    function Change_model() {
        parent::__construct();
    }

    function get_google_lang($id = '') {
        if ($id != '') {
            $this->db->where('id', $id);
        }
        return $this->db->get('language');
    }

    function get_core_lang($id = '') {
        if ($id != '') {
            $this->db->where('id', $id);
        }
        return $this->db->get('language_core');
    }

}

?>