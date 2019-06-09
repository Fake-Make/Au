<?php
// Класс-контроллер для страницы аукциона
class Controller_delete extends Controller {
	// Нельзя запросить просто аукцион
	function action_index()	{
		Route::ErrorPage404();
	}
	
	// Получаем аукцион по его уникальному идентификатору
	function action_id() {
		$model = new Model_Delete();
		// 1. Если нет пользователя, то как мы тут оказались?
		if(!($user = $model->getUserIdByLogin(validator::validAnyString($_SESSION['user']))))
		Route::ErrorPage404();

		// 2. Если нет владельца, т.е. и аукциона, или если пользователь не владелец
		preg_match("!id=(\d+)!", $_SERVER['REQUEST_URI'], $matches);
		$id = validator::validNaturalNumber($matches[1]);
		$ownerId = $model->getOwnerByAuction($id);
		if(!$ownerId || $user !== $ownerId)
			Route::ErrorPage404();

		if(!$model->deleteAuction($id))
			Route::ErrorPage404();
		else
			header("Location: $this->host/personal/created/page=1");
	}
}