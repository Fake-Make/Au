<?php

class Model_Auction extends Model {
	function getAuctionById($id, $login = NULL) {
		$arr = $this->db->getAuctionById($id);
		if(!is_array($arr))
			return false;
		$arr['id'] = $id;
		$user = $login ? $this->db->getUserIdByLogin($login) : NULL;
		return [$arr, $user];
	}
}