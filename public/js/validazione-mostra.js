var dettagli_form = {
    "nome": ['', 'MatchRegex', /^[\p{L}\p{P}\p{N}\s]{2,}$/u, 'Inserire il nome della mostra, non sono ammessi caratteri speciali'],
    "descrizione": ['', 'MatchRegex', /^[\p{L}\p{P}\p{N}\s]{25,}$/u, 'Inserire la descrizione della mostra, almeno 25 caratteri'],
    "data_fine": ['', 'DataFine', '', 'La data di fine mostra non può essere precendente alla data di inizio'],
};
