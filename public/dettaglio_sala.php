<?php

require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=dettaglio_sala.php");

$database = new DatabaseService();
$dettaglioSalaHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$dettaglioSalaHtmlContent) {}
    //TODO
$numeroSalaRichiesta = isset($_GET['sala']) ? $_GET['sala'] : 0;

/* INFO SALA*/

$infoSalaRow = $database->selectInfoFromSala($numeroSalaRichiesta);
$sectionInfoSalaToModify = Templating::getContentBetweenPlaceholders($dettaglioSalaHtmlContent, "dettagliosala");

Templating::replaceAnchor($sectionInfoSalaToModify, "nome_sala", $infoSalaRow[0]['nome']);
Templating::replaceAnchor($sectionInfoSalaToModify, "descrizione_sala", $infoSalaRow[0]["descrizione"]);

Templating::replaceContentBetweenPlaceholders($dettaglioSalaHtmlContent, "dettagliosala", $sectionInfoSalaToModify);

/* OPERE DYNAMIC */
$arrayOpere = $database->selectOpereFromSala(intval($numeroSalaRichiesta));
$sectionOpereToModify = Templating::getContentBetweenPlaceholders($dettaglioSalaHtmlContent, "opere");

$fullcontent = "";
foreach ($arrayOpere as $associativeRow) {
    $temp = $sectionOpereToModify;
    Templating::replaceAnchor($temp, "nome_opera", $associativeRow["nome"]);
    Templating::replaceAnchor($temp, "descrizione_opera", $associativeRow["descrizione"]);
    Templating::replaceAnchor($temp, "autore_opera", $associativeRow["autore"]);
    Templating::replaceAnchor($temp, "anno_opera", $associativeRow["anno"]);

    $fullcontent .= $temp . "\n";
}

Templating::replaceContentBetweenPlaceholders($dettaglioSalaHtmlContent, "opere", $fullcontent);

Templating::showHtmlPageWithoutPlaceholders($dettaglioSalaHtmlContent);


?>