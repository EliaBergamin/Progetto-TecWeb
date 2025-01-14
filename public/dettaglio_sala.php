<?php

require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

$numeroSalaRichiesta = isset($_GET['sala']) ? $_GET['sala'] : Templating::errCode(404);

if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=dettaglio_sala.php?sala=$numeroSalaRichiesta");

$dettaglioSalaHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);

/* BREADCRUMB SALA*/

$sectionBreadcrumbToModify = Templating::getContentBetweenPlaceholders($dettaglioSalaHtmlContent, "numerosalabread");
Templating::replaceAnchor($sectionBreadcrumbToModify,"numero_sala",$numeroSalaRichiesta);
Templating::replaceContentBetweenPlaceholders($dettaglioSalaHtmlContent, "numerosalabread", $sectionBreadcrumbToModify);
/* INFO SALA*/

$database = new DatabaseService();
$infoSalaRow = $database->selectInfoFromSala($numeroSalaRichiesta);
if (count($infoSalaRow) == 0) 
    Templating::errCode(404);
$sectionInfoSalaToModify = Templating::getContentBetweenPlaceholders($dettaglioSalaHtmlContent, "dettagliosala");

Templating::replaceAnchor($sectionInfoSalaToModify, "nome_sala", $infoSalaRow[0]['nome']);
Templating::replaceAnchor($sectionInfoSalaToModify, "descrizione_sala", $infoSalaRow[0]["descrizione"]);

Templating::replaceContentBetweenPlaceholders($dettaglioSalaHtmlContent, "dettagliosala", $sectionInfoSalaToModify);

/* OPERE DYNAMIC */
$arrayOpere = $database->selectOpereFromSala(intval($numeroSalaRichiesta));
unset($database);

$sectionOpereToModify = Templating::getContentBetweenPlaceholders($dettaglioSalaHtmlContent, "opere");
 
$fullcontent = "";
foreach ($arrayOpere as $associativeRow) {
    $temp = $sectionOpereToModify;
    Templating::replaceAnchor($temp, "img_path", $associativeRow["img_path"]);
    Templating::replaceAnchor($temp, "nome_opera", $associativeRow["nome"]);
    $descrizione = $associativeRow["descrizione"];
    if (strlen($descrizione) > 150) {
        $descrizione = substr($descrizione, 0, strrpos(substr($descrizione, 0, 150), ' ')) . "...";
    } //per ottenere i primi 150 caratteri della descrizione senza tagliare l'ultima parola
    Templating::replaceAnchor($temp, "descrizione_opera", $descrizione);
    Templating::replaceAnchor($temp, "autore_opera", $associativeRow["autore"]);
    Templating::replaceAnchor($temp, "anno_opera", $associativeRow["anno"]);
    Templating::replaceAnchor($temp, "numero_sala", $numeroSalaRichiesta);
    Templating::replaceAnchor($temp, "id_opera", $associativeRow["id_opera"]);

    $fullcontent .= $temp . "\n";
}

Templating::replaceContentBetweenPlaceholders($dettaglioSalaHtmlContent, "opere", $fullcontent);

Templating::showHtmlPageWithoutPlaceholders($dettaglioSalaHtmlContent);


?>