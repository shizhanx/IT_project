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
