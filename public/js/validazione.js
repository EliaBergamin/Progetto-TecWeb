function inizializzaValidazione(dettagli_form) {
    for (const key in dettagli_form) {
        let input = document.getElementById(key);
        messaggio(input, 0);
        input.onblur = function () { validazioneCampo(this); };
        input.oninput = function () { validazioneForm(); };
    }
    document.getElementById('form').onsubmit = function () { return validazioneForm(); };
    document.querySelector('#form input[type="submit"]').setAttribute('disabled', 'disabled');
}

function caricamentoValidazione(){
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