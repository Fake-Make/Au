<?php

class Controller_registration extends Controller {
	function action_index()	{
		if(empty($_POST)) {
			$data["registration_status"] = "";
		} else {
			$count = 5 - empty($_POST['registration-name']) -
				empty($_POST['registration-nick']) -
				empty($_POST['registration-email']) -
				empty($_POST['registration-password']) -
				empty($_POST['registration-password-again']);
			if(5 === $count) {
				$name = validator::validAnyString($_POST['registration-name']);
				$login = validator::validAnyString($_POST['registration-nick']);
				$email = validator::validAnyString($_POST['registration-email']);
				$password = validator::validAnyString($_POST['registration-password']);
				$passwordRepeat = validator::validAnyString($_POST['registration-password-again']);
				
				if($password==$passwordRepeat) {
					$model = new Model_Registration();
					$model->addUser($name, $login, $email, $password);

					$data["registration_status"] = "success";
					// Валидация почты, ника, пароля
					
					$_SESSION['user'] = $login;
					header("Location: $this->host/");
				} else {
					$data["registration_status"] = "errors";
				}
			} else {
				$data["registration_status"] = "empty";
			}
		}			
		
		$this->view->generate('registration_view.php', 'template_view.php', $data);
	}
}