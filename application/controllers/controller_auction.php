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
				$data['riseStatus'] = 'Error';
			// Если организатор повышает ставку
			if($data['auction']['ownerId'] == $data['user'])
				$data['riseStatus'] = 'Error';
			// Если аукцион не активен
			if($data['auction']['status'] !== 'active')
				$data['riseStatus'] = 'Error';
			// Если пришла ставка меньше минимально возможной
			if($minRate + $minStep > $rise = validator::validPositiveFloat($_POST['rise']))
				$data['riseStatus'] = 'Error';
			// Если пользователь является последним, кто делал ставку
			if($data['user'] == $data['auction']['lastMember'])
				$data['riseStatus'] = 'Error';
				
			// Если до этого были ошибки, то не выполнять, если выполнилось с ошибкой - сообщить
			if($data['riseStatus'] === 'Error' || !$model->addRise($id, $data['user'], $rise))
				$data['riseStatus'] = 'Error';
			else
				header("Location: $this->host/auction/id=$id");			
		}

		$this->view->generate('auction_view.php', 'template_view.php', $data);
	}
}