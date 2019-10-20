<?php


class Objects_model extends CI_Model
{
	public function  __construct()
	{
		$this->load->database();
	}

	public function mysearch($database,$type){
		if ($type=='exact'){
			$this->db->where('name', $_POST['search']);
			$query = $this->db->get($database);
		}elseif ($type=='include') {
			$this->db->like('name',$_POST['search'],'both');
			$this->db->or_like('description',$_POST['search'],'both');
			$query = $this->db->get($database);
		}elseif ($type=='generation'){
			if ($database!='user'){
				show_error('Wrong search method');
			}else{
				$this->db->where('generation', $_POST['search']);
				$query = $this->db->get($database);
			}
		}elseif ($type=='date'){
			if ($database!='event'){
				show_error('Wrong search method');
			}else{
				$this->db->where('date', $_POST['search']);
				$query = $this->db->get($database);
			}
		}
		return $query->result_array();
	}

	public function searchForward(){
		$this->db->where('date >', $_POST['today']);
		$query=$this->db->get('event');
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

	public function mydelete($database){
		$this->db->delete($database,array('name'=>$_POST['name']));
	}
}
