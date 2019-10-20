<?php
include APPPATH.'controllers/Relation.php';

class Objects extends CI_Controller
{
	protected $relation;

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Objects_model");
		$this->load->library('unit_test');
		$this->relation=new Relation();
	}

	/*
	 * Expected input:
	 * $database: the name of the table you want to search in
	 * $type: 'exact' for exact name match or 'include' for value included in either name or description
	 * $_POST['search']: the string you want to search for
	 * return: an array of matching records, can be empty if not found.
	 */
	public function mysearch($database,$type){
		if (!isset($_POST['search'])){
			show_error('You must search something');
		}
		$data['data']=$this->Objects_model->mysearch($database,$type);
		$this->load->view('echo',$data);
		return $data['data'];
	}

	public function returnSearch($database,$type){
		if (!isset($_POST['search'])){
			show_error('You must search something');
		}
		return $this->Objects_model->mysearch($database,$type);
	}

	/*
	 * Expected input:
	 * $database: the name of the table you want to create in
	 * $_POST['name']: the name of the object. Required!
	 * $_POST[other fields]: other fields in this object
	 * return: an array of one element: the created object. Or an empty array if failed.
	 */
	public function mycreate($database){
		$_POST['search']=$_POST['name'];
		if (!isset($_POST['name'])){
			show_error('You must enter a name for this new object');
		}
		//see if there's already an object with this name.
		$result=$this->Objects_model->mysearch($database,'exact');
		if (empty($result)){
			$this->Objects_model->mycreate($database);
			return $this->mysearch($database,'exact');
		}else{
			show_error('Object already exist');
		}
	}

	/*
	 * Expected input:
	 * $database: the name of the table you want to create in
	 * $_POST['old_name']: the original name of the object you want to edit
	 * $_POST['name']: the name of the object after you edit. If not editing name, should be same as old_name
	 * $_POST['other fields']
	 * return: a one-element array of the object after editing.
	 */
	public function myedit($database,$related_table){
		if (!isset($_POST['name'])){
			show_error('You must enter a name for this new object');
		}elseif (!isset($_POST['old_name'])){
			show_error('You must set the original name of this new object');
		}
		//to check whether the editing object exists. If editing the name, check whether new name already exists.
		$_POST['search']=$_POST['old_name'];
		$old_name_result_array=$this->Objects_model->mysearch($database,'exact');
		$_POST['search']=$_POST['old_name'];
		$new_name_result_array=$this->Objects_model->mysearch($database,'exact');
		if (empty($old_name_result_array)){
			show_error('No such object');
		}elseif ($_POST['old_name']!=$_POST['name'] && !empty($new_name_result_array)){
			show_error('New name already registered');
		}else {
			//edit each field in the object according to data POSTed
			$object=$old_name_result_array[0];
			foreach ($object as $field => $value) {
				if (isset($_POST[$field])) {
					$object[$field] = $_POST[$field];
				}
			}
			$this->Objects_model->myedit($database,$object);
			//if editing name, the old object needs to be deleted manually since name is
			// the primary key. Then edit all the relations accordingly
			if ($_POST['old_name']!=$_POST['name']){
				//mydelete requires $_POST['name'] to be the deleting object's name
				$temp=$_POST['name'];
				$_POST['name']=$_POST['old_name'];
				$this->mydelete($database);
				$_POST['name']=$temp;
				foreach ($related_table as $field=>$table_name){
					$this->relation->edit($table_name,
						array($database=>$_POST['old_name']),$database,$_POST['name']);
				}
			}
			$_POST['search']=$_POST['name'];
			$this->mysearch($database,'exact');
		}
	}

	/*
	 * Expected input:
	 * $database: the name of the table you want to delete in
	 * $_POST['name']: the name of the object. Required!
	 */
	public function mydelete($database,$related_table){
		if (!isset($_POST['name'])){
			show_error('You must enter a name for this new object');
		}
		$this->Objects_model->mydelete($database);
		foreach ($related_table as $field=>$table_name){
			$this->relation->delete($table_name,array($database=>$_POST['name']));
		}
	}

	public function testall($database){
		echo $this->unit->report();
	}
}
