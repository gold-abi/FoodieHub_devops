CREATE DATABASE food_order_db;
USE food_order_db;

-- Users Table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    phone VARCHAR(15),
    address TEXT
);

-- Hotels Table
CREATE TABLE hotels (
    hotel_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    location VARCHAR(100),
    offer VARCHAR(100),
    image VARCHAR(100)
);

-- Food Table
CREATE TABLE foods (
    food_id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT,
    name VARCHAR(100),
    price DECIMAL(10,2),
    image VARCHAR(100),
    FOREIGN KEY (hotel_id) REFERENCES hotels(hotel_id)
);

-- Orders Table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2),
    status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Cart Table
CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    food_id INT,
    quantity INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (food_id) REFERENCES foods(food_id)
);

INSERT INTO hotels (name, location, image, offer) VALUES
('Tasty Treats', 'Madurai', 'hotel1.jpg', '20% Off on First Order!'),
('Spice Garden', 'Chennai', 'hotel2.jpg', 'Free Delivery above ₹499'),
('Foodie’s Paradise', 'Coimbatore', 'hotel3.jpg', 'Buy 1 Get 1 on Burgers');

INSERT INTO foods (hotel_id, name, price, image) VALUES
(1, 'Paneer Butter Masala', 220, 'food1.jpg'),
(1, 'Veg Biryani', 180, 'food2.jpg'),
(2, 'Chicken 65', 250, 'food3.jpg'),
(3, 'Cheese Pizza', 300, 'food4.jpg');

ALTER TABLE foods ADD COLUMN category VARCHAR(100);
CREATE TABLE user_orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  food_id INT,
  order_date DATETIME DEFAULT CURRENT_TIMESTAMP
);
