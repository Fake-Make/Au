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
		
		// Если пользователь авторизован, для него нужно узнать и id
		if($login)
			$auction = $model->getAuctionById($id, $login);
		else
			$auction = $model->getAuctionById($id);
		// Если аукциона не существует
		if(false === $auction = $model->getAuctionById($id, $login))
			Route::ErrorPage404();

		$minRate = $auction['0']['curRate'] ? $auction['0']['curRate'] : $auction['0']['initRate'];
		$minStep = $auction['0']['initRate'] * 0.05;

		$data['auction'] = $auction['0'];
		$data['user'] = $auction['1'];
		$data['minRate'] = $minRate;
		$data['minStep'] = $minStep;

		// Если пользователь повысил ставку
		if(!empty($_POST)) {
			// Если пользователь не существует
			if(!$data['user'])
				Route::ErrorPage404();
			// Если организатор повышает ставку
			if($data['auction']['ownerId'] == $data['user'])
				Route::ErrorPage404();
			// Если аукцион не активен
			if($data['auction']['status'] !== 'active')
				Route::ErrorPage404();
			// Если пришла ставка меньше минимально возможной
			if($minRate + $minStep > $rise = validator::validPositiveFloat($_POST['rise']))
				Route::ErrorPage404();
			
			// Если истории ставок нет
				// То создать такую
			// Добавить в историю ставок новую ставку
			// Изменить текущую ставку для данного аукциона
			
			// Переадресовать пользователя на страницу с аукционом
			header("Location: $this->host/auction/id=$id");			
		}

		$this->view->generate('auction_view.php', 'template_view.php', $data);
	}
}