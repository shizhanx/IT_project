<?php
include APPPATH.'controllers/Objects/Objects.php';

class Family extends Objects
{
	private $database='family';
	private $relations=array('user'=>'userfamily');

	public function search($type, $value)
	{
		parent::mysearch($this->database, $type, $value);
	}

	public function create($current_user)
	{
//		$_POST['name']='99';
//		$_POST['description']='starlight';
		$related='user';
		parent::mycreate($this->database);
		$info[$related]=$current_user;
		$info[$this->database]=$_POST['name'];
		$this->relation->create($this->relations[$related],$info);
	}

	public function edit()
	{
		$_POST['old_name']='99';
		$_POST['name']='wife';
		parent::myedit($this->database);
		if ($_POST['old_name']!=$_POST['name']){
			foreach ($this->relations as $related=>$relation_database){
				$this->relation->edit($relation_database,
					array($this->database=>$_POST['old_name']),$this->database,$_POST['name']);
			}
		}
	}

	public function delete($name)
	{
		parent::mydelete($this->database,$name);
		foreach ($this->relations as $related=>$relation_database){
			$this->relation->delete($relation_database,array($this->database=>$name));
		}
	}
}
