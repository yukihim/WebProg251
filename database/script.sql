-- DATABASE: The Executive Garage


CREATE DATABASE IF NOT EXISTS the_executive_garage;
USE the_executive_garage;


DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Brand;
DROP TABLE IF EXISTS BodyStyle;
DROP TABLE IF EXISTS Location;
DROP TABLE IF EXISTS Car;


CREATE TABLE User (
  uid INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Brand (
  bid INT AUTO_INCREMENT PRIMARY KEY,
  brand_name VARCHAR(50) NOT NULL UNIQUE
);


CREATE TABLE BodyStyle (
  bsid INT AUTO_INCREMENT PRIMARY KEY,
  style_name VARCHAR(50) NOT NULL UNIQUE
);


CREATE TABLE Location (
  lid INT AUTO_INCREMENT PRIMARY KEY,
  location_name VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  Maps_url TEXT NULL
);


CREATE TABLE Car (
  cid INT AUTO_INCREMENT PRIMARY KEY,
  model_name VARCHAR(100) NOT NULL,
  description TEXT NULL,
  price DECIMAL(10, 0) NOT NULL,
  year INT NOT NULL,
  image_url VARCHAR(50) NOT NULL,
  
  -- Foreign Keys
  brand_id INT NULL,
  style_id INT NULL,
  
  -- Constraints
  CONSTRAINT fk_car_brand
    FOREIGN KEY (brand_id) 
    REFERENCES Brand (bid)
    ON DELETE SET NULL, -- If a brand is deleted, set this car's brand to NULL
    
  CONSTRAINT fk_car_style
    FOREIGN KEY (style_id) 
    REFERENCES BodyStyle (bsid)
    ON DELETE SET NULL -- If a body style is deleted, set this car's style to NULL
);

-- For the relation between Car and Location
CREATE TABLE Inventory (
  inventory_id INT AUTO_INCREMENT PRIMARY KEY,
  
  -- The Link
  car_id INT NOT NULL,
  location_id INT NOT NULL,
  
  -- The Attribute
  amount INT NOT NULL DEFAULT 0,

  UNIQUE(car_id, location_id),

  CONSTRAINT fk_inv_car FOREIGN KEY (car_id) REFERENCES Car (cid) ON DELETE CASCADE,
  CONSTRAINT fk_inv_loc FOREIGN KEY (location_id) REFERENCES Location (lid) ON DELETE CASCADE
);




-- Sample Data
INSERT INTO User (email, password, first_name, last_name) VALUES
('john.doe@example.com', '$2y$10$SfxV40WFeApPYaefRVyXVuIdXAZ41JtV10uCCGMoKzEVHxR4941KG', 'John', 'Doe'),
('jane.smith@example.com', '$2y$10$KPoCZqLwVD4Jpt.5SDswruJV.TUxmgg5.j5dIFV1bD5ZeHVFjyTVm', 'Jane', 'Smith');

-- --------------------------------------------------------

INSERT INTO Brand (brand_name) VALUES
('Porsche'),
('Mercedes-Benz'),
('BMW'),
('Audi'),
('Lexus'),
('Maserati');

-- --------------------------------------------------------

INSERT INTO BodyStyle (style_name) VALUES
('Coupe'),
('SUV'),
('Sedan'),
('Convertible'),
('Sportback'),
('Gran Coupe');

-- --------------------------------------------------------

INSERT INTO Location (location_name, address, Maps_url) VALUES
('The Executive Garage - Germany', 'Haußmannstraße 229, 70188 Stuttgart, Germany', 'https://maps.app.goo.gl/7EHad9SYWVoLEYKi6'),
('The Executive Garage - United States', '340 10th St, San Francisco, CA 94103, United States', 'https://maps.app.goo.gl/C1xMsXo15WB6g8w16'),
('The Executive Garage - United Kingdom', '12A Mornington Cres, London NW1 7RH, United Kingdom', 'https://maps.app.goo.gl/yjkbjt9SNyeR7gV56');

-- --------------------------------------------------------

INSERT INTO Car (model_name, description, price, year, image_url, brand_id, style_id) VALUES
(
  'Porsche 911 GT3 RS',
  'A track-focused masterpiece. Finished in stunning Shark Blue, this 911 GT3 is the pinnacle of performance and precision engineering. Low mileage and in pristine condition.',
  171150,
  2023,
  'porsche/porsche_911_gt3_rs.jpg',
  (SELECT bid FROM Brand WHERE brand_name = 'Porsche'),
  (SELECT bsid FROM BodyStyle WHERE style_name = 'Coupe')
),
(
  'Porsche Panamera 4',
  'Luxury sedan performance with unmistakable Porsche DNA. This Panamera 4 offers all-wheel drive and a spacious, tech-forward interior.',
  105000,
  2025,
  'porsche/porsche_panamera_4.jpg',
  (SELECT bid FROM Brand WHERE brand_name = 'Porsche'),
  (SELECT bsid FROM BodyStyle WHERE style_name = 'Sedan')
),
(
  'Porsche 718 Cayman S',
  'The quintessential mid-engine sports car. Perfectly balanced, agile, and an absolute joy to drive. This S model provides exhilarating turbocharged power.',
  88000,
  2022,
  'porsche/porsche_718_cayman_s.jpg',
  (SELECT bid FROM Brand WHERE brand_name = 'Porsche'),
  (SELECT bsid FROM BodyStyle WHERE style_name = 'Coupe')
),
(
  'BMW M5 Competition',
  'The ultimate executive super-sedan. Combines breathtaking V8 power with everyday usability and luxury. Features the Executive Package and M Drivers Package.', 
  112000,
  2022,
  'bmw/bmw_m5_comp.jpg',
  (SELECT bid FROM Brand WHERE brand_name = 'BMW'),
  (SELECT bsid FROM BodyStyle WHERE style_name = 'Sedan')
),
(
  'Mercedes-AMG G 63',
  'Iconic design meets unparalleled performance. This G 63 in Obsidian Black is the definition of luxury off-roading, with a handcrafted biturbo V8 and an opulent interior.', 
  175000,
  2023,
  'mercedes/mercedes_g63.jpg',
  (SELECT bid FROM Brand WHERE brand_name = 'Mercedes-Benz'),
  (SELECT bsid FROM BodyStyle WHERE style_name = 'SUV')
),
(
  'Audi RS 7 Sportback',
  'A stunning blend of four-door practicality and supercar performance. The RS 7 Sportback offers a potent twin-turbo V8 and a sleek, fastback design.', 
  128000,
  2023,
  'audi/audi_rs7.jpg',
  (SELECT bid FROM Brand WHERE brand_name = 'Audi'),
  (SELECT bsid FROM BodyStyle WHERE style_name = 'Sportback')
),
(
  'Lexus LC 500 Convertible',
  'A breathtaking expression of design and craftsmanship. This convertible features a naturally aspirated V8 with an incredible soundtrack and a meticulously crafted interior.', 
  105000,
  2022,
  'lexus/lexus_lc500.jpg',
  (SELECT bid FROM Brand WHERE brand_name = 'Lexus'),
  (SELECT bsid FROM BodyStyle WHERE style_name = 'Convertible')
),
(
  'Maserati Granturismo',
  'An Italian masterpiece that combines elegance and performance. The Granturismo offers a thrilling V8 engine and a luxurious interior, perfect for grand touring.',
  159495,
  2025,
  'maserati/maserati_granturismo.jpg',
  (SELECT bid FROM Brand WHERE brand_name = 'Maserati'),
  (SELECT bsid FROM BodyStyle WHERE style_name = 'Coupe')
);


INSERT INTO Inventory (car_id, location_id, amount) VALUES 
(
  (SELECT cid FROM Car WHERE model_name = 'Porsche 911 GT3 RS'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - Germany'),
  5
),
(
  (SELECT cid FROM Car WHERE model_name = 'Porsche 911 GT3 RS'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - United States'),
  2
),
(
  (SELECT cid FROM Car WHERE model_name = 'Porsche Panamera 4'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - Germany'),
  1
),
(
  (SELECT cid FROM Car WHERE model_name = 'Porsche Panamera 4'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - United States'),
  3
),
(
  (SELECT cid FROM Car WHERE model_name = 'Porsche 718 Cayman S'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - Germany'),
  2
),
(
  (SELECT cid FROM Car WHERE model_name = 'BMW M5 Competition'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - United Kingdom'),
  3
),
(
  (SELECT cid FROM Car WHERE model_name = 'BMW M5 Competition'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - United States'),
  2
),
(
  (SELECT cid FROM Car WHERE model_name = 'Mercedes-AMG G 63'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - Germany'),
  2
),
(
  (SELECT cid FROM Car WHERE model_name = 'Audi RS 7 Sportback'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - United Kingdom'),
  2
),
(
  (SELECT cid FROM Car WHERE model_name = 'Lexus LC 500 Convertible'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - United States'),
  1
),
(
  (SELECT cid FROM Car WHERE model_name = 'Lexus LC 500 Convertible'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - United Kingdom'),
  1
),
(
  (SELECT cid FROM Car WHERE model_name = 'Maserati Granturismo'),
  (SELECT lid FROM Location WHERE location_name = 'The Executive Garage - Germany'),
  2
);