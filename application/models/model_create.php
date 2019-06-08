<?php

class Model_CreateAuction extends Model {
	
	public function addAuction($name, $description, $initRate, $date, $user, $photo = "NULL")	{
		$dt = time() + $date * 60 * 60;
		return $this->db->addAuction($name, $description, $initRate, $dt, $user, $photo);
	}
}