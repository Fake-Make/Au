<?php

class Controller_personal extends Controller {
	function action_index()	{
		$this->action_active();
	}

	function action_active()	{
		$data['tab'] = "active";
		$this->view->generate('personal_view.php', 'template_view.php', $data);
	}

	function action_created()	{
		$data['tab'] = "created";
		$this->view->generate('personal_view.php', 'template_view.php', $data);
	}

	function action_dialogs()	{
		$data['tab'] = "dialogs";
		$this->view->generate('personal_view.php', 'template_view.php', $data);
	}
}