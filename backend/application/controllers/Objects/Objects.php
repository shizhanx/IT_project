<?php


class Objects extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Objects_model");
	}

	public function mysearch($database,$id_name,$type,$value){
		$data['data']=$this->Objects_model->mysearch($database,$id_name,$type,$value);
		$this->load->view('echo',$data);
	}

	public function mycreate($database){
		if (!isset($_POST['name'])){
			show_error('You must enter a name for this new object');
		}
		$exist=$this->Objects_model->mysearch($database,'exact_name',$_POST['name']);
		if (empty($exist)){
			$this->Objects_model->mycreate($database);
			$this->mysearch($database,'exact_name',$_POST['name']);
		}else{
			show_error('Object already exist');
		}
	}

	public function myedit($database,$id_name,$id){
		$object_array=$this->Objects_model->mysearch($database,$id_name,'exact',$id);
		if (empty($object_array)){
			show_error('No such object');
		}else {
			$object=$object_array[0];
			foreach ($object as $field => $value) {
				if ($field != $id_name && isset($_POST[$field])) {
					$object[$field] = $_POST[$field];
				}
			}
			$this->Objects_model->myedit($database,$object);
			$data['data']=$object;
			$this->load->view('echo',$data);
		}
	}

	public function mydelete($database,$id_name,$id){
		$this->Objects_model->mydelete($database,$id_name,$id);
	}
}
