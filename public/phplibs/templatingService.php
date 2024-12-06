<?php

#Esplichiamo per bene il processo di templating (con la nostra implementazione) 
// Partendo da una pagina html che suddivide le varie sezioni dinamiche con nomi 
// del tipo <!-- nome_sezione_start --> e <!--nome_sezione_end -->, l'obiettivo è sosituire 
// il codice html all'interno con i dati dinamici prelevati dal db. Tra questi due tag sarà 
// presente il codice html di quella sezione con al posto dei valori dinamici un ancora 
// del tipo {{nome_variabile_da_sostituire}}. Quindi il processo da svolgere in ogni pagina php sarà :
// 1) Interrogare il database con la query per quella pagina, 
// 2)Caricare la pagina html del file dove lavorare 
// 3)caricare la sezione e rimpiazzare le variabili dinamiche con i valori ottenuti dal db
// 4)fare il replacing della vecchiasezione con il nuovo codice html generato 
// 5) mostrare la pagina (rimuovere le ancore)
// Tutte le funzioni saranno public static
session_start();


class Templating{


}

?>