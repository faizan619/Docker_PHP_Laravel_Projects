-- Create a database (if it doesn't already exist)
CREATE DATABASE IF NOT EXISTS practise;
	
-- Use the database
USE practise;

-- Create a table 'users'
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task TEXT NOT NULL,
    done tinyint DEFAULT 0, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some sample data
-- INSERT INTO users (username, email) VALUES ('john_doe', 'john@example.com');