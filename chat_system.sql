-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 15, 2023 at 04:50 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `ID` int(10) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `sender_id` varchar(255) DEFAULT NULL,
  `receiver_id` varchar(255) DEFAULT NULL,
  `msg` varchar(255) DEFAULT NULL,
  `is_outgoing` int(10) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `last_msg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`ID`, `session_id`, `sender`, `receiver`, `sender_id`, `receiver_id`, `msg`, `is_outgoing`, `timestamp`, `last_msg`) VALUES
(1, 'S100', 'hema', 'rekha', 'U100', 'U102', 'hema sends', 1, '2023-03-29 18:54:25', 'hi hema'),
(53, 'S100', 'rekha', 'hema', 'U102', 'U100', 'rekha sends', 0, '2023-04-16 19:21:03', 'hi rekha'),
(150, 'undefined', '', '', '', '', 'H S', 0, '2023-05-15 08:07:43', 'H S'),
(151, 'undefined', '', '', '', '', 'H S', 0, '2023-05-15 08:07:47', 'H S'),
(152, 'S103', 'sushma', 'hema', 'U104', 'U100', 'S H', 1, '2023-05-15 08:08:02', 'S H');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `ID` int(10) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `sender` varchar(255) DEFAULT NULL,
  `receiver` varchar(255) DEFAULT NULL,
  `sender_id` varchar(255) DEFAULT NULL,
  `receiver_id` varchar(255) DEFAULT NULL,
  `is_read` int(1) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `last_msg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`ID`, `session_id`, `sender`, `receiver`, `sender_id`, `receiver_id`, `is_read`, `timestamp`, `last_msg`) VALUES
(1, 'S100', 'hema', 'rekha', 'U100', 'U102', 1, '2023-03-29 19:54:25', 'H S'),
(2, 'S101', 'jaya', 'hema', 'U103', 'U100', 1, '2023-03-29 15:54:25', 'hi hema'),
(71, '', '', 'h', '', '', NULL, '2023-05-15 08:05:43', NULL),
(75, 'S102', 'sushma', 'hema', 'U104', ' ', NULL, '2023-05-15 08:07:33', NULL),
(76, 'S103', 'sushma', 'hema', 'U104', 'U100', NULL, '2023-05-15 08:07:37', 'S H');

--
-- Triggers `sessions`
--
DELIMITER $$
CREATE TRIGGER `session_id` BEFORE INSERT ON `sessions` FOR EACH ROW BEGIN
    DECLARE new_sid VARCHAR(10) default 0;
DECLARE max_sid INT default 0;
    SET new_sid = 'S100';

    IF EXISTS(SELECT session_id FROM sessions WHERE session_id = NEW.session_id)
    THEN   
        SELECT MAX(CAST(SUBSTRING(session_id, 2) AS UNSIGNED)) INTO max_sid FROM sessions WHERE session_id REGEXP '^S[0-9]+$';
        SET NEW.session_id = CONCAT('S', LPAD(max_sid + 1, 3, '0'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` varchar(255) NOT NULL,
  `uname` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `uname`, `pwd`, `full_name`, `bio`) VALUES
('', 'admin', 'anu', 'anu', 'anu'),
('U100', 'hema', 'hema', 'hema', 'hema'),
('U102', 'rekha', 'rekha', 'rekha', 'jaya'),
('U103', 'jaya', 'jaya', 'jaya', 'jaya'),
('U104', 'sushma', 'sushma', 'sushma', 'sushma'),
('U105', 'anu', 'anu', 'anu', 'anu'),
('U106', 'azula_azula', 'azula', 'azula mehta', 'Hi! im azula');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `create_uid` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    DECLARE new_uid VARCHAR(10) default 0;
DECLARE max_uid INT default 0;
    SET new_uid = 'U100';

    IF EXISTS(SELECT uid FROM users WHERE uid = NEW.uid)
    THEN
        
        SELECT MAX(CAST(SUBSTRING(uid, 2) AS UNSIGNED)) INTO max_uid FROM users WHERE uid REGEXP '^U[0-9]+$';
        SET NEW.uid = CONCAT('U', LPAD(max_uid + 1, 3, '0'));
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
