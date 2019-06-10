<?php
// Класс модели личного кабинета, отвечающий за обмен данными для страницы личного кабинета
class Model_Personal extends Model {
	// Метод для получения максимального числа страниц в зависимости от вкладки
	function getMaxPagesForPersonal($size, $user, $tab) {
		return $this->db->getMaxPagesForPersonal($size, $user, $tab);
	}

	// Метод для получения списка аукционов, в которых участвует пользователь
	function getPersonalAuctions($size, $page, $user, $tab) {
		return $this->db->getPersonalAuctions($size, $page, $user, $tab);
	}

	// Метод для получения пользовательского id по его логину
	function getUserIdByLogin($login) {
		return $this->db->getUserIdByLogin($login);
	}

	// Метод для получения списка диалогов по id пользователя
	function getDialogsById($user) {
		return $this->db->getDialogsById($user);
	}
}