<?php

require_once("phplibs/databaseService.php");
require_once("phplibs/templatingService.php");

$redirect = $_GET['redirect'] ?? 'index.php';
if (isset($_SESSION['user_id']))
    header("Location: $redirect");

$database = new DatabaseService();
$loginHtmlContent = Templating::getHtmlWithModifiedMenu(__FILE__);
if (!$loginHtmlContent) {
}
//TODO

$messaggiPerForm = '';
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error == 'user')
        $messaggiPerForm .= '<li>Username non esistente</li>';
    else if ($error == 'pwd')
        $messaggiPerForm .= '<li>Password errata</li>';
}

if (strlen($messaggiPerForm) != 0)
    $messaggiPerForm = '<ul class="form-errors">' . $messaggiPerForm . '</ul>';

$errormsgsToModify = Templating::getContentBetweenPlaceholders($loginHtmlContent, "errormsgs");
Templating::replaceAnchor($errormsgsToModify, "messaggiPerForm", $messaggiPerForm);
Templating::replaceContentBetweenPlaceholders($loginHtmlContent, "errormsgs", $errormsgsToModify);

$formToModify = Templating::getContentBetweenPlaceholders($loginHtmlContent, 'form');
Templating::replaceAnchor($formToModify, 'redirect', $redirect);
$username = $_GET['username'] ?? '';
Templating::replaceAnchor($formToModify, 'username', $username);
Templating::replaceContentBetweenPlaceholders($loginHtmlContent, 'form', $formToModify);

Templating::showHtmlPageWithoutPlaceholders($loginHtmlContent);

?>