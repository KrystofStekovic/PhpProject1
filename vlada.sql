-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2015 at 05:19 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vlada`
--
CREATE DATABASE IF NOT EXISTS `vlada` DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci;
USE `vlada`;

-- --------------------------------------------------------

--
-- Table structure for table `aktuality`
--
-- Creation: Feb 22, 2015 at 09:41 PM
--

DROP TABLE IF EXISTS `aktuality`;
CREATE TABLE IF NOT EXISTS `aktuality` (
`id_aktuality` int(11) NOT NULL,
  `nadpis` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Truncate table before insert `aktuality`
--

TRUNCATE TABLE `aktuality`;
--
-- Dumping data for table `aktuality`
--

INSERT INTO `aktuality` (`id_aktuality`, `nadpis`, `text`, `datum`) VALUES
(1, 'prvni aktualita', 'text aktuality', '2015-02-10 14:38:38'),
(2, 'Druha aktualita', 'text druhe aktuality', '2015-02-11 12:21:35');

-- --------------------------------------------------------

--
-- Table structure for table `clanky`
--
-- Creation: Feb 22, 2015 at 09:41 PM
--

DROP TABLE IF EXISTS `clanky`;
CREATE TABLE IF NOT EXISTS `clanky` (
`id_clanku` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nadpis` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Truncate table before insert `clanky`
--

TRUNCATE TABLE `clanky`;
--
-- Dumping data for table `clanky`
--

INSERT INTO `clanky` (`id_clanku`, `datum`, `nadpis`, `text`) VALUES
(1, '2015-02-10 17:20:33', 'Prvni clanek', 'Text prvniho clanku'),
(2, '2015-02-13 12:26:19', 'Mujj clanek', 'nfsadn  kgmdsa kfmdskl mfkdsm kfma kfmd;l'),
(3, '2015-02-20 12:39:09', 'glkfgmksldgkls d', 'gfsjzbermglkrsmgbldsf¨¨)h\n \nh\n\nhrthbrtzhdt\nghf\nhf\n\ngjgh');

-- --------------------------------------------------------

--
-- Table structure for table `kosiky`
--
-- Creation: Feb 25, 2015 at 09:17 AM
--

DROP TABLE IF EXISTS `kosiky`;
CREATE TABLE IF NOT EXISTS `kosiky` (
`id_kosiku` int(11) NOT NULL,
  `id_uzivatele` int(11) DEFAULT NULL,
  `datum_vytvoreni` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `otevreny` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- RELATIONS FOR TABLE `kosiky`:
--   `id_uzivatele`
--       `uzivatele` -> `id_uzivatele`
--

--
-- Truncate table before insert `kosiky`
--

TRUNCATE TABLE `kosiky`;
--
-- Dumping data for table `kosiky`
--

INSERT INTO `kosiky` (`id_kosiku`, `id_uzivatele`, `datum_vytvoreni`, `otevreny`) VALUES
(1, 4, '2015-02-25 21:59:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `materialy`
--
-- Creation: Feb 22, 2015 at 09:41 PM
--

DROP TABLE IF EXISTS `materialy`;
CREATE TABLE IF NOT EXISTS `materialy` (
`id_materialu` int(11) NOT NULL,
  `nazev` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `mnozstvi` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Truncate table before insert `materialy`
--

TRUNCATE TABLE `materialy`;
-- --------------------------------------------------------

--
-- Table structure for table `obrazky`
--
-- Creation: Feb 22, 2015 at 09:41 PM
--

DROP TABLE IF EXISTS `obrazky`;
CREATE TABLE IF NOT EXISTS `obrazky` (
`id_obrazku` int(11) NOT NULL,
  `nazev` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `adresa` varchar(500) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Truncate table before insert `obrazky`
--

TRUNCATE TABLE `obrazky`;
--
-- Dumping data for table `obrazky`
--

INSERT INTO `obrazky` (`id_obrazku`, `nazev`, `adresa`) VALUES
(1, 'vybuch.png', 'images/vybuch.png'),
(2, 'kredity.jpg', 'images/kredity.jpg'),
(3, 'letadlo1.png', 'images/letadlo1.png');

-- --------------------------------------------------------

--
-- Table structure for table `produkty`
--
-- Creation: Feb 25, 2015 at 09:23 AM
--

DROP TABLE IF EXISTS `produkty`;
CREATE TABLE IF NOT EXISTS `produkty` (
`id_produktu` int(11) NOT NULL,
  `id_materialu` int(11) DEFAULT NULL,
  `id_obrazku` int(11) DEFAULT NULL,
  `nazev` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `popis` text COLLATE utf8_czech_ci NOT NULL,
  `cena` int(11) NOT NULL,
  `mnozstvi` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `odecetMnozstvi` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- RELATIONS FOR TABLE `produkty`:
--   `id_obrazku`
--       `obrazky` -> `id_obrazku`
--   `id_materialu`
--       `materialy` -> `id_materialu`
--

--
-- Truncate table before insert `produkty`
--

TRUNCATE TABLE `produkty`;
--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`id_produktu`, `id_materialu`, `id_obrazku`, `nazev`, `popis`, `cena`, `mnozstvi`, `odecetMnozstvi`) VALUES
(1, NULL, 1, 'aa', 'aa', 33, '33', 3),
(2, NULL, 2, 'bbb', 'bbb', 44, '3', 3),
(3, NULL, 3, 'ttt', 'ttt', 44, '554', 55);

-- --------------------------------------------------------

--
-- Table structure for table `uzivatele`
--
-- Creation: Feb 26, 2015 at 03:06 PM
--

DROP TABLE IF EXISTS `uzivatele`;
CREATE TABLE IF NOT EXISTS `uzivatele` (
`id_uzivatele` int(11) NOT NULL,
  `datum_registrace` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT 'user',
  `email` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(1000) COLLATE utf8_czech_ci NOT NULL,
  `actived` tinyint(1) NOT NULL DEFAULT '0',
  `activ_code` varchar(1000) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Truncate table before insert `uzivatele`
--

TRUNCATE TABLE `uzivatele`;
--
-- Dumping data for table `uzivatele`
--

INSERT INTO `uzivatele` (`id_uzivatele`, `datum_registrace`, `role`, `email`, `heslo`, `actived`, `activ_code`) VALUES
(3, '2015-02-26 15:06:39', 'user', 'aa', '$2y$10$/YhNSqGAhzMYhUDBmDe0FOozArfBjkc/ev5g8bDsG8n.zXw7mWU0K', 0, ''),
(4, '2015-02-26 15:06:39', 'admin', 'bb', '$2y$10$TMh7HJZC5ULfZBmIUSgmdOhncF3OZ8sIVOvRrhe6V9yyIYEeHRoli', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `zbozi_kosik`
--
-- Creation: Feb 25, 2015 at 09:25 AM
--

DROP TABLE IF EXISTS `zbozi_kosik`;
CREATE TABLE IF NOT EXISTS `zbozi_kosik` (
`id_zbozi_kosik` int(11) NOT NULL,
  `id_kosiku` int(11) NOT NULL,
  `id_zbozi` int(11) DEFAULT NULL,
  `mnozstvi` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- RELATIONS FOR TABLE `zbozi_kosik`:
--   `id_kosiku`
--       `kosiky` -> `id_kosiku`
--   `id_zbozi`
--       `produkty` -> `id_produktu`
--

--
-- Truncate table before insert `zbozi_kosik`
--

TRUNCATE TABLE `zbozi_kosik`;
--
-- Dumping data for table `zbozi_kosik`
--

INSERT INTO `zbozi_kosik` (`id_zbozi_kosik`, `id_kosiku`, `id_zbozi`, `mnozstvi`) VALUES
(1, 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktuality`
--
ALTER TABLE `aktuality`
 ADD PRIMARY KEY (`id_aktuality`);

--
-- Indexes for table `clanky`
--
ALTER TABLE `clanky`
 ADD PRIMARY KEY (`id_clanku`);

--
-- Indexes for table `kosiky`
--
ALTER TABLE `kosiky`
 ADD PRIMARY KEY (`id_kosiku`), ADD KEY `id_uzivatele` (`id_uzivatele`);

--
-- Indexes for table `materialy`
--
ALTER TABLE `materialy`
 ADD PRIMARY KEY (`id_materialu`);

--
-- Indexes for table `obrazky`
--
ALTER TABLE `obrazky`
 ADD PRIMARY KEY (`id_obrazku`), ADD UNIQUE KEY `nazev` (`nazev`);

--
-- Indexes for table `produkty`
--
ALTER TABLE `produkty`
 ADD PRIMARY KEY (`id_produktu`), ADD KEY `id_obrazku` (`id_obrazku`), ADD KEY `id_materialu` (`id_materialu`), ADD KEY `id_materialu_2` (`id_materialu`), ADD KEY `id_materialu_3` (`id_materialu`), ADD KEY `id_obrazku_2` (`id_obrazku`);

--
-- Indexes for table `uzivatele`
--
ALTER TABLE `uzivatele`
 ADD PRIMARY KEY (`id_uzivatele`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `zbozi_kosik`
--
ALTER TABLE `zbozi_kosik`
 ADD PRIMARY KEY (`id_zbozi_kosik`), ADD KEY `id_kosiku` (`id_kosiku`), ADD KEY `id_zbozi` (`id_zbozi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktuality`
--
ALTER TABLE `aktuality`
MODIFY `id_aktuality` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `clanky`
--
ALTER TABLE `clanky`
MODIFY `id_clanku` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kosiky`
--
ALTER TABLE `kosiky`
MODIFY `id_kosiku` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `materialy`
--
ALTER TABLE `materialy`
MODIFY `id_materialu` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `obrazky`
--
ALTER TABLE `obrazky`
MODIFY `id_obrazku` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
MODIFY `id_produktu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `uzivatele`
--
ALTER TABLE `uzivatele`
MODIFY `id_uzivatele` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `zbozi_kosik`
--
ALTER TABLE `zbozi_kosik`
MODIFY `id_zbozi_kosik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `kosiky`
--
ALTER TABLE `kosiky`
ADD CONSTRAINT `kosiky_ibfk_1` FOREIGN KEY (`id_uzivatele`) REFERENCES `uzivatele` (`id_uzivatele`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produkty`
--
ALTER TABLE `produkty`
ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`id_obrazku`) REFERENCES `obrazky` (`id_obrazku`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `produkty_ibfk_2` FOREIGN KEY (`id_materialu`) REFERENCES `materialy` (`id_materialu`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `zbozi_kosik`
--
ALTER TABLE `zbozi_kosik`
ADD CONSTRAINT `zbozi_kosik_ibfk_1` FOREIGN KEY (`id_kosiku`) REFERENCES `kosiky` (`id_kosiku`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `zbozi_kosik_ibfk_2` FOREIGN KEY (`id_zbozi`) REFERENCES `produkty` (`id_produktu`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
