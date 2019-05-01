-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 01. Mai 2019 um 11:17
-- Server-Version: 10.1.38-MariaDB
-- PHP-Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `filemanager`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  `dateUploaded` datetime NOT NULL,
  `counterDownloaded` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `file`
--

INSERT INTO `file` (`id`, `filename`, `path`, `userID`, `dateUploaded`, `counterDownloaded`) VALUES
(1, 'Lebenslauf.docx', 'cloud/Privat/Bewerbung', 1, '2019-05-01 11:01:10', 0),
(2, 'Geschaeftsbedingung.pdf', 'cloud/Geschäftlich', 1, '2019-05-01 11:02:37', 0),
(3, 'Abrechnung.xlsx', 'cloud/Geschäftlich', 1, '2019-05-01 11:02:44', 0),
(4, 'Song.mp3', 'cloud', 1, '2019-05-01 11:03:13', 0),
(5, 'Archiv.zip', 'cloud/Geschäftlich', 1, '2019-05-01 11:03:25', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `activationKey` varchar(255) NOT NULL,
  `roleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin7;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `gender`, `firstname`, `lastname`, `email`, `password`, `active`, `activationKey`, `roleID`) VALUES
(1, 'm', 'Max', 'Mustermann', 'filemanager@manuelseisl.at', '$2y$10$iEU0aJWqsimacd1JAgyBMuX0OsuIM12w101/akGxKa59aaSwi0xeO', 1, '$2y$10$PXpLeamW2ksmRD4iTOT8du7ZhSee.c4TN9.rYRg1D1TOwYGuq68O2', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userrole`
--

CREATE TABLE `userrole` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `uRead` bit(1) NOT NULL,
  `uWrite` bit(1) NOT NULL,
  `uChange` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin7;

--
-- Daten für Tabelle `userrole`
--

INSERT INTO `userrole` (`id`, `role`, `uRead`, `uWrite`, `uChange`) VALUES
(1, 'root', b'1', b'1', b'1');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roleID` (`roleID`);

--
-- Indizes für die Tabelle `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `userrole`
--
ALTER TABLE `userrole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleID`) REFERENCES `userrole` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
