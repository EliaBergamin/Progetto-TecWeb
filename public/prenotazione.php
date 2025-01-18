<?php
require_once "phplibs/templatingService.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=prenotazione.php");
    exit;
}

$prenotazioneContent = Templating::getHtmlWithModifiedMenu(__FILE__);

$messaggiPerForm = '';
if (isset($_SESSION['error']) && is_array($_SESSION['error'])) {
    $error = $_SESSION['error'];
    if (in_array('data_val', $error))
        $messaggiPerForm .= '<li>Data non valida</li>';
    else if (in_array('data_pass', $error))
        $messaggiPerForm .= '<li>La data non può essere passata</li>';
    if (in_array('orario_val', $error))
        $messaggiPerForm .= '<li>Orario non valido</li>';
    else if (in_array('orario_pass', $error))
        $messaggiPerForm .= '<li>L\'orario non può essere passato</li>';
    if (in_array('visitatori_val', $error))
        $messaggiPerForm .= '<li>Numero di visitatori non valido</li>';
    else if (in_array('visitatori_nd', $error))
        $messaggiPerForm .= '<li>Numero di visitatori non disponibile</li>';
    if (in_array('insert', $error))
        $messaggiPerForm .= '<li>Errore durante la prenotazione. 
            Si rammenta che non è possibile effettuare due prenotazioni per lo stesso giorno</li>';
    unset($_SESSION['error']);
}
if (strlen($messaggiPerForm) != 0)
    $messaggiPerForm = '<ul class="form-errors">' . $messaggiPerForm . '</ul>';

$errormsgsToModify = Templating::getContentBetweenPlaceholders($prenotazioneContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", $messaggiPerForm);
Templating::replaceContentBetweenPlaceholders($prenotazioneContent, "errormsgs", $errormsgsToModify);

$giorno = $_SESSION['giorno'] ?? '';
$orario = $_SESSION['orario'] ?? '';
$visitatori = floatval($_SESSION['visitatori'] ?? '');
$formValuesToModify = Templating::getContentBetweenPlaceholders($prenotazioneContent, "form");
Templating::replaceAnchor($formValuesToModify, "giorno", $giorno);
Templating::replaceAnchor($formValuesToModify, "o1", $orario == '09:00:00' ? 'selected' : '');
Templating::replaceAnchor($formValuesToModify, "o2", $orario == '10:30:00' ? 'selected' : '');
Templating::replaceAnchor($formValuesToModify, "o3", $orario == '12:00:00' ? 'selected' : '');
Templating::replaceAnchor($formValuesToModify, "o4", $orario == '13:30:00' ? 'selected' : '');
Templating::replaceAnchor($formValuesToModify, "o5", $orario == '15:00:00' ? 'selected' : '');
Templating::replaceAnchor($formValuesToModify, "o6", $orario == '16:30:00' ? 'selected' : '');
Templating::replaceAnchor($formValuesToModify, "visitatori", $visitatori);
Templating::replaceContentBetweenPlaceholders($prenotazioneContent, "form", $formValuesToModify);

Templating::showHtmlPageWithoutPlaceholders($prenotazioneContent);

unset($_SESSION['giorno']);
unset($_SESSION['orario']);
unset($_SESSION['visitatori']);
?>