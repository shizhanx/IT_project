<?php


class Artifact_model extends CI_Model
{
	public function  __construct()
	{
		$this->load->database();
	}

	public function get_artifacts($type,$value){
		if ($type=='exact') {
			$this->db->where('artifact_id', $value);
			$query = $this->db->get('artifact');
		}elseif ($type=='exact_name'){
			$this->db->where('name', $value);
			$query = $this->db->get('artifact');
		}elseif ($type=='include') {
			$this->db->like('name',$value,'both');
			$this->db->or_like('description',$value,'both');
			$query = $this->db->get('artifact');
		}
		return $query->result_array();
	}

	public function create_artifact(){
		$data=array(
			'name'=>$_POST['name'],
			'description'=>$_POST['description']
		);
		return $this->db->insert('artifact',$data);
	}

	public function edit_artifact($new)
	{
		$this->db->replace('artifact', $new);
	}

	public function delete_artifact($id){
		$this->db->delete('artifact',array('artifact_id'=>$id));
	}
}
