<?php


class Objects extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Objects_model");
	}

	//required POST fields:
	//id_name: ONLY WHEN $type='exact' the field name of the 'id' field of the searching object, i.e. user_id
	public function mysearch($database,$type,$value){
//		$_POST['id_name']='artifact_id';
		if ($type=='exact' && !isset($_POST['id_name'])){
			show_error('Please specify the field name of the id you searching');
		}
		$data['data']=$this->Objects_model->mysearch($database,$type,$value);
		$this->load->view('echo',$data);
	}

	// required POST fields:
	// name: the value of the field 'name' of the searching object
	public function mycreate($database){
//		$_POST['name']='mahiru';
//		$_POST['description']='koi no makyuu';
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

	// required POST fields:
	// id_name: ONLY WHEN $type='exact' the field name of the 'id' field of the searching object, i.e. user_id
	public function myedit($database,$id){
//		$_POST['id_name']='artifact_id';
//		$_POST['name']='green clock';
		if (!isset($_POST['id_name'])){
			show_error('Please specify the field name of the id you searching');
		}
		$object_array=$this->Objects_model->mysearch($database,'exact',$id);
		if (empty($object_array)){
			show_error('No such object');
		}else {
			$object=$object_array[0];
			foreach ($object as $field => $value) {
				if ($field != $_POST['id_name'] && isset($_POST[$field])) {
					$object[$field] = $_POST[$field];
				}
			}
			$this->Objects_model->myedit($database,$object);
			$data['data']=$object;
			$this->load->view('echo',$data);
		}
	}

	// required POST fields:
	// id_name: ONLY WHEN $type='exact' the field name of the 'id' field of the searching object, i.e. user_id
	public function mydelete($database,$id){
//		$_POST['id_name']='artifact_id';
		if (!isset($_POST['id_name'])){
			show_error('Please specify the field name of the id you searching');
		}
		$this->Objects_model->mydelete($database,$id);
	}
}
