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
    FOREIGN KEY (id_sala) REFERENCES Sala(id_sala) ON DELETE CASCADE
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
    id_utente INT,
    data_prenotazione DATE,
    num_persone INT,
    orario TIME,
    PRIMARY KEY (id_utente, data_prenotazione),
    FOREIGN KEY (id_utente) REFERENCES Utente(id_utente) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Recensione (
    id_recensione SERIAL PRIMARY KEY,
    id_utente INT,
    voto SMALLINT,
    data_recensione DATE,
    descrizione TEXT,
    tipo BOOLEAN,
    FOREIGN KEY (id_utente) REFERENCES Utente(id_utente) ON DELETE CASCADE
);




-- MOCK DATA -- 

INSERT INTO Mostra (nome, descrizione, data_inizio, data_fine, img_path) VALUES
  ('Yu-Gi-Oh Exhibit', 'Explore the iconic dueling game of Yu-Gi-Oh', '2023-06-01', '2024-05-31', 'yugioh_exhibit.jpg'),
  ('Pokémon Card Showcase', 'Discover the world of Pokémon trading cards', '2023-09-15', '2024-09-14', 'pokemon_exhibit.jpg'),
  ('Dragon Ball Z Card Battle', 'Experience the intense card battles of the Dragon Ball universe', '2024-02-01', '2025-01-31', 'dragonball_exhibit.jpg'),
  ('Gormiti Card Collection', 'Explore the collectible cards of the Gormiti creatures', '2023-11-20', '2024-11-19', 'gormiti_exhibit.jpg');

INSERT INTO Sala (nome, descrizione, img_path) VALUES
  ('Yu-Gi-Oh Arena', 'Duel against virtual opponents', 'yugioh_arena.jpg'),
  ('Pokémon Card Gallery', 'View rare and iconic Pokémon cards', 'pokemon_gallery.jpg'),
  ('Dragon Ball Z Battle Grounds', 'Engage in virtual card battles from the series', 'dragonball_grounds.jpg'),
  ('Gormiti Habitat', 'Explore the natural environments of Gormiti creatures', 'gormiti_habitat.jpg');

INSERT INTO Opera (id_sala, nome, autore, descrizione, anno, img_path) VALUES
  (1, 'Blue-Eyes White Dragon', 'Kazuki Takahashi', 'The iconic signature monster of Seto Kaiba', 1996, 'blue_eyes.jpg'),
  (2, 'Pikachu', 'Atsuko Nishida', 'The beloved Electric Mouse Pokémon', 1996, 'pikachu.jpg'),
  (3, 'Super Saiyan Goku', 'Akira Toriyama', 'Goku''s legendary transformed state', 1989, 'super_saiyan.jpg'),
  (4, 'Magmion', 'Serghei Rotaru', 'The Lava Gormiti creature', 2008, 'magmion.jpg');

INSERT INTO Utente (ruolo, username, nome, cognome, password_hash, email, salt) VALUES
(1, 'johnsmith', 'John', 'Smith', '$2y$10$abcdefghijklmnopqrstuv', 'john.smith@example.com', 'abc123def456'),
(2, 'janedoe', 'Jane', 'Doe', '$2y$10$vwxyzabcdefghijklmnop', 'jane.doe@example.com', 'ghi789jkl012'),
(2, 'bobloblaw', 'Bob', 'Loblaw', '$2y$10$mnopqrstuvwxyzabcdefg', 'bob.loblaw@example.com', 'mno345pqr678');

INSERT INTO Prenotazione (id_utente, data_prenotazione, num_persone, orario) VALUES
(3, '2023-06-15', 2, '14:30:00'),
(3, '2023-07-20', 3, '11:00:00'),
(2, '2023-08-05', 1, '16:45:00'),
(2, '2023-09-12', 4, '10:00:00'),
(3, '2023-10-01', 2, '13:20:00');

INSERT INTO Recensione (id_utente, voto, data_recensione, descrizione, tipo) VALUES
(3, 5, '2023-06-18', 'Fantastic exhibit, really enjoyed the Yu-Gi-Oh experience!', 1),
(2, 4, '2023-08-10', 'Great collection of Pokémon cards, would love to see more interactive elements.', 1);