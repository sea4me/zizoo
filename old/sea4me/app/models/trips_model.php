<?php

/**
 * Dropinn Trips_model Class
 *
 * Help to handle tables related to static Faqs of the system.
 *
 * @package		Trips
 * @subpackage	Models
 * @category	Trips_model 
 * @author		Cogzidel Product Team
 * @version		Version 1.5.1
 * @link		http://www.cogzidel.com

 */
class Trips_model extends CI_Model {

    function Trips_model() {
        parent::__construct();
    }

    function get_reservation($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->from('reservation');
        $this->db->join('reservation_status', 'reservation.status = reservation_status.id', 'inner');

        $this->db->select('reservation.id,reservation.list_id,reservation.userby,reservation.userto,reservation.checkin,reservation.checkout,reservation.no_quest,reservation.price,reservation.credit_type,reservation.ref_amount,reservation.status,reservation.book_date,reservation_status.name');

        $result = $this->db->get();
        return $result;
    }

    function update_reservation($updateKey = array(), $updateData = array()) {
        $this->db->update('reservation', $updateData, $updateKey);
    }

    function get_reservation_trips($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->from('reservation');
        $this->db->join('reservation_status', 'reservation.status = reservation_status.id', 'inner');
        $this->db->join('list', 'reservation.list_id = list.id', 'left');

        $this->db->select('reservation.id,reservation.list_id,reservation.userby,reservation.userto,reservation.checkin,reservation.checkout,reservation.no_quest,reservation.price,reservation.credit_type,reservation.ref_amount,reservation.status,reservation.book_date,reservation_status.name');

        $result = $this->db->get();
        return $result;
    }

    function insertReview($insertData = array()) {
        $this->db->insert('reviews', $insertData);
    }

    function get_review($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->from('reviews');

        $result = $this->db->get();
        return $result;
    }

    function get_review_sum($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->select_sum('cleanliness');
        $this->db->select_sum('communication');
        $this->db->select_sum('accuracy');
        $this->db->select_sum('checkin');
        $this->db->select_sum('location');
        $this->db->select_sum('value');

        $result = $this->db->get('reviews');
        return $result;
    }

    function get_calendar($conditions = array(), $group_by = '') {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        if ($group_by == 'on')
            $this->db->group_by('list_id');

        $this->db->from('calendar');

        $result = $this->db->get();
        return $result;
    }

    function insert_calendar($insertData = array()) {
        $this->db->insert('calendar', $insertData);
    }

    function update_calendar($updateKey = array(), $updateData = array()) {
        $this->db->update('calendar', $updateData, $updateKey);
    }

    function delete_calendar($id = 0, $conditions = array()) {
        if (is_array($conditions) and count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('calendar');
    }

    function update_pageViewed($list_id, $page_viewed) {
        $this->db->where('id', $list_id);
        $updateData = array("page_viewed" => $page_viewed + 1);
        $this->db->update('list', $updateData);

        return $this->db->get_where('list', array('id' => $list_id))->row()->page_viewed;
    }

}

?>