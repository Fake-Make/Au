<?php

class Controller_personal extends Controller {
	function action_index()	{
		$this->view->generate('personal_view.php', 'template_view.php');
	}
}