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


CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50),
	email VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL
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

CREATE TABLE IF NOT EXISTS registrations (
    student_id INT,
    course_id INT,
    PRIMARY KEY(student_id, course_id),
    FOREIGN KEY(student_id) REFERENCES students(id),
    FOREIGN KEY(course_id) REFERENCES courses(id)
);

INSERT INTO teachers (name, email, password) VALUES ('Mr. Johnson', 'johnson@example.com', 'password1');
INSERT INTO teachers (name, email, password) VALUES ('Ms. Smith', 'smith@example.com', 'password2');

INSERT INTO courses (course_name, teacher_id) VALUES ('Math 101', 1);
INSERT INTO courses (course_name, teacher_id) VALUES ('English 102', 2);

INSERT INTO students (name, email, password) VALUES ('John Doe', 'john@example.com', 'password3');
INSERT INTO students (name, email, password) VALUES ('Jane Doe', 'jane@example.com', 'password4');

INSERT INTO registrations (student_id, course_id) VALUES (1, 1);
INSERT INTO registrations (student_id, course_id) VALUES (1, 2);
INSERT INTO registrations (student_id, course_id) VALUES (2, 2);

INSERT INTO attendance (course_id, student_id, status, date) VALUES (1, 1, 'Present', CURDATE());
INSERT INTO attendance (course_id, student_id, status, date) VALUES (1, 1, 'Absent', DATE_SUB(CURDATE(), INTERVAL 1 DAY));
INSERT INTO attendance (course_id, student_id, status, date) VALUES (2, 1, 'Late', CURDATE());







