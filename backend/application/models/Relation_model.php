<?php


class Relation_model extends CI_Model
{
	public function  __construct()
	{
		$this->load->database();
	}

	public function add_relation($database){
		$fields=$this->db->list_fields($database);
		foreach ($fields as $field){
			if (!isset($_POST[$field])){
				return FALSE;
			}else{
				$data[$field]=$_POST[$field];
			}
		}
		return $this->db->insert($database,$data);
	}

	public function search($database,$searchBy,$value){
		$query=$this->db->get_where($database,array($searchBy=>$value));
		return $query->result_array();
	}
}
