-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2015 at 03:18 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `aktuality`
--

CREATE TABLE IF NOT EXISTS `aktuality` (
`id_aktuality` int(11) NOT NULL,
  `nadpis` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

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

CREATE TABLE IF NOT EXISTS `clanky` (
`id_clanku` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nadpis` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `clanky`
--

INSERT INTO `clanky` (`id_clanku`, `datum`, `nadpis`, `text`) VALUES
(1, '2015-02-10 17:20:33', 'Prvni clanek', 'Text prvniho clanku'),
(2, '2015-02-13 12:26:19', 'Mujj clanek', 'nfsadn  kgmdsa kfmdskl mfkdsm kfma kfmd;l'),
(3, '2015-02-20 12:39:09', 'glkfgmksldgkls d', 'hahaha\n \nh\n\nhrthbrtzhdt\nghf\nhf\n\ngjgh'),
(4, '2015-03-03 10:17:32', 'ggg', '<p>toto je novzy clane&nbsp;</p>\n\n<p><strong>fsdfasdf</strong></p>\n\n<table border="1" cellpadding="1" cellspacing="1" style="width:500px">\n	<tbody>\n		<tr>\n			<td>gfdsg</td>\n			<td>fgsdfg</td>\n		</tr>\n		<tr>\n			<td>fdgsdfg</td>\n			<td>gsd</td>\n		</tr>\n		<tr>\n			<td>rewrefdsf</td>\n			<td>gsdfg</td>\n		</tr>\n	</tbody>\n</table>\n\n<p>&nbsp;</p>\n');

-- --------------------------------------------------------

--
-- Table structure for table `kosiky`
--

CREATE TABLE IF NOT EXISTS `kosiky` (
`id_kosiku` int(11) NOT NULL,
  `id_uzivatele` int(11) DEFAULT NULL,
  `datum_vytvoreni` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `datum_objednani` timestamp NULL DEFAULT NULL,
  `datum_potvrzeni` timestamp NULL DEFAULT NULL,
  `datum_odeslani` timestamp NULL DEFAULT NULL,
  `datum_doruceni` timestamp NULL DEFAULT NULL,
  `jmeno` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  `prijmeni` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL,
  `stav` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT 'nový'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `kosiky`
--

INSERT INTO `kosiky` (`id_kosiku`, `id_uzivatele`, `datum_vytvoreni`, `datum_objednani`, `datum_potvrzeni`, `datum_odeslani`, `datum_doruceni`, `jmeno`, `prijmeni`, `stav`) VALUES
(14, 3, '2015-03-19 09:26:15', '2015-03-19 11:03:16', '2015-03-19 11:20:27', '2015-03-19 11:25:51', NULL, 'hh', 'hh', 'odeslaný'),
(15, 3, '2015-03-19 11:03:25', '2015-03-19 11:06:49', NULL, NULL, NULL, 'bb', 'bb', 'objednaný'),
(16, 3, '2015-03-19 11:06:49', NULL, NULL, NULL, NULL, NULL, NULL, 'nový'),
(17, 4, '2015-03-19 11:07:34', NULL, NULL, NULL, NULL, NULL, NULL, 'nový');

-- --------------------------------------------------------

--
-- Table structure for table `materialy`
--

CREATE TABLE IF NOT EXISTS `materialy` (
`id_materialu` int(11) NOT NULL,
  `nazev` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `mnozstvi` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `materialy`
--

INSERT INTO `materialy` (`id_materialu`, `nazev`, `mnozstvi`) VALUES
(1, 'Spirulina', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `obrazky`
--

CREATE TABLE IF NOT EXISTS `obrazky` (
`id_obrazku` int(11) NOT NULL,
  `nazev` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `adresa` varchar(500) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `obrazky`
--

INSERT INTO `obrazky` (`id_obrazku`, `nazev`, `adresa`) VALUES
(1, 'vybuch.png', 'images/vybuch.png'),
(2, 'kredity.jpg', 'images/kredity.jpg'),
(3, 'letadlo1.png', 'images/letadlo1.png'),
(4, 'ufo.png', 'images/ufo.png');

-- --------------------------------------------------------

--
-- Table structure for table `produkty`
--

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
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`id_produktu`, `id_materialu`, `id_obrazku`, `nazev`, `popis`, `cena`, `mnozstvi`, `odecetMnozstvi`) VALUES
(1, 1, 1, 'aa', 'aa', 333, '33', 3),
(2, NULL, 2, 'bbb', 'bbb', 44, '3', 3),
(3, NULL, 3, 'ttt', 'ttt', 44, '554', 55);

-- --------------------------------------------------------

--
-- Table structure for table `uzivatele`
--

CREATE TABLE IF NOT EXISTS `uzivatele` (
`id_uzivatele` int(11) NOT NULL,
  `datum_registrace` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT 'user',
  `email` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(1000) COLLATE utf8_czech_ci NOT NULL,
  `actived` tinyint(1) NOT NULL DEFAULT '0',
  `activ_code` varchar(1000) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

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

CREATE TABLE IF NOT EXISTS `zbozi_kosik` (
`id_zbozi_kosik` int(11) NOT NULL,
  `id_kosiku` int(11) NOT NULL,
  `id_zbozi` int(11) DEFAULT NULL,
  `mnozstvi` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `zbozi_kosik`
--

INSERT INTO `zbozi_kosik` (`id_zbozi_kosik`, `id_kosiku`, `id_zbozi`, `mnozstvi`) VALUES
(16, 14, 1, 4),
(18, 15, 1, 2),
(19, 16, 2, 3),
(20, 16, 1, 4);

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
MODIFY `id_clanku` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `kosiky`
--
ALTER TABLE `kosiky`
MODIFY `id_kosiku` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `materialy`
--
ALTER TABLE `materialy`
MODIFY `id_materialu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `obrazky`
--
ALTER TABLE `obrazky`
MODIFY `id_obrazku` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
MODIFY `id_produktu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `uzivatele`
--
ALTER TABLE `uzivatele`
MODIFY `id_uzivatele` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `zbozi_kosik`
--
ALTER TABLE `zbozi_kosik`
MODIFY `id_zbozi_kosik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
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
