var dettagli_form = {
    "giorno": ['', 'DataNelFuturo', '', 'La data di prenotazione non può essere nel passato'],
    "orario": ['', 'OrarioNelFuturo', '', 'L\'orario di prenotazione non può essere nel passato']
};

function caricamentoValidazioneNumeroVisitatori(numVisitatori) {
    dettagli_form["visitatori"] = ['', 'RangeVisitatori', numVisitatori, "Il numero di visitatori per la data e ora selezionata deve essere compreso tra 1 e " + numVisitatori];
    inizializzaValidazione(dettagli_form);
}