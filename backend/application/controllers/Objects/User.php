<?php
include APPPATH.'controllers/Objects/Objects.php';

class User extends Objects
{
	private $database='user';

	public function search($type, $value)
	{
		parent::mysearch($this->database, $type, $value);
	}

	public function create()
	{
		parent::mycreate($this->database);
	}

	public function edit()
	{
		parent::myedit($this->database);
	}

	public function delete($name)
	{
		parent::mydelete($this->database,$name);
	}
}
