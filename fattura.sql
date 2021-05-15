-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 15, 2021 alle 16:44
-- Versione del server: 10.4.17-MariaDB
-- Versione PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fattura`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `clienti`
--

CREATE TABLE `clienti` (
  `id_cliente` int(11) NOT NULL,
  `id_ditta` int(11) NOT NULL,
  `ncliente` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `clienti`
--

INSERT INTO `clienti` (`id_cliente`, `id_ditta`, `ncliente`, `address`) VALUES
(1, 2, 'Luca Giulio', 'VIA ROMOLO LUCCHETTI'),
(2, 2, 'Mario Concuretti', 'VIA MILANO 23'),
(3, 1, 'Luca Giancarlo', 'VIA QUALUNQUE POSTO 23'),
(4, 1, 'Mario Rossi', 'VIA ALTRA 23');

-- --------------------------------------------------------

--
-- Struttura della tabella `ditte`
--

CREATE TABLE `ditte` (
  `id_ditta` int(11) NOT NULL,
  `nditta` text NOT NULL,
  `address` text NOT NULL,
  `cf` text NOT NULL,
  `piva` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `ditte`
--

INSERT INTO `ditte` (`id_ditta`, `nditta`, `address`, `cf`, `piva`) VALUES
(1, 'Prima Ditta', 'Via della prima ditta', 'JSTXBN65H01E852D', '16610490530'),
(2, 'Seconda Ditta', 'Via della seconda ditta', 'VJIMYA64B58C807Z', '55349820211');

-- --------------------------------------------------------

--
-- Struttura della tabella `fatture`
--

CREATE TABLE `fatture` (
  `id_fattura` int(11) NOT NULL,
  `id_ditta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `importo` double(65,2) NOT NULL,
  `data` date NOT NULL,
  `dataincasso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `fatture`
--

INSERT INTO `fatture` (`id_fattura`, `id_ditta`, `id_cliente`, `importo`, `data`, `dataincasso`) VALUES
(1, 2, 1, 255.00, '2018-02-11', NULL),
(2, 2, 2, 6451.00, '2019-02-11', '2021-02-09'),
(3, 2, 2, 574.00, '2021-01-01', '2021-02-16'),
(4, 1, 3, 125.00, '2021-05-04', '2021-05-19'),
(5, 1, 3, 545.00, '2021-02-11', NULL),
(6, 1, 3, 12345.00, '2020-12-16', NULL),
(7, 2, 1, 124445.00, '2021-05-15', NULL),
(8, 2, 1, 124445.00, '2021-05-15', NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_ditta` (`id_ditta`);

--
-- Indici per le tabelle `ditte`
--
ALTER TABLE `ditte`
  ADD PRIMARY KEY (`id_ditta`);

--
-- Indici per le tabelle `fatture`
--
ALTER TABLE `fatture`
  ADD UNIQUE KEY `id_fattura` (`id_fattura`),
  ADD KEY `id_ditta` (`id_ditta`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `fatture`
--
ALTER TABLE `fatture`
  MODIFY `id_fattura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `clienti`
--
ALTER TABLE `clienti`
  ADD CONSTRAINT `clienti_ibfk_1` FOREIGN KEY (`id_ditta`) REFERENCES `ditte` (`id_ditta`);

--
-- Limiti per la tabella `fatture`
--
ALTER TABLE `fatture`
  ADD CONSTRAINT `fatture_ibfk_1` FOREIGN KEY (`id_ditta`) REFERENCES `ditte` (`id_ditta`),
  ADD CONSTRAINT `fatture_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clienti` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
