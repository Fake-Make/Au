<?php
// Класс модели диалога, отвечающий за обмен данными на странице аукциона
class Model_Dialog extends Model {
	// Метод для получения id диалога по его участникам
	function getDialogByMembers($person, $user) {
		return $this->db->getDialogByMembers($person, $user);
	}

	// Метод для получения имени пользователя по его id
	function getUserNameById($person) {
		return $this->db->getUserNameById($person);
	}

	// Метод для получения пользовательского id по его логину
	function getUserIdByLogin($login) {
		return $this->db->getUserIdByLogin($login);
	}

	// Метод для непосредственной отправки сообщения
	function sendMessage($from, $to, $what) {
		// Получение id диалога
		$dialog = $this->db->getDialogByMembers($from, $to);
		// Создание записи о диалоге, если таковая отсутствует
		if(!$dialog)
			$dialog = $this->db->createDialog($from, $to);
		// Если создание не удалось - возврат false
		if(false === $dialog)
			return false;
		// Если добавление сообщения не удалось - возврат false
		if(!$this->db->addMessage($dialog, $from, $to, $what))
			return false;
		// Иначе возврат id диалога
		return $dialog;
	}

	// Метод для получения второго участника диалога по имеющемуся первому
	function getSecondMemberByDialog($dialog, $user) {
		// Получение диалога по одному из участников
		$chat = $this->db->getSecondMemberByDialog($dialog);
		// Если ничего не пришло - возврат false
		if(!$chat || !is_array($chat))
			return false;
		// Если пользователь - инициатор, то вернуть получателя
		if($chat['initiator'] === $user)
			return $chat['recipient'];
		// Иначе наоборот
		if($chat['recipient'] === $user)
			return $chat['initiator'];
		return false;
	}

	// Метод для получения истории сообщений по id диалога
	function getChatByDialogId($dialog) {
		return $this->db->getChatByDialogId($dialog);
	}
}