<?php
// Класс-контроллер для деавторизации пользователя
class Controller_Logout extends Controller {
	// Метод по умолчанию
	function action_index() {
		// Обнуление логина в переменной сессии
		$_SESSION['user'] = NULL;
		// Переадресация на страницу авторизации
		header("Location: $this->host/login");
	}
}