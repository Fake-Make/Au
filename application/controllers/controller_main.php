<?php

class Controller_Main extends Controller {
	function action_index() {
		$this->action_page();
	}

	function action_page() {
		// Прежде всего нужно знать, на какой странице мы находимся
		preg_match("!page=(\d+)!", $_SERVER['REQUEST_URI'], $matches);
		$page = validator::validNaturalNumber($matches[1]);
		// Сначала нужно получить количество элементов и номер страницы
		$model = new Model_Main();
		$data['aucs'] = $model->getAuctions(MAX_GOODS_ON_PAGE, $page);
		if(!is_array($data['aucs']))
			$data["auctions_status"] = "empty";
		else
			$data["auctions_status"] = "got";

		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
}