<?php


class Relation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Relation_model");
	}

	public function search($database,$info){
		return $this->Relation_model->search($database,$info);
	}

	public function create($database,$info){
		$this->Relation_model->create($database,$info);
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

	public function delete($database,$info){
		$this->Relation_model->delete($database,$info);
	}
}
