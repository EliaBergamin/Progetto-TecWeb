function inizializzaValidazione(dettagli_form) {
    for(var key in dettagli_form){
       var input = document.getElementById(key);
       messaggio(input, 0);
       input.onblur = function() {validazioneCampo(this);};
    }
 }
 
function validazioneCampo(input) {		
    var regex = dettagli_form[input.id][1];
    var text = input.value;

    // Rimuovo il suggerimento o il messaggio di errore precedente, se esiste
    var nextElement = input.nextElementSibling;
    if (nextElement && (nextElement.classList.contains('default-text') || nextElement.classList.contains('errorSuggestion'))) {
        nextElement.remove();
    }

    if(text.search(regex) != 0){
        messaggio(input, 1);
        input.focus(); // Permette di rimanere sull'input errato
        input.select(); // Seleziona tutto l'input e consente di pulirlo; opzionale, solo se è stato scritto così poco che si fa prima a riscrivere da capo
        return false;
    }

    return true;
}

function validazioneForm() {
    for (var key in dettagli_form){
        var input = document.getElementById(key);
        if(!validazioneCampo(input)){
            return false;
        }
    }
    return true;
}
    
function messaggio(input, mode) {
/*  mode = 0, modalità input
    mode = 1, modalità errore */

    var node; // tag con il messaggio, da aggiungere sotto il campo validato

    if(!mode){
        // Creo messaggio di aiuto
        node = document.createElement('span');
        node.className = 'default-text';  // Nel CSS della prof questa classe fa mettere in azzurro
        node.setAttribute('aria-live', 'polite'); // aria-alert perche' venga letto dallo screen reader
        node.appendChild(document.createTextNode(dettagli_form[input.id][0]));
    }
    else{
        // Creo messaggio di errore
        node = document.createElement('strong');
        node.className = 'errorSuggestion';  // Nel CSS della prof questa classe fa mettere in rosso
        node.setAttribute('aria-live', 'assertive'); // aria-alert perche' venga letto dallo screen reader
        node.appendChild(document.createTextNode(dettagli_form[input.id][2]));
    }
    
    input.parentNode.insertBefore(node, input.nextSibling);
}