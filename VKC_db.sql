CREATE TABLE users(
	user_id INT PRIMARY KEY AUTO_INCREMENT,
	user_role ENUM('employee', 'admin') DEFAULT 'employee',
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	email VARCHAR(50) NOT NULL,
	phone INT(10) NOT NULL,
	password VARCHAR(50) NOT NULL,
	user_dc DATE NOT NULL,
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
    station_description VARCHAR(100)
);

CREATE TABLE team(
    team_id INT PRIMARY KEY AUTO_INCREMENT,
    station_id INT NOT NULL,
    team_creation_date DATE NOT NULL,
    FOREIGN KEY (station_id) REFERENCES station(station_id)
);

CREATE TABLE team_members(
    team_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (team_id) REFERENCES team(team_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE product(
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_category ENUM('SCI', 'U-BASE', '100-BASE'),
    product_code VARCHAR(50) NOT NULL,
    product_name VARCHAR(50) NOT NULL
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
    start_time DATE NOT NULL,
    end_time DATE NULL,
    units INT NULL,
    breaks BOOLEAN NULL,
    break_time INT NULL,
    mess BOOLEAN NULL,
    notes VARCHAR(100) NULL,
    FOREIGN KEY (pallet_id) REFERENCES pallet(pallet_id)
);
