<?php

require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

$nome = '';
$descrizione = '';
$data_inizio = '';
$data_fine = '';
$immagine = '';
$messaggiPerForm = '';

if (isset($_POST['submit'])) {

    $nome = DatabaseService::cleanedInput($_POST['nome']);
    if (strlen($nome) < 2) {
        $messaggiPerForm .= '<li>Nome troppo corto</li>';
    } else if (!preg_match("/[\p{L}\p{P}\p{N}\ ]+/u", $nome)) {
        $messaggiPerForm .= '<li>Il nome può contenere solo caratteri alfanumerici o di punteggiatura</li>';
    }

    $descrizione = DatabaseService::cleanedInput($_POST['descrizione']);
    if (strlen($descrizione) < 20) {
        $messaggiPerForm .= '<li>Descrizione troppo corta</li>';
    } else if (!preg_match("/[\p{L}\p{P}\p{N}\ ]+/u", $descrizione)) {
        $messaggiPerForm .= '<li>La descrizione può contenere solo caratteri alfanumerici o di punteggiatura</li>';
    }

    $data_inizio = DatabaseService::cleanedInput($_POST['data_inizio']);
    if (!preg_match("/\d{4}-\d{2}-\d{2}/", $data_inizio)) {
        $messaggiPerForm .= "<li>Data d'inizio non valida</li>";
    }
    $data_fine = DatabaseService::cleanedInput($_POST['data_fine']);
    if (!preg_match("/\d{4}-\d{2}-\d{2}/", $data_fine)) {
        $messaggiPerForm .= "<li>Data di fine non valida</li>";
    }

    if (strtotime($data_inizio) > strtotime($data_fine)) {
        $messaggiPerForm .= "<li>La data di inizio non può essere successiva alla data di fine</li>";
    }
    $immagine = DatabaseService::cleanedInput($_POST["immagine"]);
    // TODO: check and upload image

    if (strlen($messaggiPerForm) != 0) {
        $messaggiPerForm = '<ul class="form-errors">' . $messaggiPerForm . '</ul>';
        $aggiungiMostraContent = Templating::getHtmlWithModifiedMenu("aggiungi_mostra.php");
        $errormsgsToModify = Templating::getContentBetweenPlaceholders($aggiungiMostraContent, "errormsgs");
        Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", $messaggiPerForm);
        Templating::replaceContentBetweenPlaceholders($aggiungiMostraContent, "errormsgs", $errormsgsToModify);
        $formValuesToModify = Templating::getContentBetweenPlaceholders($aggiungiMostraContent, "form");
        Templating::replaceAnchor($formValuesToModify, "nome", $nome);
        Templating::replaceAnchor($formValuesToModify, "descrizione", $descrizione);
        Templating::replaceAnchor($formValuesToModify, "data_inizio", $data_inizio);
        Templating::replaceAnchor($formValuesToModify, "data_fine", $data_fine);
        Templating::replaceContentBetweenPlaceholders($aggiungiMostraContent, "form", $formValuesToModify);

        Templating::showHtmlPageWithoutPlaceholders($aggiungiMostraContent);

    } else {

        $database = new DatabaseService();
        $insertSuccess = $database->insertMostra($nome, $descrizione, $data_inizio, $data_fine, $immagine);
        unset($database);
        if ($insertSuccess)
            header('Location: admin.php');
        else
            header('Location: aggiungi_mostra.php');
    }
} else
    echo 'submit non settato';
    //TODO

?>