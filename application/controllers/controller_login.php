<?php
// Класс-контроллер для авторизации пользователя
class Controller_Login extends Controller {
	// Метод по умолчанию для проверки полей и авторизации пользователя
	function action_index() {
		// Если ничего не пришло, значит пользователь только что зашёл
		if(isset($_POST['login-name']) && isset($_POST['login-password'])) {
			// Иначе нужно проверить его данные
			$login = validator::validAnyString($_POST['login-name']);
			$password = validator::validAnyString($_POST['login-password']);

			$model = new Model_Login();
			if($model->login($login, $password)) {
				// Если логин и пароль введены верно - дать доступ пользователю
				// Записать его логин в переменную сессии
				session_start(); 				
				$_SESSION['user'] = $login;
				// И переадресовать на главную страницу
				header("Location: $this->host/");
			} else {
				// Иначе сообщить о неверных данных
				$data["login_status"] = "access_denied";
			}
		} else {
			$data["login_status"] = "";
		}
		
		// Непосредственная генерация страницы
		$this->view->generate('login_view.php', 'template_view.php', $data);
	}
}