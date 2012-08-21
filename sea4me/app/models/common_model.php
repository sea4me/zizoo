<?php
	 class Common_model extends CI_Model {
	 
		/**
			* Constructor 
			*
			*/
	  function Common_model() 
	  {
			parent::__construct();
	
		 // load model
	  $this->load->model('page_model');

   }//Controller End
	  

	
	
	 function flash_message($type,$message)
	 {
	 	switch($type)
		{
			case 'success':
					$data = '<div class="message"><div class="success">'.$message.'</div></div>';
					break;
			case 'error':
					$data = '<div class="message"><div class="error">'.$message.'</div></div>';
					break;		
		}
		return $data;
	 }//End of flash_message Function
	 
	
	 function admin_flash_message($type,$message)
	 {
	 	switch($type)
		{
			case 'success':
					$data = '<div class="message"><div class="success">'.$message.'</div></div>';
					break;
			case 'error':
					$data = '<div class="message"><div class="error">'.$message.'</div></div>';
					break;		
		}
		return $data;
	 }//End of flash_message Function
	 
		

	 function getPages()
	 {
	   $conditions = array('page.is_active'=> 1);
	   $pages                      = array();
       $pages['staticPages']       =$this->page_model->getPages($conditions);
	   return $pages['staticPages'];
	   
	 }
	 
	
	 function getSitelogo()
	 {
	   $conditions = array('settings.code'=>'SITE_LOGO');
	   $data                      = array();
	   $this->db->where($conditions);
	   $this->db->from('settings');
	   $this->db->select('settings.string_value');
	   $result = $this->db->get();
       $data['site_logo']         =	$result->result();
	   return $data;
	   
	 }
	 	 
	 
	 function getTableData($table='',$conditions=array(),$fields='',$like=array(),$limit=array(),$orderby = array(),$like1=array(),$order = array(),$conditions1=array())
	 {
	 	//Check For Conditions
	 	if(is_array($conditions) and count($conditions)>0)		
	 		$this->db->where($conditions);
		
		//Check For Conditions
	 	if(is_array($conditions1) and count($conditions1)>0)		
	 		$this->db->or_where($conditions1);	
			
		//Check For like statement
	 	if(is_array($like) and count($like)>0)		
	 		$this->db->like($like);	
		
		if(is_array($like1) and count($like1)>0)

			$this->db->or_like($like1);	
			
		//Check For Limit	
		if(is_array($limit))		
		{
			if(count($limit)==1)
	 			$this->db->limit($limit[0]);
			else if(count($limit)==2)
				$this->db->limit($limit[0],$limit[1]);
		}	
		
		
		//Check for Order by
		if(is_array($orderby) and count($orderby)>0)
			$this->db->order_by('id', 'desc');
			
		//Check for Order by
		if(is_array($order) and count($order)>0)
			$this->db->order_by($order[0], $order[1]);	
			
		$this->db->from($table);
		
		if($fields!='')
		 
				$this->db->select($fields);
		
		else 		
	 		$this->db->select();
			
		$result = $this->db->get();
		
		return $result;
		
	 }	 
	 
	 function deleteTableData($table='',$conditions=array())
	 {
	    //Check For Conditions
	 	if(is_array($conditions) and count($conditions)>0)		
	 		$this->db->where($conditions);
			
		$this->db->delete($table);
		return $this->db->affected_rows(); 
		 
 	 }//End of deleteTableData Function
	 
	 
	 function insertData($table='',$insertData=array())
	 {
	 	return $this->db->insert($table,$insertData);
	 }//End of insertData Function
	 
	 
	 function updateTableData($table='',$id=0,$updateData=array(),$conditions=array())
	 {
	 	if(is_array($conditions) and count($conditions)>0)		
	 		$this->db->where($conditions);
		else	
		    $this->db->where('id', $id);
	 	$this->db->update($table, $updateData);
		 
	 }//End of updateTableData Function
		 
}
// End Common_model Class
   
/* End of file Common_model.php */ 
/* Location: ./app/models/Common_model.php */
?>