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
  ("Dragon Ball Z Card Battle", "Esplora l'emozionante mondo delle carte <span lang='en'>Dragon Ball</span> Z! Dai Saiyan alle epiche battaglie, questa mostra celebra l'arte e la strategia del gioco con una collezione ricca e dinamica.", "2024-12-01", "2025-02-27", "dragonball_exhibit.jpg", ""),
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
  (4, "Drago Bianco Occhi Blu", "<span lang='ja'>Kazuki Takahashi</span>", "Il Drago Bianco Occhi Blu è una delle creature più potenti e rispettate del mondo di Yu-Gi-Oh!. Con le sue squame bianche luminose e gli occhi azzurri che brillano di energia, rappresenta la perfezione e il dominio assoluto. Il suo attacco devastante, il 'Raggio Bianco Distruttore', è sinonimo di distruzione totale. Solo i duellanti più esperti possono controllare questa carta leggendaria, simbolo di forza pura e ambizione. Nel cartone animato, il Drago Bianco Occhi Blu è la carta simbolo di <a target='_blank' href='https://it.wikipedia.org/wiki/Seto_Kaiba'>Seto Kaiba</a>, utilizzata in numerosi duelli cruciali. In particolare, nel Regno dei Duellanti, Kaiba distrugge una copia del suo Drago per evitare che cada in mani nemiche, dimostrando il suo legame esclusivo con questa creatura. Il Drago Bianco appare anche nel duello finale tra <a target='_blank' href='https://it.wikipedia.org/wiki/Yugi_Mut%C5%8D'>Yugi</a> e Kaiba, dove rappresenta la tenacia e l'ambizione senza limiti del suo proprietario.", 1999, "yugioh/drago_bianco_blu.jpg"),
  (4, "Drago Nero Occhi Rossi", "<span lang='ja'>Kazuki Takahashi</span>", "Il Drago Nero Occhi Rossi è una creatura leggendaria, simbolo di forza oscura e determinazione. Con le sue squame nere scintillanti e gli occhi che emanano un'aura rosso fuoco, rappresenta la resilienza e la capacità di superare ogni ostacolo. Il suo attacco principale, il 'Raggio Infuocato', è una manifestazione del suo potenziale distruttivo. Nel cartone animato, questa carta è spesso associata a <a target='_blank' href='https://it.wikipedia.org/wiki/Personaggi_di_Yu-Gi-Oh!#Katsuya_Jonouchi'>Joey Wheeler</a>, che la ottiene sconfiggendo <a target='_blank' href='https://yugioh.fandom.com/wiki/Rex_Raptor'>Rex Raptor</a> nel Regno dei Duellanti. In quella battaglia, Joey dimostra di essere degno di controllare il Drago Nero Occhi Rossi, trasformando la creatura in un simbolo della sua crescita come duellante. La carta ritorna in diversi momenti, come quando Joey la utilizza per affrontare avversari più forti, mostrando il suo coraggio e la sua determinazione a non arrendersi mai.", 1999, "yugioh/drago_nero_rosso.jpg"),
  (4, "Exodia", "<span lang='ja'>Kazuki Takahashi</span>", "Exodia è una creatura mitica, conosciuta come l'arma definitiva nel mondo di Yu-Gi-Oh!. È divisa in cinque pezzi, ognuno dei quali rappresenta un frammento del suo immenso potere. Quando tutte le parti vengono riunite, Exodia garantisce la vittoria immediata, rendendola una delle carte più temute e rispettate. Nel cartone animato, Exodia fa il suo debutto nel primo episodio della serie, quando <a target='_blank' href='https://it.wikipedia.org/wiki/Yugi_Mut%C5%8D'>Yugi</a> lo evoca per sconfiggere <a target='_blank' href='https://it.wikipedia.org/wiki/Seto_Kaiba'>Seto Kaiba</a>. In questa scena iconica, le cinque parti di Exodia si combinano per distruggere i tre Draghi Bianchi Occhi Blu di Kaiba, ribaltando il duello in un colpo solo. La sua figura colossale, avvolta in catene, è diventata un simbolo di speranza per i duellanti, evocata solo dai più grandi strategici in momenti di disperazione.", 1999, "yugioh/exodia.jpg"),
  (4, "Mago Nero", "<span lang='ja'>Kazuki Takahashi</span>", "Il Mago Nero è il maestro supremo della magia oscura, simbolo di conoscenza e potere arcano. Con la sua tunica elaborata e la sua bacchetta, è una delle creature più iconiche di Yu-Gi-Oh!. Il suo design elegante e la sua maestria negli incantesimi lo rendono un'arma letale in battaglia. Nel cartone animato, il Mago Nero è la carta simbolo di <a target='_blank' href='https://it.wikipedia.org/wiki/Yugi_Mut%C5%8D'>Yugi</a>, utilizzata in numerosi duelli chiave. Durante il Regno dei Duellanti, il Mago Nero appare per la prima volta contro <a target='_blank' href='https://it.wikipedia.org/wiki/Seto_Kaiba'>Seto Kaiba</a>, dimostrando il suo potenziale devastante. La carta gioca un ruolo centrale anche nel duello contro <a target='_blank' href='https://yugioh.fandom.com/wiki/Maximillion_Pegasus'>Pegasus</a>, dove Yugi combina la sua strategia con il potere magico del Mago Nero per proteggere i suoi amici e affrontare la mente di Pegasus. È più di una carta: è il simbolo del legame tra Yugi e il Faraone.", 1999, "yugioh/mago_nero.jpg"),
  (4, "Obelisk il Tormentatore", "<span lang='ja'>Kazuki Takahashi</span>", "Obelisk il Tormentatore è una delle tre divinità egizie, una carta di potenza divina che domina il campo di battaglia con la sua presenza colossale. Con il suo corpo blu scuro e i muscoli scolpiti, rappresenta la forza assoluta. Il suo attacco, 'Fist of Fury', è capace di eliminare tutti gli avversari con una sola mossa. Nel cartone animato, Obelisk è posseduto da <a target='_blank' href='https://it.wikipedia.org/wiki/Seto_Kaiba'>Seto Kaiba</a> e gioca un ruolo cruciale nel torneo di Battle City. Una delle sue apparizioni più iconiche avviene durante il duello contro <a target='_blank' href='https://yugioh.fandom.com/wiki/Ishizu_Ishtar'>Ishizu Ishtar</a>, dove Kaiba utilizza la carta per ribaltare una situazione apparentemente disperata. La sua figura, legata alle antiche memorie del faraone, rappresenta non solo il potere ineguagliabile, ma anche il mistero e il fascino delle civiltà perdute.", 2000, "yugioh/obelisk.jpg"),
  (2, "Pikachu", "<span lang='ja'>Atsuko Nishida</span>", "Pikachu, ideato da Atsuko Nishida, è l'adorabile Pokémon di tipo Elettro che ha conquistato il mondo fin dal 1996. Con le sue guance rosse e il suo sorriso contagioso, è diventato l'emblema dei Pokémon, amato da grandi e piccoli per il suo carattere vivace e coraggioso.", 1996, "pokemon/pikachu.jpg"),
  (2, "<span lang='en'>Arceus</span>", "<span lang='en'>Game Freak</span>", "<span lang='en'>Arceus</span>, anche noto come la Creatura Originaria, è un Pokémon misterioso di tipo Normale. Secondo la leggenda, <span lang='en'>Arceus</span> è il creatore dell'universo Pokémon, nato prima dell'esistenza stessa del tempo e dello spazio.
  Dopo aver dato origine al mondo, si dice che abbia creato <a target='_blank' href='https://wiki.pokemoncentral.it/Dialga'>Dialga</a> (tempo), <a target='_blank' href='https://wiki.pokemoncentral.it/Palkia'>Palkia</a> (spazio) e <a target='_blank' href='https://wiki.pokemoncentral.it/Giratina'>Giratina</a> (antimateria) per mantenere l'equilibrio cosmico.
  Inoltre, <span lang='en'>Arceus</span> avrebbe creato i tre Pokémon del lago (<a target='_blank' lang ='en' href='https://wiki.pokemoncentral.it/Uxie'>Uxie</a>, <a target='_blank' href='https://wiki.pokemoncentral.it/Mesprit'>Mesprit</a> e <a target='_blank' href='https://wiki.pokemoncentral.it/Azelf'>Azelf</a>) per portare conoscenza, emozioni e forza di volontà agli esseri viventi.
  <span lang='en'>Arceus</span> ha un aspetto maestoso e divino: è caratterizzato da un corpo bianco elegante e snello, con accenti grigi e dorati.
  Ha un anello dorato attorno al torso, che assomiglia a un mandala, con punte che rappresentano le diverse dimensioni o forse le placche elementali.
  La sua testa presenta lunghe protuberanze, simili a corna, che conferiscono un'aria regale e ultraterrena. Gli occhi sono di un colore verde intenso, con le pupille rosse, spesso associati a un'aura di potere.
  Inoltre, è anche un Pokémon che può parlare con gli esseri umani, quindi è in grado di capirne i sentimenti ed il linguaggio, ed è disposto ad aiutare l'uomo. Se si arrabbia, comunque, può diventare furioso a tal punto da distruggere qualsiasi cosa e far sparire chiunque lui desideri dalla faccia della terra.
  Scopri di più su <a target='_blank' href='https://wiki.pokemoncentral.it/Arceus'>Arceus</a>.", 2006, "pokemon/arceus.jpg"),
  (2, "<span lang='en'>Gengar</span>", "<span lang='ja'>Ken Sugimori</span>", "<span lang='en'>Gengar</span>, il Pokémon Ombra, è uno dei Pokémon più iconici della serie, noto per il suo aspetto spettrale e il suo sorriso malizioso. È un Pokémon di tipo Spettro/Veleno ed è stato introdotto nella prima generazione.
  Ha un corpo tondeggiante con un aspetto simile a quello di un'ombra materializzata, la schiena munita di irti aculei. È di colore viola scuro, con occhi rossi brillanti che emanano un'aura inquietante.
  Ha un sorriso permanente e maligno, che sottolinea il suo carattere dispettoso. Le sue orecchie appuntite e la sua coda corta e arrotondata lo fanno sembrare un ibrido tra un fantasma e un animale caricaturale.
  <span lang='en'>Gengar</span> ama fare scherzi agli esseri umani e agli altri Pokémon, spesso spaventandoli con la sua abilità di apparire e scomparire improvvisamente.
  Nonostante il suo lato giocoso, può essere molto spaventoso, soprattutto quando usa la sua energia spettrale per drenare calore dall'aria, causando un improvviso freddo glaciale.
  È stato uno dei primi Pokémon introdotti nella serie animata, catturando l'immaginazione dei fan per il suo mix di mistero e umorismo.
  Scopri di più su <a target='_blank' lang='en' href='https://wiki.pokemoncentral.it/Gengar'>Gengar</a>.", 1996, "pokemon/gengar.jpg"),
  (2, "<span lang='en'>Mewtwo</span>", "<span lang='ja'>Ken Sugimori</span>", "<span lang='en'>Mewtwo</span>, il Pokémon Genetico, è un Pokémon leggendario di tipo Psico introdotto in prima generazione. 
  È noto per la sua potenza straordinaria e per la sua storia unica, essendo una creatura creata artificialmente a partire dal DNA di <a lang='en' target='_blank' href='https://wiki.pokemoncentral.it/Mew'>Mew</a>.
  <span lang='en'>Mewtwo</span> ha un aspetto umanoide e felino, con un corpo slanciato ma muscoloso. Il suo corpo è prevalentemente grigio-violaceo, con una lunga coda di colore viola. Ha occhi penetranti e brillanti, che riflettono la sua intelligenza e il suo potere.
  Le sue mani hanno tre dita lunghe e affusolate, progettate per manipolare oggetti e concentrare energia psichica. <span lang='en'>Mewtwo</span> è inizialmente un Pokémon freddo, calcolatore e solitario. È tormentato dal fatto di essere una creazione artificiale e si sente disconnesso sia dai Pokémon che dagli esseri umani.
  <span lang='en'>Mewtwo</span> incarna temi di potere, identità e la ricerca del proprio posto nel mondo, rendendolo uno dei personaggi più complessi e amati del mondo Pokémon.
  Scopri di più su <a target='_blank' lang='en' href='https://wiki.pokemoncentral.it/Mewtwo'>Mewtwo</a>.", 1996, "pokemon/mewtwo.jpg"),
  (2, "Zeraora", "<span lang='ja'>Inosuke</span>", "Zeraora, il Pokémon Fulmirapido, è un Pokémon misterioso di tipo Elettro introdotto nella settima generazione (Pokémon Ultrasole e Ultraluna). È noto per la sua velocità incredibile e la sua capacità di manipolare l'elettricità con precisione letale.
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
