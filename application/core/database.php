<?php

class dataBase {
	const DB_HOST = "localhost";
	const DB_LOGIN = "learn";
	const DB_PASSWORD = "qwe123qwe";
	const DB_NAME = "auction";
	
	private $db;

	function __construct() {
		$this->$db = mysqli_connect(self::DB_HOST, self::DB_LOGIN, self::DB_PASSWORD, self::DB_NAME) or die ('Not connected: ' . mysqli_error($this->$db));
	}

	function validSQL($str) {
		return mysqli_real_escape_string($this->$db, $str);
	}

	function addUser($name, $login, $email, $passHash) {
		$name = $this->validSQL($name);
		$login = $this->validSQL($login);
		$email = $this->validSQL($email);
		
		$sqlReq = "INSERT INTO users (name, login, email, passHash)
			VALUES ('$name', '$login', '$email', '$passHash');";

		return mysqli_query($this->$db, $sqlReq);
	}
	
	function addAuction($name, $description, $initRate, $date, $user, $photo) {
		$name = $this->validSQL($name);
		$description = $this->validSQL($login);
		
		$sqlReq = "INSERT INTO auctions (name, description, photo, date, initRate, ownerId)
			VALUES ('$name', '$description', '$photo', '$date', '$initRate', '$initRate', '$user');";

		return mysqli_query($this->$db, $sqlReq);
	}

	function getUserHash($login) {
		$login = $this->validSQL($login);
		$sqlReq = "SELECT passHash from users WHERE login = '$login';";
		return mysqli_fetch_row(mysqli_query($this->$db, $sqlReq))["0"];
	}

	function __destruct() {
		mysqli_close($this->$db);
	}
}

/*
$db = mysqli_connect("localhost", "learn", "qwe123qwe", "auction");
$sqlReq = "SELECT passwordHash from users WHERE login = 'Nevada17';";
$sqlRes = mysqli_query($db, $sqlReq);
echo mysqli_fetch_row($sqlRes)["0"];*/