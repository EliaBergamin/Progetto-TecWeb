<?php

require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");


$database = new DatabaseService();
$mostreHtmlContent = Templating::getHtmlFileContent(__FILE__);
if (!$mostreHtmlContent) {}
    //TODO
/* MOSTRE CORRENTI*/
$arrayMostreCorrenti = $database->selectMostreCorrenti();
$sectionCorrentiToModify = Templating::getContentBetweenPlaceholders($mostreHtmlContent, "mostrecorrenti");
$fullcontent = "";
foreach ($arrayMostreCorrenti as $associativeRow) {
    $temp = $sectionCorrentiToModify;
    Templating::replaceAnchor($temp, "nome_mostra", $associativeRow["nome"]);
    Templating::replaceAnchor($temp, "descrizione_mostra", $associativeRow["descrizione"]);
    Templating::replaceAnchor($temp, "data_inizio", $associativeRow["data_inizio"]);
    Templating::replaceAnchor($temp, "data_fine", $associativeRow["data_fine"]);
    Templating::replaceAnchor(
        $temp,
        "string_data_inizio",
        Templating::convertDateTimeToString($associativeRow["data_inizio"])
    );
    Templating::replaceAnchor(
        $temp,
        "string_data_fine",
        Templating::convertDateTimeToString($associativeRow["data_fine"])
    );
    Templating::replaceAnchor($temp, "img_path", $associativeRow["img_path"]);


    $fullcontent .= $temp . "\n";
}

Templating::replaceContentBetweenPlaceholders($mostreHtmlContent, "mostrecorrenti", $fullcontent);


/* MOSTRE FUTURE*/

$arrayMostreFuture = $database->selectMostreFuture();
$sectionFutureToModify = Templating::getContentBetweenPlaceholders($mostreHtmlContent, "mostrefuture");

$fullcontent = "";
foreach ($arrayMostreFuture as $associativeRow) {
    $temp = $sectionFutureToModify;
    Templating::replaceAnchor($temp, "nome_mostra", $associativeRow["nome"]);
    Templating::replaceAnchor($temp, "descrizione_mostra", $associativeRow["descrizione"]);
    Templating::replaceAnchor($temp, "data_inizio", $associativeRow["data_inizio"]);
    Templating::replaceAnchor($temp, "data_fine", $associativeRow["data_fine"]);
    Templating::replaceAnchor(
        $temp,
        "string_data_inizio",
        Templating::convertDateTimeToString($associativeRow["data_inizio"])
    );
    Templating::replaceAnchor(
        $temp,
        "string_data_fine",
        Templating::convertDateTimeToString($associativeRow["data_fine"])
    );
    Templating::replaceAnchor($temp, "img_path", $associativeRow["img_path"]);


    $fullcontent .= $temp . "\n";
}

Templating::replaceContentBetweenPlaceholders($mostreHtmlContent, "mostrefuture", $fullcontent);


/* MOSTRE PASSATE*/
$arrayMostrePassate = $database->selectMostrePassate();
$sectionPassateToModify = Templating::getContentBetweenPlaceholders($mostreHtmlContent, "mostrepassate");

$fullcontent = "";
foreach ($arrayMostrePassate as $associativeRow) {
    $temp = $sectionPassateToModify;
    Templating::replaceAnchor($temp, "nome_mostra", $associativeRow["nome"]);
    Templating::replaceAnchor($temp, "descrizione_mostra", $associativeRow["descrizione"]);
    Templating::replaceAnchor($temp, "data_inizio", $associativeRow["data_inizio"]);
    Templating::replaceAnchor($temp, "data_fine", $associativeRow["data_fine"]);
    Templating::replaceAnchor(
        $temp,
        "string_data_inizio",
        Templating::convertDateTimeToString($associativeRow["data_inizio"])
    );
    Templating::replaceAnchor(
        $temp,
        "string_data_fine",
        Templating::convertDateTimeToString($associativeRow["data_fine"])
    );
    Templating::replaceAnchor($temp, "img_path", $associativeRow["img_path"]);


    $fullcontent .= $temp . "\n";
}

Templating::replaceContentBetweenPlaceholders($mostreHtmlContent, "mostrepassate", $fullcontent);

Templating::showHtmlPageWithoutPlaceholders($mostreHtmlContent);


?>