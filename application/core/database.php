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

	// Функция для добавления в БД таблицы активных аукционов пользователя
	function addUserTable($id) {
		$id = $this->validSQL($id);
		
		$sqlReq = "CREATE TABLE user_$id (
			id INT NOT NULL AUTO_INCREMENT,
			auctionId INT NOT NULL,
			PRIMARY KEY (id),
			FOREIGN KEY (auctionId) REFERENCES auctions (id) ON DELETE CASCADE,
			UNIQUE KEY ix_auctionId (auctionId))";

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

	// Функция для добавления в БД истории ставок, ставки и обновлении аукциона
	function addRise($auctionId, $userId, $rate) {
		$auctionId = $this->validSQL($auctionId);
		$userId = $this->validSQL($userId);
		$rate = $this->validSQL($rate);

		// Если истории ставок нет, то создать такую
		$sqlReq = "CREATE TABLE IF NOT EXISTS auction_$auctionId (
			id				INT NOT NULL AUTO_INCREMENT,
			memberId	INT NOT NULL,
			rate			FLOAT NOT NULL,
			PRIMARY KEY (id),
			FOREIGN KEY (memberId) REFERENCES users (id) ON DELETE CASCADE)";
		mysqli_query($this->db, $sqlReq);

		// Если что-то пойдёт не так, изменения не должны сохраниться
		mysqli_query($this->db, "START TRANSACTION");
			// Добавить в историю ставок новую ставку
			$sqlReq = "INSERT INTO auction_$auctionId (memberId, rate)
			VALUES ('$userId', '$rate')";
			if(!mysqli_query($this->db, $sqlReq)) {
				mysqli_query($this->db, "ROLLBACK");
				return false;
			}

			// Изменить текущую ставку для данного аукциона
			$sqlReq = "UPDATE auctions SET
				curRate='$rate',
				lastMember='$userId'
			WHERE id='$auctionId'";
			if(!mysqli_query($this->db, $sqlReq)) {
				mysqli_query($this->db, "ROLLBACK");
				return false;
			}
		// Если всё завершилось успешно, сохранить изменения
		return mysqli_query($this->db, "COMMIT");
	}

	// Функция для удаления существующего аукциона
	function deleteAuction($auctionId) {
		// По-хорошему, оба запроса необходимо выполнять атомарно
		$auctionId = $this->validSQL($auctionId);
		// Удаление истории ставок
		$sqlReq = "DROP TABLE IF EXISTS auction_$auctionId";
		mysqli_query($this->db, $sqlReq);

		// Удаление записи из списка аукционов
		$sqlReq = "DELETE FROM auctions WHERE id='$auctionId'";
		return mysqli_query($this->db, $sqlReq);
	}

	// Функция для получения из БД записей S последних записей об аукционах со смещением P
	function getAuctionsList($size, $page) {
		$size = $this->validSQL($size);
		$page = $this->validSQL($page);
		$offset = ($page - 1) * $size;

		$sqlReq = "SELECT id, name, initRate, curRate, date, photo FROM auctions
		WHERE status='active' ORDER BY date " .
			"LIMIT " . ($offset ? "$offset, " : "") . $size;

		$sqlRes = mysqli_query($this->db, $sqlReq);
		return mysqli_fetch_all($sqlRes, MYSQLI_ASSOC);
	}

	// Получения списка персональных аукционов: организатора или участника
	function getPersonalAuctions($size, $page, $user, $tab) {
		$size = $this->validSQL($size);
		$page = $this->validSQL($page);
		$user = $this->validSQL($user);
		$offset = ($page - 1) * $size;

		if($tab === 'created')
			$sqlReq = "SELECT id, name, initRate, curRate, date, photo FROM auctions
				WHERE status='active' AND ownerId='$user' ORDER BY date " .
				"LIMIT " . ($offset ? "$offset, " : "") . $size;
		if($tab === 'active')
			$sqlReq = "SELECT a.id, a.name, a.initRate, a.curRate, a.date, a.photo FROM auctions AS a
				INNER JOIN user_$user AS u ON a.id = u.auctionId
				WHERE a.status='active' ORDER BY a.date " .
				"LIMIT " . ($offset ? "$offset, " : "") . $size;

		$sqlRes = mysqli_query($this->db, $sqlReq);
		return mysqli_fetch_all($sqlRes, MYSQLI_ASSOC);
	}

	function addAuctionToUser($auction, $user) {
		$auction = $this->validSQL($auction);
		$user = $this->validSQL($user);
		
		$sqlReq = "INSERT INTO user_$user (auctionId)
			VALUES ('$auction')";

		return mysqli_query($this->db, $sqlReq);
	}

	// Функция для получения максимального количества страниц
	function getMaxPages($size) {
		$size = $this->validSQL($size);
		$sqlReq = "SELECT count(*) FROM auctions";
		$rawNumber = mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
		return ceil($rawNumber / $size);
	}

	// Функция для получения максимального количества страниц
	function getMaxPagesForPersonal($size, $user, $tab) {
		$user = $this->validSQL($user);
		if($tab === 'created')
			$sqlReq = "SELECT count(*) FROM auctions WHERE ownerId='$user'";
		if($tab === 'active')
			$sqlReq = "SELECT count(*) FROM user_$user";
		$rawNumber = mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
		return ceil($rawNumber / $size);
	}

	// Функция для получения из БД данных об аукционе по его id
	function getAuctionById($id) {
		$id = $this->validSQL($id);
		$sqlReq = "SELECT a.name, a.description, a.photo, a.date, a.initRate, a.curRate, a.lastMember, a.status, u.name ownerName, a.ownerId
			FROM auctions AS a JOIN users AS u ON a.ownerId = u.id
			WHERE a.id = '$id';";
		$sqlRes = mysqli_query($this->db, $sqlReq);
		return mysqli_fetch_assoc($sqlRes);
	}

	// Функция для получения из БД пользовательского хэша пароля по его логину
	function getUserHash($login) {
		$login = $this->validSQL($login);
		$sqlReq = "SELECT passHash from users WHERE login = '$login';";
		return mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
	}

	// Функция для получения из БД пользовательского id по его логину
	function getUserIdByLogin($login) {
		$login = $this->validSQL($login);
		$sqlReq = "SELECT id from users WHERE login = '$login';";
		return mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
	}

	// Функция для получения из БД организатора аукциона по id аукциона
	function getOwnerByAuction($auctionId) {
		$auctionId = $this->validSQL($auctionId);
		$sqlReq = "SELECT ownerId from auctions WHERE id = '$auctionId';";
		return mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
	}

	// Деструктор класса, разраывающий соединение с БД
	function __destruct() {
		mysqli_close($this->db);
	}
}

// Для тестирования запросов прямо в файле класса
//$a = new dataBase;
//print_r($a->getPersonalAuctions(3, 1, 1, 'created'));// ? 1 : 0;
//$a->getAuctionsList(13, 1);
//print_r($a->getAuctionsList(1,3));