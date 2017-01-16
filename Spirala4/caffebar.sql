-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2017 at 11:03 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `caffebar`
--

-- --------------------------------------------------------

--
-- Table structure for table `cjenovnik`
--

CREATE TABLE `cjenovnik` (
  `id` int(11) NOT NULL,
  `proizvod` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `cijena` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `korisnik` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `proizvodFK` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `cjenovnik`
--

INSERT INTO `cjenovnik` (`id`, `proizvod`, `cijena`, `korisnik`, `proizvodFK`) VALUES
(1, 'Coca Cola 0.25', '3.0', 'amina', NULL),
(2, 'Sprite 0.25', '3.0', 'amina', NULL),
(3, 'Fanta 0.25', '3.0', 'amina', NULL),
(4, 'Juicy 0.25', '3.0', 'amina', NULL),
(5, 'Kafa', '1.5', 'amina', NULL),
(6, 'Kafa sa mlijekom', '2.0', 'amina', NULL),
(7, 'Cappuccino', '2.0', 'amina', NULL),
(8, 'Topla čokolada', '2.5', 'amina', NULL),
(9, 'Red Bull', '5', 'amina', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prijedlozi`
--

CREATE TABLE `prijedlozi` (
  `id` int(11) NOT NULL,
  `proizvod` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `cijena` varchar(50) COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `prijedlozi`
--

INSERT INTO `prijedlozi` (`id`, `proizvod`, `cijena`) VALUES
(20, 'Burn', '3.5'),
(21, 'Limunada', '2.0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `email`) VALUES
('amina', 'f40e10d6679fcdc5786e8a88c75ed96d', 'akrekic1@etf.unsa.ba'),
('belma', '5bedbc45e8e8dcad7467de8f798e5ae8', 'bskopljako@etf.unsa.ba'),
('korisnik', '5116f16d3399fcb6571f571d79f35f41', 'korisnik@etf.unsa.ba');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cjenovnik`
--
ALTER TABLE `cjenovnik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nazivProizvodaFK` (`proizvodFK`,`korisnik`),
  ADD KEY `korisnik` (`korisnik`),
  ADD KEY `proizvodFK` (`proizvodFK`);

--
-- Indexes for table `prijedlozi`
--
ALTER TABLE `prijedlozi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prijedlozi`
--
ALTER TABLE `prijedlozi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cjenovnik`
--
ALTER TABLE `cjenovnik`
  ADD CONSTRAINT `cjenovnik_ibfk_1` FOREIGN KEY (`korisnik`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `cjenovnik_ibfk_2` FOREIGN KEY (`proizvodFK`) REFERENCES `prijedlozi` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
