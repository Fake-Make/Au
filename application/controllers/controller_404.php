<?php
// Класс контроллера для страницы ошибки с кодом 404
class Controller_404 extends Controller {
	// Метод для непосредственной генерации соотвествующей страницы
	function action_index() {
		$this->view->generate('404_view.php', 'template_view.php');
	}
}