<?php
// Супер-класс модели, от которого будут наследоваться остальные
class Model {
	// Атрибут класса - активное соединение с БД
	public $db;

	// Конструктор класса
	function __construct() {
		// Инициализация элемента класса для подключения к БД
		$this->db = new dataBase();
	}
}