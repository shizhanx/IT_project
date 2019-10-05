<?php


class Artifact_model extends CI_Model
{
	public function  __construct()
	{
		$this->load->database();
	}

	public function get_artifacts($type,$value){
		if ($type=='exact'){
			$this->db->where('artifact_id',$value);
			$this->db->or_where('name',$value);
			$query = $this->db->get('artifacts');
		}elseif ($type=='include') {
			$this->db->like('name',$value,'both');
			$this->db->or_like('description',$value,'both');
			$query = $this->db->get('artifacts');
		}
		return $query->result_array();
	}

	public function create_artifact(){
		$data=array(
			'name'=>$_POST['name'],
			'description'=>$_POST['description']
		);
		return $this->db->insert('artifacts',$data);
	}
}
