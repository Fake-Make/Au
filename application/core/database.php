<?php
// Класс для взаимодействия с БД
// Вынесен отдельно на случай смены БД
class dataBase {
	// Константы класса, использующиеся для подключения
	// Адрес сервера БД
	const DB_HOST = "localhost";
	// Учётная запись пользователя
	const DB_LOGIN = "learn";
	// Пароль пользователя
	const DB_PASSWORD = "qwe123qwe";
	// Имя базы данных
	const DB_NAME = "auction";
	
	// Указатель на активное соединение с БД
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
		// Валидация входных параметров
		$name = $this->validSQL($name);
		$login = $this->validSQL($login);
		$email = $this->validSQL($email);
		
		// Описание запроса
		$sqlReq = "INSERT INTO users (name, login, email, passHash)
			VALUES ('$name', '$login', '$email', '$passHash');";

		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_query($this->db, $sqlReq);
	}

	// Функция для добавления в БД таблицы активных аукционов пользователя
	function addUserTable($id) {
		// Валидация входных параметров
		$id = $this->validSQL($id);
		
		// Описание запроса
		$sqlReq = "CREATE TABLE IF NOT EXISTS user_$id (
			id INT NOT NULL AUTO_INCREMENT,
			auctionId INT NOT NULL,
			PRIMARY KEY (id),
			FOREIGN KEY (auctionId) REFERENCES auctions (id) ON DELETE CASCADE,
			UNIQUE KEY ix_auctionId (auctionId))";
		
		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_query($this->db, $sqlReq);
	}

	// Функция для добавления в БД записи о новом аукционе
	function addAuction($name, $description, $initRate, $timestamp, $userLogin, $photo) {
		// Валидация входных параметров
		$name = $this->validSQL($name);
		$description = $this->validSQL($description);
		$initRate = $this->validSQL($initRate);
		$timestamp = $this->validSQL(date('Y-m-d H:i:s', $timestamp));
		$userLogin = $this->validSQL($userLogin);
		$photo = $this->validSQL($photo);
		
		// Описание запроса
		$sqlReq = "INSERT INTO auctions (name, description, photo, date, initRate, ownerId)
			VALUES ('$name', '$description', '$photo', '$timestamp', '$initRate', 
				(SELECT id FROM users WHERE login = '$userLogin'));";

		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_query($this->db, $sqlReq);
	}

	// Функция для добавления в БД истории ставок, ставки и обновлении аукциона
	function addRise($auctionId, $userId, $rate) {
		// Валидация входных параметров
		$auctionId = $this->validSQL($auctionId);
		$userId = $this->validSQL($userId);
		$rate = $this->validSQL($rate);

		// Описание запроса
		// Если истории ставок нет, то создать такую
		$sqlReq = "CREATE TABLE IF NOT EXISTS auction_$auctionId (
			id				INT NOT NULL AUTO_INCREMENT,
			memberId	INT NOT NULL,
			rate			FLOAT NOT NULL,
			PRIMARY KEY (id),
			FOREIGN KEY (memberId) REFERENCES users (id) ON DELETE CASCADE)";
		// Выполнение запроса
		mysqli_query($this->db, $sqlReq);

		// Начало транзакции для атомарности выполнения группы запросов
		mysqli_query($this->db, "START TRANSACTION");
			// Добавление в историю ставок новой ставки
			$sqlReq = "INSERT INTO auction_$auctionId (memberId, rate)
			VALUES ('$userId', '$rate')";
			if(!mysqli_query($this->db, $sqlReq)) {
				// Откат транзакции при неуспешном выполнении
				mysqli_query($this->db, "ROLLBACK");
				return false;
			}

			// Обновить данные об аукционе
			$sqlReq = "UPDATE auctions SET
				curRate='$rate',
				lastMember='$userId'
			WHERE id='$auctionId'";
			if(!mysqli_query($this->db, $sqlReq)) {
				// Откат транзакции при неуспешном выполнении
				mysqli_query($this->db, "ROLLBACK");
				return false;
			}
		// Подтверждение транзакции при успешном завершении запросов
		return mysqli_query($this->db, "COMMIT");
	}

	// Функция для удаления существующего аукциона
	function deleteAuction($auctionId) {
		// Валидация входных параметров
		$auctionId = $this->validSQL($auctionId);

		// Удаление истории ставок
		$sqlReq = "DROP TABLE IF EXISTS auction_$auctionId";
		mysqli_query($this->db, $sqlReq);

		// Удаление записи из списка аукционов
		$sqlReq = "DELETE FROM auctions WHERE id='$auctionId'";
		return mysqli_query($this->db, $sqlReq);
	}

	// Функция для получения из БД записей записей об аукционах с учётом постраничной навигации
	function getAuctionsList($size, $page) {
		// Валидация входных параметров
		$size = $this->validSQL($size);
		$page = $this->validSQL($page);
		// Смещение в зависимости от текущей страницы
		$offset = ($page - 1) * $size;

		// Описание запроса
		$sqlReq = "SELECT id, name, initRate, curRate, date, photo FROM auctions
		WHERE status='active' ORDER BY date DESC " .
			"LIMIT " . ($offset ? "$offset, " : "") . $size;

		// Получение ответа от БД об успешности выполнения запроса
		$sqlRes = mysqli_query($this->db, $sqlReq);
		return mysqli_fetch_all($sqlRes, MYSQLI_ASSOC);
	}

	// Получения списка персональных аукционов (организатора или участника) с учётом постраничной навигации
	function getPersonalAuctions($size, $page, $user, $tab) {
		// Валидация входных параметров
		$size = $this->validSQL($size);
		$page = $this->validSQL($page);
		$user = $this->validSQL($user);
		// Смещение в зависимости от текущей страницы
		$offset = ($page - 1) * $size;

		// Для созданных аукционов запрашиваются те аукционы, где $user=ownerId
		if($tab === 'created')
			$sqlReq = "SELECT id, name, initRate, curRate, date, photo FROM auctions
				WHERE status='active' AND ownerId='$user' ORDER BY date DESC " .
				"LIMIT " . ($offset ? "$offset, " : "") . $size;
		// Для аукционов, где пользователь принимает участие, данные запрашиваются из соответствующего списка
		if($tab === 'active')
			$sqlReq = "SELECT a.id, a.name, a.initRate, a.curRate, a.date, a.photo FROM auctions AS a
				INNER JOIN user_$user AS u ON a.id = u.auctionId
				WHERE a.status='active' ORDER BY a.date DESC " .
				"LIMIT " . ($offset ? "$offset, " : "") . $size;

		// Выполнение запроса, если была выбрана одна из вкладок
		if(!$sqlReq)
			return false;
		$sqlRes = mysqli_query($this->db, $sqlReq);
		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_fetch_all($sqlRes, MYSQLI_ASSOC);
	}

	// Функция для занесения аукциона в список активных аукционов пользователя
	function addAuctionToUser($auction, $user) {
		// Валидация входных параметров
		$auction = $this->validSQL($auction);
		$user = $this->validSQL($user);
		
		// Описание запроса
		$sqlReq = "INSERT INTO user_$user (auctionId)
			VALUES ('$auction')";

		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_query($this->db, $sqlReq);
	}

	// Функция для получения ID диалога по его участникам
	function getDialogByMembers($person, $user) {
		// Валидация входных параметров
		$person = $this->validSQL($person);
		$user = $this->validSQL($user);

		// Описание запроса
		// Оба участника могут быть в разных ролях
		$sqlReq = 
			"SELECT id FROM dialogs
			WHERE (initiator='$person' AND recipient='$user')
			OR (initiator='$user' AND recipient='$person') LIMIT 1";

		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
	}

	// Создание нового диалога
	function createDialog($from, $to) {
		// Валидация входных параметров
		$from = $this->validSQL($from);
		$to = $this->validSQL($to);
		$time = $this->validSQL(date('Y-m-d H:i:s', time()));

		// 1. Получаем слот для диалога
		$sqlReq = "SELECT max(id) FROM dialogs";
		$id = mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"] + 1;
		// 2. Добавление в список диалогов новой записи
		$sqlReq =
			"INSERT INTO dialogs (id, initiator, recipient, lastMessage, lastUpdate)
			VALUES ('$id', '$from', '$to', 'Empty', '$time')";
		// Если выполнение запроса было неуспешно, возвращаем false
		if(!mysqli_query($this->db, $sqlReq))
			return false;
		
		// Возвращаем id диалога
		return $id;
	}

	// Функция для получения списка сообщений в диалоге
	function getChatByDialogId($dialog) {
		// Валидация входных параметров
		$dialog = $this->validSQL($dialog);

		// Описание запроса
		$sqlReq = "SELECT text, reciever FROM dialog_$dialog";

		// Получение ответа от БД об успешности выполнения запроса
		$sqlRes = mysqli_query($this->db, $sqlReq);
		return mysqli_fetch_all($sqlRes, MYSQLI_ASSOC);
	}

	// Добавление нового сообщения
	function addMessage($dialog, $from, $to, $what) {
		// Валидация входных параметров
		$dialog = $this->validSQL($dialog);
		$from = $this->validSQL($from);
		$to = $this->validSQL($to);
		$what = $this->validSQL($what);
		$time = $this->validSQL(date('Y-m-d H:i:s', time()));

		// Если списка сообщений для этого диалога нет, то создать
		$sqlReq =
			"CREATE TABLE	IF NOT EXISTS dialog_$dialog (
				id				INT NOT NULL AUTO_INCREMENT,
				text			TEXT NOT NULL,
				reciever	INT NOT NULL,
				PRIMARY KEY (id),
				FOREIGN KEY (reciever) REFERENCES users (id) ON DELETE CASCADE)";
		// Если выполнение запроса было неуспешно, возвращаем false
		if(!mysqli_query($this->db, $sqlReq))
			return false;
		

		// Непосредственное добавление сообщения
		$sqlReq =
			"INSERT INTO dialog_$dialog (text, reciever)
			VALUES ('$what', '$to')";
		// Если выполнение запроса было неуспешно, возвращаем false
		if(!mysqli_query($this->db, $sqlReq))
			return false;

		// Обновление в списке диалогов
		$sqlReq =
			"UPDATE dialogs SET
			lastMessage='$what',
			lastUpdate='$time'
			WHERE id='$dialog'";
		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_query($this->db, $sqlReq);
	}

	// Функция для получения списка диалогов пользователя
	function getDialogsById($user) {
		// Валидация входных параметров
		$user = $this->validSQL($user);

		// Нужно получить диалоги, где пользователь участвует 
		// как в роли инициатора, так и в роли получателя
		// К каждому такому диалогу нужно ещё фото и имя собеседника
		$sqlReq = 
			"SELECT d.id, d.member, d.lastMessage, d.lastUpdate, u.photo, u.name
			FROM users AS u INNER JOIN
				(SELECT id, recipient member, lastMessage, lastUpdate
				FROM dialogs
				WHERE initiator='$user'
					UNION
				SELECT id, initiator member, lastMessage, lastUpdate
				FROM dialogs
				WHERE recipient='$user') AS d
			ON u.id=d.member
			ORDER BY lastUpdate";

		// Получение ответа от БД об успешности выполнения запроса
		$sqlRes = mysqli_query($this->db, $sqlReq);
		return mysqli_fetch_all($sqlRes, MYSQLI_ASSOC);
	}

	// Получение второго пользователя диалога
	function getSecondMemberByDialog($dialog) {
		// Валидация входных параметров
		$dialog = $this->validSQL($dialog);

		// Описание запроса
		$sqlReq = "SELECT recipient, initiator FROM dialogs WHERE id='$dialog'";
		
		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_fetch_assoc(mysqli_query($this->db, $sqlReq));
	}

	// Функция для получения максимального количества страниц
	function getMaxPages($size) {
		// Валидация входных параметров
		$size = $this->validSQL($size);

		// Описание запроса
		$sqlReq = "SELECT count(*) FROM auctions";

		// Получение ответа от БД об успешности выполнения запроса
		$rawNumber = mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
		// Подсчёт максимального числа страниц в зависимости от
		// числа результатов и количества элементов на одной странице
		return ceil($rawNumber / $size);
	}

	// Функция для получения максимального количества страниц
	function getMaxPagesForPersonal($size, $user, $tab) {
		// Валидация входных параметров
		$user = $this->validSQL($user);

		// Получение числа аукционов, в зависимости от выбранной вкладки
		if($tab === 'created')
			$sqlReq = "SELECT count(*) FROM auctions WHERE ownerId='$user'";
		if($tab === 'active')
			$sqlReq = "SELECT count(*) FROM user_$user";
		// Получение ответа от БД об успешности выполнения запроса
		$rawNumber = mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
		// Подсчёт максимального числа страниц в зависимости от
		// числа результатов и количества элементов на одной странице
		return ceil($rawNumber / $size);
	}

	// Функция для получения из БД данных об аукционе по его id
	function getAuctionById($id) {
		// Валидация входных параметров
		$id = $this->validSQL($id);

		// Получение данных об аукционе и его организаторе
		$sqlReq = "SELECT a.name, a.description, a.photo, a.date, a.initRate, a.curRate, a.lastMember, a.status, u.name ownerName, a.ownerId
			FROM auctions AS a JOIN users AS u ON a.ownerId = u.id
			WHERE a.id = '$id';";
		
		// Получение ответа от БД об успешности выполнения запроса
		$sqlRes = mysqli_query($this->db, $sqlReq);
		return mysqli_fetch_assoc($sqlRes);
	}

	// Функция для получения из БД пользовательского хэша пароля по его логину
	function getUserHash($login) {
		// Валидация входных параметров
		$login = $this->validSQL($login);
		
		// Описание запроса
		$sqlReq = "SELECT passHash from users WHERE login = '$login';";
		
		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
	}

	// Функция для получения из БД пользовательского id по его логину
	function getUserIdByLogin($login) {
		// Валидация входных параметров
		$login = $this->validSQL($login);
		
		// Описание запроса
		$sqlReq = "SELECT id from users WHERE login = '$login';";
		
		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
	}

	// Функция для получения из БД имени пользователя по его id
	function getUserNameById($user) {
		// Валидация входных параметров
		$user = $this->validSQL($user);
		
		// Описание запроса
		$sqlReq = "SELECT name from users WHERE id = '$user';";
		
		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
	}

	// Функция для получения из БД организатора аукциона по id аукциона
	function getOwnerByAuction($auctionId) {
		// Валидация входных параметров
		$auctionId = $this->validSQL($auctionId);
		
		// Описание запроса
		$sqlReq = "SELECT ownerId from auctions WHERE id = '$auctionId';";
		
		// Получение ответа от БД об успешности выполнения запроса
		return mysqli_fetch_row(mysqli_query($this->db, $sqlReq))["0"];
	}

	// Деструктор класса, разраывающий соединение с БД
	function __destruct() {
		mysqli_close($this->db);
	}
}
