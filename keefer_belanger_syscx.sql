CREATE DATABASE IF NOT EXISTS keefer_belanger_syscx;
USE keefer_belanger_syscx;

CREATE TABLE USERS_INFO (
    student_id INT(10) AUTO_INCREMENT PRIMARY KEY,
    student_email VARCHAR(150),
    first_name VARCHAR(150),
    last_name VARCHAR(150),
    dob DATE
);

ALTER TABLE USERS_INFO AUTO_INCREMENT = 100100;

CREATE TABLE USERS_PASSWORDS (
    student_id INT(10),
    password VARCHAR(255),
    PRIMARY KEY (student_id),
    FOREIGN KEY (student_id) REFERENCES USERS_INFO(student_id)
);

CREATE TABLE USERS_PROGRAM (
    student_id INT(10),
    program VARCHAR(50),
    PRIMARY KEY (student_id),
    FOREIGN KEY (student_id) REFERENCES USERS_INFO(student_id)
);

CREATE TABLE USERS_AVATAR (
    student_id INT(10),
    avatar VARCHAR(1),
    PRIMARY KEY (student_id),
    FOREIGN KEY (student_id) REFERENCES USERS_INFO(student_id)
);

CREATE TABLE USERS_ADDRESS (
    student_id INT(10),
    street_number INT(5),
    street_name VARCHAR(150),
    city VARCHAR(30),
    province VARCHAR(2),
    postal_code VARCHAR(7),
    PRIMARY KEY (student_id),
    FOREIGN KEY (student_id) REFERENCES USERS_INFO(student_id)
);

CREATE TABLE USERS_POSTS (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT(10),
    new_post TEXT,
    post_date TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES USERS_INFO(student_id)
);

-- DROP TABLE USERS_POSTS;
-- DROP TABLE USERS_ADDRESS;
-- DROP TABLE USERS_AVATAR;
-- DROP TABLE USERS_PROGRAM;
-- DROP TABLE USERS_PASSWORDS;
-- DROP TABLE USERS_INFO;