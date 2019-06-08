<?php
// Класс-контроллер для страницы аукциона
class Controller_auction extends Controller {
	// Нельзя запросить просто аукцион
	function action_index()	{
		Route::ErrorPage404();
	}

	// Получаем аукцион по его уникальному идентификатору
	function action_id() {
		// Прежде всего нужно знать, какой аукцион мы ищем
		preg_match("!id=(\d+)!", $_SERVER['REQUEST_URI'], $matches);
		$model = new Model_Auction();

		$id = validator::validNaturalNumber($matches[1]);
		$login = validator::validAnyString($_SESSION['user']);
		
		if($login)
			$auction = $model->getAuctionById($id, $login);
		else
			$auction = $model->getAuctionById($id);
		if(false === $auction = $model->getAuctionById($id, $login))
			Route::ErrorPage404();

		$data['auction'] = $auction['0'];
		$data['user'] = $auction['1'];
		// Узнать id аукциона и пользователя
		// Запросить информацию по аукциону

		$this->view->generate('auction_view.php', 'template_view.php', $data);
	}
}