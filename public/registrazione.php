<?php
require_once "phplibs/templatingService.php";

if (isset($_SESSION['user_id'])) {
    header("Location: index.php?error=logged");
    exit;
}

$registrazioneContent = Templating::getHtmlWithModifiedMenu(__FILE__);

$messaggiPerForm = '';
if (isset($_SESSION['error']) && is_array($_SESSION['error'])) {
    $error = $_SESSION['error'];
    if (in_array('nome_len', $error))
        $messaggiPerForm .= '<li>Il nome deve avere minimo 2 caratteri e massimo 50</li>';
    else if (in_array('nome_char', $error))
        $messaggiPerForm .= '<li>Il nome può contenere solo caratteri alfanumerici o di punteggiatura</li>';
    if (in_array('cognome_len', $error))
        $messaggiPerForm .= '<li>Il cognome deve avere minimo 2 caratteri e massimo 50</li>';
    else if (in_array('cognome_char', $error))  
        $messaggiPerForm .= '<li>Il cognome può contenere solo caratteri alfanumerici o di punteggiatura</li>';
    if (in_array('email_val', $error))
        $messaggiPerForm .= '<li><span lang="en">Email<span> non valida</li>';
    else if (in_array('email_exists', $error))
        $messaggiPerForm .= '<li><span lang="en">Email<span> già in registrata</li>';
    if (in_array('username_len', $error))
        $messaggiPerForm .= '<li>Lo <span lang="en">username<span> deve avere minimo 4 caratteri e massimo 20</li>';
    else if (in_array('username_char', $error))
        $messaggiPerForm .= '<li>Lo <span lang="en">username<span> può contenere solo caratteri alfanumerici</li>';
    else if (in_array('username_exists', $error))
        $messaggiPerForm .= '<li><span lang="en">Username<span> già in uso</li>';
    if (in_array('password_len', $error))
        $messaggiPerForm .= '<li>La <span lang="en">password<span> deve avere almeno 8 caratteri</li>';
    else if (in_array('password_weak', $error))
        $messaggiPerForm .= '<li>La <span lang="en">password<span> deve contenere almeno 
    una lettera, un numero, e un carattere speciale tra @$!%*?&</li>';
    if (in_array('insert', $error))
        $messaggiPerForm .= '<li>Errore durante la registrazione</li>';
    unset($_SESSION['error']);
}

if (strlen($messaggiPerForm) != 0) 
    $messaggiPerForm = '<ul class="form-errors">' . $messaggiPerForm . '</ul>';

$errormsgsToModify = Templating::getContentBetweenPlaceholders($registrazioneContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", $messaggiPerForm);
Templating::replaceContentBetweenPlaceholders($registrazioneContent, "errormsgs", $errormsgsToModify);

$formValuesToModify = Templating::getContentBetweenPlaceholders($registrazioneContent, "form");
Templating::replaceAnchor($formValuesToModify, "nome", $_SESSION['nome'] ?? "");
Templating::replaceAnchor($formValuesToModify, "cognome", $_SESSION['cognome'] ?? "");
Templating::replaceAnchor($formValuesToModify, "username", $_SESSION['username'] ?? "");
Templating::replaceAnchor($formValuesToModify, "email", $_SESSION['email'] ?? "");
Templating::replaceAnchor($formValuesToModify, "password", $_SESSION['password'] ?? "");
Templating::replaceContentBetweenPlaceholders($registrazioneContent, "form", $formValuesToModify);

Templating::showHtmlPageWithoutPlaceholders($registrazioneContent);
unset($_SESSION['nome']);
unset($_SESSION['cognome']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['password']);
?>