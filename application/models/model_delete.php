<?php
// Класс модели удаления аукциона, отвечающий за обмен данными для действия удаления аукциона
class Model_Delete extends Model {
	// Метод для получения id пользователя по его логину
	function getUserIdByLogin($login)	{
		return $this->db->getUserIdByLogin($login);
	}

	// Метод для получения id владельца аукциона
	function getOwnerByAuction($auction)	{
		return $this->db->getOwnerByAuction($auction);
	}

	// Метод для удаления аукциона по его id
	function deleteAuction($auction)	{
		return $this->db->deleteAuction($auction);
	}
}