-- Перезапись существующей базы данных со всеми таблицами
DROP DATABASE IF EXISTS auction;
CREATE DATABASE IF NOT EXISTS auction;
USE auction;

-- Создание таблицы для списка пользователей
CREATE TABLE users (
	id				INT NOT NULL AUTO_INCREMENT,
	name			VARCHAR(255) NOT NULL,
	login			VARCHAR(255) NOT NULL,
	email			VARCHAR(255) NOT NULL,
	passHash	VARCHAR(255) NOT NULL,
	access		TINYINT(1) NOT NULL DEFAULT 0,
	blocked		TINYINT(1) NOT NULL DEFAULT 0,
	photo			VARCHAR(255),
	PRIMARY KEY (id)
);

-- Создание таблицы для списка аукционов
CREATE TABLE auctions (
	id					INT NOT NULL AUTO_INCREMENT,
	name				VARCHAR(255) NOT NULL,
	description	TEXT,
	photo				VARCHAR(255),
	date				DATETIME,
	initRate		FLOAT NOT NULL,
	curRate			FLOAT,
	lastMember	INT,
	ownerId			INT NOT NULL,	
	status			ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
	PRIMARY KEY (id),
	FOREIGN KEY (ownerId) REFERENCES users (id) ON DELETE CASCADE,
	FOREIGN KEY (lastMember) REFERENCES users (id)
);

-- Создание таблицы для списка диалогов
CREATE TABLE dialogs (
	id					INT NOT NULL AUTO_INCREMENT,
	initiator		INT,
	recipient		INT NOT NULL,
	lastMessage	TEXT NOT NULL,
	lastUpdate	TIMESTAMP NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (initiator) REFERENCES users (id) ON DELETE CASCADE,
	FOREIGN KEY (recipient) REFERENCES users (id) ON DELETE CASCADE
);