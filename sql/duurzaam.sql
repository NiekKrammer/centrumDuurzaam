-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 29 jan 2025 om 15:01
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `duurzaam`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `accounts`
--

CREATE TABLE `accounts` (
  `ID` int(11) NOT NULL,
  `Gebruikersnaam` varchar(255) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL,
  `Rol` varchar(255) NOT NULL,
  `Is_geverifieerd` tinyint(1) NOT NULL,
  `restore_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `accounts`
--

INSERT INTO `accounts` (`ID`, `Gebruikersnaam`, `Wachtwoord`, `Rol`, `Is_geverifieerd`, `restore_id`) VALUES
(1, 'directie', '$2y$10$z0O.NrpoBnlEh8k2gDhFCOLpW.lFcOVmNcsMt1IgvsmClyKUpAe7u', 'directie', 1, ''),
(2, 'magazijn', '$2y$10$rL.wDBv3AuxwDNCTObfRj.Nlf8cKVH6FUc6JaqgMHK8RfZ7yRLB.y', 'magazijn', 1, ''),
(3, 'winkelpersoneel', '$2y$10$GMjrUV0JiY5PS/ZsqdbuoOy7hxdQsAdCScoOo7qKumB2xTVyKZQze', 'winkelpersoneel', 1, ''),
(4, 'chaffeur', '$2y$10$yixCQ.2zCg1Ew.oapsxzuu69FQYRVKHuWhjyBjnc8npAm9WRmypDW', 'chaffeur', 1, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `prijs_ex_btw` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `categorie` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE TABLE `klant` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `plaats` varchar(255) NOT NULL,
  `telefoon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`id`, `naam`, `adres`, `plaats`, `telefoon`, `email`) VALUES
(0, 'Jan', 'Janstraat1', 'Janban', '06123456789', 'jan@email.com');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `planning`
--

CREATE TABLE `planning` (
  `id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `klant_id` int(11) NOT NULL,
  `kenteken` varchar(255) NOT NULL,
  `ophalen_of_bezorgen` enum('ophalen','bezorgen') NOT NULL,
  `afspraak_op` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verkopen`
--

CREATE TABLE `verkopen` (
  `id` int(11) NOT NULL,
  `klant_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `verkocht_op` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `voorraad`
--

CREATE TABLE `voorraad` (
  `id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `locatie` varchar(255) NOT NULL,
  `aantal` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `ingeboekt_op` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Indexen voor tabel `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artikel_id` (`artikel_id`,`klant_id`),
  ADD KEY `klant_id` (`klant_id`);

--
-- Indexen voor tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `verkopen`
--
ALTER TABLE `verkopen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `klant_id` (`klant_id`,`artikel_id`),
  ADD KEY `artikel_id` (`artikel_id`);

--
-- Indexen voor tabel `voorraad`
--
ALTER TABLE `voorraad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artikel_id` (`artikel_id`,`status_id`),
  ADD KEY `status_id` (`status_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `accounts`
--
ALTER TABLE `accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `planning`
--
ALTER TABLE `planning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `verkopen`
--
ALTER TABLE `verkopen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `voorraad`
--
ALTER TABLE `voorraad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `artikel_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);

--
-- Beperkingen voor tabel `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `planning_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`),
  ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`klant_id`) REFERENCES `klant` (`id`);

--
-- Beperkingen voor tabel `verkopen`
--
ALTER TABLE `verkopen`
  ADD CONSTRAINT `verkopen_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`),
  ADD CONSTRAINT `verkopen_ibfk_2` FOREIGN KEY (`klant_id`) REFERENCES `klant` (`id`);

--
-- Beperkingen voor tabel `voorraad`
--
ALTER TABLE `voorraad`
  ADD CONSTRAINT `voorraad_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`),
  ADD CONSTRAINT `voorraad_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
