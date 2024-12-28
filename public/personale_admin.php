<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (!isset($_SESSION['user_id']) && $_SESSION['user_role'] != 'admin') 
    header("Location: login.php?redirect=personale_admin.php");

$database = new DatabaseService();
$personalePageAdmin = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$personalePageAdmin) {}
    //TODO

$arrayMostreMuseo = $database->selectMostreCorrenti();
$sectionMostreMuseoToAdmin = Templating::getContentBetweenPlaceholders($personalePageAdmin, "mostreAdmin");

$fullcontent = "";
foreach ($arrayMostreMuseo as $associativeRow) {
    $temp = $sectionMostreMuseoToAdmin;
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

Templating::replaceContentBetweenPlaceholders($personalePageAdmin, "mostreAdmin", $fullcontent);



Templating::showHtmlPageWithoutPlaceholders($personalePageAdmin);

?>