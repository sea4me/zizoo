<?php

class Page_model extends CI_Model {

    /**
     * Constructor 
     *
     */
    function Page_model() {
        parent::__construct();
    }

//Controller End

    function deletePage($id = 0, $conditions = array()) {
        if (is_array($conditions) and count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('page');
    }

    function getPages($conditions = array(), $like = array(), $like_or = array()) {
        //Check For like statement
        if (is_array($like) and count($like) > 0)
            $this->db->like($like);

        //Check For like statement
        if (is_array($like_or) and count($like_or) > 0)
            $this->db->or_like($like_or);
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->from('page');
        $this->db->select();
        $result = $this->db->get();
        return $result;
    }

    function addpage($insertData = array()) {
        $this->db->insert('page', $insertData);
    }

    function updatePage($updateKey = array(), $updateData = array()) {
        $this->db->update('page', $updateData, $updateKey);
    }

//End of updateFaq Function 
}

// End Page_model Class
   
/* End of file Page_model.php */ 
/* Location: ./app/models/Page_model.php */