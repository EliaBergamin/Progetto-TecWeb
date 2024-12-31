GRANT ALL PRIVILEGES ON *.* TO 'user'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;

CREATE DATABASE IF NOT EXISTS Museo;
USE Museo;

CREATE TABLE IF NOT EXISTS Mostra (
    id_mostra INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descrizione TEXT,
    data_inizio DATE,
    data_fine DATE,
    img_path VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS Sala (
    id_sala INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50),
    descrizione TEXT,
    img_path VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS Opera (
    id_opera INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_sala INT UNSIGNED,
    nome VARCHAR(255) NOT NULL,
    autore VARCHAR(255),
    descrizione TEXT,
    anno YEAR,
    img_path VARCHAR(50),
    FOREIGN KEY (id_sala) REFERENCES Sala(id_sala) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Utente (
    id_utente INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ruolo TINYINT,
    username VARCHAR(20) UNIQUE,
    nome VARCHAR(30),
    cognome VARCHAR(30),
    password_hash VARCHAR(255),
    email VARCHAR(50) UNIQUE
);

CREATE TABLE IF NOT EXISTS Prenotazione (
    id_utente INT UNSIGNED,
    data_prenotazione DATE,
    num_persone SMALLINT UNSIGNED,
    orario TIME,
    PRIMARY KEY (id_utente, data_prenotazione),
    FOREIGN KEY (id_utente) REFERENCES Utente(id_utente) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Recensione (
    id_recensione INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_utente INT UNSIGNED,
    voto TINYINT UNSIGNED,
    data_recensione DATE,
    descrizione TEXT,
    tipo BOOLEAN,
    FOREIGN KEY (id_utente) REFERENCES Utente(id_utente) ON DELETE CASCADE
);




-- MOCK DATA -- 

INSERT INTO Mostra (nome, descrizione, data_inizio, data_fine, img_path) VALUES
  ("Dragon Ball Z Card Battle", "Esplora l'emozionante mondo delle carte Dragon Ball Z! Dai Saiyan alle epiche battaglie, questa mostra celebra l'arte e la strategia del gioco con una collezione ricca e dinamica.", "2024-12-01", "2025-02-27", "dragonball_exhibit.jpg"),
  ("Pokémon Card Showcase", "La più grande collezione di carte Pokémon mai esposta. Dagli inizi con il set base fino alle edizioni moderne, scopri le carte più rare e iconiche, e immergiti in un mondo di ricordi e sorprese.", "2024-12-01", "2024-12-31", "pokemon_exhibit.jpg"),
  ("Gormiti Card Collection", "Rivivi l'epoca d'oro dei Gormiti attraverso le loro carte! Una collezione completa e unica, che racconta storie di battaglie epiche e terre magiche con dettagli affascinanti e colorati.", "2025-11-20", "2025-12-31", "gormiti_exhibit.jpg"),
  ("Yu-Gi-Oh Exhibit", "Un viaggio nel mondo di Yu-Gi-Oh che non puoi perdere! L'esposizione include carte rare, storia del gioco e dettagli affascinanti sulle illustrazioni. Perfetta per fan di lunga data e neofiti curiosi.", "2023-06-01", "2023-06-10", "yugioh_exhibit.jpg");


INSERT INTO Sala (nome, descrizione, img_path) VALUES
  ("Dragon Ball Battle Grounds", "Uno spazio dedicato agli appassionati di Dragon Ball, dove le carte raccontano storie di battaglie memorabili. Ammira la potenza dei tuoi eroi preferiti in un'esperienza coinvolgente.", "dragonball_grounds.jpg"),
  ("Pokémon Card Gallery", "Una galleria interattiva che celebra il fenomeno Pokémon. Esplora le carte più iconiche e scopri curiosità e aneddoti che hanno definito una generazione di collezionisti.", "pokemon_gallery.jpg"),
  ("Gormiti Habitat", "Un'area esclusiva per immergersi nel mondo dei Gormiti. Scopri le carte che hanno fatto la storia, con esposizioni che rievocano le magiche terre dei Signori della Natura.", "gormiti_habitat.jpg"),
  ("Yu-Gi-Oh Arena", "Entra in un'arena dedicata interamente all'universo di Yu-Gi-Oh! Scopri le carte più famose, partecipa a dimostrazioni interattive e immergiti in un'atmosfera da vero duellante.", "yugioh_arena.jpg");

INSERT INTO Opera (id_sala, nome, autore, descrizione, anno, img_path) VALUES
  (4, "Drago Bianco Occhi Blu", "Kazuki Takahashi", "Il Drago Bianco Occhi Blu, creato da Kazuki Takahashi, è il simbolo iconico di Seto Kaiba nel mondo di Yu-Gi-Oh! Con la sua potenza devastante e il design leggendario, questa carta ha conquistato il cuore di milioni di fan, diventando un'icona della cultura pop dal 1996.", 1996, "blue_eyes.jpg"),
  (2, "Pikachu", "Atsuko Nishida", "Pikachu, ideato da Atsuko Nishida, è l'adorabile Pokémon di tipo Elettro che ha conquistato il mondo fin dal 1996. Con le sue guance rosse e il suo sorriso contagioso, è diventato l'emblema dei Pokémon, amato da grandi e piccoli per il suo carattere vivace e coraggioso.", 1996, "pikachu.jpg"),
  (1, "Goku Super Saiyan", "Akira Toriyama", "Goku Super Saiyan, creato da Akira Toriyama, rappresenta il momento più epico nella saga di Dragon Ball Z. Dal 1989, questa forma ha definito la leggenda di Goku, incarnando determinazione, forza e spirito combattivo che hanno ispirato generazioni di fan.", 1989, "super_saiyan.jpg"),
  (3, "Magmion", "Serghei Rotaru", "Magmion, concepito da Serghei Rotaru nel 2008, è una delle creature più potenti e memorabili dell'universo dei Gormiti. Rappresenta la forza della lava e il dominio del fuoco, con un design che combina potenza brutale e fascino mistico, perfetto per ogni collezionista.", 2008, "magmion.jpg");

INSERT INTO Utente (ruolo, username, nome, cognome, password_hash, email) VALUES
(1, "admin", "John", "Smith", "$2y$10$hR2hqK83R1oK4k2jWfz.NOYwpnV5Laf9ClB9C0xIwKj2sXKHL0WqC", "john.smith@example.com"),
(2, "janedoe", "Jane", "Doe", "$2y$10$vwxyzabcdefghijklmnop", "jane.doe@example.com"),
(2, "user", "User", "Name", "$2y$10$cFX/s3yEaLujSUteGmjlT.MBH.5suXmS667v0o8OVjBxsycCdFPCS", "user.name@example.com"),
(2, "bobloblaw", "Bob", "Loblaw", "$2y$10$mnopqrstuvwxyzabcdefg", "bob.loblaw@example.com");

INSERT INTO Prenotazione (id_utente, data_prenotazione, num_persone, orario) VALUES
(3, "202-06-15", 2, "14:30:00"),
(3, "2023-07-20", 3, "11:00:00"),
(3, "2023-10-01", 2, "13:20:00"),
(2, "2023-08-05", 1, "16:45:00"),
(2, "2025-01-15", 4, "10:30:00"),
(4, "2025-01-15", 84, "10:30:00");


INSERT INTO Recensione (id_utente, voto, data_recensione, descrizione, tipo) VALUES
(3, 5, "2023-06-18", "Una mostra davvero unica per gli appassionati di Yu-Gi-Oh! Le carte iconiche, come il Drago Bianco Occhi Blu e il Mago Nero, sono esposte in vetrine spettacolari. Perfetta combinazione di nostalgia e scoperta!", 1),
(2, 4, "2023-08-10", "Un'esperienza magica per ogni fan di Pokémon! Le carte sono esposte in modo accattivante, con spiegazioni dettagliate sulla loro storia e rarità. Atmosfera è perfetta per immergersi nel mondo dei Pokémon. Spero di tornare presto magari per una nuova mostra!", 0);
