<?php
include APPPATH.'controllers/Objects/Objects.php';

class Artifact extends Objects
{
	private $database='artifact';
	private $id_name='artifact_id';

	public function search($type, $value)
	{
		parent::mysearch($this->database, $type, $value, $this->id_name);
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
