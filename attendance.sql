CREATE DATABASE IF NOT EXISTS attendance;
USE attendance;

CREATE TABLE IF NOT EXISTS teachers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(255) NOT NULL,
    teacher_id INT,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id)
);

CREATE TABLE IF NOT EXISTS attendance (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    student_id INT,
    status ENUM('Present', 'Absent', 'Late'),
    date DATE,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (student_id) REFERENCES students(id)
);

CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50)
);

INSERT INTO teachers (name, email, password) VALUES 
('Marc', 'marc@aut.com', SHA2('password123', 256)),


INSERT INTO courses (teacher_id, course_name) VALUES 
(1, 'Math 101'),
(1, 'Physics 201'),
(2, 'Chemistry 101'),
(2, 'Biology 202'),
(3, 'English 101'),
(3, 'History 201');

INSERT INTO attendance (course_id, student_id, status, date) VALUES 
(1, 1, 'Present', '2023-01-01'),
(1, 2, 'Absent', '2023-01-01'),
(2, 1, 'Late', '2023-01-02');


INSERT INTO students (name) VALUES 
('Student One'),
('Student Two'),
('Student Three');



