<?php


class Objects extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Objects_model");
		$this->load->library('unit_test');
	}

	public function mysearch($database,$type,$value){
		$data['data']=$this->Objects_model->mysearch($database,$type,$value);
		$this->load->view('echo',$data);
		return $data['data'];
	}

	public function mycreate($database){
		if (!isset($_POST['name'])){
			show_error('You must enter a name for this new object');
		}
		$result=$this->Objects_model->mysearch($database,'exact',$_POST['name']);
		if (empty($result)){
			$this->Objects_model->mycreate($database);
			return $this->mysearch($database,'exact',$_POST['name']);
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

	public function myedit($database){
		if (!isset($_POST['name'])){
			show_error('You must enter a name for this new object');
		}
		$object_array=$this->Objects_model->mysearch($database,'exact',$_POST['name']);
		if (empty($object_array)){
			show_error('No such object');
		}else {
			$object=$object_array[0];
			foreach ($object as $field => $value) {
				if (isset($_POST[$field])) {
					$object[$field] = $_POST[$field];
				}
			}
			$this->Objects_model->myedit($database,$object);
			$data['data']=$object;
			$this->load->view('echo',$data);
			return $this->mysearch($database,'exact',$_POST['name']);
		}
	}

	public function test_edit($database){
		$result_array=$this->myedit($database);
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

	public function mydelete($database){
		if (!isset($_POST['name'])){
			show_error('You must enter a name for this new object');
		}
		$this->Objects_model->mydelete($database);
		$result_array=$this->mysearch($database,'exact',$_POST['name']);
		return empty($result_array);
	}

	public function testall($database){
		$_POST['name']='clock';
		$_POST['description']='tsuyusaki mahiru';
		$this->unit->run($this->test_create($database),true,'create');
		$_POST['description']='iwada haruki';
		$this->unit->run($this->test_edit($database),true,'edit');
		$this->unit->run($this->mydelete($database),true,'delete');
		echo $this->unit->report();
	}
}
