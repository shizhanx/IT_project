<?php
include APPPATH.'controllers/Objects/Objects.php';

class Family extends Objects
{
	private $database='family';
	private $id_name='family_id';

	public function search($type, $value)
	{
		parent::mysearch($this->database, $this->id_name, $type, $value);
	}

	public function create()
	{
		parent::mycreate($this->database);
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
