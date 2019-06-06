<?php

class Controller_auction extends Controller {
	function action_index()	{
		$this->view->generate('auction_view.php', 'template_view.php');
	}
}