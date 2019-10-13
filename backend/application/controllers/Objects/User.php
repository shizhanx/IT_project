<?php
include APPPATH.'controllers/Objects/Objects.php';

class User extends Objects
{
	private $database='user';
	private $related_table=array('family'=>'userfamily','user'=>'userrelation',
		'event'=>'userevent','artifact'=>'artifactuser');

	public function search($type)
	{
		parent::mysearch($this->database, $type);
	}

	/*
	 * auto generates relations according to current family's name
	 * additional input:
	 * $_POST['current_family']: the name of the family chosen now
	 */
	public function create()
	{
		parent::mycreate($this->database);
		$info['family']=$_POST['current_family'];
		$info[$this->database]=$_POST['name'];
		$this->relation->create($this->related_table['family'],$info);
	}

	public function edit()
	{
		parent::myedit($this->database,$this->related_table);
	}

	public function delete()
	{
		parent::mydelete($this->database,$this->related_table);
	}
}
