<?php
// Класс модели создания аукциона, отвечающий за обмен данными на странице создания аукциона
class Model_CreateAuction extends Model {
	// Метод для добавления аукциона
	function addAuction($name, $description, $initRate, $date, $user, $photo = "NULL")	{
		// Фиксация временной метки создания аукциона
		$dt = time() + $date * 60 * 60;
		// Возврат статуса запроса: успешен или нет
		return $this->db->addAuction($name, $description, $initRate, $dt, $user, $photo);
	}
}