<?php

require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

if (!isset($_SESSION['user_id']))
    header("Location: login.php?redirect=recensisci.php");

$tipo = '';
$data_visita = '';
$rating = '';
$descrizione = '';
$messaggiPerForm = '';

$database = new DatabaseService();

if (isset($_POST['submit'])) {

    $data_visita = DatabaseService::cleanedInput($_POST['data_visita']);
    if (!preg_match("/\d{4}-\d{2}-\d{2}/", $data_visita)) {
        $messaggiPerForm .= "<li>Data non valida</li>";
    }
    $today = date("Y-m-d");
    if ($data_visita > $today) {
        $messaggiPerForm .= "<li>La data non può essere futura</li>";
    }

    $rating = DatabaseService::cleanedInput($_POST['rating']);
    if (!preg_match("/[1-5]/", $rating)) {
        $messaggiPerForm .= "<li>Valutazione non valida</li>";
    }

    $descrizione = DatabaseService::cleanedInput($_POST['descrizione']);
    if (mb_strlen($descrizione, 'UTF-8') < 25) {
        $messaggiPerForm .= '<li>Descrizione troppo corta</li>';
    } else if (!preg_match("/[\p{L}\p{P}\p{N}\ ]+/u", $descrizione)) {
        $messaggiPerForm .= '<li>La descrizione può contenere solo caratteri alfanumerici o di punteggiatura</li>';
    }

    $tipo = DatabaseService::cleanedInput($_POST['tipo']);
    if (!preg_match("/[0-1]/", $tipo)) {
        $messaggiPerForm .= "<li>Tipo non valido</li>";
    } 
    if (strlen($messaggiPerForm) != 0) {
        $messaggiPerForm = '<ul class="form-errors">' . $messaggiPerForm . '</ul>';
        $recensisciContent = Templating::getHtmlWithModifiedMenu("recensisci.php");
        $errormsgsToModify = Templating::getContentBetweenPlaceholders($recensisciContent, "errormsgs");
        Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", $messaggiPerForm);
        Templating::replaceContentBetweenPlaceholders($recensisciContent, "errormsgs", $errormsgsToModify);

        $formValuesToModify = Templating::getContentBetweenPlaceholders($recensisciContent, "form");
        Templating::replaceAnchor($formValuesToModify, "r1", $rating == 1 ? "checked" : "");
        Templating::replaceAnchor($formValuesToModify, "r2", $rating == 2 ? "checked" : "");
        Templating::replaceAnchor($formValuesToModify, "r3", $rating == 3 ? "checked" : "");
        Templating::replaceAnchor($formValuesToModify, "r4", $rating == 4 ? "checked" : "");
        Templating::replaceAnchor($formValuesToModify, "r5", $rating == 5 ? "checked" : "");
        Templating::replaceAnchor($formValuesToModify, "data_visita", $data_visita);
        Templating::replaceAnchor($formValuesToModify, "checkedMuseo", $tipo == 0 ? "checked" : "");
        Templating::replaceAnchor($formValuesToModify, "checkedVirtual", $tipo == 1 ? "checked" : "");
        Templating::replaceAnchor($formValuesToModify,"descrizione", $descrizione);
        Templating::replaceContentBetweenPlaceholders($recensisciContent, "form", $formValuesToModify);

        Templating::showHtmlPageWithoutPlaceholders($recensisciContent);

    } else {
        $insertSuccess = $database->insertUserReview($_SESSION['user_id'], $rating, $data_visita, $descrizione, $tipo);

        if ($insertSuccess)
            header('Location: recensioni.php');
        else
            header('Location: recensisci.php?error=insert');
    }
}
?>