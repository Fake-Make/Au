<?php

class Controller_Login extends Controller {
	function action_index() {
		if(isset($_POST['login-name']) && isset($_POST['login-password'])) {
			$login = $_POST['login-name'];
			$password = $_POST['login-password'];

			$model = new Model_Login();
			if($model->login($login, $password)) {
				$data["login_status"] = "access_granted";
				
				session_start(); 
				
				$_SESSION['user'] = $login;
				header("Location: $this->host/");
			} else {
				$data["login_status"] = "access_denied";
			}
		} else {
			$data["login_status"] = "";
		}
		
		$this->view->generate('login_view.php', 'template_view.php', $data);
	}
}