var dettagli_form = { 
    "nome" : ['Ex: Alessandra Rossi', /^[A-Za-z\u00C0-\u024F\ \']{2,}$/, 'Inserire un nome di lunghezza almeno due e non sono ammessi numeri o caratteri speciali'],
    "dataNascita" : ['', /\d{4}\-\d{2}\-\d{2}$/, 'Formato data non corretto'],
    'altezza' : ['Altezza in cm', /^[1-2][0-9][0-9]$/, "Inserire un'altezza in cm senza unita' di misura, e massimo 299 cm"],
    'squadra' : ['Squadra in cui gioca in campionato', /\w{2,}/, 'Inserire un testo di lunghezza almeno 2'],
    'maglia' : ['Numero della maglia', /^\d{1,}$/, 'Inserire un numero di almeno una cifra'],
    'ruolo' : ['Es.: Palleggiatore, Libero, ecc.', /\w{2,}/, 'Inserire un testo di lunghezza almeno 2'],
    'magliaNazionale' : ['', /^\d{1,}$/, 'Inserire un numero di almeno una cifra'],
    'punti' : ['', /^\d{1,}$/, 'Inserire un numero di almeno una cifra'],
    'note' : ["", /.{0,}/, "Nessun controllo"] // Espressione regolare per "tutto accettato"
};


function caricamentoValidazione(){
    inizializzaValidazione(dettagli_form)
}