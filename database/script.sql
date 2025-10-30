-- DATABASE: The Executive Garage


CREATE DATABASE IF NOT EXISTS the_executive_garage;
USE the_executive_garage;


DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Brands;
DROP TABLE IF EXISTS BodyStyles;
DROP TABLE IF EXISTS Locations;
DROP TABLE IF EXISTS Cars;


CREATE TABLE Users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Brands (
  brand_id INT AUTO_INCREMENT PRIMARY KEY,
  brand_name VARCHAR(50) NOT NULL UNIQUE
);


CREATE TABLE BodyStyles (
  style_id INT AUTO_INCREMENT PRIMARY KEY,
  style_name VARCHAR(50) NOT NULL UNIQUE
);


CREATE TABLE Locations (
  location_id INT AUTO_INCREMENT PRIMARY KEY,
  location_name VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  Maps_url TEXT NULL
);


CREATE TABLE Cars (
  car_id INT AUTO_INCREMENT PRIMARY KEY,
  model_name VARCHAR(100) NOT NULL,
  description TEXT NULL,
  price DECIMAL(10, 0) NOT NULL,
  year INT NOT NULL,
  image_url VARCHAR(50) NOT NULL,
  
  -- Foreign Keys
  brand_id INT NULL,
  style_id INT NULL,
  location_id INT NULL,
  
  -- Constraints
  CONSTRAINT fk_car_brand
    FOREIGN KEY (brand_id) 
    REFERENCES Brands (brand_id)
    ON DELETE SET NULL, -- If a brand is deleted, set this car's brand to NULL
    
  CONSTRAINT fk_car_style
    FOREIGN KEY (style_id) 
    REFERENCES BodyStyles (style_id)
    ON DELETE SET NULL, -- If a body style is deleted, set this car's style to NULL
    
  CONSTRAINT fk_car_location
    FOREIGN KEY (location_id) 
    REFERENCES Locations (location_id)
    ON DELETE SET NULL -- If a location is deleted, set this car's location to NULL
    
);




-- Sample Data
INSERT INTO Users (email, password, first_name, last_name) VALUES
('john.doe@example.com', 'hashed_password_1', 'John', 'Doe'),
('jane.smith@example.com', 'hashed_password_2', 'Jane', 'Smith');

-- --------------------------------------------------------

INSERT INTO Brands (brand_name) VALUES
('Porsche'),
('Mercedes-Benz'),
('BMW'),
('Audi'),
('Lexus'),
('Maserati');

-- --------------------------------------------------------

INSERT INTO BodyStyles (style_name) VALUES
('Coupe'),
('SUV'),
('Sedan'),
('Convertible'),
('Sportback'),
('Gran Coupe');

-- --------------------------------------------------------

INSERT INTO Locations (location_name, address, Maps_url) VALUES
('The Executive Garage - Downtown', '123 Luxury Ave, Premium City, PC 10001', 'https://goo.gl/maps/example1'),
('The Executive Garage - Northside', '456 Elite Rd, Uptown, PC 10002', 'https://goo.gl/maps/example2'),
('The Executive Garage - West End', '789 Prestige Blvd, West End, PC 10003', 'https://goo.gl/maps/example3');

-- --------------------------------------------------------

INSERT INTO Cars (model_name, description, price, year, image_url, brand_id, style_id, location_id) VALUES
(
  'Porsche 911 GT3 RS',
  'A track-focused masterpiece. Finished in stunning Shark Blue, this 911 GT3 is the pinnacle of performance and precision engineering. Low mileage and in pristine condition.',
  171150,
  2023,
  'porsche/porsche_911_gt3_rs.jpg',
  (SELECT brand_id FROM Brands WHERE brand_name = 'Porsche'),
  (SELECT style_id FROM BodyStyles WHERE style_name = 'Coupe'),
  (SELECT location_id FROM Locations WHERE location_name = 'The Executive Garage - Downtown')
),
(
  'Porsche Panamera 4',
  'Luxury sedan performance with unmistakable Porsche DNA. This Panamera 4 offers all-wheel drive and a spacious, tech-forward interior.',
  105000,
  2025,
  'porsche/porsche_panamera_4.jpg',
  (SELECT brand_id FROM Brands WHERE brand_name = 'Porsche'),
  (SELECT style_id FROM BodyStyles WHERE style_name = 'Sedan'),
  (SELECT location_id FROM Locations WHERE location_name = 'The Executive Garage - West End')
),
(
  'Porsche 718 Cayman S',
  'The quintessential mid-engine sports car. Perfectly balanced, agile, and an absolute joy to drive. This S model provides exhilarating turbocharged power.',
  88000,
  2022,
  'porsche/porsche_718_cayman_s.jpg',
  (SELECT brand_id FROM Brands WHERE brand_name = 'Porsche'),
  (SELECT style_id FROM BodyStyles WHERE style_name = 'Coupe'),
  (SELECT location_id FROM Locations WHERE location_name = 'The Executive Garage - Downtown')
),
(
  'BMW M5 Competition',
  'The ultimate executive super-sedan. Combines breathtaking V8 power with everyday usability and luxury. Features the Executive Package and M Drivers Package.', 
  112000,
  2022,
  'bmw/bmw_m5_comp.jpg',
  (SELECT brand_id FROM Brands WHERE brand_name = 'BMW'),
  (SELECT style_id FROM BodyStyles WHERE style_name = 'Sedan'),
  (SELECT location_id FROM Locations WHERE location_name = 'The Executive Garage - Northside')
),
(
  'Mercedes-AMG G 63',
  'Iconic design meets unparalleled performance. This G 63 in Obsidian Black is the definition of luxury off-roading, with a handcrafted biturbo V8 and an opulent interior.', 
  175000,
  2023,
  'mercedes/mercedes_g63.jpg',
  (SELECT brand_id FROM Brands WHERE brand_name = 'Mercedes-Benz'),
  (SELECT style_id FROM BodyStyles WHERE style_name = 'SUV'),
  (SELECT location_id FROM Locations WHERE location_name = 'The Executive Garage - Downtown')
),
(
  'Audi RS 7 Sportback',
  'A stunning blend of four-door practicality and supercar performance. The RS 7 Sportback offers a potent twin-turbo V8 and a sleek, fastback design.', 
  128000,
  2023,
  'audi/audi_rs7.jpg',
  (SELECT brand_id FROM Brands WHERE brand_name = 'Audi'),
  (SELECT style_id FROM BodyStyles WHERE style_name = 'Sportback'),
  (SELECT location_id FROM Locations WHERE location_name = 'The Executive Garage - West End')
),
(
  'Lexus LC 500 Convertible',
  'A breathtaking expression of design and craftsmanship. This convertible features a naturally aspirated V8 with an incredible soundtrack and a meticulously crafted interior.', 
  105000,
  2022,
  'lexus/lexus_lc500.jpg',
  (SELECT brand_id FROM Brands WHERE brand_name = 'Lexus'),
  (SELECT style_id FROM BodyStyles WHERE style_name = 'Convertible'),
  (SELECT location_id FROM Locations WHERE location_name = 'The Executive Garage - Northside')
);