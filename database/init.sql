GRANT ALL PRIVILEGES ON *.* TO 'user'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;

CREATE DATABASE IF NOT EXISTS Museo;
USE Museo;

CREATE TABLE IF NOT EXISTS Mostra (
    id_mostra INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80) NOT NULL,
    descrizione TEXT,
    data_inizio DATE,
    data_fine DATE,
    img_path VARCHAR(50),
    alt VARCHAR(80) DEFAULT ''
);

CREATE TABLE IF NOT EXISTS Sala (
    id_sala INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80),
    descrizione TEXT,
    img_path VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS Opera (
    id_opera INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_sala INT UNSIGNED,
    nome VARCHAR(80) NOT NULL,
    autore VARCHAR(80),
    descrizione TEXT,
    anno YEAR,
    img_path VARCHAR(50),
    FOREIGN KEY (id_sala) REFERENCES Sala(id_sala) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Utente (
    id_utente INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ruolo TINYINT,
    username VARCHAR(20) UNIQUE,
    nome VARCHAR(50),
    cognome VARCHAR(50),
    password_hash VARCHAR(255),
    email VARCHAR(100) UNIQUE
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

INSERT INTO Mostra (nome, descrizione, data_inizio, data_fine, img_path, alt) VALUES
  ("Dragon Ball Z Card Battle", "Esplora l'emozionante mondo delle carte [en]Dragon Ball[/en] Z! Dai Saiyan alle epiche battaglie, questa mostra celebra l'arte e la strategia del gioco con una collezione ricca e dinamica.", "2024-12-01", "2025-02-27", "dragonball_exhibit.jpg", ""),
  ("Pokémon Card Showcase", "La più grande collezione di carte Pokémon mai esposta. Dagli inizi con il set base fino alle edizioni moderne, scopri le carte più rare e iconiche, e immergiti in un mondo di ricordi e sorprese.", "2024-12-01", "2024-12-31", "pokemon_exhibit.jpg", ""),
  ("Gormiti Card Collection", "Rivivi l'epoca d'oro dei Gormiti attraverso le loro carte! Una collezione completa e unica, che racconta storie di battaglie epiche e terre magiche con dettagli affascinanti e colorati.", "2025-11-20", "2025-12-31", "gormiti_exhibit.jpg", ""),
  ("Pokémon: Sole e Luna", "Immergiti in un'avventura spaziale con la nuova mostra a tema Pokémon: Sole e Luna! Scopri le rarissime carte della regione di Alola, tra cui non mancheranno certamente Solgaleo e Lunala GX!", "2025-01-14", "2025-03-24", "sun_moon.webp", ""),
  ("Yu-Gi-Oh Exhibit", "Un viaggio nel mondo di Yu-Gi-Oh che non puoi perdere! L'esposizione include carte rare, storia del gioco e dettagli affascinanti sulle illustrazioni. Perfetta per fan di lunga data e neofiti curiosi.", "2023-06-01", "2023-06-10", "yugioh_exhibit.jpg", "");


INSERT INTO Sala (nome, descrizione, img_path) VALUES
  ("Dragon Ball Battle Grounds", "Uno spazio dedicato agli appassionati di Dragon Ball, dove le carte raccontano storie di battaglie memorabili. Ammira la potenza dei tuoi eroi preferiti in un'esperienza coinvolgente.", "dragonball_grounds.jpg"),
  ("Pokémon Card Gallery", "Una galleria interattiva che celebra il fenomeno Pokémon. Esplora le carte più iconiche e scopri curiosità e aneddoti che hanno definito una generazione di collezionisti.", "pokemon_gallery.jpg"),
  ("Gormiti Habitat", "Un'area esclusiva per immergersi nel mondo dei Gormiti. Scopri le carte che hanno fatto la storia, con esposizioni che rievocano le magiche terre dei Signori della Natura.", "gormiti_habitat.jpg"),
  ("Yu-Gi-Oh Arena", "Entra in un'arena dedicata interamente all'universo di Yu-Gi-Oh! Scopri le carte più famose, partecipa a dimostrazioni interattive e immergiti in un'atmosfera da vero duellante.", "yugioh_arena.jpg");

INSERT INTO Opera (id_sala, nome, autore, descrizione, anno, img_path) VALUES
  (4, "Drago Bianco Occhi Blu", "Kazuki Takahashi", "Il Drago Bianco Occhi Blu, creato da Kazuki Takahashi, è il simbolo iconico di Seto Kaiba nel mondo di Yu-Gi-Oh! Con la sua potenza devastante e il design leggendario, questa carta ha conquistato il cuore di milioni di fan, diventando un'icona della cultura pop dal 1996.", 1996, "yugioh/drago_bianco_blu.jpg"),
  (2, "Pikachu", "[ja]Atsuko Nishida[/ja]", "Pikachu, ideato da Atsuko Nishida, è l'adorabile Pokémon di tipo Elettro che ha conquistato il mondo fin dal 1996. Con le sue guance rosse e il suo sorriso contagioso, è diventato l'emblema dei Pokémon, amato da grandi e piccoli per il suo carattere vivace e coraggioso.", 1996, "pokemon/pikachu.jpg"),
  (2, "[en]Arceus[/en]", "[en]Game Freak[/en]", "[en]Arceus[/en], anche noto come la Creatura Originaria, è un Pokémon misterioso di tipo Normale. Secondo la leggenda, [en]Arceus[/en] è il creatore dell'universo Pokémon, nato prima dell'esistenza stessa del tempo e dello spazio.
  Dopo aver dato origine al mondo, si dice che abbia creato <a target='_blank' href='https://wiki.pokemoncentral.it/Dialga'>Dialga</a> (tempo), <a target='_blank' href='https://wiki.pokemoncentral.it/Palkia'>Palkia</a> (spazio) e <a target='_blank' href='https://wiki.pokemoncentral.it/Giratina'>Giratina</a> (antimateria) per mantenere l'equilibrio cosmico.
  Inoltre, [en]Arceus[/en] avrebbe creato i tre Pokémon del lago (<a target='_blank' lang ='en' href='https://wiki.pokemoncentral.it/Uxie'>Uxie</a>, <a target='_blank' href='https://wiki.pokemoncentral.it/Mesprit'>Mesprit</a> e <a target='_blank' href='https://wiki.pokemoncentral.it/Azelf'>Azelf</a>) per portare conoscenza, emozioni e forza di volontà agli esseri viventi.
  [en]Arceus[/en] ha un aspetto maestoso e divino: è caratterizzato da un corpo bianco elegante e snello, con accenti grigi e dorati.
  Ha un anello dorato attorno al torso, che assomiglia a un mandala, con punte che rappresentano le diverse dimensioni o forse le placche elementali.
  La sua testa presenta lunghe protuberanze, simili a corna, che conferiscono un'aria regale e ultraterrena. Gli occhi sono di un colore verde intenso, con le pupille rosse, spesso associati a un'aura di potere.
  Inoltre, è anche un Pokémon che può parlare con gli esseri umani, quindi è in grado di capirne i sentimenti ed il linguaggio, ed è disposto ad aiutare l'uomo. Se si arrabbia, comunque, può diventare furioso a tal punto da distruggere qualsiasi cosa e far sparire chiunque lui desideri dalla faccia della terra.
  Scopri di più su <a target='_blank' href='https://wiki.pokemoncentral.it/Arceus'>Arceus</a>.", 2006, "pokemon/arceus.jpg"),
  (2, "[en]Gengar[/en]", "[ja]Ken Sugimori[/ja]", "[en]Gengar[/en], il Pokémon Ombra, è uno dei Pokémon più iconici della serie, noto per il suo aspetto spettrale e il suo sorriso malizioso. È un Pokémon di tipo Spettro/Veleno ed è stato introdotto nella prima generazione.
  Ha un corpo tondeggiante con un aspetto simile a quello di un'ombra materializzata, la schiena munita di irti aculei. È di colore viola scuro, con occhi rossi brillanti che emanano un'aura inquietante.
  Ha un sorriso permanente e maligno, che sottolinea il suo carattere dispettoso. Le sue orecchie appuntite e la sua coda corta e arrotondata lo fanno sembrare un ibrido tra un fantasma e un animale caricaturale.
  [en]Gengar[/en] ama fare scherzi agli esseri umani e agli altri Pokémon, spesso spaventandoli con la sua abilità di apparire e scomparire improvvisamente.
  Nonostante il suo lato giocoso, può essere molto spaventoso, soprattutto quando usa la sua energia spettrale per drenare calore dall'aria, causando un improvviso freddo glaciale.
  È stato uno dei primi Pokémon introdotti nella serie animata, catturando l'immaginazione dei fan per il suo mix di mistero e umorismo.
  Scopri di più su <a target='_blank' lang='en' href='https://wiki.pokemoncentral.it/Gengar'>Gengar</a>.", 1996, "pokemon/gengar.jpg"),
  (2, "[en]Mewtwo[/en]", "[ja]Ken Sugimori[/ja]", "[en]Mewtwo[/en], il Pokémon Genetico, è un Pokémon leggendario di tipo Psico introdotto in prima generazione. 
  È noto per la sua potenza straordinaria e per la sua storia unica, essendo una creatura creata artificialmente a partire dal DNA di <a lang='en' target='_blank' href='https://wiki.pokemoncentral.it/Mew'>Mew</a>.
  [en]Mewtwo[/en] ha un aspetto umanoide e felino, con un corpo slanciato ma muscoloso. Il suo corpo è prevalentemente grigio-violaceo, con una lunga coda di colore viola. Ha occhi penetranti e brillanti, che riflettono la sua intelligenza e il suo potere.
  Le sue mani hanno tre dita lunghe e affusolate, progettate per manipolare oggetti e concentrare energia psichica. [en]Mewtwo[/en] è inizialmente un Pokémon freddo, calcolatore e solitario. È tormentato dal fatto di essere una creazione artificiale e si sente disconnesso sia dai Pokémon che dagli esseri umani.
  [en]Mewtwo[/en] incarna temi di potere, identità e la ricerca del proprio posto nel mondo, rendendolo uno dei personaggi più complessi e amati del mondo Pokémon.
  Scopri di più su <a target='_blank' lang='en' href='https://wiki.pokemoncentral.it/Mewtwo'>Mewtwo</a>.", 1996, "pokemon/mewtwo.jpg"),
  (2, "Zeraora", "[ja]Inosuke[/ja]", "Zeraora, il Pokémon Fulmirapido, è un Pokémon misterioso di tipo Elettro introdotto nella settima generazione (Pokémon Ultrasole e Ultraluna). È noto per la sua velocità incredibile e la sua capacità di manipolare l'elettricità con precisione letale.
  Ha un aspetto simile a un felino bipede, che ricorda una combinazione tra una pantera e un ghepardo. Il suo corpo è prevalentemente giallo, con dettagli blu e neri che sottolineano il suo tema elettrico. Ha occhi blu luminosi e un'espressione determinata.
  I suoi arti sono muscolosi e affilati, progettati per il combattimento corpo a corpo. Gli artigli e la pelliccia sul suo corpo sembrano caricati elettricamente, pronti a scatenare fulmini in ogni momento.
  Zeraora può creare campi magnetici dai cuscinetti sulle zampe con cui si sposta fino alla velocità del fulmine e levita. Si differenzia dalla maggior parte dei Pokémon di tipo Elettro poiché deve assorbire energia elettrica 
  da fonti esterne e non possiede un organo che la produca autonomamente. Il pelo gli si rizza su tutto il corpo quando utilizza grandi quantità di elettricità.
  È un Pokémon solitario e riservato, che vive lontano dagli umani. Nonostante la sua natura indipendente, è noto per proteggere i Pokémon più deboli, mostrando una sorprendente compassione. Zeraora è un Pokémon che unisce forza, velocità e mistero, ed è amato dai fan per il suo design accattivante e i suoi incredibili poteri.
  Scopri di più su <a target='_blank' href='https://wiki.pokemoncentral.it/Zeraora'>Zeraora</a>.", 2018, "pokemon/zeraora.jpg"),
  (1, "Goku Super Saiyan", "Akira Toriyama", "Goku Super Saiyan, creato da Akira Toriyama, rappresenta il momento più epico nella saga di Dragon Ball Z. Dal 1989, questa forma ha definito la leggenda di Goku, incarnando determinazione, forza e spirito combattivo che hanno ispirato generazioni di fan.", 1989, "dragonball/goku-super-saiyan.jpg"),
  (3, "Magmion", "Serghei Rotaru", "Magmion, concepito da Serghei Rotaru nel 2008, è una delle creature più potenti e memorabili dell'universo dei Gormiti. Rappresenta la forza della lava e il dominio del fuoco, con un design che combina potenza brutale e fascino mistico, perfetto per ogni collezionista.", 2008, "gormiti/armageddon.jpg");

INSERT INTO Utente (ruolo, username, nome, cognome, password_hash, email) VALUES
(1, "admin", "John", "Smith", "$2y$10$hR2hqK83R1oK4k2jWfz.NOYwpnV5Laf9ClB9C0xIwKj2sXKHL0WqC", "john.smith@example.com"),
(2, "janedoe", "Jane", "Doe", "$2y$10$vwxyzabcdefghijklmnop", "jane.doe@example.com"),
(2, "user", "User", "Name", "$2y$10$cFX/s3yEaLujSUteGmjlT.MBH.5suXmS667v0o8OVjBxsycCdFPCS", "user.name@example.com"),
(2, "bobloblaw", "Bob", "Loblaw", "$2y$10$mnopqrstuvwxyzabcdefg", "bob.loblaw@example.com");

INSERT INTO Prenotazione (id_utente, data_prenotazione, num_persone, orario) VALUES
(3, "2025-06-15", 92, "15:00"),
(3, "2025-07-20", 3, "12:00"),
(2, "2025-08-05", 1, "16:30"),
(2, "2025-09-12", 4, "10:30"),
(3, "2024-10-01", 2, "13:30");

INSERT INTO Recensione (id_utente, voto, data_recensione, descrizione, tipo) VALUES
(3, 5, "2023-06-18", "Una mostra davvero unica per gli appassionati di Yu-Gi-Oh! Le carte iconiche, come il Drago Bianco Occhi Blu e il Mago Nero, sono esposte in vetrine spettacolari. Perfetta combinazione di nostalgia e scoperta!", 1),
(2, 4, "2023-08-10", "Un'esperienza magica per ogni fan di Pokémon! Le carte sono esposte in modo accattivante, con spiegazioni dettagliate sulla loro storia e rarità. Atmosfera è perfetta per immergersi nel mondo dei Pokémon. Spero di tornare presto magari per una nuova mostra!", 0);
