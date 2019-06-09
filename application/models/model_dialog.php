<?php

class Model_Dialog extends Model {
	function getDialogByMembers($person, $user) {
		return $this->db->getDialogByMembers($person, $user);
	}

	function getUserNameById($person) {
		return $this->db->getUserNameById($person);
	}

	function getUserIdByLogin($login) {
		return $this->db->getUserIdByLogin($login);
	}

	function sendMessage($from, $to, $what) {
		$dialog = $this->db->getDialogByMembers($from, $to);
		if(!$dialog)
			$dialog = $this->db->createDialog($from, $to);
		echo "Dialog: $dialog";
		if(false === $dialog)
			return false;
		return $this->db->addMessage($dialog, $from, $to, $what);
	}
}