<?php

class Controller_Logout extends Controller {
	function action_index() {
		$_SESSION['user'] = NULL;
		header("Location: $this->host/login");
	}
}