<?php

class Controller_create extends Controller {
	function action_index()	{
		if(empty($_POST)) {
			$data["creating_status"] = "";
		} else {
			// Если что-то пришло, надо обработать
			if(empty($_POST['good-name']) || empty($_POST['good-initRate']) || empty($_POST['good-date'])) {
				// Пришли не все обязательные поля
				$data["creating_status"] = "empty";
			}	else {
				// Пришли все поля, но их нужно валидировать
				$name = validator::validAnyString($_POST['good-name']);
				$description = validator::validAnyString($_POST['good-description']);
				$initRate = validator::validPositiveFloat($_POST['good-initRate']);
				$date = validator::validNaturalNumber($_POST['good-date']);
				//$fileName = $_POST['good-photo'];

				// ВАЛИДАЦИЯ
				if($name && $date) {
					// ДОБАВЛЕНИЕ ДАННЫХ
					$model = new Model_CreateAuction();
					// Обязательно что-то сделать с файлом
					$user = validator::validAnyString($_SESSION['user']);
					if($model->addAuction($name, $description, $initRate, $date, $user, $fileName))
						header("Location: $this->host/");	// ПЕРЕАДРЕСАЦИЯ НА СТРАНИЦУ АУКЦИОНА
					else
						$data["creating_status"] = "errors";
				}
			}
		}			
		
		$this->view->generate('create_view.php', 'template_view.php', $data);
	}
}