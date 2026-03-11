-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mar 11, 2026 alle 09:04
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airtpsit`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `aereo`
--

CREATE TABLE `aereo` (
  `id` int(11) NOT NULL,
  `codice` varchar(20) NOT NULL,
  `posti_economy` int(11) NOT NULL,
  `posti_business` int(11) NOT NULL,
  `posti_premium` int(11) NOT NULL,
  `posti_first` int(11) NOT NULL,
  `numero_motori` int(11) NOT NULL,
  `compagnia_codice` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `aereo`
--

INSERT INTO `aereo` (`id`, `codice`, `posti_economy`, `posti_business`, `posti_premium`, `posti_first`, `numero_motori`, `compagnia_codice`) VALUES
(1, 'ALITALIA01', 100, 150, 333, 122, 3, 'ALITALIA'),
(2, 'VUELING01', 100, 150, 333, 122, 3, 'VUELING');

-- --------------------------------------------------------

--
-- Struttura della tabella `aeroporto`
--

CREATE TABLE `aeroporto` (
  `codice` varchar(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `numero_hangar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `aeroporto`
--

INSERT INTO `aeroporto` (`codice`, `nome`, `indirizzo`, `numero_hangar`) VALUES
('FCO', 'ROMA FIUMICINO', 'Via Fiumicino', 3),
('IST', 'Istanbul', 'Via Istabul', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `numero_documento` varchar(50) NOT NULL,
  `genere` varchar(10) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `data_nascita` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `numero_carta` varchar(30) DEFAULT NULL,
  `data_scadenza` date DEFAULT NULL,
  `cvc` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `compagnia_aerea`
--

CREATE TABLE `compagnia_aerea` (
  `codice` varchar(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `immagine` varchar(255) DEFAULT NULL,
  `capitale_sociale` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `compagnia_aerea`
--

INSERT INTO `compagnia_aerea` (`codice`, `nome`, `immagine`, `capitale_sociale`) VALUES
('ALITALIA', 'ALITALIA', NULL, 33332233.00),
('VUELING', 'VUELING', NULL, 332423.00);

-- --------------------------------------------------------

--
-- Struttura della tabella `componente_prenotazione`
--

CREATE TABLE `componente_prenotazione` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `data_nascita` date NOT NULL,
  `numero_documento` varchar(50) NOT NULL,
  `prenotazione_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `pagamento`
--

CREATE TABLE `pagamento` (
  `id` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `esito` varchar(30) NOT NULL,
  `prenotazione_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE `prenotazione` (
  `id` int(11) NOT NULL,
  `codice` varchar(20) NOT NULL,
  `data` datetime NOT NULL,
  `numero_posti` int(11) NOT NULL,
  `totale` decimal(10,2) NOT NULL,
  `stato` varchar(30) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `volo_codice` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `ruolo`
--

CREATE TABLE `ruolo` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `ruolo`
--

INSERT INTO `ruolo` (`id`, `nome`) VALUES
(1, 'SUPERADMIN'),
(2, 'ADMIN'),
(3, 'USER'),
(4, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `scalo`
--

CREATE TABLE `scalo` (
  `id` int(11) NOT NULL,
  `data_arrivo` datetime NOT NULL,
  `data_partenza` datetime NOT NULL,
  `aeroporto_partenza` varchar(10) NOT NULL,
  `aeroporto_destinazione` varchar(10) NOT NULL,
  `volo_codice` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `codice_fiscale` varchar(16) NOT NULL,
  `data_nascita` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `ruolo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `nome`, `cognome`, `codice_fiscale`, `data_nascita`, `email`, `telefono`, `ruolo_id`) VALUES
(1, 'Mario', 'Brega', 'CRBGPP83M07A783F', '2006-03-17', 'mario@mario.it', '0824832742', 1),
(2, 'Mario', 'Lucci', 'CRCGPP83M07A783F', '2006-03-17', 'mario@lucci.it', '0824832742', 2),
(4, 'Luca', 'Benno', 'CBBGPP83M07A783F', '2001-03-17', 'luca@benno.it', '0824832742', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `volo`
--

CREATE TABLE `volo` (
  `codice` varchar(20) NOT NULL,
  `data_partenza` date NOT NULL,
  `data_arrivo` date NOT NULL,
  `aereo_id` int(11) NOT NULL,
  `aeroporto_partenza` varchar(10) NOT NULL,
  `aeroporto_arrivo` varchar(10) NOT NULL,
  `ora_partenza` time NOT NULL,
  `ora_arrivo` time NOT NULL,
  `posti_business` int(11) NOT NULL,
  `posti_economy` int(11) NOT NULL,
  `posti_first` int(11) NOT NULL,
  `posti_premium` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `volo`
--

INSERT INTO `volo` (`codice`, `data_partenza`, `data_arrivo`, `aereo_id`, `aeroporto_partenza`, `aeroporto_arrivo`, `ora_partenza`, `ora_arrivo`, `posti_business`, `posti_economy`, `posti_first`, `posti_premium`) VALUES
('AK101', '2026-03-04', '2026-03-04', 1, 'FCO', 'IST', '10:00:00', '12:00:00', 50, 50, 50, 50),
('VK101', '2026-03-04', '2026-03-04', 2, 'FCO', 'IST', '10:00:00', '18:00:00', 50, 50, 50, 50);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `aereo`
--
ALTER TABLE `aereo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codice` (`codice`),
  ADD KEY `compagnia_codice` (`compagnia_codice`);

--
-- Indici per le tabelle `aeroporto`
--
ALTER TABLE `aeroporto`
  ADD PRIMARY KEY (`codice`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `numero_documento` (`numero_documento`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `username_2` (`username`,`password`),
  ADD UNIQUE KEY `numero_carta` (`numero_carta`);

--
-- Indici per le tabelle `compagnia_aerea`
--
ALTER TABLE `compagnia_aerea`
  ADD PRIMARY KEY (`codice`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `componente_prenotazione`
--
ALTER TABLE `componente_prenotazione`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`,`cognome`),
  ADD UNIQUE KEY `numero_documento` (`numero_documento`),
  ADD KEY `prenotazione_id` (`prenotazione_id`);

--
-- Indici per le tabelle `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prenotazione_id` (`prenotazione_id`);

--
-- Indici per le tabelle `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codice` (`codice`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `volo_codice` (`volo_codice`);

--
-- Indici per le tabelle `ruolo`
--
ALTER TABLE `ruolo`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `scalo`
--
ALTER TABLE `scalo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `volo_codice` (`volo_codice`),
  ADD KEY `aeroporto_partenza` (`aeroporto_partenza`),
  ADD KEY `aeroporto_destinazione` (`aeroporto_destinazione`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codice_fiscale` (`codice_fiscale`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `ruolo_id` (`ruolo_id`);

--
-- Indici per le tabelle `volo`
--
ALTER TABLE `volo`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `aereo_id` (`aereo_id`),
  ADD KEY `aeroporto_partenza` (`aeroporto_partenza`),
  ADD KEY `aeroporto_arrivo` (`aeroporto_arrivo`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `aereo`
--
ALTER TABLE `aereo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `componente_prenotazione`
--
ALTER TABLE `componente_prenotazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ruolo`
--
ALTER TABLE `ruolo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `scalo`
--
ALTER TABLE `scalo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `aereo`
--
ALTER TABLE `aereo`
  ADD CONSTRAINT `aereo_ibfk_1` FOREIGN KEY (`compagnia_codice`) REFERENCES `compagnia_aerea` (`codice`) ON DELETE CASCADE;

--
-- Limiti per la tabella `componente_prenotazione`
--
ALTER TABLE `componente_prenotazione`
  ADD CONSTRAINT `componente_prenotazione_ibfk_1` FOREIGN KEY (`prenotazione_id`) REFERENCES `prenotazione` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`prenotazione_id`) REFERENCES `prenotazione` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD CONSTRAINT `prenotazione_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prenotazione_ibfk_2` FOREIGN KEY (`volo_codice`) REFERENCES `volo` (`codice`) ON DELETE CASCADE;

--
-- Limiti per la tabella `scalo`
--
ALTER TABLE `scalo`
  ADD CONSTRAINT `scalo_ibfk_1` FOREIGN KEY (`volo_codice`) REFERENCES `volo` (`codice`) ON DELETE CASCADE,
  ADD CONSTRAINT `scalo_ibfk_2` FOREIGN KEY (`aeroporto_partenza`) REFERENCES `aeroporto` (`codice`),
  ADD CONSTRAINT `scalo_ibfk_3` FOREIGN KEY (`aeroporto_destinazione`) REFERENCES `aeroporto` (`codice`);

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`ruolo_id`) REFERENCES `ruolo` (`id`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `volo`
--
ALTER TABLE `volo`
  ADD CONSTRAINT `volo_ibfk_1` FOREIGN KEY (`aereo_id`) REFERENCES `aereo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volo_ibfk_2` FOREIGN KEY (`aeroporto_partenza`) REFERENCES `aeroporto` (`codice`),
  ADD CONSTRAINT `volo_ibfk_3` FOREIGN KEY (`aeroporto_arrivo`) REFERENCES `aeroporto` (`codice`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
