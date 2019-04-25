-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2017 at 02:33 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plandaten`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(11) NOT NULL,
  `name` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`id`, `name`) VALUES
(0, 'Lebensmittel'),
(1, 'Hobbies'),
(2, 'Fahrtkosten'),
(3, 'Büromaterial'),
(4, 'Miete'),
(5, 'Ausgehen'),
(6, 'Kleidung'),
(7, 'Versicherungen'),
(8, 'Geschenke'),
(9, 'Multimedia'),
(10, 'Sonstige');

-- --------------------------------------------------------

--
-- Table structure for table `konto`
--

CREATE TABLE `konto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kontostand` decimal(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaktion`
--

CREATE TABLE `transaktion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `art` int(11) NOT NULL,
  `datum` date NOT NULL,
  `kategorie` int(11) NOT NULL,
  `betrag` decimal(15,2) NOT NULL,
  `konto` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konto`
--
ALTER TABLE `konto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaktion`
--
ALTER TABLE `transaktion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kat` (`kategorie`),
  ADD KEY `konto` (`konto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `konto`
--
ALTER TABLE `konto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaktion`
--
ALTER TABLE `transaktion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaktion`
--
ALTER TABLE `transaktion`
  ADD CONSTRAINT `kat` FOREIGN KEY (`kategorie`) REFERENCES `kategorie` (`id`),
  ADD CONSTRAINT `konto` FOREIGN KEY (`konto`) REFERENCES `konto` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
