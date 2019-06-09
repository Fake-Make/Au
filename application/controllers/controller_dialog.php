<?php

class Controller_dialog extends Controller {
	// Переход к действию по-умолчанию должен вызывать редирект на 404
	function action_index() {
		Route::ErrorPage404();
	}

	// Переход со страницы аукциона не означает существование диалога
	function action_person() {
		$model = new Model_Dialog();
		// 1. Прежде всего нужно знать, кто мы и с кем говорим
		preg_match("!person=(\d+)!", $_SERVER['REQUEST_URI'], $matches);
		$person = validator::validNaturalNumber($matches[1]);
		preg_match("!user=(\d+)!", $_SERVER['REQUEST_URI'], $matches);
		$user = validator::validNaturalNumber($matches[1]);

		// 2. Есть ли такой диалог?
		$id = $model->getDialogByMembers($person, $user);
		if($id)
			$this->action_id($id, $person, $user);
		else {
			// 3. Получение имени собеседника по его id
			$personName = $model->getUserNameById($person);

			$data['person'] = $person;
			$data['user'] = $user;
			$data['personName'] = $personName;
			$data['dialog_status'] = "Not exists";
			// Иначе отобразить поля со значениями: Инициатор, Приёмник, Собщение
				// При отправке сообщение будет снабжаться этими параметрами и таймштампом
				// Если диалога нет, он будет создаваться при отправке
			$this->view->generate('dialog_view.php', 'template_view.php', $data);
		}		
	}

	// Переход со страницы списка диалогов может означать существование диалога
	function action_id($id = NULL, $person = NULL, $user = NULL) {
		$this->view->generate('dialog_view.php', 'template_view.php');
	}

	function action_send() {
		$model = new Model_Dialog();
		// 1. Прежде всего нужно получить текст, автора и получателя
		// Проверить получателя
		preg_match("!person=(\d+)!", $_SERVER['REQUEST_URI'], $matches);
		if(!($person = validator::validNaturalNumber($matches[1])))
			Route::ErrorPage404();
		// Проверить отправителя
		if(!($user = $model->getUserIdByLogin(validator::validAnyString($_SESSION['user']))))
			Route::ErrorPage404();
		// Различны ли получатель и юзер
		if($user == $person)
		Route::ErrorPage404();
		// Получить сообщение
		$messageContent = validator::validAnyString($_POST['dialog-message']);

		// Отправка сообщения
		if(!$model->sendMessage($user, $person, $messageContent)) {
			$data['send_status'] = "Not sent<br>";
			echo "Not Sent";
		}
			
		echo "От $user к $person: $messageContent";
		// Сформировать сообщение
		// Если успешно, то редирект в этот же диалог
		//$this->view->generate('dialog_view.php', 'template_view.php');
	}
}