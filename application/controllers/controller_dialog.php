<?php

class Controller_dialog extends Controller {
	function action_index()	{
		$this->view->generate('dialog_view.php', 'template_view.php');
	}
}