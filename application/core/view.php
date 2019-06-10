<?php
// Супер-класс представления, от которого будут наследоваться остальные
class View {
	// Атрибут класса - адрес текущего сервера
	public $host;
	
	// Метод для включения основного контента страницы в шаблон по умолчанию
	function generate($content_view, $template_view, $data = null) {
		// Определение адреса хоста
		$this->host = preg_replace("!/au\.ru/.*!", "/au.ru", strtolower($_SERVER['REQUEST_URI']));
		// Подключение шаблона страницы по умолчанию
		include 'application/views/' . $template_view;
	}
}
