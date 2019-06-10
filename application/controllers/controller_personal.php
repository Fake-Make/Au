<?php
// Класс-контроллер для страницы личного кабинета
class Controller_personal extends Controller {
	// Метод по умолчанию для запроса к странице без параметров
	function action_index()	{
		// Если пользователь не авторизован, то переадресация на страницу авторизации
		if(!isset($_SESSION['user']))
			header("Location: $this->host/login");
		// Иначе - на первую страницу личного кабинета с вкладкой active
		else
			header("Location: $this->host/personal/active/page=1");
	}

	// Метод для запроса личного кабинета с вкладкой "участие в аукционах"
	function action_active()	{
		// Вызов метода для генерации списка аукционов в зависимости от вкладки
		$this->makeAuctionsList('active');
	}

	// Метод для запроса личного кабинета с вкладкой "организация аукционов"
	function action_created()	{
		// Вызов метода для генерации списка аукционов в зависимости от вкладки
		$this->makeAuctionsList('created');
	}

	// Метод для отображения списка аукционов в зависимости от вкладки
	function makeAuctionsList($tab) {
		$model = new Model_Personal();
		// 1. Если нет пользователя, то как мы тут оказались?
		if(!($user = $model->getUserIdByLogin(validator::validAnyString($_SESSION['user']))))
			Route::ErrorPage404();

		// 2. Нужно знать, сколько всего страниц: для пагинатора и валидации текущей
		$maxPages = $model->getMaxPagesForPersonal(MAX_GOODS_ON_PAGE, $user, $tab);

		// 3. Получаем номер текущей страницы и валидируем его
		preg_match("!page=(\d+)!", $_SERVER['REQUEST_URI'], $matches);
		$page = validator::validNaturalNumber($matches[1]);
		if($maxPages < $page)
			$page = validator::validNaturalNumber($maxPages);

		// 4. Запрашиваем данные для страницы
		$data['aucs'] = $model->getPersonalAuctions(MAX_GOODS_ON_PAGE, $page, $user, $tab);
		$data['tab'] = $tab;
		$data['page'] = $page;
		$data['maxPages'] = $maxPages;

		if(!is_array($data['aucs']) || empty($data['aucs']))
			$data["auctions_status"] = "empty";

		// 5. Отображение страницы
		$this->view->generate('personal_view.php', 'template_view.php', $data);
	}

	// Метод для запроса личного кабинета с вкладкой "диалоги"
	function action_dialogs()	{
		$model = new Model_Personal();
		$tab = "dialogs";

		// 1. Если нет пользователя, то как мы тут оказались?
		if(!($user = $model->getUserIdByLogin(validator::validAnyString($_SESSION['user']))))
			Route::ErrorPage404();

		// 2. Запрашиваем данные для страницы
		$data['dials'] = $model->getDialogsById($user);
		$data['tab'] = $tab;

		if(!is_array($data['dials']) || empty($data['dials']))
			$data["dialogs_status"] = "empty";

		// 3. Отображение данных
		$this->view->generate('personal_view.php', 'template_view.php', $data);
	}
}