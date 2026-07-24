CREATE DATABASE IF NOT EXISTS attendance_system;
USE attendance_system;

CREATE TABLE IF NOT EXISTS teachers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  roll_no VARCHAR(50) NOT NULL UNIQUE,
  name VARCHAR(200) NOT NULL,
  branch VARCHAR(100),
  year VARCHAR(10),
  section VARCHAR(5)
);

CREATE TABLE IF NOT EXISTS attendance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  date DATE NOT NULL,
  time TIME NOT NULL,
  status ENUM('Present','Absent') DEFAULT 'Present',
  FOREIGN KEY (student_id) REFERENCES students(id)
);

INSERT INTO teachers (username, password) VALUES ('admin','admin123')
ON DUPLICATE KEY UPDATE username=username;

INSERT INTO students (roll_no, name, branch, year, section) VALUES
('101','John Paul','CSE','III','A'),
('102','Don Smith','CSE','III','A'),
('103','Meena Kumari','CSE','III','A');