<?php

require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

if (!isset($_SESSION['user_id']))
    header("Location: login.php?redirect=prenotazione.php");

$giorno = '';
$orario = '';
$visitatori = '';
$messaggiPerForm = '';

$database = new DatabaseService();

if (isset($_POST['submit'])) {

    $giorno = DatabaseService::cleanedInput($_POST['giorno']);
    if (!preg_match("/\d{4}-\d{2}-\d{2}/", $giorno)) {
        $messaggiPerForm .= "<li>Data non valida</li>";
    }
    $today = date("Y-m-d");
    if ($giorno < $today) {
        $messaggiPerForm .= "<li>La data non può essere passata</li>";
    }

    $orario = DatabaseService::cleanedInput($_POST['orario']);
    if (!preg_match("/\d{2}:\d{2}:\d{2}/", $orario)) {
        $messaggiPerForm .= "<li>Orario non valido</li>";
    }
    if ($giorno == $today) {
        $currentTime = date("H:i:s");
        if ($orario <= $currentTime) {
            $messaggiPerForm .= "<li>L'orario non può essere passato</li>";
        }
    }

    $visitatori = DatabaseService::cleanedInput($_POST['visitatori']);
    if (!preg_match("/\d+/", $visitatori) || $visitatori < 1 || $visitatori > 15) {
        $messaggiPerForm .= "<li>Numero di visitatori non valido</li>";
    } elseif (!$database->checkVisitatori($giorno, $orario, $visitatori)) {
        $messaggiPerForm .= "<li>Numero di visitatori non disponibile</li>";
    }

    if (strlen($messaggiPerForm) != 0) {
        $messaggiPerForm = '<ul class="form-errors">' . $messaggiPerForm . '</ul>';
        $prenotazioneContent = Templating::getHtmlWithModifiedMenu("prenotazione.php");
        $errormsgsToModify = Templating::getContentBetweenPlaceholders($prenotazioneContent, "errormsgs");
        Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", $messaggiPerForm);
        Templating::replaceContentBetweenPlaceholders($prenotazioneContent, "errormsgs", $errormsgsToModify);
        $formValuesToModify = Templating::getContentBetweenPlaceholders($prenotazioneContent, "form");
        Templating::replaceAnchor($formValuesToModify, "giorno", $giorno);
        Templating::replaceAnchor($formValuesToModify, "visitatori", $visitatori);
        Templating::replaceContentBetweenPlaceholders($prenotazioneContent, "form", $formValuesToModify);

        Templating::showHtmlPageWithoutPlaceholders($prenotazioneContent);

    } else {
        $insertSuccess = $database->insertPrenotazione($_SESSION['user_id'], $giorno, $visitatori, $orario);
        //TODO redirect alla home page  header("Location: /"); 
        if ($insertSuccess)
            header('Location: profile.php');
        else
            header('Location: prenotazione.php?error=insert');
    }
}
?>