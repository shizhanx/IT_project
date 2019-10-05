<?php


class Artifact extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Artifact_model");
	}

	public function get_artifact($type,$value){
		$data['artifacts']=$this->Artifact_model->get_artifacts($type,$value);
		$this->load->view('artifacts',$data);
	}

	public function create_artifact(){
		$exist=$this->Artifact_model->get_artifacts('exact',$_POST['name']);
		if (empty($exist)){
			$this->Artifact_model->create_artifact();
			$this->get_artifact('exact',$_POST['name']);
		}else{
			$this->error('Artifact already exist');
		}
	}

	public function error($msg){
		$data['error_msg']=$msg;
		$this->load->view('error',$data);
	}
}
