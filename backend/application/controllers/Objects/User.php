<?php
include APPPATH.'controllers/Objects/Objects.php';

class User extends Objects
{
	private $database='user';
	private $id_name='user_id';

	public function search($type, $value)
	{
		parent::mysearch($this->database, $type, $value, $this->id_name);
	}

	public function create()
	{
		if (!isset($_POST['name'])){
			show_error('You must enter a name for this new object');
		}
		$id=$this->Objects_model->mycreate($this->database);
		$this->search('exact',$id);
	}

	public function edit($id)
	{
		parent::myedit($this->database, $this->id_name, $id);
	}

	public function delete($id)
	{
		parent::mydelete($this->database, $this->id_name, $id);
	}
}
