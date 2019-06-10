<?php
// Класс-контроллер для главной страницы
class Controller_Main extends Controller {
	// Метод для обработки запроса к странице без параметров
	function action_index() {
		// Переадресация на главную страницу с параметров page=1
		header("Location: $this->host/main/page=1");
	}

	// Метод для обработки запроса с параметром page
	function action_page() {
		// Прежде всего нужно знать, на какой странице мы находимся
		preg_match("!page=(\d+)!", $_SERVER['REQUEST_URI'], $matches);
		// Сначала нужно получить количество элементов и номер страницы
		$model = new Model_Main();
		
		// Получение и подготовка для отображения
		$data['maxPages'] = $model->getMaxPages(MAX_GOODS_ON_PAGE);
		if($data['maxPages'] < $page = validator::validNaturalNumber($matches[1]))
			$page = validator::validNaturalNumber($data['maxPages']);
		$data['aucs'] = $model->getAuctions(MAX_GOODS_ON_PAGE, $page);
		$data['page'] = $page;
		// Проверка списка аукционов на пустоту
		if(!is_array($data['aucs']))
			$data["auctions_status"] = "empty";
		else
			$data["auctions_status"] = "got";

		// Непосредственная генерация страницы
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
}