<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (!isset($_SESSION['user_id'])) 
    header("Location: login.php?redirect=admin.php");
if (!$_SESSION['is_admin']) 
    header('Location: 401.php');

$database = new DatabaseService();
$personalePageAdmin = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$personalePageAdmin) {}
    //TODO

$arrayMostreCorrenti = $database->selectMostreCorrenti();
$arrayMostreFuture = $database->selectMostreFuture();
$arrayMostrePassate = $database->selectMostrePassate();
$arrayMostreMuseo = array_merge($arrayMostreFuture, $arrayMostreCorrenti, $arrayMostrePassate);
$sectionMostreMuseoToAdmin = Templating::getContentBetweenPlaceholders($personalePageAdmin, "mostreAdmin");

$fullcontent = "";
foreach ($arrayMostreMuseo as $associativeRow) {
    $temp = $sectionMostreMuseoToAdmin;
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
    Templating::replaceAnchor($temp, "id_mostra", $associativeRow["id_mostra"]);


    $fullcontent .= $temp . "\n";
}

Templating::replaceContentBetweenPlaceholders($personalePageAdmin, "mostreAdmin", $fullcontent);



Templating::showHtmlPageWithoutPlaceholders($personalePageAdmin);

?>