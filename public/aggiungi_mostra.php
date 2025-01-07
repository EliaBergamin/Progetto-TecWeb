<?php
require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");



if (!isset($_SESSION['user_id']))
    header("Location: login.php?redirect=modifica_mostra.php");

$aggiungiMostraContent = Templating::getHtmlWithModifiedMenu(__FILE__);

$messaggiPerForm = '';
if (isset($_SESSION['error']) && is_array($_SESSION['error'])) {
    $error = $_SESSION['error'];
    if (in_array('nome_len', $error))
        $messaggiPerForm .= '<li>Nome troppo corto</li>';
    if (in_array('nome_char', $error))
        $messaggiPerForm .= '<li>Il nome può contenere solo caratteri alfanumerici o di punteggiatura</li>';
    if (in_array('descr_len', $error))
        $messaggiPerForm .= '<li>Descrizione troppo corta</li>';
    if (in_array('descr_char', $error))
        $messaggiPerForm .= '<li>La descrizione può contenere solo caratteri alfanumerici o di punteggiatura</li>';
    if (in_array('data_ini_val', $error))
        $messaggiPerForm .= "<li>Data d'inizio non valida</li>";
    if (in_array('data_fin_val', $error))
        $messaggiPerForm .= "<li>Data di fine non valida</li>";
    if (in_array('data_ini_fin', $error))
        $messaggiPerForm .= "<li>La data di inizio non può essere successiva alla data di fine</li>";
    if (in_array('immagine', $error))
        $messaggiPerForm .= "<li>Immagine non valida</li>";
    if (in_array('insert', $error))
        $messaggiPerForm .= "<li>Errore durante l'inserimento</li>";
    unset($_SESSION['error']);
}
if (strlen($messaggiPerForm) != 0)
    $messaggiPerForm = '<ul class="form-errors">' . $messaggiPerForm . '</ul>';
$errormsgsToModify = Templating::getContentBetweenPlaceholders($aggiungiMostraContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", $messaggiPerForm);
Templating::replaceContentBetweenPlaceholders($aggiungiMostraContent, "errormsgs", $errormsgsToModify);

$nome = $_SESSION['nome'] ?? '';
$descrizione = $_SESSION['descrizione'] ?? '';
$data_inizio = $_SESSION['data_inizio'] ?? '';
$data_fine = $_SESSION['data_fine'] ?? '';
$immagine = $_SESSION['immagine'] ?? '';
$formValuesToModify = Templating::getContentBetweenPlaceholders($aggiungiMostraContent, "form");
Templating::replaceAnchor($formValuesToModify, "nome", $nome);
Templating::replaceAnchor($formValuesToModify, "descrizione", $descrizione);
Templating::replaceAnchor($formValuesToModify, "data_inizio", $data_inizio);
Templating::replaceAnchor($formValuesToModify, "data_fine", $data_fine);
Templating::replaceAnchor($formValuesToModify, "immagine", $immagine);
Templating::replaceContentBetweenPlaceholders($aggiungiMostraContent, "form", $formValuesToModify);

Templating::showHtmlPageWithoutPlaceholders($aggiungiMostraContent);

unset($_SESSION['nome']);
unset($_SESSION['descrizione']);
unset($_SESSION['data_inizio']);
unset($_SESSION['data_fine']);
unset($_SESSION['immagine']);
?>