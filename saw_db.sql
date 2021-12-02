-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 02, 2021 alle 17:32
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saw_db`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `acquisto`
--

CREATE TABLE `acquisto` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `data` date NOT NULL,
  `totale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `acquisto_libro`
--

CREATE TABLE `acquisto_libro` (
  `id_acquisto` int(11) NOT NULL,
  `ISBN` int(11) NOT NULL,
  `quantita` int(11) NOT NULL,
  `costo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `amministratore`
--

CREATE TABLE `amministratore` (
  `id` int(11) NOT NULL,
  `ruolo` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `amministratore`
--
DELIMITER $$
CREATE TRIGGER `Admin_user_check` BEFORE INSERT ON `amministratore` FOR EACH ROW IF EXISTS (SELECT email FROM utente WHERE utente.email = email)
THEN 
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot have the same email as an user';
END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Admin_user_checkU` BEFORE UPDATE ON `amministratore` FOR EACH ROW IF EXISTS (SELECT email FROM utente WHERE utente.email = new.email)
THEN 
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot have the same email as an user';
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `ban`
--

CREATE TABLE `ban` (
  `id_utente` int(11) NOT NULL,
  `id_amm` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `ban`
--
DELIMITER $$
CREATE TRIGGER `Ban_user` AFTER INSERT ON `ban` FOR EACH ROW UPDATE utente
SET ban=TRUE
WHERE utente.id=id_utente
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `carrello`
--

CREATE TABLE `carrello` (
  `id_utente` int(11) NOT NULL,
  `ISBN` int(13) NOT NULL,
  `quantita` int(11) NOT NULL,
  `costo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `genere`
--

CREATE TABLE `genere` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `genere_libro`
--

CREATE TABLE `genere_libro` (
  `id_genere` int(11) NOT NULL,
  `ISBN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `libro`
--

CREATE TABLE `libro` (
  `ISBN` int(13) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `autori` varchar(100) NOT NULL,
  `costo` int(11) NOT NULL,
  `data_pub` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `metodo_p1` varchar(20) DEFAULT NULL,
  `ban` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `utente`
--
DELIMITER $$
CREATE TRIGGER `User_admin_check` BEFORE INSERT ON `utente` FOR EACH ROW IF EXISTS (SELECT email FROM amministratore WHERE amministratore.email = email)
THEN 
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot have the same email as an admin';
END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `User_admin_checkU` BEFORE UPDATE ON `utente` FOR EACH ROW IF EXISTS (SELECT email FROM amministratore WHERE amministratore.email = new.email)
THEN 
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot have the same email as an admin';
END IF
$$
DELIMITER ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `acquisto`
--
ALTER TABLE `acquisto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indici per le tabelle `acquisto_libro`
--
ALTER TABLE `acquisto_libro`
  ADD PRIMARY KEY (`id_acquisto`,`ISBN`),
  ADD KEY `ISBN` (`ISBN`);

--
-- Indici per le tabelle `amministratore`
--
ALTER TABLE `amministratore`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indici per le tabelle `ban`
--
ALTER TABLE `ban`
  ADD PRIMARY KEY (`id_utente`);

--
-- Indici per le tabelle `carrello`
--
ALTER TABLE `carrello`
  ADD PRIMARY KEY (`id_utente`,`ISBN`),
  ADD KEY `ISBN` (`ISBN`);

--
-- Indici per le tabelle `genere`
--
ALTER TABLE `genere`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `genere_libro`
--
ALTER TABLE `genere_libro`
  ADD KEY `id_genere` (`id_genere`),
  ADD KEY `ISBN` (`ISBN`);

--
-- Indici per le tabelle `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`ISBN`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `acquisto`
--
ALTER TABLE `acquisto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `amministratore`
--
ALTER TABLE `amministratore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `genere`
--
ALTER TABLE `genere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `acquisto`
--
ALTER TABLE `acquisto`
  ADD CONSTRAINT `acquisto_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`);

--
-- Limiti per la tabella `acquisto_libro`
--
ALTER TABLE `acquisto_libro`
  ADD CONSTRAINT `acquisto_libro_ibfk_1` FOREIGN KEY (`id_acquisto`) REFERENCES `acquisto` (`id`),
  ADD CONSTRAINT `acquisto_libro_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `libro` (`ISBN`);

--
-- Limiti per la tabella `ban`
--
ALTER TABLE `ban`
  ADD CONSTRAINT `ban_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`);

--
-- Limiti per la tabella `carrello`
--
ALTER TABLE `carrello`
  ADD CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`),
  ADD CONSTRAINT `carrello_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `libro` (`ISBN`);

--
-- Limiti per la tabella `genere_libro`
--
ALTER TABLE `genere_libro`
  ADD CONSTRAINT `genere_libro_ibfk_1` FOREIGN KEY (`id_genere`) REFERENCES `genere` (`id`),
  ADD CONSTRAINT `genere_libro_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `libro` (`ISBN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
