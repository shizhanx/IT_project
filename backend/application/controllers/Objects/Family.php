<?php
include APPPATH.'controllers/Objects/Objects.php';

class Family extends Objects
{
	private $database='family';
	private $related_table=array('user'=>'userfamily','event'=>'eventfamily');

	public function search($type)
	{
		$_POST['search']='starlight 99';
		parent::mysearch($this->database, $type);
	}

	/*
	 * auto generates relations according to current user's name
	 * additional input:
	 * $_POST['current_user']: the name of the user logged in now
	 */
	public function create()
	{
		parent::mycreate($this->database);
		$info['user']=$_POST['current_user'];
		$info[$this->database]=$_POST['name'];
		$this->relation->create($this->related_table['user'],$info);
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
