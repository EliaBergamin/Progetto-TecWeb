var dettagli_form = { 
    "nome" : ['','MatchRegex', /^[A-Za-z\u00C0-\u024F\ \']{2,}$/, 'Inserire il proprio nome, non sono ammessi numeri o caratteri speciali'],
    "cognome" : ['','MatchRegex', /^[A-Za-z\u00C0-\u024F\ \']{2,}$/, 'Inserire il proprio cognome, non sono ammessi numeri o caratteri speciali'],
    "username" : ['','MatchRegex', /^[A-Za-z0-9]{4,}$/, 'Scegliere il proprio <span lang="en">username</span>, sono ammessi solo lettere e numeri'],
    "email" : ['','MatchRegex', /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/ , 'Inserire il proprio indirizzo <span lang="en">email</span> nel formato corretto'],
    "password" : ['','MatchRegex', /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/, 'La <span lang="en">password</span> deve essere lunga almeno 8 caratteri' +
        ' e deve contenere almeno una lettera, un numero e un carattere speciale tra @ $ ! % * ? &'],
};


