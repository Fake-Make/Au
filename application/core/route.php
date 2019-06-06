<?php

/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> цепляет классы контроллеров и моделей;
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/
class Route {
	static function start() {
		$db = new dataBase();
		// контроллер и действие по умолчанию
		$controller_name = 'Main';
		$action_name = 'index';

		$host = preg_replace("!/Au/.*!", "/Au", $_SERVER['REQUEST_URI']);

		$routes = explode('/', str_replace($host, "", $_SERVER['REQUEST_URI']));
		//		/~administrator/Au -> $serverConstant
		/*
		http://localhost/~administrator/Au/
		http://localhost/~administrator/Au/services
		*/
		// получаем имя контроллера
		if ( !empty($routes[1])) {
			$controller_name = $routes[1];
		}
		
		// получаем имя экшена
		if ( !empty($routes[2]) ) {
			$action_name = $routes[2];
		}

		// добавляем префиксы
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		/*
		echo "Model: $model_name <br>";
		echo "Controller: $controller_name <br>";
		echo "Action: $action_name <br>";
		*/
		

		// подцепляем файл с классом модели (файла модели может и не быть)

		$model_file = strtolower($model_name).'.php';
		$model_path = "application/models/".$model_file;
		if(file_exists($model_path)) {
			include "application/models/".$model_file;
		}

		// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path)) {
			include "application/controllers/".$controller_file;
		}	else {
			/*
			правильно было бы кинуть здесь исключение,
			но для упрощения сразу сделаем редирект на страницу 404
			*/
			Route::ErrorPage404();
		}
		
		// создаем контроллер
		$controller = new $controller_name;
		$action = $action_name;
		
		if(method_exists($controller, $action))	{
			// вызываем действие контроллера
			$controller->$action();
		} else {
			// здесь также разумнее было бы кинуть исключение
			Route::ErrorPage404();
		}
	}

	function ErrorPage404()	{
		$host = preg_replace("!/Au/.*!", "/Au", $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
    header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header("Location: $host/404");
  }    
}