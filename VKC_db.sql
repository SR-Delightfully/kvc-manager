CREATE TABLE users(
	user_id INT PRIMARY KEY AUTO_INCREMENT,
	user_role ENUM('employee', 'admin') DEFAULT 'employee',
	fist_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	email VARCHAR(50) NOT NULL,
	phone INT(10) NOT NULL,
	password VARCHAR(50) NOT NULL,
	user_dc DATE NOT NULL,
	user_status ENUM('active', 'leave' 'terminated') DEFAULT 'active',
);

CREATE TABLE shift(
    shift_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    shift_start DATE NOT NULL,
    shift_end DATE NOT NULL,
    break_minutes INT,
    shift_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE schedule(
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    week_start DATE NOT NULL,
    shift_id INT NOT NULL,
    
);

CREATE TABLE station(
    station_id INT PRIMARY KEY AUTO_INCREMENT,
    station_description VARCHAR(100),
);

CREATE TABLE team(
    team_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    station_id INT NOT NULL,
    team_creation_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (station_id) REFERENCES station(station_id) ON DELETE CASCADE,
);

CREATE TABLE product(
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    sku VARCHAR(40),
    product_name VARCHAR(50) NOT NULL,
    product_category ENUM('resin', 'adhesive', 'solvent', 'coating') DEFAULT 'resin'
);

CREATE TABLE colour(
    colour_id INT PRIMARY KEY AUTO_INCREMENT,
    colour_code INT(3) UNIQUE,
    colour_name VARCHAR(20) NOT NULL,
);

CREATE TABLE product_variant(
    variant_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    colour_id INT,
    variant_description VARCHAR(30) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(product_id),
    FOREIGN KEY (colour_id) REFERENCES colour(colour_id)
);

CREATE TABLE tote(
    tote_id INT PRIMARY KEY AUTO_INCREMENT,
    variant_id INT NOT NULL,
    batch_number INT UNIQUE,
    sci_product ENUM('SCI', 'U-BASE', '100-BASE'),
    FOREIGN KEY (variant_id) REFERENCES product_variant(variant_id)
);

CREATE TABLE pallet(
    pallet_id INT PRIMARY AUTO_INCREMENT,
    tote_id INT NOT NULL,
    station_id INT NOT NULL,
    unit_size ENUM('0.5L', '1L'),
    start_time DATE NOT NULL,
    end_time DATE NOT NULL,
    units INT NOT NULL,
    breaks BOOLEAN NOT NULL,
    break_time INT,
    mess BOOLEAN NOT NULL,
    notes VARCHAR(100),
    FOREIGN KEY (tote_id) REFERENCES tote(tote_id),
    FOREIGN KEY (station_id) REFERENCES station(station_id)
);
