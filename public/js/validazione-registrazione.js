var dettagli_form = { 
    "nome" : ['', /^[A-Za-z\u00C0-\u024F\ \']{1,}$/, 'Inserire il proprio nome, non sono ammessi numeri o caratteri speciali'],
    "cognome" : ['', /^[A-Za-z\u00C0-\u024F\ \']{1,}$/, 'Inserire il proprio cognome, non sono ammessi numeri o caratteri speciali'],
    "username" : ['', /^[A-Za-z0-9]+$/, 'Scegliere il proprio username, sono ammessi solo lettere e numeri'],
    "email" : ['', /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/ , 'Inserire il proprio indirizzo email nel formato corretto'],
    "password" : ['', /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/, 'Scegliere la propria password, deve essere lunga almeno 8 caratteri' +
        'e deve contenere almeno una lettera, un numero e un carattere speciale'],
};

function caricamentoValidazione(){
    inizializzaValidazione(dettagli_form)
}

