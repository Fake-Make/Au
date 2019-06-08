<?php

class Controller_Main extends Controller {
	function action_index() {

		// Сначала нужно получить количество элементов и номер страницы
		$model = new Model_Main();
		$data['aucs'] = $model->getAuctions(18, 1);
		if(!is_array($data['aucs']))
			$data["auctions_status"] = "empty";
		else
			$data["auctions_status"] = "got";

		$this->view->generate('main_view.php', 'template_view.php', $data);
	}
}