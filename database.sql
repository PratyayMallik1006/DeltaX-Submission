-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2022 at 07:34 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deltax`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `bio` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `dob`, `bio`) VALUES
(1, 'Pratyay Mallik', 'June 10,2000', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam'),
(2, 'Arijit Singh', 'April 25, 1987', 'Arijit Singh is an Indian singer and music composer. He sings predominantly in Hindi and Bengali, but has also performed in various other Indian languages.'),
(3, 'Shreya Ghoshal', 'March 12, 1984', 'Shreya Ghoshal is an Indian singer and television personality. One of the highest-paid and well-established playback singers of Hindi cinema'),
(4, 'Anupam Roy', 'March 29, 1982', 'Anupam Roy is an Indian singer, singer-songwriter, music director, composer, songwriter, guitarist, playback singer from Kolkata, West Bengal.');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `artists` varchar(100) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `artists_id` varchar(50) NOT NULL,
  `rating_count` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `name`, `date`, `image`, `artists`, `rating`, `artists_id`, `rating_count`) VALUES
(1, 'Samjhawan', 'July 24, 2014', 'Sanmjhaawaan.jpg', 'Arijit Singh,Shreya Ghoshal,', '4.4', '2,3', 50),
(2, 'Parbona', 'July 11, 2014', 'arijit.jpg', 'Arijit Singh,', '5.0', '2', 100),
(3, 'Tum Hi Ho', 'May 20, 2013', 'music1.jpg', 'Arijit Singh,', '4.2', '2', 1),
(4, 'Naam Na Jana Pakhi', 'February 28, 2018', 'piano.jpg', 'Arijit Singh,Shreya Ghoshal,', '4.0', '2,3', 3),
(5, 'Boba Tunnel', 'September 8, 2014 ', 'music.jpg', 'Anupam Roy,', '4.3', '4', 1),
(6, 'Sun Raha Hai Na Tu', 'May 15, 2013', 'singing.jpg', 'Shreya Ghoshal,', '2.0', '3', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
