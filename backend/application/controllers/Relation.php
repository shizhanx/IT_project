<?php


class Relation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Relation_model");
	}

	public function add_relation($database){
		if(!$this->Relation_model->add_relation($database)){
			show_error('No enough information POSTed');
		}
	}

	public function search($database,$searchBy,$value){
		$data['data']=$this->Relation_model->search($database,$searchBy,$value);
		$this->load->view('echo',$data);
	}
}
