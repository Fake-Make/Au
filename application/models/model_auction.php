<?php
// Класс модели аукциона, отвечающий за обмен данными на странице аукциона
class Model_Auction extends Model {
	// Метод для получения данных об аукционе по его id
	function getAuctionById($id, $login = NULL) {
		// Получение данных об аукционе
		$arr = $this->db->getAuctionById($id);
		// Если данных нет, вернуть false
		if(!is_array($arr))
			return false;
		$arr['id'] = $id;
		// Если пользователь авторизован, то получить так же его id по логину
		$user = $login ? $this->db->getUserIdByLogin($login) : NULL;
		// Вернуть данные в виде массива: аукцион и id пользователя
		return [$arr, $user];
	}

	// Метод для повышения ставки
	function addRise($auction, $user, $rise) {
		// Добавление аукциона в список активных аукционов пользователя
		$this->db->addAuctionToUser($auction, $user);
		// Непосредственное повышение ставки
		return $this->db->addRise($auction, $user, $rise);
	}
}