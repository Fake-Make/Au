<?php

class Model_Registration extends Model {
	
	public function addUser($name, $login, $email, $password)	{
		$passwordHash = password_hash($password, PASSWORD_BCRYPT);
		if(!$this->db->addUser($name, $login, $email, $passwordHash))
			return false;
		
		return $this->db->addUserTable($this->db->getUserIdByLogin($login));
	}

}
