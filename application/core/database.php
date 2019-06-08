<?php
// Класс для взаимодействия с БД
// Вынесен отдельно на случай смены БД
class dataBase {
	// Константы класса, использующиеся для подключения
	const DB_HOST = "localhost";
	const DB_LOGIN = "learn";
	const DB_PASSWORD = "qwe123qwe";
	const DB_NAME = "auction";
	
	// Переменная класса, отвечающая за активное соединение с БД
	private $db;

	// Конструктор класса, инициализирующий подключение к БД
	function __construct() {
		$this->db = mysqli_connect(self::DB_HOST, self::DB_LOGIN, self::DB_PASSWORD, self::DB_NAME) or die ('Not connected: ' . mysqli_error($this->db));
	}

	// Универсальная функция для валидации данных от SQL-инъекций
	function validSQL($str) {
		return mysqli_real_escape_string($this->db, $str);
	}

	// Функция для добавления в БД записи о новом пользователе
	function addUser($name, $login, $email, $passHash) {
		$name = $this->validSQL($name);
		$login = $this->validSQL($login);
		$email = $this->validSQL($email);
		
		$sqlReq = "INSERT INTO users (name, login, email, passHash)
			VALUES ('$name', '$login', '$email', '$passHash');";

		return mysqli_query($this->db, $sqlReq);
	}
	
	// Функция для добавления в БД записи о новом аукционе
	function addAuction($name, $description, $initRate, $timestamp, $user, $photo) {
		$name = $this->validSQL($name);
		$description = $this->validSQL($description);
		$initRate = $this->validSQL($initRate);
		$timestamp = $this->validSQL(date('Y-m-d H:i:s', $timestamp));
		$user = $this->validSQL($user);
		$photo = $this->validSQL($photo);
		
		$sqlReq = "INSERT INTO auctions (name, description, photo, date, initRate, ownerId)
			VALUES ('$name', '$description', '$photo', '$timestamp', '$initRate', 
				(SELECT id FROM users WHERE login = '$user'));";

		return mysqli_query($this->db, $sqlReq);
	}

	// Функция для получения из БД записей S последних записей об аукционах со смещением P
	function getAuctionsList($size, $page) {
		$size = $this->validSQL($size);
		$page = $this->validSQL($page);
		$offset = ($page - 1) * $size;

		$sqlReq = "SELECT id, name, initRate, curRate, date, photo FROM auctions ORDER BY date " .
			"LIMIT " . ($offset ? "$offset, " : "") . $size;

		return mysqli_fetch_all(mysqli_query($this->db, $sqlReq), MYSQLI_ASSOC);
	}

	// Функция для получения из БД пользовательского хэша пароля по его логину
	function getUserHash($login) {
		$login = $this->validSQL($login);
		$sqlReq = "SELECT passHash from users WHERE login = '$login';";
		return mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
	}

	// Деструктор класса, разраывающий соединение с БД
	function __destruct() {
		mysqli_close($this->db);
	}
}
// Для тестирования запросов прямо в файле класса
//$a = new dataBase;
//print_r($a->getAuctionsList(18, 1));// ? 1 : 0;