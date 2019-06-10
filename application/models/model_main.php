<?php
// Класс модели списка аукционов, отвечающий за обмен данными на странице списка аукционов
class Model_Main extends Model {
	// Метод для получения списка аукционов с учётом постраничной навигации
	function getAuctions($size, $page) {
		return $this->db->getAuctionsList($size, $page);
	}

	// Метод для получения максимального числа страниц с учётом постраничной навигации
	function getMaxPages($size)	{
		return $this->db->getMaxPages($size);
	}
}