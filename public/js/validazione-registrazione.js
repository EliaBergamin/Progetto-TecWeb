var dettagli_form = { 
    "nome" : ['','MatchRegex', /^[A-Za-z\u00C0-\u024F\ \']{1,}$/, 'Inserire il proprio nome, non sono ammessi numeri o caratteri speciali'],
    "cognome" : ['','MatchRegex', /^[A-Za-z\u00C0-\u024F\ \']{1,}$/, 'Inserire il proprio cognome, non sono ammessi numeri o caratteri speciali'],
    "username" : ['','MatchRegex', /^[A-Za-z0-9]+$/, 'Scegliere il proprio username, sono ammessi solo lettere e numeri'],
    "email" : ['','MatchRegex', /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/ , 'Inserire il proprio indirizzo email nel formato corretto'],
    "password" : ['','MatchRegex', /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/, 'La password deve essere lunga almeno 8 caratteri' +
        ' e deve contenere almeno una lettera, un numero e un carattere speciale'],
};

function caricamentoValidazione(){
    inizializzaValidazione(dettagli_form)
}

