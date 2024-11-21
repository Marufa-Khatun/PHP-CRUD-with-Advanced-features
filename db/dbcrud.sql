-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2024 at 11:32 AM
-- Server version: 5.7.39
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbcrud`
--

-- --------------------------------------------------------

--
-- Table structure for table `devs`
--

CREATE TABLE `devs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `age` int(3) NOT NULL,
  `skill` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `photo` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `trash` tinyint(1) DEFAULT '0',
  `createdAT` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updatedAT` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `devs`
--

INSERT INTO `devs` (`id`, `name`, `email`, `phone`, `age`, `skill`, `location`, `gender`, `photo`, `status`, `trash`, `createdAT`, `updatedAT`) VALUES
(14, 'Rifat ', 'rifat@gmail.com', '01780669444', 50, '.net', 'Uttara', 'Male', '1732079378_42800161.jfif', 1, 0, '2024-11-15 17:05:54.224273', NULL),
(19, 'Salim', 'salim@gmail.com', '01780668765', 23, '.net', 'Rajshahi', 'Male', '1731934310_95512550.jfif', 1, 0, '2024-11-18 12:51:50.376619', NULL),
(20, 'Farnaz Kabir', 'farnaz@gmail.com', '01780339145', 35, 'Laravel', 'Uttara', 'Male', '1732078689_54078791.jfif', 0, 0, '2024-11-20 04:58:09.770470', NULL),
(22, 'Saddam', 'saddam@gmail.com', '01780668765', 25, 'ReactJs', 'Rajshahi', 'Male', '1732078784_64696174.jpg', 1, 0, '2024-11-20 04:59:44.587375', NULL),
(23, 'Rina', 'rina@gmail.com', '+8801780669333', 15, 'ReactJs', 'Rajshahi', 'Female', '1732079579_87245111.webp', 1, 0, '2024-11-20 05:00:25.028354', NULL),
(24, 'Pia', 'pia@gmail.com', '01780669666', 18, 'JS', 'Mirpur', 'Female', '1732078866_52719307.webp', 0, 1, '2024-11-20 05:01:06.285307', NULL),
(25, 'Suma', 'suma@gmail.com', '01780335262', 10, '.net', 'Rajshahi', 'Female', '1732079005_3674517.jpg', 0, 1, '2024-11-20 05:03:25.296736', NULL),
(26, 'Sristy ', 'sristy@gmail.com', '01732445674', 18, 'MERN', 'Mirpur', 'Female', '1732101249_69528464.jpg', 0, 0, '2024-11-20 11:14:10.004344', NULL),
(27, 'Mou', 'mou@gmail.com', '01380669276', 45, 'Laravel', 'Uttara', 'Female', '1732102367_31149666.jfif', 0, 1, '2024-11-20 11:32:47.721605', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `devs`
--
ALTER TABLE `devs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `devs`
--
ALTER TABLE `devs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
