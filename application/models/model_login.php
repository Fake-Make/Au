<?php

class Model_Login extends Model {
	
	public function login($login, $password) {		
		return password_verify($password, $this->$db->getUserHash($login));
	}

}
