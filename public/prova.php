<?php


    require_once("templating.php");
    
    $results = Templating::execQuery("SELECT * FROM mostre");
    //echo json_encode($results);

    $phpContent = "";
   
    // Il codice PHP che vuoi inserire tra i commenti
    foreach ($results as $riga){
        $phpContent .= 
        "<dd>
            <dl>
                <dt class=\"nomeMostra\"> " . $riga["nome"] . "</dt>
                <dd class=\"infoMostra\">
                    <img src=". $riga['URL'] . " alt=".$riga['alt_immagine'].">
                    <p>Descrizione mostra: " . $riga['descrizione'] . "</p>
                    <p class=\"giorniMostra\">Da <time datetime=".$riga['data_inizio'].">" . Templating::formattaDataIta($riga['data_inizio']) . "</time> a <time datetime=".$riga['data_fine']."> " .  Templating::formattaDataIta($riga['data_fine']) ." </time></p>
                    <a href=\"prenotazione.html\" class=\"button\">Prenota visita</a>
                </dd>
            </dl>
        </dd>" . "\n";
    }
    
    Templating::insertTemplateHTML("../html/mostre.php",$phpContent);
    
   
    //../html/mostre.php
    
?>