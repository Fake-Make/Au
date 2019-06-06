<?php

class Model_CreateAuction extends Model {
	
	public function addAuction($name, $description, $initRate, $date, $user, $photo = NULL)	{
		return $this->db->addAuction($name, $description, $initRate, $date, $user, $photo);
	}

}
