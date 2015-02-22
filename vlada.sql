-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2015 at 10:18 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

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

CREATE TABLE IF NOT EXISTS `kosiky` (
`id_kosiku` int(11) NOT NULL,
  `id_uzivatele` int(11) DEFAULT NULL,
  `datum_vytvoreni` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `otevreny` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `kosiky`
--

INSERT INTO `kosiky` (`id_kosiku`, `id_uzivatele`, `datum_vytvoreni`, `otevreny`) VALUES
(1, NULL, '2015-02-20 09:40:04', 1),
(2, 3, '2015-02-20 09:40:04', 0),
(3, 3, '2015-02-20 10:04:58', 1),
(4, 4, '2015-02-20 10:39:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `materialy`
--

CREATE TABLE IF NOT EXISTS `materialy` (
`id_materialu` int(11) NOT NULL,
  `nazev` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `mnozstvi` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `materialy`
--

INSERT INTO `materialy` (`id_materialu`, `nazev`, `mnozstvi`) VALUES
(3, 'Spirulina', 4),
(4, 'hgfhdf', 77);

-- --------------------------------------------------------

--
-- Table structure for table `obrazky`
--

CREATE TABLE IF NOT EXISTS `obrazky` (
`id_obrazku` int(11) NOT NULL,
  `nazev` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `adresa` varchar(500) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produkty`
--

CREATE TABLE IF NOT EXISTS `produkty` (
`id_produktu` int(11) NOT NULL,
  `id_materialu` int(11) NOT NULL,
  `id_obrazku` int(11) DEFAULT NULL,
  `nazev` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `popis` text COLLATE utf8_czech_ci NOT NULL,
  `cena` int(11) NOT NULL,
  `mnozstvi` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `odecetMnozstvi` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`id_produktu`, `id_materialu`, `id_obrazku`, `nazev`, `popis`, `cena`, `mnozstvi`, `odecetMnozstvi`) VALUES
(3, 3, NULL, 'hhh', 'gdf', 55, '50g', 0.05),
(4, 3, NULL, 'yrt', 'treyer', 654, '66 g', 0.066);

-- --------------------------------------------------------

--
-- Table structure for table `uzivatele`
--

CREATE TABLE IF NOT EXISTS `uzivatele` (
`id_uzivatele` int(11) NOT NULL,
  `role` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT 'user',
  `email` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(1000) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `uzivatele`
--

INSERT INTO `uzivatele` (`id_uzivatele`, `role`, `email`, `heslo`) VALUES
(2, 'user', 'ee', '$2y$10$O60ekiBtDpS/o9vO7YrZYu4.R9ubZR6W7N1KeKrjpUE6CjyFb.oWi'),
(3, 'user', 'aa', '$2y$10$/YhNSqGAhzMYhUDBmDe0FOozArfBjkc/ev5g8bDsG8n.zXw7mWU0K'),
(4, 'admin', 'bb', '$2y$10$TMh7HJZC5ULfZBmIUSgmdOhncF3OZ8sIVOvRrhe6V9yyIYEeHRoli');

-- --------------------------------------------------------

--
-- Table structure for table `zbozi_kosik`
--

CREATE TABLE IF NOT EXISTS `zbozi_kosik` (
`id_zbozi_kosik` int(11) NOT NULL,
  `id_kosiku` int(11) NOT NULL,
  `id_zbozi` int(11) NOT NULL,
  `mnozstvi` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `zbozi_kosik`
--

INSERT INTO `zbozi_kosik` (`id_zbozi_kosik`, `id_kosiku`, `id_zbozi`, `mnozstvi`) VALUES
(1, 1, 3, 1),
(2, 1, 4, 3),
(3, 2, 3, 2),
(4, 2, 3, 3),
(5, 2, 3, 3),
(6, 2, 3, 2),
(7, 3, 3, 2),
(8, 3, 4, 4),
(9, 4, 3, 10),
(10, 4, 4, 1),
(11, 3, 3, 3);

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
 ADD PRIMARY KEY (`id_kosiku`);

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
 ADD PRIMARY KEY (`id_produktu`);

--
-- Indexes for table `uzivatele`
--
ALTER TABLE `uzivatele`
 ADD PRIMARY KEY (`id_uzivatele`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `zbozi_kosik`
--
ALTER TABLE `zbozi_kosik`
 ADD PRIMARY KEY (`id_zbozi_kosik`);

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
MODIFY `id_kosiku` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `materialy`
--
ALTER TABLE `materialy`
MODIFY `id_materialu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `obrazky`
--
ALTER TABLE `obrazky`
MODIFY `id_obrazku` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
MODIFY `id_produktu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `uzivatele`
--
ALTER TABLE `uzivatele`
MODIFY `id_uzivatele` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `zbozi_kosik`
--
ALTER TABLE `zbozi_kosik`
MODIFY `id_zbozi_kosik` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
