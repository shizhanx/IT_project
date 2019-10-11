<?php
include APPPATH.'controllers/Objects/Objects.php';

class Artifact extends Objects
{
	private $database='artifact';

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

	public function delete()
	{
		parent::mydelete($this->database);
	}
}
