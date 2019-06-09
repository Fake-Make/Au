DROP DATABASE IF EXISTS auction;
CREATE DATABASE IF NOT EXISTS auction;
USE auction;

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

#INSERT INTO users (name, surname,	login, email,	passwordHash) VALUES
#('', '', '', '', '');

CREATE TABLE auctions (
	id					INT NOT NULL AUTO_INCREMENT,
	name				VARCHAR(255) NOT NULL,
	description	TEXT,
	photo				VARCHAR(255),
	date				TIMESTAMP,
	initRate		FLOAT NOT NULL,
	curRate			FLOAT,
	lastMember	INT NOT NULL,
	ownerId			INT NOT NULL,	
	status			ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
	PRIMARY KEY (id),
	FOREIGN KEY (ownerId) REFERENCES users (id) ON DELETE CASCADE,
	FOREIGN KEY (lastMember) REFERENCES users (id)
);

CREATE TABLE dialogs (
	id					INT NOT NULL AUTO_INCREMENT,
	initiator		INT,
	recipient		INT NOT NULL,
	lastMessage	TEXT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (initiator) REFERENCES users (id) ON DELETE CASCADE,
	FOREIGN KEY (recipient) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE user_1 (
	id INT NOT NULL AUTO_INCREMENT,
	auctionId INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (auctionId) REFERENCES auctions (id) ON DELETE CASCADE,
	UNIQUE KEY ix_auctionId (auctionId)
)