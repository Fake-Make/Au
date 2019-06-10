<?php
// Класс-маршрутизатор для определения запрашиваемой страницы
// Добавляет классы контроллеров и моделей
// Создает экземпляры контролеров страниц и вызывает действия этих контроллеров
class Route {
	// Метод для инициализации машрутизации
	static function start() {
		// Контроллер и действие по умолчанию
		$controller_name = 'main';
		$action_name = 'index';

		// Определение адреса хоста
		$host = preg_replace("!/au\.ru/.*!", "/au.ru", strtolower($_SERVER['REQUEST_URI']));
		// Определение запрашиваемой страницы
		$routes = explode('/', str_replace($host, "", strtolower($_SERVER['REQUEST_URI'])));
		
		// После первого / идёт имя контроллера
		if ( !empty($routes[1])) {
			$controller_name = $routes[1];
		}
		
		// После второго / идёт имя метода контроллера
		if ( !empty($routes[2]) ) {
			$action_name = preg_replace("!=.*!", "", $routes[2]);
		}

		// Добавление префиксов для правильного получения требуемых файлов
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		// Добавление файла с классом модели (файла модели может и не быть)
		$model_file = strtolower($model_name).'.php';
		$model_path = "application/models/".$model_file;
		if(file_exists($model_path)) {
			include "application/models/".$model_file;
		}

		// Добавление файла с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path)) {
			include "application/controllers/".$controller_file;
		}	else {
			Route::ErrorPage404();
		}
		
		// Инициализация контроллера
		$controller = new $controller_name;
		$action = $action_name;
		
		// Вызов метода контроллера
		if(method_exists($controller, $action))	{
			$controller->$action();
		} else {
			// Переадресация на страницу 404, если такого метода нет
			Route::ErrorPage404();
		}
	}

	// Метод для переадресации на страницу ошибки с кодом 404
	function ErrorPage404()	{
		// Определение адреса хоста
		$host = preg_replace("!/au\.ru/.*!", "/au.ru", strtolower($_SERVER['REQUEST_URI']));
		// Передача HTTP-заголовков с кодом ошибки
		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		// Непосредственная переадресация на страницу ошибки 404
		header("Location: $host/404");
  }
}