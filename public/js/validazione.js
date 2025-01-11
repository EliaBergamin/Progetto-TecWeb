function inizializzaValidazione(dettagli_form) {
    for (const key in dettagli_form) {
        let input = document.getElementById(key);
        messaggio(input, 0);
        input.oninput = function () {
            validazioneCampo(this, 0); console.log('ciao');
        };
        input.onblur = function () { validazioneCampo(this, 1); };
        input.oninput = function () { validazioneForm(); };
    }
    document.getElementById('form').onsubmit = function () { return validazioneForm(); };
    validazioneForm();
}


function caricamentoValidazione() {
    inizializzaValidazione(dettagli_form)
}

function validazioneCampo(input, mode = 1) {
    const nextElement = input.nextElementSibling;
    if (mode && nextElement && (nextElement.classList.contains('default-text') || nextElement.classList.contains('errorSuggestion'))) {
        nextElement.remove();
    }
    if (!regole[dettagli_form[input.id][1]](input.value, dettagli_form[input.id][2])) {
        if (mode) {
            messaggio(input, mode);
            input.focus();
            input.select();
        }
        return false;
    }

    return true;
}

function validazioneForm() {
    for (const key in dettagli_form) {
        const input = document.getElementById(key);
        if (!validazioneCampo(input, 0)) {
            document.querySelector('#form input[type="submit"]').setAttribute('disabled', 'disabled');
            return false;
        }
    }
    document.querySelector('#form input[type="submit"]').removeAttribute('disabled');
    return true;
}

function messaggio(input, mode) {
    /*  mode = 0, modalità input
        mode = 1, modalità errore */

    let node;

    if (!mode) {
        node = document.createElement('span');
        node.className = 'default-text';
        node.setAttribute('aria-live', 'polite');
        node.appendChild(document.createTextNode(dettagli_form[input.id][0]));
    }
    else {
        node = document.createElement('strong');
        node.className = 'errorSuggestion';
        node.setAttribute('aria-live', 'assertive');
        node.innerHTML = dettagli_form[input.id][3];
    }

    input.parentNode.insertBefore(node, input.nextSibling);
}


const checklist = {
    /* check mostra*/
    err_nome_mostra: [
        ['MatchRegex', /^.{2,50}$/, 'Inserire il nome della mostra, minimo 2 caratteri, massimo 50'],
        ['MatchRegex', /^[\p{L}\p{P}\p{N}\s]*$/u, 'Non sono ammessi caratteri speciali']
    ],
    err_descrizione: [
        ['MatchRegex', /^.{25,5000}$/, 'Inserire la descrizione della mostra, minimo 25 caratteri, massimo 5000'],
        ['MatchRegex', /^[\p{L}\p{P}\p{N}\s\n]*$/u, 'Non sono ammessi caratteri speciali']
    ],
    err_data_inizio: [
        /* ['MatchRegex', /^\d{4}-\d{2}-\d{2}$/, 'Inserire una data valida'] */
    ],
    err_data_fine: [
        /* ['MatchRegex', /^\d{4}-\d{2}-\d{2}$/, 'Inserire una data valida'], */
        ['DataFine', '', 'La data di fine mostra non può essere precedente alla data di inizio']
    ],
    err_immagine: [
        ['MatchRegex', /^.*\.(webp|png|jpeg|jpg)$/, 'Caricare un\'immagine in formato <abbr lang="en" title="Portable Network Graphics">PNG</abbr>, <abbr lang="en" title="Joint Photographic Experts Group">JPG/JPEG</abbr> o <abbr lang="en" title="Web Picture">WebP</abbr>'],
        ['DimensioneFile', '', 'L\'immagine non può superare 1.5<abbr lang="en" title="Megabyte">MB</abbr>']
    ],

    /* check recensione*/
    err_data_visita: [
        /* ['MatchRegex', /^\d{4}-\d{2}-\d{2}$/, 'Inserire una data valida'], */
        ['DataNelPassato', '', 'La data della visita non può essere nel futuro']
    ],
    //err_descrizione comune a mostra

    /* check registrazione*/
    err_nome: [
        ['MatchRegex', /^.{2,50}$/, 'Inserire il proprio nome, minimo 2 caratteri, massimo 50'],
        ['MatchRegex', /^[A-Za-z\u00C0-\u024F\ \']*$/, 'Non sono ammessi numeri o caratteri speciali']
    ],
    err_cognome: [
        ['MatchRegex', /^.{2,50}$/, 'Inserire il proprio cognome, minimo 2 caratteri, massimo 50'],
        ['MatchRegex', /^[A-Za-z\u00C0-\u024F\ \']*$/, 'Non sono ammessi numeri o caratteri speciali']
    ],
    err_username: [
        ['MatchRegex', /^.{4,20}$/, 'Scegliere il proprio <span lang="en">username</span>, minimo 4 caratteri, massimo 20'],
        ['MatchRegex', /^[A-Za-z0-9]{4,20}$/, 'Sono ammessi solo lettere non accentate e numeri']
    ],
    err_email: [
        ['MatchRegex', /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/, 'Inserire il proprio indirizzo <span lang="en">email</span> nel formato corretto']
    ],
    err_password: [
        ['MatchRegex', /.{8,}/, 'La <span lang="en">password</span> deve essere lunga almeno 8 caratteri'],
        ['MatchRegex', /^(?=.*[@$!%*?&])(?=.*[a-zA-Z])(?=.*\d).{8,}$/, 'La <span lang="en">password</span> deve contenere almeno almeno una lettera, un numero e un carattere speciale tra @ $ ! % * ? &']
    ],
};

var hasError = false;

function validate(check, rule) {

    const err = document.getElementById(check);
    const input = document.getElementById(err.getAttribute("data-ref-to"));
    const valid = regole[rule[0]](input.value, rule[1]);
    console.log('validate', check, valid, input);

    if (valid) {
        input.removeAttribute("aria-invalid");
        input.removeAttribute("aria-describedby");
        err.removeAttribute("role");
        err.classList.remove("toggleOn");
        err.classList.add("none");
        return true;
    } else {
        input.setAttribute("aria-invalid", "true");
        input.setAttribute("aria-describedby", check);
        //input.focus();
        err.classList.add("toggleOn");
        err.classList.remove("none");
        err.setAttribute("role", "alert");
        err.innerHTML = rule[2];
        hasError = true;
        return false;
    }
}

function validatorCheckAll() {
    for (const check in checklist) {
        const err = document.getElementById(check) || document.getElementById(checklist[check][3]);
        if (err) {
            for (const rule of checklist[check]) {
                if (!validate(check, rule)) {
                    document.getElementById(err.getAttribute('data-ref-to')).focus();
                    return false;
                }
            }
        }
    }
    return true;
}

function validatorLoad() {

    for (const check in checklist) {
        const err = document.getElementById(check);
        if (err) {
            err.classList.add("none");
            const input = document.getElementById(err.getAttribute("data-ref-to"));
            if (!input.getAttribute('type') === 'file')
                input.addEventListener('blur', () => {
                    for (const rule of checklist[check]) {
                        console.log(checklist[check], rule);

                        if (!validate(check, rule))
                            return;
                    }
                });
            else 
                input.addEventListener('change', () => {
                    for (const rule of checklist[check]) {
                        console.log(checklist[check], rule);

                        if (!validate(check, rule))
                            return;
                    }
                });
            input.addEventListener('input', () => {
                if (!err.classList.contains("none") && err.innerHTML != "")
                    for (const rule of checklist[check]) {
                        if (!validate(check, rule))
                            return;
                    }

            });
        }
    }
    const form = document.getElementById("form");
    form && (form.onsubmit = function (e) { return validatorCheckAll(); })
}
