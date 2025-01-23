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
  ("{en}Dragon Ball{/en} Z {en}Card Battle{/en}", "Esplora l'emozionante mondo delle carte {en}Dragon Ball{/en} Z! Dai {ja}Saiyan{/ja} alle epiche battaglie, questa mostra celebra l'arte e la strategia del gioco con una collezione ricca e dinamica.", "2024-12-01", "2025-02-27", "dragonball_exhibit.webp", ""),
  ("Pokémon {en}Card Showcase{/en}", "La più grande collezione di carte Pokémon mai esposta. Dagli inizi con il set base fino alle edizioni moderne, scopri le carte più rare e iconiche, e immergiti in un mondo di ricordi e sorprese.", "2024-12-01", "2024-12-31", "pokemon_exhibit.webp", ""),
  ("Gormiti {en}Card Collection{/en}", "Rivivi l'epoca d'oro dei Gormiti attraverso le loro carte! Una collezione completa e unica, che racconta storie di battaglie epiche e terre magiche con dettagli affascinanti e colorati.", "2025-11-20", "2025-12-31", "gormiti_exhibit.webp", ""),
  ("Pokémon: Sole e Luna", "Immergiti in un'avventura spaziale con la nuova mostra a tema Pokémon: Sole e Luna! Scopri le rarissime carte della regione di Alola, tra cui non mancheranno certamente Solgaleo e Lunala GX!", "2025-01-14", "2025-03-24", "sun_moon.webp", ""),
  ("Yu-Gi-Oh {en}Exhibit{/en}", "Un viaggio nel mondo di Yu-Gi-Oh che non puoi perdere! L'esposizione include carte rare, storia del gioco e dettagli affascinanti sulle illustrazioni. Perfetta per fan di lunga data e neofiti curiosi.", "2023-06-01", "2023-06-10", "yugioh_exhibit.webp", "");


INSERT INTO Sala (nome, descrizione, img_path) VALUES
  ("{en}Dragon Ball Battle Grounds{/en}", "Immergiti nell'universo epico di {en}Dragon Ball{/en}, dove potrai esplorare le avventure di {ja}Goku{/ja} e dei suoi amici. Scopri le Sfere del Drago, rivivi gli scontri leggendari contro i {ja}Saiyan{/ja}, {en}Freezer{/en} e {ja}Majin Bu{/ja}, e lasciati travolgere dall'energia delle trasformazioni Super {ja}Saiyan{/ja}. Oggetti iconici e ricostruzioni interattive ti aspettano per farti sentire parte di questa straordinaria saga.", "dragonball_grounds.jpg"),
  ("Pokémon {en}Card Gallery{/en}", "Entra nel fantastico mondo dei Pokémon, dove allenatori di tutte le età possono scoprire creature straordinarie. Esplora regioni come Kanto, Johto e Galar, ammira una collezione di Poké Ball, e sfida le emozionanti battaglie in un'arena virtuale. Non dimenticare di incontrare i Pokémon leggendari e mitici in una sala dedicata alla loro storia e potere.", "pokemon_gallery.jpg"),
  ("Gormiti {en}Habitat{/en}", "Viaggia verso l'isola magica dei Gormiti, dove la natura prende vita attraverso i potenti {en}Lord{/en} della Terra, del Mare, del Fuoco e dell'Aria. Attraversa paesaggi suggestivi e scopri la storia di questa eterna lotta tra il bene e il male. Modelli tridimensionali, effetti luminosi e una narrazione avvincente rendono questa sala un'esperienza immersiva.", "gormiti_habitat.jpg"),
  ("Yu-Gi-Oh Arena", "Preparati a duellare nel mondo di Yu-Gi-Oh!, dove ogni carta racconta una storia epica. Esplora il regno dei mostri con esposizioni dedicate alle carte leggendarie come il Drago Bianco Occhi Blu e il Mago Nero. Una replica dell'arena da duello ti aspetta per sfidare amici e rivivere i momenti più iconici della serie.", "yugioh_arena.jpg");

INSERT INTO Opera (id_sala, nome, autore, descrizione, anno, img_path) VALUES
  -- yugioh
  (4, "Drago Bianco Occhi Blu", "{ja}Kazuki Takahashi{/ja}", "Il Drago Bianco Occhi Blu è una delle creature più potenti e rispettate del mondo di Yu-Gi-Oh!. Con le sue squame bianche luminose e 
  gli occhi azzurri che brillano di energia, rappresenta la perfezione e il dominio assoluto. Il suo attacco devastante, il 'Raggio Bianco Distruttore', è sinonimo di distruzione totale. Solo i 
  duellanti più esperti possono controllare questa carta leggendaria, simbolo di forza pura e ambizione. Nel cartone animato, il Drago Bianco Occhi Blu è la carta simbolo di 
  {aja}Seto Kaiba{/ahttps://it.wikipedia.org/wiki/Seto_Kaiba}, utilizzata in numerosi duelli cruciali. In particolare, nel Regno dei Duellanti, {ja}Kaiba{/ja} distrugge una copia del suo Drago 
  per evitare che cada in mani nemiche, dimostrando il suo legame esclusivo con questa creatura. Il Drago Bianco appare anche nel duello finale tra {aja}Yugi{/ahttps://it.wikipedia.org/wiki/Yugi_Mut%C5%8D} 
  e {ja}Kaiba{/ja}, dove rappresenta la tenacia e l'ambizione senza limiti del suo proprietario.
  Scopri di più su {ait}Drago Bianco Occhi Blu{/ahttps://yugipedia.com/wiki/Blue-Eyes_White_Dragon_(character)}.", 1999, "yugioh/drago_bianco_blu.jpg"),
  (4, "Drago Nero Occhi Rossi", "{ja}Kazuki Takahashi{/ja}", "Il Drago Nero Occhi Rossi è una creatura leggendaria, simbolo di forza oscura e determinazione. Con le sue squame nere scintillanti 
  e gli occhi che emanano un'aura rosso fuoco, rappresenta la resilienza e la capacità di superare ogni ostacolo. Il suo attacco principale, il 'Raggio Infuocato', è una manifestazione del suo 
  potenziale distruttivo. Nel cartone animato, questa carta è spesso associata a {aen}Joey Wheeler{/ahttps://it.wikipedia.org/wiki/Personaggi_di_Yu-Gi-Oh!#Katsuya_Jonouchi}, che la ottiene sconfiggendo 
  {aen}Rex Raptor{/ahttps://yugioh.fandom.com/wiki/Rex_Raptor} nel Regno dei Duellanti. In quella battaglia, {en}Joey{/en} dimostra di essere degno di controllare il Drago Nero Occhi Rossi, trasformando 
  la creatura in un simbolo della sua crescita come duellante. La carta ritorna in diversi momenti, come quando {en}Joey{/en} la utilizza per affrontare avversari più forti, mostrando il suo coraggio e 
  la sua determinazione a non arrendersi mai.", 1999, "yugioh/drago_nero_rosso.jpg"),
  (4, "Exodia il Proibito", "{ja}Kazuki Takahashi{/ja}", "Exodia il Proibito è una creatura mitica, conosciuta come l'arma definitiva nel mondo di Yu-Gi-Oh!. È divisa in cinque pezzi, ognuno dei quali rappresenta un frammento 
  del suo immenso potere. Quando tutte le parti vengono riunite, Exodia garantisce la vittoria immediata, rendendola una delle carte più temute e rispettate. Nel cartone animato, Exodia fa il suo debutto 
  nel primo episodio della serie, quando {aja}Yugi{/ahttps://it.wikipedia.org/wiki/Yugi_Mut%C5%8D} lo evoca per sconfiggere {aja}Seto Kaiba{/ahttps://it.wikipedia.org/wiki/Seto_Kaiba}. In questa scena 
  iconica, le cinque parti di Exodia si combinano per distruggere i tre Draghi Bianchi Occhi Blu di Kaiba, ribaltando il duello in un colpo solo. La sua figura colossale, avvolta in catene, è diventata 
  un simbolo di speranza per i duellanti, evocata solo dai più grandi strategici in momenti di disperazione.
  Scopri di più su {ait}Exodia il proibito{/ahttps://yugipedia.com/wiki/Exodia_the_Forbidden_One_(character)}", 1999, "yugioh/exodia.jpg"),
  (4, "Mago Nero", "{ja}Kazuki Takahashi{/ja}", "Il Mago Nero è il maestro supremo della magia oscura, simbolo di conoscenza e potere arcano. Con la sua tunica elaborata e la sua bacchetta, è una delle 
  creature più iconiche di Yu-Gi-Oh!. Il suo design elegante e la sua maestria negli incantesimi lo rendono un'arma letale in battaglia. Nel cartone animato, il Mago Nero è la carta simbolo di 
  {aja}Yugi{/ahttps://it.wikipedia.org/wiki/Yugi_Mut%C5%8D}, utilizzata in numerosi duelli chiave. Durante il Regno dei Duellanti, il Mago Nero appare per la prima volta contro 
  {aja}Seto Kaiba{/ahttps://it.wikipedia.org/wiki/Seto_Kaiba}, dimostrando il suo potenziale devastante. La carta gioca un ruolo centrale anche nel duello contro {ait}Pegasus{/ahttps://yugioh.fandom.com/wiki/Maximillion_Pegasus}, 
  dove {ja}Yugi{/ja} combina la sua strategia con il potere magico del Mago Nero per proteggere i suoi amici e affrontare la mente di Pegasus. È più di una carta: è il simbolo del legame tra {ja}Yugi{/ja} e il Faraone.
  Scopri di più su {ait}Mago Nero{/ahttps://virtualarena.fandom.com/it/wiki/Mago_Nero}.", 1999, "yugioh/mago_nero.jpg"),
  (4, "Obelisk il Tormentatore", "{ja}Kazuki Takahashi{/ja}", "Obelisk il Tormentatore è una delle tre divinità egizie, una carta di potenza divina che domina il campo di battaglia con la sua presenza colossale. 
  Con il suo corpo blu scuro e i muscoli scolpiti, rappresenta la forza assoluta. Il suo attacco, {en}'Fist of Fury'{/en}, è capace di eliminare tutti gli avversari con una sola mossa. Nel cartone animato, 
  Obelisk è posseduto da {aja}Seto Kaiba{/ahttps://it.wikipedia.org/wiki/Seto_Kaiba} e gioca un ruolo cruciale nel torneo di {en}Battle City{/en}. Una delle sue apparizioni più iconiche avviene durante il 
  duello contro {aja}Ishizu Ishtar{/ahttps://yugioh.fandom.com/wiki/Ishizu_Ishtar}, dove {ja}Kaiba{/ja} utilizza la carta per ribaltare una situazione apparentemente disperata. La sua figura, legata alle antiche 
  memorie del faraone, rappresenta non solo il potere ineguagliabile, ma anche il mistero e il fascino delle civiltà perdute.", 2000, "yugioh/obelisk.jpg"),
  -- pokemon
  (2, "Pikachu", "{ja}Atsuko Nishida{/ja}", "Pikachu, ideato da {ja}Atsuko Nishida{/ja}, è l'adorabile Pokémon di tipo Elettro che ha conquistato il mondo fin dal 1996. Con le sue guance rosse e il suo sorriso contagioso, 
  è diventato l'emblema dei Pokémon, amato da grandi e piccoli per il suo carattere vivace e coraggioso.", 1996, "pokemon/pikachu.png"),
  (2, "{en}Arceus{/en}", "{en}Game Freak{/en}", "{en}Arceus{/en}, anche noto come la Creatura Originaria, è un Pokémon misterioso di tipo Normale. Secondo la leggenda, {en}Arceus{/en} è il creatore dell'universo Pokémon, nato prima dell'esistenza stessa del tempo e dello spazio.
  Dopo aver dato origine al mondo, si dice che abbia creato {ait}Dialga{/ahttps://wiki.pokemoncentral.it/Dialga} (tempo), {ait}Palkia{/ahttps://wiki.pokemoncentral.it/Palkia} (spazio) e {aen}Giratina{/ahttps://wiki.pokemoncentral.it/Giratina} (antimateria) per mantenere l'equilibrio cosmico.
  Inoltre, {en}Arceus{/en} avrebbe creato i tre Pokémon del lago ({aen}Uxie{/ahttps://wiki.pokemoncentral.it/Uxie}, {aen}Mesprit{/ahttps://wiki.pokemoncentral.it/Mesprit} e {aen}Azelf{/ahttps://wiki.pokemoncentral.it/Azelf}) per portare conoscenza, emozioni e forza di volontà agli esseri viventi.
  {en}Arceus{/en} ha un aspetto maestoso e divino: è caratterizzato da un corpo bianco elegante e snello, con accenti grigi e dorati.
  Ha un anello dorato attorno al torso, che assomiglia a un mandala, con punte che rappresentano le diverse dimensioni o forse le placche elementali.
  La sua testa presenta lunghe protuberanze, simili a corna, che conferiscono un'aria regale e ultraterrena. Gli occhi sono di un colore verde intenso, con le pupille rosse, spesso associati a un'aura di potere.
  Inoltre, è anche un Pokémon che può parlare con gli esseri umani, quindi è in grado di capirne i sentimenti ed il linguaggio, ed è disposto ad aiutare l'uomo. Se si arrabbia, comunque, può diventare furioso a tal punto da distruggere qualsiasi cosa e far sparire chiunque lui desideri dalla faccia della terra.
  Scopri di più su {aen}Arceus{/ahttps://wiki.pokemoncentral.it/Arceus}.", 2006, "pokemon/arceus.png"),
  (2, "{en}Gengar{/en}", "{ja}Ken Sugimori{/ja}", "{en}Gengar{/en}, il Pokémon Ombra, è uno dei Pokémon più iconici della serie, noto per il suo aspetto spettrale e il suo sorriso malizioso. È un Pokémon di tipo Spettro/Veleno ed è stato introdotto nella prima generazione.
  Ha un corpo tondeggiante con un aspetto simile a quello di un'ombra materializzata, la schiena munita di irti aculei. È di colore viola scuro, con occhi rossi brillanti che emanano un'aura inquietante.
  Ha un sorriso permanente e maligno, che sottolinea il suo carattere dispettoso. Le sue orecchie appuntite e la sua coda corta e arrotondata lo fanno sembrare un ibrido tra un fantasma e un animale caricaturale.
  {en}Gengar{/en} ama fare scherzi agli esseri umani e agli altri Pokémon, spesso spaventandoli con la sua abilità di apparire e scomparire improvvisamente.
  Nonostante il suo lato giocoso, può essere molto spaventoso, soprattutto quando usa la sua energia spettrale per drenare calore dall'aria, causando un improvviso freddo glaciale.
  È stato uno dei primi Pokémon introdotti nella serie animata, catturando l'immaginazione dei fan per il suo mix di mistero e umorismo.
  Scopri di più su {aen}Gengar{/ahttps://wiki.pokemoncentral.it/Gengar}.", 1996, "pokemon/gengar.png"),
  (2, "{en}Mewtwo{/en}", "{ja}Ken Sugimori{/ja}", "{en}Mewtwo{/en}, il Pokémon Genetico, è un Pokémon leggendario di tipo Psico introdotto in prima generazione. 
  È noto per la sua potenza straordinaria e per la sua storia unica, essendo una creatura creata artificialmente a partire dal DNA di {aen}Mew{/ahttps://wiki.pokemoncentral.it/Mew}.
  {en}Mewtwo{/en} ha un aspetto umanoide e felino, con un corpo slanciato ma muscoloso. Il suo corpo è prevalentemente grigio-violaceo, con una lunga coda di colore viola. Ha occhi penetranti e brillanti, che riflettono la sua intelligenza e il suo potere.
  Le sue mani hanno tre dita lunghe e affusolate, progettate per manipolare oggetti e concentrare energia psichica. {en}Mewtwo{/en} è inizialmente un Pokémon freddo, calcolatore e solitario. 
  È tormentato dal fatto di essere una creazione artificiale e si sente disconnesso sia dai Pokémon che dagli esseri umani.
  {en}Mewtwo{/en} incarna temi di potere, identità e la ricerca del proprio posto nel mondo, rendendolo uno dei personaggi più complessi e amati del mondo Pokémon.
  Scopri di più su {aen}Mewtwo{/ahttps://wiki.pokemoncentral.it/Mewtwo}.", 1996, "pokemon/mewtwo.png"),
  (2, "Zeraora", "{ja}Inosuke{/ja}", "Zeraora, il Pokémon Fulmirapido, è un Pokémon misterioso di tipo Elettro introdotto nella settima generazione ({ait}Pokémon Ultrasole e Ultraluna{/ahttps://wiki.pokemoncentral.it/Pok%C3%A9mon_Ultrasole_e_Ultraluna}). 
  È noto per la sua velocità incredibile e la sua capacità di manipolare l'elettricità con precisione letale.
  Ha un aspetto simile a un felino bipede, che ricorda una combinazione tra una pantera e un ghepardo. Il suo corpo è prevalentemente giallo, con dettagli blu e neri che sottolineano il suo tema elettrico. Ha occhi blu luminosi e un'espressione determinata.
  I suoi arti sono muscolosi e affilati, progettati per il combattimento corpo a corpo. Gli artigli e la pelliccia sul suo corpo sembrano caricati elettricamente, pronti a scatenare fulmini in ogni momento.
  Zeraora può creare campi magnetici dai cuscinetti sulle zampe con cui si sposta fino alla velocità del fulmine e levita. Si differenzia dalla maggior parte dei Pokémon di tipo Elettro poiché deve assorbire energia elettrica 
  da fonti esterne e non possiede un organo che la produca autonomamente. Il pelo gli si rizza su tutto il corpo quando utilizza grandi quantità di elettricità.
  È un Pokémon solitario e riservato, che vive lontano dagli umani. Nonostante la sua natura indipendente, è noto per proteggere i Pokémon più deboli, mostrando una sorprendente compassione. Zeraora è un Pokémon che unisce forza, 
  velocità e mistero, ed è amato dai fan per il suo design accattivante e i suoi incredibili poteri.
  Scopri di più su {ait}Zeraora{/ahttps://wiki.pokemoncentral.it/Zeraora}", 2018, "pokemon/zeraora.png"),
  -- dragonball
  (1, "{en}Freezer{en}", "{ja}Akira Toriyama{/ja}", "{en}Freezer{/en} è uno dei villain più iconici della serie {en}Dragon Ball{/en}, noto per la sua crudeltà e il suo potere devastante. 
  Questo imperatore galattico spietato domina interi pianeti e razze, eliminando chiunque osi opporsi al suo dominio. Con un aspetto alieno elegante e minaccioso, {en}Freezer{/en} 
  è capace di trasformarsi in diverse forme, ognuna più potente della precedente. Nel cartone animato, {en}Freezer{/en} è il principale antagonista nella saga di {aja}Namek{/ahttps://dragonball.fandom.com/it/wiki/Namecc}, 
  dove affronta {aja}Goku{/ahttps://dragonball.fandom.com/wiki/Goku} e i suoi amici. La sua trasformazione finale, combinata con il suo attacco 'Disco Distruttore', rappresenta una delle 
  battaglie più memorabili della serie. Il suo epico scontro con {ja}Goku{/ja}, culminato nella trasformazione di quest'ultimo in Super {ja}Saiyan{/ja}, è uno dei momenti più iconici di {en}Dragon Ball{/en}.
  Scopri di più su {aen}Freezer{/ahttps://dragonball.fandom.com/it/wiki/Freezer}.", 1989, "dragonball/freezer.jpg"),
  (1, "{ja}Goku{/ja} Super {ja}Saiyan{/ja}", "{ja}Akira Toriyama{/ja}", "{ja}Goku{/ja} Super {ja}Saiyan{/ja} è il simbolo dell'evoluzione e della determinazione, rappresentando il culmine 
  del potere {ja}Saiyan{/ja}. Con i capelli dorati e l'aura splendente, questa trasformazione aumenta enormemente la forza e la velocità di {aja}Goku{/ahttps://dragonball.fandom.com/wiki/Goku}, 
  rendendolo quasi invincibile. Nel cartone animato, {ja}Goku{/ja} raggiunge per la prima volta lo stato di Super {ja}Saiyan{/ja} durante la battaglia contro {en}Freezer{/en} su {aja}Namek{/ahttps://dragonball.fandom.com/it/wiki/Namecc}, 
  in un momento di pura disperazione e rabbia dopo la morte del suo amico {ait}Crilin{/ahttps://dragonball.fandom.com/wiki/Krillin}. La sua trasformazione segna un punto di svolta nella serie, 
  dimostrando il potenziale illimitato dei {ja}Saiyan{/ja}. {ja}Goku{/ja} utilizza questa forma in molte altre battaglie iconiche, consolidando il suo status di eroe leggendario.
  Scopri di più su {ait}{ja}Goku{/ja} Super {ja}Saiyan{/ja}{/ahttps://dragonball.fandom.com/it/wiki/Super_Saiyan}.", 1991, "dragonball/goku-super-saiyan.jpg"),
  (1, "{ja}Majin Bu{/ja}", "{ja}Akira Toriyama{/ja}", "{ja}Majin Bu{/ja} è una creatura antica e imprevedibile, capace di alternare momenti di innocenza a esplosioni di violenza pura. 
  Con un aspetto inizialmente buffo e paffuto, nasconde un potere immenso che lo rende uno degli avversari più pericolosi affrontati dai {ait}guerrieri Z{/ahttps://dragonball.fandom.com/it/wiki/Guerrieri_Z}. 
  {ja}Majin Bu{/ja} ha la capacità di rigenerarsi e trasformarsi in versioni sempre più potenti. Nel cartone animato, è il principale antagonista della saga di {ja}Majin Bu{/ja}, dove terrorizza l'universo 
  con la sua forza distruttiva. Una delle sue trasformazioni più memorabili è quella in {ja}Kid Bu{/ja}, la forma originale e più crudele. Le battaglie tra {ja}Majin Bu{/ja} e {aja}Goku{/ahttps://dragonball.fandom.com/wiki/Goku}, 
  culminate con l'utilizzo della {ait}Sfera {ja}Genkidama{/ja}{/ahttps://dragonball.fandom.com/it/wiki/Sfera_Genkidama}, rappresentano alcuni dei momenti più emozionanti della serie.
  Scopri di più su {aja}Majin Bu{/ahttps://dragonball.fandom.com/it/wiki/Majin-Bu}.", 1994, "dragonball/majin_bu.jpg"),
  (1, "{ja}Shenron{/ja}", "{ja}Akira Toriyama{/ja}", "{ja}Shenron{/ja} è il leggendario drago dell'anime {en}Dragon Ball{/en}, evocato raccogliendo tutte e sette le Sfere del Drago. 
  Con il suo corpo serpentino verde e le corna imponenti, rappresenta il potere divino di realizzare qualsiasi desiderio, con alcune limitazioni. {ja}Shenron{/ja} appare in momenti cruciali, spesso 
  per riportare in vita personaggi caduti o per risolvere situazioni disperate. Nel cartone animato, il primo incontro con {ja}Shenron{/ja} avviene quando {aja}Goku{/ahttps://dragonball.fandom.com/wiki/Goku} 
  e {ait}Bulma{/ahttps://dragonball.fandom.com/wiki/Bulma} cercano le Sfere del Drago per esaudire i loro desideri. La sua presenza è ricorrente in tutta la serie, come quando {ja}Goku{/ja} 
  utilizza le sfere per salvare il pianeta {aja}Namek{/ahttps://dragonball.fandom.com/it/wiki/Namecc}. {ja}Shenron{/ja} è un simbolo di speranza e rinascita, un elemento chiave della trama di {en}Dragon Ball{/en}.
  Scopri di più su {aja}Shenron{/ahttps://dragonball.fandom.com/it/wiki/Shenron}.", 1986, "dragonball/shenron.jpg"),
  (1, "Vegeta", "{ja}Akira Toriyama{/ja}", "Vegeta è il principe orgoglioso della razza {ja}Saiyan{/ja}, noto per la sua ambizione, il suo orgoglio e la sua determinazione incrollabile. Con il suo 
  caratteristico sguardo severo e la sua forza esplosiva, Vegeta è uno dei personaggi più complessi e amati della serie. All'inizio, Vegeta è un antagonista, intenzionato a conquistare la Terra, 
  ma nel corso del tempo si evolve, diventando un alleato fondamentale per {aja}Goku{/ahttps://dragonball.fandom.com/wiki/Goku} e gli altri guerrieri Z. Nel cartone animato, Vegeta è protagonista di 
  molti momenti memorabili, come il suo sacrificio eroico contro {ja}Majin Bu{/ja} e il raggiungimento della forma Super {ja}Saiyan{/ja} per competere con {ja}Goku{/ja}. La sua rivalità con {ja}Goku{/ja} è 
  una delle dinamiche più importanti della serie, spingendolo costantemente a superare i suoi limiti.
  Scopri di più su {ait}Vegeta{/ahttps://dragonball.fandom.com/it/wiki/Vegeta}.", 1989, "dragonball/vegeta.jpg"),
  -- gormiti
  (3, "Lavion", "Giochi Preziosi", "Lavion è il Signore del Popolo della Lava, noto per la sua forza devastante e la sua 'morsa stritolatrice', temuta in tutta l'Isola di Gorm. È considerabile, insieme 
  a {ait}Magmion{/ahttps://gormiti.fandom.com/it/wiki/Magmion}, il primo Signore del Vulcano apparso sull'Isola di Gorm. Con un aspetto imponente che richiama le creature laviche, Lavion è un 
  guerriero spietato e ambizioso. Nelle sue vene scorre lava infuocata, i suoi possenti muscoli sembrano dover esplodere da un momento all'altro. Il braccio d'acciaio, forgiato dalla lava del Monte 
  di Fuoco, è in grado di stritolare ogni avversario, e un ghigno malefico si accende sul suo volto ogni volta che può assistere ad uno spettacolo di sofferenza. Nel cartone animato, Lavion appare in 
  numerosi episodi, distinguendosi per la sua lealtà verso Magmion e la sua determinazione nel conquistare nuovi territori. In una scena memorabile, guida un attacco contro la Valle del Destino, dimostrando 
  la sua abilità strategica e la sua ferocia in battaglia. La sua presenza incute timore sia tra gli alleati che tra i nemici, consolidando la sua reputazione di {en}leader{/en} temibile e inarrestabile.
  Scopri di più su {ait}Lavion{/ahttps://gormiti.fandom.com/it/wiki/Lavion}.", 2008, "gormiti/lavion.webp"), 
  (3, "Noctis", "Giochi Preziosi", "Noctis è il Signore del Popolo dell'Aria, noto per la sua velocità e silenziosità. Sorveglia dall'alto, pronto a scagliarsi su prede e nemici con i suoi artigli affilati. 
  Nulla riesce a sfuggirgli, i suoi occhi vedono lontano e il suo becco d'acciaio, affilato con cura, può mandare in frantumi qualunque cosa. Quando sfreccia nel cielo di Gorm le sue ali regali oscurano la 
  luce del sole. Ha la velocità del fulmine e la leggerezza delle nuvole. Stimato e ammirato da tutti i suoi compagni, è il Signore della volta celeste. Nel cartone animato, Noctis appare in numerose battaglie, 
  utilizzando la sua capacità di volare e la sua agilità per sorprendere gli avversari. In una scena memorabile, guida un attacco aereo contro le forze del male, dimostrando la sua {en}leadership{/en} e il suo coraggio.
  Scopri di più su {ait}Noctis{/ahttps://gormiti.fandom.com/it/wiki/Noctis}.", 2008, "gormiti/noctis.webp"),
  (3, "Talps", "Giochi Preziosi", "Talps, conosciuto come lo Scavabuche, è un Gormita del Popolo della Terra. Vive sottoterra, il che ha reso la sua vista meno acuta, ma ha sviluppato un udito eccezionale, 
  capace di percepire suoni a chilometri di distanza. I suoi artigli, affilati dalla roccia che scava, sono armi temibili. Cogliere di sorpresa i nemici è la sua strategia perferita. Possiede mani 
  gigantesche, di roccia così dura da poter scavare buche profonde. I suoi movimenti sono veloci ma fatali. Nel cartone animato, Talps utilizza le sue abilità di scavo per creare tunnel strategici e 
  sorprendere i nemici. In un episodio chiave, salva i suoi compagni intrappolati utilizzando la sua conoscenza del sottosuolo.
  Scopri di più su {ait}Talps{/ahttps://gormiti.fandom.com/it/wiki/Talps}.", 2008, "gormiti/talps.webp"),
  (3, "Tenaglia", "Giochi Preziosi", "Tenaglia è un Gormita del Popolo del Mare, riconoscibile per le sue potenti chele. È un avversario temibile, capace di affrontare qualsiasi avversario in combattimento. 
  La sua spessa e resistente corazza che porta su spalle e busto gli consente non solo un'ottima difesa, ma anche la possibilità di ferire i nemici che entrano a contatto con le spinose conchiglie disseminate 
  lungo la stessa. Queste conchiglie possono ruotare come una trivella, permettendogli di scavare attraverso le rocce più dure dei fondali marini e viaggiare in appositi tunnel. Nel cartone animato, Tenaglia 
  emerge dalle profondità marine per difendere il suo territorio da invasori. In una scena significativa, affronta coraggiosamente un attacco nemico, dimostrando la sua forza e determinazione.
  Scopri di più su {ait}Tenaglia{/ahttps://gormiti.fandom.com/it/wiki/Tenaglia}.", 2008, "gormiti/tenaglia.webp"),
  (3, "Mimeticus", "Giochi Preziosi", "Mimeticus è un Gormita del Popolo della Foresta, maestro del camuffamento. È noto per il suo potente e veloce pugno distruttore e per il flusso di spore asfissianti 
  che rilascia dalla sua schiena. Le spore che emana dalla testa sono magiche: chi le respira perde la memoria. Non puoi vederlo, non puoi sentirlo, riesce a rendersi invisibile con l'arte del mimetismo 
  ed è immobile e silenzioso, un vero predatore. Nel cartone animato, Mimeticus sfrutta le sue abilità mimetiche per tendere imboscate ai nemici nella Foresta Silente. In un episodio memorabile, utilizza 
  le sue spore magiche per far perdere la memoria agli avversari, garantendo la vittoria al suo popolo.
  Scopri di più su {ait}Mimeticus{/ahttps://gormiti.fandom.com/it/wiki/Mimeticus}.", 2008, "gormiti/mimeticus.webp");

INSERT INTO Utente (ruolo, username, nome, cognome, password_hash, email) VALUES
(1, "admin", "John", "Smith", "$2y$10$hR2hqK83R1oK4k2jWfz.NOYwpnV5Laf9ClB9C0xIwKj2sXKHL0WqC", "john.smith@example.com"),
(2, "janedoe", "Jane", "Doe", "$2y$10$vwxyzabcdefghijklmnop", "jane.doe@example.com"),
(2, "user", "User", "Name", "$2y$10$cFX/s3yEaLujSUteGmjlT.MBH.5suXmS667v0o8OVjBxsycCdFPCS", "user.name@example.com"),
(2, "bobloblaw", "Bob", "Loblaw", "$2y$10$mnopqrstuvwxyzabcdefg", "bob.loblaw@example.com");

INSERT INTO Prenotazione (id_utente, data_prenotazione, num_persone, orario) VALUES
(3, "2025-06-15", 7, "15:00"),
(3, "2025-07-20", 3, "12:00"),
(2, "2025-08-05", 1, "16:30"),
(2, "2025-09-12", 4, "10:30"),
(3, "2024-10-01", 2, "13:30");

INSERT INTO Recensione (id_utente, voto, data_recensione, descrizione, tipo) VALUES
(3, 5, "2023-06-18", "Una mostra davvero unica per gli appassionati di Yu-Gi-Oh! Le carte iconiche, come il Drago Bianco Occhi Blu e il Mago Nero, sono esposte in vetrine spettacolari. Perfetta combinazione di nostalgia e scoperta!", 1),
(2, 4, "2023-08-10", "Un'esperienza magica per ogni fan di Pokémon! Le carte sono esposte in modo accattivante, con spiegazioni dettagliate sulla loro storia e rarità. Atmosfera è perfetta per immergersi nel mondo dei Pokémon. Spero di tornare presto magari per una nuova mostra!", 0);
