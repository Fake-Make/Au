<?php
// Класс модели регистрации, отвечающий за обмен данными для страницы регистрации
class Model_Registration extends Model {
	// Метод для создания учётной записи пользователя
	function addUser($name, $login, $email, $password)	{
		// Хэширование пароля
		$passwordHash = password_hash($password, PASSWORD_BCRYPT);
		// Если добавить запись не удалось - возврат false
		if(!$this->db->addUser($name, $login, $email, $passwordHash))
			return false;
		// Иначе возвращается результат запроса на создание таблицы списка активных аукционов пользователя
		return $this->db->addUserTable($this->db->getUserIdByLogin($login));
	}
}
