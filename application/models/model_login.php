<?php
// Класс модели авторизации, отвечающий за обмен данными для страницы авторизации
class Model_Login extends Model {
	// Мето для верификации введённого пароля с уже существущим по хэшу
	function login($login, $password) {		
		return password_verify($password, $this->db->getUserHash($login));
	}
}