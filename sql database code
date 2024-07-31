-- Drop existing tables if they exist
DROP TABLE IF EXISTS user_presentations;
DROP TABLE IF EXISTS user_images;
DROP TABLE IF EXISTS users;

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    current_login BOOLEAN DEFAULT FALSE
);


-- Create user_images table
CREATE TABLE user_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    image_path VARCHAR(255),
    image_type VARCHAR(50),  -- e.g., 'MRR by BU', 'Revenue by Product'
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


-- Create user_presentations table
CREATE TABLE user_presentations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    presentation_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


