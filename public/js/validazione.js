function inizializzaValidazione(dettagli_form) {
    for(var key in dettagli_form){
       var input = document.getElementById(key);
       messaggio(input, 0);
       input.onblur = function() {validazioneCampo(this);};
    }
 }
 
function validazioneCampo(input) {		
    
    var nextElement = input.nextElementSibling;
    if (nextElement && (nextElement.classList.contains('default-text') || nextElement.classList.contains('errorSuggestion'))) {
        nextElement.remove();
    }
    if (!regole[dettagli_form[input.id][1]](input.value, dettagli_form[input.id][2])){
        messaggio(input, 1);
        input.focus(); 
        input.select();
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

    var node;

    if(!mode){
        node = document.createElement('span');
        node.className = 'default-text';  
        node.setAttribute('aria-live', 'polite'); 
        node.appendChild(document.createTextNode(dettagli_form[input.id][0]));
    }
    else{
        node = document.createElement('strong');
        node.className = 'errorSuggestion';  
        node.setAttribute('aria-live', 'assertive');
        node.appendChild(document.createTextNode(dettagli_form[input.id][3]));
    }
    
    input.parentNode.insertBefore(node, input.nextSibling);
}