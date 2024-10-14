-- Drop existing tables if they exist
DROP TABLE IF EXISTS user_reports;
DROP TABLE IF EXISTS user_presentations;
DROP TABLE IF EXISTS user_images;
DROP TABLE IF EXISTS users;

-- Create users table with reset_token and reset_token_expiry columns
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    current_login BOOLEAN DEFAULT FALSE,
    reset_token VARCHAR(255),  -- Column to store the reset token
    reset_token_expiry DATETIME  -- Column to store the token expiry time
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

-- Create user_reports table
CREATE TABLE user_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    report_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
