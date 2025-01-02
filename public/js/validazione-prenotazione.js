var dettagli_form = { 
    "giorno" : ['', 'DataNelFuturo', '', 'La data di prenotazione non può essere nel passato'],
    "visitatori" : ['','RangeVisitatori', '', "Il numero di visitatori deve essere compreso tra 1 e 15"]
};


function caricamentoValidazione(){
    inizializzaValidazione(dettagli_form)
}