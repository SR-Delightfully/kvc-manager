

CREATE TABLE users(
	user_id INT PRIMARY KEY AUTO_INCREMENT,
	user_role ENUM('employee', 'admin') DEFAULT 'employee',
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	email VARCHAR(50) NOT NULL UNIQUE,
	phone CHAR(10) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	user_dc DATETIME DEFAULT CURRENT_TIMESTAMP,
	user_status ENUM('active', 'leave', 'terminated') DEFAULT 'active'
);

CREATE TABLE schedule(
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    schedule_status ENUM('pending','confirmed','rejected') NOT NULL DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE shift(
    shift_id INT PRIMARY KEY AUTO_INCREMENT,
    schedule_id INT NOT NULL,
    shift_start DATETIME NOT NULL,
    shift_end DATETIME NULL,
    FOREIGN KEY (schedule_id) REFERENCES schedule(schedule_id)
);

CREATE TABLE station(
    station_id INT PRIMARY KEY AUTO_INCREMENT,
    station_name VARCHAR(100)
);

CREATE TABLE team(
    team_id INT PRIMARY KEY AUTO_INCREMENT,
    station_id INT NOT NULL,
    team_date DATE NOT NULL,
    FOREIGN KEY (station_id) REFERENCES station(station_id)
);

CREATE TABLE team_members(
    team_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (team_id) REFERENCES team(team_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE product_type(
    product_type_id INT PRIMARY KEY AUTO_INCREMENT,
    product_type_name VARCHAR(15)
);

CREATE TABLE product(
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_type_id INT NOT NULL,
    product_code VARCHAR(20) NULL,
    product_name VARCHAR(50) NOT NULL,
    FOREIGN KEY (product_type_id) REFERENCES product_type(product_type_id)
);

CREATE TABLE colour(
    colour_id INT PRIMARY KEY AUTO_INCREMENT,
    colour_code INT(3) UNIQUE,
    colour_name VARCHAR(20) NOT NULL
);

CREATE TABLE product_variant(
    variant_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    colour_id INT NULL,
    unit_size ENUM('0.5L', '1L', '2L', '4L', '8L'),
    variant_description VARCHAR(50) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(product_id),
    FOREIGN KEY (colour_id) REFERENCES colour(colour_id)
);

CREATE TABLE tote(
    tote_id INT PRIMARY KEY AUTO_INCREMENT,
    variant_id INT NOT NULL,
    batch_number INT UNIQUE,
    FOREIGN KEY (variant_id) REFERENCES product_variant(variant_id)
);

CREATE TABLE pallet(
    pallet_id INT PRIMARY KEY AUTO_INCREMENT,
    tote_id INT NOT NULL,
    station_id INT NOT NULL,
    FOREIGN KEY (tote_id) REFERENCES tote(tote_id),
    FOREIGN KEY (station_id) REFERENCES station(station_id)
);

CREATE TABLE palletize_session(
    session_id INT PRIMARY KEY AUTO_INCREMENT,
    pallet_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NULL,
    units INT NULL,
    break_start DATETIME NULL,
    break_time INT NULL,
    mess BOOLEAN NULL,
    notes VARCHAR(100) NULL,
    FOREIGN KEY (pallet_id) REFERENCES pallet(pallet_id)
);


INSERT INTO users (user_role, first_name, last_name, email, phone, password) VALUES
('admin','admin','admin','admin','1231231234','admin'),
('employee','employee1','emp','employee1@email.com','5145145142','password'),
('employee','employee2','emp','employee2@email.com','5141112222','password'),
('employee','employee3','emp','employee3@email.com','5142223333','password'),
('employee','employee4','emp','employee4@email.com','5143334444','password');

INSERT INTO station (station_name) VALUES
('station 1'),
('station 2'),
('station 3'),
('station 4'),
('station 5');

INSERT INTO team (station_id, team_date) VALUES
(1, '2025-11-03 09:53:00'),
(2, '2025-11-03 09:53:00'),
(3, '2025-11-03 09:53:00'),
(4, '2025-11-03 09:53:00'),
(5, '2025-11-03 09:53:00');

INSERT INTO team_members(team_id, user_id) VALUES
('1','2'),
('1','3'),
('2','4'),
('2','5');

INSERT INTO product_type(product_type_id, product_type_name) VALUES
('1','SCI'),
('2','U-BASE'),
('3','100-BASE');

INSERT INTO product(product_type_id, product_code, product_name) VALUES
('2','pods','pods'),
('3', 'pods', 'pods'),
('1', '4400R', 'Solution A'),
('1', '4405FCB', 'Solution B');

INSERT INTO colour(colour_code, colour_name) VALUES
('433', 'Super White'),
('885','Light Grey'),
('305','Grey'),
('470','Charcoal'),
('663','Medium Grey'),
('365','Steel Grey'),
('459','Black'),
('360','Medium Blue');

INSERT INTO product_variant(product_id, colour_id, unit_size, variant_description) VALUES
('1','1','1L','Super White pods 1L'),
('1','2','1L','Light Grey pods 1L'),
('1','2','0.5L','Light Grey pods 0.5L'),
('1','4','1L','Charcoal pods 1L'),
('1','5','0.5L','Medium Grey pods 0.5L'),
('1','5','1L','Medium Grey pods 1L'),
('1','8','1L','Medium Blue pods 1L');

INSERT INTO product_variant(product_id, unit_size, variant_description) VALUES
('3','8L', 'Solution A'),
('4','4L','Solution B');

INSERT INTO tote(variant_id, batch_number) VALUES
('1', '21026'),
('1', '20873'),
('4', '20189'),
('3', '21025'),
('8', '20975'),
('9', '20854');

INSERT INTO pallet(tote_id, station_id) VALUES
('1','1'),
('1','1'),
('2','1'),
('2','1'),
('3','1'),
('3','1'),
('4','1'),
('4','1'),
('5','2'),
('5','2'),
('6','3'),
('6','3'),
('6','3');

INSERT INTO palletize_session(pallet_id, start_time, end_time, units, break_start, break_time, mess, notes) VALUES
(1,'2025-11-06 09:04:00','2025-11-06 09:53:00',528,NULL,NULL,FALSE,NULL),
(2,'2025-11-06 09:55:00','2025-11-06 10:44:00',528,NULL, 4, TRUE,'double clicked'),
(3,'2025-11-06 10:46:00','2025-11-06 11:11:00',528,NULL,NULL,FALSE,NULL),
(4,'2025-11-06 11:20:00','2025-11-06 12:02:00',528,NULL, 5, FALSE,NULL),
(5,'2025-11-06 12:04:00','2025-11-06 12:54:00',528,NULL,NULL,FALSE,NULL),
(6,'2025-11-06 13:01:00','2025-11-06 13:42:00',528,NULL,NULL,FALSE,NULL),
(7,'2025-11-06 13:44:00','2025-11-06 14:15:00',528,NULL,NULL,FALSE,NULL),
(8,'2025-11-06 14:19:00','2025-11-06 14:58:00',528,NULL,NULL,FALSE,NULL),
(9,'2025-11-06 09:06:00','2025-11-06 09:50:00',32,NULL,NULL,FALSE,NULL),
(10,'2025-11-06 10:02:00','2025-11-06 10:43:00',32,NULL,NULL,FALSE,NULL),
(11,'2025-11-06 09:07:00','2025-11-06 09:57:00',108,NULL,NULL,FALSE,NULL),
(12,'2025-11-06 10:00:00','2025-11-06 10:45:00',108,NULL,NULL,FALSE,NULL),
(13,'2025-11-06 10:48:00','2025-11-06 11:33:00',108,NULL,NULL,FALSE,NULL);
