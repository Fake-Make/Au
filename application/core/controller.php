<?php
// Супер-класс контроллера, от которого будут наследоваться остальные
class Controller {
	// Атрибуты класса - модель, представление и адрес текущего сервера
	public $model, $view, $host;
	
	// Конструктор класса
	function __construct() {
		// Инициализация просмотра
		$this->view = new View();
		// Определение адреса хоста
		$this->host = preg_replace("!/au\.ru/.*!", "/au.ru", strtolower($_SERVER['REQUEST_URI']));
	}
}
