<?php


class Artifact extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Artifact_model");
	}

	public function view($type,$value){
		$data['artifacts']=$this->Artifact_model->get_artifacts($type,$value);
		$this->load->view('artifacts',$data);
	}
}
