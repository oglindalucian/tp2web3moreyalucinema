-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2018 at 10:09 PM
-- Server version: 5.7.17
-- PHP Version: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdfilms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id_categ` int(10) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_categ`, `nom`) VALUES
(1, 'Action'),
(2, 'Comedie'),
(3, 'Drama'),
(4, 'Thriller'),
(5, 'Romance'),
(6, 'Horror'),
(7, 'Documentaire');

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE `film` (
  `no_film` int(10) UNSIGNED NOT NULL,
  `titre` varchar(100) NOT NULL,
  `realisateur` varchar(50) NOT NULL,
  `id_categ` int(10) UNSIGNED NOT NULL,
  `duree` int(11) UNSIGNED NOT NULL,
  `prix` float UNSIGNED NOT NULL,
  `pochette` varchar(255) NOT NULL,
  `source` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`no_film`, `titre`, `realisateur`, `id_categ`, `duree`, `prix`, `pochette`, `source`) VALUES
(2, 'Black Panther', 'r1', 1, 22222, 11, '5b6b31f412cf573080c8ac69076f066bd2f7337c.jpg', 'https://www.youtube.com/watch?v=xjDjIWPwcPU'),
(3, 'Labirinthe', 'r1', 2, 333, 2, 'ea90f8d6ed26139f7df796833c640edfe03a7ec8.jpg', 'https://www.youtube.com/watch?v=S_9OSktlm6s'),
(4, 'Star Wars: Episode V - The Empire Strikes Back (1980)', 'aa', 1, 1, 1, 'avatar.png', 'https://www.youtube.com/watch?v=JNwNXF9Y6kY'),
(5, 'Fight club', 'aa', 1, 2, 1, '08c9a892c2d0fbbe2ce5e4df0e3870fdd901d724.jpg', 'https://www.youtube.com/watch?v=SUXWAEX2jlg'),
(6, 'Gladiator', 'res', 3, 100, 25, '084c9992c98d6e4cd0d9f82a170e8aeb87152aa2.jpg', 'https://www.youtube.com/watch?v=lTmlYKiLBHI'),
(7, 'Terminator 2: Judgment Day', 'res', 4, 100, 25, 'avatar.png', 'https://www.youtube.com/watch?v=VVZQ39i5G1s'),
(9, 'film', 'res', 3, 100, 25, 'avatar.png', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categ`);

--
-- Indexes for table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`no_film`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categ` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `film`
--
ALTER TABLE `film`
  MODIFY `no_film` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
