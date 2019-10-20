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
	 * $_POST['current_user']: when this user is created by the current user
	 * $_POST['title']: how the current user address this new user
	 * $_POST['generation']: the difference in generation of the current user and new user
	 */
	public function create()
	{
		parent::mycreate($this->database);
		if (isset($_POST['current_family'])) {
			$info['family'] = $_POST['current_family'];
			$info[$this->database] = $_POST['name'];
			$this->relation->create($this->related_table['family'], $info);
		}
		if (isset($_POST['current_user'])){
			if (!isset($_POST['title']) || !isset($_POST['generation'])){
				show_error('information not enough');
			}else{
				$relativeInfo=array('user1'=>$_POST['current_user'], 'user2'=>$_POST['name'],
					'title'=>$_POST['title'], 'generation'=>$_POST['generation'],
					'image'=>$_POST['image']);
				$this->relation->create($this->related_table['user'], $relativeInfo);
			}
		}
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
