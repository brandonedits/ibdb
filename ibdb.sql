-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2019 at 11:45 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ibdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `author_id` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`author_id`, `fName`, `lName`) VALUES
(201, 'John', 'Calvin'),
(202, 'Kobe', 'Bryant'),
(203, 'Jane', 'Doe'),
(204, 'Michael', 'Jordan'),
(205, 'Brandon', 'Hempel'),
(206, 'Alfred', 'Hitchcock');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `isbn` int(11) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `synopsis` text NOT NULL,
  `is_published` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `user_id`, `title`, `isbn`, `genre`, `synopsis`, `is_published`, `created_at`) VALUES
(374, 1, 'Some Title', 1234567890, 'Horror', 'This is a test.', 1, '2019-12-08 17:04:45'),
(377, 1, 'Another Title', 12345, 'Comedy', 'This book is a book that is about something. Not sure what exactly.', 1, '2019-12-08 17:10:04'),
(378, 1, 'Test multiple authors', 53647456, 'Adventure', 'Testing multiple authors.', 1, '2019-12-08 17:15:00'),
(379, 1, 'Comedy Book', 453657, 'Comedy', 'This is a comedy.', 1, '2019-12-09 15:07:16'),
(380, 1, 'Horror Story', 4677745, 'Horror', 'This is a horror story.', 1, '2019-12-09 15:07:40'),
(381, 1, 'Little Johnny', 3537763, 'Mystery', 'This is a mystery about a boy named Johnny.', 1, '2019-12-09 15:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `book_author`
--

CREATE TABLE `book_author` (
  `book_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_author`
--

INSERT INTO `book_author` (`book_id`, `author_id`) VALUES
(374, 201),
(374, 202),
(377, 203),
(378, 201),
(378, 204),
(379, 205),
(380, 206),
(381, 201);

-- --------------------------------------------------------

--
-- Table structure for table `book_rating`
--

CREATE TABLE `book_rating` (
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_rating`
--

INSERT INTO `book_rating` (`user_id`, `book_id`, `rating`) VALUES
(1, 374, 5),
(3, 380, 3);

-- --------------------------------------------------------

--
-- Table structure for table `like_dislike`
--

CREATE TABLE `like_dislike` (
  `user_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `action` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `like_dislike`
--

INSERT INTO `like_dislike` (`user_id`, `review_id`, `action`) VALUES
(1, 124, 'like'),
(1, 126, 'like'),
(1, 127, 'like'),
(1, 128, 'like'),
(3, 128, 'like'),
(6, 124, 'dislike'),
(6, 126, 'like');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `review_title` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `is_published` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `book_id`, `review_title`, `comment`, `is_published`, `created_at`) VALUES
(124, 1, 374, 'shit book', 'This book is shit.', 1, '2019-12-08 17:07:36'),
(126, 1, 374, 'Testing Reviews', 'Decent book.', 1, '2019-12-08 17:56:29'),
(127, 1, 377, 'fuck', 'fuck this.', 1, '2019-12-08 18:05:51'),
(128, 1, 380, 'test review', 'testing', 1, '2019-12-09 15:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'brandon', 'brandonhempel@gmail.com', '$2y$10$hU1djgpaM8Z9kGRvfNsLr.7Rl91/Z82KYx4Z6wskNanucbtpZjeNy', 'admin', '2019-09-05 01:56:52'),
(2, 'tuan', 'tuan@gmail.com', '$2y$10$O5wDXMcErTtNZTBfvWWjYOl0EXYxSHoDl.C2ns9MUiYaqgaq0naJS', 'user', '2019-09-05 02:17:36'),
(3, 'John', 'john@gmail.com', '$2y$10$erUftTqzEIcd0ehoTzANqe7cMWlfUZCWSJL39QfBfHve8is5Z3z/6', 'general_user', '2019-09-19 23:52:34'),
(5, 'tom', 'tom@gmail.com', '$2y$10$sFmNyGHJjsQSsdpmZna21ea21wTYVCik.rAEBxOt5Hpnfz2T4ul5a', 'user', '2019-10-09 05:12:21'),
(6, 'Testr', 'testr@gmail.com', '$2y$10$RisyCGjCvnGeReAAyU3FTuAiJmCtEYuLINK0sQpikoytGgOzeBwSC', 'user', '2019-12-06 19:24:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`book_id`,`author_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `book_rating`
--
ALTER TABLE `book_rating`
  ADD PRIMARY KEY (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `like_dislike`
--
ALTER TABLE `like_dislike`
  ADD PRIMARY KEY (`user_id`,`review_id`),
  ADD KEY `review_id` (`review_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=382;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_rating`
--
ALTER TABLE `book_rating`
  ADD CONSTRAINT `book_rating_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `like_dislike`
--
ALTER TABLE `like_dislike`
  ADD CONSTRAINT `like_dislike_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_dislike_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
