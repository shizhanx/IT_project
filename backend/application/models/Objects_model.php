<?php


class Objects_model extends CI_Model
{
	public function  __construct()
	{
		$this->load->database();
	}

	public function mysearch($database,$type,$value,$id_name){
		if ($type=='exact') {
			$this->db->where($id_name, $value);
			$query = $this->db->get($database);
		}elseif ($type=='exact_name'){
			$this->db->where('name', $value);
			$query = $this->db->get($database);
		}elseif ($type=='include') {
			$this->db->like('name',$value,'both');
			$this->db->or_like('description',$value,'both');
			$query = $this->db->get($database);
		}
		return $query->result_array();
	}

	public function mycreate($database){
		$fields=$this->db->list_fields($database);
		foreach ($fields as $field){
			if (isset($_POST[$field])){
				$data[$field]=$_POST[$field];
			}
		}
		return $this->db->insert($database,$data);
	}

	public function myedit($database,$new)
	{
		return $this->db->replace($database, $new);
	}

	public function mydelete($database,$id_name,$id){
		$this->db->delete($database,array($id_name=>$id));
	}
}
