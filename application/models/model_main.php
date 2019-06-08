<?php

class Model_Main extends Model {
	
	public function getAuctions($size, $page) {
		return $this->db->getAuctionsList($size, $page);
	}

}