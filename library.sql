CREATE DATABASE `library`;
USE `library`;

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `book_name` varchar(100) NOT NULL,
  `book_title` varchar(100) NOT NULL,
  `book_description` varchar(100) NOT NULL,
  `book_author` varchar(100) NOT NULL,
  `book_volume` varchar(3) NOT NULL,
  `book_publishing_company` varchar(100) NOT NULL,
  `book_edition` varchar(3) NOT NULL,
  `book_publication` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;