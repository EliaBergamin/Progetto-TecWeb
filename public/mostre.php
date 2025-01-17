<?php
require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

$mostreHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);

/* MOSTRE CORRENTI*/
try {
    $database = new DatabaseService();
    $arrayMostreCorrenti = $database->selectMostreCorrenti();
    $arrayMostreFuture = $database->selectMostreFuture();
    $arrayMostrePassate = $database->selectMostrePassate();
    unset($database);
} catch (Exception $e) {
    unset($database);
    Templating::errCode(500);
}
$sectionCorrentiToModify = Templating::getContentBetweenPlaceholders($mostreHtmlContent, "mostrecorrenti");
$fullcontent = "";
foreach ($arrayMostreCorrenti as $associativeRow) {
    $temp = $sectionCorrentiToModify;
    Templating::replaceAnchor($temp, "id_mostra", $associativeRow["id_mostra"]);
    Templating::replaceAnchor($temp, "nome", $associativeRow["nome"]);
    Templating::replaceAnchor($temp, "descrizione", $associativeRow["descrizione"]);
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
$sectionFutureToModify = Templating::getContentBetweenPlaceholders($mostreHtmlContent, "mostrefuture");

$fullcontent = "";
foreach ($arrayMostreFuture as $associativeRow) {
    $temp = $sectionFutureToModify;
    Templating::replaceAnchor($temp, "id_mostra", $associativeRow["id_mostra"]);
    Templating::replaceAnchor($temp, "nome", $associativeRow["nome"]);
    Templating::replaceAnchor($temp, "descrizione", $associativeRow["descrizione"]);
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
$sectionPassateToModify = Templating::getContentBetweenPlaceholders($mostreHtmlContent, "mostrepassate");
$fullcontent = "";
foreach ($arrayMostrePassate as $associativeRow) {
    $temp = $sectionPassateToModify;
    Templating::replaceAnchor($temp, "id_mostra", $associativeRow["id_mostra"]);
    Templating::replaceAnchor($temp, "nome", $associativeRow["nome"]);
    Templating::replaceAnchor($temp, "descrizione", $associativeRow["descrizione"]);
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