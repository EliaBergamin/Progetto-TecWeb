<?php
require_once "phplibs/databaseService.php";
require_once "phplibs/templatingService.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=recensisci.php");
    exit;
}

$database = new DatabaseService();
$recensisciContent = Templating::getHtmlWithModifiedMenu(__FILE__);

$messaggiPerForm = '';
if (isset($_SESSION['error']) && is_array($_SESSION['error'])) {
    $error = $_SESSION['error'];
    if (in_array('data_val', $error))
        $messaggiPerForm .= '<li>Data non valida</li>';
    if (in_array('data_fut', $error))
        $messaggiPerForm .= '<li>La data non può essere futura</li>';
    if (in_array('rating', $error))
        $messaggiPerForm .= '<li>Valutazione non valida</li>';
    if (in_array('descr_len', $error))
        $messaggiPerForm .= '<li>Descrizione troppo corta</li>';
    if (in_array('descr_char', $error))
        $messaggiPerForm .= '<li>La descrizione può contenere solo caratteri alfanumerici o di punteggiatura</li>';
    if (in_array('tipo', $error))
        $messaggiPerForm .= '<li>Tipo di visita non valido</li>';
    if (in_array('insert', $error))
        $messaggiPerForm .= '<li>Errore durante l\'inserimento della recensione</li>';
    unset($_SESSION['error']);
}
if (strlen($messaggiPerForm) != 0) 
    $messaggiPerForm = '<ul class="form-errors">' . $messaggiPerForm . '</ul>';

$errormsgsToModify = Templating::getContentBetweenPlaceholders($recensisciContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", $messaggiPerForm);
Templating::replaceContentBetweenPlaceholders($recensisciContent, "errormsgs", $errormsgsToModify);

$rating = $_SESSION['rating'] ?? '';
$data_visita = $_SESSION['data_visita'] ?? '';
$tipo = $_SESSION['tipo'] ?? '';
$descrizione = $_SESSION['descrizione'] ?? '';
$formValuesToModify = Templating::getContentBetweenPlaceholders($recensisciContent, "form");
Templating::replaceAnchor($formValuesToModify, "r1", $rating == 1 ? "checked" : "");
Templating::replaceAnchor($formValuesToModify, "r2", $rating == 2 ? "checked" : "");
Templating::replaceAnchor($formValuesToModify, "r3", $rating == 3 ? "checked" : "");
Templating::replaceAnchor($formValuesToModify, "r4", $rating == 4 ? "checked" : "");
Templating::replaceAnchor($formValuesToModify, "r5", $rating == 5 ? "checked" : "");
Templating::replaceAnchor($formValuesToModify, "data_visita", $data_visita);
Templating::replaceAnchor($formValuesToModify, "checkedMuseo", $tipo == 0 ? "checked" : "");
Templating::replaceAnchor($formValuesToModify, "checkedVirtual", $tipo == 1 ? "checked" : "");
Templating::replaceAnchor($formValuesToModify, "descrizione", $descrizione);
Templating::replaceContentBetweenPlaceholders($recensisciContent, "form", $formValuesToModify);

Templating::showHtmlPageWithoutPlaceholders($recensisciContent);
unset($_SESSION['rating']);
unset($_SESSION['data_visita']);
unset($_SESSION['tipo']);
unset($_SESSION['descrizione']);
?>