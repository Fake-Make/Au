<?php

class Model_Personal extends Model {
	function getMaxPagesForPersonal($size, $user, $tab) {
		return $this->db->getMaxPagesForPersonal($size, $user, $tab);;
	}

	function getPersonalAuctions($size, $page, $user, $tab) {
		return $this->db->getPersonalAuctions($size, $page, $user, $tab);;
	}

	function getUserIdByLogin($login) {
		return $this->db->getUserIdByLogin($login);
	}
}