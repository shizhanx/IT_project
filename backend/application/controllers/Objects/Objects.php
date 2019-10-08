<?php


class Objects extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Objects_model");
		$this->load->library('unit_test');
	}

	public function mysearch($database,$type,$value,$id_name=null){
		$data['data']=$this->Objects_model->mysearch($database,$type,$value,$id_name);
		$this->load->view('echo',$data);
		return $data['data'];
	}

	public function mycreate($database){
		if (!isset($_POST['name'])){
			show_error('You must enter a name for this new object');
		}
		$exist=$this->Objects_model->mysearch($database,'exact_name',$_POST['name'],null);
		if (empty($exist)){
			$this->Objects_model->mycreate($database);
			return $this->mysearch($database,'exact_name',$_POST['name']);
		}else{
			show_error('Object already exist');
		}
	}

	public function test_create($database){
		$result_array=$this->mycreate($database);
		if (count($result_array)==0){
			return false;
		}
		foreach ($result_array[0] as $key=>$value){
			if (isset($_POST[$key]) && $_POST[$key]!=$value){
				return false;
			}
		}
		return true;
	}

	public function myedit($database,$id_name,$id){
		$object_array=$this->Objects_model->mysearch($database,'exact',$id,$id_name);
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
			return $this->mysearch($database,'exact',$id,$id_name);
		}
	}

	public function test_edit($database,$id_name,$id){
		$result_array=$this->myedit($database,$id_name,$id);
		if (count($result_array)==0){
			return false;
		}
		foreach ($result_array[0] as $key=>$value){
			if (isset($_POST[$key]) && $_POST[$key]!=$value){
				return false;
			}
		}
		return true;
	}

	public function mydelete($database,$id_name,$id){
		$this->Objects_model->mydelete($database,$id_name,$id);
		$result_array=$this->mysearch($database,'exact',$id,$id_name);
		return empty($result_array);
	}

	public function testall($database,$id_name,$id){
		$_POST['name']='clock';
		$_POST['description']='tsuyusaki mahiru';
		$this->unit->run($this->test_create($database),true,'create');
		$_POST['name']='green';
		$this->unit->run($this->test_edit($database,$id_name,$id),true,'edit');
		$this->unit->run($this->mydelete($database,$id_name,$id),true,'delete');
		echo $this->unit->report();
	}
}
