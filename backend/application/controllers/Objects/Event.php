<?php
include APPPATH.'controllers/Objects/Objects.php';


class Event extends Objects
{
	private $database='event';
	private $related_table=array('user'=>'userevent','family'=>'eventfamily',
		'artifact'=>'eventartifact');

	public function search($type)
	{
		parent::mysearch($this->database, $type);
	}

	/*
	 * auto generates relations according to current user and family
	 * additional input:
	 * $_POST['current_user']: the name of the user logged in now
	 * $_POST['current_family']: the name of the family chosen now
	 */
	public function create()
	{
		parent::mycreate($this->database);
		$info['user']=$_POST['current_user'];
		$info[$this->database]=$_POST['name'];
		$this->relation->create($this->related_table['user'],$info);
		$info2['family']=$_POST['current_family'];
		$info2[$this->database]=$_POST['name'];
		$this->relation->create($this->related_table['family'],$info2);
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
