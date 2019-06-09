<?php

class Model_Delete extends Model {
	function getUserIdByLogin($login)	{
		return $this->db->getUserIdByLogin($login);
	}

	function getOwnerByAuction($auction)	{
		return $this->db->getOwnerByAuction($auction);
	}

	function deleteAuction($auction)	{
		return $this->db->deleteAuction($auction);
	}
}