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
		if(false === $dialog)
			return false;
		if(!$this->db->addMessage($dialog, $from, $to, $what))
			return false;
		return $dialog;
	}

	function getSecondMemberByDialog($dialog, $user) {
		$chat = $this->db->getSecondMemberByDialog($dialog);
		if(!$chat || !is_array($chat))
			return false;
		if($chat['initiator'] === $user)
			return $chat['recipient'];
		if($chat['recipient'] === $user)
			return $chat['initiator'];
		return false;
	}

	
	function getChatByDialogId($dialog) {
		return $this->db->getChatByDialogId($dialog);
	}
}