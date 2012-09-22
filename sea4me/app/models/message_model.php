<?php

/**
 * Dropinn Message_model Class
 *
 * Help to handle tables related to static Faqs of the system.
 *
 * @package		Message
 * @subpackage	Models
 * @category	Message_model 
 * @author		Cogzidel Product Team
 * @version		Version 1.5
 * @link		http://www.cogzidel.com

 */
class Message_model extends CI_Model {

    function Message_model() {
        parent::__construct();
    }

    function updateMessage($updateKey = array(), $updateData = array()) {
        $this->db->update('messages', $updateData, $updateKey);
    }

    function get_message($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->from('messages');

        $result = $this->db->get();
        return $result;
    }

    function get_messages($conditions = array(), $or_where = array(), $orderby = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        if (count($or_where) > 0)
            $this->db->or_where($or_where);

        if (is_array($orderby) and count($orderby) > 0)
            $this->db->order_by($orderby[0], $orderby[1]);

        $this->db->from('messages');

        $this->db->join('message_type', 'messages.message_type = message_type.id', 'inner');
        $this->db->join('reservation', 'messages.reservation_id = reservation.id', 'left');

        $this->db->select('messages.id,messages.list_id,messages.reservation_id,messages.conversation_id,messages.userby,messages.userto,messages.subject,messages.message,messages.created,messages.is_read,messages.message_type,messages.is_starred,message_type.name,message_type.url,reservation.checkin,reservation.checkout,reservation.price,reservation.no_quest');

        $result = $this->db->get();
        return $result;
    }

    function reserve_notify($insertData = array(), $host_name, $traveller_name, $list_name) {
        $insertData['subject'] = 'You have a new reservation request from ' . ucfirst($traveller_name) .
                $this->db->insert('messages', $insertData);
    }

    function deleteMessage($id = 0, $conditions = array()) {
        if (is_array($conditions) and count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('messages');
    }

}

?>