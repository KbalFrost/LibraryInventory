-- Create DATABASE named 'Library'
CREATE DATABASE Library;

-- Switch to the 'Library' database
USE Library;

-- Create BOOK table
CREATE TABLE BOOK (
    entry_num AUTO_INCREMENT INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100) NOT NULL,
    publisher VARCHAR(100),
    ISBN_num VARCHAR(20) UNIQUE,
    version INT,
    shelf VARCHAR(20)
);

-- Create USER table with favorite_book
CREATE TABLE USER (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone_number VARCHAR(20),
    favorite_book VARCHAR(255),
    password VARCHAR(255),
    user_role VARCHAR(20)
);

-- Create AVAILABILITY table with quantity
CREATE TABLE AVAILABILITY (
    availability_id INT AUTO_INCREMENT PRIMARY KEY,
    book_entry_num INT,
    status VARCHAR(20) CHECK (status IN ('available', 'unavailable')),
    quantity INT,
    FOREIGN KEY (book_entry_num) REFERENCES BOOK(entry_num)
);

