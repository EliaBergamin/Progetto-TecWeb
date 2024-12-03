GRANT ALL PRIVILEGES ON *.* TO 'user'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;

CREATE DATABASE IF NOT EXISTS Museo;
USE Museo;

CREATE TABLE IF NOT EXISTS Mostra (
    id_mostra SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descrizione TEXT,
    data_inizio DATE,
    data_fine DATE,
    img_path VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS Sala (
    id_sala SERIAL PRIMARY KEY,
    nome VARCHAR(50),
    descrizione TEXT,
    img_path VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS Opera (
    id_opera SERIAL PRIMARY KEY,
    id_sala INT,
    nome VARCHAR(255) NOT NULL,
    autore VARCHAR(255),
    descrizione TEXT,
    anno YEAR,
    img_path VARCHAR(50),
    FOREIGN KEY (id_sala) REFERENCES Sala(id_sala) ON DELETE CASCADE,
);

CREATE TABLE IF NOT EXISTS Utente (
    id_utente SERIAL PRIMARY KEY,
    ruolo INT,
    username VARCHAR(20) UNIQUE,
    nome VARCHAR(30),
    cognome VARCHAR(30),
    password_hash CHAR(60),
    email VARCHAR(50) UNIQUE,
    salt CHAR(32)
);

CREATE TABLE IF NOT EXISTS Prenotazione (
    id_prenotazione SERIAL PRIMARY KEY,
    id_utente INT,
    data_prenotazione DATE,
    num_persone INT,
    orario TIME,
    FOREIGN KEY (id_utente) REFERENCES Utente(id_utente)
);

CREATE TABLE IF NOT EXISTS Recensione (
    id_recensione SERIAL PRIMARY KEY,
    id_utente INT,
    voto SMALLINT,
    data_recensione DATE,
    descrizione TEXT,
    tipo BOOLEAN,
    FOREIGN KEY (id_utente) REFERENCES Utente(id_utente)
);




-- MOCK DATA -- 

-- Mostra
INSERT INTO Mostra (nome, descrizione, data_inizio, data_fine, img_path)
VALUES 
  ('Impressionist Masters', 'A collection of renowned Impressionist paintings', '2023-06-01', '2023-09-30', 'impressionist-masters.jpg'),
  ('Modern Sculpture Exhibit', 'Cutting-edge contemporary sculptures', '2023-03-15', '2023-07-01', 'modern-sculpture.jpg'),
  ('Ancient Egyptian Artifacts', 'Rare archaeological finds from the Nile Valley', '2023-11-01', '2024-02-28', 'egyptian-artifacts.jpg');

-- Sala
INSERT INTO Sala (nome, descrizione, img_path)
VALUES
  ('West Gallery', 'Bright and spacious exhibition hall', 'west-gallery.jpg'),
  ('East Wing', 'Intimate setting for small-scale works', 'east-wing.jpg'), 
  ('Atrium', 'Airy central space with skylights', 'atrium.jpg');

-- Opera
INSERT INTO Opera (id_sala, nome, autore, descrizione, anno, img_path)
VALUES
  (1, 'Water Lilies', 'Claude Monet', 'Iconic Impressionist painting of a pond', 1919, 'water-lilies.jpg'),
  (1, 'The Starry Night', 'Vincent van Gogh', 'Renowned Post-Impressionist landscape', 1889, 'starry-night.jpg'),
  (2, 'The Thinker', 'Auguste Rodin', 'Powerful bronze sculpture of a contemplative figure', 1902, 'the-thinker.jpg'),
  (3, 'Neferkare and Sasenet', 'Unknown', 'Rare wooden funerary statue from the Old Kingdom', 2420 BC, 'neferkare-and-sasenet.jpg');

-- Utente
INSERT INTO Utente (ruolo, username, nome, cognome, password_hash, email, salt)
VALUES
  (1, 'curator1', 'John', 'Doe', 'abc123', 'john.doe@museum.org', 'xyz456'),
  (1, 'curator2', 'Jane', 'Smith', 'def456', 'jane.smith@museum.org', 'abc789'),
  (2, 'visitor1', 'Bob', 'Johnson', 'ghi789', 'bob.johnson@example.com', 'def012'),
  (2, 'visitor2', 'Sarah', 'Williams', 'jkl012', 'sarah.williams@example.com', 'ghi345');

-- Prenotazione
INSERT INTO Prenotazione (id_utente, data_prenotazione, num_persone, orario)
VALUES
  (3, '2023-06-15', 2, '13:30:00'),
  (3, '2023-08-01', 4, '10:00:00'),
  (4, '2023-07-20', 1, '15:00:00'),
  (4, '2023-11-05', 3, '17:45:00');

-- Recensione
INSERT INTO Recensione (id_utente, voto, data_recensione, descrizione, tipo)
VALUES
  (3, 5, '2023-06-17', 'Wonderful museum with amazing exhibits!', true),
  (4, 4, '2023-08-03', 'Enjoyed my visit, but the crowds were a bit much.', false),
  (3, 4, '2023-07-22', 'Great selection of artwork and informative displays.', true),
  (4, 3, '2023-11-07', 'Could use more seating and amenities for visitors.', false);