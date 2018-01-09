<?php

class Dailywages_model extends CI_Model {

    //initialize the path where you want to save your images
    function __construct() {
        parent::__construct();
    }
    public function select_stmt($tbl)
		{
			$this->db->select('*');
        	if($conditions!=null)
        		$this->db->where($conditions);
        	if($orderBy!=null)
        		$this->db->order_by($orderBy);
        	if($limit!=null && is_numeric($limit))
            	$query = $this->db->get($tbl,$limit,$start);
        	else
            	$query = $this->db->get($tbl);

        	if ($query->num_rows() > 0) {
           		return $query->result_array();
        	} else {
            	return FALSE;
        	}
		}
}
