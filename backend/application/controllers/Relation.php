<?php


class Relation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Relation_model");
	}

	/*
	 * api for front end
	 * required input:
	 * $database: the name of the relation table
	 * $_POST['search_by']: the name of the field searching on
	 * $_POST['value']: the value searching for
	 */
	public function mysearch($database){
		if (!isset($_POST['search_by']) || !isset($_POST['value'])){
			show_error('no enough information POSTed');
		}
		$info[$_POST['search_by']]=$_POST['value'];
		$data['data']=$this->search($database,$info);
		$this->load->view('echo',$data);
	}

	public function search($database,$info){
		return $this->Relation_model->search($database,$info);
	}

	/*
	 * api for front end
	 * required input:
	 * $database: the name of the relation table
	 */
	public function mycreate($database){
		$data['data']=$this->Relation_model->mycreate($database);
		$this->load->view('echo',$data);
	}

	public function create($database,$info){
		$this->Relation_model->create($database,$info);
	}

	/*
	 * api for front end
	 * required input:
	 * $database: the name of the relation table
	 * $_POST['info']: an array of the criteria of rows you trying to edit
	 * $_POST['field']: name of the specific field you trying to edit
	 * $_POST['value']: new value of that field
	 */
	public function myedit($database){
		if (!isset($_POST['info']) || !isset($_POST['field']) || !isset($_POST['value'])){
			show_error('no enough information POSTed');
		}
		$data['data']=$this->edit($database,$_POST['info'],$_POST['field'],$_POST['value']);
		$this->load->view('echo',$data);
	}

	public function edit($database,$known_info,$new_field,$new_value){
		$result_array=$this->search($database,$known_info);
		$this->delete($database,$known_info);
		foreach ($result_array as $key=>$value){
			$result_array[$key][$new_field]=$new_value;
		}
		foreach ($result_array as $info) {
			$this->create($database,$info);
		}
	}

	/*
	 * api for front end
	 * required input:
	 * $database: the name of the relation table
	 * $_POST['info']: an array of the criteria of rows you trying to delete
	 */
	public function mydelete($database){
		if (!isset($_POST['info'])){
			show_error('no enough information POSTed');
		}
		$this->delete($database,$_POST['info']);
	}

	public function delete($database,$info){
		$this->Relation_model->delete($database,$info);
	}
}
