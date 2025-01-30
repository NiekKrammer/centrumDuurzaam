-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 30 jan 2025 om 15:51
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

CREATE DATABASE IF NOT EXISTS duurzaam;

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
  `blocked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `accounts`
--

INSERT INTO `accounts` (`ID`, `Gebruikersnaam`, `Wachtwoord`, `Rol`, `Is_geverifieerd`, `blocked`) VALUES
(1, 'directie', '$2y$10$z0O.NrpoBnlEh8k2gDhFCOLpW.lFcOVmNcsMt1IgvsmClyKUpAe7u', 'directie', 1, 0),
(2, 'magazijn', '$2y$10$rL.wDBv3AuxwDNCTObfRj.Nlf8cKVH6FUc6JaqgMHK8RfZ7yRLB.y', 'magazijn', 1, 0),
(3, 'winkelpersoneel', '$2y$10$GMjrUV0JiY5PS/ZsqdbuoOy7hxdQsAdCScoOo7qKumB2xTVyKZQze', 'winkelpersoneel', 1, 0),
(4, 'chaffeur', '$2y$10$yixCQ.2zCg1Ew.oapsxzuu69FQYRVKHuWhjyBjnc8npAm9WRmypDW', 'chaffeur', 1, 0),
(5, 'directie2', '$2y$10$4RpYktmWYKGswcaohDnXUeeh41YLrHXWT0gt1x0wLRxjY/ss4PSiq', 'directie', 1, 0),
(6, 'directie3', '$2y$10$IH.G05vZAbXpqG8db9QgZelrmwNOOInHE4m8p0zSpxHQhWzKepgZi', 'directie', 1, 0),
(7, 'magazijnmedewerker2', '$2y$10$Rz8tO6mmCXXK5tshFUNqnOugACAUEkMs6Q6zK1e5tlRStZQQzo0Ha', 'magazijnmedewerker', 1, 0),
(8, 'magazijnmedewerker3', '$2y$10$yJGUyKcMEjDYZEMuo20QIO5ddWzOWyZXUjRQ1fBxhFtAo27bTolsC', 'magazijnmedewerker', 1, 0),
(9, 'magazijnmedewerker4', '$2y$10$yaJ0OzreeL0QURFvA2wgaOx0zp6g6GUzhR8fCITfpWk3Wo0EJfhE.', 'magazijnmedewerker', 1, 0),
(10, 'magazijnmedewerker5', '$2y$10$Gg6wNJK.CSruC2TKAR27c.km1EIY9U2rlmUmEnkzboH.B.v2NAdAq', 'magazijnmedewerker', 1, 0),
(11, 'chaffeur2', '$2y$10$Z9rE1oZOXZ9SRZLnsYLR2.2Q0BIee1vY/n6G0QWjHqVsswBzaL9fS', 'chaffeur', 1, 0),
(12, 'chaffeur3', '$2y$10$vExmqNnOnQzG1yIaW0f6H./Rb8DfPs2FrOxCN.Sx/lV4bTDpU8fgS', 'chaffeur', 1, 0),
(13, 'chaffeur4', '$2y$10$d8I.ItMMbFXSnfRU1wIT9uTv.3bFjddA/wZ8cUhE1hxIubnRbhZkW', 'chaffeur', 1, 0),
(14, 'chaffeur5', '$2y$10$bNMn../kdcQxbj3J3NToHOQ4NClDXO5xwKoPDNENuowCEYOlQJ/xC', 'chaffeur', 1, 0),
(15, 'chaffeur6', '$2y$10$xgLQWyG3.qKf3NWxvcKQo.oDIjyTbDdsRMmGfbcdJ8G0mn9CvGoeK', 'chaffeur', 1, 0),
(16, 'winkelpersoneel2', '$2y$10$yPewcZLR7SBq4ZYSwcU2.egIYQ6rK2HUE7eb6r1d9mpOE8FWsOMdK', 'winkelpersoneel', 1, 0),
(17, 'winkelpersoneel3', '$2y$10$zPrTbcR6z2jUOJqalzqAq.bD1ipmvdoGKDJZoeKabwLScc.0aOaS6', 'directie', 1, 0),
(18, 'piet', '$2y$10$zShyfzj6OzAfht1V4vOVz.yNg.LdXQRjsaNVQn0bCwUWa0oLSpNiS', 'directie', 1, 1),
(20, 'jaap', '$2y$10$tPLtD.T/KPYnaUC0UKvKXOPM/0pIHCxIrFXoeHZuWfTkpaSQQhpAS', 'directie', 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `prijs_ex_btw` decimal(10,2) DEFAULT NULL,
  `directVerkoopbaar` varchar(10) NOT NULL DEFAULT 'nee',
  `isKapot` varchar(10) NOT NULL DEFAULT 'nee',
  `sold_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `artikel`
--

INSERT INTO `artikel` (`id`, `naam`, `categorie_id`, `prijs_ex_btw`, `directVerkoopbaar`, `isKapot`, `sold_amount`) VALUES
(1, 'Ikea kast', 6, 50.00, 'ja', 'ja', 0),
(2, 'Spiegel', 6, 11.00, 'nee', 'nee', 0),
(3, 'T-shirt', 2, 25.00, 'nee', 'nee', 5),
(4, 'Tuinmeubel Set', 3, 100.00, 'nee', 'nee', 0),
(5, 'Televisie', 1, 90.00, 'nee', 'nee', 0),
(6, 'Jeans', 2, 40.00, 'nee', 'nee', 0),
(7, 'Grasmaaier', 3, 165.00, 'nee', 'nee', 0),
(8, 'Bank', 4, 75.00, 'nee', 'nee', 0),
(9, 'Ledikant', 5, 40.00, 'nee', 'nee', 0),
(34, 'Smart watch', 1, 45.00, 'nee', 'nee', 0),
(47, 'ste', 15, 34.00, 'ja', 'ja', 0),
(48, 'ste', 15, 34.00, 'ja', 'ja', 0),
(49, 'ste', 15, 34.00, 'ja', 'ja', 0),
(50, 'ste', 15, 34.00, 'ja', 'ja', 5),
(52, 'test tes', 14, 10.00, 'ja', 'ja', 10);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `categorie` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `categorie`
--

INSERT INTO `categorie` (`id`, `categorie`) VALUES
(1, 'Elektronica'),
(2, 'Kleding'),
(3, 'Huis & Tuin'),
(4, 'meubels'),
(5, 'bedden'),
(6, 'kledingkasten'),
(7, 'spiegels'),
(8, 'kapstokken'),
(9, 'garderobekasten'),
(10, 'schoenenkasten'),
(11, 'witgoed'),
(12, 'bruingoed'),
(13, 'glazen'),
(14, 'boeken'),
(15, 'niet toegestaande artikelen'),
(18, 'test'),
(19, 'test'),
(20, 'test'),
(21, 'kaas man');

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
  `email` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`id`, `naam`, `adres`, `plaats`, `telefoon`, `email`, `active`) VALUES
(1, 'Jan Jansen', 'Hoofdstraat 20', 'Amsterdam', '0612345678', 'jan@example.com', 1),
(2, 'Piet Pieters', 'Kerkstraat 2', 'Rotterdam', '0687654321', 'piet@example.com', 1),
(3, 'Jan Janssen', 'Hoofdstraat 1', 'Amsterdam', '0612345678', 'jan.janssen@example.com', 1),
(4, 'Piet Pietersen', 'Zijstraat 2', 'Rotterdam', '0623456789', 'piet.pietersen@example.com', 1),
(5, 'Kees de Vries', 'Laan 3', 'Den Haag', '0634567890', 'kees.devries@example.com', 1),
(6, 'Sophie Bakker', 'Ringweg 4', 'Utrecht', '0645678901', 'sophie.bakker@example.com', 1),
(7, 'Tom Jansen', 'Oudeweg 5', 'Groningen', '0656789012', 'tom.jansen@example.com', 1),
(8, 'Linda de Boer', 'Nieuwstraat 6', 'Eindhoven', '0667890123', 'linda.deboer@example.com', 1),
(9, 'Mark van Dijk', 'Dorpsstraat 7', 'Leiden', '0678901234', 'mark.vandijk@example.com', 1),
(10, 'Eva Willems', 'Achterweg 8', 'Amersfoort', '0689012345', 'eva.willems@example.com', 1),
(11, 'Marten de Jong', 'Noorderstraat 9', 'Maastricht', '0690123456', 'marten.dejong@example.com', 1),
(12, 'Lena de Groot', 'Westerdijk 10', 'Rotterdam', '0611234567', 'lena.degroot@example.com', 1),
(13, 'David Vos', 'Molenweg 11', 'Breda', '0622345678', 'david.vos@example.com', 1),
(14, 'Fleur Smits', 'Veldstraat 12', 'Almere', '0633456789', 'fleur.smits@example.com', 1),
(15, 'Joris van Leeuwen', 'Kerkstraat 13', 'Haarlem', '0644567890', 'joris.vanleeuwen@example.com', 1),
(16, 'Inge van der Meer', 'Hoofdweg 14', 'Leeuwarden', '0655678901', 'inge.vandermeer@example.com', 1),
(17, 'Rik Mulder', 'Stationsstraat 15', 'Arnhem', '0666789012', 'rik.mulder@example.com', 1),
(18, 'Olga de Wit', 'Eikenlaan 16', 'Zwolle', '0677890123', 'olga.dewit@example.com', 1),
(19, 'Mieke van der Veen', 'Dorpsplein 17', 'Gouda', '0688901234', 'mieke.vanderveen@example.com', 1),
(20, 'Bart Kuipers', 'Bergstraat 18', 'Beverwijk', '0699012345', 'bart.kuipers@example.com', 1),
(21, 'Lotte Jans', 'Zonstraat 19', 'Hengelo', '0612345670', 'lotte.jans@example.com', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `planning`
--

CREATE TABLE `planning` (
  `id` int(11) NOT NULL,
  `artikel_id` int(11) DEFAULT NULL,
  `klant_id` int(11) DEFAULT NULL,
  `kenteken` varchar(255) NOT NULL,
  `ophalen_of_bezorgen` enum('ophalen','bezorgen') NOT NULL,
  `afspraak_op` datetime NOT NULL,
  `is_bezorgd` tinytext NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `planning`
--

INSERT INTO `planning` (`id`, `artikel_id`, `klant_id`, `kenteken`, `ophalen_of_bezorgen`, `afspraak_op`, `is_bezorgd`) VALUES
(3, 3, 13, 'AB-123-CD', 'bezorgen', '2025-01-17 12:01:00', '0'),
(4, 3, 8, 'AB-123-CDS', 'ophalen', '2025-01-16 14:50:00', '0');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'In voorraad'),
(2, 'Uit voorraad');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `voorraad`
--

CREATE TABLE `voorraad` (
  `id` int(11) NOT NULL,
  `artikel_id` int(11) DEFAULT NULL,
  `locatie` varchar(255) NOT NULL,
  `aantal` int(11) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `ingeboekt_op` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `voorraad`
--

INSERT INTO `voorraad` (`id`, `artikel_id`, `locatie`, `aantal`, `status_id`, `ingeboekt_op`) VALUES
(1, 1, 'Locatie A', 100, 1, '2025-01-29 10:01:27'),
(2, 2, 'Magazijn B', 5, 1, '2025-01-29 10:01:27'),
(3, 3, 'Magazijn C', 20, 1, '2025-01-29 10:01:27'),
(5, 5, 'Magazijn F', 15, 1, '2025-01-29 10:01:27'),
(8, 4, 'Magazijn D', 10, 1, '2025-01-29 10:01:27'),
(9, 6, 'Magazijn E', 5, 1, '2025-01-29 10:01:27'),
(10, 7, 'Magazijn G', 8, 1, '2025-01-29 10:01:27'),
(11, 8, 'Magazijn H', 7, 1, '2025-01-29 10:01:27'),
(12, 9, 'Magazijn I', 18, 1, '2025-01-29 10:01:27'),
(13, 34, 'Locatie A', 2, 1, '2025-01-29 17:50:46'),
(26, 47, 'Locatie I', 34, 1, '0000-00-00 00:00:00'),
(27, 48, 'Locatie I', 34, 1, '0000-00-00 00:00:00'),
(28, 49, 'Locatie I', 34, 1, '0000-00-00 00:00:00'),
(29, 50, 'Locatie I', 1, 1, '0000-00-00 00:00:00'),
(31, 52, 'Locatie J', 1, 1, '0000-00-00 00:00:00');

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
  ADD KEY `artikel_id` (`artikel_id`),
  ADD KEY `klant_id` (`klant_id`);

--
-- Indexen voor tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `voorraad`
--
ALTER TABLE `voorraad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artikel_id` (`artikel_id`),
  ADD KEY `status_id` (`status_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `accounts`
--
ALTER TABLE `accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT voor een tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT voor een tabel `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT voor een tabel `planning`
--
ALTER TABLE `planning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `voorraad`
--
ALTER TABLE `voorraad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
-- Beperkingen voor tabel `voorraad`
--
ALTER TABLE `voorraad`
  ADD CONSTRAINT `voorraad_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`),
  ADD CONSTRAINT `voorraad_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
