<?php


class Relation_model extends CI_Model
{
	public function  __construct()
	{
		$this->load->database();
	}

	public function search($database,$info){
		$query=$this->db->get_where($database,$info);
		return $query->result_array();
	}

	public function mycreate($database){
		$fields=$this->db->list_fields($database);
		foreach ($fields as $field){
			if (isset($_POST[$field])){
				$data[$field]=$_POST[$field];
			}else{
				show_error('no enough information POSTed');
			}
		}
		return $this->db->insert($database,$data);
	}

	public function create($database,$info){
		$existing=$this->search($database,$info);
		if (empty($existing)) {
			return $this->db->insert($database, $info);
		}
	}

	public function edit($database,$new){
		$this->db->replace($database,$new);
	}

	public function delete($database,$info){
		$this->db->delete($database,$info);
	}
}
