-- Concedi tutti i privilegi su tutti i database
GRANT ALL PRIVILEGES ON *.* TO 'user'@'%' WITH GRANT OPTION;

-- Ricarica i permessi per applicare le modifiche
FLUSH PRIVILEGES;

-- Creazione del database
CREATE DATABASE IF NOT EXISTS museo;
USE museo;

-- Creazione della tabella "mostre"
CREATE TABLE IF NOT EXISTS mostre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descrizione TEXT,
    data_inizio DATE,
    data_fine DATE
);

-- Creazione della tabella "opere"
CREATE TABLE IF NOT EXISTS opere (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titolo VARCHAR(255) NOT NULL,
    artista VARCHAR(255),
    descrizione TEXT,
    anno INT
);

-- Creazione della tabella di relazione "mostra_opera" per associazione molte-a-molti
CREATE TABLE IF NOT EXISTS mostra_opera (
    id_mostra INT,
    id_opera INT,
    PRIMARY KEY (id_mostra, id_opera),
    FOREIGN KEY (id_mostra) REFERENCES mostre(id) ON DELETE CASCADE,
    FOREIGN KEY (id_opera) REFERENCES opere(id) ON DELETE CASCADE
);

-- Inserimento di dati di esempio nelle tabelle

-- Dati delle mostre
INSERT INTO mostre (nome, descrizione, data_inizio, data_fine) VALUES
('Mostra Impressionismo', 'Una raccolta di opere impressioniste da tutto il mondo.', '2024-03-01', '2024-06-30'),
('Mostra Rinascimento', 'Esplora il periodo del Rinascimento con opere di artisti celebri.', '2024-07-01', '2024-09-30');

-- Dati delle opere
INSERT INTO opere (titolo, artista, descrizione, anno) VALUES
('Impression Soleil Levant', 'Claude Monet', 'La celebre opera che ha dato il nome al movimento impressionista.', 1872),
('La Gioconda', 'Leonardo da Vinci', 'Il ritratto più famoso al mondo, realizzato da Leonardo da Vinci.', 1503),
('Ninfee', 'Claude Monet', 'Una serie di dipinti che rappresentano le ninfee nel giardino di Monet.', 1906);

-- Associazione opere alle mostre (mostra_opera)
INSERT INTO mostra_opera (id_mostra, id_opera) VALUES
(1, 1), -- Impression Soleil Levant nella mostra "Mostra Impressionismo"
(1, 3), -- Ninfee nella mostra "Mostra Impressionismo"
(2, 2); -- La Gioconda nella mostra "Mostra Rinascimento"
