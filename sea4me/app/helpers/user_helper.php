<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


function get_user_by_id($id)
{
$ci     =& get_instance();

$query  = $ci->db->get_where('users', array('id' => $id));

return $query->row();
}


function get_list_by_id($id)
{
$ci     =& get_instance();

$query  = $ci->db->get_where('list', array('id' => $id));

return $query->row();
}

function getDaysInBetween($startdate, $enddate)
{
$period = (strtotime($enddate) - strtotime($startdate))/(60*60*24);

$dateinfo = $startdate;

	do {
	$days[] = $dateinfo;

	$dateinfo = date ( 'm/d/Y' , strtotime ( '+1 day' , strtotime ( $dateinfo ) ) );
	$period-- ;
	} while ($period >= 0);

	return $days; 
}
?>