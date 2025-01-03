<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=prenotazione.php");

$database = new DatabaseService();
$profileAreaContentHtml = Templating::getHtmlWithModifiedMenu(__FILE__);

$sectionDatiUtente = Templating::getContentBetweenPlaceholders($profileAreaContentHtml, "datiutente");

$arrayDatiUtente = $database->selectInfoUtenteFromId($_SESSION['user_id']);

Templating::replaceAnchor($sectionDatiUtente, "utente_nome", $arrayDatiUtente[0]["nome"]);
Templating::replaceAnchor($sectionDatiUtente, "utente_cognome", $arrayDatiUtente[0]["cognome"]);
Templating::replaceAnchor($sectionDatiUtente, "utente_username", $arrayDatiUtente[0]["username"]);
Templating::replaceAnchor($sectionDatiUtente, "utente_email", $arrayDatiUtente[0]["email"]);

Templating::replaceContentBetweenPlaceholders($profileAreaContentHtml, "datiutente", $sectionDatiUtente);



$arrayPrenotazioniUtente = $database->selectPrenotazioniFromId($_SESSION['user_id']);

$sectionTablePrenotazioni = Templating::getContentBetweenPlaceholders($profileAreaContentHtml, "rowprenotazione");

$fullcontent = "";
foreach ($arrayPrenotazioniUtente as $associativeRow) {
    $temp = $sectionTablePrenotazioni;

    Templating::replaceAnchor($temp, "data_prenotazione", $associativeRow["data_prenotazione"]);
    Templating::replaceAnchor(
        $temp,
        "string_data_prenotazione",
        Templating::convertDateTimeToString($associativeRow["data_prenotazione"])
    );

    Templating::replaceAnchor($temp, "num_persone", $associativeRow["num_persone"]);
    Templating::replaceAnchor($temp, "orario_prenotazione", $associativeRow["orario"]);


    $fullcontent .= $temp . "\n";
}

Templating::replaceContentBetweenPlaceholders($profileAreaContentHtml, "rowprenotazione", $fullcontent);



Templating::showHtmlPageWithoutPlaceholders($profileAreaContentHtml);

?>