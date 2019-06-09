<?php

class Model_Dialog extends Model {
	function getDialogByMembers($person, $user) {
		return $this->db->getDialogByMembers($person, $user);
	}

	function getUserNameById($person) {
		return $this->db->getUserNameById($person);
	}
}