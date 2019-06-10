<?php
// Класс-контроллер для страницы создания аукциона
class Controller_create extends Controller {
	// Действие по умолчанию - создание аукциона
	function action_index()	{
		// Проверка входных данных
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

				// Валидация загружаемого файла
				if(isset($_FILES['file'])) {
					$file_temp = $_FILES['file']['tmp_name'];   
					$imageinfo = getimagesize($file_temp);
					if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg') {
						$data["creating_status"] = "photoError";
					} else {
						$uploaddir = 'photos/';
						$uploadfile = $uploaddir . basename($file_temp) . ".jpeg";
						if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
							$data["creating_status"] = "photoError";
					}
				}

				// ВАЛИДАЦИЯ
				if($name && $date && $data["creating_status"] !== "errors" && $data["creating_status"] !== "photoError") {
					// ДОБАВЛЕНИЕ ДАННЫХ
					$model = new Model_CreateAuction();
					// Обязательно что-то сделать с файлом
					$user = validator::validAnyString($_SESSION['user']);
					if($model->addAuction($name, $description, $initRate, $date, $user, $uploadfile))
						header("Location: $this->host/");	// ПЕРЕАДРЕСАЦИЯ НА СТРАНИЦУ АУКЦИОНА
					else
						$data["creating_status"] = "errors";
				}
			}
		}			
		
		// Непосредственная генерация страницы
		$this->view->generate('create_view.php', 'template_view.php', $data);
	}
}